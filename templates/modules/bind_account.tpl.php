<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title',false,L('modules__bindAccount__bindWeiboTitle'));?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="bind-account">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
                <div class="main bind-info">
				<p class="letter-bind-weibo"><?php LO('modules__bindAccount__bindWeibo');?></p>
					<div class="account-set">
						<div class="logo-pic">
							<div class="logo1">
								<?php 
									if (V('-:sysConfig/logo',false)){
										echo '<img src="'.F('fix_url', V('-:sysConfig/logo') ).'"/>';
									}else{
										echo '<img src="'.F('fix_url', WB_LOGO_DEFAULT_NAME ).'"/>';
									}
								?>
            				</div>
							<div class="logo2"><img src="<?php echo W_BASE_URL_PATH;?>img/logo/sina_logo.png" alt="" /></div>
							<div class="icon-two-way"></div>
						</div>
						<div class="btn-area"><a href="#" rel="e:lg,t:bind" class="btn-sina-bind-l"></a></div>
					</div>
                    <div class="bind-con">
                        <dl>
						<dt><?php LO('modules__bindAccount__whyBind');?></dt>
							<dd><?php LO('modules__bindAccount__noticeUseful', V('-:sysConfig/site_name'));?></dd>
                        </dl>
                        <dl>
						<dt><?php LO('modules__bindAccount__needBind');?></dt>
							<dd><?php LO('modules__bindAccount__onlyOne', V('-:sysConfig/site_name'));?></dd>
                        </dl>
                        <dl>
						<dt><?php LO('modules__bindAccount__noWeibo');?></dt>
							<dd><?php LO('modules__bindAccount__clickToRegWeibo');?><br />
							<a  href="<?php echo W_BASE_HTTP.URL('account.goSinaReg');?>"><?php LO('modules__bindAccount__regWeibo');?></a></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <!-- 底部 开始-->
            <?php TPL::module('footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
</body>
</html>
