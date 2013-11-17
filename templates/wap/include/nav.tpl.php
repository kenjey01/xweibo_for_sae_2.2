<?php
//当前路由
$router = APP::getRuningRoute(true);
$is_top = isset($is_top) ? (bool)$is_top : true;

if (USER::isUserLogin()) {
	$notices = F('sysnotice.getCount');
	
	$ur = DR('xweibo/xwb.getUnread', 'p');
	$ur = $ur['rst'];
	$msgCount = (int)($ur['dm'] + $ur['mentions'] + $ur['comments'] + $notices);
}
?>
<div class="nav"><?php if (USER::isUserLogin()): ?><?php if (in_array($router['class'], array('pub', 'ta', 'celeb'))): ?><a href="<?php echo WAP_URL('index'); ?>"><?php LO('include__nav__index');?></a>|<a href="<?php echo WAP_URL('pub')?>"><?php LO('include__nav__square');?></a>|<a href="<?php echo WAP_URL('celeb')?>"><?php LO('include__nav__major');?></a>|<a href="<?php echo WAP_URL('pub.topics')?>"><?php LO('include__nav__trend');?></a>|<?php else: ?><a href="<?php echo WAP_URL('index'); ?>"><?php LO('include__nav__index');?></a>|<a href="<?php echo HAS_DIRECT_MESSAGES ? WAP_URL('index.messages') : WAP_URL('index.messages', array('type'=>2)); ?>"><?php LO('include__nav__info');?><?php echo $msgCount ? '<span class="r">[' . $msgCount . ']</span>' : ''; ?></a>|<a href="<?php echo WAP_URL('pub')?>"><?php LO('include__nav__square');?></a>|<a href="<?php echo WAP_URL('index.setinfo', 'type=2'); ?>"><?php LO('include__nav__setting');?></a>|<?php endif; ?><?php if ($is_top): ?><a href="<?php echo WAP_URL('search')?>"><?php LO('include__nav__search');?></a><?php else: ?><a href="<?php echo WAP_URL('account.logout'); ?>"><?php LO('include__nav__logout');?></a><?php endif; ?><?php else: ?><a href="<?php echo WAP_URL('account.showLogin')?>"><?php LO('include__nav__login');?></a>|<a href="<?php echo WAP_URL('pub')?>"><?php LO('include__nav__square');?></a>|<a href="<?php echo WAP_URL('celeb')?>"><?php LO('include__nav__major');?></a>|<a href="<?php echo WAP_URL('pub.topics')?>"><?php LO('include__nav__trend');?></a><?php endif; ?></div>