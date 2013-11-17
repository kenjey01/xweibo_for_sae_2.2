<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>短链域名设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/jquery.min.js'></script>
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/admin/admin_lib.js'></script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>短链接</p></div>
    <div class="main-cont">
    	<h3 class="title">使用短链接</h3>
    	<form action="<?php echo URL('mgr/setting.setShortLink')?>" method="post" id="shortLinkForm">
    	<input type="hidden" name="doEdit" value="1" />
    	<div class="set-area">
        		<div class="form-s1">
					<?php if (XWB_SERVER_ENV_TYPE!=='sae'){ ?>
                        <p class="tips">使用短链接可以使本站微博内容中的链接替换成指定域名的链接。</p>
                        <p class="tips">短链接需要服务器支持Rewrite功能，以下提供的规则只适用于<strong class="stress">Apache</strong>服务器，并且xweibo安装在<strong class="stress">根目录</strong>，规则如下：</p>
                        <ul>
                            <li>1.确保填写的短链接域名可以解析并和服务器绑定</li>
                            <li>2.确认域名的Apache开启了Rewrite功能，并将Apache配置文件中的AllowOverride设置为All</li>
                            <li>3.找到Xweibo根目录下的.htaccess文件，复制到指定域名的服务器根目录下</li>
							<li>4.将“RewriteEngine off”前面的#号去掉，并改为“RewriteEngine on”</li>
							<li>5.找到“个性短链接”段落，去掉相关规则注释符号(#)，并按照说明作修改。注意：.htaccess文件中填写的短链要和本页设置的一致</li>
							<li>6.本页设置并保存“短链域名”</li>
							<li>7.如果需要关闭短链接，请将短链域名设置为空，并把.htaccess文件中相关代码用#号注释掉</li>
                        </ul>
                       
                        
                    <?php } else {?>
                       
                        
                    <?php }?>
                </div>
				
				<div class="form form-s1">
                <div class="form-row">
                	<label for="site-name" class="form-field">短链域名</label>
                    <div class="form-cont">
                        <input name="data[config]" id="site-name" class="input-txt" type="text" value="<?php echo $config['site_short_link'] ?>" vrel="_f|domain" warntip="#nameTip" />
						<a href="javascript:$('#shortLinkForm').submit();" class="btn-general highlight" name="保存修改"><span>保存修改</span></a>
                        <span class="tips-error hidden" id="nameTip">撒旦法</span>
                        <p class="form-tips">如:domain.com，如果微博内容中包含网站链接，此链接会自动转换为以此域名开头的短链接，不填写不做转换</p>
                    </div>
                </div>
            	<p class="tips">子目录安装或非Apache服务器需要做一些修改，具体修改请参考<a href="http://bbs.x.weibo.com/viewthread.php?tid=2076&page=1&extra=#pid4779" target="_blank">这里</a>。</p>
            </div>
        </div>
        </form>
    </div>
<script type="text/javascript">
var valid = new Validator({
	form: '#shortLinkForm',
	validators:{
		domain:function(elem, v, data, next){
			var regDoMain=/(\w+:\/\/)?([^\/:]+)(:\d*)?([^# ]*)/;
			var vdomain=regDoMain.exec(v)?regDoMain.exec(v)[2]:"";
			var returns = !( vdomain.toLowerCase() == window.location.hostname.toLowerCase() );
			if( !returns )
				data.m="短链不能设置为本站域名";
			this.report(returns, data);
        	next();
		}
	}
});
$(function(){
	$('#site-name').change(function(){
		var v = $('#site-name').val();
		var regDoMain=/(\w+:\/\/)?([^\/:]+)(:\d*)?([^# ]*)/;
		var vdomain=regDoMain.exec(v)?regDoMain.exec(v)[2]:"";
		if(vdomain !="" )$('#shortHost').html(vdomain);
	})
})
</script>
</body>
</html>
