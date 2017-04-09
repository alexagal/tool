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
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_drag.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxDataProcessor/dhtmlxdataprocessor.js"></script>

<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/dhtmlxtoolbar.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_combo.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/skins/dhtmlxtoolbar_dhx_skyblue.css"></link>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxMessage/dhtmlxmessage.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxMessage/skins/dhtmlxmessage_dhx_skyblue.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxLayout/dhtmlxlayout.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxLayout/dhtmlxcontainer.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxLayout/dhtmlxlayout.css">
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxgrid_export.js"></script>
<script>window.dhx_globalImgPath="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/imgs/";</script>

 
<div id="parentId" style="position: relative; width: 870px; height: 570px; aborder: #B5CDE4 1px solid;"></div>

<script>
dhtmlx.skin = "dhx_skyblue";

var dhxLayout,type='date',contr="<?php echo JURI::base();?>index.php?option=com_tool&controller=sq&task=";

//window.onload = function() {
    var dhxLayout = new dhtmlXLayoutObject("parentId", "2E", "dhx_skyblue");
    dhxLayout.cells("a").hideHeader();
    dhxLayout.cells("a").setHeight(470);
    dhxLayout.cells("b").hideHeader();
    dhxLayout.cells("b").setHeight(100);


var   toolbar = dhxLayout.cells("a").attachToolbar();
var mygrid2 = dhxLayout.cells("a").attachGrid();

mygrid2.imgURL = "<?php echo JURI::base();?>/libraries/dhtmlx/dhtmlxGrid/imgs/";

mygrid2.setHeader(["Код","Наименование","Значение SQL","Параметры"]);

//mygrid2.attachHeader(",#text_search");

mygrid2.setInitWidths("90,150,*,150");
mygrid2.setColAlign("left,left,left,left");
mygrid2.setColTypes("tree,ed,txt,ed");
//mygrid2.attachEvent("onEditCell", doOnCellEdit);
//mygrid2.enableSmartRendering(1);
mygrid2.enableTreeCellEdit(false);
mygrid2.init();
mygrid2.enableMultiselect(false);

 
mygrid2.kidsXmlFile=contr+'getsq&no_html=1';
 mygrid2.loadXML(contr+'getsq&no_html=1');
 myDataProcessor2 = new dataProcessor(contr+'setsq&no_html=1');
myDataProcessor2.setTransactionMode("POST", true); 
myDataProcessor2.init(mygrid2);
mygrid2.setColumnHidden(3,true);


toolbar.setIconsPath("<?php echo JURI::base();?>images/");

