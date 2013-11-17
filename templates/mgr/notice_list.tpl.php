<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通知后台</title>
<!--<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />-->
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">

function show_recipient(o) {
	if (o) {
		$('#recipient_area').removeClass('hidden');
		$('#recipientTip').removeClass('hidden');
	} else {
		$('#recipient_area').addClass('hidden');
		$('#recipientTip').addClass('hidden');
	}
}

function post_notice() {
	var type = $('input[name="recipient_type"]:checked').val();
	var title = $.trim($('input[name="title"]').val());
	var content = $.trim($('textarea[name="content"]').val());
	var recipients = $.trim($('textarea[name="recipients"]').val());
	
	var err = false;
	
	if (type == '2' && recipients == '') {
		$('#usernameTip').removeClass('hidden');
		err = true;
	} else {
		$('#usernameTip').addClass('hidden');
	}
	
	if (title == '') {
		$('#titleTip').removeClass('hidden');
		err = true;
	} else {
		$('#titleTip').addClass('hidden');
	}
	
	if (content == '') {
		$('#contentTip').removeClass('hidden');
		err = true;
	} else {
		$('#contentTip').addClass('hidden');
	}
	
	if (err) {
		return false;
	}
	
	$('#notice_frm').submit();
}

function show_detail(notice_id) {
	if ($('#detail_' + notice_id).hasClass('hidden')) {
		if ($('#recipient_list_' + notice_id).html() == '') {
			$.get('<?php echo URL('mgr/notice.getRecipients'); ?>', {notice_id : notice_id}, function(data, textStatus) {
				$('#recipient_list_' + notice_id).html(data);
			});
		}
		$('#detail_' + notice_id).removeClass('hidden');
	} else {
		$('#detail_' + notice_id).addClass('hidden');
	}
	
	return false;
}
</script>
</head>
<body class="main-body">
<div class="path"><p>当前位置：内容管理<span>&gt;</span>通知</p></div>
<div class="main-cont">
	<h3 class="title">发布新通知</h3>
	<div class="set-area">
        <form id="notice_frm" action="<?php echo URL('mgr/notice.saveNotice'); ?>" method="post">
            <div class="form">
                <div class="form-row">
                    <label class="form-field">接收对象</label>
                    <div class="form-cont">
                        <label><input type="radio" name="recipient_type" value="1" checked="checked"  onclick="javascript:show_recipient(0);" />全站</label>
                        <label><input type="radio" name="recipient_type" value="2" onclick="javascript:show_recipient(1);" />指定用户<span id="recipientTip" class="form-tips hidden">(输入用户昵称，多个用户以回车换行分隔)</span></label>
                    </div>
                </div>
                <div class="form-row hidden" id="recipient_area">
                    <label for="" class="form-field">指定用户</label>
                    <div class="form-cont">
                        <textarea class="input-area area-s4" cols="30" rows="2" name="recipients"></textarea>
                        <span class="tips-error hidden" id="usernameTip">请输入接收用户的昵称</span>
                    </div>
                </div>
                <div class="form-row">
                    <label for="" class="form-field">标题</label>
                    <div class="form-cont">
                        <input type="text" class="input-txt" name="title" />
                        <span class="tips-error hidden" id="titleTip">请输入通知标题</span>
                    </div>
                </div>
                <div class="form-row">
                	<label for="" class="form-field">内容</label>
                    <div class="form-cont">
                        <textarea class="input-area area-s4" cols="80" rows="5" name="content"></textarea>
                        <span class="tips-error hidden" id="contentTip">请输入通知内容</span>
                    </div>
                </div>
                <div class="btn-area">
                    <a href="javascript:;" class="btn-general highlight" onclick="javascript:post_notice();"><span>发布</span></a>
                 </div>
            </div>
        </form>
	</div>
    <h3 class="title">通知列表</h3>
    <div class="set-area">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
            <colgroup>
                    <col class="w70"/>
                    <col />
                    <col class="w150" />
                    <col class="w80" />
            </colgroup>
            <thead class="tb-tit-bg">
                <tr>
                    <th><div class="th-gap">编号</div></th>
                    <th><div class="th-gap">标题</div></th>
                    <th><div class="th-gap">生效时间</div></th>
                    <th><div class="th-gap">操作</div></th>
                </tr>
            </thead>
            <tfoot class="tb-tit-bg">
                <tr>
                    <td colspan="4">
                        <div class="pre-next">
                        <?php if (isset($list) && is_array($list) && !empty($list)): echo $pager; endif; ?>
                        </div>
                        </td>
                </tr>
            </tfoot>
            <tbody>
    <?php
    if (!empty($list)):
    foreach ($list as $notice):
    $offset++;
    ?>
                <tr>
                    <td><?php echo $offset;?></td>
                    <td><a href="javascript:void(0);" onclick="javascript:show_detail('<?php echo $notice['notice_id']; ?>');"><?php echo F('escape', $notice['title']);?></a><div id="detail_<?php echo $notice['notice_id']; ?>" class="hidden"><div><?php echo $notice['content']; ?></div><div>接收人：<span id="recipient_list_<?php echo $notice['notice_id']; ?>"></span></div></div></td>
                    <td><?php echo date('Y-m-d H:i:s', $notice['available_time']); ?></td>
                    <td><a class="icon-del" href="javascript:delConfirm('<?php echo URL('mgr/notice.delNotice', 'notice_id=' . $notice['notice_id']); ?>','确认删除这条通知？');">删除</a></td>
                </tr>
    <?php
    endforeach;
    else:
    ?>
            <tr>
                <td colspan="4"><p class="no-data">暂未发布任何通知</p></td>
            </tr>
    <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
