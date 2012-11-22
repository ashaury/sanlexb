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

class JElementYjholder extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'Yjholder';

	function fetchElement($name, $value, &$node, $control_name){

		// Output
		
		return '
		<div id="'.$control_name.$name.'" class="yj_holder">
			<div id="'.$control_name.$name.'sprc" class="yj_sprc"></div>
			<div id="'.$control_name.$name.'lbl" class="yj_lbl"></div>
			<div id="'.$control_name.$name.'par" class="yj_par"></div>
		</div>
		';
	}
		function fetchTooltip($label) {
		return false;
	}
}
