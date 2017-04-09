<?php defined('_JEXEC') or die('Restricted access');?>
<link rel="STYLESHEET" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.css">
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxcommon.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_filter.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCalendar/dhtmlxcalendar.js"></script>

<script src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxDataProcessor/dhtmlxdataprocessor.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/dhtmlxtoolbar.js"></script>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxGrid/excells/dhtmlxgrid_excell_combo.js"></script>

<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxCombo/dhtmlxcombo.js"></script>
<link rel="STYLESHEET" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxTree/dhtmlxtree.css"></link>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxTree/dhtmlxtree.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxToolbar/skins/dhtmlxtoolbar_dhx_skyblue.css"></link>
<script type="text/javascript" src="<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxgrid_export.js"></script>


<table>
    <tr>
        <td> <div id="toolbartree" style="width:810px;"></div>
        </td>
    </tr>
    <tr>
        <td>
            <div id="treebox" style="width:860px;height:600px" ></div>
        </td>
    </tr>
</table>

<script>
var dt = new Date,ov,dv,mygrid2,myDataProcessor2,z1,loc=0,cont='<?php echo JURI::base();?>index.php?option=com_tool&controller=';

var toolbart = new dhtmlXToolbarObject("toolbartree");
dhtmlx.skin = "dhx_skyblue";
toolbart.setIconsPath("<?php echo JURI::base();?>images/");
toolbart.addText("spacer", 1, "КЛАДР");
toolbart.addSpacer("spacer");
toolbart.addButton("loc", 2, "", "add.gif", "add.gif");
toolbart.setItemToolTip('loc', 'Добавить в STREET');

toolbart.attachEvent("onClick", function(id) {

if (id == 'loc') {
 if (tr.getSelectedItemId()) 
 {
 var z,tText,zid;
 z1='1';
 z=tr.getSelectedItemId();
 
 zid=tr.getSelectedItemId();
 tText=tr.getItemText(z); 
 
 while (tr.getParentId(z)>"0")
   { 
    z= tr.getParentId(z);
    tText=tr.getItemText(z)+","+tText;
   }
 
var zz,loader=dhtmlxAjax.getSync(cont+'klstreet&task=insstreet&no_html=1&no_html=1&pcid='+zid+'&ptext='+tText);
zz=loader.xmlDoc.responseText;
 if(zz>"")
 alert(zz);
 }
else
alert("Выберите объект!");
}
});

var tr = new dhtmlXTreeObject("treebox", "100%", "100%", 0);

//tr.deleteChildItems(0);
tr.setSkin('dhx_skyblue');

tr.setImagePath("<?php echo JURI::base();?>libraries/dhtmlx/dhtmlxTree/imgs/csh_dhx_skyblue/");
tr.setXMLAutoLoading(cont+'klstreet&task=gettree&no_html=1');

tr.loadXML(cont+'klstreet&task=gettree&no_html=1');


function my_error_handler(type, name, data) {
    if (type == "LoadXML");
    alert("My error handler \n" + name + "\n Status:" + data[0].status);
	alert("My error text \n"  + data[0].responseText);
}
dhtmlxError.catchError("LoadXML", my_error_handler);
dhtmlxError.catchError("DataStructure", my_error_handler);

</script> 