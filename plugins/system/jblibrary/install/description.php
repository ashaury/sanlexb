<?php
/**
* @id			$Id$
* @author 		Joomla Bamboo
* @package  	JB Library
* @copyright 	Copyright (C) 2006 - 2010 Joomla Bamboo. http://www.joomlabamboo.com  All rights reserved.
* @license  	GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/
//we need to import the jomla framework since we are operating outside of it
define( 'DS', DIRECTORY_SEPARATOR );
//where we are
$current_dir = dirname(__FILE__);
//we know the path from root so we remove it to get the root
$base_folder = str_replace('\plugins\system\jblibrary\install','',str_replace('/plugins/system/jblibrary/install','',$current_dir));
define( '_JEXEC', 1 );
define( 'JPATH_BASE', $base_folder );
require_once( JPATH_BASE.DS.'includes'.DS.'defines.php' );
require_once( JPATH_BASE.DS.'includes'.DS.'framework.php' );
require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
$mainframe =& JFactory::getApplication('administrator');
$mainframe->initialise();
$baseurl = str_replace('\plugins\system\jblibrary\install','',str_replace('/plugins/system/jblibrary/install','',JURI::root())); 
$baseurl = rtrim($baseurl, '/');
$baseurl = $baseurl.'/';
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<script type="text/javascript" src="../js/ajax.js"></script>
<script language="javascript" type="text/javascript">
	function finishInstallation(){	
		//Ask user if the want to continue
		//var really = confirm("Set Defaults and Activate the Plugin?");
		//if (really){
			updateDatabase('<?php echo $baseurl; ?>');
		//}
	}
	function show(){
		var my_str = window.content.location.href
		var str = "http://";
		//if we were unable to obtain the location don't show
		if(my_str.search(str)==-1){
			document.getElementById('hideshow').style.visibility = 'hidden';
		}
		var str = "com_plugins";
		if(my_str.search(str)==-1){
			document.getElementById('hideshow').style.visibility = 'show';
		}
		else{
			document.getElementById('hideshow').style.visibility = 'hidden';
		}
	}
</script>
<style type="text/css">
.logo, a.logo { float: left; border:none; text-decoration: none; margin-top: 0px; margin-right: 10px; margin-bottom: 10px; margin-left: 0px; }
.desc { font-family: Arial, Helvetica, sans-serif; }
.smdesc { color:#333333; font-size: 14px; font-family: Arial, Helvetica, sans-serif; margin-bottom: 10px; }
.mimicadmin { float:left; margin-left:15px; background-image: url(../images/j_button2_left.png); background-repeat: no-repeat; background-position: 0 0; display: block; text-align: center; vertical-align: middle; }
.mimicadmin .blank { background-image: url(../images/j_button2_right_cap.png); background-repeat: no-repeat; background-position: 100% 0; display: block; }
.mimicadmin a, .mimicadmin span { color:#333333; cursor:pointer; display:block; font-size:12px; height:22px; line-height:22px; font-family: Arial, Helvetica, sans-serif; text-decoration: none; margin-right: 6px; margin-left: 6px; }
.mimicadmin .blank a:hover span { color: #4D7502; }
.logobox { float: left; }
#buttonbox { clear: both; float: left; border-top-width: thick; border-top-style: solid; border-top-color: #4D7502; margin-top: 10px; padding-top: 10px; }
.success { font-family: Arial, Helvetica, sans-serif; color: #4D7502; font-size: 14px; }
.fail { font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #930000; }
</style>
<div class="logobox">
    <div class="logo"> <a href="http://www.joomlabamboo.com" target="_new"><img src="http://www.joomlabamboo.com/images/icons/JBLibrary.png" alt="joomla Bamboo" border="0" /></a> </div>
    <div class="desc">JB Library is a plugin used for Joomlabamboo templates and extensions. The plugin controls the loading of javascript libraries and also handles image processing for our gallery and content extensions.</div>
</div>
<div id="hideshow">
<div id="buttonbox">
    <div class="smdesc">Click the finish Installation button to activate plugin and set default data. </div>
    <div class="mimicadmin">
        <div class="blank"> <a href="#" onClick="finishInstallation()"><span>Finish Installation</span></a> </div>
    </div>
</div>
<script language="javascript" type="text/javascript">	
	window.onload=show();
</script> 
