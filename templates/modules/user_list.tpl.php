<?php
if (!empty($users) && is_array($users)):
    foreach ($users as $user):
?>
<div class="user-item" rel="u:<?php echo $user['id'];?>">
<div class="user-pic"><input type="checkbox" rel="e:ck" /><a href="<?php echo URL('ta', 'id=' . $user['id']); ?>"><img src="<?php echo $user['profile_image_url']; ?>" alt="<?php LO('modules__userList__profileImageUrl', F('escape', $user['screen_name']));?>" /></a></div>
	<?php if (!in_array($user['id'], $fids)): ?><a class="addfollow-btn" rel="e:fl,t:1" href="#"><?php LO('common__template__toFollow');?></a><?php else: ?><span class="followed-btn"><?php LO('common__template__followed');?></span><?php endif; ?>
    <div class="user-info">
		<a class="u-name" href="<?php echo URL('ta', 'id=' . $user['id']); ?>"><?php echo F('escape', $user['screen_name']); echo F('verified', $user); ?></a>
		<span class="<?php echo $user['gender'] == 'f' ? 'ico-female' : 'ico-male'; ?>"><?php echo $user['location']; ?></span>
        <p><?php echo htmlspecialchars(mb_strwidth($user['description'], 'UTF-8') > 30 ? mb_substr($user['description'], 0, 13, 'UTF-8') . '...' : $user['description']); ?></p>
	</div>
</div>
<?php
    endforeach;
if ( count($users)%2 ) {
?>
<div class="user-item"></div>
<?php
}
endif;
?>
