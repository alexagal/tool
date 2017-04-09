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
class Tablepers extends JTable
{
    /**
     * Primary Key
     */
	var $id = null; 

	var $name=null;
	var $id_c=null;
	var $id_job=null;	
	var $infolink=null;	
	var $d_r=null;	
	var $prim=null;	
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct( &$db ) {
        parent::__construct('pers', 'id', $db);
    }
}