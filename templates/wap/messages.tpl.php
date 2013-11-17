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
<?php LO('index__messages__myMessage');?> <a href="<?php echo WAP_URL('wbcom.sendMsgFrm'); ?>"><?php LO('index__messages__sendMessage');?></a>
<div class="s"></div>
<?php if (!empty($list)): ?>
	<?php foreach ($list as $message): ?>
	<table>
    	<tbody>
        	<tr>
            	<td>
            	<?php if ($message['sender_id'] == USER::uid()): ?><?php LO('index__messages__sendTo', WAP_URL('index'));?><a href="<?php echo WAP_URL('ta', 'id=' . $message['recipient_id']); ?>"><?php echo F('verified', $message['recipient']); ?></a><?php else: ?><a href="<?php echo WAP_URL('ta', 'id=' . $message['sender_id']); ?>"><?php echo F('verified', $message['sender']); endif; ?></a> <?php echo F('escape', $message['text'], ENT_QUOTES); ?> <?php echo F('format_time', $message['created_at']); ?><?php if ($message['sender_id'] != USER::uid()): ?> <a href="<?php echo WAP_URL('wbcom.sendMsgFrm', array('rid' => $message['sender_id'], 'rname' => $message['sender']['screen_name'])); ?>"><?php LO('index__messages__replyTo');?><?php echo $message['sender']['gender'] == 'f' ? L('index__messages__targetFemale') : L('index__messages__targetMale'); ?></a><?php endif; ?> <a href="<?php echo WAP_URL('wbcom.delMsgAlert', 'id=' . $message['id']); ?>"><?php LO('index__messages__deleteMessage');?></a>
            	</td>
            </tr>
        </tbody>
    </table>
    <div class="s"></div>
	<?php endforeach; ?>
<?php else: ?>
	<?php if (V('g:page', 1) > 1):?>
	<p><?php LO('index__messages__lastPage');?></p>
	<?php else: ?>
	<p><?php LO('index__messages__notAnyComment');?></p>
	<?php endif; ?>
	<div class="s"></div>
<?php endif; ?>
</div>
<?php TPL::plugin('wap/include/pager', array('ctrl' => APP::getRuningRoute(false), 'list' => $list, 'page' => $page), false); ?>
<?php TPL::plugin('wap/include/search', '', false); ?>
<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>