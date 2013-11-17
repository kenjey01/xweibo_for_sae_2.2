<?php 
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php //TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
<style type="text/css">
/* reset */
body, p, ul, li, h1, h3{ margin:0; padding:0;}
body{ font:12px/1.5 Arial, Helvetica, sans-serif; color:#444; }
li{ list-style:none;}
img{ border:0;}
em{ font-style:normal; }
.hidden{ display:none!important;}
a { color:#3290D4; text-decoration:none;  }
a:hover { text-decoration:underline;}

/*引入图片*/
.t,
.b,
.operate-area,
.btn-register,
.btn-sina-login,
.btn-custom-login,
.btn-now-login,
.list-hd h3,
.prev,
.next,
.ranking,
.top-three{ background:url(<?php echo W_BASE_URL ?>css/default/bgimg/not_login_bg.png) no-repeat; }

.tips-ok,
.tips-wrong,
.tips-normal { background:url(<?php echo W_BASE_URL ?>css/default/bgimg/ico_bg.png ) no-repeat; }

html{ background:#e1f5f8; }
.wrap{ background:url(<?php echo W_BASE_URL ?>css/default/bgimg/not_login_main_bg_x.png) repeat-x center top; }
.wrap-in{ background:url(<?php echo W_BASE_URL ?>css/default/bgimg/not_login_main_bg.jpg) no-repeat center top; }

#header{ height:90px; }
.hd-in{ position:relative; width:950px; margin:auto; }  
	.logo{ float:left; margin:30px 0 0 10px }
	.logo a{ outline:none; }
	.hd-nav{ float:right; margin:20px 20px 0; _display:inline; }
	.hd-nav a{ margin-left:20px; color:#000; }
	
#container{ width:950px; margin:0 auto 10px; }  
	.t, .b{ width:950px; height:5px; overflow:hidden; }
	.t{ background-position:0 0; }
	.b{ background-position:0 -5px; }
.main{ padding:15px 19px; border:solid #C9E2E6; border-width:0 1px; background:#fff; overflow:hidden; _zoom:1; }
	
#footer { margin-bottom:25px; }
#footer .ft-in { width:950px; margin:0 auto; height:60px; line-height:60px;}
#footer .ft-bg { display:none; }
#footer .ft-con span { margin-left:15px;}
#footer .ft-con .footer-defined{ float:right; margin-right:10px; _display:inline; }
#footer .ft-con .footer-defined s { color:#999; text-decoration:none;  }
#footer .ft-con a{ margin:0 8px;}
	
.main-left{ float:left; width:637px; padding-right:19px; overflow:hidden; }	
.main-right{ float:left; width:254px; overflow:hidden; }	

/*右边栏*/
	/*注册-登录*/
	.operate-area{ width:254px; height:246px; margin-bottom:9px; background-position:right -30px; text-align:center; }	
	.area-in{ padding-top:38px; }
	.btn-register{ display:block; width:194px; height:57px; margin:0 auto 15px; background-position:left -204px; text-indent:-9999px; outline:none; }
	.btn-register:hover{ background-position:-214px -204px; }
	.btn-sina-login,
	.btn-custom-login,
	.btn-now-login{ display:block; width:174px; height:26px; margin:52px auto 0; padding-top:6px; color:#000; font-size:14px; text-indent:-9999px; outline:none; }
	.btn-sina-login{ background-position:left -281px; }
	.btn-sina-login:hover{ background-position:-194px -281px; text-decoration:none; }
	.btn-custom-login{ width:135px; padding:6px 9px 0 30px; background-position:left -334px; text-indent:0; white-space:nowrap; overflow:hidden; }
	.btn-custom-login:hover{ background-position:-194px -334px; text-decoration:none; }
	.btn-now-login{ width:140px; background-position:-408px -334px; }
	.btn-now-login:hover{ background-position:-568px -334px; text-decoration:none; }

	/*人气推荐*/
	.recom-list .list-hd h3{ background-position:0 -146px; }
	.top-list{ padding:0 10px; } 
	.top-list li{ padding-bottom:8px; margin-bottom:8px; background:url(<?php echo W_BASE_URL ?>css/default/bgimg/bottom_line.gif) repeat-x center bottom; line-height:16px; overflow:hidden; _zoom:1; } 
	.top-list .ranking{ float:left; width:18px; height:16px; margin-right:8px; background-position:-311px -146px; color:#fff; text-align:center; line-height:16px; }
	.top-list .top-three{ background-position:-273px -146px; }
	.top-list .user-pic img{ float:left; width:30px; height:30px; padding:2px; margin-right:5px; border:1px solid #ccc; background:#fff; }
	.top-list span{ float:right; color:#999; }
	.top-list .user-name{ display:inline-block; width:132px; overflow:hidden; white-space:nowrap; }
	.top-list .top-name{ width:96px; height:32px; white-space:normal; }

/*左边栏*/	
.banner,
.user-list{ margin-bottom:20px; }
.list-hd{ margin-bottom:12px; }
.list-hd h3{ height:38px; text-indent:-9999px; }
.user-list .list-hd h3{ background-position:0 -30px; }
.talk-list .list-hd h3{ background-position:0 -88px; }

	/*他们在微博*/	
	.user-list{ position:relative; _zoom:1; }
	.user-list .list-bd{ position:relative; height:72px; margin:0 30px; overflow:hidden; _zoom:1; }
	.user-list .prev,
	.user-list .next{ position:absolute; top:70px; width:7px; height:13px; overflow:hidden; text-indent:-9999px; outline:none; }
	.user-list .prev{ left:10px; background-position:-349px -146px; }
	.user-list .next{ right:10px; background-position:-369px -146px; }
	.user-list .prev:hover{ background-position:-386px -146px; }
	.user-list .next:hover{ background-position:-406px -146px; }
	.user-list .prev-disabled,
	.user-list .prev-disabled:hover{ background-position:-423px -146px; cursor:default; }
	.user-list .next-disabled,
	.user-list .next-disabled:hover{ background-position:-443px -146px; cursor:default; }
	.user-list ul{ position:absolute; width:1000px; }
	.user-list li{ float:left; width:50px; margin-right:25px; overflow:hidden; _display:inline; }
	.user-list li img{ display:block; width:50px; height:50px;  }
	.user-list li p{ width:4em; height:20px; margin:3px auto 0; text-align:center; overflow:hidden; }
	
	/*他们在说*/	
	.talk-list .list-bd{ height:230px; padding:0 10px; overflow:hidden; }
	.talk-list .feed-list li{ margin-bottom:20px; padding-bottom:10px; background:url(<?php echo W_BASE_URL ?>css/default/bgimg/bottom_line.gif) repeat-x center bottom; overflow:hidden; *zoom:1; }
	.talk-list .user-pic{ float:left; }
	.talk-list .user-pic img{ width:50px; height:50px; }
	.talk-list .feed-content{ margin-left:60px; }
	.talk-list .feed-main{ height:35px; overflow:hidden; }

	/*窗口公共部分*/
	.win-pop{ z-index:10003;}
	.win-pop .win-t,
	.win-pop .win-t div,
	.win-pop .win-b,
	.win-pop .win-b div{ background:url(<?php echo W_BASE_URL ?>css/default/bgimg/win_bg.png) no-repeat; _font-size:0; }
	.win-pop .win-t,
	.win-pop .win-b,
	.win-pop .win-con .win-con-bg{ filter:alpha(opacity=10); opacity:0.1;}
	.win-pop .win-t{ height:5px; background-position:left 0;}
	.win-pop .win-t div{ margin-left:6px; height:5px; background-position:right -5px;}
	.win-pop .win-b{ height:5px; background-position:left -10px;}
	.win-pop .win-b div{ margin-left:6px; height:5px; background-position:right -15px;}
	.win-pop .win-con{ position:relative; overflow:hidden; _zoom:1;}
	.win-pop .win-con .win-con-in{ margin:1px 6px; border:1px solid #666; background-color:#fff; -webkit-border-radius:3px; -moz-border-radius:3px; _zoom:1;}
	.win-pop .win-con .win-con-bg{ position:absolute; top:0; left:0; width:100%; height:100%; _height:600px; background:#000; z-index:-1;}
	.win-pop .ico-close-btn{ position:absolute; right:15px; top:15px; }
	.win-pop .btn-area{ float:right; margin-top:10px;}
	.win-pop .btn-area a{ margin-left:8px;}

	/*fixed定位窗口*/
	.win-fixed{ position:fixed; top:50%; left:50%;}
	*html{ background-attachment:fixed; background-image:url('about:blank');}
	*html .win-fixed{ position:absolute; bottom:auto; top:expression(documentElement.scrollTop + (documentElement.clientHeight/2 - this.clientHeight/2));  margin-top:0;}
	
	/*绑定新浪微博按钮*/
	.btn-web-account,
	.btn-sina-account {background:url(<?php echo W_BASE_URL ?>css/default/bgimg/btn_bind.png) no-repeat;outline:none;}
	.btn-web-account,
	.btn-sina-account { display:inline-block; width:163px; height:32px; margin:10px 0;padding:0 5px 0 40px; overflow:hidden; color:#000; font-size:14px; line-height:32px; outline:none;}
	.btn-web-account{background-position:0 0;}
	.btn-web-account:hover {background-position:-228px 0;}
	.btn-sina-account{background-position:0 -52px;}
	.btn-sina-account:hover {background-position:-228px -52px;}
	
	/*绑定登录窗口*/
	.win-bind-login .win-con-in{background:url(<?php echo W_BASE_URL ?>css/default/bgimg/bind_login_bg.png ) no-repeat;} 
	.win-bind-login {margin-left:-218px; margin-top:-130px;width:436px;}
	.win-bind-login .win-box {overflow:hidden;}
	.win-bind-login .win-box .login-area {padding:75px 70px 30px 85px;overflow:hidden;_zoom:1;}
	.win-bind-login .win-box .login-area a {color:#000;}
	.win-bind-login .win-box .login-area a:hover {color:#000;text-decoration:none;}
	.win-bind-login .win-box .login-area span {float:right;margin-top:15px;margin-left:5px;*vertical-align:middle;}
	.win-bind-login .win-box .login-area span a {color:#6eafd5;}
	.win-bind-login .win-box .login-area span a:hover {color:#6eafd5;text-decoration:underline;}
	.win-bind-login .win-box .bind-tips {background-color:#e9f5ff;border-radius:3px;-moz-border-radius:3px;color:#757b80;height:25px;line-height:25px;margin:0 auto 10px;padding-left:8px;width:405px;overflow:hidden;}	
	
	/*用户反馈*/
	.win-feedback { margin-left:-234px;margin-top:-193px;width:468px;height:386px; }
	.win-feedback .win-box-inner { padding:15px 15px 25px;height:1%;overflow:hidden; }
	.win-feedback .feedback-box { margin-top:8px;overflow:hidden; }
	.win-feedback .feedback-box .user-info { float:left;width:66px;_margin-right:-3px; }
	.win-feedback .feedback-box .user-info img { padding:1px;border:1px solid #999; }
	.win-feedback .feedback-box .user-info p { padding-right:12px;text-align:center; }
	.win-feedback .feedback-box .fill-textarea textarea { padding:3px;width:340px;height:136px; color:#999;font-size:12px; }
	.win-feedback .feedback-box .input-title { float:left;width:66px;} 
	.win-feedback .feedback-box .input-area { float:left; }
	.win-feedback .feedback-box .input-area input { margin-bottom:10px;padding:4px 3px;width:184px; height:15px;line-height:15px; }
	.win-feedback .feedback-box .input-area .input-focus { color:#333;}
	.win-feedback .feedback-box .input-area .input-define { color:#999;}
	.win-feedback .feedback-box .btn-area { clear:both;float:left;overflow:hidden;  }
	.win-feedback .feedback-box .btn-area a { margin-left:0; }
	.win-feedback .feedback-box .tips-wrong,
	.win-feedback .feedback-box .tips-normal { margin:5px 0 0 10px; _margin-left:3px;  }
	.win-feedback .feedback-box .tips-ok{ margin:10px 0 0 10px; _margin-left:3px;  }

	.win-pop .win-tit{ margin:1px 1px 0; height:26px; line-height:26px; font-size:12px; text-indent:6px; background:url(../../../css/default/bgimg/x_bg.png); }
	.win-pop .arrow{ position:absolute; left:25px; top:-1px; width:15px; height:8px; background-position:-63px -128px; _font-size:0;}
	.arrow-b .arrow{ left:25px; top:auto; bottom:-1px; background-position:-64px -152px;}
	.ico-close-btn{ background:url(<?php echo W_BASE_URL ?>css/default/bgimg/ico_bg.png ) no-repeat; }
	.ico-close-btn{ width:10px; height:9px;background-position:-8px -424px;}/*浮层关闭按钮*/
	.ico-close-btn:hover { background-position:-8px -449px;}
	.win-pop .btn-area{ float:right; margin-top:10px;}
	.win-pop .btn-area a{ margin-left:8px;}
	
	/*提交按钮*/
	.btn-s1, .btn-s1 span{ height:25px; line-height:25px; color:#333; background:url(<?php echo W_BASE_URL ?>css/default/bgimg/btn_bg.png) no-repeat; }
	.btn-s1{ display:inline-block; background-position:left -56px; outline:none; }
	.btn-s1 span{ float:left; margin-left:5px; padding:0 18px 0 14px; background-position:right -84px; cursor:pointer;  }
	.btn-s1:hover{ background-position:left -112px; text-decoration:none; }
	.btn-s1:hover span{ background-position:right -140px; }
	
	/*文本框的默认，经过，禁用样式*/
	.style-normal { background:#FCFCFC; border:1px solid; border-color:#adadad #dbdbdb #e0e0e0 #ccc; }
	.style-focus { background:#F4FAFF; border:1px solid #9ED5FE; }
	.style-disabled { background:#F5F5F5; border:1px solid #ccc; }
	.style-wrong{ background:#FEE7E7; border:1px solid #F88686; }
	/*文本框输入校验框样式*/
	.tips-normal, .tips-wrong{ display:inline-block; height:28px; margin-left:10px; padding:0 5px 0 28px; line-height:27px; font-size:12px; line-height:30px\9; *overflow:hidden; }
	.tips-ok{ display:inline-block; width:16px; height:20px; margin-left:10px; vertical-align:-3px; *vertical-align:0; }
	.tips-normal { background-color:#F4FAFF; border:1px solid #9ED5FE; }/*信息提示*/
	.tips-wrong { background-color:#FEE7E7; border:1px solid #F88686; }/*错误提示*/
	/*设置校验图标*/
	.tips-ok{ background-position:-3px -604px; }
	.tips-wrong{ background-position:3px -666px; }
	.tips-normal { background-position:3px -634px; }
	
	/*底部广告*/
	.ft-xad-in{ width:950px; margin:0 auto 10px; overflow:hidden; }

	/*默认提示*/
	.default-tips{ margin:15px 20px 0; padding:30px 30px 30px 0; font-size:14px; }
	.default-tips p{ margin-left:60px; height:24px; line-height:24px;}
	.icon-tips{ float:left; width:44px; height:42px; background:url(<?php echo W_BASE_URL ?>css/default/bgimg/all_bg.png) no-repeat -144px -2px;}
</style>
<?php if (WB_LANG_TYPE_CSS):?>
<link href="<?php echo W_BASE_URL ?>css/default/language/<?php echo WB_LANG_TYPE_CSS;?>.css" rel="stylesheet" type="text/css" />
<?php endif;?>
</head>

<body>
<div class="wrap">
	<div class="wrap-in">
    	<!--头部 开始-->
        <div id="header">
            <div class="hd-in">
            	<h1 class="logo"><a href="#" title="Xweibo"><img id="logo" src="<?php echo F('get_logo_src','web');?>" alt="" /></a></h1>
				<div class="hd-nav"><a href="#" onclick="Xwb.use('feedback').display(true);return false;"><?php LO('login__account__feedback');?></a><a href="http://x.weibo.com/help.php"><?php LO('login__account__help');?></a></div>
            </div>
        </div>
    	<!--头部 结束-->
        
    	<!--主体 开始-->
    	<div id="container">
        	<div class="t"></div>
        	<div class="main">
            	<div class="main-left">
					<div class="banner"><img src="<?php echo W_BASE_URL ?><?php if (WB_LANG_TYPE_CSS):?>img/<?php echo WB_LANG_TYPE_CSS;?>/not_login_banner.jpg<?php else:?>img/not_login_banner.jpg<?php endif;?>" alt="" /></div>
                    <!--他们在微博 开始-->
                    <div class="user-list">
					<div class="list-hd"><h3><?php LO('login__account__theyAreHere');?></h3></div>
					<?php Xpipe::pagelet('component/component_2.run', array('param' => array('group_id' => V('-:sysConfig/xwb_login_group_id'), 'topic_get' => 1, 'show_num' => 10), 'component_id' => 2, 'loginPage' => 1));?>
                    </div>
                    <!--他们在微博 结束-->
                    <!--他们在说 开始-->
                    <div class="talk-list">
					<div class="list-hd"><h3><?php LO('login__account__theyAreSay');?></h3></div>
						<?php Xpipe::pagelet('component/component_14.run', array('param' => array('show_num' => 10), 'component_id' => 14, 'loginPage' => 1));?>
                    </div>
                    <!--他们在说 结束-->
                </div>
                <div class="main-right">
                	<div class="operate-area">
                    	<div class="area-in">
						<div class="register-box"><a class="btn-register" href="<?php echo W_BASE_HTTP.URL('account.goSinaReg');?>"><?php LO('login__account__goRegWeibo');?></a></div>
						<p><?php LO('login__account__whyToRegWeibo');?></p>
                            <div class="login-box">
								<?php 
								if ($login_way == 1) {
									$tips = empty($tips) ? L('modules__login__weiboAccount') : L('modules__login__orWeiboAccount', $tips);
								?>
								<a class="btn-sina-login" href="#" rel="e:lg,t:1"><?php LO('modules__login__weiboAccountLogin');?></a>
								<?php 
								}
								elseif ($login_way == 2) {
									$tips = '';
									$tips = $site_info['site_name'].'';
								?>
								<a class="btn-custom-login" href="<?php echo $site_callback_url;?>"><?php LO('modules__login__whoLogin', $site_info['site_name']);?></a>
								<?php 
								} else {
								?>
									<a class="btn-now-login" href="<?php echo URL('account.siteLogin','cb=login');?>" rel="e:lg"><?php LO('login__account__goLogin');?></a>
								<?php
								}
								?>
								
							</div>
                        </div>
                    </div>
                    <!--人气推荐 开始-->
                    <div class="recom-list">
					<div class="list-hd"><h3><?php LO('login__account__popularRec');?></h3></div>
					<?php Xpipe::pagelet('component/component_19.run', array('param' => array('show_num' => 10), 'component_id' => 19, 'loginPage' => 1));?>
                    </div>
                    <!--人气推荐 结束-->
                </div>
            </div>
        	<div class="b"></div>
        </div>
    	<!--主体 结束-->
        
        <!-- 底部 开始-->
        <?php TPL::module('footer');?>
        <!-- 底部 结束-->
    </div>
</div>


<div class="win-pop win-feedback win-fixed hidden" id="feedbackBox">
	<div class="win-t"><div></div></div>
	<div class="win-con">
		<div class="win-con-in">
		<h4 class="win-tit x-bg"><?php LO('include__header__feedback');?></h4>
			<div class="win-box">
				<div class="win-box-inner">
					<form id="fbForm" method="post" action="<?php echo URL('feedback.save');?>">
					<p><?php LO('include__header__ideas');?></p>
						<div class="feedback-box">
							<div class="user-info">
								<img src="<?php echo USER::isUserLogin() ? F('profile_image_url', USER::uid(),'index') : W_BASE_URL. 'css/default/bgimg/icon_guest.png';?>" alt="" />
								<p><?php echo  USER::isUserLogin() ? USER::get('screen_name'):L('include__header__anonymous');?></p>
							</div>
							<div class="fill-textarea">
							<textarea class="style-normal" name="content" warntip="#feedbackTip" vrel="ne=m:<?php LO('include__header__inputContent');?>|sz=max:500,ww,m:<?php LO('include__header__contentLimit');?>"></textarea>
							</div>
						</div>
						<div class="feedback-box">
						<div class="input-title"><span><?php LO('include__header__contact');?></span></div>
							<div class="input-area">
							<div class="input-field"><input type="text" vrel="_ft|ft|mail" warntip="#feedbackTip" class="input-define style-normal" name="mail" value="<?php LO('include__header__email');?>"/></div>
								<div class="input-field"><input type="text" warntip="#feedbackTip" class="input-define style-normal" vrel="_ft|ft|int|radio" name="qq" value="<?php LO('include__header__phone');?>" /></div>
								<p><?php LO('include__header__inputContact');?></p>
								<div class="btn-area">
								<a class="btn-s1" href="#" id="trig"><span><?php LO('include__header__submit');?></span></a>
								</div>
								<span class="tips-wrong hidden" id="feedbackTip"><?php LO('include__header__inputContent');?></span>
								<input type="submit" class="hidden" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="win-con-bg"></div>
	</div>
	<div class="win-b"><div></div></div>
	<a class="ico-close-btn" href="#" id="xwb_cls" title="<?php LO('include__header__close');?>"></a>
</div>
</body>
</html>
