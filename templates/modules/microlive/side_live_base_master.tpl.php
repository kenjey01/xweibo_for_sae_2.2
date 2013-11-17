<!-- 在线主持人 开始-->
<div class="mod-aside user-list-s1">
	<div class="hd"><h3><?php LO('modules_microlive_side_live_base_master_title');?></h3></div>
	<div class="bd">
		<ul>
			<?php if ($ulist):?>
			<?php foreach ($ulist as $item):?>
			<li>
				<a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>" class="user-pic"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></a>
				<div class="user-info">
					<p class="name"><a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><?php echo F('escape', $item['screen_name']);?></a></p>
					<?php if (!empty($listFans) && in_array($item['id'], $listFans) || USER::uid() == $item['id']):?>
						<em><?php LO('common__template__followed');?></em>
					<?php else:?>
						<a rel="e:fl,t:2" class="addfollow-btn" title="<?php LO('common__template__toFollow');?>" href="#"><?php LO('common__template__toFollow');?></a>
					<?php endif;?>
					<p class="txt"><?php LO('modules_microlive_side_live_base_master_master');?></p>
				</div>
			</li>
			<?php endforeach;?>
			<?php endif;?>
		</ul>
	</div>
</div>
<!-- 在线主持人 结束-->
