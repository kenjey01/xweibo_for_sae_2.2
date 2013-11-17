--
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `xwb_admin`
--

DROP TABLE IF EXISTS `xwb_admin`;

CREATE TABLE `xwb_admin` (
  `id` int(11) NOT NULL auto_increment,
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用户ID',
  `pwd` varchar(32) default NULL,
  `add_time` int(10) unsigned default NULL COMMENT '加入的时间',
  `is_root` tinyint(1) NOT NULL default '0' COMMENT '是否拥有帐号管理权限 1.拥有 0.不拥有',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员列表及密码';


--
-- Table structure for table `xwb_api_log`
--

DROP TABLE IF EXISTS `xwb_api_log`;

CREATE TABLE `xwb_api_log` (
  `id` int(4) unsigned NOT NULL auto_increment,
  `url` varchar(500) default NULL COMMENT '请求url',
  `base_string` varchar(500) NOT NULL default '' COMMENT '加密的base_string',
  `key_string` varchar(500) NOT NULL default '' COMMENT '加密的key_string',
  `http_code` int(4) default NULL COMMENT 'http code',
  `ret` varchar(200) NOT NULL default '' COMMENT '返回结果',
  `post_data` text COMMENT 'post数据',
  `request_time` float default NULL COMMENT '请求时间',
  `total_time` float default NULL COMMENT '总执行时间',
  `s_ip` char(15) default NULL COMMENT '服务器ip',
  `log_time` char(20) default NULL COMMENT '记录时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='请求接口日志';


--
-- Table structure for table `xwb_component_cfg`
--

DROP TABLE IF EXISTS `xwb_component_cfg`;

CREATE TABLE `xwb_component_cfg` (
  `component_id` int(10) unsigned NOT NULL,
  `cfgName` varchar(30) NOT NULL COMMENT '参数名称',
  `cfgValue` varchar(255) default NULL COMMENT '参数值',
  `desc` varchar(50) default NULL COMMENT '配置项说明',
  PRIMARY KEY  (`component_id`,`cfgName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='组件对应的配置';

--
-- Dumping data for table `xwb_component_cfg`
--


INSERT INTO `xwb_component_cfg` VALUES (1,'show_num','3','组件显示的微博数'),(2,'group_id','1','名人推荐用户组对应的用户列表ID'),(2,'show_num','6','显示的名人数'),(3,'show_num','6',''),(3,'group_id','2','推荐用户组使用的用户列表ID'),(5,'list_id','','list id'),(5,'show_num','3',''),(6,'show_num','10',''),(6,'topic_id','0','0 使用新浪API取数据　> 0 对应的话题组ID'),(7,'show_num','9',''),(8,'show_num','3',''),(9,'show_num','4','随便看看'),(10,'group_id','1','今日话题使用的话题组'),(10,'show_num','4','今日话题显示的微博数'),(11,'groups','','记录分组ID');


--
-- Table structure for table `xwb_component_topic`
--

DROP TABLE IF EXISTS `xwb_component_topic`;

CREATE TABLE `xwb_component_topic` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topic_id` int(10) unsigned NOT NULL,
  `topic` varchar(50) NOT NULL COMMENT '话题',
  `date_time` int(10) unsigned NOT NULL COMMENT '生效时间或添加时间',
  `sort_num` int(10) unsigned NOT NULL default '0' COMMENT '排序',
  `ext1` varchar(45) default NULL COMMENT '扩展字段',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='热门话题列表';

--
-- Dumping data for table `xwb_component_topic`
--


INSERT INTO `xwb_component_topic` VALUES (1,2,'xweibo',1291106229,0,1291106229),(2,1,'Xweibo',1291311717,0,'1291311717'),(3,1,'开放平台',1291311724,0,'1291311724');


--
-- Table structure for table `xwb_component_topiclist`
--

DROP TABLE IF EXISTS `xwb_component_topiclist`;

CREATE TABLE `xwb_component_topiclist` (
  `topic_id` int(10) unsigned NOT NULL auto_increment COMMENT '话题ID',
  `topic_name` varchar(25) NOT NULL COMMENT '话题列表的名称',
  `native` tinyint(1) NOT NULL default '0' COMMENT '是否为内置话题，内置不能删除',
  `sort` varchar(1) NOT NULL default '1' COMMENT '类别下的话题是否允许排序',
  `app_with` text,
  PRIMARY KEY  (`topic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `xwb_component_topiclist`
--


INSERT INTO `xwb_component_topiclist` VALUES (1,'推荐话题',1,'1',NULL),(2,'今日话题',1,'0',NULL),(3,'自定义话题',0,'1',NULL);


--
-- Table structure for table `xwb_component_usergroups`
--

DROP TABLE IF EXISTS `xwb_component_usergroups`;

CREATE TABLE `xwb_component_usergroups` (
  `group_id` int(10) unsigned NOT NULL auto_increment COMMENT '分组ID',
  `group_name` varchar(15) NOT NULL COMMENT '组名称',
  `native` tinyint(1) NOT NULL default '0' COMMENT '是否为内置列表 1:是 0:否',
  `related_id` varchar(50) default NULL COMMENT '组件应用情况，即哪位ID的组件使用了，可为多个，逗号分隔',
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='推荐用户　的各个分组';

--
-- Dumping data for table `xwb_component_usergroups`
--


INSERT INTO `xwb_component_usergroups` VALUES (1,'名人推荐列表',1,'2:1,11:1'),(2,'用户推荐列表',1,'3:1,11:1'),(3,'自动关注用户列表',1,'4:2'),(4,'官方微博用户列表',1,'5:1');


--
-- Table structure for table `xwb_component_users`
--

DROP TABLE IF EXISTS `xwb_component_users`;

CREATE TABLE `xwb_component_users` (
  `group_id` int(10) unsigned NOT NULL auto_increment COMMENT '唯一、自增的用户分组ID',
  `uid` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `sort_num` int(11) NOT NULL default '0' COMMENT '排序',
  `nickname` varchar(20) default NULL COMMENT '用户昵称',
  `remark` varchar(255) default NULL COMMENT '备注',
  PRIMARY KEY  (`group_id`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户列表成员表';

--
-- Dumping data for table `xwb_component_users`
--


INSERT INTO `xwb_component_users` VALUES (1,1782515283,1,'网站合作大掌柜','网站合作大掌柜'),(1,1076590735,2,'Xweibo官方','Xweibo官方微博'),(1,11051,3,'微博开放平台','微博开放平台'),(2,1782515283,1,'网站合作大掌柜','网站合作大掌柜'),(2,1076590735,2,'Xweibo官方','Xweibo官方微博'),(2,11051,3,'微博开放平台','微博开放平台'),(3,1618051664,1,'头条新闻','头条新闻'),(3,1638781994,2,'新浪体育','新浪体育'),(3,1642591402,3,'新浪娱乐','新浪娱乐');


--
-- Table structure for table `xwb_components`
--

DROP TABLE IF EXISTS `xwb_components`;

CREATE TABLE `xwb_components` (
  `component_id` int(10) unsigned NOT NULL auto_increment COMMENT '唯一、自增ID',
  `name` varchar(20) NOT NULL COMMENT '组件名称',
  `title` varchar(45) default NULL COMMENT '用于显示的名称',
  `type` tinyint(4) default NULL COMMENT '组件类型　１热门转发评论　２名人推荐　３推荐用户　４人气关注榜　５官方微博组件　６热门话题　７猜你喜欢　８同城微博　９随便看看　１０今日话题　１１分类用户推荐',
  `native` tinyint(1) NOT NULL default '1' COMMENT '是否为内置类型',
  `component_type` tinyint(4) NOT NULL COMMENT '组件类型 1: 页面主体 2: 侧边栏',
  `symbol` varchar(20) NOT NULL COMMENT '模块标识，程序中使用',
  `desc` varchar(255) default NULL COMMENT '模块说明',
  PRIMARY KEY  (`component_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='组件表';

--
-- Dumping data for table `xwb_components`
--


INSERT INTO `xwb_components` VALUES (1,'热门转发评论','热门转发评论',1,1,1,'hotWb','该组件列示了转发数最多以及评论数最多的微博消息。'),(2,'名人推荐','名人推荐',2,1,1,'starRcm','该组件按照名人推荐列表的设置，显示推荐的名人。'),(3,'用户推荐','用户推荐',3,1,2,'userRcm','该组件按照用户推荐列表的设置，显示推荐的用户。'),(5,'官方微博','官方微博',5,1,1,'official','该组件按照官方微博用户列表的设置，显示官方成员的微博消息。'),(6,'推荐话题','推荐话题',6,1,2,'hotTopic','该组件按照推荐话题的设置，显示话题列表。'),(7,'猜你喜欢','猜你喜欢',7,1,2,'guessYouLike','该组件自动列示用户可能感兴趣的用户。'),(8,'同城微博','同城微博',8,1,1,'cityWb','该组件列示了用户所在地的最新微博消息。'),(9,'随便看看','随便看看',9,1,1,'looklook','该组件列示了最新公共微博的消息。'),(10,'今日话题','今日话题',10,1,1,'todayTopic','该组件根据今日话题列表中最近生效的话题，自动获取与话题相关的微博消息。'),(11,'分类用户推荐','分类用户推荐',11,1,1,'groupUserRcm',NULL);


--
-- Table structure for table `xwb_disable_items`
--

DROP TABLE IF EXISTS `xwb_disable_items`;

CREATE TABLE `xwb_disable_items` (
  `kw_id` int(10) unsigned NOT NULL auto_increment COMMENT '唯一、自增ID',
  `type` tinyint(4) NOT NULL COMMENT '内容类型：１微博ID　２评论ID　３昵称　４内容',
  `item` varchar(45) NOT NULL COMMENT '屏蔽或禁止的ID或内容',
  `comment` varchar(60) NOT NULL COMMENT '相关显示内容',
  `admin_name` varchar(24) NOT NULL COMMENT '管理员操作时的昵称',
  `admin_id` int(10) unsigned NOT NULL COMMENT '管理员ID',
  `user` varchar(45) NOT NULL COMMENT '微博或评论的作者',
  `publish_time` varchar(20) NOT NULL COMMENT '微博或评论的发布时间yyyy-mm-dd hh:ii:ss格式字串',
  `add_time` int(10) unsigned NOT NULL COMMENT '加入时间',
  PRIMARY KEY  (`kw_id`),
  UNIQUE KEY `Index_type_item` (`type`,`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='屏蔽或禁止的内容列表';

--
-- Dumping data for table `xwb_disable_items`
--




--
-- Table structure for table `xwb_item_groups`
--

DROP TABLE IF EXISTS `xwb_item_groups`;

CREATE TABLE `xwb_item_groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL COMMENT '分组ID 已定义的，1：分类用户推荐 2：引导关注类别',
  `item_id` int(11) NOT NULL COMMENT '分组对象的ID',
  `item_name` varchar(25) default NULL COMMENT '分组名称',
  `sort_num` int(11) default '0' COMMENT '排序ID，通常用于组内',
  PRIMARY KEY  (`id`),
  KEY `group_idx` (`group_id`,`sort_num`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用于存储ID分组列表，如用户分类';

--
-- Dumping data for table `xwb_item_groups`
--


INSERT INTO `xwb_item_groups` VALUES (2,1,1,'名人推荐',0),(3,1,2,'用户推荐',0),(4,2,1,'名人推荐',0),(5,2,2,'用户推荐',0);


--
-- Table structure for table `xwb_page_manager`
--

DROP TABLE IF EXISTS `xwb_page_manager`;

CREATE TABLE `xwb_page_manager` (
  `page_id` int(11) NOT NULL COMMENT '预定义的页面ID：如１：广场。。',
  `component_id` int(11) default NULL COMMENT '使用到的组件ID',
  `position` int(11) NOT NULL default '0' COMMENT '摆放的位置 1:左边　２：右侧栏',
  `sort_num` int(11) default '0' COMMENT '摆放的顺序',
  `in_use` tinyint(1) default '1' COMMENT '是否使用'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='页面设置';

--
-- Dumping data for table `xwb_page_manager`
--


INSERT INTO `xwb_page_manager` VALUES (1,10,1,1,1),(1,1,1,5,1),(1,8,1,3,1),(1,2,1,4,1),(1,9,1,2,1),(1,5,1,6,1),(1,6,2,3,1),(1,3,2,2,1),(2,3,2,1,1),(2,6,2,2,1),(2,7,2,3,1);


--
-- Table structure for table `xwb_pages`
--

DROP TABLE IF EXISTS `xwb_pages`;

CREATE TABLE `xwb_pages` (
  `page_id` int(10) unsigned NOT NULL auto_increment COMMENT '页面id',
  `page_name` varchar(20) default NULL COMMENT '页面名称',
  `desc` varchar(255) default NULL COMMENT '页面描述',
  `native` tinyint(1) NOT NULL default '0' COMMENT '是否为内置页',
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `xwb_pages`
--


INSERT INTO `xwb_pages` VALUES (1,'微博广场','“微博广场”是用户免登录即可查看的页面，包含了今日话题、随便看看等组件。',1),(2,'我的首页','“我的首页”是登录用户操作微博的页面，包含了猜你喜欢、推荐话题等组件。',1);


--
-- Table structure for table `xwb_plugins`
--

DROP TABLE IF EXISTS `xwb_plugins`;

CREATE TABLE `xwb_plugins` (
  `plugin_id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(20) default NULL COMMENT '名称',
  `desc` varchar(255) default NULL COMMENT '简介',
  `in_use` tinyint(1) default '1' COMMENT '是否开启',
  PRIMARY KEY  (`plugin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `xwb_plugins`
--


INSERT INTO `xwb_plugins` VALUES (1,'页尾广告','开启广告插件并且添加相应的广告代码，全站所有页面将在特定位置显示您所设置的广告。',1),(2,'用户首页聚焦位','开启该插件会将站长设定的内容以图文的形式显示于用户首页中。',1),(3,'个人资料推广位','开启该插件会将站长设定的内容以文字链接的形式显示于用户的个人信息的下方。',1),(4,'登录后引导关注','开启该插件后，用户首次登录会强制关注指定的用户并且引导用户其它推荐用户。',1);


--
-- Table structure for table `xwb_profile_ad`
--

DROP TABLE IF EXISTS `xwb_profile_ad`;

CREATE TABLE `xwb_profile_ad` (
  `link_id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(50) NOT NULL COMMENT '标题',
  `link` varchar(255) NOT NULL COMMENT '链接',
  `add_time` int(11) default NULL COMMENT '添加的时间',
  PRIMARY KEY  (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='个人信息推广位的广告';

--
-- Dumping data for table `xwb_profile_ad`
--


INSERT INTO `xwb_profile_ad` VALUES (2,'新浪微博','http://weibo.com',NULL),(3,'Xweibo','http://x.weibo.com/',NULL),(4,'新浪网','http://www.sina.com.cn/',NULL);


--
-- Table structure for table `xwb_skin_groups`
--

DROP TABLE IF EXISTS `xwb_skin_groups`;

CREATE TABLE `xwb_skin_groups` (
  `style_id` int(10) unsigned NOT NULL auto_increment COMMENT '模板分类ID',
  `style_name` varchar(15) NOT NULL COMMENT '分类名称',
  `sort_num` int(11) NOT NULL default '0' COMMENT '显示排序',
  PRIMARY KEY  (`style_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='皮肤类别表';

--
-- Dumping data for table `xwb_skin_groups`
--


INSERT INTO `xwb_skin_groups` VALUES (1,'经典',1),(2,'时尚',2);


--
-- Table structure for table `xwb_skins`
--

DROP TABLE IF EXISTS `xwb_skins`;

CREATE TABLE `xwb_skins` (
  `skin_id` int(10) unsigned NOT NULL auto_increment COMMENT '模板ID',
  `name` varchar(45) default NULL COMMENT '文件名名称',
  `directory` varchar(45) NOT NULL COMMENT '所在的目录',
  `desc` varchar(255) default NULL COMMENT '模板说明',
  `state` tinyint(4) NOT NULL default '1' COMMENT '模板状态　０正常（启用）　１禁用　２文件不存在（不可用）',
  `style_id` int(11) NOT NULL default '0' COMMENT '模板分类ID',
  `sort_num` int(11) NOT NULL default '0' COMMENT '显示排序',
  PRIMARY KEY  (`skin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='模板列表';

--
-- Dumping data for table `xwb_skins`
--


INSERT INTO `xwb_skins` VALUES (1,'旅行','skin_tour','关于旅行的皮肤',0,2,1),(2,'科技','skin_tech','关于科技的皮肤',0,2,2),(3,'荷花','skin_lotus','关于荷花的皮肤',0,1,3),(4,'风景','skin_landscape','关于风景的皮肤',0,1,4),(5,'默认','skin_default','默认皮肤',0,0,0),(6,'海滩','skin_beach','关于海滩的皮肤',0,1,5);


--
-- Table structure for table `xwb_sys_config`
--

DROP TABLE IF EXISTS `xwb_sys_config`;

CREATE TABLE `xwb_sys_config` (
  `key` varchar(40) NOT NULL,
  `value` text,
  `group_id` int(10) unsigned NOT NULL default '1' COMMENT '配置的分组ID',
  PRIMARY KEY  (`key`,`group_id`),
  KEY `idx_groupid` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统配置信息';

--
-- Dumping data for table `xwb_sys_config`
--


INSERT INTO `xwb_sys_config` VALUES ('rewrite_enable','0',1),('logo','',1),('login_way','1',1),('third_code','',1),('site_record','',1),('address_icon','',1),('head_link','{\"3\":{\"link_name\":\"\\u65b0\\u6d6a\\u5fae\\u535a\",\"link_address\":\"http:\\/\\/weibo.com\\/\"},\"4\":{\"link_name\":\"Xweibo\",\"link_address\":\"http:\\/\\/x.weibo.com\\/\"}}',1),('foot_link','{\"2\":{\"link_name\":\"\\u610f\\u89c1\\u53cd\\u9988\",\"link_address\":\"http:\\/\\/x.weibo.com\\/bbs\\/\"},\"3\":{\"link_name\":\"\\u5e2e\\u52a9\\u4e2d\\u5fc3\",\"link_address\":\"http:\\/\\/x.weibo.com\\/help.php\"}}',1),('authen_enable','0',1),('authen_big_icon','img/logo/big_auth_icon.png',1),('authen_small_icon','img/logo/small_auth_icon.png',1),('skin_default','10',1),('ad_header','',1),('guide_auto_follow','1',1),('ad_footer','<a href=\"http://x.weibo.com\" target=\"_blank\"><img src=\"img/ad/footer_ad.png\"></a>',1),('title','Xweibo 1.1.0 ',2),('text','新版Xweibo提供了丰富的运营功能，包括游客访问、换肤机制、用户推荐、话题推荐等等。此外，站长还能在多个区域发布广告，获得收入。',2),('bg_pic','',2),('oper','2',2),('topic','',2),('link','http://x.weibo.com/products.php',2),('btnTitle','了解更多',2),('guide_auto_follow_id','3',1),('authen_small_icon_title','',1);


--
-- Table structure for table `xwb_user_ban`
--

DROP TABLE IF EXISTS `xwb_user_ban`;

CREATE TABLE `xwb_user_ban` (
  `id` int(11) NOT NULL auto_increment,
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用户ID',
  `ban_time` int(11) default NULL COMMENT '封禁时间',
  `nick` varchar(20) default NULL COMMENT '封禁用户的昵称',
  PRIMARY KEY  (`id`),
  KEY `nick` (`nick`),
  KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='封禁用户列表';

--
-- Dumping data for table `xwb_user_ban`
--




--
-- Table structure for table `xwb_user_config`
--

DROP TABLE IF EXISTS `xwb_user_config`;

CREATE TABLE `xwb_user_config` (
  `id` int(4) unsigned NOT NULL auto_increment,
  `sina_uid` bigint(20) unsigned NOT NULL,
  `values` varchar(100) NOT NULL default '0' COMMENT '用户自定义的配置',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户自定义配置的信息';

--
-- Dumping data for table `xwb_user_config`
--




--
-- Table structure for table `xwb_user_verify`
--

DROP TABLE IF EXISTS `xwb_user_verify`;

CREATE TABLE `xwb_user_verify` (
  `id` int(11) NOT NULL auto_increment,
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用户ID',
  `nick` varchar(45) NOT NULL COMMENT '要加V的用户',
  `add_time` int(10) unsigned default NULL,
  `operator` bigint(20) NOT NULL COMMENT '操作者的ID',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_nick` (`nick`),
  KEY `index_add_time` (`add_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='要加V的用户';

--
-- Dumping data for table `xwb_user_verify`
--




--
-- Table structure for table `xwb_users`
--

DROP TABLE IF EXISTS `xwb_users`;

CREATE TABLE `xwb_users` (
  `id` int(11) NOT NULL auto_increment,
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用户ID',
  `nickname` varchar(25) NOT NULL COMMENT '昵称',
  `first_login` int(10) unsigned default NULL COMMENT '首次登录时间',
  `access_token` varchar(50) default NULL COMMENT '授权后得到访问API的token',
  `token_secret` varchar(50) default NULL COMMENT 'API服务器生成的加密串',
  `uid` bigint(20) default NULL COMMENT '所捆绑的合作方的用户ID',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sina_uid` (`sina_uid`),
  KEY `nickname` (`nickname`),
  KEY `site_uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户表---所有登录过的用户';
