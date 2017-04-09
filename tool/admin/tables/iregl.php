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
class Tableiregl extends JTable
{
    /**
     * Primary Key
     */
	var $id = null; 
    var $id_c = null;
    var $date_n = null;
	var $status = null;
    var $id_r = null;
    var $id_pers = null;
    var $kol = null;
    var $prim = null;		
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct( &$db ) {
        parent::__construct('iregl', 'id', $db);
    }
}