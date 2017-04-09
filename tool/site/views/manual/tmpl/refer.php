<?php defined('_JEXEC') or die('Restricted access');?>
<link rel="STYLESHEET" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">

<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_kladr.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxcommon.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_filter.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxTabbar/dhtmlxtabbar.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxTabbar/dhtmlxtabbar.js"></script>

<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCalendar/dhtmlxcalendar.js"></script>
<link rel="STYLESHEET" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCalendar/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_dhxcalendar.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_kladr.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxDataProcessor/dhtmlxdataprocessor.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/dhtmlxtoolbar.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_combo.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/ext/dhtmlxcombo_extra.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/ext/dhtmlxcombo_whp.js"></script>
<link rel="STYLESHEET" type="text/css" href="libraries/dhtmlx/dhtmlxCalendar/skins/dhtmlxcalendar_yahoolike.css"></link>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxLayout/dhtmlxlayout.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxLayout/dhtmlxcontainer.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxLayout/dhtmlxlayout.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxLayout/skin/dhtmlxlayout_dhx_skyblue.css">

<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/skins/dhtmlxtoolbar_dhx_skyblue.css"></link>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxgrid_export.js"></script>
<script>window.dhx_globalImgPath="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/imgs/";</script>
 <div id="a_space" style="position: relative; width:950px; height:50px;"></div>
<div id="a_tabbar" style="position: relative; width:950px; height:510px;"></div>
<script>

var tabbar = new dhtmlXTabBar("a_tabbar", "top"),cont='<?php echo JURI::base();?>index.php?option=com_tool&controller=';
tabbar.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxTabbar/imgs/");
tabbar.setSkin('dhx_skyblue'); // dhx_terrace dhx_skyblue dhx_black  modern
tabbar.addTab("a3", "Исполнители", "130px");
tabbar.addTab("a4", "Должности", "130px");
tabbar.addTab("a5", "Типы контрагентов", "130px");
tabbar.addTab("a7", "Компании", "130px");
tabbar.setTabActive("a3");

</script>

<script>
//------avto
dhtmlx.skin = "dhx_skyblue";

 var myL3 = tabbar.cells("a3").attachLayout("2E");
   myL3.cells("a").hideHeader();
   myL3.cells("a").setHeight(20);
   myL3.cells("b").hideHeader();
   myL3.cells("b").setHeight(490); 

 var myL4 = tabbar.cells("a4").attachLayout("2E");
   myL4.cells("a").hideHeader();
   myL4.cells("a").setHeight(20);
   myL4.cells("b").hideHeader();
   myL4.cells("b").setHeight(490); 
 var myL5 = tabbar.cells("a5").attachLayout("2E");
   myL5.cells("a").hideHeader();
   myL5.cells("a").setHeight(20);
   myL5.cells("b").hideHeader();
   myL5.cells("b").setHeight(490);  

 var myL7 = tabbar.cells("a7").attachLayout("2U");
   myL7.cells("a").hideHeader();
   myL7.cells("a").setHeight(20);;
   myL7.cells("b").hideHeader();
   myL7.cells("b").setHeight(490);;    

//------ispol

var toolbar3 = myL3.cells("a").attachToolbar();

toolbar3.setIconsPath("<?php echo JURI::base();?>images/");

toolbar3.addButton("add", 4, "", "add.gif", "add.gif");
toolbar3.setItemToolTip('add', 'Добавить строку');
toolbar3.addButton("del", 5, "", "delete.gif", "delete.gif");
toolbar3.setItemToolTip('del', 'Удалить выделеные строки');
toolbar3.attachEvent("onClick", function(id) {
if (id == 'del') {
if(confirm('Удалить выделенные строки?')) mygrid3.deleteSelectedRows();
}
if (id == 'add') {
mygrid3.addRow((new Date()).valueOf(), ["",], "0");
}
});

mygrid3 = myL3.cells("b").attachGrid();
mygrid3.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/");
mygrid3.enableMultiselect(true);
mygrid3.init(); 

 mygrid3.loadXML(cont+'pers&task=getpers&no_html=1',function(){ mygrid3.setSizes()});