toolbar.addButton("pdf", 2, "", "pdf.gif", "pdf.gif");
toolbar.setItemToolTip('pdf', 'Запись в pdf');
toolbar.addButton("excel", 3, "", "excel.gif", "excel.gif");
toolbar.setItemToolTip('excel', 'Запись в excel');
toolbar.addButton("cadd", 4, "", "cadd.png", "cadd.png");
toolbar.setItemToolTip('cadd', 'Дублирование выделенной строки');
toolbar.addButton("add", 5, "", "add.gif", "add.gif");
toolbar.setItemToolTip('add', 'Добавить строку');
toolbar.addButton("child", 6, "",  "child_plus.png", "child_plus.png");
toolbar.setItemToolTip('child', 'Добавить подстроку');
toolbar.addButton("del", 7, "", "delete.gif", "delete.gif");
toolbar.setItemToolTip('del', 'Удалить выделеные строки');
toolbar.addButton("move", 8, "", "tree_move.png", "tree_move.png");
toolbar.setItemToolTip('move', 'Перемещение');
toolbar.addButton("rekv", 9, "", "comment_new.gif", "comment_delete.gif");
toolbar.setItemToolTip('rekv', 'Параметры запроса');
toolbar.addButton("run", 10, "", "run.gif", "run.gif");
toolbar.setItemToolTip('run', 'Выполнение запроса');
toolbar.addButton("process", 11, "", "process_grin.png", "process_grin.png");
toolbar.setItemToolTip('process', 'Цепь запросов');
toolbar.attachEvent("onClick", function(id) {
 if (id == 'excel') {
  mygrid2.toExcel('<?php echo JURI::base();?>libraries/dhtmlx/generate/excel/generate.php');
 }
 if (id == 'rekv') {
 if(mygrid2.isColumnHidden(3))
 {mygrid2.setColumnHidden(3,false);
 }
 else
 {mygrid2.setColumnHidden(3,true);
 }
} 
 if (id == 'run') {
 if (mygrid2.getSelectedId()){
  var t;
  t=mygrid2.getSelectedId();
  if(mygrid2.cells(t,2).getValue()>" ")
  {var arr= t.split('_'),len=arr.length;
  id_sel=arr[len-1];
  mygridp =dhxLayout.cells("b").attachGrid();
mygridp.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/");
mygridp.enableMultiselect(true);
mygridp.init();

mygridp.loadXML(contr+'sqex&no_html=1&sq='+id_sel,function(){ mygridp.setSizes()});

dhxLayout.cells("b").expand();
dhxLayout.cells("a").collapse();
}
else
dhtmlx.message({ type:"error", text:"Выбран узел!" });
  }
  else
  dhtmlx.message({ type:"error", text:"Выберите запрос!" });
 }
 if (id == 'process') {
 if (mygrid2.getSelectedId()){
  var t;
  t=mygrid2.getSelectedId();
  var arr= t.split('_'),len=arr.length;
  id_sel=arr[len-1];
  mygridp =dhxLayout.cells("b").attachGrid();
mygridp.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/");
mygridp.enableMultiselect(true);
mygridp.init();

mygridp.loadXML(contr+'sqexg&no_html=1&sq='+id_sel,function(){ mygridp.setSizes()});

dhxLayout.cells("b").expand();
dhxLayout.cells("a").collapse();
  }
  else
  dhtmlx.message({ type:"error", text:"Выберите запрос!" });
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
  if (id == 'add') {
 
//arr = str.split('_');
//arr.join('_');
// arr.length=3 укорачивание массива
//Add new row at child of node at position
//var z=mygrid.getRowId(this.nextSibling.value); 
//if (z) mygrid.addRow((new Date()).valueOf(),['new row','text','text',1,1],0,z);
//Add new row as child of selected
// z=mygrid.getSelectedId(); if (z) mygrid.addRow((new Date()).valueOf(),['new row','text','text',1,1],0,z);

var z=mygrid2.getSelectedId(),arr,len,nn; 
if (z)
{arr = z.split('_');

len=arr.length;
if(len==1)
 mygrid2.addRow((new Date()).valueOf(),['new ','name',''],0);
 else
 {arr.length=len-1;
 nn=arr.join('_');

 mygrid2.addRow((new Date()).valueOf(),['new ','name',''],0,nn);
 }
 }
else
mygrid2.addRow((new Date()).valueOf(),['new ','name',''],0);
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
	dhtmlx.message({ type:"error", text:"Выберите запись!" });
 } 
 if (id == 'child') {
 
var z=mygrid2.getSelectedId(); 

if (z)
{ mygrid2.addRow((new Date()).valueOf(),['new ','name',''],0,z);
if(!mygrid2.getOpenState(z)) mygrid2.openItem(z);
}
else
mygrid2.addRow((new Date()).valueOf(),['new ','name',''],0);
 }
 if (id == 'move') {
 if(type=='date')
 {type='move';
 toolbar.hideItem("child");
 toolbar.hideItem("del");
 toolbar.hideItem("cadd");
 toolbar.hideItem("add");
 toolbar.hideItem("rekv");
 toolbar.hideItem("run");
 toolbar.hideItem("process");
toolbar.setItemToolTip('move', 'Ввод данных');
 mygridd = dhxLayout.cells("a").attachGrid();


mygridd.imgURL = "<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/";
mygridd.setHeader(["Код","Наименование","Значение SQL"]);

mygridd.setInitWidths("90,*,300");
mygridd.setColAlign("left,left,left");
mygridd.setColTypes("tree,ro,ro");

mygridd.enableTreeCellEdit(false);
mygridd.enableDragAndDrop(true);
mygridd.init();
mygridd.enableMultiselect(false);
mygridd.attachEvent("onDrop", drop);
mygridd.kidsXmlFile=contr+'getsq&no_html=1';
mygridd.loadXML(contr+'getsq&no_html=1');
 }
 else
 {type='date';
 toolbar.showItem("child");
 toolbar.showItem("del");
 toolbar.showItem("cadd");
 toolbar.showItem("add");
 toolbar.showItem("rekv");
 toolbar.showItem("run");
 toolbar.showItem("process");
 mygrid2 = dhxLayout.cells("a").attachGrid();
 toolbar.setItemToolTip('move', 'Перемещение');

mygrid2.imgURL = "<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/";
mygrid2.setHeader(["Код","Наименование","Значение SQL","Параметры"]);

mygrid2.setInitWidths("90,150,*,150");
mygrid2.setColAlign("left,left,left,left");
mygrid2.setColTypes("tree,ed,txt,ed");

mygrid2.enableTreeCellEdit(false);
mygrid2.init();
mygrid2.enableMultiselect(false);
 
mygrid2.kidsXmlFile=contr+'getsq&no_html=1';
mygrid2.loadXML(contr+'getsq&no_html=1');
myDataProcessor2 = new dataProcessor(contr+'setsq&no_html=1');
myDataProcessor2.setTransactionMode("POST", true); 
myDataProcessor2.init(mygrid2);
mygrid2.setColumnHidden(3,true);
 }
 }
});
function drop(r1,r2){
// alert("1="+r1+"_2="+r2);
var l=dhtmlxAjax.getSync(contr+'move&no_html=1&r1='+r1+'&r2='+r2);

return true;
}
function my_error_handler(type, name, data) {
    if (type == "LoadXML");
    alert("My error handler \n" + name + "\n Status:" + data[0].status);
	alert("My error text \n"  + data[0].responseText);
}
dhtmlxError.catchError("LoadXML", my_error_handler);
dhtmlxError.catchError("DataStructure", my_error_handler);
/*
				var z=new Array();
				for (var i=0; i<sgrid.hdr.rows[0].cells.length; i++)
					z[i+1]=sgrid.cells(rowId,i).getValue();
*/
var toolbarp = dhxLayout.cells("b").attachToolbar();

toolbarp.setIconsPath("<?php echo JURI::base();?>images/");
toolbarp.addText("spacer", 1,"Результат запроса");
toolbarp.addSpacer("spacer");
toolbarp.addButton("back", 2, "", "back.png", "back.png");
toolbarp.setItemToolTip('back', 'Возврат');
toolbarp.addButton("excel", 3, "", "excel.gif", "excel.gif");
toolbarp.setItemToolTip('excel', 'Запись в excel');

toolbarp.attachEvent("onClick", function(id) {

if (id == 'excel') {
  mygridp.toExcel('<?php echo JURI::base();?>libraries/dhtmlx/generate/excel/generate.php');
 }
if (id == 'back') {
dhxLayout.cells("a").expand();

dhxLayout.cells("b").collapse();
}
});
dhxLayout.cells("b").collapse();
</script> 