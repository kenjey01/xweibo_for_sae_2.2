<?php
/**************************************************
*  Created:  2010-10-18
*
*  后台Action基类
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/
class action {
		var $userInfo = array();
		var $memu = array(); // 管理后台菜单
		var $menu_click_record = array(); // 用记点击记录

		/**
		 * 初始化菜单
		 */
		function _initMenu() {
			$this->menu = array(
				'home' => array('title' => '首页'),
				'system' => array('title' => '系统设置'),
				'ui' => array('title' => '界面管理'),
				'content' => array('title' => '内容管理'),
				'user' => array('title' => '用户管理'),
				'tools' => array('title' => '扩展工具')
			);

			$this->menu['home']['sub'] = array(
					array(
						'title' => '快捷方式',
						'sub' => array(
							array('title' => '首页', 'url' => array('mgr/admin.default_page')),
							array('title' => '聚焦图',			'url' =>array('mgr/plugins.config','id=2')),
							array('title' => '个人资料推广位',	'url' =>array('mgr/plugins.config','id=3')),
							array('title' => '通知',			'url' =>array('mgr/notice')),
							array('title' => '首次登录关注',	'url' =>array('mgr/plugins.config','id=4'))
							)
						),
					array(
						'title' => '最近使用',
						'sub' => array(
							)
						)
					);
			$this->menu['system']['sub'] = array(
					array(
						'title' => '基础设置',
						'sub' => array(
									array('title'=>'站点设置', 		'url' => array('mgr/setting.editIndex')),
									array('title'=>'优化设置',		'url' => array('mgr/setting.editRewrite')),
									array('title'=>'帐号登录设置',	'url' => array('mgr/setting.editUser')),
									array('title'=>'个性化域名',	'url' => array('mgr/setting.setPersonalDomain')),
									array('title' => '代理帐号设置', 'url' => array('mgr/proxy_account.accountList')),
									array('title' => '清除缓存', 'url' => array('mgr/setting.cacheClear'))
									//array('title'=>'短链接',		'url' => array('mgr/setting.setShortLink'))
									//array('title'=>'数据备份',		'url' => array('mgr/setting.dataBackup'))
									)
						),
					array(
						'title' => '外部设置',
						'sub' => array(
							//array('title' => 'WAP设置',				'url' => array('mgr/setting.wap')),
							array('title' => '与论坛插件通信',		'url' => array('mgr/connection'))
							)

						),
					array(
						'title' => '管理员',
						'sub' => array(
							array('title' => '管理员设置',			'url' => array('mgr/admin.userlist')),
							array('title' => '添加管理员',			'url' => array('mgr/admin.search')),
							array('title' => '修改密码',				'url' => array('mgr/admin.repassword'))
							)
						)
					);
					
			if (XWB_SERVER_ENV_TYPE!=='sae'){
				$this->menu['system']['sub'][0]['sub'][] = array('title'=>'短链接',		'url' => array('mgr/setting.setShortLink'));
				$this->menu['system']['sub'][0]['sub'][] = array('title'=>'数据库备份还原',		'url' => array('mgr/backup.backupData'));
			}
/*
			// 只有超级管理员才能添加管理员
			$admRst = DR('mgr/adminCom.getAdminById', FALSE, $this->_getUid());	//获取当前操作者的数据
			//if( $admRst['rst']['is_root'] ) 
			if(USER::get('isAdminAccount') == 1) 
			{
				array_unshift($this->menu['system']['sub'][2]['sub'], array('title'=>'管理员设置', 'url'=>array('mgr/admin.userlist')));
				array_unshift($this->menu['system']['sub'][2]['sub'], array('title'=>'添加管理员', 'url'=>array('mgr/admin.search')));
			}
*/
/*
			$this->menu['system']['sub'] = array(
					array(
						'title' => '基础设置',
						'sub' => array(
									array('title' => '站点设置',			'url' =>array('mgr/setting.editIndex')),
									array('title' => '优化设置',	'url' =>array('mgr/setting.editRewrite')),
									array('title' => '账号登陆设置',	'url' =>array('mgr/setting.editUser')),
									array('title' => '首次登录关注',	'url' =>array('mgr/plugins.config','id=4'))
									)
					)
				);
*/
			$this->menu['ui']['sub'] = array(
							array(
								'title' => '界面',
								'sub' => array(
									array('title' => '布局',		'url' => array('mgr/page_nav')),
									array('title' => '导航',		'url' => array('mgr/page_nav.nav')),
									array('title' => '皮肤',		'url' => array('mgr/skin.getAllSkin')),
									array('title' => '广告',		'url' => array('mgr/ad.ad_list')),
									array('title' => '页头设置',	'url' => array('mgr/setting.header'))
									)
								),
							array(
								'title' => '页面模块',
								'sub' => array(
									array('title' => '页面设置',	'url' => array('mgr/page_manager'))
									)
								)
							);

			$this->menu['content']['sub'] = array(
							array(
								'title' => '内容',
								'sub' => array(
									array('title' => '内容审核',		'url' => array('mgr/weibo/disableWeibo.verifyWeiboList')),
									array('title' => '内容屏蔽',		'url' => array('mgr/weibo/disableComment.search')),
									//array('title' => '已屏蔽的评论',		'url' => array('mgr/weibo/disableComment.commentList')),
									//array('title' => '已屏蔽的微博',		'url' => array('mgr/weibo/disableWeibo.weiboList')),
									//array('title' => '话题',		'url' => array('mgr/weibo/todayTopic.category')),
									array('title' => '意见反馈',	'url' => array('mgr/feedback.getList')),
									)
								),
							array(
								'title' => '屏蔽过滤',
								'sub' => array(
									array('title' => '关键字过滤',	'url' => array('mgr/weibo/keyword.add'))
									)
								),
							array(
								'title' => '活动',
								'sub' => array(
									array('title' => '活动管理', 	'url' => array('mgr/events.getList'))
									)
								),
							array(
									'title' => '通知',
									'sub' => array(
										array('title' => '通知',	'url' => array('mgr/notice'))
										)
								 ),
							array(
									'title' => '扩展设置',
									'sub' => array(
										array('title' => '页头页脚链接',	'url' => array('mgr/setting.getlink')),
										array('title' => '个人资料推广',	'url' => array('mgr/plugins.config', 'id=3')),
										array('title' => '我的首页聚焦位',	'url' => array('mgr/plugins.config', 'id=2'))
										)
								 )
					 );

			$this->menu['user']['sub'] = array(
							array('title' => '用户',
								'sub' => array(
									array('title' => '用户管理',		'url' => array('mgr/users.search')),
									array('title' => '用户组管理',		'url' => array('mgr/user_recommend.getReSort')),
									array('title' => '禁止用户',		'url' => array('mgr/users.userAction')),
									)
								),
							array(
								'title' => '名人 - 认证',
								'sub' => array(
									array('title' => '认证管理',		'url' => array('mgr/user_verify.search')),
									array('title' => '名人管理',		'url' => array('mgr/celeb_mgr.starCatList')),
									)
								)
							);

			$this->menu['tools']['sub'] = array(
				array('title' => '整合工具',
					'sub' => array(
						array('title' => '转发按钮', 'url' => array('mgr/share')),
						array('title' => '站外调用', 'url' => array('mgr/content_unit'))
					)
				),
				array('title' => '扩展应用',
					'sub' => array(
						array('title' => '在线直播', 'url' => array('mgr/wb_live')),
						array('title' => '在线访谈', 'url' => array('mgr/micro_interview'))
					)
				)
			);

			arsort($this->menu_click_record);
			// 添加常用功能子菜单
			$max = 5;
			$n = 0;
			if (isset($this->menu_click_record) && is_array($this->menu_click_record)) {
				foreach ($this->menu_click_record as $path => $count) {
				//for ($i=0,$count=count($this->menu_click_record); $i<$count; $i++) {
					$index = explode('/', $path);
					if (!isset($this->menu[$index[0]]['sub'][$index[1]]['sub'][$index[2]])) {
						continue;
					}
					if(!in_array($this->menu[$index[0]]['sub'][$index[1]]['sub'][$index[2]],$this->menu['home']['sub'][1]['sub'])){
						$this->menu['home']['sub'][1]['sub'][] = $this->menu[$index[0]]['sub'][$index[1]]['sub'][$index[2]];	
					}
					$n++;
					if ($n >= $max) {
						break;
					}
					//var_dump($this->menu['home']['sub'][0]['sub']);
				}
			}
		}

		function _recordClick() {
			$cache_name = 'menu_click_record';

			$record = CACHE::get($cache_name);
			if (!$record || !is_array($record)) {
				$record = array();
			}

			$menu_path = V('g:router', false);
			// 如果要记录菜单点击
			if ($menu_path) {
				$record[$menu_path] =	isset($record[$menu_path])? $record[$menu_path] +1:1;
			}
			CACHE::set($cache_name, $record);
			$this->menu_click_record = $record;
		}

		function action() {
			Xpipe::usePipe(false);
			$this->_recordClick();
			$this->_initMenu();
			$ajax = V('g:ajax', false);
			//判断用户是否登录			
			if (!USER::isUserLogin()) {
				if ($ajax) {
					//APP::ajaxRst(false, '-1', '用户未登录');
					exit('{"state":"403", "msg":"您未登录！"}');
				}
				$jumpAct = V('-:sysConfig/login_way', 1)*1 == 2 ? 'account.siteLogin' : 'account.sinaLogin'; 
				exit('<script>window.top.location.href = "' . URL($jumpAct,'cb=login&loginCallBack=' . urlencode(URL('mgr/admin.login', '', 'admin.php')), 'index.php'). '"</script>');
				//APP :: redirect(URL('account.gloCheckLogin', '', 'index.php'), 3);
			}

			//判断管理员是否登录
			if (!$this->_isLogin() && !($this->_getModule() == 'admin' && in_array($this->_getAction() , array('login', 'authcode')) )) {
				if ($ajax) {
					APP::ajaxRst(false, '-2', '管理员未登录');
				}
				exit('<script>window.top.location.href = "' . URL('mgr/admin.login', '', 'admin.php'). '"</script>');
				//APP :: redirect(URL('mgr/admin.login', 'admin.php'), 3);
			}
			// 除登录，拿出和取验证码外，其它页面都要进行功能控制
			if (!in_array($this->_getAction() , array('login', 'authcode', 'logout')) && !$this->_isAllowAccess(USER::aid())) {
				if ($ajax) {
					APP::ajaxRst(false, '-3', '没有访问权限');
				}
				exit('没有访问权限');
			}
			TPL :: assign('admin_root', $this->_getUserInfo('__CLIENT_ADMIN_ROOT'));
			TPL :: assign('real_name', $this->_getUserInfo('screen_name'));
			TPL :: assign('admin_id', $this->_getUid());
			
		}
		
		/**
		 * 是否允许访问
		 * @param $uid int 管理员用户id
		 * @param $router string 路由
		 * @return boolean true表示为允许
		 */
		function _isAllowAccess($uid, $router=null) {
			$permissions = $this->_getPermissions($uid);
			if (!$permissions || !is_array($permissions)) {
				return false;
			}
			if ($router === null) {
				$r = APP::getRuningRoute(false);
			} else {
				$r = $router;
			}
			foreach ($permissions as $p) {
				if (preg_match('#' . $p . '#', $r)) {
					return true;
				}
			}
			return false;
		}

		/**
		 * 得到用户权限
		 * @param $uid int 管理员id
		 * @return array
		 */
		function _getPermissions($uid) {
			static $permissions = array();
			if (isset($permissions[$uid])) {
				return $permissions[$uid];
			}
			//@todo 缓存权限信息
			//@todo 得到用户所属组
			$rs = DS('mgr/adminCom.getAdminById','' ,$uid);
			if (empty($rs)) {
				return false;
			}
			$group_id = $rs['group_id'];
			
			//@todo 得到用户所属组权限
			$rs = DS('mgr/adminCom.getGroupInfo','' ,$group_id);
			if ($rs && isset($rs['permissions']) && !empty($rs['permissions'])) {
				return $permissions[$uid] = explode(',', $rs['permissions']);
			}
			return false;
		}

		/**
		 * 得到当前用户可以访问的菜单
		 * @param $uid int
		 * @return Array
		 */
		function _getUserMenu($uid) {
			$user_menu = array();
			foreach($this->menu as $key =>$main) {
				$m_menu = array();
				foreach ($main['sub'] as $m) {
					$s_menu = array();
					foreach ($m['sub'] as $s) {
						$router = $s['url'][0];

						if ($this->_isAllowAccess($uid, $router)) {
							$s_menu[] = $s;
						}
					}
					if (!empty($s_menu)) {
						$m_menu[] = array(
								'title' => $m['title'],
								'sub' => $s_menu
								);
					}
				}
				if (!empty($m_menu)) {
					$user_menu[$key] = array(
							'title' => $main['title'],
							'sub' => $m_menu
							);
				}
			}
			return $user_menu;
		}

		/**
		 * 用户是否已登录
		 */
		function _isLogin() {
			return USER::isAdminLogin();
		}

		/**
		 * 得到当前登录用户ID
		 * @return int
		 */
		function _getUid() {
			return USER::aid();
		}

		/**
		 * 得到登录用户信息
		 */
		function _getUserInfo($key = '') {
			return USER::get($key);
		}

		/**
		 * 得到控制器名称
		 * @return string
		 */
		function _getController() {
				$router_str = APP::getRuningRoute(true);
				return trim($router_str['path'], '/\\');
		}

		/**
		 * 得到模块名称
		 * @return string
		 */
		function _getModule() {
				$router_str = APP::getRuningRoute(true);
				return $router_str['class'];
		}

		/**
		 * 复到action名称
		 * @return string
		 */
		function _getAction() {
				$router_str = APP::getRuningRoute(true);
				return $router_str['function'];
		}

		/**
		 * 跳转
		 */
		function _redirect($action, $module = false, $controller = false) {
			if (!$action) {
				return;
			}
			$module = $module ? $module : $this->_getModule();
			$controller = $controller ? $controller : $this->_getController();
			$path = $controller . '/' . $module . '.' . $action;
			header('Location:' . APP::mkModuleUrl($path, '', 'admin.php'));
			exit;
		}

		/**
		 * 当前请求方法
		 */
		function _requestMethod() {
			return $_SERVER['REQUEST_METHOD'];
		}

		/**
		 * 操作成功后跳转
		 * @param $msg String 要显示的消息
		 * @param $url String|Array 显示消息3秒后跳转的地址,如果该参数为数据则为路由方式,其中下标为0表示action,1表示module,2表示controller,
		 * @param $data mixed json数据，如果设置该值，则以json方式输出
		 */
		function _succ($msg, $url = null, $data=null) {
			if ($data !== null) {
				APP::ajaxRst($data);
			}
			if (is_array($url)) {
				if (empty($url[0])) {
					APP :: tips(array('msg'=> $msg, 'tpl' => 'error', 'baseskin'=>false));
				}
				$module = isset($url[1]) ? $url[1]: $this->_getModule();;
			TPL :: assign($this->userInfo);

				$controller = isset($url[2]) ? $url[2] : $this->_getController();
				$url = URL( $controller . '/' . $module . '.' . $url[0]);
			}
			if (!$url) {
				APP :: tips(array('msg'=> $msg, 'tpl' => 'error','baseskin'=>false));
			}
			
			// 成功后直接调整，不出现成功提示页面, 2011-05-20
			//APP :: tips(array('msg'=> $msg, 'tpl' => 'mgr/success', 'timeout'=>3, 'location' => $url, 'baseskin'=>false));
			APP::redirect($url, 3);
		}

		/**
		 * 操作成功后跳转
		 * @param $msg String 要显示的消息
		 * @param $url String|Array 显示消息3秒后跳转的地址,如果该参数为数据则为路由方式,其中下标为0表示action,1表示module,2表示controller,
		 * @param $errno int 如果设置该参数，则返回json结果
		 */
		function _error($msg, $url = null, $errno=null) {
			if ($errno !== null) {
				APP::ajaxRst(false, $errno, $msg);
			}
			if (is_array($url)) {
				if (empty($url[0])) {
					APP :: tips(array('msg'=> $msg, 'tpl' => 'error', 'baseskin'=>false));
				}
				$module = isset($url[1]) ? $url[1]: $this->_getModule();
				$controller = isset($url[2]) ? $url[2] : $this->_getController();
				$url = URL( $controller . '/' . $module . '.' . $url[0]);
			}

			$param = array(
						'msg'=> $msg,
						'tpl' => 'mgr/error',
						'baseskin'=>false
					);

			if ($url) {
				$param += array(
					'timeout'=>3,
					'location' => $url
				);
			}
			APP :: tips($param);
		}

		/**
		 * 当前请求是否为POST方法
		 */
		function _isPost() {
			if (strtolower($this->_requestMethod()) == 'post') {
				return true;
			}
			return false;
		}

		/**
		 * 当前请求是否为GET方法
		 *
		 */
		function _isGet() {
			if (strtolower($this->_requestMethod()) == 'get') {
				return true;
			}
			return false;
		}

		function _display($tpl) {
			$adminNotShowNav = V('-:adminNotShowNav');
			TPL::assign('adminNotShowNav', $adminNotShowNav[PAGE_TYPE_CURRENT]);
			TPL :: display('mgr/' . $tpl, '', 0, false);
		}

		/**
		 * 上传图片
		 *
		 * @param array $config array('field_name' => string, 'upload_path' => string, 'allowed_types' => string, 'thumb' => bool)
		 * 输出json
		 */
		function _upload_pic($config){
			extract($config);
			$field_name = empty($field_name) ? 'pic' : $field_name;
			$allowed_types = empty($allowed_types) ? 'jpg,jpeg,gif,png' : $allowed_types;

			$callback = V('g:callback','');
			$redirect = 'window.location="'.W_BASE_URL.'js/blank.html?rand='.rand(1,PHP_INT_MAX) . '"';
			if(isset($_FILES[$field_name])){
				$f_upload = APP::ADP('upload');
				$fileName = $f_upload->getName();
				if($f_upload->upload($field_name,	$fileName ,P_URL_UPLOAD.'/'.$upload_path.'/', $allowed_types,1)){
					$fileInfo = $f_upload->getUploadFileInfo();
					if ($fileInfo['errcode']) {
						die("<script language=\"javascript\">$callback(".APP::ajaxRst(false, '30'.$fileInfo['errcode'], $fileInfo['errmsg'], true).");$redirect</script>");
					}
					//缩小图片
					if ($thumb) {
						$image = APP::ADP('image');
						if (strtolower(IMAGE_ADAPTER)==='sae'){
							$image->loadFile($fileInfo['webpath']);
							$imageInfo = $image->getImgInfo();
							if($imageInfo['width']>120 || $imageInfo['height']>120){
								$image->resize(120,120);
								$image->save($fileName);
							}
						}else{
							$image->loadFile($fileInfo['savepath']);
							$imageInfo = $image->getImgInfo();
							if($imageInfo['width']>120 || $imageInfo['height']>120){
								$image->resize(120,120);
								$image->save($fileInfo['savepath']);
							}
						}
					}

				}else{
					$errno = '3040050';
					if ($f_upload->getErrorCode()){
						$errno = '30'.$f_upload->getErrorCode();
					}
					die("<script language=\"javascript\">$callback(".APP::ajaxRst(false,$errno, $f_upload->getErrorMsg(), true).");$redirect</script>");
				}

			} else {
				die("<script language=\"javascript\">$callback(".APP::ajaxRst(false, '1010000', 'Parameter can not be empty', true).");$redirect</script>");
			}

			$json = array();
			$result['pic'] = $fileInfo['webpath'];
			if (strtolower(IMAGE_ADAPTER)==='sae') {
				$result['filepath'] = $fileInfo['webpath'];
			} else {
				$result['filepath'] = F('fix_url', $fileInfo['savepath']);
			}

			die("<script language=\"javascript\">$callback(".APP::ajaxRst($result, 0, '', true).");$redirect</script>");
		}

		/**
		 * 批量获取用户信息
		 */
		function _getUserBatchShow()
		{
			$names 		= V('p:names');
			$nameList 	= explode(',', $names);
			$countId 		= count($nameList);
			$result		= array();
			
			if ($countId > 0) 
			{
				//批量获取, 目前最多支持20个人,超过20个人, 分组调用批量接口
				if ($countId > 20) 
				{
					$pageCnt = ceil($count/20);
			
					for ($p=1; $p <=$pageCnt; $p++) 
					{
						$offset = ($p-1) * 20;
						$nameList = array_slice($nameList, $offset, 20);
						$rspTmp = DR('xweibo/xwb.getUsersBatchShow', FALSE, array(), $nameList);
						if (!empty($rspTmp['errno'])) {
							continue;
						}
						$result = array_merge($result, $rspTmp['rst']);
					}
				} 
				else {
					$rspTmp = DS('xweibo/xwb.getUserShow', FALSE, '', '', $nameList);
					$result = $rspTmp;
				}
			} 

			APP::ajaxRst($result);
		}
}
