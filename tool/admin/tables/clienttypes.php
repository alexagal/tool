<?php
/**
 * soro table class
 * 
 */
 
defined('_JEXEC') or die('Restricted access');
 
/**
 * Clienttypes Table class
 *
 */
class TableClienttypes extends JTable
{
    /**
     * Primary Key
     */
    var $id = null;
    var $short = null;
    var $name = null;
 
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct( &$db ) {
        parent::__construct('company_type', 'id', $db);
    }
}