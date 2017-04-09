<?php
/**
 * Controller for  Component
 * 
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
  function formreader()
{
 $a='reader_';

 foreach($_REQUEST as $field=>$value)
 {$a.=$field.' = '.$value.'__';}
 mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.$a.'");');
} 
/**
 *   Controller
 *
 */
		
class toolControllersq extends toolController
{
 
        /**
         * get  data
         * @return void
         */
        function getsq()
        { 
		    $parent = JRequest::getVar('id');
            $ids = explode("_", $parent);
            $c=count($ids);
			$idp=($parent == '')?0:$ids[$c-1];
            if ($parent == '') 
			
              $query = 'SELECT * FROM sq where id_p=0   ORDER BY id';
			
			else
			  $query = 'SELECT * from sq where id_p="'.$idp.'"   ORDER BY id';
					
	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
 
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
		$return .= "<rows parent='";
		 $db =& JFactory::getDBO();
	    if ($parent == '') {
              $return .= '0';
            } else {
              $return .= $parent;
              $parent .= '_';
            }
            $return .= "'>\n";
 
            $db->setQuery( $query );
            $result = $db->loadRowList();
            for ($j=0, $m=count($result); $j < $m; $j++) {
            $fq=mysql_query('select count(id) from sq where id_p="'.$result[$j][0].'";');
			 $f=mysql_fetch_row($fq);
			 if($f[0]>0)
		         {   $return .= "<row id='".$parent.$result[$j][0]."'  xmlkids='1'>\n";
					$return .= "   <cell image='folder.gif'></cell>\n";}
				else
		         {   $return .= "<row id='".$parent.$result[$j][0]."' >\n";
					$return .= "   <cell></cell>\n";}
					$return .= "   <cell>".$result[$j][1]."</cell>\n";
					$return .= "   <cell><![CDATA[".$result[$j][2]."]]></cell>\n";
 					$return .= "   <cell><![CDATA[".$result[$j][3]."]]></cell>\n";                  
					 $return .= " </row>\n";} 
      
            $return .= "</rows>";

            echo $return;      
         }

        /**
         * save  data
         * @return void
         */
        function setsq()
        {
                 $model = $this->getModel('sq');
 
            $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');                 
 //formreader();
            $id = JRequest::getVar('ids', '0', 'post', 'string');
            $nativeeditor_status = JRequest::getVar($id.'_!nativeeditor_status', '', 'post', 'string');
 
            if ($nativeeditor_status == 'updated')
            {
                    $m_id = $model->storeData();
					
                           if ($m_id == 0) 
                    {
                        $msg = JText::_( 'Error Saving Greeting' );
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
                    } else {
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
                               $return .= "<data>"; 
                           $return .= "<action type='update' sid='".$id."' tid='".$m_id."'/>";
                           $return .= "</data>"; 
                       }
            }
 
            if ($nativeeditor_status == 'deleted')
            {
                    $m_id = $model->deleteData();
                    if($m_id == 0) 
                    {
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
                     } else {
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
                             $return .= "<data>"; 
                          $return .= "<action type='delete' sid='".$id."' tid='".$m_id."'/>";
                         $return .= "</data>"; 
                     }
            }
 
            if ($nativeeditor_status == 'inserted')
            {
                    $m_id = $model->newData();
                           if ($m_id == 0) 
                    {
                        $msg = JText::_( 'Error Inserting Record' );
                        echo "<script>alert('Error Inserting Record (".$new_id.")')</script>";
                    } else {
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
                               $return .= "<data>"; 
                           $return .= "<action type='insert' sid='".$id."' tid='".$m_id."'/>";
                           $return .= "</data>"; 
                       }
            }
 
            echo $return;      
        }
 /**
         * search  data
         * @return void
         */
        function searchsq()
        { 
		    $name = JRequest::getVar('name');
			$ids = explode("_", $name);
            $c=count($ids); $return='';$t='';
			for($i=0;$i<$c;$i++)
			{
			$fq=mysql_query('select count(*),val from sq where name="'.$ids[$i].'"');
			$f=mysql_fetch_row($fq);
			$return.=$t;
			$return.=($f[0]==0)?'нет':$f[1];
			$t='_';
			}
			echo $return;
		}

