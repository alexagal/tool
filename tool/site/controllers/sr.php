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

		
class toolControllersr extends toolController
{
 
        /**
         * get  data
         * @return void
         */
        function getsr()
        { 
		    $parent = JRequest::getVar('id');
            $ids = explode("_", $parent);
            $c=count($ids);
			$idp=($parent == '')?0:$ids[$c-1];
            if ($parent == '') 
			
              $query = 'SELECT id,name, val	FROM sr where id_p=0  order by id ';
			
			else
			  $query = 'SELECT id,name,val from sr where id_p="'.$idp.'" order by id';
					
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
            $fq=mysql_query('select count(id) from sr where id_p="'.$result[$j][0].'";');
			 $f=mysql_fetch_row($fq);
			 if($f[0]>0)
		         {   $return .= "<row id='".$parent.$result[$j][0]."'  xmlkids='1'>\n";
					$return .= "   <cell image='folder.gif'></cell>\n";}
				else
		         {   $return .= "<row id='".$parent.$result[$j][0]."' >\n";
					$return .= "   <cell></cell>\n";}
					$return .= "   <cell>".$result[$j][1]."</cell>\n";
					$return .= "   <cell><![CDATA[".$result[$j][2]."]]></cell>\n";
                
					 $return .= " </row>\n";} 
      
            $return .= "</rows>";

            echo $return;      
         }

        /**
         * save  data
         * @return void
         */
        function setsr()
        {
                 $model = $this->getModel('sr');
 
            $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');                 
// formreader();
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
//$t='r='.$r.'_l_'.$l;
	//	mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.$t.'");');
		mysql_query('update sr set id_p="'.$r0.'" where id="'.$l0.'";');
		
		}
}