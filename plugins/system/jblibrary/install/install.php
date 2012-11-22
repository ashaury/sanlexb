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
// no direct access
defined('_JEXEC') or die('Restricted access');
	$database = & JFactory::getDBO();
	// Prevent the plugin row to be inserted more than once
	$query = "SELECT COUNT(*) FROM `#__plugins` WHERE element = 'jblibrary' OR element = 'plg_jblibrary'";
	$database->setQuery($query);
		if(!$database->loadResult()){
		$query = 	"INSERT INTO #__plugins (
					name,
					element,
					folder,
					access,
					ordering,
					published,
					iscore,
					client_id,
					checked_out,
					checked_out_time,
					params
					)
					VALUES (
					'System - JB Library', 
					'jblibrary', 
					'system',
					'0',
					'0',
					'1',
					'0',
					'0',
					'0',
					'0000-00-00 00:00:00',
					'jQueryVersion=1.3.2
					source=local
					jqunique=0
					jqregex=([\/a-zA-Z0-9_:\.-]*)jquery([0-9\.-]\|min\|pack)*?.js
					stripCustom=0
					customScripts=
					stripMootools=0
					replaceMootools=0
					mootoolsPath=http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js
					ie6Warning=1
					scrollTop=1
					scrollStyle=dark
					scrollText=^ Back to Top
					lazyLoad=0
					llSelector=img'
					)";	
		$database->setQuery($query);
		$database->query() ? $success = 1 : $success = 0;
} else {
		$query = 	"UPDATE #__plugins 
					SET name = 'System - JB Library', 
					element = 'jblibrary', 
					published = 1,
					params = 'jQueryVersion=1.3.2
					source=local
					jqunique=0
					jqregex=([\/a-zA-Z0-9_:\.-]*)jquery([0-9\.-]\|min\|pack)*?.js
					stripCustom=0
					customScripts=
					stripMootools=0
					replaceMootools=0
					mootoolsPath=http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js
					ie6Warning=1
					scrollTop=1
					scrollStyle=dark
					scrollText=^ Back to Top
					lazyLoad=0
					llSelector=img'
					WHERE element = 'jblibrary' OR element = 'plg_jblibrary'";
		$database->setQuery($query);
		$database->query() ? $success = 1 : $success = 0;
	}
if($success){
	echo '<div class="success">Success! The plugin has been activated and defaults have been set.</div>';
} else {
	echo '<div class="fail">Failed! Not able to automatically activate the plugin, you will have to enable it manually in the plugin manager.</div>';
}	
exit();
?>
