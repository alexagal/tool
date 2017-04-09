<?php
/**
 * table class
 * 
 */
 
defined('_JEXEC') or die('Restricted access');
 
/**
 *  Table class
 *
 */
class Tablesq extends JTable
{
    /**
     * Primary Key
     */
	var $id = null; 

	

	var $name=null;
	var $val=null;
	var $param=null;
	var $id_p=null;
	
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct( &$db ) {
        parent::__construct('sq', 'id', $db);
    }
}