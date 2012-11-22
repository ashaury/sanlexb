<?php
/**
 * @package		Youjoomla Extend Elements
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2010 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a spacer element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementYjSpacer extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'YjSpacer';

	function fetchTooltip($label, $description, &$node, $control_name, $name) {
		return false;
			
	}

	function fetchElement($name, $value, &$node, $control_name)
	{
		return '
		<div id="'.$control_name.$name.'" class="yjspacer_holder">
			<div class="yjspacer">'.JText::_($value).'</div>
		</div>
		';
	}

}
