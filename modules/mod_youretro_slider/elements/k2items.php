<?php
/**
 * @version		$Id: items.php 478 2010-06-16 16:11:42Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2010 JoomlaWorks, a business unit of Nuevvo Webware Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class JElementK2Items extends JElement
{

	var	$_name = 'k2items';

	function fetchElement($name, $value, &$node, $control_name){


$k2_check = JFolder::exists(JPATH_ROOT.DS."components".DS."com_k2".DS);
	if($k2_check):
		$document = & JFactory::getDocument();
		if (JPluginHelper::getPlugin('system', 'mtupgrade')) :
			$size = '';
		else:
			$size = '.size';
		endif;
		$js = "		
		function jSelectItem(id, title, object) {
			var exists = false;
			$$('#itemsListk2 input').each(function(element){
					if(element.value==id){
						alert('".JText::_('Item exists already in the list')."');
						exists = true;			
					}
			});
			if(!exists){
				var container = new Element('div').injectInside($('itemsListk2'));
				var img = new Element('img',{'class':'removek2', 'src':'images/publish_x.png'}).injectInside(container);
				var span = new Element('span',{'class':'handlek2'}).setHTML(title).injectInside(container);
				var input = new Element('input',{'value':id, 'type':'hidden', 'name':'".$control_name."[".$name."][]'}).injectInside(container);
				var div = new Element('div',{'style':'clear:both;'}).injectInside(container);
				fireEvent('sortingready');
				alert('".JText::_('Item added in the list')."');
				var k2_ibox = $('itemsListk2').getSize()".$size.";
				$('paramsk2items-lbl').setStyle('height',k2_ibox.y);
				var k2_sel_it = $$('.k2_selected_item').getSize()".$size.";
				var k2_it_hold = $$('.togh_k2').getSize()".$size.";
				$$('.togh_k2').setStyle('height',k2_it_hold.y+k2_sel_it.y);

			}
		}
		
		window.addEvent('domready', function(){			
			fireEvent('sortingready');
		});
		
		window.addEvent('sortingready', function(){
			new Sortables($('itemsListk2'), {
			 	handles:$$('.handlek2')
			
			});
			$$('.removek2').addEvent('click', function(){
				$(this).getParent().remove();
				var k2_ibox = $('itemsListk2').getSize()".$size.";
				$('paramsk2items-lbl').setStyle('height',k2_ibox.y);				

			});
		});
		";

		$document->addScriptDeclaration($js);
		$current = array();
		if(is_string($value) && !empty($value))
			$current[]=$value;
		if(is_array($value))
			$current=$value;
			
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'tables');
		$output = '<div id="itemsListk2">';
		foreach($current as $id){
			$row = &JTable::getInstance('K2Item', 'Table');
			$row->load($id);
			$output .= '
			<div class="k2_selected_item">
				<img class="removek2" src="images/publish_x.png"/>
				<span class="handlek2">'.$row->title.'</span>
				<input type="hidden" value="'.$row->id.'" name="'.$control_name.'['.$name.'][]"/>
				<div style="clear:both;"></div>
			</div>
			';
		}
		$output .= '</div>';
else:
		$output='<div id="itemsListk2"><br /><br /><b><font color="red">K2 is not installed!</font></b><br /></div>';
endif;
		return $output;
	}
}
