<?php
	/**
	 * 推荐用户公用模板之：人物排列
	 * 需要传入$users
	 * @author yaoying
	 * @version $Id: mod_fame_list.tpl.php 11660 2011-03-16 03:09:39Z yaoying $
	 */

	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
	
?>
<div class="user-list-search">
	<div class="tab-box">
		<div class="tab-s2">
		<a href="<?php echo URL('search.user', array('k' => V('r:k', ''), 'base_app' => V('r:us_base_app', '0'))); ?>" class="show-all"><?php LO('modules__modSearchUserPre__seeAll');?></a>
			<span <?php echo V('r:us_base_app', '0') == 0 ? 'class="current"' : ''; ?>><span><a href="<?php echo URL('search', array('k' => V('r:k', ''), 'us_base_app' => 0, 'wb_base_app' => V('r:wb_base_app', '0'))); ?>"><?php LO('modules__modSearchUserPre__sourceSina');?></a></span></span>
			<span <?php echo V('r:us_base_app', '0') == 1 ? 'class="current"' : ''; ?>><span><a href="<?php echo URL('search', array('k' => V('r:k', ''), 'us_base_app' => 1, 'wb_base_app' => V('r:wb_base_app', '0'))); ?>"><?php LO('modules__modSearchUserPre__local');?></a></span></span>
		</div>
	</div>
    
	<?php
	$userTmp=$users;
	$users=array();
	foreach($userTmp as $row){
		if(isset($row['filter_state']) && !in_array(2,$row['filter_state'])){
			$users[]=$row;
		}
	}
	unset($userTmp);
	
	if (isset($users) && is_array($users) && !empty($users)) {
		echo '<div class="user-list-wrap">';
		
		$i = 1;
		$uid = USER::uid();
		foreach ($users as $row) {
	?>
	
		<div class="user-item" rel="u:<?php echo $row['id'];?>">
			<div class="user-pic">
				<a href="<?php echo URL('ta', 'id=' . $row['id'] . '&name='. urlencode($row['screen_name']));?>"><img src="<?php echo $row['profile_image_url']?>" alt="<?php LO('modules__modSearchUserPre__profileImageUrl', F('escape', $row['screen_name']));?>" /></a>
			</div>
            <?php if ($row['id'] != $uid) {?>
			<?php if ($row['following']) {?>
			<span class="followed-btn"><?php LO('common__template__toFollow');?></span>
			<?php } else {?>
			<a class="addfollow-btn"  rel="e:fl,t:1" href="#"><?php LO('common__template__followed');?></a>
			<?php }?>
			<?php }?>
			<div class="user-info">
				<a class="u-name" href="<?php echo URL('ta', 'id=' . $row['id'] . '&name=' . urlencode($row['screen_name']));?>"><?php echo htmlspecialchars($row['screen_name']); echo F('verified', $row); ?></a>
				<span class="<?php echo $row['gender'] == 'm' ? 'ico-male' : 'ico-female'; ?>"><?php echo htmlspecialchars($row['location']);?></span>
				<p><?php echo htmlspecialchars(mb_strwidth($row['description'], 'UTF-8') > 30 ? mb_substr($row['description'], 0, 13, 'UTF-8') . '...' : $row['description']); ?></p>
			</div>
			
		</div>
	
	<?php
			$i++;
		}
		if ( count($users)%2 ) {
			echo '<div class="user-item"></div>';	
		}
		echo '</div>';
	} else {
	?>
	<div class="search-result">
        <div class="icon-alert"></div>
		<p><strong><?php LO('modules__modSearchUserPre__emptyTip');?></strong></p>
    </div>
	<?php
	}
	?>
</div>
