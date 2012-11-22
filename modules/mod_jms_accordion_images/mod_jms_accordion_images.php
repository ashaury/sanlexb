<?php
/**
* @version		1.0
* @package		JMS accordion images Module
* @copyright	Joommasters.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$document->addScript('modules/mod_jms_accordion_images/assets/jquery-1.2.3.js');
$document->addStyleSheet('modules/mod_jms_accordion_images/assets/common.css');
// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$list = modJMS_accordion_imagesHelper::getList($params);
require(JModuleHelper::getLayoutPath('mod_jms_accordion_images'));