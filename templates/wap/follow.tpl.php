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
				<td><a href="<?php echo WAP_URL('ta', 'id=' . $user['id']); ?>"><?php echo F('verified', $user); ?></a><br /><?php LO('index__follow__fansNum', $user['followers_count']);?><br /><a href="<?php echo WAP_URL('wbcom.cancelFollowAlert', 'id=' . $user['id']); ?>"><?php LO('index__follow__cancelFollowed');?></a></td>
            </tr>
        </tbody>
    </table>
    <div class="s"></div>
    </div>
	<?php endforeach; ?>
	<?php else: ?>
		<?php if (V('g:page', 1) > 1):?>
		<p><?php LO('index__follow__endPage');?></p>
		<?php else: ?>
		<p><?php LO('index__follow__emptyTip');?></p>
		<?php endif; ?>
		<div class="s"></div>
	<?php endif; ?>
	<?php TPL::plugin('wap/include/pager', array('ctrl' => APP::getRuningRoute(false), 'list' => $list, 'page' => $page, 'limit' => $limit), false); ?>
	<?php TPL::plugin('wap/include/search', '', false); ?>
	<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
	<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>
