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

		
class toolControllerrplan extends toolController
{
 
        /**
         * get  data
         * @return void
         */
        function getrplan()
        { 
		$today = date("d-m-Y");
		$t_mon=date("m");
		$mon = JRequest::getVar('mon',$t_mon);
 
		if ($mon==-2){
		$b_mon= mktime(0, 0, 0, 10,31, date("Y")-1);
		$e_mon=mktime(0, 0, 0, 11,30, date("Y")-1);
		$d1=date('Y-m-d',$b_mon);
		$d2=date('Y-m-d',$e_mon);
		}elseif($mon==-1){
		$b_mon= mktime(0, 0, 0, 11,30, date("Y")-1);
		$e_mon=mktime(0, 0, 0, 12,31, date("Y")-1);
		$d1=date('Y-m-d',$b_mon);
		$d2=date('Y-m-d',$e_mon);
		}else{
		$b_mon= mktime(0, 0, 0, $mon,0, date("Y"));
		if($mon==12)
		$e_mon=mktime(0, 0, 0, 12,31, date("Y"));
		else
		$e_mon=mktime(0, 0, 0,$mon+1,0, date("Y"));
		$d1=date('Y-m-d',$b_mon);
		$d2=date('Y-m-d',$e_mon);
		}
		    $parent = JRequest::getVar('id');
            $ids = explode("_", $parent);
            $c=count($ids);
			$idp=($parent == '')?0:$ids[$c-1];
            if ($parent == '') 
			
              $query = 'SELECT status+0,status,count(*) from plan where status+0>0&&date_n<="'.$d2.'"&&"'.$d1.'"<=date_n   group by (status+0) ORDER BY status';
			
			else
				$query = 'SELECT p.id,date_format(p.date_n,"%d.%m.%y"),p.name,c.short_name,substring_index(pr.name," ",1),p.kol,p.prim FROM plan p,contractors c,pers pr
				where p.status+0="'.$idp.'"&&p.date_n<="'.$d2.'"&&"'.$d1.'"<=p.date_n&&c.id=p.id_c&&p.id_pers=pr.id ';
//mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.addslashes($query).'");');					
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
              if ($parent == '')
		       {     $return .= "<row id='".$parent.$result[$j][0]."'  xmlkids='1'>\n";
					$return .= "   <cell image='folder.gif' style='color:#007f00; font-weight:bold;'></cell>\n";
					$r=$result[$j][1].' ('.$result[$j][2].')';
					$return .= "   <cell style=' font-weight:bold;'>".$r."</cell>\n";
				
					}
			else
				{	 $return .= "  <row id='".$parent.$result[$j][0]."' xmlkids=''>\n";
					$return .= "   <cell >".$result[$j][1]."</cell>\n";		
					$return .= "   <cell>".$result[$j][2]."</cell>\n";
					$return .= "   <cell>".$result[$j][3]."</cell>\n";
					$return .= "   <cell>".$result[$j][4]."</cell>\n";					
					$return .= "   <cell>".$result[$j][5]."</cell>\n";
					$return .= "   <cell>".$result[$j][6]."</cell>\n";
		//			$return .= "   <cell>".$result[$j][7]."</cell>\n";
					}
					 $return .= " </row>\n";} 
			
            $return .= "</rows>";

            echo $return;      
         }

        /**
         * save  data
         * @return void
         */
        function setplan()
        {
                 $model = $this->getModel('plan');
 
            $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');                 
 formreader();
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
        function searchsr()
        { 
		    $name = JRequest::getVar('name');
			$ids = explode("_", $name);
            $c=count($ids); $return='';$t='';
			for($i=0;$i<$c;$i++)
			{
			$fq=mysql_query('select count(*),val from sr where name="'.$ids[$i].'"');
			$f=mysql_fetch_row($fq);
			$return.=$t;
			$return.=($f[0]==0)?'нет':$f[1];
			$t='_';
			}
			echo $return;
		}
			// периоды
        function gmon()
        { $db =& JFactory::getDBO();
 	     $doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
         $n_mon= date("m");
		 $arr=array('-2'=>'ноябрь пр.г.','-1' => 'декабрь пр.г.',
		 '1' => 'январь','2' => 'февраль','3' =>'март','4' => 'апрель','5' => 'май','6' =>'июнь','7' => 'июль','8' => 'август','9' =>'сентябрь','10' => 'октябрь','11' => 'ноябрь','12' => 'декабрь'
			 );
	     $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
            $return .= "<complete>\n";
		foreach($arr as $field=>$v) {
			if ($field==$n_mon)
            $return .= " <option value=\"".$field."\" selected=\"1\" >".$v."</option>\n";
			else
			 $return .= " <option value=\"".$field."\">".$v."</option>\n";	}
            $return .= "</complete>\n";
 //mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.$return.'");');
            echo $return;
         }
		// clients combo
		function clients()
		{
            $db =& JFactory::getDBO();
            $query = "SELECT id,short_name FROM contractors; ";

	     $doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');

	     $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
            $return .= "<complete>\n";
            $db->setQuery( $query );
            $result = $db->loadRowList();
            for ($j=0, $m=count($result); $j < $m; $j++) {
                $return .= " <option value=\"".$result[$j][0]."\">".$result[$j][1]."</option>\n";
            }
            $return .= "</complete>\n";

	      echo $return;
		} 
				// pers combo
		function pers()
		{
            $db =& JFactory::getDBO();
            $query = "SELECT id,substring_index(name,' ',1) FROM pers; ";

	     $doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');

	     $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
            $return .= "<complete>\n";
            $db->setQuery( $query );
            $result = $db->loadRowList();
            for ($j=0, $m=count($result); $j < $m; $j++) {
                $return .= " <option value=\"".$result[$j][0]."\">".$result[$j][1]."</option>\n";
            }
            $return .= "</complete>\n";

	      echo $return;
		  }
						// status combo
		function status()
		{
            $db =& JFactory::getDBO();
         // enum

	     $doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');

	     $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
            $return .= "<complete>\n";
			$sql="DESCRIBE plan status";
		$result=mysql_query($sql) or die(mysql_error());
		$records=mysql_num_rows($result);
		if($records){
		@$enum_ar=mysql_fetch_assoc($result);// получить запись в массив
		eval('$ar='.str_replace('enum','array',$enum_ar['Type']).';');
		}
		mysql_free_result($result);
		for ($i=0,$m=count($ar); $i < $m; $i++)
		{ 
 		$return .= " <option value=\"".$ar[$i]."\">".$ar[$i]."</option>\n" ;
		}
         
            $return .= "</complete>\n";

	      echo $return;
			}
}