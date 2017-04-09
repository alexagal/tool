<?php
/**
 *  Controller for  Component
 *
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once 'ExcelWriter.php';
require_once 'html_to_doc.inc.php';

// var dolg
function vardolg($row)
{$f_q=mysql_query('select date_format(d.date_n, "%d.%m.%Y"),date_format(d.date_k, "%d.%m.%Y"),p.name,
date_format(p.d_r, "%d.%m.%Y"),d.adres,concat((select name from company_type where id=c.id_type)," ",c.name),
c.address, s.name,s.inn,s.address,s.email,s.tel,s.person,s.short_name,s.osnovanie,d.s_p,d.s_u,p.homeland,
concat("ИНН ",c.inn," КПП ",c.kpp," р/сч. ",c.rsh),c.bik,d.kod,if(p.pol="ж",1,0),p.room,p.id_h,d.date_k,d.pril
		from sdoc d,company c,company s,prop p
		where d.id="'.$row.'"&& d.id_company=c.id&&d.id_sy=s.id&&d.kod=p.kod');
list($d_dn,$d_dk,$d_fio,$d_dr,$d_adres,$k_name,$k_adres,$sy_name,$sy_nom,$sy_adres,$sy_email,$sy_tel,$sy_person,$sy_short,
$sy_raion,$d_s_p,$d_s_u,$urog,$k_rekv,$bik,$kod,$pol,$d_room,$id_h,$dk,$d_pril)=mysql_fetch_row($f_q);
	$d_adres=p_adr($d_adres);
	$k_adres=p_adr($k_adres);
	$sy_adres=p_adr($sy_adres);	
	$d_fio=mb_convert_case($d_fio, MB_CASE_TITLE, "UTF-8");
	$d_fi_d=d_pad($d_fio);
	$d_fi_r=fr_pad($d_fio,$pol);
	$ids=explode(" ",$sy_name,3);
	$ids[0]=r_pad($ids[0]);
	$ids[1]=r_pad($ids[1],1);	
	$sy_nam_r=implode(" ",$ids);
	$ids=explode(" ",$k_name,2);
	$ids[0]=r_pad($ids[0],2);
	$k_nam_r=implode(" ",$ids);
    $ids[0]="Обществом";   
	$k_nam_t=implode(" ",$ids);
	$sy_pers_i=in_fio($sy_person);
	$f_q=mysql_query('select name,kshet from bik where bik="'.$bik.'" limit 1;' );
	while ($f_ = mysql_fetch_row($f_q))
	{$k_rekv.=" в ".$f_[0]." кор/сч ".$f_[1];}
// data house
    $f_q=mysql_query('select param from feat where id_h="'.$id_h.'"&&kod="d"&&name="Договор" limit 1;');
	$f_=mysql_fetch_row($f_q);
	if(is_null($f_[0]))
	$d_dog=date('d.m.Y');
	else
	$d_dog=$f_[0];
    $f_q=mysql_query('select param from feat where id_h="'.$id_h.'"&&kod="d"&&name="Протокол" limit 1;');
	$f_=mysql_fetch_row($f_q);
	if(is_null($f_[0]))
	$d_prot=date('d.m.Y');
	else
	$d_prot=$f_[0];	
	$f_q = mysql_query('select s.name,h.home	from house h,street s where h.id_street=s.id&&h.id="'.$id_h.'" ;') or 
	die("ошибка БД house: " . mysql_error());
	$f_=mysql_fetch_row($f_q);
	if(is_null($f_[0]))
	$d_home="";
	else
	{$ids=explode(' ',$f_[0]);
		array_unshift($ids,array_pop($ids));
		$ids[0].='.';
		$t=implode(' ',$ids);
	$d_home=$t.',д.'.$f_[1];
    }	
//  data dolg
	$f_q=mysql_query('select max(date_n) from detal where date_n<="'.$dk.'";');
	$f=mysql_fetch_row($f_q);
	$dn=(is_null($f[0]))?$dk:$f[0];
	$d_sum=0;
	$f_q=mysql_query('select sum(rest+calc-pay) from detal where date_n="'.$dn.'"&&kod="'.$kod.'";' );
	while ($f_ = mysql_fetch_row($f_q))	
	{$d_sum+=$f_[0];}	
	$d_su_p=propstr($d_sum);
	$d_detal='';
	$f_q=mysql_query('select u.name,(d.rest+d.calc-d.pay) from detal d,serv u where u.kod=d.kod_u&&d.date_n="'.$dn.'"&&d.kod="'.$kod.'";' );
	while ($f_ = mysql_fetch_row($f_q))	
	{$d_detal.='<tr><td  style="text-align: left">'.$f_[0].'</td><td style="text-align: right">'.number_format($f_[1],2,'.','').'</td></tr>';}
	$d_detal.='<tr><td  style="text-align: left">Итого</td><td style="text-align: right">'.number_format($d_sum,2,'.','').'</td></tr>';
	$urog='место рождения: '.(($urog=="")?"Кемеровская обл,г. Новокузнецк":p_adr($urog));
	$d_pril=str_replace(";","<br/>",$d_pril); // ; перевод строки
		$mon=array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
	    $today.=" «".date('d')."» ".$mon[date('m')-1]." ".date('Y');
$a=array("",$city,$d_dn,$d_dk,$d_fio,$d_fi_r,$d_fi_d,$d_dr,$d_adres,$k_name,$k_nam_r,$k_nam_t,$k_adres,$k_rekv,
$sy_name,$sy_nom,$sy_nam_r,$sy_adres,$sy_email,$sy_tel,$sy_person,$sy_pers_i,$sy_short,$sy_raion,
$d_sum,$d_su_p,$d_s_p,$d_s_u,$today,$urog,$d_pril,$d_detal,$d_room,$d_home,$d_dog,$d_prot);
$s=array('city','d_dn','d_dk','d_fio','d_fi_r','d_fi_d','d_dr','d_adres','k_name','k_nam_r','k_nam_t','k_adres','k_rekv',
'sy_name','sy_nom','sy_nam_r','sy_adres','sy_email','sy_tel','sy_person','sy_pers_i','sy_short','sy_raion',
'd_sum','d_su_p','d_s_p','d_s_u','today','urog','d_pril','d_detal','d_room','d_home','d_dog','d_prot');
		$a[0]=implode(",",$s);
		return $a;
}

function w_sh($sv)
{	$f_q=mysql_query('select col1,col2,col3,col4,col5  from sh_doc where id="'.$sv.'"');
 if(mysql_num_rows($f_q)==0)
 {		$filename = 'components/com_jkh/tmplh/err_no.html';
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
	return	$contents;
 }
 $f=mysql_fetch_row($f_q);
 $contents='';
 for($i=0,$m=count($f); $i < $m; $i++)
 {if($f[$i]>"")
 {$filename = 'components/com_jkh/tmplh/'.$f[$i].'.html';
 $handle = fopen($filename, "r");
 $contents.= fread($handle, filesize($filename))."\n";
 fclose($handle);
 }
 }
return		$contents;
}
//
function p_adr($cli_adr)
{	$cli=str_replace(',,',',',$cli_adr);
		$m=explode(',',$cli);
		$m = array_diff($m, array(null,'', ','));
		if (count($m)>1)
		{ $m1=explode(' ',$m[1]);
		array_unshift($m1,array_pop($m1));
		$m1[0].='.';
		$m[1]=implode(' ',$m1);
			if (count($m)>2)
			{ $m1=explode(' ',$m[2]);
			array_unshift($m1,array_pop($m1));
			$m1[0].='.';
			$m[2]=implode(' ',$m1);
			}
		$cli=implode(', ',$m);
		}
return 	$cli;
}
//date format
function d_f($date,$day=0)
{
 $d= mktime(0, 0, 0, substr($date,5,3), substr($date,-2)+$day,  substr($date,0,4));
 return date('d.m.Y',$d);
}
// inizial
function in_fio($z)
{
$z = mb_convert_case($z, MB_CASE_TITLE, "UTF-8");
$m=explode(" ",$z);
IF(count($m)>2)
return substr($m[1],0,2).".".substr($m[2],0,2).". ".$m[0];
elseif (count($m)>1)
return substr($m[1],0,2).". ".$m[0];
else
return $z;
}

// dolg rod
 function dr_pad($z)
 { If (trim($z)=="")
  return "";
 $m=explode(" ",$z);
 $t='';
 $k=0;
 foreach($m as $field=>$value)
 $t.=(($k++<3)?r_pad($value):$value)." ";
 Return $t;
 }
 // fio rod
 function fr_pad($z,$p)
 { If (trim($z)=="")
  return "";
  $z = mb_convert_case($z, MB_CASE_TITLE, "UTF-8");
 $m=explode(" ",$z);
 $t='';
 $i=0;
 foreach($m as $field=>$value)
 {
 $t.=r_pad($value,$i,$p)." ";
 $i++;
 if ($i>2)
 break;
 }
 Return $t;
 }
// rod_padeg
//parameters $z -name, $tip 0,1,2- f,i,o, $pol -0,1 -m,g
function r_pad($z,$t=0,$p=0)
{$z=trim($z);
if(strlen($z)<3)
return $z;
 $s22='';
 $s11='';
 IF($t==2) 	// отчество
 {  $s=substr($z,-2);
   $s1=substr($z,0,strlen($z)-2);
   if($s=="а")
   $s2="ы";
   elseif ($s=="ч")
   $s2="ча";
   elseif ($s=="о")
   $s2="а";  
   else
   $s2=$s;
  return $s1.$s2;
  }
 IF($t==1)	// имя
 {$s2=substr($z,-4);
  $s1=substr($s2,-2);
  $s20=substr($s2,0,2);
  $s3=substr($z,-6);
  if($p==0) //муж
  {if($s1=='я')
    $s11='и';
   elseif($s1=='а')
    $s11='ы';
   elseif($s1=='й' or $s1=='ь')
    $s11='я';
   elseif($s2=='ев')
    $s22='ьва';
   elseif($s2=='ок')
    $s22='ка';	
   elseif($s3=='вел')
    $s22='ла';
   elseif(mb_substr_count("цкнгшщзхфвпрpлджчсмтб", $s1,"UTF-8")>0)
    $s11=$s1.'а';
   else
     $s11=$s1;
	 $s3=((strlen($s11)>0)?2:0)+((strlen($s22)>0)?4:0);
	return substr($z,0,strlen($z)-$s3).$s11.$s22;
  }
  else // жен
  {
   if($s1=='а')
    $s11=(mb_substr_count("кгжш", $s20,"UTF-8")>0)?'и':'ы';
   elseif($s1=='я' or $s1=='ь')
    $s11='и';
   else
    $s11=$s1;
	echo "len=".strlen($z).'s1='.$s1.' s11='.$s11.'<br>';
   return substr($z,0,strlen($z)-2).$s11;
  }
 }
 // fam
  $s2=substr($z,-4);
  $s20=substr($z,-4,2);
  $s1=substr($s2,-2);
  $s3=substr($z,-6);
  $s30=substr($z,-6,2);
  $s40=substr($z,-8,2);
  if($p==0) //муж
  {if(($s2=='ов' or $s2=='ев' or $s2=='ёв' or $s2=='ин' or $s2=='ын') and strlen($z)>6)
    $s11=$s1.'а';
   elseif(mb_substr_count("жийчийшийщийций", $s3,"UTF-8")>0)
    $s22='его';
   elseif($s3=='хий')
    $s22='ого';
   elseif(($s2=='ий' or $s2=='ый' or $s2=='ой') and s3<>'лий' and strlen($z)>6 and mb_substr_count("уеыаоэяиюё",$s40,"UTF-8")==0 and mb_substr_count("кшчг",$s30,"UTF-8")==0)
    $s22='ого';
   elseif(($s2=='ий' or $s2=='ый' or $s2=='ой') and s3<>'лий' and strlen($z)>6 and mb_substr_count("кшчг",$s30,"UTF-8")>0)
    $s22='ого';
   elseif(($s2=='ий' or $s2=='ый' or $s2=='ой') and s3<>'лий' and strlen($z)>6 and mb_substr_count("уеыаоэяиюё",$s40,"UTF-8")>0 and mb_substr_count("кшчг",$s30,"UTF-8")==0)
    $s11='я';
   elseif ($s1=='й')
    $s22=($z=='Воробей' or $z=='Соловей' or $z=='Муравей')?'ья':($s20.'я');
   elseif (($s3=='иец' or $s2=='яц') and strlen($z)>6)
    $s22='йца';
   elseif(($s2=='ец' or $s2=='ёц') and strlen($z)>6)
   { if(mb_substr_count("уёеыаоэяию", $s40,"UTF-8")>0)
    $s22=($s30=='л')?'ьца':'ца';
     else
	$s11=$s1.'а';
   }
   elseif($s2=='ёк' and strlen($z)>6 and mb_substr_count("уёеыаоэяию",$s40,"UTF-8")>0)
    $s22='ька';
   elseif(mb_substr_count("цжчшщ",$s1,"UTF-8")>0)
    $s11=$s1.'а';
   elseif($s2=='ок' and $s3<>'кок' and mb_substr_count("уёеыаоэяию",$s40,"UTF-8")>0)
    $s22='ка';
   elseif($z=='Мать' or $z=='Дочь')
    $s11='ери';
   elseif($s1=='ь' or $s2=='ой')
     $s11='я';
   elseif($s2=='ия')
     $s22='ии';
   elseif($s1=='а' and mb_substr_count("уеыаоэяиюё",$s20,"UTF-8")>0)
    $s11='а';
   elseif($s2=='мя')
     $s11='ени';
   elseif($z=='Дитя')
     $s11='яти';
   elseif($s1=='я' and $z<>'Золя')
    $s11='и';
   elseif($s1=='а' and mb_substr_count("шчщцгкхж",$s20,"UTF-8")>0)
    $s11='и';
   elseif($z=='Бобер' or $z=='Бобёр')
    $s22='ра';
   elseif($z=='Орел' or $z=='Осел' or $z=='Козел' or $z=='Бусел' or $z=='Котел' or $z=='Дятел')
    $s22='ла';
   elseif(mb_substr_count("хнрpквщзгпфлдсмтб", $s1,"UTF-8")>0 and !($s2=='их' or $s2=='ых'))
    $s11=$s1.'а';
   else
     $s11=$s1;
  }
  else // жен
  {if(($s2=='на' or $s2=='ва') and strlen($z)>8 and $z<>'Плева')
   $s11='ой' ;
   elseif(mb_substr_count("жаячаяшая", $s3,"UTF-8")>0)
   $s22='ей' ;
   elseif($s2=='ая')
    $s22='ой' ;
   elseif($s2=='яя')
    $s22='ей' ;
   else
    $s11=$s1;
  }
   $s3=((strlen($s11)>0)?2:0)+((strlen($s22)>0)?4:0);
 return substr($z,0,strlen($z)-$s3).$s11.$s22;
}
//
function d_pad($FIO)
      { $ids=explode(" ",$FIO,3);
        $FirstName = $ids[0];
        $SecondName = $ids[1];
        $Patronymic = $ids[2];
       
          # Получаем пол человека:
         if (substr($Patronymic, -2) == 'ч')
          {
            # Склонение фамилии мужчины:
           switch (substr($FirstName, -2))
            {
              case 'ха':
                  $FirstName = substr($FirstName, 0, -2).'хи';
                  break;
                 
              default:
                  switch (substr($FirstName, -2))
                  {
                      case 'е': case 'о': case 'и': case 'я': case 'а':
                          break;
                         
                      case 'й':
                          $FirstName = substr($FirstName, 0, -4).'ому';
                          break;
                         
                      case 'ь':
                          $FirstName = substr($FirstName, 0, -2).'ю';
                          break;
                         
                      default:
                          $FirstName = $FirstName.'у';
                          break;
                  }
                  break;
            }
 
            # Склонение мужского имени:
           switch (substr($SecondName, -2))
            {
               case 'л':
                   $SecondName = substr($SecondName, 0, -4).'лу';
                   break;
                   
               case 'а': case 'я':
                   If (substr($SecondName, -4, 2) == 'и')
                   {
                       $SecondName = substr($SecondName, 0, -2).'и';
                   }
                   else
                   {
                       $SecondName = substr($SecondName, 0, -2).'е';
                   }
                   break;
                           
               case 'й': case 'ь':
                   $SecondName = substr($SecondName, 0, -2).'ю';
                   break;
                           
               default:
                   $SecondName = $SecondName.'у';
                   break;
            }
           
            # Склонение отчества
           $Patronymic = $Patronymic.'у';
           
        }
        else
        {
            # Склоенение женской фамилии
           switch (substr($FirstName, -2))
            {
                case 'о': case 'и': case 'б': case 'в': case 'г':
                case 'д': case 'ж': case 'з': case 'к': case 'л':
                case 'м': case 'н': case 'п': case 'р': case 'с':
                case 'т': case 'ф': case 'х': case 'ц': case 'ч':
                case 'ш': case 'щ': case 'ь':
                    break;
                   
                case 'я':
                    $FirstName = substr($FirstName, 0, -4).'ой';
                   
                default:
                    $FirstName = substr($FirstName, 0, -2).'ой';
                    break;
            }
           
            # Склонение женского имени:
           switch (substr($SecondName, -2))
            {
               case 'а': case 'я':
                   If (substr($SecondName, -4, 2) == 'и')
                   {
                       $SecondName = substr($SecondName, 0, -2).'и';
                   }
                   else
                   {
                       $SecondName = substr($SecondName, 0, -2).'е';
                   }
                   break;
                           
               case 'ь':
                   $SecondName = substr($SecondName, 0, -2).'и';
                   break;
            }
           
            # Склонение женского отчества
           $Patronymic = substr($Patronymic, 0, -2).'е';
 
          }
     
          return $FirstName." ".$SecondName." ".$Patronymic;
        }
  
// propis
function propstr($num) {
    $nul='ноль';
    $ten=array(
        array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
    $unit=array( // Units
        array('копейка' ,'копейки' ,'копеек',	 1),
        array('рубль'   ,'рубля'   ,'рублей'    ,0),
        array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
        array('миллион' ,'миллиона','миллионов' ,0),
        array('миллиард','милиарда','миллиардов',0),
    );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        } //foreach
    }
    else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}
function get_digit($number, $digit) {
    # Получение разряда числа
    $up = pow(10, $digit);
    $down = pow(10, $digit - 1);

    return ($number >= $down)
             ? floor( ($number % $up) / $down )
             : 0 ;
}

function num_prop($number, $words, $gender = 'male') {
    # Возвращает число прописью в именительном падеже
    # (используется для товарных чеков).
    # $gender: female|male|middle

    if (!is_array($words))
        $words = explode(',', $words);

    $str = '';

    $names = array(
            1 => 'тысяча,тысячи,тысяч',
            'миллион,миллиона,миллионов',
            'миллиард,миллиарда,миллиардов',
            // сюда добавить по желанию
        );

    $F = __FUNCTION__;

    foreach (array_reverse($names, TRUE) as $i => $w) {

        $pow = pow(1000, $i);

        if ($number >= $pow) {
            $str .= $F(
                    floor($number/$pow),
                    $w,
                    ( ($i == 1) ? 'female' : 'male' )
                ) . ' ';

            $number = $number % $pow;
        }
    }


    # Сотни

        if ($number >= 100) {
            $hundreds = array(
                1 => 'сто',
                'двести',
                'триста',
                'четыреста',
                'пятьсот',
                'шестьсот',
                'семьсот',
                'восемьсот',
                'девятьсот'
            );
            $h = get_digit($number, 3);
            if (isset($hundreds[$h]))
                $str .= "$hundreds[$h] ";
        }


    # Десятки

        $d = get_digit($number, 2);

        if ($d >= 2 OR $d == 0) {
            $decs = array(
                2 => 'двадцать',
                'тридцать',
                'сорок',
                'пятьдесят',
                'шестьдесят',
                'семьдесят',
                'восемьдесят',
                'девяносто'
            );
            if (isset($decs[$d]))
                $str .= "$decs[$d] ";

            # Единицы

            $u = get_digit($number, 1);

            if ($u > 2) {
                $units = array(
                        3 => 'три',
                        'четыре',
                        'пять',
                        'шесть',
                        'семь',
                        'восемь',
                        'девять'
                    );
                $str .= "$units[$u] "
                        . (
                              ($u > 4)
                              ? $words[2]
                              : $words[1]
                          ) ;
            }

            elseif ($u == 2) {
                $tmp = array(
                        'female' => 'две',
                        'male' => 'два',
                        'middle' => 'два'
                    );
                $str .= "$tmp[$gender] $words[1]";
            }
            elseif ($u == 1) {
                $tmp = array(
                        'female' => 'одна',
                        'male' => 'один',
                        'middle' => 'одно'
                    );
                $str .= "$tmp[$gender] $words[0]";
            }
            else
                $str .= $words[2]; // ноль

        }
        else {

            $sub_d = $number % 100;

            $tmp = array(
                    10 => 'десять',
                    'одиннадцать',
                    'двенадцать',
                    'тринадцать',
                    'четырнадцать',
                    'пятнадцать',
                    'шестнадцать',
                    'семнадцать',
                    'восемьнадцать',
                    'девятнадцать'
                );
            $str .= "$tmp[$sub_d] $words[2]";
            unset($tmp);
        }



    return $str;
}

/**
 *   Controller
 *
 */
