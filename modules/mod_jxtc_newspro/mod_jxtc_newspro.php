<?PHP
/*
 JoomlaXTC News Pro Module
 version 1.2 for Joomla 1.5
 copyright (c) 2008 JoomlaXTC   www.joomlaxtc.com
*/

defined('_JEXEC') or die('Restricted access');
global $mainframe;
require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

if (!function_exists('jxtcParseRow')) {
	function jxtcParseRow($row,$html,$aid,$maxintro) {
		global $mainframe;
		if (empty($row)) return;
		if($row->access <= $aid) {
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
		} else {
			$link = JRoute::_('index.php?option=com_user&view=login');
		}
		$intro = $row->introtext;
		$ini=strpos(strtolower($row->introtext),'<img');
		if ($ini === false) $img = '';
		else {
			$ini = strpos($row->introtext,'src="',$ini)+5;
			$fin = strpos($row->introtext,'"',$ini);
			$img = substr($row->introtext,$ini,$fin-$ini);
			$fin = strpos($row->introtext,'>',$fin);
			$intro = substr($row->introtext,$fin+1);
		}
		if (!empty($maxintro)) $intro = trim(substr($intro,0,$maxintro)).'...';
		
		$hold = $html;
		$hold = str_replace( '{link}', $link, $hold );
		$hold = str_replace( '{title}', htmlspecialchars($row->title), $hold );
		$hold = str_replace( '{intro}', $row->introtext, $hold );
		$hold = str_replace( '{introtext}', '<p class="jnpIntro">'.$intro.'</p>', $hold );
		$hold = str_replace( '{introimage}', $img, $hold );
		$hold = str_replace( '{section}', $row->sec_title, $hold );
		$hold = str_replace( '{category}', $row->cat_title, $hold );
		$hold = str_replace( '{date}', $row->created, $hold );
		$hold = str_replace( '{moddate}', $row->modified, $hold );
		$hold = str_replace( '{author}', $row->author, $hold );
		$hold = str_replace( '{authorid}', $row->authorid, $hold );
		$params = $mainframe->getParams('com_content');
		$dispatcher =& JDispatcher::getInstance();
		JPluginHelper::importPlugin('content');
		$row = new stdClass();
		$row->text = $hold;
		$results = $dispatcher->trigger('onPrepareContent', array (&$row, & $params, 0 ));
		$hold = $row->text;
		return $hold;
	}
}

if (!function_exists('jxtcDrawMores')) {
	global $mainframe;
	function jxtcDrawMores($data) {
		if ($data['moretext']) {
			echo '<img src="modules/mod_jxtc_newspro/images/article-grey.gif">&nbsp;&nbsp;<a style="color:#'.$data['morergb'].'">'.$data['moretext'].'</a><br/>';
		}
		echo '<table class="jnpMore" border="0" cellpadding="0" cellspacing="0"><tr>';
		$i=1;
		$c=1;
		foreach ( $data['mores'] as $row ) {
			if ($c==1) {
				echo '<tr>';
			}
			echo '<td valign="top">'.jxtcParseRow($row,$data['morehtml'],$data['aid'],$data['moreintro']).'</td>';
			$i++;$c++;
			if ($c > $data['morecols']) {
				echo '</tr>';
				$c=1;
			}
		}
		if ($c > 1) echo '</tr>';
		echo '</table>';
	}
}

