<?php
/**
 * company Controller for soro Component
 *
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
function formreader()
{
 $a='reader_';

 foreach($_REQUEST as $field=>$value)
 {$a.=$field.' = '.$value.'__';}
 mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.$a.'");');
}
/**
 * soro company Controller
 *
 */
class toolControllercompany extends toolController
{

	/**
         * get company data
         * @return void
         */
        function getcompany()
        {
//		formreader();
            $db =& JFactory::getDBO();
 //           $cli = JRequest::getVar('cli',0);

	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	    $return .= "<rows>\n";
	    $return .= "<head>\n";

	    $return .= "<column type=\"ro\" width=\"90\" align=\"left\" filter=\"true\" sort=\"str\" xmlcontent=\"1\"><![CDATA[<div align=center>Краткое<br>наименование</div>]]></column>\n";

		$return .= "<column type=\"ed\" width=\"70\" align=\"left\" sort=\"str\">БИК</column>\n";
		$return .= "<column type=\"ed\" width=\"140\" align=\"left\" sort=\"str\">Расчетный счет</column>\n";

		$return .= "<column type=\"ed\" width=\"52\" align=\"left\" sort=\"str\">Индекс</column>\n";
		$return .= "<column type=\"ed\" width=\"90\" align=\"left\" sort=\"str\">Телефон</column>\n";
		$return .= "<column type=\"ed\" width=\"60\" align=\"left\" sort=\"str\">Факс</column>\n";
		$return .= "<column type=\"ed\" width=\"90\" align=\"left\" sort=\"str\">e-mail</column>\n";
		$return .= "<column type=\"ed\" width=\"130\" align=\"left\" sort=\"str\">Должность</column>\n";
		$return .= "<column type=\"ed\" width=\"90\" align=\"left\" sort=\"str\">Основание</column>\n";
		$return .= "<column type=\"ed\" width=\"*\" align=\"left\" sort=\"str\">Подписант</column>\n";
		$return .= "<column type=\"ch\" width=\"30\" align=\"left\" sort=\"str\">Пол</column>\n";
		$return .= "<column type=\"txt\" width=\"120\" align=\"left\" sort=\"str\">Документы</column>\n";

	    $return .= "</head>\n";

        $query = 'SELECT c.id,c.short_name,c.bik,c.rsh,c.pind,c.tel,c.fax,c.email,c.dolj,c.osnovanie,c.person,c.pol,c.infodoc
        FROM company c   ';


	    $doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');

        $f_q = mysql_query($query) or die("ошибка БД dogovor: " . mysql_error());
		while  ($f=mysql_fetch_row($f_q))
	    {
                $return .= " <row id=\"".$f[0]."\">\n";


                $return .= " <cell><![CDATA[".$f[1]."]]></cell>\n";
                $return .= " <cell>".$f[2]."</cell>\n";
                $return .= " <cell>".$f[3]."</cell>\n";
                $return .= " <cell>".$f[4]."</cell>\n";
                $return .= " <cell>".$f[5]."</cell>\n";
                $return .= " <cell>".$f[6]."</cell>\n";
				$return .= " <cell>".$f[7]."</cell>\n";
				$return .= " <cell>".$f[8]."</cell>\n";
                $return .= " <cell>".$f[9]."</cell>\n";
                $return .= " <cell>".$f[10]."</cell>\n";
                $return .= " <cell>".$f[11]."</cell>\n";
                $return .= " <cell>".$f[12]."</cell>\n";
                $return .= " </row>\n";
            }
	    $return .= "</rows>";
	    echo $return;
	 }

	/**
	 * save data
	 * @return void
	 */
	function putcompany()
	{
     	    $model = $this->getModel('company');
     	    //$ids = explode(",", JRequest::getVar('ids', '0', 'post', 'integer'));

	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');

            $id = JRequest::getVar('ids', '0', 'post', 'string');
            $nativeeditor_status = JRequest::getVar($id.'_!nativeeditor_status', '', 'post', 'string');

            if ($nativeeditor_status == 'updated')
            {
                    $m_id = $model->storeData();
       	            if ($m_id == 0)
		    {
        	        $msg = JText::_( 'Error Saving Greeting' );
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
					    $return .= "<data>";
           	        $return .= "<action type='my_error' sid='".$id."' tid='".$m_id."'>".mysql_errno() . ':' . mysql_error()."</action>";
           	        $return .= "</data>";
        	    } else {
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
               	        $return .= "<data>";
           	        $return .= "<action type='update' sid='".$id."' tid='".$m_id."'/>";
           	        $return .= "</data>";
           	    }
            }

            if ($nativeeditor_status == 'deleted')
            {
                    $m_id = $model->deleteData();
        	    if($m_id == 0)
		    {
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
         	    } else {
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
             	        $return .= "<data>";
          	        $return .= "<action type='delete' sid='".$id."' tid='".$m_id."'/>";
         	        $return .= "</data>";
         	    }
            }

            if ($nativeeditor_status == 'inserted')
            {
                    $m_id = $model->newData();
       	            if ($m_id == 0)
		    {
        	        $msg = JText::_( 'Error Inserting Record' );
        	        echo "<script>alert('Error Inserting Record (".$new_id.")')</script>";
        	    } else {
                        $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
               	        $return .= "<data>";
           	        $return .= "<action type='insert' sid='".$id."' tid='".$m_id."'/>";
           	        $return .= "</data>";
           	    }
            }

	    echo $return;
	}



        function getCitycompany() {

            $db =& JFactory::getDBO();


	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	    $return .= "<rows>\n";

	    $return .= "<head>\n";
	    $return .= "<column type=\"ed\" width=\"200\" align=\"left\" filter=\"true\" sort=\"str\" >Наименование компании</column>\n";

	    $return .= "<column type=\"ed\" width=\"100\" align=\"left\" filter=\"true\" sort=\"str\" >Краткое наименование</column>\n";
	    $return .= "<column type=\"ed\" width=\"90\" align=\"right\" filter=\"true\" sort=\"int\" >ИНН</column>\n";
		$return .= "<column type=\"ed\" width=\"110\" align=\"left\" sort=\"str\">ОГРН</column>\n";
		$return .= "<column type=\"ed\" width=\"90\" align=\"left\" sort=\"str\">КПП</column>\n";
		$return .= "<column  type=\"kladr\" width=\"*\" align=\"left\" sort=\"str\">Адрес юридический/ регистрации</column>\n";

	    $return .= "</head>\n";



                $query = "SELECT c.id, c.name,  c.short_name,
				c.inn,c.ogrn,c.kpp, c.address        FROM company c  ";


	    $doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');

            $db->setQuery( $query );
            $result = $db->loadRowList();
            for ($j=0, $m=count($result); $j < $m; $j++) {

                $return .= " <row id=\"".$result[$j][0]."\">\n";
                $return .= " <cell><![CDATA[".$result[$j][1]."]]></cell>\n";
                $return .= " <cell><![CDATA[".$result[$j][2]."]]></cell>\n";

                $return .= " <cell>".$result[$j][3]."</cell>\n";
                $return .= " <cell>".$result[$j][4]."</cell>\n";
                $return .= " <cell>".$result[$j][5]."</cell>\n";
                $return .= " <cell>".$result[$j][6]."</cell>\n";
                $return .= " </row>\n";
            }
	    $return .= "</rows>";

	    echo $return;
	}

}