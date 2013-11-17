-- MySQL dump 10.13  Distrib 5.1.50, for Win32 (ia32)

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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_account_proxy`
--

/*!40000 ALTER TABLE `xwb_account_proxy` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_account_proxy` ENABLE KEYS */;

--
-- Table structure for table `xwb_ad`
--

DROP TABLE IF EXISTS `xwb_ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COMMENT '廣告內容',
  `using` varchar(1) DEFAULT '1' COMMENT '是否應用',
  `add_time` int(10) unsigned DEFAULT NULL COMMENT '添加時間',
  `name` varchar(45) DEFAULT NULL COMMENT '廣告位名稱',
  `description` text COMMENT '廣告位描述',
  `page` varchar(45) DEFAULT NULL COMMENT '頁面Action',
  `flag` varchar(45) DEFAULT NULL,
  `config` text COMMENT '廣告配置',
  `width` int(11) DEFAULT '0' COMMENT '廣告容器寬度',
  `height` int(11) DEFAULT '0' COMMENT '廣告容器高度',
  PRIMARY KEY (`id`),
  KEY `index_using` (`using`,`page`,`flag`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='廣告';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_ad`
--

/*!40000 ALTER TABLE `xwb_ad` DISABLE KEYS */;
INSERT INTO `xwb_ad` VALUES (1,'','0',1306827698,'頁尾廣告','全站','global','global_footer','',0,0),(2,'','0',1306894648,'頁頭廣告','全站','global','global_header','',0,0),(3,'','0',1306894660,'右側banner','全站','global','sidebar','',0,0);
/*!40000 ALTER TABLE `xwb_ad` ENABLE KEYS */;

--
-- Table structure for table `xwb_admin`
--

DROP TABLE IF EXISTS `xwb_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用戶ID',
  `pwd` varchar(32) DEFAULT NULL,
  `add_time` int(10) unsigned DEFAULT NULL COMMENT '加入的時間',
  `is_root` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否擁有帳號管理許可權 1.擁有 0.不擁有',
  `group_id` int(11) DEFAULT NULL COMMENT '用戶所屬組',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理員清單及密碼';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_admin`
--

/*!40000 ALTER TABLE `xwb_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_admin` ENABLE KEYS */;

--
-- Table structure for table `xwb_admin_group`
--

