<!-- 视频 开始-->
<?php if ( isset($liveInfo['code']) && !empty($liveInfo['code']) ) {?>
<div class="video-cont">
	<?php echo $liveInfo['code'];?>
</div>
<?php } ?>
<!-- 视频 结束-->

<!-- 直播简介 开始-->
<div class="live-intro">
	<div class="tit-hd">
		<?php if ($liveInfo['start_time'] <= APP_LOCAL_TIMESTAMP && $liveInfo['end_time'] > APP_LOCAL_TIMESTAMP):?>
		<span class="going">(<?php LO('modules_microlive_live_detail_info_running');?>)</span>
		<?php elseif ($liveInfo['start_time'] > APP_LOCAL_TIMESTAMP):?>
		<span class="not-started">(<?php LO('modules_microlive_live_detail_info_ready');?>)</span>
		<?php else:?>
		<span class="closed">(<?php LO('modules_microlive_live_detail_info_closed');?>)</span>
		<?php endif;?>
		<h3><?php LO('modules_microlive_live_detail_info_title');?></h3>
	</div>
	<div class="bd">
		<div class="info">
			<p>
				<span class="label"><?php LO('modules_microlive_live_detail_info_fieldTime');?></span>
				<span class="time"><?php echo F('format_time.foramt_show_time',$liveInfo['start_time']);?> - <?php echo F('format_time.foramt_show_time',$liveInfo['end_time']);?></span>
			</p>
			<p><?php echo F('escape', $liveInfo['desc']);?></p>
			<span class="ico-mic"></span>
		</div>
		<a href="#" class="btn-recommend" rel="e:sd,t:share,m:<?php echo F('share_weibo', 'live', $liveInfo);?>"><?php LO('modules_microlive_live_detail_info_recommend');?></a>
	</div>
</div>
<!-- 直播简介 结束-->
