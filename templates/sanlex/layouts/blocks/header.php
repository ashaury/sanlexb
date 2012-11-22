<div id="ja-header" class="wrap">
<!--
<div class="main" style="background-image: url(<?php echo $this->templateurl(); ?>/images/header/<?php echo $this->getRandomImage($this->templatepath().DS.'images/header'); ?>);">
//-->
<div class="main" >
<div class="inner clearfix">
	<!--<img src="<?php echo $this->templateurl(); ?>/images/sanlexlogo.png" class="sanlexlogo" />//-->
    <img src="<?php echo $this->templateurl(); ?>/images/logo/<?php echo $this->getRandomLogo($this->templatepath().DS.'images/logo'); ?>" class="sanlexlogo" />
    <!-- MAIN NAVIGATION -->
	<?php $this->loadBlock('mainnav') ?>
	<!-- //MAIN NAVIGATION -->
	<div class="ja-headermask">&nbsp;</div>
	<?php
	$siteName = $this->sitename();
	?>
<!--
	<?php
	if ($this->getParam('logoType')=='image'): ?>
	<h1 class="logo">
		<a href="index.php" title="<?php echo $siteName; ?>"><span><?php echo $siteName; ?></span></a>
	</h1>
	<?php else:
	$logoText = (trim($this->getParam('logoType-text-logoText'))=='') ? $config->sitename : $this->getParam('logoType-text-logoText');
	$sloganText = (trim($this->getParam('logoType-text-sloganText'))=='') ? JText::_('SITE SLOGAN') : $this->getParam('logoType-text-sloganText');?>
	<div class="logo-text">
		<h1><a href="index.php" title="<?php echo $siteName; ?>"><span><?php echo $logoText; ?></span></a></h1>
		<p class="site-slogan"><?php echo $sloganText;?></p>
	</div>
	<?php endif; ?>
//-->	
	<?php //$this->loadBlock('usertools/screen') ?>
	<?php //$this->loadBlock('usertools/font') ?>
	<!-- <div id="inner-header"> //-->
	<?php if($this->countModules('search')) : ?>
	<div id="ja-search">
		<jdoc:include type="modules" name="search" />
	</div>
	<?php endif; ?>
   	<!--
    <img id="arca-symb" src="<?php echo $this->templateurl(); ?>/images/arcasimbol.png" />
	</div> //-->
</div>

</div>
</div>
