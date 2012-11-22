<?php
/**
 * @package		Youjoomla Extend Elements
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2010 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */
//<param name="handler" type="yjhandler"/>   add once in xml to load custom codes
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
//JHTML::_('behavior.modal');
/**
 * Renders a spacer element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementYjHandler extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'YjHandler';

	function fetchElement($name, $value, &$node, $control_name){
		$e_folder = basename(dirname(dirname(__FILE__)));
		$document =& JFactory::getDocument();
		if (JPluginHelper::getPlugin('system', 'mtupgrade')) :
			$moo_v = '12';
		else:
			$moo_v = '';
		endif;
$document->addStyleSheet(JURI::root() . 'modules/'.$e_folder.'/elements/css/stylesheet.css');
$document->addScript(JURI::root() . 'modules/'.$e_folder.'/elements/src/yjsourceswitch'.$moo_v.'.js');
	
		echo '<div id="selectedresult"></div>';
		
		return ;
	}
		function fetchTooltip($label) {
		return false;
	}
}
