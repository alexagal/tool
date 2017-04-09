<?php
/**
 *  table class
 * 
 */
 
defined('_JEXEC') or die('Restricted access');
 
/**
 *  Table class
 *
 */
class Tableplan extends JTable
{
    /**
     * Primary Key
     */
	var $id = null; 
    var $id_c = null;
    var $date_n = null;
    var $status = null;	
	var $id_pers = null;
    var $name = null;
    var $kol = null;
    var $prim = null;	
    var $id_p = null;	
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct( &$db ) {
        parent::__construct('plan', 'id', $db);
    }
}