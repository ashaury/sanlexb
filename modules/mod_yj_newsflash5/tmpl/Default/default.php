<?php
/*======================================================================*\
|| #################################################################### ||
|| # Copyright (C) 2006-2010 Youjoomla LLC. All Rights Reserved.        ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- THIS IS NOT FREE SOFTWARE ---------------- #      ||
|| # http://www.youjoomla.com | http://www.youjoomla.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<!-- http://www.Youjoomla.com  Youjoomla YJ Newsflash5 ver 2.0 for Joomla 1.5 starts here -->

<div id="YJ_NewsFlash5<?php echo $yj5_iscopy ?>">
	<!--nav links -->
    <div class="yjnf5_nav<?php echo $yj5_iscopy ?>">
		<div class="yjmf5_nav_b">
			<a href="#" id="up<?php echo $yj5_iscopy ?>">up</a>
			<a href="#" id="down<?php echo $yj5_iscopy ?>">down</a> 
		</div>
    </div>
	<!-- module content -->
	<div id="yjnf5_co<?php echo $yj5_iscopy ?>" style="height:<?php echo $yj5_height ?>;">
		<div id="yjnf5_ci<?php echo $yj5_iscopy ?>">
			<?php $i = 1;
			$numberof = count($yjnf5_items);
			foreach ($yjnf5_items as $item5_get): // this is the loop for each module news item 
			if($i == $numberof){
				$last = ' last';
			}else{
				$last = '';
			}
			$i++;?>
			<div class="yjnewsflash5">
				<div class="yjnewsflash5_in yjnfitem<?php echo $item5_get['item_id']// news item id. We add this to div class so it can be used for individual item styling?><?php echo $last ?>">
					<?php if ($showtitle == 1 ): // if news item title is enabeled ?>
					<a class="itemtitle" href="<?php echo $item5_get['item_link'] // news item url ?>">
						<?php echo $item5_get['item_title']// news item title ?>
					</a>
					<?php endif; ?>
					<?php  if (isset($item5_get['item_img']) && $item5_get['item_img'] != "" && $showimage == 1) : // this condition checks if image is available or if Show image intro is set to yes ?>
					<div class="imageholder" style="width:<?php echo $imgwidth // image width ?>;height:<?php echo $imgheight // image height ?>;float:<?php echo $align // image float ?>;">
						<a class="itemimage"  style="width:<?php echo $imgwidth ?>;height:<?php echo $imgheight ?>;" href="<?php echo $item5_get['item_link'] ?>" >
							<img src="<?php echo $item5_get['item_img'] // image output ?>" alt="" />
						</a>
					</div>
					<?php endif;?>
					<?php if ($showintro == 1 ): //checks if Show introtext is set to yes is ?>
					<p class="itemintro">
						<?php echo $item5_get['item_intro'] // news item intro?>
					</p>
					<?php endif; ?>
					<?php if ($show_cat_title == 1 || $showdate == 1 ): // Checks if Show date and show category title is set to yes ?>
					<div class="itemdetails">
						<?php if ($show_cat_title == 1): // Checks if show category title?>
						<div class="itemcategory">
						<?php echo $item5_get['item_ctitle'] // Category title ?>&nbsp;-&nbsp;
						</div>
						<?php endif; ?>
						<?php if ($showdate == 1): // Checks if Show date is set to yes ?>
						<div class="itemcdate">
						<?php echo $item5_get['item_date'] // News item create date?>
						</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<?php if ($showrm == 1 ): ?>
					<a class="itemreadmore" href="<?php echo $item5_get['item_link']?>">
						<span>
							<?php echo JText::_('YJNF5READMORE'); // Read more text set in module language file ?>
						</span>
					</a>
					<?php endif; ?>
					<?php if ($showcomments == 1): // Checks if Show JComments count is set to yes?>
					<div class="itemcomments<?php if (!JFolder::exists(JPATH_SITE.DS.'components'.DS.'com_jcomments')): //Checks if JComments is available?>_no<?php endif; ?>">
					<?php echo $item5_get['item_comment'] // News items comments count?>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach;?>
		</div> 
	</div> 
</div> 	