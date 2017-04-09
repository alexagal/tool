<?php defined('_JEXEC') or die('Restricted access');?>
<link rel="STYLESHEET" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">

<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/skins/dhtmlxtoolbar_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxcommon.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>

<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_combo.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_filter.js"</script>

<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_math.js"></script>

<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/dhtmlxtoolbar.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxMessage/dhtmlxmessage.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxMessage/skins/dhtmlxmessage_dhx_skyblue.css"
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxgrid_export.js"></script>
<script>window.dhx_globalImgPath="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/imgs/";</script>

 <div id="stbox" width="120px" style="display:none">
 <B>Загрузка данных</B>
  <img src="<?php echo JURI::base();?>images/aloader.gif">
 </div>
<form name=f1>

 <div id="sel" style="float:left;"><select  style="width:200px;" id="idm" name="idm"></select></div>&nbsp;

 <input type=button name=Submit value=OK onClick=javascript:setCondition();>
</form>
<div id="toolbarObj" style="width:940px;"></div>
<div id="gridbox" width="950px" height="450px"></div>

<script>
function setCondition() {
document.getElementById("stbox").style.display = "";
 mygrid.clearAll();
 
 mygrid.loadXML(cont+'iregl&task=getiregl&no_html=1&mon='+z.getActualValue(),zload);
 //,calcFooter);
}
function zload()
{ document.getElementById("stbox").style.display = "none"; }
dhtmlx.skin = "dhx_skyblue";
var toolbar = new dhtmlXToolbarObject("toolbarObj"),cont='<?php echo JURI::base();?>index.php?option=com_tool&controller=';

toolbar.setIconsPath("<?php echo JURI::base();?>images/");

toolbar.addButton("pdf", 2, "", "pdf.gif", "pdf.gif");
toolbar.setItemToolTip('pdf', 'экспорт в pdf');
toolbar.addButton("excel", 3, "", "excel.gif", "excel.gif");
toolbar.setItemToolTip('excel', 'экспорт в excel');
toolbar.addButton("del", 4, "", "list_accept.png", "list_accept.png");
toolbar.setItemToolTip('del', 'Закрытие строки');

toolbar.attachEvent("onClick", function(id) {
 if (id == 'excel') {
  mygrid.toExcel('<?php echo JURI::base();?>libraries/dhtmlx/generate/excel/generate.php', 'custom');
 }
 if (id == 'pdf') {
  mygrid.toPDF('<?php echo JURI::base();?>libraries/dhtmlx/generate/pdf/generate.php', 'custom', true);
 }
 if (id == 'del') {
  if(mygrid.getSelectedId())
  { var id_sel=mygrid.getSelectedId(),isp=mygrid.cells(id_sel,3).getValue(),kol=mygrid.cells(id_sel,4).getValue();
  var status=mygrid.cells(id_sel,5).getValue(),prim=mygrid.cells(id_sel,6).getValue(),loader,z;
  if(kol>0 && isp>0 && status>"")
  {loader=dhtmlxAjax.getSync(cont+'iregl&task=setiregl&no_html=1&idr='+id_sel+'&pers='+isp+'&kol='+kol+'&status='+status+'&prim='+prim);
     z=loader.xmlDoc.responseText;
     mygrid.deleteRow(id_sel);
  }
  else
  dhtmlx.message({ type:"error", text:"Заполните строку регламента!" });
  }
  else
  dhtmlx.message({ type:"error", text:"Выберите строку регламента!" }); 
 }
});
var mygrid = new dhtmlXGridObject('gridbox');
mygrid.imgURL = "<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/";

mygrid.setHeader("Дата,Регламент ,Компания,Исполнитель,Длит.(ч),Статус,Примечание");

mygrid.setInitWidths("110,*,100,100,70,70,150");

mygrid.setColAlign("left,left,left,left,right,left,left");
mygrid.setColTypes("ron,ron,ron,combo,ed,combo,ed");
mygrid.setColSorting("str,str,str,str,int,str,str");

mygrid.init();

var combo3=mygrid.getColumnCombo(3);//takes the column index

combo3.loadXML(cont+"plan&task=pers&no_html=1");
var combo5=mygrid.getColumnCombo(5);//takes the column index
//combo.load("data/combo.xml");
combo5.loadXML(cont+"plan&task=status&no_html=1&table=iregl");

zmygrid(0);

function my_error_handler(type, name, data) {
    if (type == "LoadXML");
    alert("My error handler \n" + name + "\n Status:" + data[0].status);
	alert("My error text \n"  + data[0].responseText);
}
dhtmlxError.catchError("LoadXML", my_error_handler);
dhtmlxError.catchError("DataStructure", my_error_handler);

var id_timeout;
function zmygrid(kod){
if (kod>0)
{clearTimeout(id_timeout);
  // запись изменений по строке z
 var dt = new Date,mon=dt.getMonth()+1;
mygrid.loadXML(cont+'iregl&task=getiregl&no_html=1&mon='+mon,zload);
}
else
id_timeout=setTimeout( function() { zmygrid(1) } ,300);
return 0;
}

var z = new dhtmlXCombo("idm"); 
z.loadXML(cont+"plan&task=gmon&no_html=1");
z.enableOptionAutoHeight(true,460);
//z.setComboText("Выберете период"); 

</script>