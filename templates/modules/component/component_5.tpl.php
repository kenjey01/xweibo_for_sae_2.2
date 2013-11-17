<?php
	/**
	 * 微博频道模块模板
	 * 需要参数参见component_5_pls
	 * @version $Id$
	 */
	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
?>

<div class="pub-feed-list">
    <div class="title-box">
        <h3><?php echo F('escape', $mod['title']);?></h3>
    </div>
	<div class="feed-list">
    <?php
		if ($weiboList['errno'] == 0 && is_array($weiboList['rst'])) {
			TPL::module('feedlist', array('list' => $weiboList['rst']));
		} elseif($weiboList['errno'] == -999999) {
	?>
		<div class="int-box ico-load-fail"><?php LO('modules_component_component_5_empty');?></div>
	<?php }elseif(defined('IS_DEBUG') && IS_DEBUG){ ?>
		<div class="int-box ico-load-fail">[DEBUG 模式]<?php echo $weiboList['err']. '(Errno: '. $weiboList['errno']. ')'; ?></div>
	<?php }else{ ?>
		<div class="int-box ico-load-fail"><?php LO('modules_component_component_5_sysError');?></div>
	<?php } ?>
	</div>
	
	<?php
	if(USER::isUserLogin() && $mod['param']['page_type'] && $weiboList['errno'] == 0 && is_array($weiboList['rst'])){
		TPL::module('page', array('list' => $weiboList['rst'], 'limit' => $mod['param']['show_num']));
	}
	?>
	
	<?php
		//list 内的用户
		if (isset($userList['rst']['users']) && is_array($userList['rst']['users']) && !empty($userList['rst']['users'])) {
	?>
	<div class="more-mbloger">
        <span><?php LO('modules_component_component_5_memberList');?></span>
		<div class="mbloger-list">

		<?php	
			foreach ($userList['rst']['users'] as $u) 
			{
				if (empty($u)) continue;
				
				$nick 		 = F('escape', $u['screen_name']);
				$profile_url = URL('ta', array('id' => $u['id']));
		?>
        		<a href="<?php echo $profile_url;?>"><?php echo $nick;?></a>
		<?php }?>
		</div>
    </div>
    
<?php } ?>
</div>
