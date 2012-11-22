<div id="sidekanan-container" class="mepet-samping">
<!-- RIGHT COLUMN-->
<?php if(($this->countModules('kanan1'))||($this->countModules('kanan2'))||($this->countModules('kanan3'))) : ?> 
<div id="content-kanan">
<?php if($this->countModules('kanan1')): ?>
<div id="kanan1">
<jdoc:include type="modules" name="kanan1" />
</div>
<?php endif; ?>
<?php if($this->countModules('kanan2')): ?>
<div id="kanan2">
<jdoc:include type="modules" name="kanan2" />
</div>
<?php endif; ?>
<?php if($this->countModules('kanan3')): ?>
<div id="kanan3">
<jdoc:include type="modules" name="kanan3" />
</div>
<?php endif; ?>
</div>
<div id="control-kanan">
<div id="kanan1-con" class="but-kanan"><img src="<?php echo $this->templateurl(); ?>/images/icon/but-tinting.png" /></div><div id="kanan2-con" class="but-kanan"><img src="<?php echo $this->templateurl(); ?>/images/icon/but-pelapis.png" /></div><div id="kanan3-con" class="but-kanan"><img src="<?php echo $this->templateurl(); ?>/images/icon/but-pelengkap.png" /></div>
</div>
<!--
<script language="javascript" type="text/javascript" src="<?php echo $this->templateurl(); ?>/js/jquery-1.5.2.min.js"></script>
//-->
<script type="text/javascript">
jQuery.noConflict();

jQuery("#kanan1-con").click(function(){
      if (jQuery("#kanan1").is(":visible")) {
			jQuery("#kanan1").animate({width:'hide'});
			jQuery("#kanan2-con").css("visibility","visible");
			jQuery("#kanan3-con").css("visibility","visible");
      } 
      else {
            jQuery("#kanan1").animate({width:'show'});
			jQuery("#kanan2").animate({width:'hide'});
			jQuery("#kanan3").animate({width:'hide'});
			jQuery("#kanan2-con").css("visibility","hidden");
			jQuery("#kanan3-con").css("visibility","hidden");
      }
});
jQuery("#kanan2-con").click(function(){
      if (jQuery("#kanan2").is(":visible")) {
            jQuery("#kanan2").animate({width:'hide'});
			jQuery("#kanan1-con").css("visibility","visible");
			jQuery("#kanan3-con").css("visibility","visible");
      } 
      else {
            jQuery("#kanan2").animate({width:'show'});
			jQuery("#kanan1").animate({width:'hide'});
			jQuery("#kanan3").animate({width:'hide'});
			jQuery("#kanan1-con").css("visibility","hidden");
			jQuery("#kanan3-con").css("visibility","hidden");
      }
});
jQuery("#kanan3-con").click(function(){
      if (jQuery("#kanan3").is(":visible")) {
            jQuery("#kanan3").animate({width:'hide'});
			jQuery("#kanan2-con").css("visibility","visible");
			jQuery("#kanan1-con").css("visibility","visible");

      } 
      else {
            jQuery("#kanan3").animate({width:'show'});
			jQuery("#kanan2").animate({width:'hide'});
			jQuery("#kanan1").animate({width:'hide'});
			jQuery("#kanan2-con").css("visibility","hidden");
			jQuery("#kanan1-con").css("visibility","hidden");
      }
});
</script>
<?php endif; ?>


<?php /* if($this->countModules('kanan')) : ?>

<div id="content-kanan">
<jdoc:include type="modules" name="kanan" />
</div>
<button id="clickme2">show</button>
<button id="hide2">hide</button>
<script language="javascript" type="text/javascript" src="<?php echo $this->templateurl(); ?>/js/jquery-1.5.2.min.js"></script>
<script type="text/javascript">
jQuery.noConflict();

jQuery("#clickme2").click(function(){
	//alert("in comiiing");
	jQuery("#content-kanan").show("slow");
});
jQuery("#hide2").click(function(){
	//alert("retreeaaat");
	jQuery("#content-kanan").hide(5);
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

<!-- RIGHT COLUMN--> 
</div>