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
/** Thanks to onejQuery for being the inspiration of our unique jQuery function **/
/** ensure this file is being included by a parent file */
jimport( 'joomla.plugin.plugin' );
class plgSystemJblibrary extends JPlugin {
    function plgSystemJblibrary( &$subject ){
        parent::__construct( $subject );
        $this->_plugin = JPluginHelper::getPlugin( 'system', 'jblibrary' );
        $this->_params = new JParameter( $this->_plugin->params );
        $this->_mainframe= &JFactory::getApplication();
        $this->_jqpath = '';
        if($this->_mainframe->isAdmin())return;
    }
    function onAfterInitialise() {
        if($this->_mainframe->isAdmin())return;
        $source = $this->_params->get('source','google');    
        $jQueryVersion = $this->_params->get('jQueryVersion','1.6.1');
		$noConflict = $this->_params->get('noConflict',1);
        $ie6Warning = $this->_params->get('ie6Warning',1); 
        $scrolltop = $this->_params->get('scrollTop',1);
        $lazyLoad = $this->_params->get('lazyLoad',1);
        $scrollStyle = $this->_params->get('scrollStyle','dark');
        $scrollText = $this->_params->get('scrollText','^ Back To Top');
        $llSelector = $this->_params->get('llSelector','img');
        $selectedMenus = $this->_params->get('menuItems','');
        $itemid = JRequest::getInt('Itemid');
        if(!$itemid) $itemid = 1;
        if($llSelector == "") $llSelector = "img";
        if (is_array($selectedMenus)){
            $menus = $selectedMenus;
        } elseif (is_string($selectedMenus) && $selectedMenus!=''){
            $menus[] = $selectedMenus;
        } elseif ($selectedMenus == ''){
            $menus[] = $itemid;
        }
        //module base
        $modbase = JURI::root (true).'/media/plg_jblibrary/';
    	$jsbase = 'jquery/';
		$document =& JFactory::getDocument();
		if(in_array($itemid,$menus)){
			//Dont Add Jquery in Admin

			if((JFactory::getApplication()->get('jquery') == false) && ($jQueryVersion !=="none")) {
				
				// Tell other extensions jQuery has been loaded
				JFactory::getApplication()->set('jquery', true);
		   		JHTML::_(' behavior.mootools');
				if ($jQueryVersion == '1.6') {
						$this->_jqpath = 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js';
						$document->addScript($this->_jqpath); 
		   		}else{
					if ($source == 'local') {
						$this->_jqpath = $modbase . $jsbase . 'jquery-'.$jQueryVersion.'.min.js';
					}
					if ($source == 'google') {
						$this->_jqpath = 'http://ajax.googleapis.com/ajax/libs/jquery/'.$jQueryVersion.'/jquery.min.js';
					}
					$document->addScript($this->_jqpath);	
				}
				if(!($jQueryVersion == "none") and $noConflict){
					$document->addScript($modbase.'jquery/jquery.noconflict.js');
				}
			}	
   		}
	   	//Detect Browser
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$browser = substr("$browser", 25, 8);
		//Load Scroll To Top if Not IE6
		if ($scrolltop and ($browser != "MSIE 6.0")){
			if($scrollStyle == "dark")
			{
				$document->addStyleDeclaration("#toTop {width:100px;z-index: 10;border: 1px solid #333; background:#121212; text-align:center; padding:5px; position:fixed; bottom:0px; right:0px; cursor:pointer; display:none; color:#fff;text-transform: lowercase; font-size: 0.9em;}");
			}
			if($scrollStyle == "light")
			{
				$document->addStyleDeclaration("#toTop {width:100px;z-index: 10;border: 1px solid #eee; background:#f7f7f7; text-align:center; padding:5px; position:fixed; bottom:0px; right:0px; cursor:pointer; display:none;  color:#333;text-transform: lowercase; font-size: 0.9em;}");
			}
		}
		if ($lazyLoad){
			$document->addScript($modbase . $jsbase. "jquery.lazyload.js");
		}
	}
	function onAfterRoute() {
		/*if($this->_mainframe->isAdmin())return;
		$selectedMenus = $this->_params->get('menuItems','');
		//$menu = &JSite::getMenu();
		$menuItem   = $this->_menu->getActive();
		$itemid = $menuItem->id;
		//$itemid = JSite::getMenu()->getActive()->id;
		//$itemid 		= JRequest::getInt('Itemid');
		if(!$itemid) $itemid = 1;
		if (is_array($selectedMenus)){
			$menus = $selectedMenus;
		} elseif (is_string($selectedMenus) && $selectedMenus!=''){
			$menus[] = $selectedMenus;
		} elseif ($selectedMenus == ''){
			$menus[] = $itemid;
		}
		$menuVar = '<pre>'.$itemid.' in route array '.print_r($menus).'</pre>';
		$this->_mainframe->addCustomHeadTag($menuVar);
		if(in_array($itemid,$menus)){}
		*/
	}
	function onAfterRender() {
		if($this->_mainframe->isAdmin()){return;}	
		$jqRegex = $this->_params->get('jqregex','([\/a-zA-Z0-9_:\.-]*)jquery([0-9\.-]|min|pack)*?.js');
		$jqUnique = $this->_params->get('jqunique',0);
		$stripCustom = $this->_params->get('stripCustom',0);
		$customScripts = $this->_params->get('customScripts','');
		$stripMootools = $this->_params->get('stripMootools',0);
		$replaceMootools = $this->_params->get('replaceMootools',0);
		$ie6Warning = $this->_params->get('ie6Warning',1); 
		$mootoolsPath = $this->_params->get('mootoolsPath','http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js');
		$scrolltop = $this->_params->get('scrollTop',1);
		$lazyLoad = $this->_params->get('lazyLoad',1);
		$scrollStyle = $this->_params->get('scrollStyle','dark');
		$scrollText = $this->_params->get('scrollText','^ Back To Top');
		$llSelector = $this->_params->get('llSelector','img');
		if($llSelector == "") $llSelector = "img";
		//module base
        $modbase = JURI::root (true).'/media/plg_jblibrary/';
    	$jsbase = 'jquery/';
		$body =& JResponse::getBody();
		if($stripMootools){
			$body = preg_replace("#([\/a-zA-Z0-9_:\.-]*)mootools.js#", "", $body);
			$body = preg_replace("#([\/a-zA-Z0-9_:\.-]*)caption.js#", "", $body);
			$body = str_ireplace('<script type="text/javascript" src=""></script>', "", $body);
		}
		if($replaceMootools){
			if ($mootoolsPath != ''){$body = preg_replace("#([\/a-zA-Z0-9_:\.-]*)mootools.js#", "MTLIB", $body, 1);}
			$body = str_ireplace('<script type="text/javascript" src=""></script>', "", $body);
			$body = preg_replace('#MTLIB#', $mootoolsPath, $body);
		}
		if($jqUnique && $jqRegex){
			if ($this->_jqpath != ''){$body = preg_replace("#$jqRegex#", "JQLIB", $body, 1);}
            $body = preg_replace("#$jqRegex#", "", $body);
            $body = str_ireplace('<script type="text/javascript" src=""></script>', "", $body);
            $body = preg_replace("#jQuery\.noConflict\(\);#", "", $body);
            $body = preg_replace('#(<script type="text/javascript" src="JQLIB"></script>)#', "\\1<script type=\"text/javascript\">jQuery.noConflict();</script>", $body);
            $body = preg_replace('#JQLIB#', $this->_jqpath, $body);
		}
		if($stripCustom && ($customScripts != "")){
			$customScripts = preg_split("/[\s,]+/", trim($customScripts));
			foreach($customScripts as $scriptName){
				$scriptRegex = '([\/a-zA-Z0-9_:\.-]*)'.trim($scriptName);
				$body = preg_replace("#$scriptRegex#", "", $body);
			}
			$body = str_ireplace('<script type="text/javascript" src=""></script>', "", $body);
		}
		//Detect Browser
		jimport('joomla.environment.browser');
		$browser = JBrowser::getInstance();		
		$agent = $browser->getAgentString();
		$scripts = '';
		if ($ie6Warning and (stripos($agent, 'msie 6'))) { 
	   			$scripts = '
	   			<!--[if lte IE 6]>
	   			<script type="text/javascript" src="'.$modbase .''.$jsbase.'jquery.badBrowser.js"></script> 
	   			 <![endif]-->
	   			 ';	
		 }
		//Load Scroll To Top if Not IE6
		if ($scrolltop and (!(stripos($agent, 'msie 6') or stripos($agent,'iphone') or stripos($agent,'ipod') or stripos($agent,'ipad') or stripos($agent,'blackberry') or stripos($agent,'palmos') or stripos($agent,'android')))){
			$scripts .= '
			<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(function () {
				var scrollDiv = document.createElement("div");
				jQuery(scrollDiv).attr("id", "toTop").html("'.JText::_(''.$scrollText.'').'").appendTo("body");    
				jQuery(window).scroll(function () {
						if (jQuery(this).scrollTop() != 0) {
							jQuery("#toTop").fadeIn();
						} else {
							jQuery("#toTop").fadeOut();
						}
					});
					jQuery("#toTop").click(function () {
						jQuery("body,html").animate({
							scrollTop: 0
						},
						800);
					});
				});
			});
			</script>
			';
		}
		if ($lazyLoad){
			$scripts .= '
			<script type="text/javascript">
			jQuery(document).ready(function(){jQuery("'.$llSelector.'").lazyload({ 
		    effect : "fadeIn" 
		    });
		});
		</script>
		';
		}
		
		$path= "media".DS."plg_jblibrary".DS."user";
		$files = JFolder::files($path, 'js', false, true);
		$files ? $result = count($files) : $result = 0;
				
		if ($result > 0) {	
			foreach($files as $file){
				$scripts .= '<script type="text/javascript" src="'.JURI::root (true).'/'.$file.'"></script>';	
			}
		}		
		
		$body = str_replace ("</body>", $scripts."</body>", $body);
		JResponse::setBody($body);
		return true;
	}
}
?>
