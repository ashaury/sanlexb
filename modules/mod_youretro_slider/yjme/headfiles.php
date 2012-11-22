<?php
/**
 * @package		YJ Module Engine
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2011 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
			JHTML::_('behavior.mootools');
			$document = &JFactory::getDocument();
			$module_css			= $params->get   ('module_css','stylesheet.css');
			$document->addStyleSheet(JURI::base() . 'modules/'.$yj_mod_name.'/css/'.$module_css.'');
		if (JPluginHelper::getPlugin('system', 'mtupgrade')) :
			$moo_v = '12';
		else:
			$moo_v = '';
		endif;
		$document->addScript(JURI::base() . 'modules/'.$yj_mod_name.'/src/youretro_slider'.$moo_v.'.js');
		$fx_poz = $slider_width - ($thumb_width * 2);
		if($infoContainerPosition =='right'){
			$move_m ='';
		}else{
			$move_m ='-';
		}
		$document->addScriptDeclaration("
		window.addEvent('domready', function(){
				new YouretroSlider({
					navigation:{
						container: 'navigator".$is_copy."',
						elements:'.element',
						outer: 'navigator_outer".$is_copy."',
						selectedClass: 'selected',
						visibleItems: ".$visibleItems."
					},
					slides:{
						container:'slides".$is_copy."',
						elements:'.slide',
						infoContainer:'.long_desc',
						fadeDurr:".$fadeDurr.",
						infoContainerPosition: '".$infoContainerPosition."',
						startFx:{
							'opacity':[0,1],
							'marginLeft':0
						},
						endFx:{
							'opacity':0,
							'marginLeft':".$move_m.$fx_poz."
						}
					},
					startElem: ".$startElem.",
					autoSlide: ".$autoSlide."
				});

			});
		");
		
	if($con_border_radius > 0) {
		$document->addScriptDeclaration("
		window.addEvent('domready', function(){
			  $$('.youretro_cont_border').setStyles({
			  		borderRadius: '".$con_border_radius."px',
			  		WebkitBorderRadius:'".$con_border_radius."px',
			  		MozBorderRadius:'".$con_border_radius."px'
				});
			
		});
			");
	}





		
//Document type examples
//$document->addStyleSheet(JURI::base() . 'modules/'.$yj_mod_name.'/css/'.$module_css.'');
//$document->addScript('');
//$document->addScriptDeclaration("jQuery.noConflict();");
//$document->addCustomTag('<style type="text/css"></style>');
//$document->addScriptDeclaration("");

// if you need to check if mt upgrade plugin is on comment out the lines below
//// check to see if mtupgrade is on to switch between js files versions for moo 1.1 and 1.2.5
//if (JPluginHelper::getPlugin('system', 'mtupgrade')) :
//	$moo_v = '12';
//else:
//	$moo_v = '';
//endif;
?>