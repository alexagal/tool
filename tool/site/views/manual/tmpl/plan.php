<?php defined('_JEXEC') or die('Restricted access');?>

<link rel="STYLESHEET" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">

<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxcommon.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_srnd.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxTreeGrid/dhtmlxtreegrid.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_filter.js"</script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxTreeGrid/ext/dhtmlxtreegrid_filter.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_math.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCalendar/dhtmlxcalendar.js"></script>
<link rel="STYLESHEET" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCalendar/skins/dhtmlxcalendar_dhx_skyblue.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_dhxcalendar.js"></script>
<link rel="STYLESHEET" type="text/css" href="libraries/dhtmlx/dhtmlxCalendar/skins/dhtmlxcalendar_yahoolike.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxDataProcessor/dhtmlxdataprocessor.js"></script>

<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/dhtmlxtoolbar.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_combo.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/skins/dhtmlxtoolbar_dhx_skyblue.css"></link>

<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxgrid_export.js"></script>
<script>window.dhx_globalImgPath="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/imgs/";</script>

<div id="toolbarObj" style="width:940px;"></div>
<div id="gridbox" width="950px" height="450px"></div> 


<script>
dhtmlx.skin = "dhx_skyblue";

var dhxLayout, dt = new Date,day=dt.getDate(),mon=dt.getMonth()+1,Y=dt.getFullYear(),d_t,i;
if(day<10)
 i='0'+day+'.';
else
 i=day+'.';
 if(mon<10)
 d_t=i+'0'+mon+'.'+Y;
else
  d_t=i+mon+'.'+Y;

//window.onload = function() {
  
var   toolbar = new dhtmlXToolbarObject("toolbarObj"),cont='<?php echo JURI::base();?>index.php?option=com_tool&controller=';
var mygrid2 =  new dhtmlXGridObject('gridbox');

//mygrid2.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/");

mygrid2.imgURL = "<?php echo JURI::base();?>/libraries/dhtmlx/dhtmlxGrid/imgs/";
mygrid2.setHeader(["Код","Дата","Наименование","Клиент","Исполнитель","Срок дн.","Статус","Примечание"]);

//mygrid2.attachHeader(",#text_search");

mygrid2.setInitWidths("70,80,*,90,90,70,80,100");
mygrid2.setColAlign("left,left,left,left,left,left,left,left");
mygrid2.setColTypes("tree,dhxCalendar,ed,combo,combo,ed,combo,ed");
//mygrid2.attachEvent("onEditCell", doOnCellEdit);
//mygrid2.enableSmartRendering(1);
mygrid2.enableTreeCellEdit(false);
mygrid2.init();
var combo3=mygrid2.getColumnCombo(3);//takes the column index
//combo.load("data/combo.xml");
combo3.loadXML(cont+"plan&task=clients&no_html=1");
var combo4=mygrid2.getColumnCombo(4);//takes the column index
//combo.load("data/combo.xml");
combo4.loadXML(cont+"plan&task=pers&no_html=1");
var combo6=mygrid2.getColumnCombo(6);//takes the column index
//combo.load("data/combo.xml");
combo6.loadXML(cont+"plan&task=status&no_html=1");
mygrid2.enableMultiselect(false);

mygrid2.kidsXmlFile=cont+'plan&task=getplan&no_html=1';
 mygrid2.loadXML(cont+'plan&task=getplan&no_html=1');
 myDataProcessor2 = new dataProcessor(cont+'plan&task=setplan&no_html=1');
myDataProcessor2.setTransactionMode("POST", true); 
myDataProcessor2.init(mygrid2);

toolbar.setIconsPath("<?php echo JURI::base();?>components/com_ito/images/");
toolbar.addButton("pdf", 2, "", "pdf.gif", "pdf.gif");
toolbar.setItemToolTip('pdf', 'Запись в pdf');
toolbar.addButton("cadd", 3, "", "cadd.png", "cadd.png");
toolbar.setItemToolTip('cadd', 'Дублирование выделенной строки');
toolbar.addButton("add", 4, "", "add.gif", "add.gif");
toolbar.setItemToolTip('add', 'Добавить строку');
toolbar.addButton("child", 5, "", "child_plus.png", "child_plus.png");
toolbar.setItemToolTip('child', 'Добавить подстроку');
toolbar.addButton("del", 6, "", "delete.gif", "delete.gif");
toolbar.setItemToolTip('del', 'Удалить выделеные строки');
 
toolbar.attachEvent("onClick", function(id) {
 if (id == 'excel') {
  mygrid2.toExcel('<?php echo JURI::base();?>libraries/dhtmlx/generate/excel/generate.php');
 }

 if (id == 'pdf') {
  mygrid2.toPDF('<?php echo JURI::base();?>libraries/dhtmlx/generate/pdf/generate.php');
 }
 if (id == 'del') {
  if(confirm('Удаление выделеного узла?'))
{ 
//mygrid2.deleteChildItems(mygrid2.getSelectedId()); 
mygrid2.deleteSelectedRows();
}
 }
  if (id == 'cadd') {
 
var z=mygrid2.getSelectedId(),arr,len,nn,idn=(new Date()).valueOf(); 
if (z)
{arr = z.split('_');

len=arr.length;
if(len==1)
 mygrid2.addRow(idn,['new '],0);
 else
 {arr.length=len-1;
 nn=arr.join('_');

 mygrid2.addRow(idn,['new '],0,nn);
 }
 mygrid2.copyRowContent(z,idn);
 }
else
	alert("Выберите запись!");
 }
  if (id == 'add') {
 
//arr = str.split('_');
//arr.join('_');
// arr.length=3 укорачивание массива
//Add new row at child of node at position
//var z=mygrid.getRowId(this.nextSibling.value); 
//if (z) mygrid.addRow((new Date()).valueOf(),['new row','text','text',1,1],0,z);
//Add new row as child of selected
// z=mygrid.getSelectedId(); if (z) mygrid.addRow((new Date()).valueOf(),['new row','text','text',1,1],0,z);

var z=mygrid2.getSelectedId(),arr,len,nn,dd; 
if (z)
{arr = z.split('_');
dd=mygrid2.cells(z,1).getValue();

len=arr.length;
if(len==1)
 mygrid2.addRow((new Date()).valueOf(),['new ',dd,'',0,0,7,'план'],0);
 else
 {arr.length=len-1;
 nn=arr.join('_');

 mygrid2.addRow((new Date()).valueOf(),['new ',dd,'',0,0,7,'план'],0,nn);
 }
 }
else
mygrid2.addRow((new Date()).valueOf(),['new ',d_t,'',0,0,7,'план'],0);
 }
 if (id == 'child') {
 
var z=mygrid2.getSelectedId(),dd; 

if (z)
{ dd=mygrid2.cells(z,1).getValue();

mygrid2.addRow((new Date()).valueOf(),['new ',dd,'',0,0,7,'план'],0,z);
if(!mygrid2.getOpenState(z)) mygrid2.openItem(z);
}
else
mygrid2.addRow((new Date()).valueOf(),['new ',d_t,'',0,0,7,'план'],0);
 }
});

function my_error_handler(type, name, data) {
    if (type == "LoadXML");
    alert("My error handler \n" + name + "\n Status:" + data[0].status);
	alert("My error text \n"  + data[0].responseText);
}
dhtmlxError.catchError("LoadXML", my_error_handler);
dhtmlxError.catchError("DataStructure", my_error_handler);

</script> 