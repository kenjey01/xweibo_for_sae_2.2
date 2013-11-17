<div class="event-list">
	<div class="cover">
	<a href="#"><img src="<?php echo $info['pic'];?>" alt="<?php LO('modules__eventInfo__eventPic');?>" /></a>
		<div class="cover-bg"></div>
	</div>
	<div class="event-info" rel="eid:<?php echo $info['id'] ;?>,m:<?php echo F('share_weibo', 'event_attend', $info);?>,m1:<?php echo F('share_weibo', 'event', $info);?>,other:<?php echo $info['other'] ;?>">
	<h3><a href="#"><?php echo F('escape', $info['title']);?></a></h3>
		<div class="info-item">
		<div class="item-l"><?php LO('modules__eventInfo__eventTime');?></div>
			<div class="item-c"><?php echo F('format_time.foramt_show_time',$info['start_time']);?> - <?php echo F('format_time.foramt_show_time',$info['end_time']);?></div>
		</div>
		<div class="info-item">
		<div class="item-l"><?php LO('modules__eventInfo__eventAddr');?></div>
			<div class="item-c"><?php echo F('escape', $info['addr']);?></div>
		</div>
		<div class="info-item">
		<div class="item-l"><?php LO('modules__eventInfo__eventName');?></div>
			<div class="item-c"><a href="<?php echo URL('ta', array('id' => $info['sina_uid']));?>"><?php echo F('escape', $info['nickname']);?></a><?php if (isset($info['realname']) && !empty($info['realname'])):?>(<?php echo F('escape', $info['realname']);?>)<?php endif;?></div>
		</div>
		<div class="info-item">
		<div class="item-l"><?php LO('modules__eventInfo__eventPhone');?></div>
			<div class="item-c"><?php echo $info['phone'];?></div>
		</div>
		<div class="info-item">
		<div class="item-l"><?php LO('modules__eventInfo__eventState');?></div>
			<?php if ($info['state_num'] == 4):?>
			<div class="item-c warn">
			<?php LO('modules__eventInfo__eventStateClose');?>	
			</div>
			<?php elseif ($info['state_num'] == 5):?>
			<div class="item-c warn">
			<?php LO('modules__eventInfo__eventStateBan');?>	
			</div>
			<?php elseif ($info['state_num'] == 6):?>
			<div class="item-c">
			<?php LO('modules__eventInfo__eventStateComplete');?>	
			</div>
			<?php elseif ($info['state_num'] == 7):?>
			<div class="item-c">
			<?php LO('modules__eventInfo__eventStateNotStart');?>	
			</div>
			<?php elseif ($info['state_num'] == 1 && $info['start_time'] > APP_LOCAL_TIMESTAMP):?>
			<div class="item-c">
			<?php LO('modules__eventInfo__eventStateNotStart');?>	
			</div>
			<?php elseif ($info['state_num'] == 1 && $info['start_time'] < APP_LOCAL_TIMESTAMP):?>
			<div class="item-c">
			<?php LO('modules__eventList__eventStateGoing');?>	
			</div>
			<?php elseif ($info['state_num'] == 2 || $info['state_num'] == 3):?>
			<div class="item-c">
			<?php LO('modules__eventInfo__eventStateGoing');?>
			</div>
			<?php endif;?>
		</div>
		<div class="info-item">
		<div class="item-l"><?php LO('modules__eventInfo__eventJoinNum');?></div>
			<div class="item-c"><a href="<?php echo URL('event.member', 'eid='.$info['id']);?>"><?php echo $info['join_num'];?></a></div>
		</div>
		<?php if ($info['state_num'] == 1 || $info['state_num'] == 2 || $info['state_num'] == 3):?>
		<a class="ico-share" href="#"  rel='e:sd,t:share'><?php LO('modules__eventInfo__eventShare');?></a>
		<?php endif;?>
		<?php if (isset($join_list[$info['id']]) && $join_list[$info['id']] != ''):?>
		<a class="btn-s2 btn-s2-disabled" href="#"><span><?php LO('modules__eventInfo__eventJoined');?></span></a>
		<?php elseif (($info['state_num'] == 2 
		|| $info['state_num'] == 3 
		|| $info['state_num'] == 7 
		|| $info['state_num'] == 1) 
		&& $info['sina_uid'] != USER::uid()):?>
		<a class="btn-s2" href="#" rel='e:join'><span><?php LO('modules__eventInfo__eventToJoin');?></span></a>
		<?php else:?>
		<a class="btn-s2 btn-s2-disabled" href="#"><span><?php LO('modules__eventInfo__eventToJoin');?></span></a>
		<?php endif;?>
	</div>
</div>
<div class="overview">
<h4><?php LO('modules__eventInfo__eventDesc');?></h4>
	<p><?php echo F('escape', $info['desc']);?></p>
</div>
<div class="active-item">
<div class="hd"><?php LO('modules__eventInfo__eventJoinMemberNum', URL('event.member', 'eid='.$info['id']), $info['join_num']);?></div>
<div class="bd">
	<ul>
		<?php foreach ($list_member as $item):?>
		<li rel="u:<?php echo $item['id']; ?>">
		<a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><img alt="<?php echo F('escape', $item['screen_name']);?>" src="<?php echo $item['profile_image_url'];?>"></a>
		<p><a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><?php echo F('escape', $item['screen_name']);?></a></p>
		<?php if (!empty($listFans) && in_array($item['id'], $listFans) || USER::uid() == $item['id']):?>
		<em><?php LO('modules__eventInfo__eventMemberFollowed');?></em>
		<?php else:?>
		<a rel="e:fl,t:2" class="sub-link" href="#"><?php LO('modules__eventInfo__eventMemberToFollow');?></a>
		<?php endif;?>
		</li>
		<?php endforeach;?>
	</ul>
</div>
</div>
