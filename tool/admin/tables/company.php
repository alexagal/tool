<?php
/**
 * soro table class
 * 
 */
 
defined('_JEXEC') or die('Restricted access');

class TableCompany extends JTable
{
    /**
     * Primary Key
     */
    var $id = null;
    var $name = null;
    var $short_name = null;
    var $inn = null;
    var $address = null;
    var $ogrn = null;
    var $kpp = null;
    var $bik = null;
    var $rsh = null; 
	var $pind = null;
    var $tel = null;
    var $fax = null;
    var $email = null;
    var $dolj = null;
    var $osnovanie = null;
    var $person = null;
    var $pol = null;
    var $infodoc = null;
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct( &$db ) {
        parent::__construct('company', 'id', $db);
    }
}