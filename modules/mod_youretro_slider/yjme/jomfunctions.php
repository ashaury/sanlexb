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
	 * Smart Image detection inside article. Searches in intro text and if not found, in full article text
	 *
	 * @param object $row
	 * @return string - image path
	 */
	if(!function_exists('yjme_art_image'))
	{	 
		function yjme_art_image ($row)
		{
			$img = yjme_search_image ( $row->introtext );
			if( $img ) return $img;
					
			$img = yjme_search_image ( $row->fulltext );
			return $img;		
		}
	}
		/**
		 * Searches for all images inside a text and returns the first one found
		 *
		 * @param string $text
		 * @return string
		 */
	if(!function_exists('yjme_search_image'))
	{	
		function yjme_search_image ( $text )
		{		
			preg_match_all("#\<img(.*)src\=\"(.*)\"#Ui", $text, $mathes);		
			return isset($mathes[2][0]) ? $mathes[2][0] : '';			
		}
	}
	
	
	// get item url joomla
	if(!function_exists('yjme_get_url'))
	{	
		function yjme_get_url ( $row )
		{		
			$item_url = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
			return $item_url;
		}
	}
	
	
	// get cat url joomla
	if(!function_exists('yjme_get_cat_url'))
	{	
		function yjme_get_cat_url ( $row )
		{		
			$cat_url = JRoute::_(ContentHelperRoute::getCategoryRoute($row->catslug, $row->sectionid));
			return $cat_url;
		}
	}	
	
	// get author url joomla :) maybe one day :)
	if(!function_exists('yjme_get_author_url'))
	{	
		function yjme_get_author_url ( $row )
		{		
			$author_url = '';
			return $author_url;
		}
	}	
	

	
?>