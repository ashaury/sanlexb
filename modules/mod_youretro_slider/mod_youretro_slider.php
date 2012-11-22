<?php
/**
 * @package		YJ Module Engine
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2011 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
// do not change the order!!!  Main arrays are named based on it
// all styles , scripts files etc that you need to load in head tag are in mod_name/yjme/headfiles.php
// additional params are located in mod_name/yjme/params/params.php that is where you can add your own params
// params located here and in helper.php are required by default. do not change them unless you know what you are doing
$yj_mod_name 				= basename(dirname(__FILE__));
$main_yj_arr 				= $yj_mod_name.'s';
$yj_get_items 				= $yj_mod_name;
$module_template 			= $params->get('module_template','Default');
$module_template_check		= JFolder::exists(JPATH_ROOT.DS."modules".DS.$yj_mod_name.DS."tmpl".DS.$module_template);
$k2_check					= JFolder::exists(JPATH_ROOT.DS."components".DS."com_k2".DS);
$item_source				= $params->get   ('item_source',1);

switch ($item_source) {
	// Script ends here if module template does not exist or K2 is not installed
	// joomla
	case 1 :   
		
		if($module_template_check){
			require_once (dirname(__FILE__).DS.'helper.php');
			require('modules/'.$yj_mod_name.'/yjme/params/params.php');
			$main_yj_arr 			= YJmeHelp::YJmeItems($params);
			require(JModuleHelper::getLayoutPath(''.$yj_mod_name.'',''.$module_template.'/default'));
		}else{
			echo JText::_( 'TEMPLATE_ERROR' );
		}

    break;
	// k2
	case 2:  

		if($module_template_check && $k2_check){
			require_once (dirname(__FILE__).DS.'helper.php');
			require('modules/'.$yj_mod_name.'/yjme/params/params.php');
			$main_yj_arr 			= YJmeHelp::YJmeItems($params);
			require(JModuleHelper::getLayoutPath(''.$yj_mod_name.'',''.$module_template.'/default'));
		}else{
			if(!$k2_check){
				echo JText::_( 'K2_ERROR' );
			}else{
				echo JText::_( 'TEMPLATE_ERROR' );
			}
		}
    break; 
 
}

?>