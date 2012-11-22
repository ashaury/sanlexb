<?php
/**
 * @package 	mod_bt_contentslider - BT ContentSlider Module
 * @version		1.4
 * @created		Oct 2011

 * @author		BowThemes
 * @email		support@bowthems.com
 * @website		http://bowthemes.com
 * @support		Forum - http://bowthemes.com/forum/
 * @copyright	Copyright (C) 2011 Bowthemes. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
JModel::addIncludePath(JPATH_SITE . '/components/com_content/models');
require_once JPATH_SITE . DS . 'modules' . DS . 'mod_bt_contentslider' . DS . 'helpers' . DS . 'route_content.php';
require_once JPATH_SITE . DS . 'modules' . DS . 'mod_bt_contentslider' . DS . 'classes' . DS . 'btsource.php';

/**
 * class BtContentDataSource
 */
class BtContentDataSource extends BTSource {
	
	/**
	 * Get List articles following to parameters
	 */
	function getList(){	

		$params = &$this->_params;

		$formatter = $params->get('style_displaying', 'title');
		$titleMaxChars = $params->get('title_max_chars', '100');
		$limit_title_by = $params->get('limit_title_by', 'char');
		$descriptionMaxChars = $params->get('description_max_chars', 100);
		$limitDescriptionBy = $params->get('limit_description_by', 'char');
		$isThumb = $params->get('image_thumb', 1);
		$replacer = $params->get('replacer', '...');
		$isStrips = $params->get("auto_strip_tags", 1);
		$limit = $params->get('limit_items', 12);
		$user	 =& JFactory::getUser();
		$aid		 = (int) $user->get('aid', 0);

		if ($isStrips) {
			$allow_tags = $params->get("allow_tags", array());
			$stringtags = '';
			if (!is_array($allow_tags)) {
				$allow_tags = explode(',', $allow_tags);
			}
			foreach ($allow_tags as $tag) {
				$stringtags .= '<' . $tag . '>';
			}
		}
		if (!$params->get('default_thumb', 1)) {
			$this->_defaultThumb = '';
		}
		$itemid = $params->get('itemid', 0);

		$ordering = $params->get('ordering', 'created-asc');
		
	    $db = JFactory::getDbo();
	    
		
	   $source = trim($params->get( 'source', 'category' ) );
	   $where = array();
	   //if category
	    if( $source == 'category' ){
	      // Category filter
	      $categories=$params->get('category', array());
		if(is_array($categories))
		  $where[] = "b.id in(".implode(",",$categories).")";
		else
		 $where[] = "b.id  = $categories";
		//esle article_ids
	    }else{
	      $ids = preg_split('/,/',$params->get( 'article_ids','')); 
	      $tmp = array();
	      foreach( $ids as $id ){
	        $tmp[] = (int) trim($id);
	      }
	      $where[] = "a.id in(".implode(",",$tmp).")";
	    }
	
	    // User filter
	    $userId = JFactory::getUser()->get('id');
	    switch ($params->get('user_id') ) {
	      case 'by_me':
	        $where[] = 'a.created_by = '.$userId;
	        break;
	      case 'not_me':
	        $where[] = 'a.created_by != '.$userId;
	        break;
	     case 0:
	        break;
	
	      default:
	        $where[] = 'a.created_by = '.$userId;
	        break;
	    }
		
	    switch ( $params->get('show_featured') )  {
	      case '3':
			$query = "SELECT content_id from #__content_frontpage";
			$db->setQuery($query);
			$frontpages = $db->loadResultArray();
			if(count($frontpages))
	         "a.id in(".implode(",",$frontpages).")";
	        break;
	      case 2:
	        $query = "SELECT content_id from #__content_frontpage";
			$db->setQuery($query);
			$frontpages = $db->loadResultArray();
			if(count($frontpages))
	         $where[] = "a.id not in(".implode(",",$frontpages).")";
	        break;
	      default:
	        break;
	    }
		$where[] = 'a.state = 1';
		
		// Filter by access
		$where[] = 'a.access <= '.$aid;
		$where[] = 'b.access <= '.$aid;
		
		// Filter by start and end dates.
		$nullDate	= $db->Quote($db->getNullDate());
		$nowDate	= $db->Quote(JFactory::getDate()->toMySQL());

		$where[]= '(a.publish_up = '.$nullDate.' OR a.publish_up <= '.$nowDate.')';
		$where[] = '(a.publish_down = '.$nullDate.' OR a.publish_down >= '.$nowDate.')';
		
	    // Set ordering

		$orderby =str_replace('-',' ','a.'.$ordering);
		$where = implode(" AND ",$where );
	    $query = 'SELECT a.*,CASE WHEN CHAR_LENGTH(a.alias) THEN  CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,
				CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(":", b.id, b.alias) ELSE b.id END as catslug,
				b.title as category_title, b.alias as categoryalias, b.params as categoryparams,u.name AS author
				FROM #__content as a left join #__categories as b
				ON a.catid = b.id
				LEFT JOIN #__users AS u ON u.id = a.created_by
				where '.$where. ' order by '. $orderby. " limit ".$limit;
	  
	    $db->setQuery($query);
		$items = $db->loadObjectList();
		foreach ($items as &$item) {


			if ($item->access <= $aid) {
				// We know that user has the privilege to view the article
				//Item link
				$item->link = JRoute::_(BTContentSliderRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid, $itemid));
			}
			else {

				$item->link = JRoute::_('index.php?option=com_user&view=login');
			}
			$item->date = JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC2'));

			$item->thumbnail = '';
			if ($params->get('show_image', 1)) {
				$item = $this->generateImages($item, $isThumb);
			}

			//$item->fulltext = $item->introtext;
			//$item->introtext = JHtml::_('content.prepare', $item->introtext);

			//category Link
			$item->categoryLink = JRoute::_(BTContentSliderRoute::getCategoryRoute($item->catid,$item->sectionid, $itemid));

			if ($limit_title_by == 'word' && $titleMaxChars > 0) {

				$item->title_cut = self::substrword($item->title, $titleMaxChars, $replacer, $isStrips);

			}
			elseif ($limit_title_by == 'char' && $titleMaxChars > 0) {
				$item->title_cut = self::substring($item->title, $titleMaxChars, $replacer, $isStrips);
			}

			if ($limitDescriptionBy == 'word' && $descriptionMaxChars > 0) {

				$item->description = self::substrword($item->introtext, $descriptionMaxChars, $replacer, $isStrips, $stringtags);

			}
			elseif ($limitDescriptionBy == 'char' && $descriptionMaxChars > 0) {

				$item->description = self::substring($item->introtext, $descriptionMaxChars, $replacer, $isStrips, $stringtags);
			}
			$item->authorLink = "#";
		}
		return $items;
	}
}

?>