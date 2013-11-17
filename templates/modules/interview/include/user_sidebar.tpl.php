<?php if ( is_array($guestList) ) { ?>
<div class="user-sidebar">
	<div class="tit-hd">
    	<h3><?php LO('modules_interview_user_sidebar_guest');?></h3>
	</div>
	
	<ul>
		<?php 
			foreach ($guestList as $aGuest) 
			{ 
				$userInfo = F('user_filter', $aGuest, TRUE);
		?>
		<li rel="u:<?php echo $aGuest['id']; ?>" >
	        <a href="<?php echo URL('ta', array('id'=>$aGuest['id'])); ?>"><img src="<?php echo $aGuest['profile_image_url']; ?>" alt="" /></a>
	        <p><a href="<?php echo URL('ta', array('id'=>$aGuest['id'])); ?>" title="<?php echo $aGuest['screen_name']; ?>"><?php echo $aGuest['screen_name'].F('verified', $userInfo); ?></a></p>
        	<?php if ( $aGuest['id'] == USER::uid() ) { ?>
         		<span>&nbsp;</span>
			<?php } else if ( isset($friendList[$aGuest['id']]) ) { ?>
         		<span class="followed-btn"><?php LO('modules_interview_user_list_s1_followed');?></span>
         	<?php } else { ?>
         		<a href="#" class="addfollow-btn" rel="e:fl,t:1" ><?php LO('modules_interview_user_list_s1_follow');?></a>
         	<?php } ?>
        </li>
        <?php } ?>
	</ul>
</div>
<?php } ?>
