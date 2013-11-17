<?php 
	/**
	 * 人气关注榜模块模板
	 * 需要参数参见component_4_pls
	 * @version $Id$
	 */
	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
?>

<div class="mod-aside top10 top10-attention">
    <div class="hd"><?php echo F('escape', $mod['title']);?></div>
	<div class="bd">
		<ul>
		<?php
			$count = 1;
			foreach ($rs as $u) {
				$nick 		 = F('escape', $u['nickname']);
				$profile_url = URL('ta', array('id' => $u['uid']));
		?>
				 <li>
					<div class="ranking<?php if($count<4):?> r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
					<span><?php echo number_format($u['sort_num']);?></span>
					<a href="<?php echo $profile_url;?>"><?php echo $nick;?></a>
				</li>
		<?php
				$count++;
			}
		?>
		</ul>
	</div>
</div>