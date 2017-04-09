<?php
/**
 * Controller for  Component
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
 *   Controller
 *
 */

		
class toolControllerrregl extends toolController
{
 
        /**
         * get  data
         * @return void
         */
        function getrregl()
        { 
		$today = date("d-m-Y");
		$t_mon=date("m");
		$mon = JRequest::getVar('mon',$t_mon);
 
		if ($mon==-2){
		$b_mon= mktime(0, 0, 0, 10,31, date("Y")-1);
		$e_mon=mktime(0, 0, 0, 11,30, date("Y")-1);
		$d1=date('Y-m-d',$b_mon);
		$d2=date('Y-m-d',$e_mon);
		}elseif($mon==-1){
		$b_mon= mktime(0, 0, 0, 11,30, date("Y")-1);
		$e_mon=mktime(0, 0, 0, 12,31, date("Y")-1);
		$d1=date('Y-m-d',$b_mon);
		$d2=date('Y-m-d',$e_mon);
		}else{
		$b_mon= mktime(0, 0, 0, $mon,0, date("Y"));
		if($mon==12)
		$e_mon=mktime(0, 0, 0, 12,31, date("Y"));
		else
		$e_mon=mktime(0, 0, 0,$mon+1,0, date("Y"));
		$d1=date('Y-m-d',$b_mon);
		$d2=date('Y-m-d',$e_mon);
		}
		  
	    $doc =& JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
 
	    $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
		$return .= "<rows>\n";
		 $db =& JFactory::getDBO();
		  $f_q = mysql_query('select i.id,date_format(i.date_n,"%d.%m.%y"),r.name,c.short_name,substring_index(pr.name," ",1),i.kol,i.status,i.prim
		  from iregl i,contractors c,pers pr,regl r where 
		  i.date_n<="'.$d2.'"&&"'.$d1.'"<i.date_n&&i.id_r=r.id&&r.id_c=c.id&&i.id_pers=pr.id;');
					$return .= " <row id=\"i\">\n";
					$return .= "  <cell></cell>\n";
					$return .= "  <cell style=' font-weight:bold;'>ИСПОЛНЕННЫЕ</cell>\n";
                    $return .= " </row>\n";	  
	    while ($f_s = mysql_fetch_row($f_q))
	    {     
					$return .= " <row id=\"".$f_s[0]."\">\n";
					$return .= "  <cell>".$f_s[1]."</cell>\n";
					$return .= "  <cell>".$f_s[2]."</cell>\n";
					$return .= "  <cell>".$f_s[3]."</cell>\n";
                    $return .= "  <cell>".$f_s[4]."</cell>\n";
					$return .= "  <cell>".$f_s[5]."</cell>\n";
                    $return .= "  <cell>".$f_s[6]."</cell>\n";
					$return .= "  <cell>".$f_s[7]."</cell>\n";
		
                    $return .= " </row>\n";
        } 
//	обработка не исполненных
					$return .= " <row id=\"n\">\n";
					$return .= "  <cell></cell>\n";
					$return .= "  <cell style=' font-weight:bold;'>НЕ ИСПОЛНЕННЫЕ</cell>\n";
                    $return .= " </row>\n";
		mysql_query('truncate table `tmp_regl`;');					
		$db=explode("-", $d1);			
		$nd=array('вс','пн','вт','ср','чт','пт','сб');
        $w=date('w',$b_mon)+1;
        $kdm=date('d',$e_mon); // day of mon
		for($i=0; $i < $kdm; $i++)
		{$t=($w+$i)%7;
		 $kd=$nd[$t];
		 $dd=date('Y-m-d',mktime(0, 0, 0,$db[1],$db[2]+$i+1,$db[0]));
		 $gday=date('d.m',mktime(0, 0, 0,$db[1],$db[2]+$i+1,$db[0]));
		 $dt=substr($dd,-2);
	mysql_query('INSERT INTO `tmp_regl` ( id, id_r, date_n ) (
SELECT 0 , id, "'.$dd.'" FROM regl WHERE instr(gr_w,"ежедневно") + instr(gr_w,"'.$kd.'")+ instr(gr_w,"'.$dt.'")+
instr(gr_w,"по заявке")*instr(gday,"'.$gday.'")>0&& date_n <= "'.$dd.'" &&( "'.$dd.'" <= date_k||date_k is NULL ));'); 
		}
        mysql_query('DELETE FROM tmp_regl WHERE EXISTS (
SELECT id
FROM iregl
WHERE tmp_regl.date_n = date_n && tmp_regl.id_r = id_r
);');		
          $f_q = mysql_query('select i.id,date_format(i.date_n,"%d.%m.%y"),r.name,c.short_name
		  from tmp_regl i,contractors c,regl r where 
		  i.id_r=r.id&&r.id_c=c.id;');
		  $t='n';
	    while ($f_s = mysql_fetch_row($f_q))
	    {     
					$return .= " <row id=\"".$t.$f_s[0]."\">\n";
					$return .= "  <cell>".$f_s[1]."</cell>\n";
					$return .= "  <cell>".$f_s[2]."</cell>\n";
					$return .= "  <cell>".$f_s[3]."</cell>\n";

                    $return .= " </row>\n";
        } 		  
         $return .= "</rows>";
 
            echo $return;      
         }

}