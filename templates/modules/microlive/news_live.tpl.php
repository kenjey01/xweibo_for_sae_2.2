<div>
<!-- 精彩直播 开始-->
<?php if (!empty($last_item)):?>
<div class="live-newest">
	<div class="bd">
		<div class="item">
			<h4><a href="<?php echo URL('live.details', array('id' => $last_item['id']));?>" target="_blank"><?php echo F('escape', $last_item['title']);?></a><span class="time">(<?php echo F('format_time.foramt_show_time',$last_item['start_time']);?> - <?php echo F('format_time.foramt_show_time',$last_item['end_time']);?>)</span>
		<?php if ($last_item['start_time'] <= APP_LOCAL_TIMESTAMP && $last_item['end_time'] > APP_LOCAL_TIMESTAMP):?>
		<span class="active">(<?php LO('modules_microlive_news_live_running');?>)</span>
		<?php elseif ($last_item['start_time'] > APP_LOCAL_TIMESTAMP):?>
		<span class="unplayed">(<?php LO('modules_microlive_news_live_ready');?>)</span>
		<?php else:?>
		<span class="finish">(<?php LO('modules_microlive_news_live_closed');?>)</span>
		<?php endif;?>
			</h4>
			<div class="cover">
				<a href="<?php echo URL('live.details', array('id' => $last_item['id']));?>" target="_blank"><img src="<?php echo isset($last_item['cover_img']) ? $last_item['cover_img'] : '';?>" alt="" /></a>
			</div>
			<div class="info">
				<p><?php echo F('escape', $last_item['desc']);?></p>
				<?php if ($last_item['start_time'] > APP_LOCAL_TIMESTAMP):?>
				<div class="remind">
				<?php if ($last_item['notice_time'] >= APP_LOCAL_TIMESTAMP):?>
				<a class="ico-remind" href="#" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', $last_item['title']);?>,c:<?php echo F('share_weibo', 'live_tips', $last_item);?>,n:<?php echo $last_item['notice_time'];?>"><?php LO('modules_microlive_news_live_remind');?></a>
				<?php endif;?>
					<p><?php LO('modules_microlive_news_live_timeout');?><em><?php echo $difference;?></em></p>
				</div>
				<?php endif;?>
			</div>
		</div>
		<div class="guests-list">
			<div class="list-hd">
				<h4><?php LO('modules_microlive_news_live_guest');?></h4>
			</div>
			<div class="list-bd" id="scrollor">
				<ul>
					<?php if ($list_member):?>
					<?php foreach($list_member as $item):?>
					<li>
						<a class="user-pic" href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></a>
						<p><a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><?php echo F('escape', $item['screen_name']);?><?php echo F('verified', $item);?></a></p>
					</li>
					<?php endforeach;?>
					<?php endif;?>
				</ul>
			</div>
			<a href="#" class="arrow-l-s2"><?php LO('modules_microlive_news_live_lift');?></a>
			<a href="#" class="arrow-r-s2 <?php if (count($list_member) < 6):?>arrow-r-s2-disabled<?php endif;?>"><?php LO('modules_microlive_news_live_right');?></a>
		</div>
	</div>
</div>
<?php else:?>
<div class="default-tips">
	<div class="icon-tips"></div>
	<?php if (USER::get('isAdminAccount')):?>
	<p><?php LO('modules_microlive_news_live_emptyForAdmin');?></p>
	<?php else:?>
	<p><?php LO('modules_microlive_news_live_empty');?> </p>
	<?php endif;?>
</div>
<?php endif;?>
<!-- 精彩直播 结束-->
<!-- 更多推荐 开始 -->
	<?php if (!empty($list)):?>
	<div class="tit-hd">
		<a class="more" href="<?php echo URL('live.livelist');?>"><?php LO('modules_microlive_news_live_more');?>&gt;&gt;</a>
		<h3><?php LO('modules_microlive_news_live_moreRecommend');?></h3>
	</div>
	<div class="live-list">
	<?php foreach ($list as $item):?>
	<div class="item">
		<div class="cover">
			<a href="<?php echo URL('live.details', array('id' => $item['id']));?>" target="_blank"><img src="<?php echo $item['cover_img'];?>" alt="" /></a>
		</div>
		<div class="info">
			<h4>
				<a href="<?php echo URL('live.details', array('id' => $item['id']));?>" target="_blank"><?php echo F('escape', $item['title']);?></a>
				<?php if ($item['start_time'] <= APP_LOCAL_TIMESTAMP && $item['end_time'] > APP_LOCAL_TIMESTAMP):?>
				<span class="active">(<?php LO('modules_microlive_news_live_running');?>)</span>
				<?php elseif ($item['start_time'] > APP_LOCAL_TIMESTAMP):?>
				<?php if ($item['notice_time'] >= APP_LOCAL_TIMESTAMP):?>
				<a class="ico-remind" href="#" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', $item['title']);?>,c:<?php echo F('share_weibo', 'live_tips', $item);?>,n:<?php echo $item['notice_time'];?>"><?php LO('modules_microlive_news_live_remind');?></a>
				<?php endif;?>
				<span class="unplayed">(<?php LO('modules_microlive_news_live_ready');?>)</span>
				<?php else:?>
				<span class="finish">(<?php LO('modules_microlive_news_live_closed');?>)</span>
				<?php endif;?>
			</h4>
			<p class="time"><?php echo F('format_time.foramt_show_time',$item['start_time']);?> - <?php echo F('format_time.foramt_show_time',$item['end_time']);?></p>
			<p><?php echo F('escape', $item['desc']);?></p>
		</div>
	</div>
	<?php endforeach;?>
</div>
<!-- 更多推荐 结束 -->
</div>
<?php endif;?>
