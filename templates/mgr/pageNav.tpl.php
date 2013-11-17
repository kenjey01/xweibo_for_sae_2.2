<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>界面管理 - 模板管理 - 模板设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：界面管理<span>&gt;</span>布局</p></div>
	<div class="main-cont">
    	<h3 class="title">模板设置</h3>
        <div class="set-area">
        	<div class="tpl-setting clear">
            <form method="post" id="form1" action="<?php echo URL('mgr/page_nav.updatePageType');?>">
                <div class="item">
                    <input type="radio" class="ipt-radio" name="pageType" id="focus1" value="2" <?php if($pageType==2){echo 'checked="checked"';}?> />
                    <label for="focus1"><strong> 三栏模板布局</strong></label>
                    <p><img src="<?php echo W_BASE_URL;?>css/admin/bgimg/three_mode.jpg" /></p>
                </div>
                <div class="item">
                    <input type="radio" class="ipt-radio" name="pageType" id="focus2"  value="1" <?php if($pageType==1){echo 'checked="checked"';}?> />
                    <label for="focus2"><strong>两栏模板布局</strong></label>
                    <p><img src="<?php echo W_BASE_URL;?>css/admin/bgimg/two_mode.jpg" /></p>
                </div>
                <div class="btn-area"><a href="javascript:$('#form1').submit();" class="btn-general highlight" name="ad"><span>保存</span></a></div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>