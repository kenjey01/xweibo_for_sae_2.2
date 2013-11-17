<?php
header("Content-type:text/css; charset=utf-8");
$BASE_URL = substr($_SERVER['PHP_SELF'],0,strpos($_SERVER['PHP_SELF'],'skin.css.php'));
if (!function_exists('json_decode')){
	function json_decode($s, $ass = false){
		$assoc = ($ass) ? 16 : 32;
		require_once('../../../application/class/servicesJSON.class.php');
		$gloJSON = new servicesJSON($assoc);
		return $gloJSON->decode($s);
	}
}

function CUSTOM_CSS($type,$default=NULL){
	static $customSkin;
	if(!is_array($customSkin)&&isset($_GET['customSkin'])){
		$customSkin=json_decode(stripslashes($_GET['customSkin']),TRUE);		
	}
	$ret='';
	switch($type){
		case 'BG_COLOR':/*主背景色*/
			$ret=isset($customSkin['colors'][2])?'#'.$customSkin['colors'][2]:$default;
			break;
		case 'MAIN_FONT_COLOR':/*主文字色*/
			$ret=isset($customSkin['colors'][4])?'#'.$customSkin['colors'][4]:$default;
			break;
		case 'HELP_LINK_COLOR':/*辅助连接色*/
		case 'TWO_ROW_RIGHT_MENU_COLOR':/*两栏-右边栏用户菜单*/
			$ret=isset($customSkin['colors'][1])?'#'.$customSkin['colors'][1]:$default;
			break;
		case 'MAIN_LINK_COLOR':/*主链接色*/
			$ret=isset($customSkin['colors'][0])?'#'.$customSkin['colors'][0]:$default;
			break;
		case 'TITLE_COLOR':/*标题字体色*/
			$ret=isset($customSkin['colors'][3])?'#'.$customSkin['colors'][3]:$default;
			break;
		case 'BODY_BG_IMG':/*大背景图*/
			if(isset($customSkin['bg'])&&$customSkin['bg']!=''){
				$aligh=array('','left','center','right');
				$ret=sprintf("html{background:url('%s') %s top %s %s;}",
							 $customSkin['bg'],
							 (isset($customSkin['fixed'])&&$customSkin['fixed']==1)?'fixed':'',
							 isset($customSkin['align'])?$aligh[$customSkin['align']]:'left',
							 isset($customSkin['tiled'])&&$customSkin['tiled']==1?'repeat':'no-repeat'
							 );
			}
			else{
				$ret='';
			}
			break;
		case 'LANG_OPT':/*语言选项*/
			$ret=isset($customSkin['lang_opt']) ? $customSkin['lang_opt'] : $default;
			return $ret;
			break;	
	}
	echo $ret;
}

?>

@charset "utf-8";
/*
  维护者：林毅/蔡伟江
  文档作用：默认样式，定义微博标准版主题相关样式，包括背景、文本颜色、链接颜色、边框等
*/
/*大背景图*/
<?php
CUSTOM_CSS('BODY_BG_IMG');
?>

/*主背景色*/
html { background-color:<?php CUSTOM_CSS('BG_COLOR','#8dd7f5')?>;}

/*主文字色*/
body { color:<?php CUSTOM_CSS('MAIN_FONT_COLOR','#444')?>;}

/*辅助连接色*/
.sub-link,
.feed-list .feed-info p a,
.feed-list .feed-info span a,
.feed-list .forward p span a,
.gotop:link,
.gotop:visited,
.ft-con a,
.icon-reply,
.icon-del { color:<?php CUSTOM_CSS('HELP_LINK_COLOR','#44b1da')?>; }

/*两栏-右边栏用户菜单*/
#home .home-current,
#atme .atme-current,
#comments .comment-current,
#favs .favs-current,
#systemnotice .systemnotice-current,
#messages .messages-current,
.nav-block .cur,
.nav-block .cur:hover,
.nav .defined-link a:hover,
.nav .user-link a:hover,
.tab-s4 a:hover,
.tab-s4 .current,
.tab-s4 .current:visited,
.menu li,
.menu .menu-bg,
.menu .menu-bg .l-bg,
.menu .menu-bg .r-bg { background:<?php CUSTOM_CSS('TWO_ROW_RIGHT_MENU_COLOR','#44b1da')?>; }

