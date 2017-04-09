<?php
/**
 * Kladr Controller for soro Component
 * 
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
/**
 * soro Kladr Controller
 *
 */
class toolControllerKladr extends toolController
{

        /**
         * get Kladr regions data
         * @return void
         */
        function getRegions()
        { 
            $db =& JFactory::getDBO();

	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	    $return .= "<complete>\n";

	    $query = "select name,socr,left(code,2) as code from kladr_KLADR 
                       where left(code,2)!='00' and right(code,11)='00000000000' order by name";

            $db->setQuery( $query );
            $result = $db->loadRowList();
            for ($j=0, $m=count($result); $j < $m; $j++)
	    {
	            $return .= "<option value=\"".$result[$j][2]."\">".$result[$j][0]." ".$result[$j][1]."</option>\n";
	    }

	    $return .= "</complete>\n";
	    echo $return;      
	 }

        /**
         * get Kladr areas data
         * @return void
         */
        function getAreas()
        { 
            $db =& JFactory::getDBO();
	    $reg_code = JRequest::getVar('reg_code');

	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";

	    $query = "select name,socr,left(code,5) as code from kladr_KLADR 
                       where left(code,2)='$reg_code' and right(left(CODE,5),3)!='000'
                        and right(CODE,8)='00000000' order by name";

            $db->setQuery( $query );
            $result = $db->loadRowList();
	    $return .= "<complete>\n";
            for ($j=0, $m=count($result); $j < $m; $j++)
	    {
	            $return .= "<option value=\"".$result[$j][2]."\">".$result[$j][0]." ".$result[$j][1]."</option>\n";
	    }

	    $return .= "</complete>\n";
	    echo $return;      
	 }

        /**
         * get Kladr citys data
         * @return void
         */
        function getCitys()
        { 
            $db =& JFactory::getDBO();
	    $reg_code = JRequest::getVar('reg_code');

	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";

	    $query = "select name,socr,left(code,8) as code from kladr_KLADR 
                       WHERE left(code, 5)='".$reg_code."000' AND right(left(CODE, 8), 3) != '000'
                        AND right(CODE, 5) = '00000' ORDER BY name";

            $db->setQuery( $query );
            $result = $db->loadRowList();
	    $return .= "<complete>\n";
            for ($j=0, $m=count($result); $j < $m; $j++)
	    {
	            $return .= "<option value=\"".$result[$j][2]."\">".$result[$j][0]." ".$result[$j][1]."</option>\n";
	    }

	    $return .= "</complete>\n";
	    echo $return;      
	 }

        /**
         * get Kladr towns data
         * @return void
         */
        function getTowns()
        { 
            $db =& JFactory::getDBO();
	    $parent_code = JRequest::getVar('parent_code');

	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";

	    $query = "SELECT name,socr,left(code,11) AS code FROM kladr_KLADR 
                       WHERE left(code, ".strlen($parent_code).") = '$parent_code' 
                        AND right(CODE, ".(13-strlen($parent_code)).") != '".str_repeat('0', 13-strlen($parent_code)).
                        "' AND right(code, 2) = '00' ORDER BY name";
            $db->setQuery( $query );
            $result = $db->loadRowList();
	    $return .= "<complete>\n";
            //$return .= "<option value=\"".$parent_code.str_repeat('0', 11-strlen($parent_code))."\"><![CDATA[&nbsp;]]></option>\n";
            for ($j=0, $m=count($result); $j < $m; $j++)
	    {
	            $return .= "<option value=\"".$result[$j][2]."\">".$result[$j][0]." ".$result[$j][1]."</option>\n";
	    }

	    $return .= "</complete>\n";
	    echo $return;      
	 }

        /**
         * get Kladr street data
         * @return void
         */
        function getStreets()
        { 
            $db =& JFactory::getDBO();
	    $parent_code = JRequest::getVar('parent_code');

	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";

	    $query = "SELECT name,socr,left(code,15) AS code FROM kladr_STREET 
                       WHERE left(code, 11) = '$parent_code' AND right(code, 2) = '00' ORDER BY name";

            $db->setQuery( $query );
            $result = $db->loadRowList();
	    $return .= "<complete>\n";
            for ($j=0, $m=count($result); $j < $m; $j++)
	    {
	            $return .= "<option value=\"".$result[$j][2]."\">".$result[$j][0]." ".$result[$j][1]."</option>\n";
	    }

	    $return .= "</complete>\n";
	    echo $return;      
	 }

}