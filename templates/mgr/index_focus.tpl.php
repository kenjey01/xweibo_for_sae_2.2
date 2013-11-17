<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>功能插件 - 组件 - 组件扩展</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
</head>
<body class="main-body">
    <div class="path"><p>当前位置：内容管理<span>&gt;</span>我的首页聚焦位</p></div>
    <div class="main-cont">
        <h3 class="title">设置</h3>
        <div class="set-area">
        	<div class="form">
            <form method="post" id="form1" enctype="multipart/form-data" action="<?php echo URL('mgr/plugins.save', array('id' => 2));?>">
                <div class="form-row">
                    <label for="title" class="form-field">标题</label>
                    <div class="form-cont">
                        <input id="title" type="text" name="title" class="input-txt" value="<?php echo F('escape', $cfg['title']);?>">
                    </div>
                </div>
                <div class="form-row">
                    <label for="declare" class="form-field">内容</label>
                    <div class="form-cont">
                        <textarea id="declare" rows="" cols="" class="input-area area-s5" vrel="sz=max:200,ww,m:不允许超过200字符。" warntip="#textTips" name="text"><?php echo F('escape', $cfg['text']);?></textarea><span id="textTips" class="tips-error hidden"></span>
                        <p class="form-tips">（建议字数不超过74字，超过部分前端将不会显示）</p>
                    </div>
                </div>
                <div class="form-row">
                    <label for="image" class="form-field">背景图片</label>
                    <div class="form-cont">
                        <input id="image" type="file" onchange="" name="bg" value="" class="btn-file" />
                        <p class="form-tips">请选择PNG格式的本地图片文件；</p>
                        <p class="form-tips">为显示美观，图片大小建议为560*122。如不选择背景图片，将使用默认的背景图片。</p>
                    </div>
                </div>
                <div class="form-row">
                    <label for="oper" class="form-field">操作设置</label>
                    <div class="form-cont">
                        <select name="oper" id="oper">
                        <?php if ($cfg['oper'] == 1):?>
                            <option value=1 selected>发布微博</option>
                            <option value=2>跳转到其他页面</option>
                        <?php else: ?>
                            <option value=1>发布微博</option>
                            <option value=2 selected>跳转到其他页面</option>
                        <?php endif;?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <label for="topic" class="form-field">话题</label>
                    <div class="form-cont">
                        <input type="text" class="input-txt" name="topic" id="topic" value="<?php echo F('escape', $cfg['topic']);?>">
                    </div>
                </div>
                <div class="form-row">
                    <label for="link" class="form-field">链接</label>
                    <div class="form-cont">
                        <input type="text" class="input-txt" name="link" id="link" size=40 value="<?php echo F('escape', $cfg['link']);?>">
                    </div>
                </div>
                <div class="form-row">
                    <label for="btn-txt" class="form-field">按钮的文字</label>
                    <div class="form-cont">
                        <input id="btn-txt" type="text" class="input-txt" name="btnTitle" vrel="sz=min:1,max:5,m:最多只能五个字|ne=m:不能为空" warntip="#btnTips" value="<?php echo F('escape', $cfg['btnTitle']);?>"><span class="tips-error hidden" id="btnTips"></span>
                    </div>
                </div>
                <!--div class="focus-set">
                  <p>效果预览：</p>
                    <img width="560" height="89" src="<?php echo W_BASE_URL;?>css/admin/focus_pre.png">
                    <div id="preview_loading" class="preview_loading">正在上传图片，请稍候...</div>
                </div-->
                <div class="btn-area"><a href="#" class="btn-general highlight" name="ad" id="submitBtn"><span>提交</span></a></div>
            </form>
            </div>
        </div>
    </div>

<script type="text/javascript">
var valid = new Validator({
	form: '#form1',
	trigger: '#submitBtn'
});

$('#oper').change(function(e) {
	var $topic = $('#topic'),
		$link = $('#link');

	if (this.value == 1)
	{
		$link.attr('disabled', 'true').addClass('input-disabled');
		$topic.removeAttr('disabled').removeClass('input-disabled');
		if (e)
		{
			$topic.focus();
		}
	}
	else {
		$topic.attr('disabled', 'true').addClass('input-disabled');
		$link.removeAttr('disabled').removeClass('input-disabled');
		if (e)
		{
			$link.focus();
		}
	}
}).change();
</script>
</body>
</html>
