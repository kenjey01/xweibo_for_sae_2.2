--
-- Table structure for table `xwb_account_proxy`
--

DROP TABLE IF EXISTS `xwb_account_proxy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_account_proxy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sina_uid` varchar(16) DEFAULT NULL,
  `screen_name` varchar(45) DEFAULT NULL,
  `token` varchar(45) DEFAULT NULL,
  `secret` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


--
-- Table structure for table `xwb_comment_delete`
--

DROP TABLE IF EXISTS `xwb_comment_delete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_comment_delete` (
  `id` bigint(20) unsigned NOT NULL COMMENT '评论ID',
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '发评论者的新浪UID',
  `sina_nick` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT '发布者新浪的昵称',
  `mid` bigint(20) unsigned NOT NULL COMMENT '微博ID',
  `reply_cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论ID',
  `content` varchar(140) CHARACTER SET utf8 NOT NULL COMMENT '评论内容',
  `post_ip` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '发布者IP',
  `dateline` int(10) unsigned NOT NULL COMMENT '评论时间',
  `add_time` int(11) unsigned NOT NULL COMMENT '增加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC COMMENT='评论删除表';


--
-- Table structure for table `xwb_comment_verify`
--

DROP TABLE IF EXISTS `xwb_comment_verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_comment_verify` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '发评论者的新浪UID',
  `sina_nick` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT '发布者新浪的昵称',
  `token` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '发布者的token',
  `token_secret` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '发布者的token_secret',
  `mid` bigint(20) unsigned NOT NULL COMMENT '微博ID',
  `reply_cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论ID',
  `content` varchar(140) CHARACTER SET utf8 NOT NULL COMMENT '评论内容',
  `post_ip` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '发布者IP',
  `dateline` int(11) unsigned NOT NULL COMMENT '用户评论时间',
  `forward` varchar(1) COLLATE utf8_bin DEFAULT NULL COMMENT '是否作为一条新微博发布',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC COMMENT='评论待审表';


--
-- Table structure for table `xwb_log_error`
--

DROP TABLE IF EXISTS `xwb_log_error`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_error` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识ID',
  `soft` varchar(45) NOT NULL COMMENT '软件名称',
  `version` varchar(10) NOT NULL COMMENT '版本',
  `akey` varchar(45) NOT NULL COMMENT 'app key',
  `type` varchar(10) NOT NULL COMMENT '日志类型，IO/DB/CACHE/API',
  `level` varchar(10) NOT NULL COMMENT '日志等级 ,error、warning',
  `msg` varchar(500) NOT NULL COMMENT '日志信息',
  `extra` varchar(500) DEFAULT NULL COMMENT '扩展信息',
  `log_time` datetime NOT NULL COMMENT '记录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `xwb_log_error_api`
--

DROP TABLE IF EXISTS `xwb_log_error_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_error_api` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识ID',
  `soft` varchar(45) NOT NULL COMMENT '软件名称',
  `version` varchar(10) NOT NULL COMMENT '版本',
  `akey` varchar(45) NOT NULL COMMENT 'app key',
  `type` varchar(10) NOT NULL COMMENT '日志类型，IO/DB/CACHE/API',
  `level` varchar(10) NOT NULL COMMENT '日志等级 ,error、warning',
  `msg` varchar(500) NOT NULL COMMENT '日志信息',
  `extra` varchar(500) DEFAULT NULL COMMENT '扩展信息',
  `log_time` datetime NOT NULL COMMENT '记录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `xwb_log_http`
--

DROP TABLE IF EXISTS `xwb_log_http`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_http` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(500) DEFAULT NULL COMMENT '请求url',
  `base_string` varchar(500) NOT NULL DEFAULT '' COMMENT '加密的base_string',
  `key_string` varchar(500) NOT NULL DEFAULT '' COMMENT '加密的key_string',
  `http_code` int(4) DEFAULT NULL COMMENT 'http code',
  `ret` varchar(200) NOT NULL DEFAULT '' COMMENT '返回结果',
  `post_data` text COMMENT 'post数据',
  `request_time` float DEFAULT NULL COMMENT '请求时间',
  `total_time` float DEFAULT NULL COMMENT '总执行时间',
  `s_ip` char(15) DEFAULT NULL COMMENT '服务器ip',
  `log_time` char(20) DEFAULT NULL COMMENT '记录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='请求接口日志';


--
-- Table structure for table `xwb_log_info`
--

DROP TABLE IF EXISTS `xwb_log_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识ID',
  `soft` varchar(45) NOT NULL COMMENT '软件名称',
  `version` varchar(10) NOT NULL COMMENT '版本',
  `akey` varchar(45) NOT NULL COMMENT 'app key',
  `type` varchar(10) NOT NULL COMMENT '日志类型，IO/DB/CACHE/API',
  `level` varchar(10) NOT NULL COMMENT '日志等级 ,error、warning',
  `msg` varchar(500) NOT NULL COMMENT '日志信息',
  `extra` varchar(500) DEFAULT NULL COMMENT '扩展信息',
  `log_time` datetime NOT NULL COMMENT '记录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `xwb_log_info_api`
--

DROP TABLE IF EXISTS `xwb_log_info_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_info_api` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识ID',
  `soft` varchar(45) NOT NULL COMMENT '软件名称',
  `version` varchar(10) NOT NULL COMMENT '版本',
  `akey` varchar(45) NOT NULL COMMENT 'app key',
  `type` varchar(10) NOT NULL COMMENT '日志类型，IO/DB/CACHE/API',
  `level` varchar(10) NOT NULL COMMENT '日志等级 ,error、warning',
  `msg` varchar(500) NOT NULL COMMENT '日志信息',
  `extra` varchar(500) DEFAULT NULL COMMENT '扩展信息',
  `log_time` datetime NOT NULL COMMENT '记录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `xwb_weibo_delete`
--

DROP TABLE IF EXISTS `xwb_weibo_delete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_weibo_delete` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `weibo` text NOT NULL COMMENT '微博内容',
  `picid` varchar(100) DEFAULT NULL COMMENT '上传图片的id',
  `sina_uid` bigint(20) NOT NULL COMMENT '发微博的用户id',
  `nickname` varchar(45) DEFAULT NULL COMMENT '用户昵称',
  `retweeted_status` text COMMENT '转发微博内容',
  `retweeted_wid` bigint(20) DEFAULT NULL COMMENT '转发微博id',
  `access_token` varchar(50) NOT NULL,
  `token_secret` varchar(50) NOT NULL,
  `dateline` int(10) NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='微博审核删除表';


--
-- Table structure for table `xwb_weibo_verify`
--

DROP TABLE IF EXISTS `xwb_weibo_verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_weibo_verify` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `weibo` text NOT NULL COMMENT '微博内容',
  `cwid` varchar(50) DEFAULT NULL COMMENT '要评论的微博id',
  `picid` varchar(100) DEFAULT NULL COMMENT '上传图片的id',
  `sina_uid` bigint(20) NOT NULL COMMENT '发微博的用户id',
  `nickname` varchar(45) DEFAULT NULL COMMENT '用户昵称',
  `retweeted_status` text COMMENT '转发微博内容',
  `retweeted_wid` bigint(20) DEFAULT NULL COMMENT '转发微博id',
  `access_token` varchar(50) NOT NULL,
  `token_secret` varchar(50) NOT NULL,
  `type` varchar(20) DEFAULT NULL COMMENT '类型,"live"微直播',
  `extend_id` int(4) DEFAULT NULL COMMENT '扩展id',
  `extend_data` varchar(200) DEFAULT NULL COMMENT '扩展数据',
  `dateline` int(10) NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='微博审核表';


--
-- Table structure for table `xwb_admin_group`
--

DROP TABLE IF EXISTS `xwb_admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_admin_group` (
  `gid` int(11) NOT NULL,
  `group_name` varchar(45) DEFAULT NULL COMMENT '组名',
  `permissions` text COMMENT '权限',
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_admin_group`
--

/*!40000 ALTER TABLE `xwb_admin_group` DISABLE KEYS */;
INSERT INTO `xwb_admin_group` VALUES (1,'超級管理員','^mgr/',''),(2,'管理員','^((?!mgr/setting\\.|mgr/connection|mgr/admin\\.del|mgr/admin\\.userlist|mgr/admin.add|mgr/admin.search|mgr/backup\\.).)*$',''),(3,'運營維護','mgr/admin\\.login,mgr/admin\\.logout,mgr/admin\\.index,mgr/admin\\.map,mgr/admin\\.default_page,mgr/admin\\.repassword,mgr/weibo/disableComment,mgr/weibo/disableWeibo,mgr/weibo/keyword,mgr/weibo/weiboCopy,mgr/users\\.,mgr/user_verify\\.,mgr/celeb_mgr\\.,mgr/user_recommend\\.','');
/*!40000 ALTER TABLE `xwb_admin_group` ENABLE KEYS */;

ALTER TABLE `xwb_ad` ADD COLUMN `remarks` TEXT COMMENT '廣告使用方法描述';
/*!40000 ALTER TABLE `xwb_ad` DISABLE KEYS */;
INSERT INTO `xwb_ad` (`using`,`add_time`,`name`,`description`,`page`,`flag`,`remarks`) VALUES ('0','1306827698','頁尾廣告', '全站','global','global_footer','建議大小，兩欄800px *70px，三欄為960px*70px'),('0','1306894648','頁頭廣告','全站','global','global_header','建議大小，兩欄570px *70px，三欄為720px*70px'),('0','1306894660','右側banner','全站',' global','sidebar','建議大小，180px*任意高度');

ALTER TABLE `xwb_event_comment`  ADD COLUMN `weibo` TEXT CHARSET utf8 COLLATE utf8_general_ci NULL COMMENT '微博内容';

ALTER TABLE `xwb_micro_live_wb`  ADD COLUMN `weibo` TEXT CHARSET utf8 COLLATE utf8_general_ci NULL COMMENT '微博内容';

ALTER TABLE `xwb_interview_wb`  ADD COLUMN `weibo` TEXT CHARSET utf8 COLLATE utf8_general_ci NULL COMMENT '微博内容';

ALTER TABLE `xwb_interview_wb`  ADD COLUMN `answer_weibo` TEXT CHARSET utf8 COLLATE utf8_general_ci NULL COMMENT 'json結構的微博內容';

ALTER TABLE `xwb_interview_wb_atme`  ADD COLUMN `weibo` TEXT CHARSET utf8 COLLATE utf8_general_ci NULL COMMENT '微博内容';

ALTER TABLE `xwb_admin`  ADD COLUMN `group_id` int(11) DEFAULT NULL COMMENT '用户所属组';

ALTER TABLE `xwb_comment_copy`  ADD COLUMN `disabled` varchar(1) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '是否屏蔽';

ALTER TABLE `xwb_users`  ADD COLUMN `followers_count` int(11) unsigned DEFAULT NULL COMMENT '用户的粉丝数，每次登陆时更新';

ALTER TABLE `xwb_weibo_copy`  ADD COLUMN `pic` varchar(124) DEFAULT NULL COMMENT '图片url';

ALTER TABLE `xwb_feedback`  ADD COLUMN `ip` VARCHAR(16) DEFAULT NULL;