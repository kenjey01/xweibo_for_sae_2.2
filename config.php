<?php
/**
 * @file			config.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	xionghui/2010-11-15
 * @Brief			系统配置文件
 */
//----------------------------------------------------------------------
/// 产品名称
define('WB_SOFT_NAME', 'Xweibo');
/// 当前版本号
define('WB_VERSION', '2.1');
/// 项目号 用于统计
define('WB_PROJECT', 'xwb');
/// 系统默认的模块路由 当入口文件中未定义时使用如下值
if ( !defined('R_DEF_MOD') ){define('R_DEF_MOD', "index");}
//----------------------------------------------------------------------
// 本地安全 solt string
define('AUTH_KEY',			'XMBLOG654321');
/// 站点语言名称（目录）
define('SITE_LANG',			'zh_cn');
/// 站点皮肤  CSS 文件目录名称的 前缀
define('SITE_SKIN_CSS_PRE',	'skin_');
/// 站点皮肤 CSS 自定义皮肤目录
define('SITE_SKIN_CSS_CUSTOM',	'skin_define');
/// 站点皮肤  CSS 文件目录名称的 后缀
/// 当用户和系统都没有设置,且不能从预览变量路由中取得CSS皮肤值的时候即为当前值
define('SITE_SKIN_TYPE',	'default');
/// 站点皮肤  模板目录名称（目录）
define('SITE_SKIN_TPL_DIR',	'1');
/// 预览皮肤时的 变量路由
define('SITE_SKIN_PREV_V',	'R:prev_skin');
/// 皮肤配置文件名称
define('SKIN_CONFIG',		'skinconfig.ini');
/// 皮肤预览图片名称
define('SKIN_PRE_PIC',		'thumbpic.png');

/// 字体目录
define('WB_FONT_PATH',			P_VAR_DATA . '/fonts');
/// 微博列表默认显示条数
define('WB_API_LIMIT',			20);
/// 默认时区
define('APP_TIMEZONE_OFFSET',	8);
/// 本地时间，与标准时间的差，单位为秒，当本地时钟较快时为　负数　，较慢时为　正数　, 默认为　０　即本地时间是准确的
define('LOCAL_TIME_OFFSET',		0);
/// 经过较准的，本地时间戳　所有使用APP_LOCAL_TIMESTAMP　的地方用这个常替代，防止，无法更改服务器时间导致的问题
define('APP_LOCAL_TIMESTAMP',	time() + LOCAL_TIME_OFFSET);

