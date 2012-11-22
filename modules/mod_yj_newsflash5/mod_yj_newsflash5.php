<?php
/*======================================================================*\
|| #################################################################### ||
|| # Youjoomla LLC - YJ- Licence Number 5172IP972
|| # Licensed to - ALEXEY KLIMENTYEV
|| # ---------------------------------------------------------------- # ||
|| # Copyright (C) 2006-2009 Youjoomla LLC. All Rights Reserved.        ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- THIS IS NOT FREE SOFTWARE ---------------- #      ||
|| # http://www.youjoomla.com | http://www.youjoomla.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (dirname(__FILE__).DS.'helper.php');
$module_template 		=  		$params->get('module_template','Default');
$showtitle 				= 		$params->get('showtitle',1);
$showimage 				= 		$params->get('showimage',1);
$imgwidth				= 		$params->get('imgwidth',"90px");
$imgheight				= 		$params->get('imgheight',"50px");
$imgalign 				= 		$params->get('imgalign',1);
$showintro				= 		$params->get('showintro',1);
$showrm 				= 		$params->get('showrm',1);
$show_cat_title			= 		$params->get('show_cat_title',1);
$showdate				= 		$params->get('showdate',1);
$yj5_height 			= 		$params->get('yj5_height');
$yj5_iscopy 			= 		$params->get('yj5_iscopy');
$showcomments 	= $params->get('showcomments');	
/* image align */
$alig = array(
	1=>'left',
	2=>'right',
	3=>'none'
	);
$align = $alig[$imgalign];




$yjnf5_items = modYJNewsFlash5Helper::getYJNF5Items($params);
require(JModuleHelper::getLayoutPath('mod_yj_newsflash5',''.$module_template.'/default'));
?>