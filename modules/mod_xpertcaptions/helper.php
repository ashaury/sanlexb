<?php
/**
 * @package Xpert Captions
 * @version 1.1
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

class modXpertCaptionsHelper{
    public static function getLists($params){
        global $mainframe;

        $db         =& JFactory::getDBO();
        $user       =& JFactory::getUser();
        $userId     =  (int) $user->get('id');
        $aid        =  $user->get('aid', 0);
        $nullDate   =  $db->getNullDate();
        $date       =& JFactory::getDate();
        $now        =  $date->toMySQL();
        $contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('shownoauth');
        
        $count		    = $params->get('count', 3);
        $content_source = $params->get('content_source','joomla');
        $jcat_id		= trim( $params->get('joomla_cat_id') );
        $show_front	    = $params->get('show_front', 1);
        $jordering      = $params->get('item_ordering');
        $k2cat_id       = $params->get('k2_cat_id');
        $k2ordering     = $params->get('k2_item_ordering');
        $where          = '';

        // ensure should be published
		$where .= " AND ( a.publish_up = ".$db->Quote($nullDate)." OR a.publish_up <= ".$db->Quote($now)." )";
		$where .= " AND ( a.publish_down = ".$db->Quote($nullDate)." OR a.publish_down >= ".$db->Quote($now)." )";

        //joomla specific
        if($content_source == 'joomla')
        {
            require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
            // ordering
            switch ($jordering) {
                case 'date' :
                    $orderby = 'a.created ASC';
                    break;
                case 'rdate' :
                    $orderby = 'a.created DESC';
                    break;
                case 'alpha' :
                    $orderby = 'a.title';
                    break;
                case 'ralpha' :
                    $orderby = 'a.title DESC';
                    break;
                case 'order' :
                    $orderby = 'a.ordering';
                    break;
                default :
                    $orderby = 'a.id DESC';
                    break;
            }
            $cat_condition = '';
            if ($show_front != 2) {
        		if ($jcat_id)
        		{
        			$ids = explode( ',', $jcat_id );
        			JArrayHelper::toInteger( $ids );
        			$cat_condition = ' AND (cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
        		}
        	}
            // Content Items only
    		$query = 'SELECT a.*, ' .
    			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
    			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug,'.
                ' CHAR_LENGTH( a.fulltext ) AS readmore ' .
    			' FROM #__content AS a' .
    			($show_front == '0' ? ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
    			($show_front == '2' ? ' INNER JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
    			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
    			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
    			' WHERE a.state = 1'. $where .' AND s.id > 0' .
    			($access ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
    			($jcat_id && $show_front != 2 ? $cat_condition : '').
    			($show_front == '0' ? ' AND f.content_id IS NULL ' : '').
    			' AND s.published = 1' .
    			' AND cc.published = 1' .
    			' ORDER BY '. $orderby;
    		// end Joomla specific

        }elseif($content_source == 'k2'){
            // start K2 specific
		    require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');

            $query = "SELECT i.*, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";

            if ($k2ordering == 'best') $query .= ", (r.rating_sum/r.rating_count) AS rating";

            if ($k2ordering == 'comments') $query .= ", COUNT(comments.id) AS numOfComments";

            $query .= " FROM #__k2_items as i LEFT JOIN #__k2_categories c ON c.id = i.catid";

            if ($k2ordering == 'best') $query .= " LEFT JOIN #__k2_rating r ON r.itemID = i.id";

            if ($k2ordering == 'comments') $query .= " LEFT JOIN #__k2_comments comments ON comments.itemID = i.id";

            $query .= " WHERE i.published = 1 AND i.access <= {$aid} AND i.trash = 0 AND c.published = 1 AND c.access <= {$aid} AND c.trash = 0";

            $query .= " AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )";
            $query .= " AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";

            if ($params->get('catfilter')) {
				if (!is_null($k2cat_id)) {
					if (is_array($k2cat_id)) {
						if ($params->get('get_children')) {
							require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'itemlist.php');
							$allChildren = array();
							foreach ($k2cat_id as $id) {
								$categories = K2ModelItemlist::getCategoryChilds($id, true);
								$categories[] = $id;
								$categories = @array_unique($categories);
								$allChildren = @array_merge($allChildren, $categories);
							}

							$allChildren = @array_unique($allChildren);
							JArrayHelper::toInteger($allChildren);
							$sql = @implode(',', $allChildren);
							$query .= " AND i.catid IN ({$sql})";

						} else {
							JArrayHelper::toInteger($k2cat_id);
							$query .= " AND i.catid IN(".implode(',', $k2cat_id).")";
						}

					} else {
						if ($params->get('get_children')) {
							require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'itemlist.php');
							$categories = K2ModelItemlist::getCategoryChilds($k2cat_id, true);
							$categories[] = $k2cat_id;
							$categories = @array_unique($categories);
							JArrayHelper::toInteger($categories);
							$sql = @implode(',', $categories);
							$query .= " AND i.catid IN ({$sql})";
						} else {
							$query .= " AND i.catid=".(int)$k2cat_id;
						}

					}
				}
			}

            if ($params->get('k2_featured_items') == '0') $query .= " AND i.featured != 1";

            if ($params->get('k2_featured_items') == '2') $query .= " AND i.featured = 1";

            if ($k2ordering == 'comments')
            $query .= " AND comments.published = 1";

            switch ($k2ordering) {
                case 'date':
                    $orderby = 'i.created ASC';
                    break;
                case 'rdate':
                    $orderby = 'i.created DESC';
                    break;
                case 'alpha':
                    $orderby = 'i.title';
                    break;
                case 'ralpha':
                    $orderby = 'i.title DESC';
                    break;
                case 'order':
                    if ($params->get('k2_featured_items') == '2')
                    $orderby = 'i.featured_ordering';
                    else
                    $orderby = 'i.ordering';
                    break;
                case 'rorder':
                    if ($params->get('k2_featured_items') == '2')
                    $orderby = 'i.featured_ordering DESC';
                    else
                    $orderby = 'i.ordering DESC';
                    break;
                case 'rand':
                    $orderby = 'RAND()';
                    break;
                case 'best':
                    $orderby = 'rating DESC';
                    break;
                case 'comments':
                    $query.=" GROUP BY i.id ";
                    $orderby = 'numOfComments DESC';
                    break;
                default:
                    $orderby = 'i.id DESC';
                    break;
            }
            $query .= " ORDER BY ".$orderby;
            
        }
        $db->setQuery($query, 0, $count);
        $items = $db->loadObjectList();
        $lists = array();
        $lists = modXpertCaptionsHelper::buildLists($params, $items);
        return $lists;

    }
    
    //function specific for Joomla and k2 content
    private static function buildLists($params, $items){
        $i = 0;
        $lists = array();
        $content_source = $params->get('content_source','joomla');

        foreach($items as $row){
            $lists[$i]->id = $row->id;
			$lists[$i]->created = $row->created;
			$lists[$i]->modified = $row->modified;
            $lists[$i]->title = htmlspecialchars( $row->title );
            
			if ($content_source=='joomla') {
			    $lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
                $lists[$i]->image = modXpertCaptionsHelper::getJoomlaImage($row->introtext);
                $lists[$i]->introtext = modXpertCaptionsHelper::prepareIntroText($row->introtext,(int)$params->get('intro_limit',100));
			} else {
			    $lists[$i]->link = JRoute::_(K2HelperRoute::getItemRoute($row->id.':'.$row->alias, $row->catid.':'.$row->categoryalias));
                $lists[$i]->image = modXpertCaptionsHelper::getK2Images($lists[$i]->id, $lists[$i]->title, $params->get('k2_img_size'));
                $lists[$i]->introtext = modXpertCaptionsHelper::prepareIntroText($row->introtext,(int)$params->get('intro_limit',100));
			}

            $i++;
        }
        return $lists;
        
    }

    public static function loadScripts($params, $module_id){
        $doc =& JFactory::getDocument();

        //load jquery first
        modXpertCaptionsHelper::loadJquery($params);
        
        $animation  = $params->get('animation');
        $speed      = (int)$params->get('speed',150);
        $opacity    = $params->get('opacity',1);
        $anchor     = $params->get('anchor','left');
        $hover_x    = "'". (int) $params->get('hover_x',0) . "px'";
        $hover_y    = "'". (int) $params->get('hover_y',0) . "px'";
        $js         = '';
        
        if($anchor == 'left' OR $anchor == 'right'){
            $anchor = "anchor_x: '$anchor'";
        }else{
            $anchor = "anchor_y: '$anchor'";
        }
        if($animation == 'xc-fade'){
            $js = "
                jQuery.noConflict();
                jQuery(document).ready(function(){
                    jQuery('#$module_id .xc-block').xpertcaptions({
                        animation: 'fade',
                        opacity: {$opacity}
                    });
                });
            ";
        }else{
            $js = "
                jQuery.noConflict();
                jQuery(document).ready(function(){
                    jQuery('#$module_id .xc-block').xpertcaptions({
                        animation: 'slide',
                        speed: {$speed},
                        {$anchor},
                        hover_x: {$hover_x},
                        hover_y: {$hover_y}
                    });
                });
            ";
        }
        $doc->addScriptDeclaration($js);

        if(!defined('XPERT_CAPTIONS')){
            //add tab engine js file
            $doc->addScript(JURI::root(true).'/modules/mod_xpertcaptions/interface/js/xpertcaptions.js');
            define('XPERT_CAPTIONS',1);
        }
    }

    public static function loadJquery($params){
        $doc =& JFactory::getDocument();    //document object
        $app =& JFactory::getApplication(); //application object

        static $jqLoaded;

        if ($jqLoaded) {
            return;
        }

        if($params->get('load_jquery') AND !$app->get('jQuery')){
            //get the cdn
            $cdn = $params->get('jquery_source');
            switch ($cdn){
                case 'google_cdn':
                    $file = 'https://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js';
                    break;
                case 'local':
                    $file = JURI::root(true).'/modules/mod_xpertcaptions/interface/js/jquery-1.6.1.min.js';
                    break;
            }
            $app->set('jQuery','1.6');
            $doc->addScript($file);
            //$doc->addScriptDeclaration("jQuery.noConflict();");
            $jqLoaded = TRUE;
        }

    }

    public static function loadStyles($params,$module_id){
        $app                = &JApplication::getInstance('site', array(), 'J');
        $template           = $app->getTemplate();
        $doc                = & JFactory::getDocument();
        $css                = '';
        $anchor             = $params->get('anchor','left');
        $anchor_position    = (int) $params->get('anchor_position',-100) . 'px';
        $width              = (int)$params->get('width',250).'px';
        $height             = (int)$params->get('height',250).'px';

        static $isStyleLoaded;

        $css .= "
            #$module_id .xc-block, #$module_id img{width:$width; height:$height;}
            #$module_id .xc-overlay{{$anchor}:{$anchor_position};}
        ";
        
        $doc->addStyleDeclaration($css);

        if($isStyleLoaded) return;

        $doc->addStyleSheet(JURI::root(true).'/modules/mod_xpertcaptions/interface/css/xpertcaptions.css');
        $isStyleLoaded = TRUE;
        
    }

    public static function getK2Images($id, $title, $image_size){
        if (file_exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$id).'_'.$image_size.'.jpg')) {
            $image_path = 'media/k2/items/cache/'.md5("Image".$id).'_'.$image_size.'.jpg';
            $image_path = JURI::Root(true).'/'.$image_path;
            return $image_path;
        }
        else{
          echo "Image not found for article $title \n";
        }

    }

    public static function prepareIntroText ($text, $num_charecter){
        $text = strip_tags($text,'</a>');

        if(strlen($text)>$num_charecter && $num_charecter!=0){
            $text1 = substr ($text, 0, $num_charecter) . "....";
            return $text1;
        }
        else return $text;
    }

    public static function getJoomlaImage($text) {

        preg_match("/\<img.+?src=\"(.+?)\".+?\/>/", $text, $matches);  

        $image_path='';

        $paths = array();

        if (isset($matches[1])) {
            $image_path = $matches[1];
            $image_path = JURI::Root(True)."/".$image_path;
        }
        return $image_path;
    }
}