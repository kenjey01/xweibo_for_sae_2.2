<?php
/**
 * @file			upgrade.class.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-07-08
 * @Modified By:	heli/2010-12-24
 * @Brief			Xweibo安装程序版本升级处理类
 */

class upgrade {

	var $link;
	var $db_host;
	var $db_user;
	var $db_passwd;
	var $db_name;

	function upgrade($db_host, $db_user, $db_passwd, $db_name)
	{
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_passwd = $db_passwd;
		$this->db_name = $db_name;
		$this->link = @mysql_connect($db_host, $db_user, $db_passwd);
		mysql_select_db($db_name, $this->link);
		mysql_query('SET NAMES '.XWEIBO_DB_CHARSET, $this->link);
	}

	/**
	 * 升级更新到1.1.1
	 *
	 *
	 */
	function action_db111($db_prefix)
	{
		///更新page_manager 表字段和值
		$pmTable = $db_prefix.'page_manager';
		$sql	 = "ALTER TABLE `$pmTable` ADD COLUMN `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT
					, ADD COLUMN `title` VARCHAR(45)
					, ADD COLUMN `isNative` INT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1:系统自带，不能删除  0:用户添加，可以删除'
					, ADD COLUMN `param` TEXT
					, ADD PRIMARY KEY (`id`)";
		$ret = mysql_query($sql, $this->link);

		///更新component_users 表字段和值
		$comUserTable 	= $db_prefix.'component_users'; 
		$sql			= "ALTER TABLE `$comUserTable` MODIFY COLUMN `group_id` INT(10) UNSIGNED DEFAULT NULL COMMENT '唯一、自增的用户分组ID'
							, ADD COLUMN `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT
							, DROP PRIMARY KEY
							, ADD PRIMARY KEY  USING BTREE(`id`)";
		$ret = mysql_query($sql, $this->link);

		///更新component_usergroups 表字段和值
		$userGroupTable = $db_prefix.'component_usergroups'; 
		$sql			= "ALTER TABLE `$userGroupTable` ADD COLUMN `type` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分组类型，0:普通分组, 4:微博频道分组'";
		$ret = mysql_query($sql, $this->link);
		$sql = "update `$userGroupTable` set `type` = 4, `group_name`='微博频道用户列表' where group_id=4";
		$ret = mysql_query($sql, $this->link);

		///更新components 表字段和值
		$componentTable = $db_prefix.'components'; 
		$sql = "ALTER TABLE `$componentTable` MODIFY COLUMN `type` TINYINT(4) DEFAULT NULL COMMENT '组件类型　0表示一个页面只有一个，>0表示一个页面可以有多个'";
		$ret = mysql_query($sql, $this->link);
		$sql = "update $componentTable set type='0' where component_id in(1, 7, 8, 9, 10, 11)";
		$ret = mysql_query($sql, $this->link);
		$sql = "insert into $componentTable (`component_id`, `name`, `title`, `type`, `native`, `component_type`, `symbol`, `desc`) values (12, '话题微博', '话题微博', 12, 1, 1, 'topicWb', '该组件列示了话题的微博消息。')";
		$ret = mysql_query($sql, $this->link);
		$sql = "update $componentTable set `name`='微博频道', `title`='微博频道' where component_id = 5";
		$ret = mysql_query($sql, $this->link);

		///更新component_cfg 表字段和值
		$comCfgTable = $db_prefix.'component_cfg'; 
		$sql = "INSERT INTO `$comCfgTable` VALUES (2,'topic_id','0','0 使用新浪API取数据　> 0 对应的话题组ID')";
		$ret = mysql_query($sql, $this->link);
		$sql = "INSERT INTO `$comCfgTable` VALUES (12,'topic','微小说','话题微薄的默认话题'), (12, 'show_num', '6', '显示微博数'), (1, 'source', 0, '0 使用全局数据 >0 使用本站数据'), (8, 'source', 0, '0 使用全局数据 >0 使用本站数据'), (9, 'source', 0, '0 使用全局数据 >0 使用本站数据'), (10, 'source', 0, '0 使用全局数据 >0 使用本站数据'), (12, 'source', '0', '0 使用全局数据 >0 使用本站数据')";
		$ret = mysql_query($sql, $this->link);

		///更新component_topiclist 表字段和值
		$comTopicTable = $db_prefix.'component_topiclist'; 
		$sql = "ALTER TABLE `$comTopicTable` ADD COLUMN `type` TINYINT(4) NOT NULL DEFAULT 0 COMMENT '话题分组类型'";
		$ret = mysql_query($sql, $this->link);
		$sql = "update `$comTopicTable` set type=2 where topic_id=2";
		$ret = mysql_query($sql, $this->link);

		// plugin
		$pluginTable = $db_prefix.'plugins'; 
		// 删除 页尾广告  在 plugin 表里面的记录
		$ret = mysql_query("delete from $pluginTable where plugin_id=1 ", $this->link);

		///添加ad表
		$adTable = $db_prefix.'ad';
		$sql = "CREATE TABLE `$adTable` (`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				`content` TEXT COMMENT '广告内容',
				`using` VARCHAR(1) DEFAULT '1' COMMENT '是否应用',
				`add_time` INT(10) UNSIGNED DEFAULT NULL COMMENT '添加时间',
				`name` VARCHAR(45) DEFAULT NULL COMMENT '广告位名称',
				`description` TEXT COMMENT '广告位描述',
				`page` VARCHAR(45) DEFAULT NULL COMMENT '页面Action',
				`flag` VARCHAR(45) DEFAULT NULL,
				`config` TEXT COMMENT '广告配置',
				`width` INT(11) DEFAULT '0' COMMENT '广告容器宽度',
				`height` INT(11) DEFAULT '0' COMMENT '广告容器高度',
				PRIMARY KEY (`id`),
				KEY `index_using` (`using`,`page`,`flag`)
				) ENGINE=MYISAM DEFAULT CHARSET=utf8 COMMENT='广告'";
		$ret = mysql_query($sql, $this->link);
		$sql = "INSERT INTO `$adTable` VALUES ('1','<a href=\"http://x.weibo.com\" target=\"_blank\"><img src=\"img/ad/footer_ad.png\"></a>','1','1293697787','底部通栏广告','全站','global','global_bottom',NULL,'0','0'),('2','','',NULL,'对联广告(左)','全站','global','global_left',null,'0','0'),('3','','',NULL,'对联广告(右)','全站','global','global_right',null,'0','0'),('4','','',NULL,'侧栏广告','微博广场','pub','sidebar',NULL,'0','0'),('5','','',NULL,'今日话题广告','微博广场','pub','today_topic',NULL,'0','0'),('6','','',NULL,'发布框下广告','我的首页','index','publish',NULL,'0','0'),('7','','',NULL,'侧栏广告','我的首页','index','sidebar',NULL,'0','0'),('8','','',NULL,'侧栏广告','他的首页','ta','sidebar',NULL,'0','0');";
		$ret = mysql_query($sql, $this->link);