/// 本程序中的HTTP  USER_AGENT 代理
if (XWB_SERVER_ENV_TYPE === 'common') {
	define('XWB_HTTP_USER_AGENT',	isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
} else {
	define('XWB_HTTP_USER_AGENT',	'SAE/fetchurl-' . SAE_ACCESSKEY);// . ' ' . $_SERVER['HTTP_USER_AGENT']);
}
/// 定时程序锁文件前缀
define('CRON_LOCK_FILE_PREFIX', 'cron_lock_');
//----------------------------------------------------------------------
/// 站点LOGO文件名
define('WB_LOGO_DEFAULT_NAME',		'img/logo.png');
define('WB_LOGO_WAP_DEFAULT_NAME',		'img/logo_wap.png');
define('WB_LOGO_OUTPUT_DEFAULT_NAME',		'img/logo_output.png');
define('WB_LOGO_FILE_NAME',			'/data/logo/logo_upload.png');
define('WB_LOGO_WAP_FILE_NAME',			'/data/logo/logo_upload_wap.png');
define('WB_LOGO_OUTPUT_FILE_NAME',			'/data/logo/logo_upload_output.png');
define('WB_LOGO_PREVIEW_FILE_NAME',	'/data/logo/logo_previews.png');
/// 站点地址栏文件名
define('WB_ICON_DEFAULT_NAME',		'img/logo/default_icon.png');
define('WB_ICON_FILE_NAME',			'/data/logo/icon_upload.png');
define('WB_ICON_PREVIEW_FILE_NAME',	'/data/logo/icon_previews.png');
/// 网站认证大图标
define('AUTH_BIG_ICON_DEFAULT_NAME',		'img/logo/default_v1.png');
define('AUTH_BIG_ICON_FILE_NAME',			'/data/logo/big_auth_icon_upload.png');
define('AUTH_BIG_ICON_PREVIEW_FILE_NAME',	'/data/logo/big_auth_icon_previews.png');
/// 网站认证小图标
define('AUTH_SMALL_ICON_DEFAULT_NAME',		'img/logo/default_v2.png');
define('AUTH_SMALL_ICON_FILE_NAME',			'/data/logo/small_auth_icon_upload.png');
define('AUTH_SMALL_ICON_PREVIEW_FILE_NAME',	'/data/logo/small_auth_icon_previews.png');

define('WB_SKIN_BGIMG_UPLOAD_DIR',	'/data/skinbg/');
//----------------------------------------------------------------------
/// API 相关
/// 微博 api url
define('WEIBO_API_URL', 	'http://api.t.sina.com.cn/');
/// sinaurl.cn 地址信息查询API地址
define('SINAURL_INFO', 		'http://weibo.com/mblog/sinaurl_info.php');
/// 微博表情 url
define('WB_EMOTICONS_URL',	'http://timg.sjs.sinajs.cn/miniblog2style/images/common/face/basic/');
/// X微博升级检查URL
define('WB_UPGRADE_CHK_URL','http://x.weibo.com/service/stdVersion.php?p=std&v=' . WB_VERSION);
//define('WB_UPGRADE_CHK_URL', '');
/// SINA 微博的注册地址
define('SINA_WB_REG_URL',	'http://weibo.com/reg.php?ps=u3&lang=zh');
/// X微博用户反馈上报地址
define('WB_FEEDBACK_URL',	'http://x.weibo.com/xapi.php');
/// 测试地址
//define('WB_FEEDBACK_URL',	'http://x_dev.weibo.com/xapi.php');
//----------------------------------------------------------------------
/// 数据库名表名 content_unit
define('T_CONTENT_UNIT',	'content_unit');
/// 数据库名表名 ad
define('T_AD',				'ad');
/// 数据库名表名 admin
define('T_ADMIN',			'admin');
/// 数据库名表名 admin_group
define('T_ADMIN_GROUP',		'admin_group');
/// 数据库名表名 users
define('T_USERS',			'users');
/// 数据库名表名 users
define('T_USER_BAN',		'user_ban');
/// 数据库名表名 user_token
define('T_USER_TOKEN',		'user_token');
/// 数据表,今日话题
define('T_TODAY_TOPIC',		'today_topic');
/// 数据表,明人推荐
define('T_CELEBRITY', 		'celebrity');
/// 数据表，所有屏蔽相关的数据
define('T_DISABLE_ITEMS',	'disable_items');
/// 数据表,被屏蔽的热门转发和评论
define('T_DISABLED_HOT_PUBLISH', 'disabled_hot_publish');
/// 数据表,被屏蔽的"人气关注"用户
define('T_DISABLED_USER',	'disabled_user');
/// 数据表,被屏蔽的微博
define('T_DISABLED_WEIBO',	'disabled_weibo');
/// 数据表，被屏蔽的回复
define('T_DISABLED_COMMENT','disabled_comment');
/// 数据表,过滤关键词
define('T_KEYWORD',			'keyword');
/// 数据表,要加V的用户
define('T_USER_VERIFY',		'user_verify');
/// 关注人气榜基数
define('T_FOLLOWERS_COUNT',	'followers_count');
/// 数据表,被屏蔽的人气关注列表项
define('T_DISABLED_FOLLOWERS',	'disabled_followers');
/// 数据表,保存用户后台设置项
define('T_SYS_CONFIG',		'sys_config');
/// 数据表,保存用户自定义配置项
define('T_USER_CONFIG',		'user_config');
/// 代理帐号表
define('T_ACCOUNT_PROXY', 'account_proxy');
/// 组件表
define('T_COMPONENTS',		'components');
/// 组件配置表
define('T_COMPONENTS_CFG',		'component_cfg');
/// 用户分组列表
define('T_COMPONENT_USERGROUPS', 'component_usergroups');
/// 用于推荐的用户组成员
define('T_COMPONENT_USERS',		'component_users');
/// 今日话题
define('T_TODAY_TOPICS',		'today_topics');
/// 话题内容列表
define('T_COMPONENT_TOPIC',		'component_topic');
/// 话题分组
define('T_COMPONENT_TOPICLIST',	'component_topiclist');
/// 页面模块使用情况数据表
define('T_PAGE_MANAGER',		'page_manager');
/// 页面
define('T_PAGES',				'pages');
/// 皮肤类别表
define('T_SKIN_GROUPS',	'skin_groups');
/// 模板列表
define('T_SKINS',		'skins');
/// 插件
define('T_PLUGINS',		'plugins');
/// 个人信息推广位下的内容
define('T_PROFILE_AD',	'profile_ad');
/// 分组数据存储表
define('T_ITEM_GROUPS', 'item_groups');

/// 页面导航表
define('T_NAV', 'nav');

/// 页面原型表
define('T_PAGE_PROTOTYPE', 'page_prototype');

/// 名人用户表
define('T_CELEB', 'celeb');

/// 名人用户分类表
define('T_CELEB_CATEGORY', 'celeb_category');

/// 本地微博
define('T_WEIBO_COPY',		'weibo_copy');

define('T_FEEDBACK',		'feedback');

///话题收藏表
define('T_PAGE_SUBJECT',	'subject');

/// 个性域名保留词
define('KEEP_USERDOMAIN',	'keep_userdomain');
/// 用户关注关系表
define('T_USER_FOLLOW', 'user_follow');
/// 评论本地备份表
define('T_COMMENT_COPY', 'comment_copy');
/// 用户关系本地备份表，当XWB_PARENT_RELATIONSHIP配置为FALSE起作用
define('T_USER_FOLLOW_COPY', 'user_follow_copy');
/// 活动表
define('T_EVENTS',			'events');
define('T_EVENT_JOIN',		'event_join');
define('T_EVENT_COMMENT',	'event_comment');
/// 在线访谈表
define('T_MICRO_INTERVIEW', 'micro_interview');
define('T_INTERVIEW_WB', 'interview_wb');
define('T_INTERVIEW_WB_ATME', 'interview_wb_atme');
/// 通知信息表
define('T_NOTICE', 'notice');
define('T_NOTICE_RECIPIENTS', 'notice_recipients');

///有用户操作表
define('T_USER_ACTION',	'user_action');

/// 在线直播表 
define('T_MICRO_LIVE',		'micro_live');
define('T_MICRO_LIVE_WB',	'micro_live_wb');

/// 待审评论和删除评论表 
define('T_COMMENT_VERIFY',	'comment_verify');
define('T_COMMENT_DELETE',	'comment_delete');

/// 待审核微博和删除微博表
define('T_WEIBO_VERIFY', 'weibo_verify');
define('T_WEIBO_DELETE', 'weibo_delete');

/// 日志表, api表和http表单独分开
define('T_LOG_HTTP', 		'log_http');
define('T_LOG_ERROR', 		'log_error');
define('T_LOG_INFO', 		'log_info');
define('T_LOG_API_ERROR', 	'log_error_api');
define('T_LOG_API_INFO', 	'log_info_api');
//---------------------------------------------------------------------
/// cache下标定义 屏蔽回复
define('CACHE_DISABLED_COMMENT',			'disabled_comment');
/// cache下标定义  屏蔽微博
define('CACHE_DISABLED_WEIBO',				'disabled_weibo');
/// cache下标定义 昵称关键字
define('CACHE_DISABLED_NICK_KEYWORD',		'disabled_nick_keyword');
/// cache下标定义 内容关键字
define('CACHE_DISABLED_CONTENT_KEYWORD',	'disabled_content_keyword');
/// cache下标定义 通过认证的用户
define('CACHE_USER_VERIFY', 				'user_verify');
/// cache下标前缀定义 @me,评论,粉丝未读数
define('CACHE_UNREAD_COUNTER',				'unread_counter_');
/// cache下标,用户后台配置缓存
define('CACHE_SYS_CONFIG',					'sys_config');
/// cache下标,用户自定义配置缓存
define('CACHE_USER_CONFIG',					'user_config');
/// 组件配置信息缓存
define('CACHE_COMPONENT_CFG',				'component_cfg');

//----------------------------------------------------------------------
/// 全局配置变量
$cfg = array();
//----------------------------------------------------------------------
/// 适配器选择器
$cfg['adapter'] = array(
	'io'		=> FILE_ADAPTER,
	'db'		=> DB_ADAPTER,
	'http'		=> HTTP_ADAPTER,
	'cache'		=> CACHE_ADAPTER,
	'mailer'	=> SMTP_ADAPTER,
	'account'	=> ACCOUNT_ADAPTER,
	'upload'	=> UPLOAD_ADAPTER,
	'auth'		=> AUTH_ADAPTER,
	'image' 	=> IMAGE_ADAPTER,
	'mail'		=> MAIL_ADAPTER,
	'log'		=> LOG_ADAPTER
);
//----------------------------------------------------------------------
/// 适配器初始化数据配置变量
$cfg['adapter_cfg'] = array();
$_adapter = &$cfg['adapter_cfg'];
//----------------------------------------------------------------------
$_adapter['db'] = array();
$_adapter['account']['dzUcenter'] = array(
	'homeUrl'		=>'',
	'home2'			=>''
);

//----------------------------------------------------------------------
$_adapter['db'] = array();
$_adapter['db']['mysql'] = array(
	'host'	 => DB_HOST,
	'port'	 => DB_PORT,
	'user'	 => DB_USER,
	'pwd'	 => DB_PASSWD,
	'charset'=> DB_CHARSET,
	'tbpre'	 => DB_PREFIX,
	'db'	 => DB_NAME,
	'slaves' => array(
			array(
				'host'	 => DB_HOST_2,
				'port'	 => DB_PORT,
				'user'	 => DB_USER,
				'pwd'	 => DB_PASSWD,
				)
		)
);
//---------------------------------------------图片处理---------------------
$_adapter['image'] = array();
$_adapter['image']['sae'] = array();
//---------------------------------------------验证码---------------------
$_adapter['auth'] = array();
$_adapter['auth']['sae'] = array();
//----------------------------------------------------------------------
$_adapter['upload'] = array();
$_adapter['upload']['upload'] = array();
//----------------------------------------------------------------------
$_adapter['io'] = array();
$_adapter['io']['file'] = array();
$_adapter['io']['ftp']	= array();
//----------------------------------------------------------------------
$_adapter['http'] = array();
$_adapter['http']['curl'] 		= array();
$_adapter['http']['fsockopen'] 	= array();
$_adapter['http']['snoopy'] 	= array();
//----------------------------------------------------------------------
$_adapter['mail'] = array();
$_adapter['mail']['sae']		= array();
//----------------------------------------------------------------------
$_adapter['cache'] = array();
$_adapter['cache']['file'] 				= array(
	'baseDir'=>		P_VAR_CACHE,
	'pathLevel'=>	3,
	'nameLen'=>		2,
	'varName'=>		'__cache_data'
);
$_adapter['cache']['serialize'] 		= array(
	'baseDir'=>		P_VAR_CACHE,
	'pathLevel'=>	3,
	'nameLen'=>		2
);

$_adapter['cache']['xcache'] 			= array();
$_adapter['cache']['memcache'] 			= array(
	'pconnect'=>false,
	'servers'=>	MC_HOST,
	'keyPre'=>	MC_PREFIX
);
$_adapter['cache']['eaccelerator'] 		= array();
//----------------------------------------------------------------------
$_adapter['mail'] = array();
$_adapter['mail']['mail'] 	= array();
$_adapter['mail']['smtp']	= array();
//----------------------------------------------------------------------
/// WB api接口错误状态吗
$cfg['apierrno'] = array('400', '403', '404', '500');
//----------------------------------------------------------------------
/// 访问控制列表
$aclTable = &$cfg['aclTable'];
/// TODO入口控制配置 : 入口名 路由匹配正则 控制选项 （选项为 true 时 表示匹配的路由被允许访问 ）
$aclTable['E']		= array();
$aclTable['E'][]	= array('admin',	"#^admin/.*#sim",true);
$aclTable['E'][]	= array('index',	"#^admin/.*#sim",false);

/// IP控制配置 ： 入口名称 IP匹配正则 控制选项
$aclTable['IP']		= array();
//$aclTable['IP'][]	= array('index',"",true);

//----------------------------------------------------------------------
// 模板使用的配置变量，使用方法：  V('-:tpl/title');
$tpl = &$cfg['tpl'];
$tpl['title'] = array(
			//标题前缀
			'_pre' => '',
			//标题后缀
			'_suf' => ' - Powered By Xweibo',

			//根据页面路由配置页面标题，可使用格式 如下
			'comDemo.tit'=> 'pageTitle__comDemo__title',
			'pub'=>'pageTitle__pub__title',
			'pub.look' => 'pageTitle__pubLook__title',
			'pub.topics' => 'pageTitle__pubTopic__title',
			'pub.hotForward' => 'pageTitle__pubHotForward__title',
			'pub.hotComments' => 'pageTitle__pubHotComments__title',
			'search.recommend' => 'pageTitle__searchRecommend__title',
			'search' => 'pageTitle__search__title',
			'search.user' => 'pageTitle__searchUser__title',
			'search.weibo' => 'pageTitle__searchWeibo__title',
			'index' => 'pageTitle__index__title',
			'account.login' => 'pageTitle__accountLogin__title',
			'account.bind' => 'pageTitle__accountBind__title',
			'account.isBinded' => 'pageTitle__accountIsBinded__title',
			'index.atme' => 'pageTitle__indexAtme__title',
			'index.comments' => 'pageTitle__indexComments__title',
			'index.commentsend' => 'pageTitle__indexCommentsend__title',
			'index.messages' => 'pageTitle__indexMessages__title',
			'index.notices' => 'pageTitle__indexNotices__title',
			'index.favorites' => 'pageTitle__indexFavorites__title',
			'index.profile' => 'pageTitle__indexProfile__title',
			'index.fans' => 'pageTitle__indexFans__title',
			'index.follow' => 'pageTitle__indexFollow__title',
			'index.setinfo' => 'pageTitle__indexSetinfo__title',
			'index.info' => 'pageTitle__indexInfo__title',
			'ta' => 'pageTitle__ta__title',
			'ta.profile' => 'pageTitle__taProfile__title',
			'ta.fans' => 'pageTitle__taFans__title',
			'ta.follow' => 'pageTitle__taFollow__title',
			'ta.mention' =>'pageTitle__taMention__title',
			'setting' => 'pageTitle__setting__title',
			'setting.user' => 'pageTitle__settingUser__title',
			'setting.tag' => 'pageTitle__settingTag__title',
			'setting.myface' => 'pageTitle__settingMyface__title',
			'setting.show' => 'pageTitle__settingShow__title',
			'setting.blacklist' => 'pageTitle__settingBlacklist__title',
			'setting.notice' => 'pageTitle__settingNotice__title',
			'setting.account' => 'pageTitle__settingAccount__title',
			'setting.domain' => 'pageTitle__settingDomain__title',
			'show' => 'pageTitle__show__title',
			'show.repos'=>'pageTitle__showRepos__title',
			'event' => 'pageTitle__event__title',
			'event.mine' => 'pageTitle__eventMine__title',
			'event.details' => 'pageTitle__eventDetails__title',
			'event.member' => 'pageTitle__eventMember__title',
			'event.create' => 'pageTitle__eventCreate__title',
			'event.modify' => 'pageTitle__eventModify__title',
			'live' => 'pageTitle__live__title',
			'live.details' => 'pageTitle__liveDetails__title',
			'live.livelist' => 'pageTitle__liveLivelist__title',
			'interview' => 'pageTitle__interview__title',
			'interview.page' => 'pageTitle__interviewPage__title',
			'wbcom.viewPhoto' => 'pageTitle__wbcomViewPhoto__title',
			'wbcom.replyComment' => 'pageTitle__wbcomReplyComment__title',
			'wbcom.sendWBFrm' => 'pageTitle__wbcomSendWBFrm__title',
			'wbcom.sendMsgFrm' => 'pageTitle__wbcomSendMsgFrm__title',
			'account.showLogin' => 'pageTitle__accountShowLogin__title'
			);
//----------------------------------------------------------------------
/// sina微博名人推荐类别
$cfg['userhot'] = array(
		'1' => array('value' => 'default', 'key' => '人气关注'),
		'2' => array('value' => 'ent', 'key' => '影视名星'),
		'3' => array('value' => 'hk_famous', 'key' => '港台名人'),
		'4' => array('value' => 'model', 'key' => '模特'),
		'5' => array('value' => 'cooking', 'key' => '美食&健康'),
		'6' => array('value' => 'sport', 'key' => '体育名人'),
		'7' => array('value' => 'finance', 'key' => '商界名人'),
		'8' => array('value' => 'tech', 'key' => 'IT互联网'),
		'9' => array('value' => 'singer', 'key' => '歌手'),
		'10' => array('value' => 'writer', 'key' => '作家'),
		'11' => array('value' => 'moderator', 'key' => '主持人'),
		'12' => array('value' => 'medium', 'key' => '媒体总编'),
		'13' => array('value' => 'stockplayer', 'key' => '炒股高手')
	);
//----------------------------------------------------------------------
/// 哪些控制器需要检查是是否允许禁止发言用户操作
$cfg['writeableCheckRouter']=array('api/weibo/action.comment',
									 'api/weibo/action.sendDirectMessage',
									 'api/weibo/action.update',
									 'api/weibo/action.applyDomain',
									 'api/weibo/action.repost',
									 'api/weibo/action.createFriendship',
									 'event.create',
									 'event.saveEvent',
									 'event.joinEvent'
									 );

//----------------------------------------------------------------------
/// 缓存时间设置, route+desc=time, time 以秒为单位
$tpl['cache_time'] = array(
	'output_nologin' 				=> 300,
	'output_type1_login' 			=> 300,			// 微博秀
	'output_type2_login' 			=> 300,			// 推荐guanz
	'output_type3_login' 			=> 30,			// 互动话题
	'pagelet_component1'			=> 300,			// 热门转发与评论
	'pagelet_component2'			=> 300,			// 用户组
	'pagelet_component3'			=> 300,			// 推荐用户
	'pagelet_component4'			=> 300,			// 人气关注榜模块
	'pagelet_component5'			=> 30,			// 群组微博
	'pagelet_component6'			=> 300,			// 话题推荐列表
	'pagelet_component7'			=> 300,			// 可能感兴趣的人(未登录，不显示)
	'pagelet_component8'			=> 300,			// 同城微博(未登录缓存, 登录不缓存)
	'pagelet_component9'			=> 30,			// 随便看看
	'pagelet_component10'			=> 30,			// 今日话题(未登录缓存, 登录不缓存)
	'pagelet_component11'			=> 300,			// 用户组
	'pagelet_component12'			=> 30,			// 话题微博
	'pagelet_component14'			=> 300,			// 最新微博
	'pagelet_component15'			=> 300,			// 最新用户
	'pagelet_component18'			=> 300,			// 活动列表
	'pagelet_component19'			=> 300			// 本地关注榜
);
									 
/// xweibo模板配置
define('PAGE_TYPE_SYSCONFIG', 	'wb_page_type');
define('PAGE_TYPE_DEFAULT', 	'1');
/// 两栏不显示的后台
$cfg['adminNotShowNav'][1] = array(
		'mgr/setting.header' => 1
	);
/// 三栏不显示的后台
$cfg['adminNotShowNav'][2] = array(
		'mgr/skin' 						=> 1,
		'mgr/setting.getlink.header'	=> 1,
		'mgr/ad' 						=> 1
	);

/// weibo页头设置
define('HEADER_MODEL_SYSCONFIG', 	'wb_header_model');
define('HEADER_HTMLCODE_SYSCONFIG', 'wb_header_htmlcode');
//----------------------------------------------------------------------
/// 是否启用私信功能，FALSE：不启用；TRUE：启用
define('HAS_DIRECT_MESSAGES', FALSE);
/// 是否启用个人资料功能，FALSE：不启用；TRUE：启用
define('HAS_DIRECT_UPDATE_PROFILE', FALSE);
/// 是否启用修改头像功能，FALSE：不启用；TRUE：启用
define('HAS_DIRECT_UPDATE_PROFILE_IMAGE', FALSE);
