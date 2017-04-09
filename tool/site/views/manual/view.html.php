<?php
/**
 *  View for manual Component
 * 
 */
 
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.view' );
 
/**
 * avto View
 *
 */
class toolViewmanual extends JView
{
    /**
     * soro view display method
     * @return void
     **/
    function display($tpl = null)
    {
 
        // Get data from
		  $items =& $this->get( 'Data');
 
        $this->assignRef( 'items', $items );
 
        parent::display($tpl);
    }
}