if (!function_exists('jxtcDrawMain')) {
	function jxtcDrawMain($rows,$data) {
		global $mainframe;

		if ($data['pages'] > 1) {
			if (!defined('JXTCNPJS')) {
				JHTML::_('behavior.mootools');
				$mainframe->addCustomHeadTag('<script type="text/javascript" src="modules/mod_jxtc_newspro/js/_class.noobSlide.js"></script>');
				define('JXTCNPJS',1);
			}
?>
	<script type="text/javascript">
	window.addEvent('domready',function(){
			var <?php echo $data['uid']; ?> = new noobSlide({
<?php
			echo "box: $('",$data['uid'],"'),";
			if ($data['mode'] == 'v') {
				$size = $data['height'];
				$mode = ",mode: 'vertical'";
			}
			else {
				$size = $data['width'];
				$mode = '';
			}
			$items = range(1,$data['pages']);
			echo "items: [",implode(',',$items),"]";
			if ($data['slidemode'] == 'a') {
				echo ",autoPlay: true";
			}
			else {
				echo ",buttons: {previous: $('",$data['uid'],"prev'),next: $('",$data['uid'],"next')}";
			}
			echo ",size: ",$size;
			echo $mode;
			if ($data['pause'] > 0) {
				echo ",interval: ",$data['pause'];
			}
?>
		});
	});
	</script>
<?php
			if ($data['slidemode']=='a') {
					echo '<div class="jnpMain" style="position:relative;width:'.$data['width'].'px;height:'.$data['height'].'px;overflow:hidden;text-align:left;margin:0px">';
			}
			else {
				switch ($data['buttonpos']) {
					case "2":	// top
					echo '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="jpnPrev">';
					echo '<img id="'.$data['uid'].'prev" style="float:right;cursor:pointer" src="modules/mod_jxtc_newspro/buttons/'.$data['button'].'/prev.gif" />';
					echo '</td><td class="jpnNext">';
					echo '<img id="'.$data['uid'].'next" style="float:left;cursor:pointer" src="modules/mod_jxtc_newspro/buttons/'.$data['button'].'/next.gif" />';
					echo '</td></tr>';
					echo '<tr><td colspan="2">';
					echo '<div class="jnpMain" style="position:relative;width:'.$data['width'].'px;height:'.$data['height'].'px;overflow:hidden;text-align:left;margin:0px">';
					break;
					case "3":	// bottom
					echo '<table border="0" cellpadding="0" cellspacing="0"><tr><td colspan="2">';
					echo '<div class="jnpMain" style="position:relative;width:'.$data['width'].'px;height:'.$data['height'].'px;overflow:hidden;text-align:left;margin:0px">';
					break;
					case "4":	// top/bottom
					echo '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="jpnPrev">';
					echo '<img id="'.$data['uid'].'prev" style="float:right;cursor:pointer" src="modules/mod_jxtc_newspro/buttons/'.$data['button'].'/prev.gif" />';
					echo '</td></tr><tr><td>';
					echo '<div class="jnpMain" style="position:relative;width:'.$data['width'].'px;height:'.$data['height'].'px;overflow:hidden;text-align:left;margin:0px">';
					break;
				}
			}
			echo '<div id="'.$data['uid'].'" style="position:absolute">';
			for ($p=1;$p<=$data['pages'];$p++) {
				echo '<div style="float:left;width:'.$data['width'].'px;height:'.$data['height'].'px;margin:0px;padding:0px">';				
				for ($r=1;$r<=$data['rows'];$r++) {
					for ($c=1;$c<=$data['columns'];$c++) {
						$row = array_shift($rows);
						if (!empty($row)) {
							echo '<div class="jnpContent" style="margin:0px;padding:0px;float:left;width:',$data['cellw'],'px;height:',$data['cellh'],'px">'.jxtcParseRow($row,$data['html'],$data['aid'],$data['maxintro']).'</div>';
						}
					}
				}
				echo '</div>';
			}
			echo '</div>';
			if ($data['slidemode']=='a') {
					echo '</div>';
			}
			else {
				switch ($data['buttonpos']) {
					case "2": // top
					echo '</div>';
					echo '</td></tr></table>';
					break;
					case "3": // bottom
					echo '</div>';
					echo '</td></tr><tr><td class="jpnPrev">';
					echo '<img id="'.$data['uid'].'prev" style="float:right;cursor:pointer" src="modules/mod_jxtc_newspro/buttons/'.$data['button'].'/prev.gif" />';
					echo '</td><td class="jpnNext">';
					echo '<img id="'.$data['uid'].'next" style="float:left;cursor:pointer" src="modules/mod_jxtc_newspro/buttons/'.$data['button'].'/next.gif" />';
					echo '</td></tr></table>';
					break;
					case "4": // top/bottom
					echo '</div>';
					echo '</td></tr><tr><td class="jpnNext">';
					echo '<img id="'.$data['uid'].'next" style="float:left;cursor:pointer" src="modules/mod_jxtc_newspro/buttons/'.$data['button'].'/next.gif" />';
					echo '</td></tr></table>';
					break;
				}
			}
		}
		else {
			echo '<table class="jnpMain" style="border:none;width="',$data['width'],'px;height:',$data['height'],'px">';
			for ($r=1;$r<=$data['rows'];$r++) {
				echo '<tr>';
				for ($c=1;$c<=$data['columns'];$c++) {
					echo '<td class="jnpContent">',jxtcParseRow(array_shift($rows),$data['html'],$data['aid'],$data['maxintro']),'</td>';
				}
				echo '</tr>';
			}
			echo '</table>';
		}
	}
}

