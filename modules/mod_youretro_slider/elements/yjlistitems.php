<?php
/**
 * @package		Youjoomla Extend Elements
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2010 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */
/**
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr modified by Youjoomla LLC
 * @copyright	Copyright (c) 2006 - 2010 JoomlaWorks, a business unit of Nuevvo Webware Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class JElementYjListitems extends JElement
{

	var	$_name = 'yjlistitems';

	function fetchElement($name, $value, &$node, $control_name){
		$document = & JFactory::getDocument();
		if (JPluginHelper::getPlugin('system', 'mtupgrade')) :
			$size = '';
		else:
			$size = '.size';
		endif;
		$js = "		
		function jSelectArticle(id, title, object) {
			var exists = false;
			$$('#itemsList input').each(function(element){
					if(element.value==id){
						alert('".JText::_('Item exists already in the list')."');
						exists = true;			
					}
			});
			if(!exists){
				var container = new Element('div').injectInside($('itemsList'));
				var img = new Element('img',{'class':'remove', 'src':'images/publish_x.png'}).injectInside(container);
				var span = new Element('span',{'class':'handle'}).setHTML(title).injectInside(container);
				var input = new Element('input',{'value':id, 'type':'hidden', 'name':'".$control_name."[".$name."][]'}).injectInside(container);
				var div = new Element('div',{'style':'clear:both;'}).injectInside(container);
				fireEvent('sortingready');
				alert('".JText::_('Item added in the list')."');
		var yj_ibox = $('itemsList').getSize()".$size.";
		$('paramsgetspecific-lbl').setStyle('height',yj_ibox.y);
		
		var j_sel_it = $$('.jom_selected_item').getSize()".$size.";
		var j_it_hold = $$('.togh_yj').getSize()".$size.";
		$$('.togh_yj').setStyle('height',j_it_hold.y+j_sel_it.y);		
		
			}
		}
		
		window.addEvent('domready', function(){			
			fireEvent('sortingready');
		});
		
		window.addEvent('sortingready', function(){
			new Sortables($('itemsList'), {
			 	handles:$$('.handle')
			
			});
			$$('#itemsList .remove').addEvent('click', function(){
				$(this).getParent().remove();
		var yj_ibox = $('itemsList').getSize()".$size.";
		$('paramsgetspecific-lbl').setStyle('height',yj_ibox.y);
			});
		});
		";

		$document->addScriptDeclaration($js);
		$current = array();
		if(is_string($value) && !empty($value))
			$current[]=$value;
		if(is_array($value))
			$current=$value;
		$e_folder = basename(dirname(dirname(__FILE__)));	
		JTable::addIncludePath(JPATH_ROOT.'/modules/'.$e_folder.'/elements');
		$output = '<div id="itemsList">';
		foreach($current as $id){
			$row = & JTable::getInstance('YjContent', 'Table');
			$row->load($id);
			$output .= '
			<div class="jom_selected_item">
				<img class="remove" src="images/publish_x.png"/>
				<span class="handle">'.$row->title.'</span>
				<input type="hidden" value="'.$row->id.'" name="'.$control_name.'['.$name.'][]"/>
				<div style="clear:both;"></div>
			</div>
			';
		}
		$output .= '</div>';
		return $output;
	}
}
