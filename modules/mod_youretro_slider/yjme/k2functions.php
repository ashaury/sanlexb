<?php
/**
 * @package		YJ Module Engine
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2011 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */
	// default functions used in both cases no matter what content source
	// no direct access
	defined('_JEXEC') or die('Restricted access');
	/**
	 * Smart Image detection
	 *
	 * @param object $row
	 * @return string - image path
	 */
	// k2 images
	if(!function_exists('k2_yjme_art_image'))
	{	
		function k2_yjme_art_image ($row)
		{	
	// awesome check! intro text has the priority. if image in introtext than that is what we will use
			if(preg_match_all("#\<img(.*)src\=\"(.*)\"#Ui", $row->introtext, $images)):
				$img = $images[2][0];
				return $img;
			else:
				global $k2image_size;
				$is_image = JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_'.$k2image_size .'.jpg');
				$img = JURI::root().'media/k2/items/cache/'.md5("Image".$row->id).'_'.$k2image_size .'.jpg';
				if( $is_image ) return $img;
			endif;
		}
	}
	
	// get item url k2
	if(!function_exists('k2_yjme_get_url'))
	{	
		function k2_yjme_get_url ( $row )
		{	
		//crazy!!  403 redirect by default? nahhh..To bad I cant edit the default router but this should be ok
		global $mainframe;
		global $aid;
			if ($row->access == 0){
					$item_url 		= urldecode(JRoute::_(K2HelperRoute::getItemRoute($row->id.':'.urlencode($row->alias), $row->catid.':'.urlencode($row->categoryalias))));
			}else{
				$item_url  = JRoute::_('index.php?option=com_user&amp;view=login');
			}
				return $item_url;
		}
	}	
	
		// get cat url k2
	if(!function_exists('k2_yjme_get_cat_url'))
	{	
		function k2_yjme_get_cat_url ( $row )
		{		
			$cat_url = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($row->catid.':'.urlencode($row->categoryalias))));
			return $cat_url;
		}
	}
	
		// get author url k2 :) maybe one day :)
	if(!function_exists('k2_yjme_get_author_url'))
	{	
		function k2_yjme_get_author_url ( $row )
		{		
			$author_url = JRoute::_(K2HelperRoute::getUserRoute($row->created_by));
			return $author_url;
		}
	}
	

	
	
?>