myDataProcessor3 = new dataProcessor(cont+'pers&task=setpers&no_html=1');
myDataProcessor3.setTransactionMode("POST", true);
myDataProcessor3.init(mygrid3);  

//------jobs

var toolbar5 = myL5.cells("a").attachToolbar();;

toolbar5.setIconsPath("<?php echo JURI::base();?>images/");

toolbar5.addButton("add", 4, "", "add.gif", "add.gif");
toolbar5.setItemToolTip('add', 'Добавить строку');
toolbar5.addButton("del", 5, "", "delete.gif", "delete.gif");
toolbar5.setItemToolTip('del', 'Удалить выделеные строки');
 
toolbar5.attachEvent("onclick", function(id) {
 if (id == 'excel') {
  mygrid5.toExcel('<?php echo JURI::base();?>libraries/dhtmlx/generate/excel/generate.php');
 }
 if (id == 'pdf') {
  mygrid5.toPDF('<?php echo JURI::base();?>libraries/dhtmlx/generate/pdf/generate.php');
 }
 if (id == 'del') {
  if(confirm('Удаление выделеных строк?')) mygrid5.deleteSelectedRows();
 }
 if (id == 'add') {
  mygrid5.addRow((new Date()).valueOf(), [""], "0");
 }
});
mygrid5 = myL5.cells("b").attachGrid();
mygrid5.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/");
mygrid5.setHeader("Тип,Наименование");
mygrid5.setInitWidths("100,*");
mygrid5.setColAlign("left,left");
mygrid5.setColTypes("ed,ed");
mygrid5.setColSorting("str,str");
mygrid5.enableMultiselect(true);
mygrid5.init();

mygrid5.loadXML(cont+'clienttypes&task=getClienttypes&no_html=1');

myDataProcessor5 = new dataProcessor(cont+'clienttypes&task=setClienttypes&no_html=1');

myDataProcessor5.setTransactionMode("POST", true);
myDataProcessor5.init(mygrid5);

var toolbar4 = myL4.cells("a").attachToolbar();;

toolbar4.setIconsPath("<?php echo JURI::base();?>images/");

toolbar4.addButton("add", 4, "", "add.gif", "add.gif");
toolbar4.setItemToolTip('add', 'Добавить строку');
toolbar4.addButton("del", 5, "", "delete.gif", "delete.gif");
toolbar4.setItemToolTip('del', 'Удалить выделеные строки');
 
toolbar4.attachEvent("onclick", function(id) {
 if (id == 'excel') {
  mygrid4.toExcel('<?php echo JURI::base();?>libraries/dhtmlx/generate/excel/generate.php');
 }
 if (id == 'pdf') {
  mygrid4.toPDF('<?php echo JURI::base();?>libraries/dhtmlx/generate/pdf/generate.php');
 }
 if (id == 'del') {
  if(confirm('Удаление выделеных строк?')) mygrid4.deleteSelectedRows();
 }
 if (id == 'add') {
  mygrid4.addRow((new Date()).valueOf(), [""], "0");
 }
});
mygrid4 = myL4.cells("b").attachGrid();
mygrid4.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/");
mygrid4.setHeader("Код,Наименование");
mygrid4.setInitWidths("30,*");
mygrid4.setColAlign("left,left");
mygrid4.setColTypes("ro,ed");
mygrid4.setColSorting("str,str");
mygrid4.enableMultiselect(true);
mygrid4.init();

mygrid4.loadXML(cont+'job&task=getjob&no_html=1');
myDataProcessor4 = new dataProcessor(cont+'job&task=setjob&no_html=1');
myDataProcessor4.setTransactionMode("POST", true);
myDataProcessor4.init(mygrid4);



var toolbar7 = myL7.cells("a").attachToolbar();;

