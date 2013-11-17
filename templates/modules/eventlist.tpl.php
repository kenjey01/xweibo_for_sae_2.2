<?php if (is_array($list) && !empty($list)):?>
	<?php foreach ($list as $item):?>
	<div class="event-list" rel="eid:<?php echo $item['id'];?>,m:<?php echo F('share_weibo', 'event_attend', $item);?>,m1:<?php echo F('share_weibo', 'event', $item);?>,other:<?php echo $item['other'] ;?>">
		<div class="cover">
		<a href="<?php echo URL('event.details', 'eid='.$item['id']);?>"><img src="<?php echo $item['pic'];?>" alt="<?php LO('modules__eventList__eventPic');?>" /></a>
			<div class="cover-bg"></div>
		</div>
		<div class="event-info">
		<h3><a href="<?php echo URL('event.details', 'eid='.$item['id']);?>"><?php echo F('escape', $item['title']);?></a></h3>
			<div class="info-item">
			<div class="item-l"><?php LO('modules__eventList__eventTime');?></div>
				<div class="item-c"><?php echo F('format_time.foramt_show_time',$item['start_time']);?> - <?php echo F('format_time.foramt_show_time',$item['end_time']);?></div>
			</div>
			<div class="info-item">
			<div class="item-l"><?php LO('modules__eventList__eventAddr');?></div>
				<div class="item-c"><?php echo F('escape', $item['addr']);?></div>
			</div>
			<div class="info-item">
			<div class="item-l"><?php LO('modules__eventList__eventName');?></div>
				<div class="item-c"><a href="<?php echo URL('ta', array('id' => $item['sina_uid']));?>"><?php echo F('escape', $item['nickname']);?></a><?php if (isset($item['realname']) && !empty($item['realname'])):?>(<?php echo F('escape', $item['realname']);?>)<?php endif;?></div>
			</div>
			<div class="info-item">
			<div class="item-l"><?php LO('modules__eventList__eventPhone');?></div>
				<div class="item-c"><?php echo $item['phone'];?></div>
			</div>
			<div class="info-item">
			<div class="item-l"><?php LO('modules__eventList__eventState');?></div>
				<?php if ($item['state_num'] == 4):?>
				<div class="item-c warn">
				<?php LO('modules__eventList__eventStateClose');?>	
				</div>
				<?php elseif ($item['state_num'] == 5):?>
				<div class="item-c warn">
				<?php LO('modules__eventList__eventStateBan');?>	
				</div>
				<?php elseif ($item['state_num'] == 6):?>
				<div class="item-c">
				<?php LO('modules__eventList__eventStateComplete');?>	
				</div>
				<?php elseif ($item['state_num'] == 1 && $item['start_time'] > APP_LOCAL_TIMESTAMP):?>
				<div class="item-c">
				<?php LO('modules__eventInfo__eventStateNotStart');?>	
				</div>
				<?php elseif ($item['state_num'] == 1 && $item['start_time'] < APP_LOCAL_TIMESTAMP):?>
				<div class="item-c">
				<?php LO('modules__eventList__eventStateGoing');?>	
				</div>
				<?php elseif ($item['state_num'] == 7):?>
				<div class="item-c">
				<?php LO('modules__eventInfo__eventStateNotStart');?>	
				</div>
				<?php elseif ($item['state_num'] == 2 || $item['state_num'] == 3):?>
				<div class="item-c">
				<?php LO('modules__eventList__eventStateGoing');?>	
				</div>
				<?php endif;?>	
			</div>
			<div class="info-item">
			<div class="item-l"><?php LO('modules__eventList__eventJoinNum');?></div>
				<div class="item-c"><a href="<?php echo URL('event.member', 'eid='.$item['id']);?>"><?php echo $item['join_num'];?></a></div>
			</div>
			<?php if ('hot' == $type):?>
			<a class="ico-share" href="#" rel="e:sd,t:share"><?php LO('modules__eventList__eventShare');?></a>
				<?php if (isset($join_list[$item['id']]) && $join_list[$item['id']] != ''):?>
				<a class="btn-s2 btn-s2-disabled" href="#"><span><?php LO('modules__eventList__eventJoined');?></span></a>
				<?php elseif (($item['state_num'] == 2 
				|| $item['state_num'] == 3 
				|| $item['state_num'] == 7 
				|| $item['state_num'] == 1) 
				&& $item['sina_uid'] != USER::uid()):?>
				<a class="btn-s2" href="#" rel="e:join"><span><?php LO('modules__eventList__eventToJoin');?></span></a>
				<?php else:?>
				<a class="btn-s2 btn-s2-disabled" href="#"><span><?php LO('modules__eventList__eventToJoin');?></span></a>
				<?php endif;?>
			<?php elseif ('create' == $type):?>
				<div class="oper-event">
				<?php if ($item['state_num'] != 4 && $item['sina_uid'] == USER::uid()):?>
				<a href="#" rel="e:clsevt,id:<?php echo $item['id'];?>" ><?php LO('modules__eventList__eventClose');?></a>
				<?php else:?>
				<span><?php LO('modules__eventList__eventClose');?></span>
				<?php endif;?>
				|
				<?php if (($item['state_num'] == 2 
				|| $item['state_num'] == 3 
				|| $item['state_num'] == 7 
				|| $item['state_num'] == 1) 
				&& $item['sina_uid'] == USER::uid()):?>
				<a href="<?php echo URL('event.modify', 'eid='.$item['id']);?>"><?php LO('modules__eventList__eventEdit');?></a>
				<?php else:?>
				<span><?php LO('modules__eventList__eventEdit');?></span>
				<?php endif;?>
				|
					<a href="#"  rel="e:delevt,id:<?php echo $item['id'];?>"><?php LO('modules__eventList__eventDelete');?></a>
				</div>
			<?php endif;?>
		</div>
	</div>
	<?php endforeach;?>                                	
	<?php TPL::module('page', array('list' => $list, 'count' => $count, 'limit' => $limit, 'type' => 'event'));?>
<?php else:?>
<div class="default-tips">
	<div class="icon-tips"></div>
	<?php if ('create' == $type):?>
	<p><?php LO('modules__eventList__myEventEmptyTip');?></p>
	<?php elseif ('attend' == $type):?>
	<p><?php LO('modules__eventList__myAttendEventEmptyTip');?></p>
	<?php else:?>
	<p><?php LO('modules__eventList__eventEmptyTip');?></p>
	<?php endif;?>
</div>
<?php endif;?>
