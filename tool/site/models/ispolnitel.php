<?php
/**
 * ispolnitel Model for soro Component
 * 
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.model' );
 
/**
 * ispolnitel Model
 *
 */
class jkhModelispolnitel extends JModel
{
    var $_data;
 
    function _buildQuery()
    {
        $query = 'SELECT * FROM ispolnitel';
        return $query;
    }
 
    function getData()
    {
        // Lets load the data if it doesn't already exist
        if (empty( $this->_data ))
        {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList( $query );
        }
 
        return $this->_data;
    }

    function storeData()
    {
	    $row =& $this->getTable();
	    $id = JRequest::getVar('ids', '0', 'post', 'integer');
		
	    $arr = array('id'=>$id,
         'name' => JRequest::getVar($id.'_c0', '0','post', 'string'),
		 'id_job' => JRequest::getVar($id.'_c1', '0','post', 'string'),
		 'type_i' => JRequest::getVar($id.'_c2', '','post', 'string')
		 );

	    // Bind to the  table
	    if (!$row->bind($arr)) {
	        $this->setError($this->_db->getErrorMsg());
	        return 0;
	    }
 
	    // Make sure the record is valid
	    if (!$row->check()) {
	        $this->setError($this->_db->getErrorMsg());
	        return 0;
	    }
 
	    // Store the table to the database
	    if (!$row->store()) {
	        $this->setError($this->_db->getErrorMsg());
	        return 0;
	    }
	 
	    return $row->id;

    }
   function deleteData()
   {
         $id = JRequest::getVar('ids', '0');
        $row =& $this->getTable();
 
        if (!$row->delete( $id )) {
             $this->setError( $row->getErrorMsg() );
             return 0;
        }
 
        return $id;
   }
 
 
    function newData()
    {
            $row =& $this->getTable();
 
            $arr = array('id' => '0',
			            'name' =>'',

			            'type_i' =>'Специалисты компании'
						 );
 
            // Bind to the  table
            if (!$row->bind($arr)) {
                $this->setError($this->_db->getErrorMsg());
                return 0;
            }
 
            // Make sure the  record is valid
            if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());
                return 0;
            }
 
             // Store table to the database
            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
                return 0;
            }
         
            return $row->id;
    }
}	
