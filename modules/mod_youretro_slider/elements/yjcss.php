<?php
/**
* @version		$Id: filelist.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla.Framework
* @subpackage	Parameter
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
/**
 * @package		YJ Module Engine
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2011 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a filelist element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementYJcss extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'YJcss';

	function fetchElement($name, $value, &$node, $control_name)
	{
		jimport( 'joomla.filesystem.folder' );
		jimport( 'joomla.filesystem.file' );

		// path to images directory
		$path		= JPATH_ROOT.DS.$node->attributes('directory');
		$filter		= $node->attributes('filter');
		$exclude	= $node->attributes('exclude');
		$stripExt	= $node->attributes('stripext');
		$files		= JFolder::files($path, $filter);
		global $yj_mod_name;
		$yj_mod_name = basename(dirname(dirname(__FILE__)));
		$options = array ();

		if (!$node->attributes('hide_none'))
		{
			$options[] = JHTML::_('select.option', '-1', '- '.JText::_('Do not use').' -');
		}

		if (!$node->attributes('hide_default'))
		{
			$options[] = JHTML::_('select.option', '', '- '.JText::_('Use default').' -');
		}

		if ( is_array($files) )
		{
			foreach ($files as $file)
			{
				if ($exclude)
				{
					if (preg_match( chr( 1 ) . $exclude . chr( 1 ), $file ))
					{
						continue;
					}
				}
				if ($stripExt)
				{
					$file = JFile::stripExt( $file );
				}
				$options[] = JHTML::_('select.option', $file, $file);
			}
		}
		

		

		$cssedit = JURI::root() . 'modules/'.$yj_mod_name.'/elements/yjeditcss/index.php';
		$cssupload = JURI::root() . 'modules/'.$yj_mod_name.'/elements/yjuploadcss/index.php';
		$csscreate = JURI::root() . 'modules/'.$yj_mod_name.'/elements/yjcreatecss/index.php';
		JHTML::_('behavior.modal', 'a.modal');
		$html = '
		<div id="css_file">
			<div class="button2-left">
				<div class="blank">
					<a class="modal" title="'.JText::_('Edit CSS files').'"  href="'.$cssedit.'" rel="{handler: \'iframe\', size: {x: 700, y: 500}}">'.JText::_('Edit CSS files').'</a>
				</div>
			</div>
			
			<div class="button2-left">
				<div class="blank">
					<a class="modal" title="'.JText::_('Upload CSS file').'"  href="'.$cssupload.'" rel="{handler: \'iframe\', size: {x: 380, y: 210}}">'.JText::_('Upload new CSS file').'</a>
				</div>
			</div>
			
			<div class="button2-left">
				<div class="blank">
					<a class="modal" title="'.JText::_('Create new CSS file').'"  href="'.$csscreate.'" rel="{handler: \'iframe\', size: {x: 380, y: 210}}">'.JText::_('Create new CSS file').'</a>
				</div>
			</div>			
		</div>
		
		';
	
		
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'value', 'text', $value, $control_name.$name).$html;
	}
}
