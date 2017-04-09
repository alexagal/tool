<?php defined('_JEXEC') or die('Restricted access');?>
<link rel="STYLESHEET" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<link rel="STYLESHEET" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCalendar/dhtmlxCalendar.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxcommon.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCalendar/dhtmlxcalendar.js"></script>

<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_srnd.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_filter.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<link rel="STYLESHEET" type="text/css" href="libraries/dhtmlx/dhtmlxCalendar/skins/dhtmlxcalendar_yahoolike.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_dhxcalendar.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxDataProcessor/dhtmlxdataprocessor.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/dhtmlxtoolbar.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_grw.css">
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_grw.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_combo.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/ext/dhtmlxcombo_extra.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/ext/dhtmlxcombo_whp.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/skins/dhtmlxtoolbar_dhx_skyblue.css"></link>

<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxgrid_export.js"></script>
<script>window.dhx_globalImgPath="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/imgs/";</script>
 
<div id="toolbarObj" style="width:940px;"></div>
<script>
dhtmlx.skin = "dhx_skyblue";

var cont="<?php echo JURI::base();?>index.php?option=com_tool&controller=";
var toolbar = new dhtmlXToolbarObject("toolbarObj");
toolbar.setSkin("dhx_web");
toolbar.setIconsPath("<?php echo JURI::base();?>images/");
toolbar.addText("spacer", 1, "Регламенты");
toolbar.addSpacer("spacer");
//toolbar.addButton("pdf", 2, "", "pdf.gif", "pdf.gif");
//toolbar.setItemToolTip('pdf', 'Запись в pdf');
//toolbar.addButton("excel", 3, "", "excel.gif", "excel.gif");
//toolbar.setItemToolTip('excel', 'Запись в excel');
toolbar.addButton("add", 4, "", "add.gif", "add.gif");
toolbar.setItemToolTip('add', 'Добавить строку');
toolbar.addButton("del", 5, "", "delete.gif", "delete.gif");
toolbar.setItemToolTip('del', 'Удалить выделеные строки');
 
toolbar.attachEvent("onclick", function(id) {
 if (id == 'excel') {
  mygrid2.toExcel('<?php echo JURI::base();?>libraries/dhtmlx/generate/excel/generate.php');
 }
 if (id == 'pdf') {
  mygrid2.toPDF('<?php echo JURI::base();?>libraries/dhtmlx/generate/pdf/generate.php');
 }
 if (id == 'del') {
  if(confirm('Удаление выделеных строк?')) mygrid2.deleteSelectedRows();
 }
 if (id == 'add') {
  mygrid2.addRow((new Date()).valueOf(), [""], "0");
 }
});
</script>
 
<div align=left id="gridbox2" style="width:950px;height:450px"></div>
<script>
function my_error_handler(type, name, data) {
    if (type == "LoadXML");
    alert("My error handler \n" + name + "\n Status:" + data[0].status);
	alert("My error text \n"  + data[0].responseText);
}
dhtmlxError.catchError("LoadXML", my_error_handler);
dhtmlxError.catchError("DataStructure", my_error_handler);

mygrid2 = new dhtmlXGridObject('gridbox2');
mygrid2.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/");
 

mygrid2.enableMultiselect(true);
mygrid2.init();
mygrid2.setSkin("dhx_skyblue");
mygrid2.enableSmartRendering(true, 50);
mygrid2.loadXML(cont+'regl&task=getregl&no_html=1');
 
 
myDataProcessor2 = new dataProcessor(cont+'regl&task=setregl&no_html=1');
myDataProcessor2.setTransactionMode("POST", true);

myDataProcessor2.init(mygrid2); 
</script> 