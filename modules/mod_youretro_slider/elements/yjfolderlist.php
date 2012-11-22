<?php
/**
 * @package		YJ Module Engine
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2011 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */
// no direct access

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

class JElementYJfolderlist extends JElement
{
	var	$_name = 'YJfolderlist';

	function fetchElement($name, $value, &$node, $control_name)
	{
		jimport( 'joomla.filesystem.folder' );
		
		// path to images directory
		$path		= JPATH_ROOT.DS.$node->attributes('directory');
		$filter		= $node->attributes('filter');
		$exclude	= $node->attributes('exclude');
		$folders	= JFolder::folders($path, $filter);
		global $yj_mod_name;
		$yj_mod_name = basename(dirname(dirname(__FILE__)));
		$options = array ();
		foreach ($folders as $folder)
		{
			if ($exclude)
			{
				if (preg_match( chr( 1 ) . $exclude . chr( 1 ), $folder )) {
					continue;
				}
			}
			$options[] = JHTML::_('select.option', $folder, $folder);
		}

		if (!$node->attributes('hide_none')) {
			array_unshift($options, JHTML::_('select.option', '-1', '- '.JText::_('Do not use').' -'));
		}

		if (!$node->attributes('hide_default')) {
			array_unshift($options, JHTML::_('select.option', '', '- '.JText::_('Use default').' -'));
		}
		global $yj_mod_name;
		$e_folder = basename(dirname(dirname(__FILE__)));
		$document =& JFactory::getDocument();
		$templatecreate = JURI::root() . 'modules/'.$yj_mod_name.'/elements/yjcreatetemplate/index.php';
		$templateedit	= JURI::root() . 'modules/'.$yj_mod_name.'/elements/yjeditemplate/index.php';
		$html = '
		<div id="copy_template">
			<div class="button2-left">
				<div class="blank">
					<a class="modal" title="'.JText::_('Create new template').'"  href="'.$templateedit.'" rel="{handler: \'iframe\', size: {x: 700, y: 500}}">'.JText::_('Edit Template').'</a>
				</div>
			</div>
			<div class="button2-left">
				<div class="blank">
					<a class="modal" title="'.JText::_('Create new template').'"  href="'.$templatecreate.'" rel="{handler: \'iframe\', size: {x: 360, y: 210}}">'.JText::_('Create new template').'</a>
				</div>
			</div>
		</div>
		';

		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'value', 'text', $value, $control_name.$name).$html;
	}
	
		
	
}