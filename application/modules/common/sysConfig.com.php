<?php
/**************************************************
*  Created:  2010-10-28
*
*  网站自定义配置项管理类
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/
class sysConfig {

	///初始值 
	var $options = array(   
							'rewrite_enable' 			=> '',					//Rewrite设置 0.不开启 1.开启
							'logo'	 					=> '',					//logo图标
							'logo_wap'					=> '',					//wap logo
							'logo_output'				=> '',					//输出模块logo
							'address_icon' 				=> '',					//网站地址图标			
							'login_way' 				=> '',					//登录方式 1.仅使用新浪帐号直接登录 2.仅使用原有站点帐号登录 3. 使用新浪帐号与原有站点帐号并存方式登录
							'third_code' 				=> '',					//网站第三方统计代码
							'site_record' 				=> '',					//网站备案信息代码
							'site_name' 				=> '',					//网站名称
							'head_link' 				=> '',					//页首链接
							'foot_link' 				=> '',					//页尾链接
							'default_skin'				=> '',					//默认皮肤
							'authen_type'				=> '3',					//用户认证方式 0.不显示认证信息 1.使用新浪认证 2.使用站点自定义认证 3.新浪与本站认证共存
							'authen_big_icon'			=> '',					//站点自定义认证大图标
							'authen_small_icon'			=> '',					//站点自定义认证小图标
							'authen_small_icon_title' 	=> '', 					//站点自定义认证小图标提示文字
							'skin_default'				=> '',					//默认皮肤设置
							'ad_header' 				=> '', 					//header广告代码
							'ad_footer' 				=> '', 					//footer广告代码
							'guide_auto_follow' 		=> '0', 				//登录引导自动关注开关
							'guide_auto_follow_id' 		=> '', 					//自动关注的用户列表ID
							'wb_version' 				=> WB_VERSION, 			//当前xweibo版本号
							PAGE_TYPE_SYSCONFIG 		=> PAGE_TYPE_DEFAULT, 	//当前模板类型
							HEADER_MODEL_SYSCONFIG 		=> '', 					//当前页头类型
							HEADER_HTMLCODE_SYSCONFIG	=> '', 					//自定义页头html代码
							'ad_setting' 				=> '', 					
							'xwb_discuz_url'			=> '',					// xweibo for discuz地址url
							'xwb_discuz_enable'			=> false,				// 是否连接xweibo for discuz
							'api_checking'				=> false,				// API是否在维护中
							'site_short_link'			=> '',					// 网站的短链设置
							'use_person_domain'			=> FALSE,				// 是否启用个性域名
							'microInterview_setting'	=> '',					// 在线访谈设置
							'microLive_setting'			=> '',					// 在线直播设置
							'open_user_local_relationship' => 0,				// 是否开启用户关系本地化
							'skin_custom'				=>'',					//自定义的默认皮肤
							'xwb_strategy'				=> 0,					// 审核策略
							'sysLoginModel'				=> 0,					// 首页模式
							'wb_lang_type'				=> 'zh_cn',				// 当前语言设置
							'default_use_custom'		=>'1',					//使用自定义的默认皮肤还是皮肤目录的默认值
							'xwb_login_group_id'		=> ''					//登录页的用户组id
						);	


	/**
	 * 保存用户配置信息
	 * @return bool|null
	 */
	function set(){
		
        $args = func_get_args();
		// 修改为可接受数组参数
		if (!is_array($args[0])) {
			$params = array($args[0] => isset($args[1])? $args[1] : '');
		} else {
			$params = $args[0];
		}

		$data = array();
		$db   = APP::ADP('db');
		foreach ($params as $key=>$value) {
			if (!isset($this->options[$key])) {
				return RST(false, '2110001', 'Set the option does not exist');
			}
			$data[] = '("' . $db->escape($key) . '","' . $db->escape($value) .'")';
		}
		
		$sql = 'REPLACE ' . $db->getTable(T_SYS_CONFIG) . '(`key`,`value`) VALUES' . implode(',', $data);
		$rst = $db->execute($sql);
		///删除缓存
		if ($rst) {
			DD('common/sysConfig.get');
		}
        return RST($rst);

	}

	/**
	 * 获取网站自定义配置信息
	 *
	 * @param string $key 如:rewrite_enable
	 * $key为空时取全部配置信息
	 * @return bool|null
	 */
	function get($key = null)
	{
		$db = APP :: ADP('db');
		$row = $db->query('SELECT * FROM ' . $db->getTable(T_SYS_CONFIG));

        foreach($row as $value) {
             $rs[$value['key']] = $value['value'];
        }
                
		if ($key) {
			$kvalue = isset($rs[$key]) ? $rs[$key] : false;
			return RST($kvalue);	
		}
		return RST($rs);
	}
}
?>
