<div class="emcee-list">
	<div class="tit-hd">
		<h3><?php LO('modules_microlive_live_detail_users_master');?></h3>
	</div>
	<div class="bd">
		<ul>
			<?php if ($master_list):?>
			<?php foreach ($master_list as $item):?>
			<li rel="u:<?php echo $item['id'];?>">
				<a class="user-pic" href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></a>
				<p>
					<a class="user-name" href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><?php echo F('escape', $item['screen_name']);?></a>
				</p>
				<?php echo isset($friendList[$item['id']]) ? L('modules_microlive_live_detail_users_followed') : L('modules_microlive_live_detail_users_addFollower'); ?>
			</li>
			<?php endforeach;?>
			<?php endif;?>
		</ul>
	</div>
</div>

<div class="user-sidebar">
	<div class="tit-hd">
		<h3><?php LO('modules_microlive_live_detail_users_guest');?></h3>
	</div>
	<ul>
		<?php if ($guest_list):?>
		<?php foreach ($guest_list as $item):?>
			<li rel="u:<?php echo $item['id'];?>">
				<a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></a>
				<p><a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><?php echo F('escape', $item['screen_name']);?><?php echo F('verified', $item);?></a></p>
				<?php if ( $item['id'] == USER::uid() ) { ?>
         		<span>&nbsp;</span>
				<?php } else if ( isset($friendList[$item['id']]) ) { ?>
	         		<span class="followed-btn"><?php L('modules_microlive_live_detail_users_followed');?></span>
	         	<?php } else { ?>
	         		<a href="#" class="addfollow-btn" rel="e:fl,t:1" ><?php L('modules_microlive_live_detail_users_addFollower');?></a>
	         	<?php } ?>
			</li>
		<?php endforeach;?>
		<?php endif;?>
	</ul>
</div>
