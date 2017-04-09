<?php
/**
 * Locations Controller for soro Component
 * 
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
/**
 * soro Locations Controller
 *
 */
class toolControllerklstreet extends toolController
{
 function insstreet()
{
 $return = "";
 
 $fcid = JRequest::getVar('pcid');
 $ftext = JRequest::getVar('ptext');


 $еtt = '';
 $ids1 = explode("_", $fcid);
 

 if ( strlen($ids1[count($ids1)-1])==17 )
 {
  $f_q = mysql_query('select id,code from street where code= substr("'.$ids1[count($ids1)-1].'",1,15);');
  $f_=mysql_fetch_row($f_q);
  if ($f_[0]>0)
     { $еtt = 'Элемент уже есть в справочнике улиц !'; }
   else
    {
	$еtt = 'Элемент добавлен в справочник улиц !';
	 
	$fttext =''; 
    $idst = explode(",", $ftext);
    for ($j=1, $m=count($idst); $j < $m; $j++) 
		{
		 if ($j<>1 )
		    $fttext.= ',';
		 $fttext.= $idst[$j];
        }

  	$f_q = mysql_query('insert into street (code,name) values (substr("'.$ids1[count($ids1)-1].'",1,15),"'.$fttext.'");');
	}
 } 
 else
 { 
  $еtt = 'Добавление на этом уровне невозможно !';
 }
 
 $return .= $еtt;
// $f_q = mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.$return.'");');
 echo $return;
 
 //	$poz = iconv_strpos($ftext, "," ,1,utf8_general_ci); 
//	$pozz = stripos($ftext, "," ); 
//	if ( $pozz===false)
//		 $f_q = mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"false");');

//	$fte = substr_replace ($ftext, "", 1, $pozz); 
//	 $f_q = mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.$ftext.' ");');
//	 $f_q = mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.$pozz.' ");');
//	$pozz = strpos($ftext, ',' ); 
//	 $f_q = mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.$pozz.' ");');
 
 //$tr = substr_count($ftext,',');


 }
 

 function gettree()
	{
     $parent = JRequest::getVar('id');
     $ids = explode("_", $parent);
     //$obl = JURI::base();
	
	 $f_q = mysql_query('select val from sr where name="kodReg";') or die("ошибка БД street: " . mysql_error());
 	 $f_s = mysql_fetch_row($f_q);
	 $kodobl =(is_null($f_s[0]))?42:$f_s[0];


	 if (count($ids)<4) 
	 {

       if ($parent == '') 
	    {
 		$query = 'select code, concat(name," ",socr) as name from kladr_KLADR
                       where right(code,11)="00000000000" and left(code,2)=substr("'.$kodobl.'",1,2) order by name;';
 
        }
		else
		{
 		switch(count($ids))
        {
	     case 1: //районы, города без кода района
       		{

  		    $query = 'select code, concat(name," ",socr) as name from kladr_KLADR
			           where left(code,2)=substr("'.$ids[0].'",1,2) and  right(code,2)="00"
                       and  ( ( substr(code,3,3)!="000" and right(CODE,8)="00000000" )
                       or ( substr(code,6,3)!="000"  and substr(code,3,3)="000" ) ) order by name ;';
                       //where left(code,2)=substr("'.$ids[0].'",1,2) and right(left(CODE,5),3)!="000" and right(CODE,8)="00000000" order by name;';
			break;
			}
	     case 2: //город
       		{
			if ( substr($ids[1],3,3)=="000" )
			{

			 $query = 'select code, concat(name," ",socr) as name from kladr_STREET
                       where left(code,11)=substr("'.$ids[1].'",1,11) and right(code, 2) = "00"
                         order by name;'; 
			}
 	        else
			{

			 $query = 'select code, concat(name," ",socr) as name from kladr_KLADR
                       where left(code,2)=substr("'.$ids[1].'",1,2) and  right(code,2)="00" and 
					   substr(code,3,3)=substr("'.$ids[1].'",3,3) and right(CODE, 8) != "00000000"
                        order by name;'; 
			} 
			break;
			}
	    case 3: //улицы
 	        {

			$query = 'select code, concat(name," ",socr) as name from kladr_STREET
                       where left(code,11)=substr("'.$ids[2].'",1,11) and right(code, 2) = "00"
                         order by name;'; 
               break;       } 
	     default:		 
          echo ("This isn't number or number is > 9 or < 1");
        } 
	
        }
 	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	    $return .= "<tree id='";
		$db =& JFactory::getDBO();
	    if ($parent == '') 
             $return.= '0';
		else
           { $return .= $parent;
            $parent .= '_';}
    
        $return .= "'>\n";
        $db->setQuery( $query );
        $result = $db->loadRowList();
		$f='0F';
		// free
		/*If(JRequest::getVar('id')==''&&count($result)>0&&$result[0][0]>0)
			{$return .= "<item child='1' id='".$parent.$f."' text='Свободные'>\n";
			 $return .= "  </item>\n";} */
        for ($j=0, $m=count($result); $j < $m; $j++) 
		{
		 if ( ( count($ids)==2 and substr($ids[1],3,3)=="000" ) or ( count($ids)==3 ) )
	 	    $return .= "<item child='0' id='".$parent.$result[$j][0]."' text='".$result[$j][1]."'>\n";
	       else
		    $return .= "<item child='1' id='".$parent.$result[$j][0]."' text='".$result[$j][1]."'>\n";

		 /*If(JRequest::getVar('id')=='')
		 { if($result[$j][0]==0)
			$return .= "<item child='1' id='".$parent.$f."' text='Свободные'>\n";
		   else
 	        $return .= "<item child='1' id='".$parent.$result[$j][0]."' text='".$result[$j][1]."'>\n";
				}
 		 else	
			$return .="<item child='1' id='".$parent.$result[$j][0]."' text='".$result[$j][1]."'>\n"; */		 
		 $return .= "  </item>\n";
	    }
	    $return .= "</tree>\n";
	    echo $return;      
 
        }
		else
		{ $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
		$return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	    $return .= "<tree id='";
        $return .= $parent;
        
        $return .= "'>\n";
		$return .= "</tree>\n";
	    echo $return; 
		}
	}


}