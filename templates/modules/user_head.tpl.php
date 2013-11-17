<?php
if (USER::isUserLogin() && USER::uid() != $userinfo['id']) {
	//获取相互关系
	$friendship = DR('xweibo/xwb.getFriendship', '', $userinfo['id']);
	$friendship = $friendship['rst'];
	
	//我是否关注了ta
	$followed = $friendship['source']['following'] ? 1 : 0;

	//他是否关注了我
	$followedBack = $friendship['source']['followed_by'] ? 2: 0;

	/// 是否加入黑名单
	$isBlocks = DR('xweibo/xwb.existsBlocks', '', V('g:id'), V('g:name'));

	if ($isBlocks['errno'] == 0) {
		$isBlocks = $isBlocks['rst'];
		$blocked = $isBlocks['result'] ? 1 : 0;
	} else {
		$isBlocks = array();;
		$blocked = 0;
	}

	/*
	/// 是否关注了ta
	$isFriends = DR('xweibo/xwb.existsFriendship', '', USER::uid(), $userinfo['id']);
	$isFriends = $isFriends['rst'];

	/// 是否加入黑名单
	$isBlocks = DR('xweibo/xwb.existsBlocks', '', V('g:id'), V('g:name'));

	if ($isBlocks['errno'] == 0) {
		$isBlocks = $isBlocks['rst'];
		$blocked = $isBlocks['result'] ? 1 : 0;
	} else {
		$isBlocks = array();;
		$blocked = 0;
	}

	//我是否关注了他
	$followed = $isFriends['friends'] ? 1: 0;
	
	//他是否关注了我
	$followedBack = in_array($userinfo['id'], $fids) ? 2: 0;
	*/
}

$userDomain = DR('mgr/userCom.getByUid', FALSE, $userinfo['id']);
$userDomain = isset($userDomain['rst']['domain_name']) ? $userDomain['rst']['domain_name']  : '';
?>
<div class="user-head">
    <div class="user-head-pic">
    	<img src="<?php echo APP::F('profile_image_url', $userinfo['profile_image_url'], 'profile');?>" alt="" />
    </div>
    <div class="user-head-c" rel="u:<?php echo $userinfo['id'];?>">
		<h3>
			<?php echo F('escape', $userinfo['screen_name']);?>
			<?php echo F('verified', $userinfo);?>
		</h3>
        <div class="user-url">
	        <?php if( USED_PERSON_DOMAIN && $userDomain ) : ?>
	        	<a href="<?php echo W_BASE_HTTP.W_BASE_URL.$userDomain;?>"><?php echo W_BASE_HTTP.W_BASE_URL.$userDomain;?></a>
	        <?php elseif( USED_PERSON_DOMAIN ) : ?>
	        	<a href="<?php echo W_BASE_HTTP.W_BASE_URL.$userinfo['id'];?>"><?php echo W_BASE_HTTP.W_BASE_URL.$userinfo['id'];?></a>
	        <?php else: ?>
	        	<a href="<?php echo URL('ta', 'id='.$userinfo['id']);?>"><?php echo W_BASE_HTTP.URL('ta', 'id='.$userinfo['id']);?></a>
	        <?php endif ?>
        </div>
        
        <p class="<?php if ($userinfo['gender'] == 'f'):?>ico-female<?php elseif ($userinfo['gender'] == 'm'):?>ico-male<?php endif;?>"><?php echo F('escape', $userinfo['location']);?></p>
        <p><?php echo F('escape', $userinfo['description']);?></p>
		<?php if ($userinfo['id'] != USER::uid()):?>
        <div class="opera-area">
			<?php if (USER::isUserLogin()):?>
				<?php if (!$blocked):?>
					<span class="opera-area-r">
						<?php if ( HAS_DIRECT_MESSAGES && $followedBack):?>
						<a href="javascript:;" rel="e:sdm,n:<?php echo $userinfo['screen_name'];?>" id="xwb_sndmsg"><?php LO('modules__userHead__sendMessage');?></a>
							|
						<?php endif;?>
						<a href="#" id="at_ta" rel="e:sd,m:<?php LO('modules__userHead__talkToWho', $userinfo['screen_name']);?>\:">@<?php if ($userinfo['gender'] == 'f'):?><?php LO('modules__userHead__woman');?><?php elseif ($userinfo['gender'] == 'm'):?><?php LO('modules__userHead__man');?><?php endif;?></a>
						<?php if ($followed):?>|<a class="more-opera" href="#" rel="e:mop" id="more_oper"><?php LO('modules__userHead__more');?></a><?php endif;?>
					</span>
					<?php if (!$followed):?>
					<a href="#" rel="e:fl,t:3" class="skin-bg addfollow-btn"><?php LO('common__template__toFollow');?></a>
					<?php elseif ($followedBack):?>
						<div class="operated-box">
						<div class="icon-each-follow"><?php LO('modules__userHead__mutualConcern');?></div>
							<em>|</em>
							<a class="cancel" rel="e:ufl,t:3" href="#"><?php LO('modules__userHead__cancel');?></a>
						</div>
						<div class="more-list hidden" id="more_list">
						<a class="ico-blacklist" href="#" rel="e:abl,u:<?php echo $userinfo['id'];?>,nick:<?php echo F('escape', addslashes($userinfo['screen_name']));?>,gender:<?php echo $userinfo['gender'];?>"><?php LO('modules__userHead__addBlack');?></a>
						</div>
					<?php else:?>
						<div class="operated-box">
						<span class="followed-btn"><?php LO('common__template__followed');?></span>
							<em>|</em>
							<a class="cancel" rel="e:ufl,t:3" href="#"><?php LO('modules__userHead__cancel');?></a>
						</div>
						<div class="more-list hidden" id="more_list">
						<a class="ico-blacklist" href="#" rel="e:abl,u:<?php echo $userinfo['id'];?>,nick:<?php echo F('escape', addslashes($userinfo['screen_name']));?>,gender:<?php echo $userinfo['gender'];?>"><?php LO('modules__userHead__addBlack');?></a>
						</div>
					<?php endif;?>
				<?php else:?>
					<div class="operated-box">
					<span class="ico-yes"><?php LO('modules__userHead__blacked');?></span>
						<em>|</em>
						<a class="cancel" href="#" rel="e:dbl,u:<?php echo $userinfo['id'];?>,m:<?php LO('modules__userHead__sureDelete');?>"><?php LO('modules__userHead__cancel');?></a>
					</div>
				<?php endif;?>
			<?php else:?>
				<a href="#"  rel="e:fl,t:1" class="skin-bg addfollow-btn"><?php LO('common__template__toFollow');?></a>
			<?php endif;?>
        </div>
		<?php else:?>
		<div class="opera-area">
			<span class="opera-area-r">
			<a href="#" rel="e:sd,format:-1" class="ico-post-weibo"><?php LO('modules__userHead__pubWeibo');?></a>
			</span>
		</div>
		<?php endif;?>
    </div>
</div>
