-- MySQL dump 10.13  Distrib 5.1.50, for Win32 (ia32)

--
-- Table structure for table `xwb_ad`
--

DROP TABLE IF EXISTS `xwb_ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COMMENT '广告内容',
  `using` varchar(1) DEFAULT '1' COMMENT '是否应用',
  `add_time` int(10) unsigned DEFAULT NULL COMMENT '添加时间',
  `name` varchar(45) DEFAULT NULL COMMENT '广告位名称',
  `description` text COMMENT '广告位描述',
  `page` varchar(45) DEFAULT NULL COMMENT '页面Action',
  `flag` varchar(45) DEFAULT NULL,
  `config` text COMMENT '广告配置',
  `width` int(11) DEFAULT '0' COMMENT '广告容器宽度',
  `height` int(11) DEFAULT '0' COMMENT '广告容器高度',
  PRIMARY KEY (`id`),
  KEY `index_using` (`using`,`page`,`flag`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='广告';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_ad`
--

/*!40000 ALTER TABLE `xwb_ad` DISABLE KEYS */;
INSERT INTO `xwb_ad` VALUES (1,'<script>\r\nPFP_CONF = {\r\n			\'partnerid\': 40602, // 联盟ID\r\n			\'siteid\': 3333, // 站点ID\r\n			\'blockid\': 2 // 广告位ID\r\n		};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://p4p.sina.com.cn/test/sina/pfp.js\"></script>','1',1294307785,'底部通栏广告','全站','global','global_bottom',NULL,0,0),(2,'<script>\r\nPFP_CONF = {\r\n			\'partnerid\': 40602, // 联盟ID\r\n			\'siteid\': 3333, // 站点ID\r\n			\'blockid\': 1 // 广告位ID\r\n		};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://p4p.sina.com.cn/test/sina/pfp.js\"></script>','1',1294307785,'对联广告(左)','全站','global','global_left','{\"topic_get\":\"2\"}',0,0),(3,'<script>\r\nPFP_CONF = {\r\n			\'partnerid\': 40602, // 联盟ID\r\n			\'siteid\': 3333, // 站点ID\r\n			\'blockid\': 6 // 广告位ID\r\n		};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://p4p.sina.com.cn/test/sina/pfp.js\"></script>','1',1294307785,'对联广告(右)','全站','global','global_right','{\"topic_get\":\"2\"}',0,0),(4,'<script>\r\nPFP_CONF = {\r\n			\'partnerid\': 40602, // 联盟ID\r\n			\'siteid\': 3333, // 站点ID\r\n			\'blockid\': 5 // 广告位ID\r\n		};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://p4p.sina.com.cn/test/sina/pfp.js\"></script>','1',1294307785,'侧栏广告','微博广场','pub','sidebar',NULL,0,0),(5,'<script>\r\nPFP_CONF = {\r\n			\'partnerid\': 40602, // 联盟ID\r\n			\'siteid\': 3333, // 站点ID\r\n			\'blockid\': 3 // 广告位ID\r\n		};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://p4p.sina.com.cn/test/sina/pfp.js\"></script>','0',1294307785,'今日话题广告','微博广场','pub','today_topic',NULL,0,0),(6,'<script>\r\nPFP_CONF = {\r\n			\'partnerid\': 40602, // 联盟ID\r\n			\'siteid\': 3333, // 站点ID\r\n			\'blockid\': 4 // 广告位ID\r\n		};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://p4p.sina.com.cn/test/sina/pfp.js\"></script>','1',1294307785,'发布框下广告','我的首页','index','publish',NULL,0,0),(7,'<script>\r\nPFP_CONF = {\r\n			\'partnerid\': 40602, // 联盟ID\r\n			\'siteid\': 3333, // 站点ID\r\n			\'blockid\': 5 // 广告位ID\r\n		};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://p4p.sina.com.cn/test/sina/pfp.js\"></script>','1',1294307785,'侧栏广告','我的首页','index','sidebar',NULL,0,0),(8,'<script>\r\nPFP_CONF = {\r\n			\'partnerid\': 40602, // 联盟ID\r\n			\'siteid\': 3333, // 站点ID\r\n			\'blockid\': 5 // 广告位ID\r\n		};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://p4p.sina.com.cn/test/sina/pfp.js\"></script>','1',1294307785,'侧栏广告','他的首页','ta','sidebar',NULL,0,0);
/*!40000 ALTER TABLE `xwb_ad` ENABLE KEYS */;

--
-- Table structure for table `xwb_admin`
--

DROP TABLE IF EXISTS `xwb_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用户ID',
  `pwd` varchar(32) DEFAULT NULL,
  `add_time` int(10) unsigned DEFAULT NULL COMMENT '加入的时间',
  `is_root` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否拥有帐号管理权限 1.拥有 0.不拥有',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员列表及密码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_admin`
--

/*!40000 ALTER TABLE `xwb_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_admin` ENABLE KEYS */;

--
-- Table structure for table `xwb_api_log`
--

DROP TABLE IF EXISTS `xwb_api_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_api_log` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_api_log`
--

/*!40000 ALTER TABLE `xwb_api_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_api_log` ENABLE KEYS */;

--
-- Table structure for table `xwb_celeb`
--

DROP TABLE IF EXISTS `xwb_celeb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_celeb` (
  `c_id1` int(11) DEFAULT NULL COMMENT '一级分类ID',
  `c_id2` int(11) DEFAULT NULL COMMENT '二级分类ID',
  `char_index` tinyint(2) DEFAULT NULL COMMENT '字母索引 1-26对应A-Z, 0为其它',
  `sina_uid` bigint(20) DEFAULT NULL COMMENT 'sina用户ID',
  `nick` varchar(100) DEFAULT NULL COMMENT 'sina用户昵称',
  `face` varchar(200) NOT NULL COMMENT '头像地址',
  `verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为官方认证用户 0.不是 1.是',
  `sort` int(11) DEFAULT NULL COMMENT '排序值，小的在前',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='名人堂推荐用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_celeb`
--

/*!40000 ALTER TABLE `xwb_celeb` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_celeb` ENABLE KEYS */;

--
-- Table structure for table `xwb_celeb_category`
--

DROP TABLE IF EXISTS `xwb_celeb_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_celeb_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL COMMENT '父ID,如果是0，则为一级分类',
  `name` varchar(50) DEFAULT NULL COMMENT '分类名称',
  `sort` int(11) DEFAULT NULL COMMENT '排序，数字小的在前',
  `add_time` int(11) DEFAULT NULL COMMENT '增加时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:启用',
  `recommended` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:推荐',
  `color` varchar(45) DEFAULT NULL COMMENT '二级导航的显示颜色',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='名人堂用户分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_celeb_category`