class toolControllerdgf extends toolController
{

		// doc spr
		function getspr()
		{
		$row = JRequest::getVar('row',0); // id sdoc
		$sv = JRequest::getVar('sv',0); // id Sh
        $a=vardolg($row);
        $vs=array_shift($a);
        $s=explode(",",$vs);
// save	
		$contents=w_sh($sv);
		$fp = fopen("doc.html", "w+");
		// replace
		
		$contentr= str_replace($s,$a,$contents);

		fwrite($fp, $contentr);
		fclose($fp);
		$htmltodoc= new HTML_TO_DOC();
		$htmltodoc->createDoc("doc.html","doc");
		echo "";
		}


		// value table,row,field 
		function valtrf()
		{
			$table=JRequest::getVar('table','plan');
			$field=JRequest::getVar('field','name');
			$row=JRequest::getVar('row',1);			
            $db =& JFactory::getDBO();
		    $query = "SELECT ".$field." FROM  ".$table." where id=".$row.";";

            $db->setQuery( $query );
            $result = $db->loadRowList();
	      echo $result[0][0];
		}
		// manual combo
		function manual()
		{
			$table=JRequest::getVar('table','plan');
			$field=JRequest::getVar('field','name');
			$value=JRequest::getVar('value','');			
            $db =& JFactory::getDBO();
            $query = "SELECT id,".$field." FROM  ".$table.";";
          if($value>"")
		    $query='select id,'.$field.' FROM '.$table.' WHERE type="'.$value.'";';
	     $doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');

	     $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
            $return .= "<complete>\n";
            $db->setQuery( $query );
            $result = $db->loadRowList();
            for ($j=0, $m=count($result); $j < $m; $j++) {
                $return .= " <option value=\"".$result[$j][0]."\">".$result[$j][1]."</option>\n";
            }
            $return .= "</complete>\n";

	      echo $return;
		} 

