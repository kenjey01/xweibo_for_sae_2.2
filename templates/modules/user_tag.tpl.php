<?php if (USER::isUserLogin()):?>
<?php
$myself = true; 
if (isset($userinfo) && !empty($userinfo)) {
	$myself = $userinfo['id'] == USER::uid() ? $myself : false;
	$name = $userinfo['screen_name'];
	/// 获取标签
	$taglist = DR('xweibo/xwb.getTagsList', '', $userinfo['id']);
} else {
	$name = L('modules__userTag__me');
	/// 获取标签
	$taglist = DR('xweibo/xwb.getTagsList', '', USER::uid());
}
$taglist = $taglist['rst'];
?>
<?php if ($myself || (!$myself && !empty($taglist))):?>
<div class="mod-aside user-tag">
	<div class="hd">
	<h3><?php LO('modules__userTag__whoTag', F('escape', $name));?></h3>
	</div>
	<div class="bd">
		<?php if ($taglist):?>
		<?php foreach($taglist as $tag):?>
			<?php foreach ($tag as $key => $item):?>
				<a href="<?php echo URL('search.user', array('k' => $item, 'ut' => 'tags'));?>"><?php echo $item;?></a>
			<?php endforeach;?>
		<?php endforeach;?>
		<?php else:?>
			<p><?php LO('modules__userTag__emptyTip', URL('setting.tag'));?></p>
		<?php endif;?>
	</div>
	<?php if (!empty($taglist) && $myself):?>
	<div class="tag-set">
	<a href="<?php echo URL('setting.tag');?>"><?php LO('modules__userTag__set');?></a>
	</div>
	<?php endif;?>
</div>
<?php endif;?>
<?php endif;?>
