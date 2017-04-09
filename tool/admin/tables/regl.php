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
class Tableregl extends JTable
{
    /**
     * Primary Key
     */
	var $id = null; 
    var $id_c = null;
    var $date_n = null;
    var $date_k = null;	
	var $gr_w = null;
    var $name = null;
    var $gday = null;
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct( &$db ) {
        parent::__construct('regl', 'id', $db);
    }
}