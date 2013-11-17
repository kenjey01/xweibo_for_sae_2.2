<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个性域名设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
</head>

<body class="main-body">
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>个性化域名</p></div>
    <div class="main-cont">
    	<h3 class="title">使用个性化域名</h3>
    	<form action="<?php echo URL('mgr/setting.setPersonalDomain')?>" name="rewrite" method="post" id="RnForm">
    	<input type="hidden" name="doEdit" value="1" />
    	<div class="set-area">
			<div class="form-s1">
				<?php if (XWB_SERVER_ENV_TYPE != 'sae'):?>
				<p class="tips">使用个性化域名后可以使个人微博的域名变得美观有规律。</p>
				<p class="tips">个性化域名需要服务器支持Rewrite功能，以下提供的规则只适用于<strong class="stress" >Apache</strong>服务器，并且xweibo安装在<strong class="stress" >根目录</strong>，规则如下：</p>
				<ul>
					<li>1.确保Apache安装了Rewite模块，并将Apache配置文件中的AllowOverride设置为All</li>
					<li>2.找到Xweibo根目录下的.htaccess文件，将“RewriteEngine off”前面的#号去掉，并改为“RewriteEngine on”</li>
					<li>3.找到“处理自定义个性域名”段落，按照说明把相关代码注释符号(#)去掉</li>
					<li>4.选择“开启”并保存设置</li>
					<li>5.如果选择“关闭”，请把.htaccess文件中相关代码用#号注释掉</li>
				</ul>
				<?php else:?>
				<p class="tips">使用个性化域名后可以使个人微博的域名变得美观有规律。</p>
				<ul>
					<li>1.请登录SAE进入对应应用在代码管理找到readme/config.yaml，把里面的代码复制到apps/APPNAME/1/config.yaml (APPNAME是您的应用名,1代表版本号)。</li>
					<li>2.打开SAE SDK 选择对应的应用版本，点击“上传”</li>
					<li>4.选择“开启”并保存设置</li>
					<li>5.如果选择了“关闭”，请将已添加的代码删除或注释，再用SAE SDK重新“上传”即可。</li>
				</ul>
				<?php endif;?>
                <p class="operate">
                    <label for="rewrite-open"><input id="rewrite-open" class="ipt-radio" name="data[config]" type="radio" value="1" <?php if($config['use_person_domain'] == 1) echo 'checked="checked"'; ?> />开启</label>
                </p>
                <p class="operate">
                    <label for="rewrite-closed"><input id="rewrite-closed" class="ipt-radio" name="data[config]" type="radio" value="0" <?php if($config['use_person_domain'] == 0) echo 'checked="checked"'; ?> />关闭</label>
                </p>
                <div class="btn-area"><a href="javascript:$('#RnForm').submit();" class="btn-general highlight" name="保存修改"><span>保存修改</span></a></div>
				<?php if (XWB_SERVER_ENV_TYPE != 'sae'):?>
                <p class="tips">子目录安装或非Apache服务器需要做一些修改，具体修改请参考<a href="http://bbs.x.weibo.com/viewthread.php?tid=2076&page=1&extra=#pid4779" target="_blank">这里</a>。</p>
				<?php endif;?>
            </div>
		</div>
		</form>
	</div>
</body>
</html>