/*主链接色*/
a,
.feed-list .feed-filter a,
.user-preview .user-total-box a,
.user-preview .user-total-box a:hover,
.gotop:hover { color:<?php CUSTOM_CSS('MAIN_LINK_COLOR','#0082cb')?> ; }

/*两栏菜单当前背景色*/
.menu .menu-custom,
.menu .menu-over{ background:<?php CUSTOM_CSS('MAIN_LINK_COLOR','#0082cb;')?>; }

/*标题字体色*/
.user-sidebar .hd h3,
.user-list-s1 .hd h3,
.user-tag .tag-tit h3,
.top10 .hd h3,
.user-tag .hd h3,
.user-preview .user-intro strong,
.feed-list .feed-tit h3,
.title-box h3,
.column-title h3,
.account-login h3,
.recom-box .hd h3,
.att-topic .hd h3,
.events-title h3,
.recent-event .hd h3,
.tit-hd h3,
.tit-s1 h3,
.tab-s2 span a,
.tab-s2 span a:visited,
.tab-s3 span a,
.tab-s3 span a:visited { color:#000; }


#container { background:url(<?php echo $BASE_URL?>bgimg/bg_content.png) repeat-y right; }
#footer .ft-bg,
.gotop .gotop-bg { background:#fff; }

#footer .ft-bg { opacity:.7; filter:alpha(opacity=70); }

/*顶部导航菜单 - 设置页面*/
.nav .user-link .manage,
.nav .user-link .manage:visited { color:#f00; }
.nav .user-link .manage:hover { background-color:#fff; color:#f00; }

.nav .defined-link a:hover,
.nav .user-link a:hover,
.sub-menu a:hover,
.sub-menu a.current,
.tab-s4 a:hover,
.tab-s4 .current,
.tab-s4 .current:visited { color:#fff; }

/*两栏菜单*/
.menu { border-radius:3px;moz-border-radius:3px;-webkit-border-radius:3px;  }
.menu li{ background:url(bgimg/menu_bg.png) no-repeat right -84px;}
.menu .menu-custom{ font-weight:bold; }
.menu li.last{ background:none; }
.menu a{ color:#fff;}
.menu a:visited { color:#fff;}
.menu .sub-pubmenu a:visited { color:#444; }
.menu .sub-pubmenu { border:1px solid #bbb; background:#fff; }
.menu .sub-pubmenu li a{ font:12px/25px Tahoma; color:#444; }
.menu .sub-pubmenu li a:hover { background:#eee; text-decoration:none; }
.menu .sub-arrow{ background:url(<?php echo $BASE_URL?>bgimg/menu_bg.png) left -176px; *background-position:left -171px; }

/*三栏站点导航*/
.nav-block h3,
.nav-block a:link,
.nav-block a:visited { color:#444; }
.nav-block h3 a:hover,
.nav-block ul li a:hover { background-color:#e7e7e7; }

.nav-block h3 .square:link,
.nav-block h3 .square:visited,
.nav-block ul li .square:link,
.nav-block ul li .square:visited { color:#fff;  }
.nav-block .cur { color:#fff !important;font-weight:700; }
.nav-block .cur:hover { text-decoration:none; }

/*微博广场*/
	/*导入图片*/
	.hot-topic .column-title .sendBtn{ background:url(<?php echo $BASE_URL?>../bgimg/pub_bg.png) no-repeat; }
	.hot-topic{ background-color:#f4faff; border:1px solid #a8cae7;}
	.hot-topic .column-title .sendBtn{ background-position:0 0;}
	.hot-topic .column-title .theme { color:#707070;}
	.recommand-list a.leftBtn { background-position:0 -49px;}
	.recommand-list a.rightBtn { background-position:-68px -49px;}
	.recommand-list .info{ color:#999;}

/*公用类*/
	
	/*评论提示文字*/
	.gray-text { color:#707070;}
	
	/* 默认表单样式 */
	.form-area .form-item select {font-size:13px;}
	#edit-event .form-area .form-item label {font-size:14px;}


<?php
	//包含不同语言的CSS
	include('skin_'.CUSTOM_CSS('LANG_OPT').'.css');
?>