toolbar7.setIconsPath("<?php echo JURI::base();?>images/");
toolbar7.addButton("rekv", 3, "", "comment_new.gif", "comment_delete.gif");
toolbar7.setItemToolTip('rekv', 'отобразить реквизиты'); 
toolbar7.addButton("add", 4, "", "add.gif", "add.gif");
toolbar7.setItemToolTip('add', 'Добавить строку');
toolbar7.addButton("del", 5, "", "delete.gif", "delete.gif");
toolbar7.setItemToolTip('del', 'Удалить выделеные строки');
 
toolbar7.attachEvent("onclick", function(id) {
 if (id == 'excel') {
  mygrid7.toExcel('<?php echo JURI::base();?>libraries/dhtmlx/generate/excel/generate.php');
 }
 if (id == 'pdf') {
  mygrid7.toPDF('<?php echo JURI::base();?>libraries/dhtmlx/generate/pdf/generate.php');
 }
 if (id == 'del') {
  if(confirm('Удаление выделеных строк?')) mygrid7.deleteSelectedRows();
 }
 if (id == 'add') {
  mygrid7.addRow((new Date()).valueOf(), [""], "0");
 }
   if (id == 'rekv') {
  
	mygridp = myL7.cells("b").attachGrid();
	mygridp.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/");

	mygridp.loadXML(cont+'company&task=getcompany&no_html=1');
	
	mygridp.init();
	myDataProcessorp = new dataProcessor(cont+'company&task=putcompany&no_html=1&dopr=1');
	myDataProcessorp.setTransactionMode("POST", true);
	myDataProcessorp.init(mygridp);
	mygridp.setColumnHidden(7,true);
mygridp.setColumnHidden(8,true);
mygridp.setColumnHidden(9,true);
mygridp.setColumnHidden(10,true);
	myL7.cells("b").expand();
	myL7.cells("a").collapse();
   
  }
});
 toolbarp = myL7.cells("b").attachToolbar();

    toolbarp.setIconsPath("<?php echo JURI::base();?>images/");

	toolbarp.addButton("back", 2, "", "back.png", "back.png");
    toolbarp.setItemToolTip('back', 'Возврат');
 toolbarp.addButton("rekv", 5, "", "comment_new.gif", "comment_delete.gif");
 toolbarp.setItemToolTip('rekv', 'отобразить реквизиты');
    toolbarp.attachEvent("onClick", function(id) {
    if (id == 'back') {
     myL7.cells("a").expand();
     myL7.cells("b").collapse();

     }

 if (id == 'rekv') {
 if(mygridp.isColumnHidden(3))
{ mygridp.setColumnHidden(3,false);
  mygridp.setColumnHidden(4,false);
   mygridp.setColumnHidden(5,false);
    mygridp.setColumnHidden(6,false);
mygridp.setColumnHidden(7,true);
mygridp.setColumnHidden(8,true);
mygridp.setColumnHidden(9,true);
mygridp.setColumnHidden(10,true);}	
 else
{ mygridp.setColumnHidden(3,true);
  mygridp.setColumnHidden(4,true);
   mygridp.setColumnHidden(5,true);
    mygridp.setColumnHidden(6,true);
mygridp.setColumnHidden(7,false);
mygridp.setColumnHidden(8,false);
mygridp.setColumnHidden(9,false);
mygridp.setColumnHidden(10,false);}	
}

 }) 
	
mygrid7 = myL7.cells("a").attachGrid();
mygrid7.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/imgs/");
mygrid7.enableMultiselect(true);
mygrid7.init();

 mygrid7.loadXML(cont+'company&task=getCitycompany&no_html=1&a_dhx_rSeed='+(new Date()).valueOf());
 myDataProcessor7 = new dataProcessor(cont+'company&task=putcompany&no_html=1');
myDataProcessor7.setTransactionMode("POST", true);
myDataProcessor7.init(mygrid7);  
   myL7.cells("a").expand();
   myL7.cells("b").collapse();

function my_error_handler(type, name, data) {
    if (type == "LoadXML");
    alert("My error handler \n" + name + "\n Status:" + data[0].status);
	alert("My error text \n"  + data[0].responseText);
}
dhtmlxError.catchError("LoadXML", my_error_handler);
dhtmlxError.catchError("DataStructure", my_error_handler);

</script> 