--

/*!40000 ALTER TABLE `xwb_celeb_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_celeb_category` ENABLE KEYS */;

--
-- Table structure for table `xwb_comment_copy`
--

DROP TABLE IF EXISTS `xwb_comment_copy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_comment_copy` (
  `cid` bigint(20) unsigned NOT NULL COMMENT '评论ID',
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '发评论者的新浪UID',
  `uid` bigint(20) DEFAULT NULL COMMENT '发评论的ID',
  `mid` bigint(20) unsigned NOT NULL COMMENT '微博ID',
  `m_uid` bigint(20) unsigned NOT NULL COMMENT '发微博的UID',
  `reply_cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论ID',
  `reply_uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复者的ID',
  `content` varchar(140) CHARACTER SET utf8 NOT NULL COMMENT '评论内容',
  `source` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '内容来源',
  `post_ip` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '发布者IP',
  `dateline` int(10) unsigned NOT NULL COMMENT '评论时间',
  `sina_nick` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT '发布者新浪的昵称',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC COMMENT='评论表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_comment_copy`
--

/*!40000 ALTER TABLE `xwb_comment_copy` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_comment_copy` ENABLE KEYS */;

--
-- Table structure for table `xwb_component_cfg`
--

DROP TABLE IF EXISTS `xwb_component_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_component_cfg` (
  `component_id` int(10) unsigned NOT NULL,
  `cfgName` varchar(30) NOT NULL COMMENT '参数名称',
  `cfgValue` varchar(255) DEFAULT NULL COMMENT '参数值',
  `desc` varchar(50) DEFAULT NULL COMMENT '配置项说明',
  PRIMARY KEY (`component_id`,`cfgName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='组件对应的配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_component_cfg`
--

/*!40000 ALTER TABLE `xwb_component_cfg` DISABLE KEYS */;
INSERT INTO `xwb_component_cfg` VALUES (1,'show_num','5','组件显示的微博数'),(2,'group_id','1','名人推荐用户组对应的用户列表ID'),(2,'show_num','3','显示的名人数'),(3,'show_num','9',NULL),(3,'group_id','2','推荐用户组使用的用户列表ID'),(4,'group_id','3','人气关注榜的数据来源，0 使用新浪API >0　对应的用户组'),(10,'show_num','10','今日话题显示的微博数'),(10,'group_id','1','今日话题使用的话题组'),(11,'groups','{\"1\":\"\\u660e\\u661f\",\"2\":\"\\u8349\\u6839\"}',NULL),(9,'show_num','4','随便看看'),(5,'list_id','54355137','list id'),(5,'show_num','4',NULL),(4,'show_num','5','人气关注榜挂件人数'),(6,'show_num','10',NULL),(6,'topic_id','0','0 使用新浪API取数据　> 0 对应的话题组ID'),(7,'show_num','9',NULL),(8,'show_num','3',NULL),(2,'topic_id','0','0 使用新浪API取数据　> 0 对应的话题组ID'),(10,'source','1','0 使用全局数据 >0 使用本站数据'),(9,'source','1','0 使用全局数据 >0 使用本站数据'),(1,'source','1','0 使用全局数据 >0 使用本站数据'),(8,'source','1','0 使用全局数据 >0 使用本站数据'),(12,'topic','微小说','话题微薄的默认话题'),(12,'show_num','6','显示微博数'),(12,'source','1','微博来源'),(17,'show_num','5','组件显示的微博数'),(17,'source','0','0 使用全局数据 >0 使用本站数据'),(18,'show_num','3',NULL);
/*!40000 ALTER TABLE `xwb_component_cfg` ENABLE KEYS */;

--
-- Table structure for table `xwb_component_topic`
--

DROP TABLE IF EXISTS `xwb_component_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_component_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL,
  `topic` varchar(50) NOT NULL COMMENT '话题',
  `date_time` int(10) unsigned NOT NULL COMMENT '生效时间或添加时间',
  `sort_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `ext1` varchar(45) DEFAULT NULL COMMENT '扩展字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='热门话题列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_component_topic`
--

/*!40000 ALTER TABLE `xwb_component_topic` DISABLE KEYS */;
INSERT INTO `xwb_component_topic` VALUES (26,2,'Xweibo',1303107194,0,'1303107120');
/*!40000 ALTER TABLE `xwb_component_topic` ENABLE KEYS */;

--
-- Table structure for table `xwb_component_topiclist`
--

DROP TABLE IF EXISTS `xwb_component_topiclist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_component_topiclist` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '话题ID',
  `topic_name` varchar(25) NOT NULL COMMENT '话题列表的名称',
  `native` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为内置话题，内置不能删除',
  `sort` varchar(1) NOT NULL DEFAULT '1' COMMENT '类别下的话题是否允许排序',
  `app_with` text,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '话题分组类型',
  PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_component_topiclist`
--

/*!40000 ALTER TABLE `xwb_component_topiclist` DISABLE KEYS */;
INSERT INTO `xwb_component_topiclist` VALUES (2,'今日话题',1,'0','2,5',2);
/*!40000 ALTER TABLE `xwb_component_topiclist` ENABLE KEYS */;

--
-- Table structure for table `xwb_component_usergroups`
--

DROP TABLE IF EXISTS `xwb_component_usergroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_component_usergroups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分组ID',
  `group_name` varchar(15) NOT NULL COMMENT '组名称',
  `native` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为内置列表 1:是 0:否',
  `related_id` varchar(50) DEFAULT NULL COMMENT '组件应用情况，即哪位ID的组件使用了，可为多个，逗号分隔',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分组类型，0:普通分组, 4:官方微博分组',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='推荐用户　的各个分组';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_component_usergroups`
--

/*!40000 ALTER TABLE `xwb_component_usergroups` DISABLE KEYS */;
INSERT INTO `xwb_component_usergroups` VALUES (3,'自动关注用户列表',1,'11:1,11:1',0),(83,'首次登陆引导关注',0,NULL,0);
/*!40000 ALTER TABLE `xwb_component_usergroups` ENABLE KEYS */;

--
-- Table structure for table `xwb_component_users`
--

DROP TABLE IF EXISTS `xwb_component_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_component_users` (
  `group_id` int(10) unsigned DEFAULT NULL COMMENT '唯一、自增的用户分组ID',
  `uid` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `nickname` varchar(20) DEFAULT NULL COMMENT '用户昵称',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户列表成员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_component_users`
--

/*!40000 ALTER TABLE `xwb_component_users` DISABLE KEYS */;
INSERT INTO `xwb_component_users` VALUES (1,1904178193,3,'微博开放平台','新浪微博API官方帐号',160),(2,1662047260,3,'SinaAppEngine','新浪SAE服务官方帐号',163),(83,1076590735,1,'Xweibo官方','xweibo官方微博',164),(2,1904178193,2,'微博开放平台','新浪微博API官方帐号',162),(2,1076590735,1,'Xweibo官方','新浪Xweibo官方帐号',161),(1,1076590735,1,'Xweibo官方','新浪Xweibo官方帐号',158),(1,1662047260,2,'SinaAppEngine','新浪SAE云服务平台官方帐号',159);
/*!40000 ALTER TABLE `xwb_component_users` ENABLE KEYS */;

--
-- Table structure for table `xwb_components`
--

DROP TABLE IF EXISTS `xwb_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_components` (
  `component_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一、自增ID',
  `name` varchar(20) NOT NULL COMMENT '组件名称',
  `title` varchar(45) DEFAULT NULL COMMENT '用于显示的名称',
  `type` tinyint(4) DEFAULT NULL COMMENT '组件类型　0表示一个页面只有一个，>0表示一个页面可以有多个',
  `native` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否为内置类型',
  `component_type` tinyint(4) NOT NULL COMMENT '组件类型 1: 页面主体 2: 侧边栏',
  `symbol` varchar(20) NOT NULL COMMENT '模块标识，程序中使用',
  `desc` varchar(255) DEFAULT NULL COMMENT '模块说明',
  `preview_img` varchar(255) DEFAULT NULL COMMENT '预览图片',
  `component_cty` varchar(16) DEFAULT NULL COMMENT '组件分类:array(''user'' => ''用户'', ''wb'' => ''微博'', ''topic'' => ''话题'', ''others'' => ''其它'')',
  PRIMARY KEY (`component_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='组件表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_components`
--

/*!40000 ALTER TABLE `xwb_components` DISABLE KEYS */;
INSERT INTO `xwb_components` VALUES (1,'热门转发与评论','热门转发与评论',0,1,1,'hotWb','当天转发最多的微博列表（倒序排列）',NULL,'wb'),(2,'用户组','用户组',2,1,1,'starRcm','一组用户的列表',NULL,'user'),(3,'推荐用户','推荐用户',3,1,2,'userRcm','指定某些用户的列表（右边栏）',NULL,'user'),(5,'自定义微博列表','自定义微博列表',5,1,1,'official','某些指定用户发布的微博列表',NULL,'wb'),(6,'话题推荐列表','话题推荐列表',6,1,2,'hotTopic','一组话题列表',NULL,'others'),(7,'可能感兴趣的人','可能感兴趣的人',0,1,2,'guessYouLike','根据当前用户的IP、个人资料推荐相关联的用户列表',NULL,'user'),(8,'同城微博','同城微博',0,1,1,'cityWb','根据当前用户的IP地址判断地区，并展示该地区用户的微博列表',NULL,'wb'),(9,'随便看看','随便看看',0,1,1,'looklook','一段特点时间内发布的（一般为最新）的微博列表，随机展现',NULL,'wb'),(10,'今日话题','今日话题',0,1,1,'todayTopic','自动获取与今日话题相关的微博消息。话题可以在“运营管理-话题推荐管理”中设置',NULL,'others'),(12,'话题微博','话题微博',12,1,1,'topicWb','当前设定话题的相关微博列表',NULL,'wb'),(15,'最新用户','最新用户',0,1,2,'newestWbUser','本站最新开通微博的用户列表',NULL,'user'),(14,'最新微博','最新微博',15,1,1,'newestWb','当前站点最新发布的微博列表',NULL,'wb'),(13,'专题banner图','专题banner图',13,1,1,'pageImg','在页面中添加一个宽度为560px的banner图片',NULL,'others'),(16,'微博发布框','微博发布框',0,1,1,'sendWb','微博发布框',NULL,'others'),(18,'活动列表','活动列表',0,1,2,'eventList','活动列表',NULL,'others'),(19,'本地关注榜','本地关注榜',0,1,2,'localFollowTop','本地关注榜',NULL,'user');
/*!40000 ALTER TABLE `xwb_components` ENABLE KEYS */;

--
-- Table structure for table `xwb_content_unit`
--

DROP TABLE IF EXISTS `xwb_content_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_content_unit` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(40) DEFAULT NULL COMMENT '输出单元的名称',
  `title` varchar(40) DEFAULT NULL COMMENT '输出单元的标题，暂时只用于群组微博',
  `width` int(4) DEFAULT NULL COMMENT '输出单元的宽度',
  `height` int(4) DEFAULT NULL COMMENT '输出单元的高度',
  `target` varchar(40) DEFAULT NULL COMMENT '输出单元内容的来源对象',
  `type` int(4) DEFAULT '1' COMMENT '输出单元的类型，默认是1.1是微博秀, 2是推荐用户列表, 3是互动话题，4是一键关注，5是群组微博',
  `skin` int(4) DEFAULT '1' COMMENT '输出单元的样式皮肤,默认是1',
  `colors` int(4) DEFAULT NULL COMMENT '输出单元的自定义样式',
  `show_title` tinyint(3) DEFAULT '1' COMMENT '是否显示标题,默认是1, 1是显示, 0是不显示',
  `show_border` tinyint(3) DEFAULT '1' COMMENT '是否显示边框,默认是1, 1是显示, 0是不显示',
  `show_logo` tinyint(3) DEFAULT '1' COMMENT '是否显示logo,默认是1, 1是显示, 0是不显示',
  `show_publish` tinyint(3) DEFAULT '0' COMMENT '是否显示发布框，默认是0, 1是显示，0是不显示',
  `auto_scroll` tinyint(3) DEFAULT '0' COMMENT '是否自动滚动，默认是0, 1是自动滚动，0不是自动滚动',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='内容输出单元';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_content_unit`
--

/*!40000 ALTER TABLE `xwb_content_unit` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_content_unit` ENABLE KEYS */;

--
-- Table structure for table `xwb_disable_items`
--

DROP TABLE IF EXISTS `xwb_disable_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_disable_items` (
  `kw_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一、自增ID',
  `type` tinyint(4) NOT NULL COMMENT '内容类型：１微博ID　２评论ID　３昵称　４内容',
  `item` varchar(45) NOT NULL COMMENT '屏蔽或禁止的ID或内容',
  `comment` varchar(60) NOT NULL COMMENT '相关显示内容',
  `admin_name` varchar(24) NOT NULL COMMENT '管理员操作时的昵称',
  `admin_id` int(10) unsigned NOT NULL COMMENT '管理员ID',
  `user` varchar(45) NOT NULL COMMENT '微博或评论的作者',
  `publish_time` varchar(20) NOT NULL COMMENT '微博或评论的发布时间yyyy-mm-dd hh:ii:ss格式字串',
  `add_time` int(10) unsigned NOT NULL COMMENT '加入时间',
  PRIMARY KEY (`kw_id`),
  UNIQUE KEY `Index_type_item` (`type`,`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='屏蔽或禁止的内容列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_disable_items`
--

/*!40000 ALTER TABLE `xwb_disable_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_disable_items` ENABLE KEYS */;

--
-- Table structure for table `xwb_event_comment`
--

DROP TABLE IF EXISTS `xwb_event_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_event_comment` (
  `event_id` int(4) unsigned NOT NULL COMMENT '活动id',
  `wb_id` bigint(20) NOT NULL COMMENT '微博id',
  `comment_time` int(10) DEFAULT NULL COMMENT '评论时间',
  PRIMARY KEY (`event_id`,`wb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 COMMENT='活动评论表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_event_comment`
--

/*!40000 ALTER TABLE `xwb_event_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_event_comment` ENABLE KEYS */;

--
-- Table structure for table `xwb_event_join`
--

DROP TABLE IF EXISTS `xwb_event_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_event_join` (
  `sina_uid` bigint(20) NOT NULL COMMENT 'SINA　UID',
  `event_id` int(11) NOT NULL COMMENT '活动ID',
  `contact` varchar(200) DEFAULT NULL COMMENT '联系方式',
  `notes` text COMMENT '备注',
  `join_time` int(11) DEFAULT NULL COMMENT '参与时间',
  PRIMARY KEY (`sina_uid`,`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='活动参与表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_event_join`
--

/*!40000 ALTER TABLE `xwb_event_join` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_event_join` ENABLE KEYS */;

--
-- Table structure for table `xwb_events`
--

DROP TABLE IF EXISTS `xwb_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `addr` varchar(200) DEFAULT NULL COMMENT '地址',
  `desc` text COMMENT '简介',
  `cost` float DEFAULT NULL COMMENT '费用',
  `sina_uid` bigint(20) DEFAULT NULL COMMENT '发起人ID',
  `nickname` varchar(25) NOT NULL COMMENT '发起人昵称',
  `realname` varchar(25) DEFAULT NULL COMMENT '真实姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `start_time` int(11) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `pic` varchar(200) DEFAULT NULL COMMENT '图片',
  `wb_id` bigint(20) DEFAULT NULL COMMENT '微博ID',
  `join_num` int(11) DEFAULT NULL COMMENT '参与人数',
  `view_num` int(11) DEFAULT NULL COMMENT '查看次数',
  `comment_num` int(11) DEFAULT NULL COMMENT '评论数',
  `state` tinyint(2) DEFAULT '1' COMMENT '活动状态：1正常，2用户关闭，3，管理员封禁，4是推荐',
  `other` tinyint(2) DEFAULT '1' COMMENT '是否要求参加填写联系方式和备注：1是不用，2是要求',
  `modify_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `add_time` int(11) DEFAULT NULL COMMENT '发起时间',
  `add_ip` varchar(30) DEFAULT NULL COMMENT '发起人所在地IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='活动主表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_events`
--

/*!40000 ALTER TABLE `xwb_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_events` ENABLE KEYS */;

--
-- Table structure for table `xwb_feedback`
--

DROP TABLE IF EXISTS `xwb_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `uid` bigint(20) DEFAULT NULL,
  `nickname` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `qq` varchar(45) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_feedback`
--

/*!40000 ALTER TABLE `xwb_feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_feedback` ENABLE KEYS */;

--
-- Table structure for table `xwb_interview_wb`
--

DROP TABLE IF EXISTS `xwb_interview_wb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_interview_wb` (
  `ask_id` bigint(20) unsigned NOT NULL COMMENT '提问微博ID',
  `answer_wb` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '第一条回答的微博ID;如果是点评的,ask_id=answer_wb',
  `interview_id` int(10) unsigned NOT NULL COMMENT '在线访谈节目标识',
  `state` char(1) NOT NULL COMMENT 'P:待审;A:审核通过;删除为物理删除;主持人和嘉宾的微博不需要审核',
  `ask_uid` bigint(20) unsigned NOT NULL COMMENT '提问者uid',
  `answer_uid` bigint(20) unsigned DEFAULT NULL COMMENT '第一个回答者uid',
  PRIMARY KEY (`ask_id`),
  KEY `interview_index` (`interview_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='在线访谈内容';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_interview_wb`
--

/*!40000 ALTER TABLE `xwb_interview_wb` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_interview_wb` ENABLE KEYS */;

--
-- Table structure for table `xwb_interview_wb_atme`
--

DROP TABLE IF EXISTS `xwb_interview_wb_atme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_interview_wb_atme` (
  `interview_id` int(10) NOT NULL COMMENT '在线访谈节目ID',
  `ask_id` bigint(20) NOT NULL COMMENT '用户提问微博ID',
  `at_uid` bigint(20) NOT NULL COMMENT '提问嘉宾UID',
  `answer_wb` bigint(20) NOT NULL DEFAULT '0' COMMENT '回答的微博ID',
  PRIMARY KEY (`interview_id`,`ask_id`,`at_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存在线访谈嘉宾被提问的问题';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_interview_wb_atme`
--

/*!40000 ALTER TABLE `xwb_interview_wb_atme` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_interview_wb_atme` ENABLE KEYS */;

--
-- Table structure for table `xwb_item_groups`
--

DROP TABLE IF EXISTS `xwb_item_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_item_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL COMMENT '分组ID 已定义的，1：分类用户推荐 2：引导关注类别',
  `item_id` int(11) NOT NULL COMMENT '分组对象的ID',
  `item_name` varchar(25) DEFAULT NULL COMMENT '分组名称',
  `sort_num` int(11) DEFAULT '0' COMMENT '排序ID，通常用于组内',
  PRIMARY KEY (`id`),
  KEY `group_idx` (`group_id`,`sort_num`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用于存储ID分组列表，如用户分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_item_groups`
--

/*!40000 ALTER TABLE `xwb_item_groups` DISABLE KEYS */;
INSERT INTO `xwb_item_groups` VALUES (1,2,83,'首次登陆引导关注',0);
/*!40000 ALTER TABLE `xwb_item_groups` ENABLE KEYS */;

--
-- Table structure for table `xwb_keep_userdomain`
--

DROP TABLE IF EXISTS `xwb_keep_userdomain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_keep_userdomain` (
  `keep_domain` varchar(45) NOT NULL,
  PRIMARY KEY (`keep_domain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保留一些个性域名';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_keep_userdomain`
--

/*!40000 ALTER TABLE `xwb_keep_userdomain` DISABLE KEYS */;
INSERT INTO `xwb_keep_userdomain` VALUES ('application'),('flash'),('html_demo'),('install'),('readme'),('sae_install'),('templates');
/*!40000 ALTER TABLE `xwb_keep_userdomain` ENABLE KEYS */;

--
-- Table structure for table `xwb_micro_interview`
--

DROP TABLE IF EXISTS `xwb_micro_interview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_micro_interview` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '标识',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `desc` text NOT NULL COMMENT '说明',
  `banner_img` varchar(200) NOT NULL COMMENT 'Banner图片',
  `cover_img` varchar(200) NOT NULL COMMENT '封面图片',
  `state` char(1) NOT NULL DEFAULT 'N' COMMENT '默认N;X:已删;',
  `wb_state` char(1) NOT NULL DEFAULT 'A' COMMENT 'P:先审后发;A:直接发布',
  `master` varchar(200) DEFAULT NULL COMMENT '主持人新浪uid列表，json结构保存',
  `guest` text COMMENT '嘉宾新浪uid列表，json结构保存',
  `backgroup_img` varchar(200) DEFAULT NULL COMMENT '背景图片',
  `backgroup_color` varchar(20) DEFAULT NULL COMMENT '外观颜色',
  `start_time` int(11) NOT NULL COMMENT '开始时间',
  `end_time` int(11) NOT NULL COMMENT '结束时间',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `backgroup_style` tinyint(2) unsigned DEFAULT NULL COMMENT '背景图方式,默认是1,1是平铺，2是居中',
  `custom_color` varchar(20) DEFAULT NULL COMMENT '自定义颜色',
  `notice_time` int(10) unsigned DEFAULT NULL COMMENT '提醒时间，以秒为单位',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Xweibo在线访谈';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_micro_interview`
--

/*!40000 ALTER TABLE `xwb_micro_interview` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_micro_interview` ENABLE KEYS */;

--
-- Table structure for table `xwb_micro_live`
--

DROP TABLE IF EXISTS `xwb_micro_live`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_micro_live` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `trends` varchar(200) NOT NULL COMMENT '微直播的话题',
  `desc` text NOT NULL COMMENT '简介',
  `code` text COMMENT '直播视频代码',
  `start_time` int(11) NOT NULL COMMENT '开始时间',
  `end_time` int(11) NOT NULL COMMENT '结束时间',
  `master` varchar(200) NOT NULL COMMENT '主持人，json格式保存',
  `guest` text NOT NULL COMMENT '嘉宾，json格式保存',
  `banner_img` varchar(200) DEFAULT NULL COMMENT '微直播的banner',
  `cover_img` varchar(200) DEFAULT NULL COMMENT '封面图',
  `backgroup_img` varchar(200) DEFAULT NULL COMMENT '背景图',
  `backgroup_style` tinyint(2) DEFAULT NULL COMMENT '背景图方式，默认是1，1是平铺，2是居中',
  `backgroup_color` varchar(20) DEFAULT NULL COMMENT '外观样式',
  `custom_color` varchar(20) DEFAULT NULL COMMENT '自定义颜色',
  `state` char(1) NOT NULL DEFAULT 'N' COMMENT '默认N，X:已删',
  `wb_state` char(1) NOT NULL DEFAULT 'A' COMMENT 'P:先审后发;A:直接发布',
  `notice_time` int(11) DEFAULT NULL COMMENT '提醒时间',
  `add_time` int(11) DEFAULT NULL COMMENT '发起时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='微主播';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_micro_live`
--

/*!40000 ALTER TABLE `xwb_micro_live` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_micro_live` ENABLE KEYS */;

--
-- Table structure for table `xwb_micro_live_wb`
--

DROP TABLE IF EXISTS `xwb_micro_live_wb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_micro_live_wb` (
  `live_id` int(4) NOT NULL COMMENT '微直播的id',
  `wb_id` bigint(20) NOT NULL COMMENT '微博id',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '发微博人的类型，默认是1，1是网友，2是主持人，3是嘉宾',
  `state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '微博状态，默认是1，1是正常，2是未审核，3是通过审核',
  `add_time` int(11) DEFAULT NULL COMMENT '发布微博时间',
  PRIMARY KEY (`live_id`,`wb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_micro_live_wb`
--

/*!40000 ALTER TABLE `xwb_micro_live_wb` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_micro_live_wb` ENABLE KEYS */;

--
-- Table structure for table `xwb_nav`
--

DROP TABLE IF EXISTS `xwb_nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `in_use` tinyint(1) unsigned DEFAULT '1',
  `sort_num` tinyint(4) unsigned DEFAULT NULL,
  `page_id` int(10) DEFAULT '0',
  `is_blank` tinyint(1) unsigned DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL,
  `isNative` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0:自定义;1:系统预设',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='页面导航栏';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_nav`
--

/*!40000 ALTER TABLE `xwb_nav` DISABLE KEYS */;
INSERT INTO `xwb_nav` VALUES (132,'活动',0,1,100,35,0,'',2,0),(130,'微博广场',0,1,0,1,0,'',2,0),(131,'名人堂',0,1,0,3,0,'',2,0),(21,'我的首页',0,1,50,2,1,'',2,1);
/*!40000 ALTER TABLE `xwb_nav` ENABLE KEYS */;

--
-- Table structure for table `xwb_notice`
--

DROP TABLE IF EXISTS `xwb_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_notice` (
  `notice_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '通知ID',
  `sender_id` bigint(20) DEFAULT '0' COMMENT '发送者的sina_uid，默认为0，表示系统发送',
  `title` varchar(100) DEFAULT NULL COMMENT '通知标题',
  `content` text COMMENT '通知内容',
  `add_time` int(11) DEFAULT NULL COMMENT '发布时间',
  `available_time` int(11) DEFAULT NULL COMMENT '生效时间',
  PRIMARY KEY (`notice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='通知内容表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_notice`
--

/*!40000 ALTER TABLE `xwb_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_notice` ENABLE KEYS */;

--
-- Table structure for table `xwb_notice_recipients`
--

DROP TABLE IF EXISTS `xwb_notice_recipients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_notice_recipients` (
  `kid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `notice_id` bigint(20) unsigned NOT NULL COMMENT '消息ID',
  `recipient_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '接收者的sina_uid，为0表示全站用户',
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_bin CHECKSUM=1 DELAY_KEY_WRITE=1 COMMENT='消息接收者记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_notice_recipients`
--

/*!40000 ALTER TABLE `xwb_notice_recipients` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_notice_recipients` ENABLE KEYS */;

--
-- Table structure for table `xwb_page_manager`
--

DROP TABLE IF EXISTS `xwb_page_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_page_manager` (
  `page_id` int(11) NOT NULL COMMENT '预定义的页面ID：如１：广场。。',
  `component_id` int(11) DEFAULT NULL COMMENT '使用到的组件ID',
  `title` varchar(45) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0' COMMENT '摆放的位置 1:左边　２：右侧栏',
  `sort_num` int(11) DEFAULT '0' COMMENT '摆放的顺序',
  `in_use` tinyint(1) DEFAULT '1' COMMENT '是否使用',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isNative` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:系统自带，不能删除  0:用户添加，可以删除',
  `param` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=367 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='页面设置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_page_manager`
--

/*!40000 ALTER TABLE `xwb_page_manager` DISABLE KEYS */;
INSERT INTO `xwb_page_manager` VALUES (1,10,'今日话题',1,1,1,1,0,'{\"show_num\":\"10\",\"source\":\"0\",\"topic\":\"Xweibo\"}'),(1,14,'本站最新微博',1,3,1,363,0,'{\"show_num\":\"10\"}'),(1,7,'可能感兴趣的人',2,2,1,364,0,'{\"show_num\":\"3\"}'),(2,7,'可能感兴趣的人',2,2,1,11,0,'{\"show_num\":\"10\"}'),(45,13,'随便看看banner图',1,1,1,357,0,'{\"link\":\"\",\"src\":\"\\/var\\/upload\\/pic\\/component_img_1303108721.png\",\"width\":\"560\",\"height\":\"\"}'),(45,14,'本站最新微博',1,2,1,356,0,'{\"show_num\":\"20\"}'),(44,13,'banner图',1,1,1,355,0,'{\"link\":\"http:\\/\\/\",\"src\":\"\\/var\\/upload\\/pic\\/component_img_1303108508.png\",\"width\":\"560\",\"height\":\"\"}'),(44,8,'同城微博',1,2,1,353,0,'{\"source\":\"0\",\"page_type\":\"1\",\"show_num\":\"15\"}'),(44,19,'本地关注榜',2,2,1,354,0,'{\"show_num\":\"6\"}'),(47,5,'自定义集体微博',1,2,1,361,0,'{\"list_id\":\"0\",\"page_type\":\"1\",\"show_num\":\"15\"}'),(46,13,'自定义话题Banner',1,1,1,359,0,'{\"link\":\"\",\"src\":\"\\/var\\/upload\\/pic\\/component_img_1303109588.png\",\"width\":\"560\",\"height\":\"\"}'),(47,13,'自定义集体微博',1,1,1,360,0,'{\"link\":\"\",\"src\":\"\\/var\\/upload\\/pic\\/component_img_1303110458.png\",\"width\":\"560\",\"height\":\"\"}'),(46,12,'自定义话题微博列表',1,2,1,358,0,'{\"topic\":\"xweibo\",\"source\":\"0\",\"page_type\":\"1\",\"show_num\":\"15\"}'),(1,12,'大家都在聊',1,2,1,366,0,'{\"topic\":\"\\u5fae\\u535a\",\"source\":\"0\",\"page_type\":\"0\",\"show_num\":\"10\"}');
/*!40000 ALTER TABLE `xwb_page_manager` ENABLE KEYS */;

--
-- Table structure for table `xwb_page_prototype`
--

DROP TABLE IF EXISTS `xwb_page_prototype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_page_prototype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `type` int(10) unsigned NOT NULL DEFAULT '2',
  `components` text,
  `url` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='页面原型';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_page_prototype`
--

/*!40000 ALTER TABLE `xwb_page_prototype` DISABLE KEYS */;
INSERT INTO `xwb_page_prototype` VALUES (2,'自定义页面','自定义页面原型',2,'','custom'),(1,'自定义页面','自定义页面原型',1,'','custom');
/*!40000 ALTER TABLE `xwb_page_prototype` ENABLE KEYS */;

--
-- Table structure for table `xwb_pages`
--

DROP TABLE IF EXISTS `xwb_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_pages` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '页面id',
  `page_name` varchar(20) DEFAULT NULL COMMENT '页面名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '页面描述',
  `native` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为内置页',
  `url` varchar(45) DEFAULT NULL,
  `prototype_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_pages`
--

/*!40000 ALTER TABLE `xwb_pages` DISABLE KEYS */;
INSERT INTO `xwb_pages` VALUES (1,'微博广场','“微博广场”是用户免登录即可查看的页面，包含了今日话题、随便看看等组件。',1,'pub',NULL),(2,'我的首页','“我的首页”是登录用户操作微博的页面，包含了猜你喜欢、推荐话题等组件。',1,'index',NULL),(3,'名人堂','名人堂',1,'celeb',NULL),(4,'我的微博','我的微博',1,'index.profile',NULL),(35,'活动首页','活动列表页，包括最新活动和推荐活动',1,'event',NULL),(6,'话题排行榜','话题排行榜',1,'pub.topics',NULL),(37,'我的收藏','我的收藏',1,'index.favorites',2),(7,'在线直播','在线直播扩展工具',1,'live',NULL),(8,'在线访谈','在线访谈扩展工具',1,'interview',NULL);
/*!40000 ALTER TABLE `xwb_pages` ENABLE KEYS */;

--
-- Table structure for table `xwb_plugins`
--

DROP TABLE IF EXISTS `xwb_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_plugins` (
  `plugin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL COMMENT '名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '简介',
  `in_use` tinyint(1) DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`plugin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_plugins`
--

/*!40000 ALTER TABLE `xwb_plugins` DISABLE KEYS */;
INSERT INTO `xwb_plugins` VALUES (2,'用户首页聚焦位','开启该插件会将站长设定的内容以图文的形式显示于用户首页中。',1),(3,'个人资料推广位','开启该插件会将站长设定的内容以文字链接的形式显示于用户的个人信息的下方。',1),(4,'登录后引导关注','开启该插件后，用户首次登陆会强制关注指定的用户并且引导用户其它推荐用户。',1),(5,'用户反馈意见','左导航会出现一个意见反馈通道',1),(6,'数据本地备份','本站备份一份微博数据',1);
/*!40000 ALTER TABLE `xwb_plugins` ENABLE KEYS */;

--
-- Table structure for table `xwb_profile_ad`
--

DROP TABLE IF EXISTS `xwb_profile_ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_profile_ad` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '标题',
  `link` varchar(255) NOT NULL COMMENT '链接',
  `add_time` int(11) DEFAULT NULL COMMENT '添加的时间',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='个人信息推广位的广告';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_profile_ad`
--

/*!40000 ALTER TABLE `xwb_profile_ad` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_profile_ad` ENABLE KEYS */;

--
-- Table structure for table `xwb_sessions`
--

DROP TABLE IF EXISTS `xwb_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_sessions` (
  `sesskey` char(32) NOT NULL,
  `expiry` int(11) unsigned NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`sesskey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_sessions`
--

/*!40000 ALTER TABLE `xwb_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_sessions` ENABLE KEYS */;

--
-- Table structure for table `xwb_skin_groups`
--

DROP TABLE IF EXISTS `xwb_skin_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_skin_groups` (
  `style_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模板分类ID',
  `style_name` varchar(15) NOT NULL COMMENT '分类名称',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '显示排序',
  PRIMARY KEY (`style_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='皮肤类别表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_skin_groups`
--

/*!40000 ALTER TABLE `xwb_skin_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_skin_groups` ENABLE KEYS */;

--
-- Table structure for table `xwb_skins`
--

DROP TABLE IF EXISTS `xwb_skins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_skins` (
  `skin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模板ID',
  `name` varchar(45) DEFAULT NULL COMMENT '文件名名称',
  `directory` varchar(45) NOT NULL COMMENT '所在的目录',
  `desc` varchar(255) DEFAULT NULL COMMENT '模板说明',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '模板状态　０正常（启用）　１禁用　２文件不存在（不可用）',
  `style_id` int(11) NOT NULL DEFAULT '0' COMMENT '模板分类ID',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '显示排序',
  PRIMARY KEY (`skin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='模板列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_skins`
--

/*!40000 ALTER TABLE `xwb_skins` DISABLE KEYS */;
INSERT INTO `xwb_skins` VALUES (1,'经典','skin_default','',0,0,1),(2,'沙滩','skin_beach','',0,0,4),(3,'墨绿','skin_blackgreen','',0,0,1),(4,'蓝色','skin_blue','',0,0,2),(5,'魅紫','skin_charmpurple','',0,0,3),(6,'风景','skin_landscape','',0,0,5),(7,'荷花','skin_lotus','',0,0,6),(8,'节日','skin_newyear','',0,0,7),(9,'冬雪','skin_snow','',0,0,8),(10,'科技','skin_tech','',0,0,9),(11,'旅行','skin_tour','',0,0,10);
/*!40000 ALTER TABLE `xwb_skins` ENABLE KEYS */;

--
-- Table structure for table `xwb_subject`
--

DROP TABLE IF EXISTS `xwb_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sina_uid` bigint(20) NOT NULL COMMENT 'sina id',
  `subject` varchar(100) NOT NULL DEFAULT '' COMMENT '话题名称',
  `is_use` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用，默认启用，如果用户删除该话题订阅，只进行软删除',
  PRIMARY KEY (`id`),
  KEY `sina_uid` (`sina_uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户话题收藏记录表，如果用户取消收藏，使用is_use来标记，不删除。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_subject`
--

/*!40000 ALTER TABLE `xwb_subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_subject` ENABLE KEYS */;

--
-- Table structure for table `xwb_sys_config`
--

DROP TABLE IF EXISTS `xwb_sys_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_sys_config` (
  `key` varchar(40) NOT NULL,
  `value` text,
  `group_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '配置的分组ID',
  PRIMARY KEY (`key`,`group_id`),
  KEY `idx_groupid` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统配置信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_sys_config`
--

/*!40000 ALTER TABLE `xwb_sys_config` DISABLE KEYS */;
INSERT INTO `xwb_sys_config` VALUES ('rewrite_enable','0',1),('logo','',1),('login_way','1',1),('third_code','',1),('site_record','',1),('address_icon','',1),('head_link','{\"1\":{\"link_name\":\"\\u65b0\\u6d6a\\u5fae\\u535a\",\"link_address\":\"http:\\/\\/weibo.com\\/\"},\"3\":{\"link_name\":\"\\u65b0\\u6d6a\\u7f51\",\"link_address\":\"http:\\/\\/www.sina.com.cn\"}}',1),('foot_link','{\"3\":{\"link_name\":\"\\u5e2e\\u52a9\\u4e2d\\u5fc3\",\"link_address\":\"http:\\/\\/x.weibo.com\\/help.php\"}}',1),('authen_type','3',1),('authen_big_icon','img/logo/big_auth_icon.png',1),('authen_small_icon','img/logo/small_auth_icon.png',1),('skin_default','1',1),('ad_header','',1),('guide_auto_follow','',1),('ad_footer','',1),('title','Xweibo 2.0',2),('text','新版Xweibo2.0更新了大量功能，在原有体系基础上，提供了丰富的运营手段，帮助广大站长利用新浪微博的平台，架设属于自己网站的微博系统。',2),('bg_pic','',2),('oper','2',2),('topic','',2),('link','http://x.weibo.com',2),('btnTitle','了解更多',2),('guide_auto_follow_id','3',1),('authen_small_icon_title','我的站点认证',1),('ad_setting','',1),('microInterview_setting','',1),('wb_page_type','2',1),('wb_header_model','1',1),('wb_header_htmlcode','',1),('api_checking','',1),('xwb_discuz_url','',1),('xwb_discuz_enable','',1),('use_person_domain','0',1),('site_short_link','',1),('microLive_setting','',1),('default_use_custom','0',1),('open_user_local_relationship','0',1);
/*!40000 ALTER TABLE `xwb_sys_config` ENABLE KEYS */;

--
-- Table structure for table `xwb_today_topics`
--

DROP TABLE IF EXISTS `xwb_today_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_today_topics` (
  `group_id` int(10) unsigned NOT NULL COMMENT '话题分组ID',
  `topic` varchar(45) NOT NULL COMMENT '话题内容',
  `effect_time` int(10) unsigned NOT NULL COMMENT '生效时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='今日话题的内容';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_today_topics`
--

/*!40000 ALTER TABLE `xwb_today_topics` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_today_topics` ENABLE KEYS */;

--
-- Table structure for table `xwb_user_action`
--

DROP TABLE IF EXISTS `xwb_user_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_user_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sina_uid` bigint(20) NOT NULL,
  `action_type` smallint(6) NOT NULL COMMENT '1、禁言 2、禁止用户登录、3、清除用户信息（不删除、仅是在任何情况不显示） 4、恢复正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_user_action`
--

/*!40000 ALTER TABLE `xwb_user_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_user_action` ENABLE KEYS */;

--
-- Table structure for table `xwb_user_ban`
--

DROP TABLE IF EXISTS `xwb_user_ban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_user_ban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用户ID',
  `ban_time` int(11) DEFAULT NULL COMMENT '封禁时间',
  `nick` varchar(20) DEFAULT NULL COMMENT '封禁用户的昵称',
  PRIMARY KEY (`id`),
  KEY `nick` (`nick`),
  KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='封禁用户列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_user_ban`
--

/*!40000 ALTER TABLE `xwb_user_ban` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_user_ban` ENABLE KEYS */;

--
-- Table structure for table `xwb_user_config`
--

DROP TABLE IF EXISTS `xwb_user_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_user_config` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `sina_uid` bigint(20) unsigned NOT NULL,
  `values` varchar(510) NOT NULL DEFAULT '0' COMMENT '用户自定义的配置',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户自定义配置的信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_user_config`
--

/*!40000 ALTER TABLE `xwb_user_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_user_config` ENABLE KEYS */;

--
-- Table structure for table `xwb_user_focus`
--

DROP TABLE IF EXISTS `xwb_user_focus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_user_focus` (
  `id` int(10) NOT NULL,
  `sina_uid` bigint(20) NOT NULL,
  `topic` varchar(45) NOT NULL,
  `source` tinyint(1) DEFAULT NULL,
  `add_time` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_focus_uid_index` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存用户关注的话题';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_user_focus`
--

/*!40000 ALTER TABLE `xwb_user_focus` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_user_focus` ENABLE KEYS */;

--
-- Table structure for table `xwb_user_follow`
--

DROP TABLE IF EXISTS `xwb_user_follow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_user_follow` (
  `friend_uid` bigint(20) NOT NULL COMMENT '被关注用户ID',
  `fans_uid` bigint(20) NOT NULL COMMENT '粉丝用户ID',
  `datetime` int(10) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`friend_uid`,`fans_uid`),
  KEY `datetime_idx` (`datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关注表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_user_follow`
--

/*!40000 ALTER TABLE `xwb_user_follow` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_user_follow` ENABLE KEYS */;

--
-- Table structure for table `xwb_user_follow_copy`
--

DROP TABLE IF EXISTS `xwb_user_follow_copy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_user_follow_copy` (
  `friend_uid` bigint(20) NOT NULL COMMENT '被关注用户ID',
  `fans_uid` bigint(20) NOT NULL COMMENT '粉丝用户ID',
  `datetime` int(10) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`friend_uid`,`fans_uid`),
  KEY `datetime_idx` (`datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关注表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_user_follow_copy`
--

/*!40000 ALTER TABLE `xwb_user_follow_copy` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_user_follow_copy` ENABLE KEYS */;

--
-- Table structure for table `xwb_user_verify`
--

DROP TABLE IF EXISTS `xwb_user_verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_user_verify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用户ID',
  `nick` varchar(45) NOT NULL COMMENT '要加V的用户',
  `reason` varchar(50) DEFAULT NULL COMMENT '认证理由',
  `add_time` int(10) unsigned DEFAULT NULL COMMENT '添加认证时间',
  `operator` bigint(20) NOT NULL COMMENT '操作者的ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_nick` (`nick`),
  KEY `index_add_time` (`add_time`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='要加V的用户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_user_verify`
--

/*!40000 ALTER TABLE `xwb_user_verify` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_user_verify` ENABLE KEYS */;

--
-- Table structure for table `xwb_users`
--

DROP TABLE IF EXISTS `xwb_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用户ID',
  `nickname` varchar(25) NOT NULL COMMENT '昵称',
  `first_login` int(10) unsigned DEFAULT NULL COMMENT '首次登陆时间',
  `access_token` varchar(50) DEFAULT NULL COMMENT '授权后得到访问API的token',
  `token_secret` varchar(50) DEFAULT NULL COMMENT 'API服务器生成的加密串',
  `uid` bigint(20) DEFAULT NULL COMMENT '所捆绑的合作方的用户ID',
  `domain_name` varchar(45) DEFAULT NULL COMMENT '用户设置的个性化域名',
  `max_notice_time` int(11) DEFAULT '0' COMMENT '用户最后一次阅读的起效的最新通知的时间戳',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sina_uid` (`sina_uid`),
  KEY `nickname` (`nickname`),
  KEY `site_uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户表---所有登录过的用户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_users`
--

/*!40000 ALTER TABLE `xwb_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_users` ENABLE KEYS */;

--
-- Table structure for table `xwb_weibo_copy`
--

DROP TABLE IF EXISTS `xwb_weibo_copy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_weibo_copy` (
  `id` bigint(20) unsigned NOT NULL COMMENT '微博id',
  `weibo` tinytext COMMENT '微博内容',
  `uid` bigint(20) unsigned DEFAULT NULL,
  `nickname` varchar(45) DEFAULT NULL COMMENT '作者',
  `addtime` int(11) DEFAULT NULL COMMENT '发布时间',
  `disabled` varchar(1) DEFAULT NULL COMMENT '是否被屏蔽',
  PRIMARY KEY (`id`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_weibo_copy`
--

/*!40000 ALTER TABLE `xwb_weibo_copy` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_weibo_copy` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-04-29 11:27:11
