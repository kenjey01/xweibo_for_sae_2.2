<?php
$uid = USER::uid();
if ($uid && !isset($uInfo)) {
	$uInfo = DR('xweibo/xwb.getUserShow', 'p', $uid);
	$uInfo = $uInfo['rst'];
}
$uName      = F('escape', $uInfo['screen_name']);
$location   = F('escape', $uInfo['location']);
$desc       = F('escape', $uInfo['description']);
$pic        = F('profile_image_url', $uInfo['profile_image_url']);

$ur = DR('xweibo/xwb.getUnread', 'p');
$ur = $ur['rst'];
$atmeCount = (int)$ur['mentions'];
?>
<div class="u-intro">
	<table>
		<tr>
			<td class="u-img" valign="top"><img src="<?php echo $pic;?>" alt="<?php echo $uName;?>" /></td>
			<td>
				<div><?php echo F('verified', $uInfo); ?>/<?php echo ($uInfo['gender'] == 'm' || $uInfo['gender'] == '') ? L('include__myPreview__genderMale') : L('include__myPreview__genderFemale');?>/<?php echo $location;?></div>
				<div><?php echo $desc;?></div>
				<div><a href="<?php echo WAP_URL('index.info'); ?>"><?php LO('include__myPreview__info');?></a>&nbsp;<a href="<?php echo WAP_URL('wbcom.sendWBFrm'); ?>"><?php LO('include__myPreview__postWeibo');?></a></div>
			</td>
		</tr>
	</table>
</div>
<div class="fc">
<?php $router = APP::getRuningRoute(true); ?>
	<?php if ($router['function'] == 'profile'): ?><?php LO('include__myPreview__weibo');?>[<?php echo $uInfo['statuses_count']; ?>]<?php else: ?><a href="<?php echo WAP_URL('index.profile'); ?>"><?php LO('include__myPreview__weibo');?>[<?php echo $uInfo['statuses_count']; ?>]</a><?php endif; ?>
	<?php if ($router['function'] == 'follow'): ?><?php LO('include__myPreview__follow');?>[<?php echo $uInfo['friends_count']; ?>]<?php else: ?><a href="<?php echo WAP_URL('index.follow'); ?>"><?php LO('include__myPreview__follow');?>[<?php echo $uInfo['friends_count']; ?>]</a><?php endif; ?>
	<?php if ($router['function'] == 'fans'): ?><?php LO('include__myPreview__fans');?>[<?php echo $uInfo['followers_count']; ?>]<?php else: ?><a href="<?php echo WAP_URL('index.fans'); ?>"><?php LO('include__myPreview__fans');?>[<?php echo $uInfo['followers_count']; ?>]</a><?php endif; ?>
	<?php if ($router['function'] == 'message' && V('g:type') == 3): ?><?php LO('include__myPreview__atme');?><?php else: ?><a href="<?php echo WAP_URL('index.messages', 'type=3'); ?>"><?php LO('include__myPreview__atme');?><?php echo $atmeCount ? '<span class="r">[' . $atmeCount . ']</span>' : ''; ?></a><?php endif; ?>
</div>