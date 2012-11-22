<div id="sidekiri-container" class="mepet-samping">
<!-- LEFT COLUMN-->
<?php if(($this->countModules('kiri1'))||($this->countModules('kiri2'))||($this->countModules('kiri3'))) : ?> 
<div id="content-kiri">
<?php if($this->countModules('kiri1')): ?>
<div id="kiri1">
<jdoc:include type="modules" name="kiri1" />
</div>
<?php endif; ?>
<?php if($this->countModules('kiri2')): ?>
<div id="kiri2">
<jdoc:include type="modules" name="kiri2" />
</div>
<?php endif; ?>
<?php if($this->countModules('kiri3')): ?>
<div id="kiri3">
<jdoc:include type="modules" name="kiri3" />
</div>
<?php endif; ?>
</div>
<div id="control-kiri">
<div id="kiri1-con" class="but-kiri"><img src="<?php echo $this->templateurl(); ?>/images/icon/but-tembok.png" /></div><div id="kiri2-con" class="but-kiri"><img src="<?php echo $this->templateurl(); ?>/images/icon/but-genteng.png" /></div><div id="kiri3-con" class="but-kiri"><img src="<?php echo $this->templateurl(); ?>/images/icon/but-kayu.png" /></div>
</div>
<!---
<script language="javascript" type="text/javascript" src="<?php echo $this->templateurl(); ?>/js/jquery-1.5.2.min.js"></script>
//-->
<script type="text/javascript">
jQuery.noConflict();

jQuery("#kiri1-con").click(function(){
      if (jQuery("#kiri1").is(":visible")) {
			jQuery("#kiri1").animate({width:'hide'});
			jQuery("#kiri2-con").css("visibility","visible");
			jQuery("#kiri3-con").css("visibility","visible");
      } 
      else {
            jQuery("#kiri1").animate({width:'show'});
			jQuery("#kiri2").animate({width:'hide'});
			jQuery("#kiri3").animate({width:'hide'});
			jQuery("#kiri2-con").css("visibility","hidden");
			jQuery("#kiri3-con").css("visibility","hidden");
      }
});
jQuery("#kiri2-con").click(function(){
      if (jQuery("#kiri2").is(":visible")) {
            jQuery("#kiri2").animate({width:'hide'});
			jQuery("#kiri1-con").css("visibility","visible");
			jQuery("#kiri3-con").css("visibility","visible");
      } 
      else {
            jQuery("#kiri2").animate({width:'show'});
			jQuery("#kiri1").animate({width:'hide'});
			jQuery("#kiri3").animate({width:'hide'});
			jQuery("#kiri1-con").css("visibility","hidden");
			jQuery("#kiri3-con").css("visibility","hidden");
      }
});
jQuery("#kiri3-con").click(function(){
      if (jQuery("#kiri3").is(":visible")) {
            jQuery("#kiri3").animate({width:'hide'});
			jQuery("#kiri2-con").css("visibility","visible");
			jQuery("#kiri1-con").css("visibility","visible");

      } 
      else {
            jQuery("#kiri3").animate({width:'show'});
			jQuery("#kiri2").animate({width:'hide'});
			jQuery("#kiri1").animate({width:'hide'});
			jQuery("#kiri2-con").css("visibility","hidden");
			jQuery("#kiri1-con").css("visibility","hidden");
      }
});
</script>
<?php endif; ?>
<?php /*
<div id="ja-right" class="column sidebar" style="width:<?php echo $r ?>%">

	<?php 
	$pos = $this->getPositionName ('right-mass-top');
	if ($this->countModules($pos)): ?>
	<div class="ja-mass ja-mass-top clearfix">
		<jdoc:include type="modules" name="<?php echo $pos;?>" style="JArounded" />
	</div>
	<?php endif; ?>

	<?php
	$right1 = $this->getPositionName ('right1');
	$right2 = $this->getPositionName ('right2');
	$cls_right1 = $cls_right2 = "";
	if ($this->countModules("$right1 && $right2")) {
		$cls_right1 = "ja-right1";
		$cls_right2 = "ja-right2";
	}
	if ($this->countModules("$right1 + $right2")):
	?>
	<div class="ja-colswrap clearfix <?php echo $this->getColumnWidth('cls_r'); ?>">

	<?php if ($this->countModules($right1)): ?>
		<div class="ja-col <?php echo $cls_right1;?> column" style="width:<?php echo $this->getColumnWidth('r1')?>%">
			<jdoc:include type="modules" name="<?php echo $right1;?>" style="JArounded" />
		</div>
	<?php endif; ?>

	<?php if ($this->countModules($right2)): ?>
		<div class="ja-col <?php echo $cls_right2;?> column" style="width:<?php echo $this->getColumnWidth('r2')?>%">
			<jdoc:include type="modules" name="<?php echo $right2;?>" style="JArounded" />
		</div>
	<?php endif; ?>

	</div>
	<?php endif; ?>

	<?php 
	$pos = $this->getPositionName ('right-mass-bottom');
	if ($this->countModules($pos)): ?>
	<div class="ja-mass ja-mass-bottom clearfix">
		<jdoc:include type="modules" name="<?php echo $pos;?>" style="JArounded" />
	</div>
	<?php endif; ?>

</div>
*/?>

<!-- LEFT COLUMN--> 
</div>