<?php
/**
 * company Model for soro Component
 *
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * company Model
 *
 */
class toolModelCompany extends JModel
{
    /**
     * company data array
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
        $query = ' SELECT * FROM company ';
        return $query;
    }

    /**
     * Retrieves the company data
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
     * Stores the company data
     */
    function storeData()
    {
	    $row =& $this->getTable();
        $dopr = JRequest::getVar('dopr',0);
		$id = JRequest::getVar('ids', '0', 'post', 'integer');

		if($dopr==1)
		 $arr = array('id' => $id,

			 'bik' => JRequest::getVar($id.'_c1', '0'),
			 'rsh' => JRequest::getVar($id.'_c2', '0'),
	 		 'pind' => JRequest::getVar($id.'_c3', '654010'),
			 'tel' => JRequest::getVar($id.'_c4', ''),
			 'fax' => JRequest::getVar($id.'_c5', ''),
			 'email' => JRequest::getVar($id.'_c6', ''),
			 'dolj' => JRequest::getVar($id.'_c7', ''),
			 'osnovanie' => JRequest::getVar($id.'_c8', ''),
			 'person' => JRequest::getVar($id.'_c9', ''),
			 'pol' => JRequest::getVar($id.'_c10', '0'),
			 'infodoc' => JRequest::getVar($id.'_c11', ''),			 
			 );
		else
	    $arr = array('id' => $id,
			 'name' => JRequest::getVar($id.'_c0', '', 'post', 'string'),
			 'short_name' => JRequest::getVar($id.'_c1', '', 'post', 'string'),
			 'inn' => JRequest::getVar($id.'_c2', '0'),
 			 'ogrn' => JRequest::getVar($id.'_c3', '0'),
			 'kpp' => JRequest::getVar($id.'_c4', '0'),
 			 'address' => JRequest::getVar($id.'_c5', '')
			 );

	    // Bind to the company table
	    if (!$row->bind($arr)) {
	        $this->setError($this->_db->getErrorMsg());
	        return 0;
	    }

	    // Make sure the company record is valid
	    if (!$row->check()) {
	        $this->setError($this->_db->getErrorMsg());
	        return 0;
	    }

	    // Store the web link table to the database
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
     * Retrieves the company data
     */
    function newData()
    {
	    $row =& $this->getTable();

	    $arr = array('id' => '0',
			 'name' => '',

			 'short_name' => ''

						 );

	    // Bind to the company table
	    if (!$row->bind($arr)) {
	        $this->setError($this->_db->getErrorMsg());
	        return 0;
	    }

	    // Make sure the company record is valid
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