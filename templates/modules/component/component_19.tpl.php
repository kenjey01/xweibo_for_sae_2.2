<!--本地关注榜-->
<?php if (isset($mod['loginPage'])):?>
<!-- start 登录页的人气排行榜 -->
<div class="list-bd">
	<ul class="top-list">
		<?php if ($list):?>
<?php 
	$count = 1;
	foreach ($list as $u):?> 
<?php 
		$nick 		 = F('escape', $u['screen_name']);
		$profile_url = URL('ta', array('id' => $u['sina_uid']));
		$followers_count = number_format($u['followers_count']);
		$profile_img = F('profile_image_url', $u['sina_uid'], 'comment');
?>
		<li>
		<div class="ranking <?php if ($count < 4):?>top-three<?php endif;?>"><?php echo $count;?></div>
			<span><?php echo $followers_count;?></span>
			<?php if ($count < 4):?>
				<a href="<?php echo $profile_url;?>" class="user-pic"><img src="<?php echo $profile_img;?>" alt="<?php echo $nick;?>" /></a>
			<?php endif;?>
		<a href="<?php echo $profile_url;?>" class="user-name <?php if ($count < 4):?>top-name<?php endif;?>"><?php echo $nick;?></a>
		</li>
<?php $count++;?>
<?php endforeach;?>
<?php endif;?>
	</ul>
</div>
<!-- end 登录页的人气排行榜 -->
<?php else:?>
<?php if (!empty($list)) {?>
<div class="mod-aside top10">
	<div class="hd"><h3><?php echo isset($mod['newTitle'])?$mod['newTitle']:'本地关注榜';?></h3></div>
	<div class="bd">
		<ul>
			<?php
			$i=0;
			
			foreach($list as $key => $row):
			?>
			 <li>
				<div class="ranking r-<?php echo ++$i;?> skin-bg"><?php echo $i;?></div>
				<a href="<?php echo URL('ta','id='.$row['sina_uid'])?>"><?php echo $row['screen_name']?></a>
				<span>(<?php echo $row['followers_count']; ?>)</span>
			</li>
			 <?php
			 endforeach;
			 ?>
		
		</ul>
	</div>
</div>
<?php }?>
<?php endif;?>