		///添加content_unit表
		$contentUnitTable = $db_prefix.'content_unit';
		$sql = "CREATE TABLE `$contentUnitTable` (`id` INT(4) NOT NULL AUTO_INCREMENT,
				`unit_name` VARCHAR(40) DEFAULT NULL COMMENT '输出单元的标题',
				`width` INT(4) DEFAULT NULL COMMENT '输出单元的宽度',
				`height` INT(4) DEFAULT NULL COMMENT '输出单元的高度',
				`target` VARCHAR(40) DEFAULT NULL COMMENT '输出单元内容的来源对象',
				`type` INT(4) DEFAULT '1' COMMENT '输出单元的类型，默认是1.1是微博秀, 2是推荐用户列表, 3是话题',
				`skin` INT(4) DEFAULT '1' COMMENT '输出单元的样式皮肤,默认是1',
				`colors` INT(4) DEFAULT NULL COMMENT '输出单元的自定义样式',
				`show_title` TINYINT(3) DEFAULT '1' COMMENT '是否显示标题,默认是1, 1是显示, 0是不显示',
				`show_border` TINYINT(3) DEFAULT '1' COMMENT '是否显示边框,默认是1, 1是显示, 0是不显示',
				`show_logo` TINYINT(3) DEFAULT '1' COMMENT '是否显示logo,默认是1, 1是显示, 0是不显示',
				`add_time` INT(10) DEFAULT NULL COMMENT '添加时间',
				PRIMARY KEY (`id`)
				) ENGINE=MYISAM DEFAULT CHARSET=utf8 COMMENT='内容输出单元'";
		$ret = mysql_query($sql, $this->link);

		///更新sys_config wb_version版本号的值
		$sysConfigTable = $db_prefix.'sys_config';
		$sql = "UPDATE `$sysConfigTable` set `value` = '1.1.1' where `key` = 'wb_version'";
		$ret = mysql_query($sql, $this->link);

		return true;
	}
	
	/**
	 * 升级到2.0
	 *
	 */
	function action_db20($db_prefix) 
	{
		/// 先备份用户绑定表
		$usersTable = $db_prefix.'users';
		$sql_backup = backup_data_sql($this->link, $usersTable);	

		/// 覆盖安装
		create_db($this->db_host, $this->db_user, $this->db_passwd, $this->db_name);

		create_tables($this->db_host, $this->db_user, $this->db_passwd, $this->db_name, $db_prefix);

		init_site_data($this->db_host, $this->db_user, $this->db_passwd, $this->db_name, $db_prefix);

		/// 添加之前的用户绑定数据
		$this->link = @mysql_connect($this->db_host, $this->db_user, $this->db_passwd);
		mysql_select_db($this->db_name, $this->link);
		mysql_query('SET NAMES '.XWEIBO_DB_CHARSET, $this->link);
		$ret = mysql_query($sql_backup, $this->link);
		if (!$ret) {
			/// 错误日志
			install_log('sql: '.$sql_backup." \r\nerrno: ".mysql_errno($this->link)." \r\nerror: ".mysql_error($this->link));
		}
		mysql_close($this->link);

		return true;
	}

	/**
	 *
	 * 升级到2.1
	 *
	 */
	function action_db21($db_prefix)
	{
		// 清空广告表
		$table_ad = $db_prefix . 'ad';
		$sql = 'TRUNCATE ' . $table_ad;
		$rs = mysql_query($sql, $this->link);

		///更新表结构
		upgrade_tables($db_prefix, $this->link);

		$sql = 'UPDATE ' . $db_prefix . 'admin SET group_id=2';
		mysql_query($sql, $this->link);

		$sysConfigTable = $db_prefix.'sys_config';
		// 如果是2.0默认的认证图标，则替换
		$sql = 'UPDATE '. $sysConfigTable . ' SET `value`="img/logo/big_auth_icon.png" WHERE `key`="authen_big_icon" AND `value`="var/data/logo/big_auth_icon.png"' ;
		mysql_query($sql, $this->link);
		$sql = 'UPDATE '. $sysConfigTable . ' SET `value`="img/logo/small_auth_icon.png" WHERE `key`="authen_small_icon" AND `value`="var/data/logo/small_auth_icon.png"' ;
		mysql_query($sql, $this->link);
		///sys_config 添加wb_lang_type,xwb_strategy字段值
		$lang_type = getLangType();
		$sql = "INSERT INTO `$sysConfigTable` VALUES ('wb_lang_type','".$lang_type."',1),('xwb_strategy','',1),('sysLoginModel','0',1)";
		$ret = mysql_query($sql, $this->link);

		///更新sys_config wb_version版本号的值
		$sql = "UPDATE `$sysConfigTable` set `value` = '2.1' where `key` = 'wb_version'";
		$ret = mysql_query($sql, $this->link);

		// 插入推荐用户组
		$sql = 'INSERT INTO ' . $db_prefix. 'component_usergroups(`group_name`,`native`,`related_id`,`type`) VALUES("首页用户推荐(他们在微博)",1,NULL,0)';
		mysql_query($sql, $this->link);
		$group_id = mysql_insert_id($this->link);

		$sql = 'INSERT INTO ' . $db_prefix . 'component_users VALUES('.$group_id.',1076590735,1,"Xweibo官方","xweibo官方微博",165)';
		mysql_query($sql);

		$sql = 'INSERT INTO ' . $sysConfigTable . ' VALUES("xwb_login_group_id",' . $group_id . ',1 )';
		mysql_query($sql);

		mysql_close($this->link);

		return true;
	}
}
?>
