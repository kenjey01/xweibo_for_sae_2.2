<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="weibo_login">
	<div id="wrap">
    	<div class="wrap-in">
            <!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single ">
            	<div class="content">
                	<div class="main-wrap">
                        <div class="main">
                            <div class="main-bd">
                                <div class="weibo-login-info">
                                    <div class="icon-head"></div>
                                    <div class="weibo-login-con">
										<p><?php LO('login__account__chooseLoginWay');?></p>
                                    </div>
                                </div>
								<div class="weibo-login-area">
									<?php 
									$tips = '';
									if ($use_site_login) {
										$tips = $site_info['site_name'].'';
										?>
										<div>
											<a href="<?php echo $site_callback_url;?>" class="btn-web-account bind-btn-bg"><?php echo $site_info['site_name'];?><?php LO('login__account__loginTip');?></a><span><a href="<?php echo $site_info['reg_url'];?>"><?php LO('login__account__regTip');?></a></span>
										</div>
											<?php 
									}
									if ($use_sina_login) {
										$tips = empty($tips) ? L('login__account__weiboAccount') : L('login__account__otherAccount', $tips);
										?>
										<div>
											<a rel="e:lg,t:1,from:<?php echo $sina_callback_url;?>" href="#" class="btn-sina-account bind-btn-bg"><?php LO('login__account__weiboAccountLogin');?></a><span><a target="_blank" href="<?php echo W_BASE_HTTP.URL('account.goSinaReg');?>"><?php LO('login__account__regWeiboTip');?></a></span>
										</div>
											<?php 
									}?>
									<p class="tips"><?php LO('login__account__chooseAccountLogin', $tips);?></p>
								</div>
                             </div>
                        </div>
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
