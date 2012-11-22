<?php
/**
 * @package		Youjoomla Extend Elements
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2011 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2 Copyleft CSS / JS / IMAGES are Copyrighted Commercial
 */
sleep(2);
// Check to ensure this file is within the rest of the framework
if(!defined('_JEXEC')) define( '_JEXEC', 1 );
// do some form check before continuing
function yjsg_validate_data (&$array)
{
    if (is_array($array))
        foreach ($array as $key => $value)
            yjsg_validate_data($array[$key]);
    else
        $array = preg_replace("|([^\w\s\'])|i",'',$array);
}
yjsg_validate_data($_POST);
yjsg_validate_data($_GET);

// get the module name for base path
$yj_mod_name 	= basename(dirname(dirname(dirname(__FILE__))));
$yj_element 	= basename(dirname(__FILE__));
// load joomla framework
define( 'DS', DIRECTORY_SEPARATOR );
define('JPATH_BASE', str_replace("modules".DS.$yj_mod_name.DS."elements".DS.$yj_element,"",dirname(__FILE__)) );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
jimport('joomla.filesystem.file');
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.methods' );
// get base vars
$mainframe 			=& JFactory::getApplication('administrator');
$lang 				=& JFactory::getLanguage();
$user 				=& JFactory::getUser();
$session		 	=& JFactory::getSession();
$default_lang 		= $lang->getDefault();
$yj_mod_name 		= basename(dirname(dirname(dirname(__FILE__))));
$yj_element 		= basename(dirname(__FILE__));
$baselink 			= str_replace("/elements/".$yj_element."","",JURI::base());
$mainframe->initialise();
$lang->load(''.$yj_mod_name.'', JPATH_SITE);
// joomla is on :)

	// Check for request forgeries
JRequest::checkToken() or jexit( 'Invalid Token' );
	// double check and stop if not admin :)
if($user->aid > 1 && ($user->gid == 23 || $user->gid == 24 || $user->gid == 25)){

// joomla is on :)


$cssfile 		= JRequest::getVar('css_upload', null, 'files', 'array');
$cssname 		= JFile::makeSafe($cssfile['name']);
$source			= $cssfile['tmp_name'];
$destination 	= JPATH_ROOT."modules".DS.$yj_mod_name.DS."css".DS.$cssname; 
		// check  if input has value or exit
		if($source ==''){
			echo '<span class="error">Error:'.JText::_('CHOOSE_CSS').'</span>';
			exit;
		}
		
		// go on 
		if(!JFile::exists($destination)) {
				if ( strtolower(JFile::getExt($cssname) ) == 'css') {
				   if ( JFile::upload($source, $destination) ) {
					  //Success
					  echo '<span class="thnx">'.JText::_('CSS_UP').'</span>';
				   } else {
					  //Error message
					  echo '<span class="error">Error: '.JText::_('NO_UPLOAD').'</span>';
				   }
				} else {
				   //Wrong extension
				   echo '<span class="error">Error: '.JText::_('WRONG_EX').'</span>';
				}
		}else{
			echo '<span class="error">Error: '.JText::_('CSS_EXIST').'</span>';
		}


}
