<?php
/**
 * Modified from route.php of com_content
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.helper');

abstract class BTContentSliderRoute
{
	/**
	 * @param	int	The route of the content item
	 */
	function getArticleRoute($id, $catid = 0, $sectionid = 0,$itemid = 9999)
	{
		$needles = array(
			'article'  => (int) $id,
			'category' => (int) $catid,
			'section'  => (int) $sectionid,
		);

		//Create the link
		$link = 'index.php?option=com_content&view=article&id='. $id;

		if($catid) {
			$link .= '&catid='.$catid;
		}

		if($item = ContentHelperRoute::_findItem($needles)) {
			$link .= '&Itemid='.$item->id;
		}
		else
		{
			$link .= '&Itemid=' . $itemid;
		}

		return $link;
	}

	function getSectionRoute($sectionid)
	{
		$needles = array(
			'section' => (int) $sectionid
		);

		//Create the link
		$link = 'index.php?option=com_content&view=section&id='.$sectionid;

		if($item = ContentHelperRoute::_findItem($needles)) {
			if(isset($item->query['layout'])) {
				$link .= '&layout='.$item->query['layout'];
			}
			$link .= '&Itemid='.$item->id;
		};

		return $link;
	}

	function getCategoryRoute($catid, $sectionid, $itemid = 9999)
	{
		$needles = array(
			'category' => (int) $catid,
			'section'  => (int) $sectionid
		);

		//Create the link
		$link = 'index.php?option=com_content&view=category&id='.$catid;

		if($item = ContentHelperRoute::_findItem($needles)) {
			if(isset($item->query['layout'])) {
				$link .= '&layout='.$item->query['layout'];
			}
			$link .= '&Itemid='.$item->id;
		}
		else
		{
			$link .= '&Itemid=' . $itemid;
		}


		return $link;
	}
}
