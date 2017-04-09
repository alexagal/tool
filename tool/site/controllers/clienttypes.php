<?php

 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
/**
 *  Clienttypes Controller
 *
 */
class toolControllerClienttypes extends toolController
{

	/**
         * get Clienttypes data
         * @return void
         */
        function getClienttypes()
        { 
	    $model = $this->getModel('Clienttypes');
	    $items = $model->getData();

	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	    $return .= "<rows>\n";


	    for ($i=0, $n=count( $items ); $i < $n; $i++)
	    {
                    $row =& $items[$i];
                    $return .= " <row id=\"".$row->id."\">\n";
                    $return .= "  <cell>".$row->short."</cell>\n";
                    $return .= "  <cell>".$row->name."</cell>\n";
                    $return .= " </row>\n";
            }
	    $return .= "</rows>";
	    echo $return;      
	 }

	/**
	 * save Clienttypes data
	 * @return void
	 */
	function setClienttypes()
	{
     	    $model = $this->getModel('Clienttypes');

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