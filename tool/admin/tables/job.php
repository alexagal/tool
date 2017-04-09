<?php
/**
 * soro table class
 * 
 */
 
defined('_JEXEC') or die('Restricted access');
 
/**
 *  Table class
 *
 */
class Tablejob extends JTable
{
    /**
     * Primary Key
     */
	var $id = null; 
	var $name=null;
	
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct( &$db ) {
        parent::__construct('jobs', 'id', $db);
    }
}