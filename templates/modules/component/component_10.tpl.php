<?php
	/**
	 * 今日话题模块模板
	 * 需要参数参见component_10_pls
	 * @version $Id$
	 */
	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
?>

<div class="hot-topic">
	<div class="hd">
		<h3><?php echo F('escape', $mod['title']);?></h3>
		<span class="theme">：<a hideFocus="true" href="<?php echo URL('search.weibo', array('k' => $today['keyword']));?>"><?php echo F('escape', $today['keyword']);?></a></span>
		<a hideFocus="true" title="<?php LO('modules_component_component_10_saySomething');?>" href="#" rel="e:sd,m:<?php echo $today['keyword'] ? '#'. APP::F('escape', $today['keyword']). '#' : '';?>" class="ico-post-weibo"><?php LO('modules_component_component_10_saySomething');?></a>
	</div>
	<div class="bd" id="xwb_today_topic">
	<?php
		if ($today['errno'] == 0 && is_array($today['data']['rst'])) 
		{
			if (!empty($today['data']['rst'])) {
	?>
			
			
			<?php
				$uid = USER::uid();
				//关注列表
				foreach ($today['data']['rst'] as $tp) 
				{
					$user 		= &$tp['user'];
					
					//昵称
					$nick 		 = F('escape', $user['screen_name']);
					$user_img 	 = F('profile_image_url', $user['id']);
					$profile_url = URL('ta', array('id' => $user['id'], 'name' => $user['screen_name']));
					$text 		 = F('format_text', $tp['text'], 'feed', 0, false);
				?>
				<div class="column-item next" rel="u:<?php echo $user['id'];?>">
					<div class="side">
						<a href="<?php echo $profile_url;?>" class="user-pic"><img src="<?php echo $user_img;?>" alt="<?php LO('modules_component_component_10_somebodyFace', $nick);?>" /></a>
					<?php if ($uid != $user['id']):?>
						<?php if (isset($followedList[(string)$user['id']])):?>
							<span class="followed-btn"><?php LO('modules_component_component_2_followed');?></span>
						<?php else: ?>
							<span class="addfollow-btn" rel="e:fl,t:1"><?php LO('modules_component_component_2_follow');?></span>
						<?php endif;?>
					<?php endif;?>
					</div>
					<div class="topic-content">
						<a href="<?php echo $profile_url;?>" class="nick"><?php echo $nick;?></a>
						<p class="info ico-<?php if ($user['gender'] == 'f'):?>female<?php else:?>male<?php endif;?>"><span class="location"><?php echo $user['location'];?></span><span class="fans"><?php LO('modules_component_component_10_fans', $user['followers_count']);?></span></p>
						<p class="feedback"><?php echo $text;?></p>
					</div>
				</div>
			<?php } ?>
			
		<?php } else { ?>
			<div class="int-box"><?php LO('modules_component_component_10_topicEmpty');?></div>
		<?php } ?>
	
	<?php } elseif(defined('IS_DEBUG') && IS_DEBUG) { ?>
		<div class="int-box ico-load-fail">components/todayTopic.get出现api错误：<?php echo $today['err']. '(ERRCODE: '. $today['errno']. ')' ; ?></div>
	
	<?php } else { ?>
		<div class="int-box ico-load-fail"><?php LO('modules_component_component_10_tryToGetAgain');?></div>
	<?php } ?>
	</div>
</div>