		/**
         * move  data
         * @return void
         */
        function move()
        {
		$l = JRequest::getVar('r1',"");
		$r = JRequest::getVar('r2','');

        $ids = explode("_", $l);
		$c=count($ids)-1; 
		$l0=$ids[$c];
		$ids = explode("_", $r);
		$c=count($ids)-1; 
		$r0=$ids[$c];

		mysql_query('update sq set id_p="'.$r0.'" where id="'.$l0.'";');
		
		}
      /**
         * exec sql script
		 * @return void
         */
        function sqex()
        { 
		    $id = JRequest::getVar('sq',0);	
/*	 mysql_errno() . ": " . mysql_error()		
     mysql_escape_string ( string unescaped_string )
int mysql_affected_rows() возвращает количество рядов, затронутых последним INSERT, UPDATE, DELETE запросом

 Свойства объекта:

    name - название колонки

    table - название таблицы, которой принадлежит колонка

    max_length - максимальная длинна содержания

    not_null - 1, если колонка не может быть равна NULL

    primary_key - 1, если колонка -- первичный индекс

    unique_key - 1, если колона -- уникальный индекс

    multiple_key - 1, если колонка -- не уникальный индекс

    numeric - 1, если колонка численная

    blob - 1, если колонка -- BLOB

    type - тип колонки

    unsigned - 1, если колонка строго положительная (unsigned)

    zerofill - 1, если колонка заполняется нулями (zero-filled) 

    Замечание: Имена полей, возвращаемые этой функцией, регистро-зависимы.
	
$result = mysql_query("select * from table")
    or die("Query failed: " . mysql_error());
 получаем данные о колонке 
$i = 0;
while ($i < mysql_num_fields($result)) {
    echo "Information for column $i:<br />\n";
    $meta = mysql_fetch_field($result, $i);
    if (!$meta) {
        echo "No information available<br />\n";
    }
    echo "<pre>
blob:         $meta->blob
max_length:   $meta->max_length
multiple_key: $meta->multiple_key
name:         $meta->name
not_null:     $meta->not_null
numeric:      $meta->numeric
primary_key:  $meta->primary_key
table:        $meta->table
type:         $meta->type
unique_key:   $meta->unique_key
unsigned:     $meta->unsigned
zerofill:     $meta->zerofill
</pre>";
    $i++;
}
mysql_free_result($result);
*/
    $result = mysql_query('select val,param	FROM sq where id='.$id);
	$f=mysql_fetch_row($result);
	$query=trim($f[0]);
	if($f[1]>""&&is_int(strpos($query,'$')))
	{$a=explode(";",$f[1]);
	for ($j=0, $m=count($a); $j < $m; $j++) 
	$s[]='$'.$j;
	 
	$query= str_replace($s,$a,$query);
	}
	$result = mysql_query($query);
	if($result===false)
    { $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
    $return .= "<rows>\n";

	$return .= "<head>\n";
	
	$return .= "<column type=\"ro\" width=\"*\" align=\"left\" sort=\"str\">Код : описание ошибки</column>\n";	
		$return .= "</head>\n";
		$return .= "<row id='1' >\n";
		$return .= "   <cell><![CDATA[".$query."]]></cell>\n";
		$return .= " </row>\n" ; 
		$return .="<row id='2' >\n";
		$return .= "   <cell style='color:red;'>". mysql_errno() . ": " . mysql_error()."</cell>\n";
		$return .= " </row>\n" ; 
            $return .= "</rows>";

            echo $return;  
    	return false;		
	}	
	$ar=array('insert','update','delete','replace');	
	$nr=array('select','show','explain','describe');
	$n=strpos($query," ");
	$s=$query;
	if(is_int($n))
	$s=substr($query,0,$n);
	$s=strtolower($s);
	if(in_array($s,$ar)) // insert... 
	{$doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
    $return .= "<rows>\n";

	$return .= "<head>\n";
	$return .= "<column type=\"ro\" width=\"100\" align=\"left\" sort=\"str\">Тип</column>\n";	
	$return .= "<column type=\"ro\" width=\"*\" align=\"left\" sort=\"str\">Результат</column>\n";	
		$return .= "</head>\n";
		$return .= "<row id='1' >\n";
		$return .= "   <cell>Запрос</cell>\n";
		$return .= "   <cell><![CDATA[".$query."]]></cell>\n";
		$return .= " </row>\n" ; 
		$return .="<row id='2' >\n";
		$return .= "   <cell>Строк изменено:</cell>\n";		
		$return .= "   <cell style='font-weight:bold;'>". mysql_affected_rows() ."</cell>\n";
		$return .= " </row>\n" ; 
            $return .= "</rows>";

            echo $return;  
    	return true;
	}
	if(in_array($s,$nr)) // select... 
	{$doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
    $return .= "<rows>\n";
    if(mysql_num_rows($result)==0)
	{$return .= "<head>\n";
	$return .= "<column type=\"ro\" width=\"100\" align=\"left\" sort=\"str\">Тип</column>\n";	
	$return .= "<column type=\"ro\" width=\"*\" align=\"left\" sort=\"str\">Результат</column>\n";	
		$return .= "</head>\n";
		$return .= "<row id='1' >\n";
		$return .= "   <cell>Запрос</cell>\n";
		$return .= "   <cell><![CDATA[".$query."]]></cell>\n";
		$return .= " </row>\n" ; 
		$return .="<row id='2' >\n";
		$return .= "   <cell>Строк выбрано:</cell>\n";		
		$return .= "   <cell style='font-weight:bold;'>0</cell>\n";
		$return .= " </row>\n" ; 
            $return .= "</rows>";

            echo $return;  
    	return true;
	}
	$return .= "<head>\n";
	$return .= "<column type=\"ro\" width=\"40\" align=\"right\" sort=\"str\">№</column>\n";	
	$i = 0;$c=mysql_num_fields($result);
	while ($i < $c) {

    $meta = mysql_fetch_field($result, $i);
    if (!$meta) {
      $return .= "<column type=\"ro\" width=\"40\" align=\"left\" sort=\"str\">не опознан</column>\n";	
    }
	$a='left';
	if($meta->numeric)
	{$a='right';
	$l=45;
	}
	else
	$l=($meta->max_length<20)?$meta->max_length*7:$meta->max_length*6;
	$l=($l<50)?50:$l;
    $return .= "<column type=\"ro\" width=\"".$l."\" align=\"".$a."\" sort=\"str\">".$meta->name."</column>\n";	
    $i++;
	}
     $i=1;
		$return .= "</head>\n";
		while ($f=mysql_fetch_row($result))
		{
		$return .= "<row id='".$i."' >\n";
		$return .= "   <cell>".$i."</cell>\n";
		for($j=0;$j<$c;$j++)
		{$return .= "   <cell><![CDATA[".$f[$j]."]]></cell>\n";
		}
		$i++;
		$return .= " </row>\n" ;
		}
            $return .= "</rows>";

            echo $return;  
    	return true;
	}
	// other
	$doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
    $return .= "<rows>\n";

	$return .= "<head>\n";
	
	$return .= "<column type=\"ro\" width=\"100\" align=\"left\" sort=\"str\">Тип</column>\n";	
	$return .= "<column type=\"ro\" width=\"*\" align=\"left\" sort=\"str\">Результат</column>\n";	
		$return .= "</head>\n";
		$return .= "<row id='1' >\n";
		$return .= "   <cell>Запрос</cell>\n";
		$return .= "   <cell><![CDATA[".$query."]]></cell>\n";
		$return .= " </row>\n" ; 
		$return .="<row id='2' >\n";
		$return .= "   <cell>Исполнение:</cell>\n";	
	if($result==false)	
		$return .= "   <cell style='font-weight:bold;'>НЕ ИСПОЛНЕН</cell>\n";
	else
		$return .= "   <cell style='font-weight:bold;'>ИСПОЛНЕН</cell>\n";	
		$return .= " </row>\n" ; 
            $return .= "</rows>";

            echo $return;      
         }
    /**
         * exec sql script grup
		 * @return void
         */
        function sqexg()
        { 
		    $id = JRequest::getVar('sq',0);	
	$doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
    $return .= "<rows>\n";

	$return .= "<head>\n";
	
	$return .= "<column type=\"ro\" width=\"200\" align=\"left\" sort=\"str\">Тип</column>\n";		
	$return .= "<column type=\"ro\" width=\"*\" align=\"left\" sort=\"str\">Результат</column>\n";	
		$return .= "</head>\n";	
	$num=1;	
	$ar=array('insert','update','delete','replace');	
	$nr=array('select','show','explain','describe');
    $ressq = mysql_query('select val,param,name	FROM sq where val>""&&(id="'.$id.'" or id_p="'.$id.'") ;');
	while ($f=mysql_fetch_row($ressq))
	{$query=trim($f[0]);$ss=array();
		if($f[1]>""&&is_int(strpos($query,'$')))
		{$a=explode(";",$f[1]);
		for ($j=0, $m=count($a); $j < $m; $j++) 
		$ss[]='$'.$j;
	 
		$query= str_replace($ss,$a,$query);
		}
		$result = mysql_query($query);
	if($result===false)
    {   $return .= "<row id='".$num."' >\n";
		$num++;
		$return .= "   <cell><![CDATA[".$f[2]."]]></cell>\n";		
		$return .= "   <cell><![CDATA[".$query."]]></cell>\n";
		$return .= " </row>\n" ; 
		$return .= "<row id='".$num."' >\n";
		$num++;
		$return .= "   <cell style='color:red;'>Код ошибки:</cell>\n";	
		$return .= "   <cell style='font-weight:bold;'>". mysql_errno() . ": " . mysql_error()."</cell>\n";
		$return .= " </row>\n" ; 
		continue;
	}
	$n=strpos($query," ");
	$s=$query;
	if(is_int($n))
	$s=substr($query,0,$n);
	$s=strtolower($s);
	if(in_array($s,$ar)) // insert... 
	{	$return .= "<row id='".$num."' >\n";
		$num++;
		$return .= "   <cell><![CDATA[".$f[2]."]]></cell>\n";		
		$return .= "   <cell><![CDATA[".$query."]]></cell>\n";
		$return .= " </row>\n" ; 
		$return .= "<row id='".$num."' >\n";
		$num++;
		$return .= "   <cell>Строк изменено:</cell>\n";		
		$return .= "   <cell style='font-weight:bold;'>". mysql_affected_rows() ."</cell>\n";
		$return .= " </row>\n" ; 
		continue;
	}
	if(in_array($s,$nr)) // select... 
	{	$return .= "<row id='".$num."' >\n";
		$num++;
		$return .= "   <cell><![CDATA[".$f[2]."]]></cell>\n";		
		$return .= "   <cell><![CDATA[".$query."]]></cell>\n";
		$return .= " </row>\n" ; 
		$return .= "<row id='".$num."' >\n";
		$num++;
		$return .= "   <cell>Строк выбрано:</cell>\n";		
		$return .= "   <cell style='font-weight:bold;'>". mysql_num_rows($result) ."</cell>\n";
		$return .= " </row>\n" ; 
		continue;
	}
	// прочее... 
		$return .= "<row id='".$num."' >\n";
		$num++;
		$return .= "   <cell><![CDATA[".$f[2]."]]></cell>\n";		
		$return .= "   <cell><![CDATA[".$query."]]></cell>\n";
		$return .= " </row>\n" ; 
		$return .= "<row id='".$num."' >\n";
		$num++;
		$return .= "   <cell>Исполнение:</cell>\n";	
	if($result==false)	
		$return .= "   <cell style='font-weight:bold;'>НЕ ИСПОЛНЕН</cell>\n";
	else
		$return .= "   <cell style='font-weight:bold;'>ИСПОЛНЕН</cell>\n";
		$return .= " </row>\n" ; 

	}
		$return .= "</rows>";

        echo $return;      
         
		}
	    /**
         * exec function
		 * @return void
         */
        function sqfun()
        { 
		    $idm = JRequest::getVar('idm',0);
         if($idm==1) // обработка договоров таблица d_v  dogu - delete , dogv - восстановление до 31.12.16
        {
		$f_q=mysql_query('select dogu,dogv from d_v');
		while($f=mysql_fetch_row($f_q))
		{ mysql_query('delete from dogovor where id="'.$f[0].'"');
		
		}
         }
		 echo '';
		 return true;
		 
		}	
	 // usertype
	function usertype()
	{$user =& JFactory:: getUser();
		echo $user->usertype;
	}
}