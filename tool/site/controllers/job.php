<?php
/**
 *  Controller for  Component
 * 
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
/**
 *  Controller
 *
 */
class toolControllerjob extends toolController
{
 
        /**
         * get  data
         * @return void
         */
        function getjob()
        { 
        	  
		  
            $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
            $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
            $return .= "<rows>\n";


		$f_q = mysql_query('SELECT * FROM jobs;') or die("ошибка БД jobs: " . mysql_error());
        while ($f_s = mysql_fetch_row($f_q))
	    {
                    $return .= " <row id=\"".$f_s[0]."\">\n";
				    $return .= "  <cell>".$f_s[0]."</cell>\n";
                    $return .= "  <cell>".$f_s[1]."</cell>\n";
                   
                    $return .= " </row>\n";
            }
	
            $return .= "</rows>";
 
            echo $return;      
         }

        /**
         * save  data
         * @return void
         */
        function setjob()
        {
                 $model = $this->getModel('job');
 
            $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');                 
 
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
		// ispjob combo
		function ispjob()
		{
		$name=JRequest::getVar('name','менеджер');
		$query='select id,count(*) FROM jobs WHERE name="'.$name.'";';
		$f_q = mysql_query($query) or die("ошибка БД jobs: " . mysql_error());
		$f_s = mysql_fetch_row($f_q);
		if($f_s[1]>0)
		 $value=$f_s[0];
		 else
		 $value=0;
        $db =& JFactory::getDBO();
		$doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
        $return .= "<complete>\n";
		 if($value==0)
		 { $return .= "</complete>\n";
	      echo $return;
		  return false;
		 }
	    $query='select id,name FROM ispolnitel WHERE id_job="'.$value.'";';	
            $db->setQuery( $query );
            $result = $db->loadRowList();
            for ($j=0, $m=count($result); $j < $m; $j++) {
                $return .= " <option value=\"".$result[$j][0]."\">".$result[$j][1]."</option>\n";
            }
            $return .= "</complete>\n";

	      echo $return;
		} 		
 
} 