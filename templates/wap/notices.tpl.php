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
<?php TPL::plugin('wap/include/my_preview', $uInfo, false); ?>
<?php TPL::plugin('wap/include/msg_common', '', false); ?>
<div class="c">
<?php if (!empty($list['rst'])): ?>
	<?php foreach ($list['rst'] as $notice): ?>
	<table>
    	<tbody>
        	<tr>
            	<td>
            	<?php LO('index__notice__label_admin');?><?php echo F('escape', $notice['title'], ENT_QUOTES); ?><br /><?php echo F('escape', $notice['content'], ENT_QUOTES); ?>&nbsp;<span class="g"><?php echo date('Y-m-d H:i:s', $notice['add_time']); ?></span>
            	</td>
            </tr>
        </tbody>
    </table>
    <div class="s"></div>
	<?php endforeach; ?>
<?php else: ?>
	<?php if (V('g:page', 1) > 1):?>
	<p><?php LO('index__notice__lastPage');?></p>
	<?php else: ?>
	<p><?php LO('index__notice__notAnyNotice');?></p>
	<?php endif; ?>
	<div class="s"></div>
<?php endif; ?>
</div>
<?php TPL::plugin('wap/include/pager', array('ctrl' => APP::getRuningRoute(false), 'list' => $list, 'page' => $page, 'limit' => $limit), false); ?>
<?php TPL::plugin('wap/include/search', '', false); ?>
<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>