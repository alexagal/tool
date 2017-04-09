<?php
/**
 *  Model for  Component
 * 
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.model' );
 
/**
 *  Model
 *
 */
class toolModelpers extends JModel
{
    /**
     *  data array
     *
     * @var array
     */
    var $_data;
 
    /**
     * Returns the query
     * @return string The query to be used to retrieve the rows from the database
     */
    function _buildQuery()
    {
        $query = 'SELECT * FROM pers';
        return $query;
    }
 
    /**
     * Retrieves the  data
     * @return array Array of objects containing the data from the database
     */
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

    /**
     * Stores the  data
     */
    function storeData()
    {	$today = date("d.m.Y");
	    $row =& $this->getTable();

	    $id = JRequest::getVar('ids', '0', 'post', 'integer');
		$dt2= JRequest::getVar($id.'_c4', $today);
		$dto = substr($dt2, -4).'-'.substr($dt2, 3, 2).'-'.substr($dt2, 0, 2);
		
	    $arr = array('id'=>$id,
		     
			 'name' => JRequest::getVar($id.'_c0', '','post', 'string'),
			 'id_c' =>JRequest::getVar($id.'_c1', '0','post'),
	'id_job' =>JRequest::getVar($id.'_c2', '0','post'),	
	'infolink' =>JRequest::getVar($id.'_c3', '','post', 'string'),	
	'd_r'=>$dto,	
	'prim'=>JRequest::getVar($id.'_c5', '','post', 'string')	
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
	  /**
    * Method to delete record(s)
    *
    */
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
 
 
    /**
     * Retrieves the  data
             */
    function newData()
    {
            $row =& $this->getTable();
 
            $arr = array('id' => '0',
						 'name' =>''
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