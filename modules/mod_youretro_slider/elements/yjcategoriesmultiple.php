<?php
/**
 * @version		$Id: categoriesmultiple.php 478 2010-06-16 16:11:42Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2010 JoomlaWorks, a business unit of Nuevvo Webware Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
/**
 * @package		YJ Module Engine
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2011 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

class JElementYjCategoriesmultiple extends JElement
{

	var	$_name = 'Yjcategoriesmultiple';

	function fetchElement($name, $value, &$node, $control_name){
		$db = &JFactory::getDBO();
		
		$section	= $node->attributes('section');
		if (!isset ($section)) {
			// alias for section
			$section = $node->attributes('scope');
			if (!isset ($section)) {
				$section = 'content';
			}
		}		
		
		
		$query ='SELECT c.id, CONCAT_WS( "/",s.title, c.title ) AS title' .
				' FROM #__categories AS c' .
				' LEFT JOIN #__sections AS s ON s.id=c.section' .
				' WHERE c.published = 1' .
				' AND s.scope = '.$db->Quote($section).
				' ORDER BY s.title, c.title';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();
		
		
		foreach($mitems as $mitem){
			$itemid[] = $mitem->id;
			$iteminame[] = $mitem->title;
		}

	  $default = 2;
  ## Initialize array to store dropdown options ##
  $options = array();
 
  foreach ( $mitems as $key=>$item ) {
    ## Create $value ##
    $options[] = JHTML::_('select.option',  $itemid[''.$key.''], '&nbsp;&nbsp;&nbsp;'.$iteminame[''.$key.''] );
  }
		$doc = & JFactory::getDocument();

		$output= JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.'][]', 'class="inputbox" style="width:90%;" multiple="multiple" size="10"', 'value', 'text', $value );
		return $output;
	}
}
