<?php
/**
* @id			$Id$
* @author 		Joomla Bamboo
* @package  	JB Library
* @copyright 	Copyright (C) 2006 - 2010 Joomla Bamboo. http://www.joomlabamboo.com  All rights reserved.
* @license  	GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
class JElementRegex extends JElement {
	var	$_name = 'regex';
	function fetchElement( $name, $value, &$node, $control_name )
	{ 	 
		$myvalue = ($value) ? $value : $node->attributes('regex');
		$return = '<textarea ' .
						 'name="' . $control_name . '[' . $name . ']"' .
						 'id="'   . $control_name . '[' . $name . ']"' .
						 'cols="' . $node->attributes( 'cols' ) . '"' .
						 'rows="' . $node->attributes( 'rows' ) . '">' .
						 JText::_($myvalue).
						 '</textarea>'; 
    return $return;
	}
}
