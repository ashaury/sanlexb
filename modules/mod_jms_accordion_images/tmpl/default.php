<?php // no direct access
/**
* @version		1.0
* @package		JMS accordion images Module
* @copyright	Joommasters.com
*/

defined('_JEXEC') or die('Restricted access'); 
$height 	= $params->get('height',260);
$width 	= (int)$params->get('width',923);
$desc_height= $params->get('desc_height',30);
$maxwidth 	= (int)$params->get('maxwidth',600);
?>
<script type="text/javascript" >
var $j = jQuery.noConflict();

$j(document).ready(function(){
    slides = $j(".featured");
    slides_desc = $j(".slide_desc");
    gallery_width = parseInt(<?php echo $width;?>);
    slides_count  = slides.length;	
	slide_width   = gallery_width/slides_count;
	max_width  	  = parseInt(<?php echo $maxwidth;?>);
	min_width   = (gallery_width - max_width)/(slides_count-1) ;
	
	for(i = 0; i < slides_count ; i++) {
		$j(slides[i]).animate({left: i*slide_width + "px",width:slide_width + 'px'}, { queue:false, duration:100 });
	}
	
    $j("div#jmsaccordion div.featured").mouseover(
      function(){
 		slide_id = this.id;
 		current_id = parseInt(slide_id.substring(5,slide_id.length));
 		if(current_id == 0 ) {
			var left_move = 0	
		} else {
			var left_move = current_id*min_width; 	
		}
 		$j(this).animate({left: left_move + "px",width:max_width + 'px'}, { queue:false, duration:100});
 		
 		for(i = 0; i < current_id ; i++) {
 			$j(slides[i]).animate({left: i*min_width + "px",width:min_width + 'px'}, { queue:false, duration:100 });
 		}
		
		var j = 0 ;
		for(i = current_id + 1; i < slides_count ; i++) {
			$j(slides[i]).animate({left: left_move + max_width + j*min_width + "px",width:min_width + 'px'}, { queue:false, duration:100 });
			j++;
		}
		$j(slides_desc[current_id]).css({opacity:0.9});
      }
    );
    
    $j("div#jmsaccordion div.featured").mouseout (
      function(){
         for(i = 0; i < slides_count ; i++) {
			$j(slides[i]).animate({left: i*slide_width + "px",width:slide_width + 'px'}, { queue:false, duration:100 });
			$j(slides_desc[i]).css({opacity:0.6});
		}
      }
    );
});
</script>
<div id="jmsaccordion" style="width:<?php echo $width;?>px; height:<?php echo $height; ?>px;">
<?php for($i=0;$i<count($list);$i++) {?>
  <div class="featured" id="slide<?php echo $i;?>" style="height:<?php echo $height; ?>px; z-index:<?php echo ($i+1);?>;">
  	<div class="slide-inner">
	   <a href="<?php echo $list[$i]['url'];?>">
	   	<span class="faceout" style=" height:<?php echo $height; ?>px;"></span>
	  	<img src="images/stories/jms_accordion/<?php echo $list[$i]['img'];?>" />
	  	<span class="slide_desc" style="height:<?php echo $desc_height;?>px;">
	  		<?php echo $list[$i]['caption'];?>
	  	</span>
  		</a>	
  	</div>
  </div>
 <?php } ?>
</div>
