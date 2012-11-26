<?php
/*
#------------------------------------------------------------------------
  JA Purity II for Joomla 1.5
#------------------------------------------------------------------------
#Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
#@license - GNU/GPL, http://www.gnu.org/copyleft/gpl.html
#Author: J.O.O.M Solutions Co., Ltd
#Websites: http://www.joomlart.com - http://www.joomlancers.com
#------------------------------------------------------------------------
*/


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$this->_basewidth = 20;
$positions = array (
	'left1'					=>'left',
	'left2'					=>'',
	'left-mass-top'			=>'',
	'left-mass-bottom'		=>'',
	'right1'				=>'right',
	'right2'				=>'',
	'right-mass-top'		=>'',
	'right-mass-bottom'		=>'',
	'content-mass-top'		=>'',
	'content-mass-bottom'	=>'',
	'content-top'			=>'top',
	'content-bottom'		=>'bottom',
	'inset1'				=>'',
	'inset2'				=>''
);
//$this->customwidth('right1', 25); <== override right1 column width to 25%. Must call before call definePosition. Can call many time to override many columns.
$this->definePosition ($positions);
?>

<?php if ($this->isIE() && ($this->getParam('direction')=='rtl' || $this->direction == 'rtl')) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php } ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">

<head>
<?php $this->loadBlock('head') ?>
</head>

<body id="bd" style=" background-image: url(<?php echo $this->templateurl(); ?>/images/header/<?php 
echo $this->getRandomImage($this->templatepath().DS.'images/header'); ?>);" class="fs<?php echo $this->getParam(JA_TOOL_FONT);?> <?php echo $this->browser();?>;">

<div id="ja-wrapper">
	<a name="Top" id="Top"></a>

	<!-- HEADER -->
	<?php $this->loadBlock('header') ?>
	<!-- //HEADER -->

	<?php $this->loadBlock('topsl') ?>

	<!-- mepet sebelah kiri //-->
    <?php $this->loadBlock('sidekiri') ?>
    <!-- //mepet sebelah kiri //-->

	<!-- mepet sebelah kanan //-->
    <?php $this->loadBlock('sidekanan') ?>
    <!-- //mepet sebelah kanan //-->


	<!-- MAIN CONTAINER -->
    <?php
    $spotlight = array ('user3');
	$sliderul = $this->calSpotlight ($spotlight,100);
	if( $sliderul ) :
	?>
    
    <div style="position:relative; height:550px">
    <div id="ultimate-slider">
	<jdoc:include type="modules" name="user3" style="JAxhtml" />
    </div>
    </div>
    
    <?php
	endif;
	?>
	<div id="ja-container" class="wrap <?php echo $this->getColumnWidth('cls_w'); ?>">    
    <div class="main clearfix">
		<div id="ja-mainbody" style="width:<?php echo $this->getColumnWidth('mw') ?>%">
			<?php $this->loadBlock('main') ?>
			<?php $this->loadBlock('left') ?>
	    <?php
    $spotlight2 = array ('user4','user5');
	$top = $this->calSpotlight ($spotlight2,100);
	if( $top ) :
	?>
    <div style="position:relative;width:1024px;margin:auto;">
    	<div id="top-a">
        <jdoc:include type="modules" name="user4" style="JAxhtml" />
    	</div>
 	
        <div id="top-b">
        <jdoc:include type="modules" name="user5" style="JAxhtml" />
    	</div>
    </div>
    <?php
	endif;
	?>
    	</div>

		<?php $this->loadBlock('right') ?>

	</div>
	</div>


	<!-- //MAIN CONTAINER -->


	<!-- FOOTER -->

	<!-- MAIN NAVIGATION -->
	<?php //$this->loadBlock('mainnav') ?>
	<!-- //MAIN NAVIGATION -->
	<?php $this->loadBlock('botsl') ?>
	<div style="clear:both"></div>
	<?php $this->loadBlock('footer') ?>

	<!-- //FOOTER -->

</div>

<jdoc:include type="modules" name="debug" />

<?php if ($this->isIE6()) : ?>
	<?php $this->loadBlock('ie6/ie6warning') ?>
<?php endif; ?>


</body>

</html>
