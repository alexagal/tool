<?php
/**
 * Clienttypes Model for soro Component
 *
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * Clienttypes Model
 *
 */
class toolModelClienttypes extends JModel
{
    /**
     * Clienttypes data array
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
        $query = "SELECT id,short,name FROM company_type ORDER BY short";
        return $query;
    }

    /**
     * Retrieves the Client Types data
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
     * Stores the Client Types data
     */
    function storeData()
    {
	    $row =& $this->getTable();

	    $id = JRequest::getVar('ids', '0', 'post', 'integer');

	    $arr = array('id' => $id,
	    'short'=>JRequest::getVar($id.'_c0', ''),
	     'name' =>JRequest::getVar($id.'_c1', ''));

	    // Bind to the ClientTypes table
	    if (!$row->bind($arr)) {
	        $this->setError($this->_db->getErrorMsg());
	        return 0;
	    }

	    // Make sure the ClientTypes record is valid
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
 	$id = JRequest::getVar('ids', '0', 'post', 'integer');
	$row =& $this->getTable();

	if (!$row->delete( $id )) {
	     $this->setError( $row->getErrorMsg() );
	     return 0;
	}
	return $id;
   }

    /**
     * Retrieves the ClientTypes data
     */
    function newData()
    {
	    $row =& $this->getTable();

	    $arr = array('id' => '0',
	    'short'=>'',
			 'name_type' => '');

	    // Bind to the types table
	    if (!$row->bind($arr)) {
	        $this->setError($this->_db->getErrorMsg());
	        return 0;
	    }

	    // Make sure the types record is valid
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


}