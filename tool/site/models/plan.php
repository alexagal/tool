<?php
/**
 *  Model for  Component
 * 
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

 function delnode($n)
{$f_q = mysql_query('select id from plan where id_p="'.$n.'";');
 $r=mysql_num_rows($f_q);
 IF ($r>0)
 { 
  while ($f=mysql_fetch_row($f_q))
  delnode($f[0]);
  };
 mysql_query('delete from plan where id="'.$n.'";');
return ;
}  
jimport( 'joomla.application.component.model' );
 
/**
 *  Model
 *
 */
class toolModelplan extends JModel
{
    /**
     * locgraf data array
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
        $query = " SELECT * FROM plan";
        return $query;
    }
 
    /**
     * Retrieves  data
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
     * Stores  data
    
     */
    function storeData()
    {  
            $row =& $this->getTable();
            $id = JRequest::getVar('ids', '', 'post', 'string');
			$ids = explode("_", $id);
			$c=count($ids);
			$id_=$ids[$c-1];
			$today = date("d.m.Y");
			
			$dt=JRequest::getVar($id.'_c1',$today);
			$dn = substr($dt, -4).'-'.substr($dt, 3, 2).'-'.substr($dt, 0, 2);
			$name=JRequest::getVar($id.'_c2', '', 'post', 'string');
			$id_c=JRequest::getVar($id.'_c3', '0', 'post', 'string');
			$id_pers=JRequest::getVar($id.'_c4', '0', 'post', 'string');
			$kol=JRequest::getVar($id.'_c5', '0', 'post', 'string');
			$status=JRequest::getVar($id.'_c6', '', 'post', 'string');
			$prim=JRequest::getVar($id.'_c7', '', 'post', 'string');			
 
	  
            $arr = array('id' => $id_,
			             'name' => $name,
						 'date_n' => $dn,
			             'id_c' => $id_c,
						'id_pers' =>$id_pers,
						'kol' =>	$kol,
						'status' =>$status,
						'prim' =>$prim						 
						 );

            // Bind to table
            if (!$row->bind($arr)) {
                $this->setError($this->_db->getErrorMsg());
 
                return 0;
            }
 
            // Make sure  record is valid
            if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());

                return 0;
            }
 
            // Store the web link table to the database
            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
		
                return 0;
            }
         
            return $id;
 
    }
 	  /**
    * Method to delete record(s)
    *
    */
   function deleteData()
   {
        $id = JRequest::getVar('ids', '', 'post', 'string');
		$ids = explode("_", $id);
		$c=count($ids);
		$id_=$ids[$c-1];

		delnode($id_);
/*        $row =& $this->getTable();
 
        if (!$row->delete( $id_ )) {
             $this->setError( $row->getErrorMsg() );
             return 0;
        } */
 
        return $id;
   }
  
    /**
     * Retrieves the  data
             */
    function newData()
    {       $id = JRequest::getVar('ids', '', 'post', 'string');
			$id_= JRequest::getVar($id.'_gr_pid', '', 'post', 'string');
		    $ids = explode("_", $id_);
			$c=count($ids);

			$id_p=$ids[$c-1];

            $row =& $this->getTable();

            $arr = array('id' => 0,
						 'name'=>"",
						 'id_p' =>$id_p
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
            $p=($id_==0)?"":$id_."_";
            return $p.$row->id;
    }
   
 
 
 }