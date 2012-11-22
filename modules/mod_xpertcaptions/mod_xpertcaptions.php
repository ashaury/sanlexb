<?php
/**
 * @package Xpert Captions
 * @version 1.1
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
 
// no direct access
defined('_JEXEC') or die('Restricted accessd');


// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$lists = modXpertCaptionsHelper::getLists($params);
$module_id = 'xc'.$module->id;

modXpertCaptionsHelper::loadStyles($params,$module_id);
modXpertCaptionsHelper::loadScripts($params,$module_id);

require( JModuleHelper::getLayoutPath('mod_xpertcaptions') );
