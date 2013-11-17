<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<link href="<?php echo W_BASE_URL ?>css/default/pub.css" rel="stylesheet" type="text/css" />
<?php TPL::plugin('include/js_link');?>
</head>
<body id="person">
	<div id="wrap">
    	<div class="wrap-in">
            <!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
                <div class="content">
                    <div class="main userinfo">
                        <div class="form xform-normal">
                            <!-- 个人设置 开始-->
							<?php TPL::module('user_setting');?>
                            <!-- 个人设置 结束-->
                            <!--个人资料 开始-->
                            <div id="infomation" class="form-body">
                                <div class="form-info">
                                    <span class="tab-s4">
									<?php if (HAS_DIRECT_UPDATE_PROFILE):?>
									<a href="<?php echo URL('setting.user');?>"><?php LO('setting__setting__baseInfo');?></a>
									<?php endif;?>
									<a href="javascript:void(0)" class="current"><?php LO('setting__setting__perTags');?></a>
                                    </span>
									<span class="tips"><?php LO('setting__setting__noticeTip', URL('index.profile'));?></span>
                                </div>
								<?php Xpipe::pagelet('user.userTagEdit');?>
                            </div>
                            <!--个人资料 结束-->
                        </div>
                    </div>
                 </div>
            </div>
            <!-- 底部 开始-->
            <?php TPL::module('footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
	<?php TPL::module('gotop');?>
</body>
</html>
