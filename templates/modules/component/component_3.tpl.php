<?php 
	/**
	 * 用户推荐模块模板
	 * 需要参数参见component_3_pls
	 * @version $Id$
	 */
	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
	
?>

<div class="mod-aside user-list-s1">
    <div class="hd"><h3><?php echo F('escape', $mod['title']);?></h3></div>
	<div class="bd">
		<ul>
		<?php
			$uid = USER::uid();
			$userTmp=$rs;
			$rs=array();
			foreach($userTmp as $row){
				if(isset($row['filter_state']) && !in_array(2,$row['filter_state'])){
					$rs[]=$row;
				}
			}
			unset($userTmp);
			foreach ($rs as $u) {
				$user_img = F('profile_image_url', $u['uid']);
				$nick = F('escape', $u['nickname']);
				$url = URL('ta', array('id' => $u['uid']));
				$description = F('escape', $u['remark']);
		?>
			<li rel="u:<?php echo $u['uid'];?>">
				<a class="user-pic" href="<?php echo $url;?>"><img src="<?php echo $user_img;?>" alt="<?php echo $nick;?>" /></a>
				<div class="user-info">
				<p class="name"><a href="<?php echo $url;?>"><?php echo $nick;?></a></p>
				<?php if ((string)$u['uid'] !== (string)$uid) {?>
					<?php if (!isset($followedList[(string)$u['uid']])):?>
					<a href="#" class="addfollow-btn" rel="e:fl,t:2"><?php LO('modules_component_component_2_follow');?></a>
					<?php else:?>
					<em><?php LO('modules_component_component_2_followed');?></em>
					<?php endif;?>
				<?php } else {?>
					<em>&nbsp;</em>
				<?php }?>
				<p class="txt"><?php echo $description;?></p>
				</div>
			</li>
		<?php } ?>
		</ul>
	</div>
</div>
