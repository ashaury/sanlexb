<?php
/*
// JoomlaWorks "SuperBlogger" Plugin for Joomla! 1.5.x - Version 1.1
// no direct access
class SuperBlogger {
	// Load Includes
	function loadHeadIncludes($headIncludes){
		global $loadPluginIncludes;
		if(!$loadPluginIncludes){
			$loadPluginIncludes=1;
			$document->addCustomTag($headIncludes);
		}
	}
	// Load Module Position
		$document	= &JFactory::getDocument();
		$renderer	= $document->loadRenderer('module');
		$params		= array('style'=>$style);
	
		$contents = '';
		foreach (JModuleHelper::getModules($position) as $mod)  {
			$contents .= $renderer->render($mod, $params);
		}
	}
	
	// Word Limiter
	function wordLimiter($str,$limit=100,$end_char='&#8230;') {
		if (trim($str) == '') return $str;
		preg_match('/\s*(?:\S*\s*){'. (int) $limit .'}/', $str, $matches);
		if (strlen($matches[0]) == strlen($str)) $end_char = '';
		return rtrim($matches[0]).$end_char;
	}

	// Text Cleanup
		//e.g. $allowed_tags = "span,a,b,p,br,img,hr,h1,h2,h3,h4";
		$allowed_tags_array = explode(",",$allowed_tags);
		$allowed_htmltags = array();
		foreach($allowed_tags_array as $tag){
		}
		$allowed_htmltags = implode("",$allowed_htmltags);
		return $string;
	// Clean HTML Tag Attributes
	function cleanupAttributes($string,$tag_array,$attr_array) {
		// e.g. cleanupAttributes($string,"img,hr,h1,h2,h3,h4","style,width,height,hspace,vspace,border,class,id");
		$attr = implode("|",$attr_array);
		foreach($tag_array as $tag) {
			preg_match_all("#<($tag) .+?>#", $string, $matches, PREG_PATTERN_ORDER);
			foreach($matches[0] as $match){
				preg_match_all('/('.$attr.')=([\\"\\\']).+?([\\"\\\'])/', $match, $matchesAttr, PREG_PATTERN_ORDER);
				foreach($matchesAttr[0] as $attrToClean){
					$string = str_replace($attrToClean,'',$string);
					$string = preg_replace('|  +|', ' ', $string);
					$string = str_replace(' >','>',$string);
				}
			}
		}
		return $string;
	
	// Grab the first image in a string
	function getFirstImage($string,$minDimension=80,$maxDimension=140){
		$img = array();
		// find images
		if (preg_match_all($regex, $string, $matches, PREG_PATTERN_ORDER) > 0) {
			$img['tag'] = $matches[0][0];
			$srcPattern = '/<img[^>]+src[\\s=\'"]';
			$srcPattern.= '+([^"\'>\\s]+)/is';
			
			if(preg_match($srcPattern,$matches[0][0],$match)){
				$img['src'] = $match[1];
				list($img['width'], $img['height'], $img['type'], $img['attr']) = getimagesize($match[1]);
				/*
				$alt = '';
				if($imgWidth>$maxDimension){
					$img = '<img class="processed" src="'.$src.'" alt="'.$alt.'" />';
				} elseif($imgWidth>$minDimension && $imgWidth<$maxDimension) {
					$img = '<img src="'.$src.'" alt="'.$alt.'" />';
				} else {
					$img = '';
				}
				*/
				return $img;
	// Grab local or remote image and resize/resample it
	function generateResizedImage($url,$riWidth,$riQuality,$riPrefix,$cacheTime,$cacheFolder){
		/* legend:
		// TO DO: add GD check here
		jimport('joomla.filesystem.file');
		global $mainframe;
		$site_absolutepath = JPATH_SITE;
		$site_httppath = JURI::base();				
		// Define the directory separator
		// Cache
		}
		// Get the remote filename
		$grabUrl = parse_url($url);
		$grabUrlPath = explode("/",$grabUrl['path']);
		$grabUrlPath = array_reverse($grabUrlPath);
		// Define source and target images
		$siFilename = 'temp_sb_'.$grabUrlPath[0];
		$siPath = $cacheFolderPath.$ds.$siFilename;
		//$riPrefix = 'cache_sb_';
		$riFilename = $riPrefix.substr(md5($siFilename),0,10).'.jpg';
		$riPath = $cacheFolderPath.$ds.$riFilename;
		$riHttpPath = $site_httppath.$cacheFolder.$ds.$riFilename;
		// Check if thumb image exists otherwise create it
		if(file_exists($riPath) && is_readable($riPath) && (filemtime($riPath)+$cacheTime) > time()){
			// Grab the local or remote image
			$siTemp = imagecreatefromstring(JFile::read($url));
			if ($siTemp !== false) {
				// create source image locally
				// grab local source image details
				list($siWidth, $siHeight, $siType) = getimagesize($siPath);
				// create an image resource for the original
				$source = imagecreatefromjpeg($siPath);
				// create an image resource for the resized image
				if($riWidth>=$siWidth){
					$riWidth = $siWidth;
					$riHeight = $siHeight;
				} else {
				}
				$resized = imagecreatetruecolor($riWidth,$riHeight);
				// create the resized copy
				// save the resized copy
				// delete temp source
				// cleanup resources
		// output
		return $riHttpPath;	
	}
	// Twitter updates
		jimport('joomla.filesystem.file');
		$site_absolutepath = JPATH_SITE;
		// Assign some names
		$ds = (strtoupper(substr(PHP_OS,0,3)=='WIN')) ? '\\' : '/';
		$cacheFolderPath = $site_absolutepath.$ds.'cache'.$ds.$pluginName;
		$twitterXMLFile = $cacheFolderPath.$ds.'cache_sb_'.$twitterUsername.'.xml';
		// Check cache folder
		$cacheTime = $cacheTime*60;
		if(file_exists($cacheFolderPath) && is_dir($cacheFolderPath)){
			// all OK
		} else {
			mkdir($cacheFolderPath);
		}
		if(file_exists($twitterXMLFile) && is_readable($twitterXMLFile) && (filemtime($twitterXMLFile)+($cacheTime)) > time()){
			// XML file is cached
		//$twitterXML = new SimpleXMLElement(file_get_contents($twitterXMLFile));
		//$twitterXML = new SimpleXMLElement(JFile::read($twitterXMLFile));
		$twitterXML = new JSimpleXML;
		$twitterXML->loadFile($twitterXMLFile);
		
		$twitterName = $twitterXML->document->getElementByPath('status/user/name');
		$siteTweets['name'] = $twitterName->data();
		/*
		$twitterName = $twitterXML->xpath('/statuses/status/user/name');
		$siteTweets['name'] = $twitterName[0];
		*/
		for ($j = 0; $j < $siteTweetsLimit; $j++){
			$pattern = "@\b(https?://)?(([0-9a-zA-Z_!~*'().&=+$%-]+:)?[0-9a-zA-Z_!~*'().&=+$%-]+\@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-zA-Z_!~*'()-]+\.)*([0-9a-zA-Z][0-9a-zA-Z-]{0,61})?[0-9a-zA-Z]\.[a-zA-Z]{2,6})(:[0-9]{1,4})?((/[0-9a-zA-Z_!~*'().;?:\@&=+$,%#-]+)*/?)@";
			$siteTweetsObj[$j]->text = preg_replace($pattern, '<a target="_blank" href="\0">\0</a>', $siteTweetsObj[$j]->text);
		$siteTweets['tweets'] = $siteTweetsObj;
		// Output
		return $siteTweets;
	}
	// Path overrides
	function getTemplatePath($pluginName,$file){
		global $mainframe;
		if(file_exists(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.$pluginName.DS.str_replace('/',DS,$file))){
			$p->http = JURI::base()."templates/".$mainframe->getTemplate()."/html/{$pluginName}/{$file}";
			$p->file = JPATH_SITE.DS.'plugins'.DS.'content'.DS.$pluginName.DS.'tmpl'.DS.$file;
			$p->http = JURI::base()."plugins/content/{$pluginName}/tmpl/{$file}";
		}
		return $p;
	}
} // end class