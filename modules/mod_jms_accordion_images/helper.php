<?php
/**
* @version		1.0
* @package		JMS accordion images Module
* @copyright	Joommasters.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class modJMS_accordion_imagesHelper
{
	
	function parseParams( $string ) {
		$string = html_entity_decode($string, ENT_QUOTES);
		$regex = "/\s*([^=\s]+)\s*=\s*('([^']*)'|\"([^\"]*)\"|([^\s]*))/";
		 $params = null;
		 if(preg_match_all($regex, $string, $matches) ){
				for ($i=0;$i<count($matches[1]);$i++){ 
				  $key 	 = $matches[1][$i];
				  $value = $matches[3][$i]?$matches[3][$i]:($matches[4][$i]?$matches[4][$i]:$matches[5][$i]);
				  $params[$key] = $value;
				}
		  }
		  return $params;
	}
	function parseDescNew( $description ) {
		
		$regex = '#\[desc ([^\]]*)\]([^\[]*)\[/desc\]#m';
		preg_match_all ($regex, $description, $matches, PREG_SET_ORDER);
		
		$descriptionArray = array();
		$i=0;
		foreach ($matches as $match) {
		$params = modJMS_accordion_imagesHelper::parseParams( $match[1] );
		if (is_array($params)) {
			$img = isset($params['img'])?trim($params['img']):'';
			if (!$img) continue;
				$url = isset($params['url'])?trim($params['url']):'';
				$target = isset($params['target'])?trim($params['target']):'';
				$descriptionArray[$i] = array( 'img' => $img,
												'url'		=> $url,
												 'caption'	=> str_replace("\n","<br />",trim($match[2])),
												 'target'	=>$target);
			}
			$i++;
		}
		return $descriptionArray;
	}
	
	function getList(&$params)
	{
		global $mainframe;

		$descriptions  		= 	$params->get('description',"");
		
		$descriptionArr = preg_split('/<lang=([^>]*)>/', $descriptions , -1 , PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		$description = '';
		
		if(count($descriptionArr) > 1){
			for($i=0; $i< count( $descriptionArr ); $i=$i+2 ){
				if( $descriptionArr[$i] == $iso_client_lang ){
					$description = $descriptionArr[($i+1)];
					break;
				}
			}
			if(!$description){
				$description = $descriptionArr[1];
			}
		} else if(isset($descriptionArr[0])) {
				$description = $descriptionArr[0];
		}
		//Parse description. Description in format: [desc img="imagename" url="link"]Description goes here[/desc]
		$descriptionArray = modJMS_accordion_imagesHelper::parseDescNew ( $description );
		
		//print_r($descriptionArray); exit;
		return $descriptionArray; 

	}
}
