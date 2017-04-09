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
class toolControllerpers extends toolController
{
 
        /**
         * get  data
         * @return void
         */
        function getpers()
        { 
        	  
		  
            $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
            $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
            $return .= "<rows>\n";
	    $return .= "<head>\n";

	    $return .= "<column type=\"ed\" width=\"200\" align=\"left\" filter=\"true\" sort=\"str\" >ФИО</column>\n";

		$return .= "<column type=\"combo\" width=\"100\" align=\"left\"  sort=\"str\" xmlcontent=\"1\">Компания\n";		
	$f_q = mysql_query('select id,short_name	from company;') or die("ошибка БД company: ". mysql_error());
	        while ($f_s = mysql_fetch_row($f_q))
	    	$return .= " <option value=\"".$f_s[0]."\">".$f_s[1]."</option>\n" ;
	$return .= "</column>\n";
		
		$return .= "<column type=\"combo\" width=\"140\" align=\"left\" sort=\"str\" xmlcontent=\"1\">Должность\n";
	$f_q = mysql_query('select id,name	from jobs;') or die("ошибка БД jobs: ". mysql_error());
	        while ($f_s = mysql_fetch_row($f_q))
	    	$return .= " <option value=\"".$f_s[0]."\">".$f_s[1]."</option>\n" ;
	$return .= "</column>\n";	
	
		$return .= "<column type=\"txt\" width=\"100\" align=\"left\" sort=\"str\">Инф.для связи</column>\n";

	//	$return .= "<column type=\"dhxCalendar\" width=\"90\" align=\"left\" sort=\"str\">Дата рожд.</column>\n";
	$return .= "<column type=\"ed\" width=\"90\" align=\"left\" sort=\"str\">Дата рожд.</column>\n";
		$return .= "<column type=\"ed\" width=\"*\" align=\"left\" sort=\"str\">Прим.</column>\n";



	    $return .= "</head>\n";

		$f_q = mysql_query('SELECT id,name,id_c,id_job,infolink,date_format(d_r,"%d.%m.%Y"),prim FROM pers;') or die("ошибка БД pers: " . mysql_error());
        while ($f_s = mysql_fetch_row($f_q))
	    {
                    $return .= " <row id=\"".$f_s[0]."\">\n";
                    $return .= "  <cell>".$f_s[1]."</cell>\n";
                    $return .= "  <cell>".$f_s[2]."</cell>\n";
                    $return .= "  <cell>".$f_s[3]."</cell>\n";
                    $return .= "  <cell>".$f_s[4]."</cell>\n";
                    $return .= "  <cell>".$f_s[5]."</cell>\n";
                    $return .= "  <cell>".$f_s[6]."</cell>\n";
			
					$return .= " </row>\n";
            }

	
//$f_q = mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"jk");') or die("ошибка БД locations: " . mysql_error());
            $return .= "</rows>";
 
            echo $return;      
         }
 
        /**
         * save  data
         * @return void
         */
        function setpers()
        {
                 $model = $this->getModel('pers');
 
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
 
} 