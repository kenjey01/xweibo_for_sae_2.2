<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
<?php TPL::plugin('wap/include/top_logo', '', false); ?>
<?php TPL::plugin('wap/include/nav', array('is_top' => true), false); ?>
<?php TPL::plugin('wap/include/my_preview', '', false); ?>
<div class="s"></div>
	<?php if (!empty($list['users'])): ?>
	<?php foreach ($list['users'] as $user): ?>
	<div class="list">
	<table>
    	<tbody>
        	<tr>
            	<td><a href="<?php echo WAP_URL('ta', 'id=' . $user['id']); ?>"><img src="<?php echo $user['profile_image_url']; ?>" alt="<?php echo F('escape', $user['screen_name']); ?>" /></a></td>
				<td><a href="<?php echo WAP_URL('ta', 'id=' . $user['id']); ?>"><?php echo F('verified', $user); ?></a><br /><?php LO('index__fans__fansNum', $user['followers_count']);?><br /><a href="<?php echo WAP_URL('wbcom.cancelFanAlert', 'id=' . $user['id']); ?>"><?php LO('index__fans__remove');?></a> <?php if (in_array($user['id'], $fids)): ?><?php LO('common__template__followed');?><?php else: ?><a href="<?php echo WAP_URL('wbcom.addFollow', 'id=' . $user['id']); ?>"><?php LO('index__fans__follow');?><?php echo $user['gender'] == 'f' ? L('index__fans__she') : L('index__fans__he'); ?></a><?php endif; ?> <?php if (HAS_DIRECT_MESSAGES) {?><a href="<?php echo WAP_URL('wbcom.sendMsgFrm', array('rid' => $user['id'], 'rname' => $user['screen_name'], 'st' => 2)); ?>"><?php LO('index__fans__message');?></a><?php }?></td>
            </tr>
        </tbody>
    </table>
    <div class="s"></div>
    </div>
	<?php endforeach; ?>
	<?php else: ?>
		<?php if (V('g:page', 1) > 1):?>
		<p><?php LO('index__fans__endPage');?></p>
		<?php else: ?>
		<p><?php LO('index__fans__emptyTip');?></p>
		<?php endif; ?>
		<div class="s"></div>
	<?php endif; ?>
	<?php TPL::plugin('wap/include/pager', array('ctrl' => APP::getRuningRoute(false), 'list' => $list, 'page' => $page, 'limit' => $limit), false); ?>
	<?php TPL::plugin('wap/include/search', '', false); ?>
	<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
	<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>
