<?php
/**
 * @file			userConfig.com.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-07-08
 * @Modified By:	heli/2010-11-15
 * @Brief			用户自定义配置项管理类
 */

class userConfig {

	///初始值 
	/// user_newfeed		有新微博显现方式
	/// user_newmsg			有未读新信息的显现方式
	/// user_page_wb		微博显示的条数 
	/// user_page_comment	评论显示的条数
	/// user_skin			用户皮肤设置
	/// new_followers		是否有新粉丝
	/// index_listId		我的首页的List ID
	var $options = array(
						'user_newfeed' 		=>	'',
						'user_newmsg' 		=>	'',
						'user_newnotice'	=>	'1',
						'user_page_wb' 		=>	50,
						'user_page_comment' =>	20,
						'user_skin'			=>	'',
						'wap_font_size'		=>	'1',
						'wap_show_pic'		=>	'1',
						'wap_page_wb'		=>	'10',
						'new_followers'		=>	0,
						'index_listId'		=>  ''
						);	


	/**
	 * 保存用户配置信息
	 *
	 * @param int $sina_uid
	 * @param string $values
	 * @return bool|null
	 */
	function set()
	{
		$sina_uid 	= USER::uid(); 
		$args 		= func_get_args();
		$args_num 	= count($args);
		
		if ($args_num > 1) 
		{
			$key = $args[0];	
			if (!isset($this->options[$key])) {
				return RST('', '2010001', 'Set the option does not exist'); 
			}
			
			$value 			= $args[1];
			$user_configs 	= V('-:userConfig');
			
			// 指定用户的配置
			if ( isset($args[2]))
			{
				$sina_uid 		= $args[2];
				$user_configs 	= $this->get(null, $sina_uid);
				$user_configs	= $user_configs['rst'];
			}
			
			$user_configs[$key] = $value;
			$values 			= json_encode($user_configs);
		} else {
			$values = json_encode($args[0]);	
		}
		
		if (empty($sina_uid) || empty($values)) {
			return RST('', '2010000', 'User_id or Options can not be empty'); 
		}

		///删除缓存
		DD('common/userConfig.get');
		$db = APP::ADP('db');
		$row = $db->query('SELECT * FROM ' . $db->getTable(T_USER_CONFIG) . ' WHERE sina_uid = '.$sina_uid);
		$data = array();
	   	$data['values'] = $values;
		if (empty($row)) {
			$data['sina_uid'] = $sina_uid;
			$ret = $db->save($data, '', T_USER_CONFIG);
		} else {
			$ret = $db->save($data, $sina_uid, T_USER_CONFIG, 'sina_uid');
		}

		if ($ret === false) {
			return RST('', '2010002', 'Update configuration fails'); 
		}
	}

	/**
	 * 获取用户自定义配置信息
	 *
	 * @param int $sina_uid
	 * @return bool|null
	 */
	function get($key = null, $sina_uid=false)
	{
		$sina_uid = $sina_uid===false ? USER::uid() : $sina_uid;
		if (empty($sina_uid)) {
			return RST($this->options); 
		}

		$db = APP :: ADP('db');
		$row = $db->query('SELECT * FROM ' . $db->getTable(T_USER_CONFIG) . ' WHERE sina_uid = '.$sina_uid);
		$values = array();
		if (!empty($row)) {
			$values = $row[0]['values']; 
			$values = json_decode($values, true);
			if ($values === false || !is_array($values) ) {
				$values = array();
			}
		} else {
			$values = $this->options;
		}

		if ($key) {
			$kvalue = isset($values[$key]) ? $values[$key] : false;
			return RST($kvalue);	
		}
		return RST($values);
	}
}
?>