			// enum
		function status()
		{
            $db =& JFactory::getDBO();

	     $doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
		$table=JRequest::getVar('table','plan');
		$field=JRequest::getVar('field','status');	
	     $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
            $return .= "<complete>\n";
			$sql="DESCRIBE ".$table." ".$field;
		$result=mysql_query($sql) or die(mysql_error());
		$records=mysql_num_rows($result);
		if($records){
		@$enum_ar=mysql_fetch_assoc($result);// получить запись в массив
		eval('$ar='.str_replace('enum','array',$enum_ar['Type']).';');
		}
		mysql_free_result($result);
		for ($i=0,$m=count($ar); $i < $m; $i++)
		{ 
 		$return .= " <option value=\"".$ar[$i]."\">".$ar[$i]."</option>\n" ;
		}
         
            $return .= "</complete>\n";

	      echo $return;
			}
		// периоды
        function gmon()
        { $db =& JFactory::getDBO();
 	     $doc =&JFactory::getDocument(); $doc->setMimeEncoding('text/xml');
         $n_mon= date("m");
		 $arr=array('-2'=>'ноябрь пр.г.','-1' => 'декабрь пр.г.',
		 '1' => 'январь','2' => 'февраль','3' =>'март','4' => 'апрель','5' => 'май','6' =>'июнь','7' => 'июль','8' => 'август','9' =>'сентябрь','10' => 'октябрь','11' => 'ноябрь','12' => 'декабрь'
			 );
	     $return = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
            $return .= "<complete>\n";
		foreach($arr as $field=>$v) {
			if ($field==$n_mon)
            $return .= " <option value=\"".$field."\" selected=\"1\" >".$v."</option>\n";
			else
			 $return .= " <option value=\"".$field."\">".$v."</option>\n";	}
            $return .= "</complete>\n";
 //mysql_query('insert into otl (dt,data) values (CURRENT_TIMESTAMP,"'.$return.'");');
            echo $return;
         }		
}