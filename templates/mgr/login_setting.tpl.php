<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>帐号登录设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
</head>
<body id="login-set" class="main-wrap">
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>帐号登录设置</p></div>
    <div class="main-cont">
    	<h3 class="title">请选择用户在Xweibo站点登录的方式</h3>
    	<div class="set-area">
        	<div class="form-s1">
                <form action="" method="post" id="loginWayForm">
                    <p class="tips"><strong>提示：</strong></p>
                    <p class="tips-s2">如果您只需要搭建一个Xweibo站点，请选择"仅使用新浪帐号直接登录"<br />
                    如果您已经搭建了其它网站，希望将新建的Xweibo站点与原有站点实现帐号绑定，请选择"使用新浪帐号与原有站点帐号并存方式登录"</p>
                    <p class="operate"><label for="model1"><input id="model1" class="ipt-radio" name="login_way" type="radio" value="1" <?php if($config['login_way'] == 1) echo 'checked="checked"'; ?> />仅使用新浪帐号直接登录</label></p>
                    <p class="operate"><label for="model2"><input id="model2" class="ipt-radio" name="login_way" type="radio" value="2" <?php if($config['login_way'] == 2) echo 'checked="checked"'; ?> />仅使用原有站点帐号登录<span class="form-tips">（需绑定帐号）</span></label></p>
                    <p class="operate"><label for="model3"><input id="model3" class="ipt-radio" name="login_way" type="radio" value="3" <?php if($config['login_way'] == 3) echo 'checked="checked"'; ?> />使用新浪帐号与原有站点帐号并存方式登录</label></p>
                    <!--<div class="adapter">
                        <p class="adapter-t">请选择帐号绑定所需的适配器：</p>
                        <select name="">
                            <option>Disscuz帐号绑定适配器</option>
                            <option>PHPWind帐号绑定适配器</option>
                        </select>
                        <p class="tip">还没完成哦！选择了帐号绑定适配器之后，您需要进行少许的设置才能实现帐号绑定功能。请参考<a href="">Xweibo开发人员文档</a></p>
                    </div>-->
                    <div class="btn-area">
                        <a href="javascript:$('#loginWayForm').submit();" class="btn-general highlight" name="保存修改"><span>保存修改</span></a>
                        <span class="form-tips">您可以开发与自己站点相匹配的帐号绑定适配器，请参考<a href="http://x.weibo.com/download_official.php" target="_blank">Xweibo开发人员文档</a></span>
                    </div>
                </form>
            </div>
        </div>
	</div>
</body>
</html>
