<div class="ja-navhelper wrap">
<div class="main clearfix">
<!--
	<div class="ja-breadcrums">
		<strong><?php echo JText::_('Arca :')?></strong> <jdoc:include type="module" name="breadcrumbs" />
	</div>
    <ul class="ja-links">
		<li class="layout-switcher"><?php $this->loadBlock('usertools/layout-switcher') ?>&nbsp;</li>
		<li class="top"><a href="<?php echo $this->getCurrentURL();?>#Top" title="Back to Top" onclick="javascript:scroll(0,0)"><?php echo JText::_('BACK TO TOP')?></a></li>
	</ul>
	
	<ul class="no-display">
		<li><a href="<?php echo $this->getCurrentURL();?>#ja-content" title="<?php echo JText::_("Skip to content");?>"><?php echo JText::_("Skip to content");?></a></li>
	</ul>
//-->
</div>
</div>

<?php // fix paling bawah
?>
<div class="fix-bot">


<div id="control-bottom"><a id="bottom-token" style="cursor:pointer;"></a></div>
<div id="body-bottom">
<div class="main clearfix">
<div style="position:relative;">
<div id="rh-think">
<img src="<?php echo $this->templateurl(); ?>/images/logo-think.png" />
</div>
</div>
<?php
$spotlight = array ('user6','user7','user8','user9');
$botsl = $this->calSpotlight ($spotlight,100);
if( $botsl ) :
?>
	<div id="con-bottom">
	<?php if( $this->countModules('user6') ): ?>
	<div class="ja-box column ja-box<?php echo $botsl['user6']['class']; ?>" style="width: <?php echo $botsl['user6']['width']; ?>;">
		<jdoc:include type="modules" name="user6" style="JAxhtml" />
	</div>
	<?php endif; ?>

	<?php if( $this->countModules('user7') ): ?>
	<div class="ja-box column ja-box<?php echo $botsl['user7']['class']; ?>" style="width: <?php echo $botsl['user7']['width']; ?>;">
		<jdoc:include type="modules" name="user7" style="JAxhtml" />
	</div>
	<?php endif; ?>

	<?php if( $this->countModules('user8') ): ?>
	<div class="ja-box column ja-box<?php echo $botsl['user8']['class']; ?>" style="width: <?php echo $botsl['user8']['width']; ?>;">
		<jdoc:include type="modules" name="user8" style="JAxhtml" />
	</div>
	<?php endif; ?>

	<?php if( $this->countModules('user9') ): ?>
	<div class="ja-box column ja-box<?php echo $botsl['user9']['class']; ?>" style="width: <?php echo $botsl['user9']['width']; ?>;">
		<jdoc:include type="modules" name="user9" style="JAxhtml" />
	</div>
	<?php endif; ?>
    </div>
 <?php endif; ?> 
	</div>
</div>


 <!--<script language="javascript" type="text/javascript" src="<?php echo $this->templateurl(); ?>/js/jquery-1.5.2.min.js"></script>
 //-->
					<script type="text/javascript">
					jQuery.noConflict();
					jQuery("#rh-think").click(function(){
      				if (jQuery("#con-bottom").is(":visible")) {
            		jQuery("#con-bottom").slideUp();
      				jQuery("#bottom-token").css("background-image","url(<?php echo $this->templateurl(); ?>/images/down.png)");
					} 
      				else {
            		jQuery("#con-bottom").slideDown();
	   				jQuery("#bottom-token").css("background-image","url(<?php echo $this->templateurl(); ?>/images/up.png)");
      				}
					jQuery("html,body").animate({scrollTop:jQuery(document).height()},"slow");
					});
</script>

<div id="ja-footer" class="wrap">
<div class="main clearfix">
<div style="position:relative;">
<img id="rh-logo" src="<?php echo $this->templateurl(); ?>/images/logo-rh.jpg" />
</div>

	
<div class="inner">
	<div class="ja-copyright">
		<jdoc:include type="modules" name="footer" />
	</div>   
	<div class="ja-footnav">
	<jdoc:include type="modules" name="user1" />
	</div>


</div>

</div>
</div>

</div>
<?php //fix paling bawah end
?>
