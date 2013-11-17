<?php if ( is_array($masterList) ) { ?>
<div class="emcee-list">
	<div class="tit-hd">
		<h3><?php LO('modules_interview_emcee_list_manager');?></h3>
	</div>
	
	<div class="bd">
		<ul>
			<?php 
				foreach ($masterList as $aMaster) 
				{ 
					$userInfo = F('user_filter', $aMaster, TRUE);
			?>
			<li rel="u:<?php echo $aMaster['id'];?>">
	           	<a class="user-pic" href="<?php echo URL('ta', array('id'=>$aMaster['id'])); ?>"><img src="<?php echo $aMaster['profile_image_url']; ?>" alt="" /></a>
	            <p><a class="user-name" href="<?php echo URL('ta', array('id'=>$aMaster['id'])); ?>"><?php echo $aMaster['screen_name'].F('verified', $userInfo); ?></a></p>
	         	<?php if ( isset($friendList[$aMaster['id']]) ) { ?>
	         		<span class="followed-btn"><?php LO('modules_interview_emcee_list_followed');?></span>
	         	<?php } else { ?>
	         		<a href="#" class="addfollow-btn" rel="e:fl,t:1"><?php LO('modules_interview_emcee_list_follow');?></a>
	         	<?php } ?>
            </li>
      		<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>
