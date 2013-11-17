<div class="tit-hd">
	<h3><?php LO('modules_microlive_news_live_list_title');?></h3>
</div>
<div class="talk-list">
	<?php if ($list):?>
	<?php foreach ($list as $item):?>
	<div class="item">
		<div class="cover">
			<a href="<?php echo URL('live.details', array('id' => $item['id']));?>" target="_blank"><img src="<?php echo $item['cover_img'];?>" target="_blank" alt="" /></a>
		</div>
		<div class="info">
			<h4>
			<a href="<?php echo URL('live.details', array('id' => $item['id']));?>" target="_blank"><?php echo F('escape', $item['title']);?></a>
			<?php if ($item['start_time'] <= APP_LOCAL_TIMESTAMP && $item['end_time'] > APP_LOCAL_TIMESTAMP):?>
			<span class="active">(<?php LO('modules_microlive_news_live_list_running');?>)</span>
			<?php elseif ($item['start_time'] > APP_LOCAL_TIMESTAMP):?>
				<?php if ($item['notice_time'] >= APP_LOCAL_TIMESTAMP):?>
				<a class="ico-remind" href="#" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', $item['title']);?>,c:<?php echo F('share_weibo', 'live_tips', $item);?>,n:<?php echo $item['notice_time'];?>"><?php LO('modules_microlive_news_live_list_remind');?></a>
				<?php endif;?>
			<span class="unplayed">(<?php LO('modules_microlive_news_live_list_ready');?>)</span>
			<?php else:?>
			<span class="finish">(<?php LO('modules_microlive_news_live_list_closed');?>)</span>
			<?php endif;?>
			</h4>
			<p class="time"><?php echo F('format_time.foramt_show_time',$item['start_time']);?> - <?php echo F('format_time.foramt_show_time',$item['end_time']);?></p>
			<p><?php echo F('escape', $item['desc']);?></p>
		</div>
	</div>
	<?php endforeach;?>
	<?php TPL::module('page', array('list' => $list, 'count' => $count, 'limit' => $limit, 'type' => 'live'));?>
	<?php else:?>
	<div class="default-tips">
		<div class="icon-tips"></div>
		<?php if (USER::get('isAdminAccount')):?>
		<p><?php LO('modules_microlive_news_live_list_emptyForAdmin');?></p>
		<?php else:?>
		<p><?php LO('modules_microlive_news_live_list_empty');?></p>
		<?php endif;?>
	</div>
	<?php endif;?>
</div>
