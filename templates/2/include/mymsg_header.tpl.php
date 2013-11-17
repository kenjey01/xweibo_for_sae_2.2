<?php 
	$reqRoute 	= APP::getRequestRoute(); 
	$curatme	= $reqRoute=='index.atme';
	$curcoment	= $reqRoute=='index.comments';
	$curcmmsend	= $reqRoute=='index.commentsend';
	$iscurcmm	= $curcoment||$curcmmsend;
	$curmsg		= $reqRoute=='index.messages';
	$curnotice	= $reqRoute=='index.notices';
?>
<div class="tab-s2">
	<span <?php if($curatme){echo 'class="current"';}?> ><span><a href="<?php echo ($curatme)? 'javascript:void(0)' : URL('index.atme');?>"><?php LO('index__atme__listTitle'); ?></a></span></span>
	<span <?php if($iscurcmm){echo 'class="current"';}?> ><span><a href="<?php echo ($iscurcmm)? 'javascript:void(0)' : URL('index.comments');?>"><?php LO('index__comment__mycomments'); ?></a></span></span>
	
	<?php if (HAS_DIRECT_MESSAGES) {?>
	<span <?php if($curmsg){echo 'class="current"';}?> ><span><a href="<?php echo ($curmsg)? 'javascript:void(0)' : URL('index.messages');?>"><?php LO('index__message__listTitle'); ?></a></span></span>
	<?php } ?>
	
	<span <?php if($curnotice){echo 'class="current"';}?> ><span><a href="<?php echo ($curnotice)? 'javascript:void(0)' : URL('index.notices');?>"><?php LO('index__notice__myNotice'); ?></a></span></span>
</div>

<?php if ($iscurcmm) {?>
	<div class="tab-s4">
		<a href="<?php echo $curcoment? 'javascript:void(0);' : URL('index.comments');?>" <?php echo $curcoment?'class="current"':''; ?>><?php LO('index__comment__comments');?></a><a href="<?php echo $curcmmsend?'javascript:void(0)':URL('index.commentsend');?>"  <?php echo $curcmmsend?'class="current"':''; ?>><?php LO('index__comment__commentsend');?></a>
	</div>
<?php } ?>