$db				=& JFactory::getDBO();
$data['user']			=& JFactory::getUser();
$data['userId']		= $data['user']->get('id');
$data['width']	= $params->get('width',100);
$data['height']	= $params->get('height',100);
$data['columns'] = $params->get('columns',1);
$data['rows']		= $params->get('rows', 1);
$data['pages']		= $params->get('pages', 1);
$data['class'] 		= trim($params->get('moduleclass_sfx'));
$data['mode']	= $params->get('mode','h');
$data['slidemode']	= $params->get('slidemode','a');
$data['pause']	= $params->get('pause',5000);
$data['buttonpos']	= $params->get('buttonpos',3);
$data['button']		= $params->get('button','default');
$secid = $params->get('secid');
$catid = $params->get('catid');
$data['user_id'] = $params->get( 'user_id' );
$data['showfront']	= $params->get('show_front', 1);
$data['ordering'] = $params->get( 'ordering' );
$data['html']			= trim( $params->get('html','{intro}') );
$data['maxintro']	= trim( $params->get('maxintro') );
$morepos = $params->get('morepos', 'b');
$data['more']			= $params->get('more', 0);
$data['morecols']	= trim( $params->get('morecols',1) );
$data['moretext']	= trim($params->get('moretext', ''));
$data['morergb']	= trim( $params->get('morergb','cccccc') );
$data['morehtml']	= $params->get('morehtml', '{title}');
$data['moreintro']	= trim( $params->get('moreintro') );

$data['aid'] = $data['user']->get('aid', 0);
$data['contentconfig'] = &JComponentHelper::getParams( 'com_content' );
$data['uid'] = uniqid('jnp');
$data['cellw'] = $data['width']/$data['columns'];
$data['cellh'] = $data['height']/$data['rows'];
$accesslevel		= !$data['contentconfig']->get('show_noauth');
$nullDate	= $db->getNullDate();
$date =& JFactory::getDate();
$now = $date->toMySQL();

// Build query
$where		= 'a.state = 1'
	. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
	. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
	;

// User Filter
switch ($data['user_id']) {
	case 'by_me':
		$where .= ' AND (created_by = ' . (int) $data['userId'] . ' OR modified_by = ' . (int) $data['userId'] . ')';
		break;
	case 'not_me':
		$where .= ' AND (created_by <> ' . (int) $data['userId'] . ' AND modified_by <> ' . (int) $data['userId'] . ')';
		break;
}

// Ordering
switch ($data['ordering']) {
	case 'm_dsc':
		$ordering		= 'a.modified DESC, a.created DESC';
		break;
	case 'c_dsc':
	default:
		$ordering		= 'a.created DESC';
		break;
}

if ($catid) {
	$ids = explode( ',', $catid );
	JArrayHelper::toInteger( $ids );
	$catCondition = ' AND (cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
}
if ($secid) {
	$ids = explode( ',', $secid );
	JArrayHelper::toInteger( $ids );
	$secCondition = ' AND (s.id=' . implode( ' OR s.id=', $ids ) . ')';
}

// Content Items only
$query = 'SELECT a.*, cc.title as cat_title, s.title as sec_title, u.name as author, u.username as authorid,' .
	' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
	' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
	' FROM #__content AS a' .
	($data['showfront'] == '0' ? ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
	' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
	' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
	' INNER JOIN #__users AS u ON u.id = a.created_by' .
	' WHERE '. $where .' AND s.id > 0' .
	($accesslevel ? ' AND a.access <= ' .(int) $data['aid']. ' AND cc.access <= ' .(int) $data['aid']. ' AND s.access <= ' .(int) $data['aid'] : '').
	($catid ? $catCondition : '').
	($secid ? $secCondition : '').
	($data['showfront'] == '0' ? ' AND f.content_id IS NULL ' : '').
	' AND s.published = 1' .
	' AND cc.published = 1' .
	' ORDER BY '. $ordering;
	$data['limit'] = $data['columns']*$data['rows']*$data['pages'];
$db->setQuery($query, 0, $data['limit']+$data['more']);
$items = $db->loadObjectList();

if (count($items) == 0) return;	// Return empty

$rows = array_slice($items,0,$data['limit']);
$data['mores'] = array_slice($items,$data['limit']);

switch ($morepos) {
	case 't':
	if (count ($data['mores']) > 0) {
		jxtcDrawMores($data);
	}
	jxtcDrawMain($rows,$data);
	break;
	case 'l':
	if (count ($data['mores']) > 0) {
		echo '<div style="float:left">';
		jxtcDrawMores($data);
		echo '</div><div style="float:left">';
		jxtcDrawMain($rows,$data);
		echo '</div>';
	}
	else {
		jxtcDrawMain($rows,$data);
	}		
	break;
	case 'r':
	if (count ($data['mores']) > 0) {
		echo '<div style="float:left">';
		jxtcDrawMain($rows,$data);
		echo '</div><div style="float:left">';
		jxtcDrawMores($data);
		echo '</div>';
	}
	else {
		jxtcDrawMain($rows,$data);
	}		
	break;
	case 'b':
	jxtcDrawMain($rows,$data);
	if (count ($data['mores']) > 0) {
		jxtcDrawMores($data);
	}
	break;
	default:
	jxtcDrawMain($rows,$data);
	break;
}