DROP TABLE IF EXISTS `xwb_admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_admin_group` (
  `gid` int(11) NOT NULL,
  `group_name` varchar(45) DEFAULT NULL COMMENT '組名',
  `permissions` text COMMENT '許可權',
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

--
-- Table structure for table `xwb_celeb`
--

DROP TABLE IF EXISTS `xwb_celeb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_celeb` (
  `c_id1` int(11) DEFAULT NULL COMMENT '一級分類ID',
  `c_id2` int(11) DEFAULT NULL COMMENT '二級分類ID',
  `char_index` tinyint(2) DEFAULT NULL COMMENT '字母索引 1-26對應A-Z, 0為其它',
  `sina_uid` bigint(20) DEFAULT NULL COMMENT 'sina用戶ID',
  `nick` varchar(100) DEFAULT NULL COMMENT 'sina用戶昵稱',
  `face` varchar(200) NOT NULL COMMENT '頭像地址',
  `verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否為官方認證用戶 0.不是 1.是',
  `sort` int(11) DEFAULT NULL COMMENT '排序值，小的在前',
  `add_time` int(11) DEFAULT NULL COMMENT '添加時間',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='名人堂推薦用戶表';
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
  `parent_id` int(11) DEFAULT NULL COMMENT '父ID,如果是0，則為一級分類',
  `name` varchar(50) DEFAULT NULL COMMENT '分類名稱',
  `sort` int(11) DEFAULT NULL COMMENT '排序，數字小的在前',
  `add_time` int(11) DEFAULT NULL COMMENT '增加時間',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:啟用',
  `recommended` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:推薦',
  `color` varchar(45) DEFAULT NULL COMMENT '二級導航的顯示顏色',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='名人堂用戶分類';
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
  `cid` bigint(20) unsigned NOT NULL COMMENT '評論ID',
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '發評論者的新浪UID',
  `uid` bigint(20) DEFAULT NULL COMMENT '發評論的ID',
  `mid` bigint(20) unsigned NOT NULL COMMENT '微博ID',
  `m_uid` bigint(20) unsigned NOT NULL COMMENT '發微博的UID',
  `reply_cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回復的評論ID',
  `reply_uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回復者的ID',
  `content` varchar(140) CHARACTER SET utf8 NOT NULL COMMENT '評論內容',
  `source` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '內容來源',
  `post_ip` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '發佈者IP',
  `dateline` int(11) unsigned NOT NULL COMMENT '評論時間',
  `sina_nick` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT '發佈者新浪的昵稱',
  `disabled` varchar(1) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '是否遮罩',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC COMMENT='評論表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_comment_copy`
--

/*!40000 ALTER TABLE `xwb_comment_copy` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_comment_copy` ENABLE KEYS */;

--
-- Table structure for table `xwb_comment_delete`
--

DROP TABLE IF EXISTS `xwb_comment_delete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_comment_delete` (
  `id` bigint(20) unsigned NOT NULL COMMENT '評論ID',
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '發評論者的新浪UID',
  `sina_nick` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT '發佈者新浪的昵稱',
  `mid` bigint(20) unsigned NOT NULL COMMENT '微博ID',
  `reply_cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回復的評論ID',
  `content` varchar(140) CHARACTER SET utf8 NOT NULL COMMENT '評論內容',
  `post_ip` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '發佈者IP',
  `dateline` int(10) unsigned NOT NULL COMMENT '評論時間',
  `add_time` int(11) unsigned NOT NULL COMMENT '增加時間',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC COMMENT='評論刪除表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_comment_delete`
--

/*!40000 ALTER TABLE `xwb_comment_delete` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_comment_delete` ENABLE KEYS */;

--
-- Table structure for table `xwb_comment_verify`
--

DROP TABLE IF EXISTS `xwb_comment_verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_comment_verify` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '評論ID',
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '發評論者的新浪UID',
  `sina_nick` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT '發佈者新浪的昵稱',
  `token` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '發佈者的token',
  `token_secret` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '發佈者的token_secret',
  `mid` bigint(20) unsigned NOT NULL COMMENT '微博ID',
  `reply_cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回復的評論ID',
  `content` varchar(140) CHARACTER SET utf8 NOT NULL COMMENT '評論內容',
  `post_ip` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '發佈者IP',
  `dateline` int(11) unsigned NOT NULL COMMENT '用戶評論時間',
  `forward` varchar(1) COLLATE utf8_bin DEFAULT NULL COMMENT '是否作為一條新微博發佈',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC COMMENT='評論待審表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_comment_verify`
--

/*!40000 ALTER TABLE `xwb_comment_verify` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_comment_verify` ENABLE KEYS */;

--
-- Table structure for table `xwb_component_cfg`
--

DROP TABLE IF EXISTS `xwb_component_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_component_cfg` (
  `component_id` int(10) unsigned NOT NULL,
  `cfgName` varchar(30) NOT NULL COMMENT '參數名稱',
  `cfgValue` varchar(255) DEFAULT NULL COMMENT '參數值',
  `desc` varchar(50) DEFAULT NULL COMMENT '配置項說明',
  PRIMARY KEY (`component_id`,`cfgName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='元件對應的配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_component_cfg`
--

/*!40000 ALTER TABLE `xwb_component_cfg` DISABLE KEYS */;
INSERT INTO `xwb_component_cfg` VALUES (1,'show_num','5','元件顯示的微博數'),(2,'group_id','1','名人推薦用戶組對應的用戶列表ID'),(2,'show_num','3','顯示的名人數'),(3,'show_num','9',NULL),(3,'group_id','2','推薦用戶組使用的用戶列表ID'),(4,'group_id','3','人氣關注榜的資料來源，0 使用新浪API >0　對應的用戶組'),(10,'show_num','10','今日話題顯示的微博數'),(10,'group_id','1','今日話題使用的話題組'),(11,'groups','{\"1\":\"\\u660e\\u661f\",\"2\":\"\\u8349\\u6839\"}',NULL),(9,'show_num','4','隨便看看'),(5,'list_id','54355137','list id'),(5,'show_num','4',NULL),(4,'show_num','5','人氣關注榜掛件人數'),(6,'show_num','10',NULL),(6,'topic_id','0','0 使用新浪API取資料　> 0 對應的話題組ID'),(7,'show_num','9',NULL),(8,'show_num','3',NULL),(2,'topic_id','0','0 使用新浪API取資料　> 0 對應的話題組ID'),(10,'source','1','0 使用全域資料 >0 使用本站資料'),(9,'source','1','0 使用全域資料 >0 使用本站資料'),(1,'source','1','0 使用全域資料 >0 使用本站資料'),(8,'source','1','0 使用全域資料 >0 使用本站資料'),(12,'topic','微小說','話題微薄的預設話題'),(12,'show_num','6','顯示微博數'),(12,'source','1','微博來源'),(17,'show_num','5','元件顯示的微博數'),(17,'source','0','0 使用全域資料 >0 使用本站資料'),(18,'show_num','3',NULL);
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
  `topic` varchar(50) NOT NULL COMMENT '話題',
  `date_time` int(10) unsigned NOT NULL COMMENT '生效時間或添加時間',
  `sort_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `ext1` varchar(45) DEFAULT NULL COMMENT '擴展欄位',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='熱門話題清單';
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
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '話題ID',
  `topic_name` varchar(25) NOT NULL COMMENT '話題清單的名稱',
  `native` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否為內置話題，內置不能刪除',
  `sort` varchar(1) NOT NULL DEFAULT '1' COMMENT '類別下的話題是否允許排序',
  `app_with` text,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '話題分組類型',
  PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_component_topiclist`
--

/*!40000 ALTER TABLE `xwb_component_topiclist` DISABLE KEYS */;
INSERT INTO `xwb_component_topiclist` VALUES (2,'今日話題',1,'0','2,5',2);
/*!40000 ALTER TABLE `xwb_component_topiclist` ENABLE KEYS */;

--
-- Table structure for table `xwb_component_usergroups`
--

DROP TABLE IF EXISTS `xwb_component_usergroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_component_usergroups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分組ID',
  `group_name` varchar(15) NOT NULL COMMENT '組名稱',
  `native` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否為內置列表 1:是 0:否',
  `related_id` varchar(50) DEFAULT NULL COMMENT '元件應用情況，即哪位元ID的元件使用了，可為多個，逗號分隔',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分組類型，0:普通分組, 4:官方微博分組',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='推薦用戶　的各個分組';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_component_usergroups`
--

/*!40000 ALTER TABLE `xwb_component_usergroups` DISABLE KEYS */;
INSERT INTO `xwb_component_usergroups` VALUES (3,'自動關注用戶列表',1,'11:1,11:1',0),(83,'首次登陸引導關注',0,NULL,0),(84,'首頁用戶推薦(他們在微博)',1,NULL,0);
/*!40000 ALTER TABLE `xwb_component_usergroups` ENABLE KEYS */;

--
-- Table structure for table `xwb_component_users`
--

DROP TABLE IF EXISTS `xwb_component_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_component_users` (
  `group_id` int(10) unsigned DEFAULT NULL COMMENT '唯一、自增的用戶分組ID',
  `uid` bigint(20) unsigned NOT NULL COMMENT '用戶ID',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `nickname` varchar(20) DEFAULT NULL COMMENT '用戶昵稱',
  `remark` varchar(255) DEFAULT NULL COMMENT '備註',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用戶列表成員表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_component_users`
--

/*!40000 ALTER TABLE `xwb_component_users` DISABLE KEYS */;
INSERT INTO `xwb_component_users` VALUES (1,1904178193,3,'微博開放平臺','新浪微博API官方帳號',160),(2,1662047260,3,'SinaAppEngine','新浪SAE服務官方帳號',163),(83,1076590735,1,'Xweibo官方','xweibo官方微博',164),(2,1904178193,2,'微博開放平臺','新浪微博API官方帳號',162),(2,1076590735,1,'Xweibo官方','新浪Xweibo官方帳號',161),(1,1076590735,1,'Xweibo官方','新浪Xweibo官方帳號',158),(1,1662047260,2,'SinaAppEngine','新浪SAE雲服務平臺官方帳號',159);
/*!40000 ALTER TABLE `xwb_component_users` ENABLE KEYS */;

--
-- Table structure for table `xwb_components`
--

DROP TABLE IF EXISTS `xwb_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_components` (
  `component_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一、自增ID',
  `name` varchar(20) NOT NULL COMMENT '組件名稱',
  `title` varchar(45) DEFAULT NULL COMMENT '用於顯示的名稱',
  `type` tinyint(4) DEFAULT NULL COMMENT '元件類型　0表示一個頁面只有一個，>0表示一個頁面可以有多個',
  `native` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否為內置類型',
  `component_type` tinyint(4) NOT NULL COMMENT '組件類型 1: 頁面主體 2: 側邊欄',
  `symbol` varchar(20) NOT NULL COMMENT '模組標識，程式中使用',
  `desc` varchar(255) DEFAULT NULL COMMENT '模組說明',
  `preview_img` varchar(255) DEFAULT NULL COMMENT '預覽圖片',
  `component_cty` varchar(16) DEFAULT NULL COMMENT '組件分類:array(''user'' => ''用戶'', ''wb'' => ''微博'', ''topic'' => ''話題'', ''others'' => ''其它'')',
  PRIMARY KEY (`component_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='組件表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_components`
--

/*!40000 ALTER TABLE `xwb_components` DISABLE KEYS */;
INSERT INTO `xwb_components` VALUES (1,'熱門轉發與評論','熱門轉發與評論',0,1,1,'hotWb','當天轉發最多的微博列表（倒序排列）',NULL,'wb'),(2,'用戶組','用戶組',2,1,1,'starRcm','一組用戶的列表',NULL,'user'),(3,'推薦用戶','推薦用戶',3,1,2,'userRcm','指定某些用戶的列表（右邊欄）',NULL,'user'),(5,'自訂微博列表','自訂微博列表',5,1,1,'official','某些指定用戶發佈的微博列表',NULL,'wb'),(6,'話題推薦清單','話題推薦清單',6,1,2,'hotTopic','一組話題清單',NULL,'others'),(7,'可能感興趣的人','可能感興趣的人',0,1,2,'guessYouLike','根據當前使用者的IP、個人資料推薦相關聯的用戶列表',NULL,'user'),(8,'同城微博','同城微博',0,1,1,'cityWb','根據當前使用者的IP位址判斷地區，並展示該地區使用者的微博清單',NULL,'wb'),(9,'隨便看看','隨便看看',0,1,1,'looklook','一段特點時間內發佈的（一般為最新）的微博列表，隨機展現',NULL,'wb'),(10,'今日話題','今日話題',0,1,1,'todayTopic','自動獲取與今日話題相關的微博消息。話題可以在“運營管理-話題推薦管理”中設置',NULL,'others'),(12,'話題微博','話題微博',12,1,1,'topicWb','當前設定話題的相關微博清單',NULL,'wb'),(15,'最新用戶','最新用戶',0,1,2,'newestWbUser','本站最新開通微博的用戶列表',NULL,'user'),(14,'最新微博','最新微博',15,1,1,'newestWb','當前網站最新發佈的微博列表',NULL,'wb'),(13,'專題banner圖','專題banner圖',13,1,1,'pageImg','在頁面中添加一個寬度為560px的banner圖片',NULL,'others'),(16,'微博發佈框','微博發佈框',0,1,1,'sendWb','微博發佈框',NULL,'others'),(18,'活動列表','活動列表',0,1,2,'eventList','活動列表',NULL,'others'),(19,'本地關注榜','本地關注榜',0,1,2,'localFollowTop','本地關注榜',NULL,'user');
/*!40000 ALTER TABLE `xwb_components` ENABLE KEYS */;

--
-- Table structure for table `xwb_content_unit`
--

DROP TABLE IF EXISTS `xwb_content_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_content_unit` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(40) DEFAULT NULL COMMENT '輸出單元的名稱',
  `title` varchar(40) DEFAULT NULL COMMENT '輸出單元的標題，暫時只用於群組微博',
  `width` int(4) DEFAULT NULL COMMENT '輸出單元的寬度',
  `height` int(4) DEFAULT NULL COMMENT '輸出單元的高度',
  `target` varchar(40) DEFAULT NULL COMMENT '輸出單元內容的來源物件',
  `type` int(4) DEFAULT '1' COMMENT '輸出單元的類型，預設是1.1是微博秀, 2是推薦用戶列表, 3是互動話題，4是一鍵關注，5是群組微博',
  `skin` int(4) DEFAULT '1' COMMENT '輸出單元的樣式皮膚,預設是1',
  `colors` int(4) DEFAULT NULL COMMENT '輸出單元的自訂樣式',
  `show_title` tinyint(3) DEFAULT '1' COMMENT '是否顯示標題,預設是1, 1是顯示, 0是不顯示',
  `show_border` tinyint(3) DEFAULT '1' COMMENT '是否顯示邊框,預設是1, 1是顯示, 0是不顯示',
  `show_logo` tinyint(3) DEFAULT '1' COMMENT '是否顯示logo,預設是1, 1是顯示, 0是不顯示',
  `show_publish` tinyint(3) DEFAULT '0' COMMENT '是否顯示發佈框，預設是0, 1是顯示，0是不顯示',
  `auto_scroll` tinyint(3) DEFAULT '0' COMMENT '是否自動滾動，默認是0, 1是自動滾動，0不是自動滾動',
  `add_time` int(10) DEFAULT NULL COMMENT '添加時間',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='內容輸出單元';
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
  `type` tinyint(4) NOT NULL COMMENT '內容類別型：１微博ID　２評論ID　３昵稱　４內容',
  `item` varchar(45) NOT NULL COMMENT '遮罩或禁止的ID或內容',
  `comment` varchar(60) NOT NULL COMMENT '相關顯示內容',
  `admin_name` varchar(24) NOT NULL COMMENT '管理員操作時的昵稱',
  `admin_id` int(10) unsigned NOT NULL COMMENT '管理員ID',
  `user` varchar(45) NOT NULL COMMENT '微博或評論的作者',
  `publish_time` varchar(20) NOT NULL COMMENT '微博或評論的發佈時間yyyy-mm-dd hh:ii:ss格式字串',
  `add_time` int(10) unsigned NOT NULL COMMENT '加入時間',
  PRIMARY KEY (`kw_id`),
  UNIQUE KEY `Index_type_item` (`type`,`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='遮罩或禁止的內容清單';
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
  `event_id` int(4) unsigned NOT NULL COMMENT '活動id',
  `wb_id` bigint(20) NOT NULL COMMENT '微博id',
  `weibo` text COMMENT '微博內容',
  `comment_time` int(10) DEFAULT NULL COMMENT '評論時間',
  PRIMARY KEY (`event_id`,`wb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 COMMENT='活動評論表';
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
  `event_id` int(11) NOT NULL COMMENT '活動ID',
  `contact` varchar(200) DEFAULT NULL COMMENT '聯繫方式',
  `notes` text COMMENT '備註',
  `join_time` int(11) DEFAULT NULL COMMENT '參與時間',
  PRIMARY KEY (`sina_uid`,`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='活動參與表';
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
  `title` varchar(200) DEFAULT NULL COMMENT '標題',
  `addr` varchar(200) DEFAULT NULL COMMENT '地址',
  `desc` text COMMENT '簡介',
  `cost` float DEFAULT NULL COMMENT '費用',
  `sina_uid` bigint(20) DEFAULT NULL COMMENT '發起人ID',
  `nickname` varchar(25) NOT NULL COMMENT '發起人昵稱',
  `realname` varchar(25) DEFAULT NULL COMMENT '真實姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '聯繫電話',
  `start_time` int(11) DEFAULT NULL COMMENT '開始時間',
  `end_time` int(11) DEFAULT NULL COMMENT '結束時間',
  `pic` varchar(200) DEFAULT NULL COMMENT '圖片',
  `wb_id` bigint(20) DEFAULT NULL COMMENT '微博ID',
  `join_num` int(11) DEFAULT NULL COMMENT '參與人數',
  `view_num` int(11) DEFAULT NULL COMMENT '查看次數',
  `comment_num` int(11) DEFAULT NULL COMMENT '評論數',
  `state` tinyint(2) DEFAULT '1' COMMENT '活動狀態：1正常，2用戶關閉，3，管理員封禁，4是推薦',
  `other` tinyint(2) DEFAULT '1' COMMENT '是否要求參加填寫聯繫方式和備註：1是不用，2是要求',
  `modify_time` int(11) DEFAULT NULL COMMENT '修改時間',
  `add_time` int(11) DEFAULT NULL COMMENT '發起時間',
  `add_ip` varchar(30) DEFAULT NULL COMMENT '發起人所在地IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='活動主表';
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
  `ask_id` bigint(20) unsigned NOT NULL COMMENT '提問微博ID',
  `answer_wb` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '第一條回答的微博ID;如果是點評的,ask_id=answer_wb',
  `interview_id` int(10) unsigned NOT NULL COMMENT '微訪談節目標識',
  `state` char(1) NOT NULL COMMENT 'P:待審;A:審核通過;刪除為物理刪除;主持人和嘉賓的微博不需要審核',
  `ask_uid` bigint(20) unsigned NOT NULL COMMENT '提問者uid',
  `answer_uid` bigint(20) unsigned DEFAULT NULL COMMENT '第一個回答者uid',
  `weibo` text COMMENT 'json結構的微博內容',
  `answer_weibo` text COMMENT 'json結構的微博內容',
  PRIMARY KEY (`ask_id`),
  KEY `interview_index` (`interview_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微訪談內容';
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
  `interview_id` int(10) NOT NULL COMMENT '微訪談節目ID',
  `ask_id` bigint(20) NOT NULL COMMENT '用戶提問微博ID',
  `at_uid` bigint(20) NOT NULL COMMENT '提問嘉賓UID',
  `answer_wb` bigint(20) NOT NULL DEFAULT '0' COMMENT '回答的微博ID',
  `weibo` text COMMENT 'json結構後的微博內容',
  PRIMARY KEY (`interview_id`,`ask_id`,`at_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存微訪談嘉賓被提問的問題';
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
  `group_id` int(10) unsigned NOT NULL COMMENT '分組ID 已定義的，1：分類用戶推薦 2：引導關注類別',
  `item_id` int(11) NOT NULL COMMENT '分組對象的ID',
  `item_name` varchar(25) DEFAULT NULL COMMENT '分組名稱',
  `sort_num` int(11) DEFAULT '0' COMMENT '排序ID，通常用於組內',
  PRIMARY KEY (`id`),
  KEY `group_idx` (`group_id`,`sort_num`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用於存儲ID分組清單，如用戶分類';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_item_groups`
--

/*!40000 ALTER TABLE `xwb_item_groups` DISABLE KEYS */;
INSERT INTO `xwb_item_groups` VALUES (1,2,83,'首次登陸引導關注',0);
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保留一些個性功能變數名稱';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_keep_userdomain`
--

/*!40000 ALTER TABLE `xwb_keep_userdomain` DISABLE KEYS */;
INSERT INTO `xwb_keep_userdomain` VALUES ('application'),('flash'),('html_demo'),('install'),('readme'),('sae_install'),('templates');
/*!40000 ALTER TABLE `xwb_keep_userdomain` ENABLE KEYS */;

--
-- Table structure for table `xwb_log_error`
--

DROP TABLE IF EXISTS `xwb_log_error`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_error` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '標識ID',
  `soft` varchar(45) NOT NULL COMMENT '軟體名稱',
  `version` varchar(10) NOT NULL COMMENT '版本',
  `akey` varchar(45) NOT NULL COMMENT 'app key',
  `type` varchar(10) NOT NULL COMMENT '日誌類型，IO/DB/CACHE/API',
  `level` varchar(10) NOT NULL COMMENT '日誌等級 ,error、warning',
  `msg` varchar(500) NOT NULL COMMENT '日誌資訊',
  `extra` varchar(500) DEFAULT NULL COMMENT '擴展資訊',
  `log_time` datetime NOT NULL COMMENT '記錄時間',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_log_error`
--

/*!40000 ALTER TABLE `xwb_log_error` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_log_error` ENABLE KEYS */;

--
-- Table structure for table `xwb_log_error_api`
--

DROP TABLE IF EXISTS `xwb_log_error_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_error_api` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '標識ID',
  `soft` varchar(45) NOT NULL COMMENT '軟體名稱',
  `version` varchar(10) NOT NULL COMMENT '版本',
  `akey` varchar(45) NOT NULL COMMENT 'app key',
  `type` varchar(10) NOT NULL COMMENT '日誌類型，IO/DB/CACHE/API',
  `level` varchar(10) NOT NULL COMMENT '日誌等級 ,error、warning',
  `msg` varchar(500) NOT NULL COMMENT '日誌資訊',
  `extra` varchar(500) DEFAULT NULL COMMENT '擴展資訊',
  `log_time` datetime NOT NULL COMMENT '記錄時間',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_log_error_api`
--

/*!40000 ALTER TABLE `xwb_log_error_api` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_log_error_api` ENABLE KEYS */;

--
-- Table structure for table `xwb_log_http`
--

DROP TABLE IF EXISTS `xwb_log_http`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_http` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(500) DEFAULT NULL COMMENT '請求url',
  `base_string` varchar(500) NOT NULL DEFAULT '' COMMENT '加密的base_string',
  `key_string` varchar(500) NOT NULL DEFAULT '' COMMENT '加密的key_string',
  `http_code` int(4) DEFAULT NULL COMMENT 'http code',
  `ret` varchar(200) NOT NULL DEFAULT '' COMMENT '返回結果',
  `post_data` text COMMENT 'post數據',
  `request_time` float DEFAULT NULL COMMENT '請求時間',
  `total_time` float DEFAULT NULL COMMENT '總執行時間',
  `s_ip` char(15) DEFAULT NULL COMMENT '伺服器ip',
  `log_time` char(20) DEFAULT NULL COMMENT '記錄時間',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='請求介面日誌';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_log_http`
--

/*!40000 ALTER TABLE `xwb_log_http` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_log_http` ENABLE KEYS */;

--
-- Table structure for table `xwb_log_info`
--

DROP TABLE IF EXISTS `xwb_log_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '標識ID',
  `soft` varchar(45) NOT NULL COMMENT '軟體名稱',
  `version` varchar(10) NOT NULL COMMENT '版本',
  `akey` varchar(45) NOT NULL COMMENT 'app key',
  `type` varchar(10) NOT NULL COMMENT '日誌類型，IO/DB/CACHE/API',
  `level` varchar(10) NOT NULL COMMENT '日誌等級 ,error、warning',
  `msg` varchar(500) NOT NULL COMMENT '日誌資訊',
  `extra` varchar(500) DEFAULT NULL COMMENT '擴展資訊',
  `log_time` datetime NOT NULL COMMENT '記錄時間',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_log_info`
--

/*!40000 ALTER TABLE `xwb_log_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_log_info` ENABLE KEYS */;

--
-- Table structure for table `xwb_log_info_api`
--

DROP TABLE IF EXISTS `xwb_log_info_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_log_info_api` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '標識ID',
  `soft` varchar(45) NOT NULL COMMENT '軟體名稱',
  `version` varchar(10) NOT NULL COMMENT '版本',
  `akey` varchar(45) NOT NULL COMMENT 'app key',
  `type` varchar(10) NOT NULL COMMENT '日誌類型，IO/DB/CACHE/API',
  `level` varchar(10) NOT NULL COMMENT '日誌等級 ,error、warning',
  `msg` varchar(500) NOT NULL COMMENT '日誌資訊',
  `extra` varchar(500) DEFAULT NULL COMMENT '擴展資訊',
  `log_time` datetime NOT NULL COMMENT '記錄時間',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_log_info_api`
--

/*!40000 ALTER TABLE `xwb_log_info_api` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_log_info_api` ENABLE KEYS */;

--
-- Table structure for table `xwb_micro_interview`
--

DROP TABLE IF EXISTS `xwb_micro_interview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_micro_interview` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '標識',
  `title` varchar(200) NOT NULL COMMENT '標題',
  `desc` text NOT NULL COMMENT '說明',
  `banner_img` varchar(200) NOT NULL COMMENT 'Banner圖片',
  `cover_img` varchar(200) NOT NULL COMMENT '封面圖片',
  `state` char(1) NOT NULL DEFAULT 'N' COMMENT '默認N;X:已刪;',
  `wb_state` char(1) NOT NULL DEFAULT 'A' COMMENT 'P:先審後發;A:直接發佈',
  `master` varchar(200) DEFAULT NULL COMMENT '主持人新浪uid清單，json結構保存',
  `guest` text COMMENT '嘉賓新浪uid清單，json結構保存',
  `backgroup_img` varchar(200) DEFAULT NULL COMMENT '背景圖片',
  `backgroup_color` varchar(20) DEFAULT NULL COMMENT '外觀顏色',
  `start_time` int(11) NOT NULL COMMENT '開始時間',
  `end_time` int(11) NOT NULL COMMENT '結束時間',
  `add_time` int(11) NOT NULL COMMENT '添加時間',
  `backgroup_style` tinyint(2) unsigned DEFAULT NULL COMMENT '背景圖方式,預設是1,1是平鋪，2是居中',
  `custom_color` varchar(20) DEFAULT NULL COMMENT '自訂顏色',
  `notice_time` int(10) unsigned DEFAULT NULL COMMENT '提醒時間，以秒為單位',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Xweibo微訪談';
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
  `title` varchar(200) NOT NULL COMMENT '標題',
  `trends` varchar(200) NOT NULL COMMENT '微直播的話題',
  `desc` text NOT NULL COMMENT '簡介',
  `code` text COMMENT '直播視頻代碼',
  `start_time` int(11) NOT NULL COMMENT '開始時間',
  `end_time` int(11) NOT NULL COMMENT '結束時間',
  `master` varchar(200) NOT NULL COMMENT '主持人，json格式保存',
  `guest` text NOT NULL COMMENT '嘉賓，json格式保存',
  `banner_img` varchar(200) DEFAULT NULL COMMENT '微直播的banner',
  `cover_img` varchar(200) DEFAULT NULL COMMENT '封面圖',
  `backgroup_img` varchar(200) DEFAULT NULL COMMENT '背景圖',
  `backgroup_style` tinyint(2) DEFAULT NULL COMMENT '背景圖方式，預設是1，1是平鋪，2是居中',
  `backgroup_color` varchar(20) DEFAULT NULL COMMENT '外觀樣式',
  `custom_color` varchar(20) DEFAULT NULL COMMENT '自訂顏色',
  `state` char(1) NOT NULL DEFAULT 'N' COMMENT '默認N，X:已刪',
  `wb_state` char(1) NOT NULL DEFAULT 'A' COMMENT 'P:先審後發;A:直接發佈',
  `notice_time` int(11) DEFAULT NULL COMMENT '提醒時間',
  `add_time` int(11) DEFAULT NULL COMMENT '發起時間',
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
  `weibo` text COMMENT '微博內容',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '發微博人的類型，默認是1，1是網友，2是主持人，3是嘉賓',
  `state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '微博狀態，預設是1，1是正常，2是未審核，3是通過審核',
  `add_time` int(11) DEFAULT NULL COMMENT '發佈微博時間',
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
  `isNative` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0:自訂;1:系統預設',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='頁面巡覽列';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_nav`
--

/*!40000 ALTER TABLE `xwb_nav` DISABLE KEYS */;
INSERT INTO `xwb_nav` VALUES (132,'活動',0,1,100,35,0,'',2,0),(130,'微博廣場',0,1,0,1,0,'',2,0),(131,'名人堂',0,1,0,3,0,'',2,0),(21,'我的首頁',0,1,50,2,1,'',2,1);
/*!40000 ALTER TABLE `xwb_nav` ENABLE KEYS */;

--
-- Table structure for table `xwb_notice`
--

DROP TABLE IF EXISTS `xwb_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_notice` (
  `notice_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '通知ID',
  `sender_id` bigint(20) DEFAULT '0' COMMENT '發送者的sina_uid，預設為0，表示系統發送',
  `title` varchar(100) DEFAULT NULL COMMENT '通知標題',
  `content` text COMMENT '通知內容',
  `add_time` int(11) DEFAULT NULL COMMENT '發佈時間',
  `available_time` int(11) DEFAULT NULL COMMENT '生效時間',
  PRIMARY KEY (`notice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='通知內容表';
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
  `recipient_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '接收者的sina_uid，為0表示全站用戶',
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin CHECKSUM=1 DELAY_KEY_WRITE=1 COMMENT='消息接收者記錄表';
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
  `page_id` int(11) NOT NULL COMMENT '預定義的頁面ID：如１：廣場。。',
  `component_id` int(11) DEFAULT NULL COMMENT '使用到的元件ID',
  `title` varchar(45) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0' COMMENT '擺放的位置 1:左邊　２：右側欄',
  `sort_num` int(11) DEFAULT '0' COMMENT '擺放的順序',
  `in_use` tinyint(1) DEFAULT '1' COMMENT '是否使用',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isNative` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:系統自帶，不能刪除  0:用戶添加，可以刪除',
  `param` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=367 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='頁面設置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_page_manager`
--

/*!40000 ALTER TABLE `xwb_page_manager` DISABLE KEYS */;
INSERT INTO `xwb_page_manager` VALUES (1,10,'今日話題',1,1,1,1,0,'{\"show_num\":\"10\",\"source\":\"0\",\"topic\":\"Xweibo\"}'),(1,14,'本站最新微博',1,3,1,363,0,'{\"show_num\":\"10\"}'),(1,7,'可能感興趣的人',2,2,1,364,0,'{\"show_num\":\"3\"}'),(2,7,'可能感興趣的人',2,2,1,11,0,'{\"show_num\":\"10\"}'),(45,13,'隨便看看banner圖',1,1,1,357,0,'{\"link\":\"\",\"src\":\"\\/var\\/upload\\/pic\\/component_img_1303108721.png\",\"width\":\"560\",\"height\":\"\"}'),(45,14,'本站最新微博',1,2,1,356,0,'{\"show_num\":\"20\"}'),(44,13,'banner圖',1,1,1,355,0,'{\"link\":\"http:\\/\\/\",\"src\":\"\\/var\\/upload\\/pic\\/component_img_1303108508.png\",\"width\":\"560\",\"height\":\"\"}'),(44,8,'同城微博',1,2,1,353,0,'{\"source\":\"0\",\"page_type\":\"1\",\"show_num\":\"15\"}'),(44,19,'本地關注榜',2,2,1,354,0,'{\"show_num\":\"6\"}'),(47,5,'自訂集體微博',1,2,1,361,0,'{\"list_id\":\"0\",\"page_type\":\"1\",\"show_num\":\"15\"}'),(46,13,'自訂話題Banner',1,1,1,359,0,'{\"link\":\"\",\"src\":\"\\/var\\/upload\\/pic\\/component_img_1303109588.png\",\"width\":\"560\",\"height\":\"\"}'),(47,13,'自訂集體微博',1,1,1,360,0,'{\"link\":\"\",\"src\":\"\\/var\\/upload\\/pic\\/component_img_1303110458.png\",\"width\":\"560\",\"height\":\"\"}'),(46,12,'自訂話題微博清單',1,2,1,358,0,'{\"topic\":\"xweibo\",\"source\":\"0\",\"page_type\":\"1\",\"show_num\":\"15\"}'),(1,12,'大家都在聊',1,2,1,366,0,'{\"topic\":\"\\u5fae\\u535a\",\"source\":\"0\",\"page_type\":\"0\",\"show_num\":\"10\"}');
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='頁面原型';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_page_prototype`
--

/*!40000 ALTER TABLE `xwb_page_prototype` DISABLE KEYS */;
INSERT INTO `xwb_page_prototype` VALUES (2,'自訂頁面','自訂頁面原型',2,'','custom'),(1,'自訂頁面','自訂頁面原型',1,'','custom');
/*!40000 ALTER TABLE `xwb_page_prototype` ENABLE KEYS */;

--
-- Table structure for table `xwb_pages`
--

DROP TABLE IF EXISTS `xwb_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_pages` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '頁面id',
  `page_name` varchar(20) DEFAULT NULL COMMENT '頁面名稱',
  `desc` varchar(255) DEFAULT NULL COMMENT '頁面描述',
  `native` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否為內置頁',
  `url` varchar(45) DEFAULT NULL,
  `prototype_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_pages`
--

/*!40000 ALTER TABLE `xwb_pages` DISABLE KEYS */;
INSERT INTO `xwb_pages` VALUES (1,'微博廣場','“微博廣場”是用戶免登錄即可查看的頁面，包含了今日話題、隨便看看等元件。',1,'pub',NULL),(2,'我的首頁','“我的首頁”是登錄使用者操作微博的頁面，包含了猜你喜歡、推薦話題等元件。',1,'index',NULL),(3,'名人堂','名人堂',1,'celeb',NULL),(4,'我的微博','我的微博',1,'index.profile',NULL),(35,'活動首頁','活動列表頁，包括最新活動和推薦活動',1,'event',NULL),(6,'話題排行榜','話題排行榜',1,'pub.topics',NULL),(37,'我的收藏','我的收藏',1,'index.favorites',2),(7,'線上直播','線上直播擴展工具',1,'live',NULL),(8,'線上訪談','線上訪談擴展工具',1,'interview',NULL);
/*!40000 ALTER TABLE `xwb_pages` ENABLE KEYS */;

--
-- Table structure for table `xwb_plugins`
--

DROP TABLE IF EXISTS `xwb_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_plugins` (
  `plugin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL COMMENT '名稱',
  `desc` varchar(255) DEFAULT NULL COMMENT '簡介',
  `in_use` tinyint(1) DEFAULT '1' COMMENT '是否開啟',
  PRIMARY KEY (`plugin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_plugins`
--

/*!40000 ALTER TABLE `xwb_plugins` DISABLE KEYS */;
INSERT INTO `xwb_plugins` VALUES (2,'用戶首頁聚焦位','開啟該外掛程式會將站長設定的內容以圖文的形式顯示於使用者首頁中。',1),(3,'個人資料推廣位','開啟該外掛程式會將站長設定的內容以文字連結的形式顯示於使用者的個人資訊的下方。',1),(4,'登錄後引導關注','開啟該外掛程式後，用戶首次登陸會強制關注指定的用戶並且引導用戶其它推薦用戶。',1),(5,'用戶回饋意見','左導航會出現一個意見回饋通道',1),(6,'資料本地備份','本站備份一份微博資料',1);
/*!40000 ALTER TABLE `xwb_plugins` ENABLE KEYS */;

--
-- Table structure for table `xwb_profile_ad`
--

DROP TABLE IF EXISTS `xwb_profile_ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_profile_ad` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '標題',
  `link` varchar(255) NOT NULL COMMENT '連結',
  `add_time` int(11) DEFAULT NULL COMMENT '添加的時間',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='個人資訊推廣位元的廣告';
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
  `style_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '範本分類ID',
  `style_name` varchar(15) NOT NULL COMMENT '分類名稱',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '顯示排序',
  PRIMARY KEY (`style_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='皮膚類別表';
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
  `skin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '範本ID',
  `name` varchar(45) DEFAULT NULL COMMENT '檔案名名稱',
  `directory` varchar(45) NOT NULL COMMENT '所在的目錄',
  `desc` varchar(255) DEFAULT NULL COMMENT '範本說明',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '範本狀態　０正常（啟用）　１禁用　２文件不存在（不可用）',
  `style_id` int(11) NOT NULL DEFAULT '0' COMMENT '範本分類ID',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '顯示排序',
  PRIMARY KEY (`skin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='範本清單';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_skins`
--

/*!40000 ALTER TABLE `xwb_skins` DISABLE KEYS */;
INSERT INTO `xwb_skins` VALUES (1,'經典','skin_default','',0,0,1),(2,'沙灘','skin_beach','',0,0,4),(3,'墨綠','skin_blackgreen','',0,0,1),(4,'藍色','skin_blue','',0,0,2),(5,'魅紫','skin_charmpurple','',0,0,3),(6,'風景','skin_landscape','',0,0,5),(7,'荷花','skin_lotus','',0,0,6),(8,'節日','skin_newyear','',0,0,7),(9,'冬雪','skin_snow','',0,0,8),(10,'科技','skin_tech','',0,0,9),(11,'旅行','skin_tour','',0,0,10);
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
  `subject` varchar(100) NOT NULL DEFAULT '' COMMENT '話題名稱',
  `is_use` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否啟用，默認啟用，如果使用者刪除該話題訂閱，只進行軟刪除',
  PRIMARY KEY (`id`),
  KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='使用者話題收藏記錄表，如果使用者取消收藏，使用is_use來標記，不刪除。';
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
  `group_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '配置的分組ID',
  PRIMARY KEY (`key`,`group_id`),
  KEY `idx_groupid` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系統組態信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_sys_config`
--

/*!40000 ALTER TABLE `xwb_sys_config` DISABLE KEYS */;
INSERT INTO `xwb_sys_config` VALUES ('rewrite_enable','0',1),('logo','',1),('login_way','1',1),('third_code','',1),('site_record','',1),('address_icon','',1),('head_link','{\"1\":{\"link_name\":\"\\u65b0\\u6d6a\\u5fae\\u535a\",\"link_address\":\"http:\\/\\/t.sina.com.cn\\/\"},\"3\":{\"link_name\":\"\\u65b0\\u6d6a\\u7f51\",\"link_address\":\"http:\\/\\/www.sina.com.cn\"}}',1),('foot_link','{\"3\":{\"link_name\":\"\\u5e2e\\u52a9\\u4e2d\\u5fc3\",\"link_address\":\"http:\\/\\/x.weibo.com\\/help.php\"}}',1),('authen_type','3',1),('authen_big_icon','img/logo/big_auth_icon.png',1),('authen_small_icon','img/logo/small_auth_icon.png',1),('skin_default','1',1),('ad_header','',1),('guide_auto_follow','',1),('ad_footer','',1),('title','Xweibo 2.1',2),('text','新版Xweibo2.1更新了大量功能，在原有體系基礎上，提供了豐富的運營手段，幫助廣大站長利用新浪微博的平臺，架設屬於自己網站的微博系統。',2),('bg_pic','',2),('oper','2',2),('topic','',2),('link','http://x.weibo.com',2),('btnTitle','瞭解更多',2),('guide_auto_follow_id','3',1),('authen_small_icon_title','我的網站認證',1),('ad_setting','',1),('microInterview_setting','',1),('wb_page_type','2',1),('wb_header_model','1',1),('wb_header_htmlcode','',1),('api_checking','',1),('xwb_discuz_url','',1),('xwb_discuz_enable','',1),('use_person_domain','0',1),('site_short_link','',1),('microLive_setting','',1),('default_use_custom','0',1),('open_user_local_relationship','0',1),('xwb_strategy','',1);
/*!40000 ALTER TABLE `xwb_sys_config` ENABLE KEYS */;

--
-- Table structure for table `xwb_today_topics`
--

DROP TABLE IF EXISTS `xwb_today_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_today_topics` (
  `group_id` int(10) unsigned NOT NULL COMMENT '話題分組ID',
  `topic` varchar(45) NOT NULL COMMENT '話題內容',
  `effect_time` int(10) unsigned NOT NULL COMMENT '生效時間'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='今日話題的內容';
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
  `action_type` smallint(6) NOT NULL COMMENT '1、禁言 2、禁止用戶登錄、3、清除使用者資訊（不刪除、僅是在任何情況不顯示） 4、恢復正常',
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
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用戶ID',
  `ban_time` int(11) DEFAULT NULL COMMENT '封禁時間',
  `nick` varchar(20) DEFAULT NULL COMMENT '封禁用戶的昵稱',
  PRIMARY KEY (`id`),
  KEY `nick` (`nick`),
  KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='封禁用戶列表';
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
  `values` varchar(510) NOT NULL DEFAULT '0' COMMENT '使用者自訂的配置',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='使用者自訂配置的資訊';
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存使用者關注的話題';
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
  `friend_uid` bigint(20) NOT NULL COMMENT '被關注用戶ID',
  `fans_uid` bigint(20) NOT NULL COMMENT '粉絲用戶ID',
  `datetime` int(10) DEFAULT NULL COMMENT '時間',
  PRIMARY KEY (`friend_uid`,`fans_uid`),
  KEY `datetime_idx` (`datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='關注表';
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
  `friend_uid` bigint(20) NOT NULL COMMENT '被關注用戶ID',
  `fans_uid` bigint(20) NOT NULL COMMENT '粉絲用戶ID',
  `datetime` int(10) DEFAULT NULL COMMENT '時間',
  PRIMARY KEY (`friend_uid`,`fans_uid`),
  KEY `datetime_idx` (`datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='關注表';
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
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用戶ID',
  `nick` varchar(45) NOT NULL COMMENT '要加V的用戶',
  `reason` varchar(50) DEFAULT NULL COMMENT '認證理由',
  `add_time` int(10) unsigned DEFAULT NULL COMMENT '添加認證時間',
  `operator` bigint(20) NOT NULL COMMENT '操作者的ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_nick` (`nick`),
  KEY `index_add_time` (`add_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='要加V的用戶';
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
  `sina_uid` bigint(20) unsigned NOT NULL COMMENT '新浪用戶ID',
  `nickname` varchar(25) NOT NULL COMMENT '昵稱',
  `first_login` int(10) unsigned DEFAULT NULL COMMENT '首次登陸時間',
  `access_token` varchar(50) DEFAULT NULL COMMENT '授權後得到訪問API的token',
  `token_secret` varchar(50) DEFAULT NULL COMMENT 'API伺服器生成的加密串',
  `uid` bigint(20) DEFAULT NULL COMMENT '所捆綁的合作方的用戶ID',
  `domain_name` varchar(45) DEFAULT NULL COMMENT '用戶設置的個性化功能變數名稱',
  `max_notice_time` int(11) DEFAULT '0' COMMENT '用戶最後一次閱讀的起效的最新通知的時間戳記',
  `followers_count` int(11) unsigned DEFAULT NULL COMMENT '用戶的粉絲數，每次登陸時更新',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sina_uid` (`sina_uid`),
  KEY `nickname` (`nickname`),
  KEY `site_uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用戶表---所有登錄過的用戶';
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
  `weibo` tinytext COMMENT '微博內容',
  `uid` bigint(20) unsigned DEFAULT NULL,
  `nickname` varchar(45) DEFAULT NULL COMMENT '作者',
  `addtime` int(11) DEFAULT NULL COMMENT '發佈時間',
  `disabled` varchar(1) DEFAULT NULL COMMENT '是否被遮罩',
  `pic` varchar(124) DEFAULT NULL COMMENT '圖片url',
  PRIMARY KEY (`id`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_weibo_copy`
--

/*!40000 ALTER TABLE `xwb_weibo_copy` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_weibo_copy` ENABLE KEYS */;

--
-- Table structure for table `xwb_weibo_delete`
--

DROP TABLE IF EXISTS `xwb_weibo_delete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_weibo_delete` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `weibo` text NOT NULL COMMENT '微博內容',
  `picid` varchar(100) DEFAULT NULL COMMENT '上傳圖片的id',
  `sina_uid` bigint(20) NOT NULL COMMENT '發微博的用戶id',
  `nickname` varchar(45) DEFAULT NULL COMMENT '用戶昵稱',
  `retweeted_status` text COMMENT '轉發微博內容',
  `retweeted_wid` bigint(20) DEFAULT NULL COMMENT '轉發微博id',
  `access_token` varchar(50) NOT NULL,
  `token_secret` varchar(50) NOT NULL,
  `dateline` int(10) NOT NULL COMMENT '發佈時間',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='微博審核刪除表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_weibo_delete`
--

/*!40000 ALTER TABLE `xwb_weibo_delete` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_weibo_delete` ENABLE KEYS */;

--
-- Table structure for table `xwb_weibo_verify`
--

DROP TABLE IF EXISTS `xwb_weibo_verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xwb_weibo_verify` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `weibo` text NOT NULL COMMENT '微博內容',
  `cwid` varchar(50) DEFAULT NULL COMMENT '要評論的微博id',
  `picid` varchar(100) DEFAULT NULL COMMENT '上傳圖片的id',
  `sina_uid` bigint(20) NOT NULL COMMENT '發微博的用戶id',
  `nickname` varchar(45) DEFAULT NULL COMMENT '用戶昵稱',
  `retweeted_status` text COMMENT '轉發微博內容',
  `retweeted_wid` bigint(20) DEFAULT NULL COMMENT '轉發微博id',
  `access_token` varchar(50) NOT NULL,
  `token_secret` varchar(50) NOT NULL,
  `type` varchar(20) DEFAULT NULL COMMENT '類型,"live"微直播',
  `extend_id` int(4) DEFAULT NULL COMMENT '擴展id',
  `extend_data` varchar(200) DEFAULT NULL COMMENT '擴展資料',
  `dateline` int(10) NOT NULL COMMENT '發佈時間',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `sina_uid` (`sina_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='微博審核表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xwb_weibo_verify`
--

/*!40000 ALTER TABLE `xwb_weibo_verify` DISABLE KEYS */;
/*!40000 ALTER TABLE `xwb_weibo_verify` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-06-08 10:58:51