<?php
include('action.abs.php');
class setting_mod extends action{
	function setting_mod() {
		parent :: action();
	}

	/*
	* 上传logo
	*/
	function uploadLogo() {
		if ($this->_isPost()) {
			$file = V('f:logo');
			$state = 200;
			while ($file && $file['tmp_name']) {
				if ($file['size'] > 500 * 1024) {
					$state = '上传LOGO的大小不能超过500K';
					break;
				}
				$info = getimagesize($file['tmp_name']);
				if ($info[2] != 3) {
					$state = '上传的图片文件不为PNG格式，请重新选择';
					break;
				}
				if ($info[0] > 200 || $info[1] > 65) {
					$state = '上传的图片长宽(200x65)超过限制，请重新选择';
					break;
				}

				//上传文件
				$file_obj = APP::ADP('upload');
				$file_arr = explode('.', WB_LOGO_PREVIEW_FILE_NAME);
				if (!$file_obj->upload('logo', array_shift($file_arr), P_VAR_NAME, 'png')) {
					$state = '复制文件时出错,上传失败' . $file['tmp_name'] . '===' . P_VAR . WB_LOGO_PREVIEW_FILE_NAME;
					break;
				}
				//获取上传文件的信息
				$logo = $file_obj->getUploadFileInfo();
				break;			
			}
			//var_dump($logo);exit;
			echo '<script>parent.uploadFinished("' . $state. '","' . F('fix_url', $logo['savepath']).'?r='.rand() . '");</script>';
		}
	}
	
	/*
	* 上传地址图标
	*/
	function uploadIcon() {
		if ($this->_isPost()) {
			$file = V('f:address_icon');
			$state = 200;
			while ($file && $file['tmp_name']) {
				if ($file['size'] > 50 * 1024) {
					$state = '上传LOGO的大小不能超过500K';
					break;
				}
				$info = getimagesize($file['tmp_name']);
				if ($info[2] != 3) {
					$state = '上传的图片文件不为PNG格式，请重新选择';
					break;
				}
				if ($info[0] > 10 || $info[1] > 10) {
					$state = '上传的图片长宽(186x50)超过限制，请重新选择';
					break;
				}
				if (!move_uploaded_file($file['tmp_name'], P_VAR . WB_ICON_PREVIEW_FILE_NAME)) {
					$state = '复制文件时出错,上传失败' . $file['tmp_name'] . '===' . P_VAR . WB_ICON_PREVIEW_FILE_NAME;
					break;
				}
				$icon = W_BASE_URL . P_VAR_NAME .WB_ICON_PREVIEW_FILE_NAME;
				break;
			}
			echo '<script>parent.uploadFinished("' . $state. '","' . $icon . '");</script>';
		}
	}
	
	/*	
	* 站点设置提交
	*/
	function editIndex() {
		if ($this->_isPost()) {
			$file_logo = V('p:logo');
			$file_icon = V('p:address_icon');
			$logo = $icon = $logo_wap = $logo_output = '';
		
			if ($file_logo) {
				
				$image = APP::ADP('image');
				
				if(XWB_SERVER_ENV_TYPE == "sae") {
					$file_arr = explode('.', WB_LOGO_PREVIEW_FILE_NAME);
					$file_content = IO::read(array_shift($file_arr));
					$url = IO::write(P_VAR . WB_LOGO_FILE_NAME, $file_content);
					
					$logo = $url;
				}elseif(is_file(P_VAR . WB_LOGO_PREVIEW_FILE_NAME)) {
					$file_content = IO::read(P_VAR . WB_LOGO_PREVIEW_FILE_NAME);
					IO::write(P_VAR . WB_LOGO_FILE_NAME, $file_content);
					//小图处理
					$logo = P_VAR_NAME .WB_LOGO_FILE_NAME;
				}
				
				//wap 图片
				$image->loadFile($logo);
				$imageInfo = $image->getImgInfo();
				if($imageInfo['height']>35){
					$image->resize($imageInfo['width']*35/$imageInfo['height'],35);
					$rst=$image->save(P_VAR . WB_LOGO_WAP_FILE_NAME);
					if(XWB_SERVER_ENV_TYPE == "sae"){
						$logo_wap=$rst;
					}
					else{
						$logo_wap=P_VAR_NAME . WB_LOGO_WAP_FILE_NAME;	
					}
					
				}
				else{
					$logo_wap=$url;
				}
				
				//输出模块图片处理
				if($imageInfo['height']>18){
					$image->resize($imageInfo['width']*18/$imageInfo['height'],18);
					$rst=$image->save(P_VAR . WB_LOGO_OUTPUT_FILE_NAME);
					if(XWB_SERVER_ENV_TYPE == "sae"){
						$logo_output=$rst;
					}
					else{
						$logo_output=P_VAR_NAME . WB_LOGO_OUTPUT_FILE_NAME;
					}
				}
				else{
					$logo_output=$url;
				}
			}

			$data = array(
				'logo' 							=> $logo,											//logo图标
				'logo_wap' 						=> $logo_wap, 										//wap logo
				'logo_output' 					=> $logo_output, 									//output logo
				'address_icon' 					=> $icon,											//网站地址图标
				'third_code' 					=> V('p:third_code', ''),							//网站第三方统计代码
				'site_record' 					=> htmlspecialchars(trim(V('p:site_record', ''))),	//网站备案信息代码
				'site_name' 					=> htmlspecialchars(trim(V('p:site_name', ''))),	//网站名称
//				'wb_lang_type' 					=> trim( V('p:wb_lang_type', 'zh_cn') ),			//网站当前语言
				'sysLoginModel' 				=> trim( V('p:sysLoginModel', 0) ),					//登录模式
				'open_user_local_relationship' 	=> trim( V('p:local_relation', 0) )					// 是否开启本地关系
				);
				
			foreach($data as $key=>$value) {
				$result = DR('common/sysConfig.set', '', $key, $value);
				if($result['errno']) {
					$this->_error('配置失败',  array('editIndex'));
				}
			}
			$this->_succ('已经成功保存你的配置', array('editIndex'));
			exit;
		}
		
		$d = DR('common/sysConfig.get');
		if ($d['rst']) {
			TPL::assign('config', $d['rst']);
		}
		$this->_display('setting');
	}
	
	/*	
	* 优化设置
	*/
	function editRewrite() 
	{
		if ($this->_isPost()) 
		{
			// 校验，是apache服务器并且开启了rewrite module才保存成功
			if ( V('p:rewrite_way', '0') && !$this->_checkApacheReweite() ) {
				$this->_error('配置失败,Apache服务器没有开启rewrite模块',  array('editRewrite'));
			}
			
			$result = DR('common/sysConfig.set', '', 'rewrite_enable', V('p:rewrite_way', '0'));
			
			if($result['errno']) {
				$this->_error('配置失败',  array('editRewrite'));
			}

			$this->_succ('已经成功保存你的配置', array('editRewrite'));
			exit;
		}
		
		$d = DR('common/sysConfig.get');

		if ($d['rst']) {
			TPL::assign('config', $d['rst']);
		}
		$this->_display('optimization_setting');
	}	
	
	/*	
	* 用户登录管理
	*/
	function editUser() {
		if ($this->_isPost()) {			

			$result = DR('common/sysConfig.set', '', 'login_way', V('p:login_way', 1));	//登录方式1.仅使用新浪帐号直接登录 2.仅使用原有站点帐号登录 3。使用新浪帐号与原有站点帐号并存方式登录
			
			if($result['errno']) {
				$this->_error('配置失败',  array('editUser'));
			}

			$this->_succ('已经成功保存你的配置', array('editUser'));
			exit;
		}
		
		$d = DR('common/sysConfig.get');

		if ($d['rst']) {
			TPL::assign('config', $d['rst']);
		}
		$this->_display('login_setting');
	}

	/*
	* 获取页首页脚设置
	*/
	function getLink() {
		//获取页首设置
		$d = DR('common/sysConfig.get','','head_link');
		$head_link = json_decode($d['rst'],true);
		TPL::assign('head_link', $head_link);

		//获取页脚设置
		$d = DR('common/sysConfig.get','','foot_link');
		$foot_link = json_decode($d['rst'],true);
		TPL::assign('foot_link', $foot_link);

		$this->_display('header_setting');
	}

	/*
	* 根据id获取相应的链接数据
	*/
	function getLinkById() {
		$id = (int)V('g:id', 0);
		$action = V('g:action', '');
		
		if(!$id || !$action) {
			$this->_error('参数错误！',  array('getLink'));
		}
		
		//获取页首设置
		$d = DR('common/sysConfig.get','','head_link');
		$head_link = json_decode($d['rst'],true);

		//获取页脚设置
		$d = DR('common/sysConfig.get','','foot_link');
		$foot_link = json_decode($d['rst'],true);

		if($action == 'head') {
			$data = $head_link[$id];
		}

		if($action == 'foot') {
			$data = $foot_link[$id];
		}

		if($id) {
			APP::ajaxRst($data);
			exit;
		}

		TPL::assign('data', $data);
		$this->_display('header_setting');
	}

	/*
	* 编辑,添加页首页脚设置
	*/
	function editLink() {
		$action = V('p:action', '');
		$link = htmlspecialchars(V('p:link_address', ''));
		$name = htmlspecialchars(V('p:link_name', ''));
		$id = (int)V('p:id', 0);

		$d = DR('common/sysConfig.get','','head_link');
		$head_link = json_decode($d['rst'], true);
		$head_count = count($head_link);

		$d = DR('common/sysConfig.get','','foot_link');
		$foot_link = json_decode($d['rst'], true);
		$foot_count = count($foot_link);

		//判断链接地址是否以http开头
		$link = F('fix_url', $link, 'http://', 'http://');

		//添加,编辑首页链接
		if ($action == 'head') {
			//获取页首设置
			if(!$link || !$name) {
				$this->_error('链接名称或地址不能为空',  array('getLink'));
			}

			$data = array(
							'link_name' => $name,
							'link_address' => $link
					);
			
			if($id) {
				$head_link[$id] = $data;
			}else{
				if($head_count) {
					$head_link[] = $data;
				}else{
					$head_link[1] = $data;
				}
			}

			if(count($head_link) > 5) {
				$this->_error('页首链接数不能多于5个',  array('getLink'));
			}
			$result = DR('common/sysConfig.set', '', 'head_link', json_encode($head_link));
		}


		//添加,编辑页尾链接
		if ($action == 'foot') {
			//获取页首设置
			if(!$link || !$name) {
				$this->_error('链接名称或地址不能为空',  array('getLink'));
			}

			$data = array(
							'link_name' => $name,
							'link_address' => $link
					);

			if($id) {
				$foot_link[$id] = $data;
			}else{
				if($foot_count) {
					$foot_link[] = $data;
				}else{
					$foot_link[1] = $data;
				}
			}

			if(count($foot_link) > 5) {
				$this->_error('页尾链接数不能多于5个',  array('getLink'));
			}
			$result = DR('common/sysConfig.set', '', 'foot_link', json_encode($foot_link));
		}

		if($result['errno']) {
			$this->_error('配置失败',  array('getLink'));
		}

		$this->_succ('已经成功保存你的配置', array('getLink'));
		exit;
	}

	/*
	* 删除页首页脚设置
	*/
	function delLink() {
		$action = V('g:action', '');
		$id = (int)V('g:id', 0);

		$d = DR('common/sysConfig.get','','head_link');
		$head_link = json_decode($d['rst'], true);

		$d = DR('common/sysConfig.get','','foot_link');
		$foot_link = json_decode($d['rst'], true);

		if(!$id) {
			$this->_error('不能删除该项！',  array('getLink'));
		}

		if ($action == 'head') {
			unset($head_link[$id]);
			$result = DR('common/sysConfig.set', '', 'head_link', json_encode($head_link));
		}

		if ($action == 'foot') {
			unset($foot_link[$id]);
			$result = DR('common/sysConfig.set', '', 'foot_link', json_encode($foot_link));
		}

		if($result['errno']) {
			$this->_error('配置失败',  array('getLink'));
		}

		$this->_succ('已经成功保存你的配置', array('getLink'));
		exit;
	}
	
	
	
	function header()
	{
		// header model
		$rst = DR('common/sysConfig.get', FALSE, HEADER_MODEL_SYSCONFIG);
		TPL::assign('model', $rst['rst']);
		
		// header html code
		$rst = DR('common/sysConfig.get', FALSE, HEADER_HTMLCODE_SYSCONFIG);
		TPL::assign('headerHtml', $rst['rst']);
		
		$this->_display('setting_header');
	}
	
	
	function updateHeader()
	{
		// get var
		$url  = URL('mgr/setting.header');
		$data = V('p:data');
		
		// set db
		$model = DR('common/sysConfig.set', FALSE, HEADER_MODEL_SYSCONFIG, $data['model']);
		$customHeaderModel = 2;
		if ($customHeaderModel == $data['model']) {
			$model = DR('common/sysConfig.set', FALSE, HEADER_HTMLCODE_SYSCONFIG, $data['headerHtml']);
		}

		// show result message
		if ($model['rst']) {
			$this->_succ('操作成功', $url);
		}
		$this->_error('操作失败！', $url);
	}
	
	
	/**
	 * 设置网站的短链
	 */
	function setShortLink()
	{
		// 校验，是apache服务器并且开启了rewrite module才保存成功
		if ( $this->_isPost() && ($data=V('p:data')) && $data['config'] && !$this->_checkApacheReweite() ) {
			$this->_error('配置失败,Apache服务器没有开启rewrite模块',  array('setShortLink'));
		}
		
		$this->setConfig('site_short_link', URL('mgr/setting.setShortLink'), 'setting_shortlink');
	}
	
	
	/**
	 * 设置个性化域名
	 */
	function setPersonalDomain()
	{
		// 校验，是apache服务器并且开启了rewrite module才保存成功
		if ($this->_isPost() && ($data=V('p:data')) && $data['config'] && !$this->_checkApacheReweite() ) {
			$this->_error('配置失败,Apache服务器没有开启rewrite模块',  array('setPersonalDomain'));
		}
			
		$this->setConfig('use_person_domain', URL('mgr/setting.setPersonalDomain'), 'setting_domain');
	}
	
	
	/**
	 * Set Sysconfig
	 * 
	 * @param string $key
	 * @param url $url
	 * @param string $value
	 */
	function setConfig($key, $url, $tpl, $value='config')
	{
		// Update
		if ( V('p:doEdit') ) 
		{
			$data  = V('p:data');
			$value = trim( $data[$value] );
			
			// 短链不能设置为本host
			if ( $key=='site_short_link'){
				if ( $value && $value==$_SERVER['HTTP_HOST'] ) {
					$this->_error('短链不能设置为本站域名', $url);
				}
				$value = rtrim($value, '/\\');
				$value = F('fix_url', $value, '', 'http://');
			}
			
			$conf = DR('common/sysConfig.set', FALSE, $key, $value);
	
			// show result message
			if ($conf['rst']) {
				$this->_succ('操作成功', $url);
			}
			$this->_error('操作失败！', $url);
		}
		
		
		// Show View
		$rst = DR('common/sysConfig.get');
		TPL::assign('config', $rst['rst']);
		$this->_display($tpl);
	}
	/**
	  *  wap页面 
	  */
	function wap(){
		$this->_display('wap');
	}
	
	/**
	  *  数据备份 
	  */
	function dataBackup(){
		$this->_display('data_backup');
	}
	
	
	/**
	 * 在线访谈的设置
	 */
	function setInterView()
	{
		$this->setConfig('microInterview_setting', URL('mgr/setting.setInterView'), 'setting_interview');
	}
	
	
	/**
	 * 在线直播的设置
	 */
	function setMicroLive()
	{
		$this->setConfig('microLive_setting', URL('mgr/setting.setLive'), 'setting_microLive');
	}
	/**
	  *  后台自定义皮肤 
	  */
	function setSkin() {
		$json_array=array();
		$colors=V('p:colors',NULL);
		if($colors!=NULL){
			$json_array['colors']=$colors;
		}
		$bg=V('p:bg',NULL);
		if($bg!=NULL){
			$json_array['bg']=$bg;
		}
		$colorid=V('p:colorid',NULL);
		if($colorid!=NULL){
			$json_array['colorid']=$colorid;
		}
		$align=V('p:align',NULL);
		if($align!=NULL){
			$json_array['align']=$align;
		}
		$fixed=V('p:fixed',NULL);
		if($fixed!=NULL){
			$json_array['fixed']=$fixed;
		}
		$tiled=V('p:tiled',NULL);
		if($tiled==1){
			$json_array['tiled']=1;
		}
		$cs=V('p:custom_skin',json_encode($json_array));
		$rs = DR('common/sysConfig.set', '', 'skin_custom', $cs);
		if($rs['errno']==0){
			DR('common/sysConfig.set', '', 'default_use_custom', 1);
			APP::ajaxRst(TRUE);
		}
		else{
			APP::ajaxRst(FALSE,1,'系统自定义皮肤设置失败');
		}
		
		
	}
	
	
		/**
		*  背景图片上传 
		*/
	  function skinBGUpload(){
		if ($this->_isPost()) {
			///如何防止上传相同内容的图片？？？
			if(!USER::isUserLogin()){
				APP::ajaxRst(FALSE,610005, L('controller__setting__notLogin'));
				return;
			}
			else{
				$sina_uid=USER::uid();
			}
			$file = V('f:skinbg');
			$callback=V('g:callback');
			$state = 200;
			$maxSize = 2 * 1024 * 1024;
			$script='window.location="/js/blank.html?rand='.microtime().'";';
			while ($file && $file['tmp_name']) {
				if ($file['size'] > $maxSize) {
					APP::JSONP(FALSE,3040012, L('controller__setting__sizeLimit'),$callback,$script);
					break;
				}
				$info = getimagesize($file['tmp_name']);
				if ($info[2] != 3&&$info[2] != 2) {
					//APP::ajaxRst(FALSE,610003,'上传的图片文件不为PNG/JPG格式，请重新选择');
					APP::JSONP(FALSE,610003,L('controller__setting__uploadImgType'),$callback,$script);
					break;
				}
				//上传文件
				$file_obj = APP::ADP('upload');
				///以 md5 为名保存文件
				if (!$file_obj->upload('skinbg', WB_SKIN_BGIMG_UPLOAD_DIR . md5('admin#skin'), P_VAR_NAME, 'png,jpeg,jpg', $maxSize)) {
					APP::JSONP(FALSE,610007, L('controller__setting__copyImgError'),$callback,$script);
					break;
				}
				//获取上传文件的信息
				$skinBG = $file_obj->getUploadFileInfo();
				//return APP::ajaxRst(F('fix_url', $skinBG['webpath']));
				APP::JSONP(array('url'=>F('fix_url', $skinBG['webpath']) . '?_rand='.time()),0,'',$callback,$script);
				return;
			}
			if($file&&$file['tmp_name']==''&&$file['size']==0){
				APP::JSONP(FALSE,3040012, L('controller__setting__sizeLimit'),$callback,$script);
				return;
			}
			else{
				APP::JSONP(FALSE,610008, L('controller__setting__serverError'),$callback,$script);
				return;
			}
		}
		else{
			APP::ajaxRst(FALSE,610002,'');
		}
		
	  }
	
	
	
	/**
	 * 检查当前服务器是否Apache并开启了Rewrite模块
	 */
	function _checkApacheReweite()
	{
		if ( function_exists('apache_get_version') && apache_get_version() && function_exists('apache_get_modules') ) 
		{
			$apacheModuleList = apache_get_modules();
			if ( !in_array('mod_rewrite', $apacheModuleList) )
			{
				return FALSE;
			}
		}
		return TRUE;
	}
	
	
	/**
	 * 审核策略的设置
	 */
	function setStrategy()
	{
		// Update
		if ( $this->_isPost() ) 
		{
			// Build Data
			$data  				= V('p:data');
			$config				= array();
			$config['strategy'] = intval($data['strategy']);
			if ($config['strategy'])
			{
				$config['type'] = $data['type'];
				switch ( $config['type'] )
				{
					// 指定用户审核(黑名单)
					case 1:
						if ( isset($data['user']) && $data['user'] )
						{
							$nameList 	= explode('|', $data['user']);
							$blackList 	= F('get_user_show', implode(',', $nameList), FALSE, TRUE);
							if ( is_array($blackList['rst']) )
							{
								foreach ($blackList['rst'] as $aUser)
								{
									if ( isset($aUser['id']) && ($id=$aUser['id']) ) {
										$config['black'][$id] = $aUser['screen_name'];
									}
								}
							}
						}
					break;
						
						
					// 指定用户不审核(白名单)
					case 2:
						if ( isset($data['user']) && $data['user'] )
						{
							$nameList 	= explode('|', $data['user']);
							$whiteList 	= F('get_user_show', implode(',', $nameList), FALSE, TRUE);
							if ( is_array($whiteList['rst']) )
							{
								foreach ($whiteList['rst'] as $aUser)
								{
									if ( isset($aUser['id']) && ($id=$aUser['id']) ) {
										$config['white'][$id] = $aUser['screen_name'];
									}
								}
							}
						}
					break;
					
					
					// 全站
					default:
						// 开始时间
						if ( isset($data['start']) && $data['start'] )
						{
							$hour			 = isset($data['start_h']) ? $data['start_h'] : '';
							$config['start'] = strtotime("{$data['start']} $hour:00:00");
						}
						
						// 结束时间
						if ( isset($data['end']) && $data['end'] )
						{
							$hour			= isset($data['end_h']) ? $data['end_h'] : '';
							$config['end'] 	= strtotime("{$data['end']} $hour:00:00");
						}
						
						//关键字
						if ( isset($data['keyword']) )
						{
							$data['keyword'] = trim($data['keyword']);
							if ( $data['keyword'] || '0'===(string)$data['keyword'] ) 
							{
								$config['keyword'] 	= explode(',', $data['keyword']);
							}
						}
				}
			}
			
			$conf = DR('common/sysConfig.set', FALSE, 'xwb_strategy', json_encode($config));
	
			// show result message
			$url = $_SERVER['HTTP_REFERER'];
			if ($conf['rst']) {
				$this->_succ('操作成功', $url);
			}
			$this->_error('操作失败！', $url);
		}
		
		
		// Show View
		$config = json_decode( V('-:sysConfig/xwb_strategy'), TRUE );
		if ( isset($config['black']) ) 
		{
			$config['user']	= implode('|', array_values($config['black']) );
		}
		
		if ( isset($config['white']) ) 
		{
			$config['user']	= implode('|', array_values($config['white']) );
		}
		
		TPL::assign('config', $config);
		$this->_display('setting_strategy');
	}

	/**
	 * 清空缓存
	 *
	 */
	function cacheClear() {
		if ($this->_isPost()) {
			// 清空文件缓存
			if (XWB_SERVER_ENV_TYPE !== 'sae') {
				$rs = F('clearDir', P_VAR_CACHE);
				// 修改user_config.php中memcache前缀，以达到更新缓存目的
				$fn = P_ROOT. '/../user_config.php';
				$c = file_get_contents($fn);
				$c = F('set_define_value',$c, 'APP_FLAG_VER', date('mdHis'));
				$rs_f = file_put_contents($fn, $c);
				if ($rs && $rs_f) {
					APP::ajaxRst(true);
				}
			} else {// 如果是sae
/*
				// 修改memcache前缀，以达到更新缓存目的
				$storage = new SaeStorage();
				$content = $storage->read(CONFIG_DOMAIN, md5(CONFIG_DOMAIN));

				$config = array();
				parse_str($content, $config);
				$config['app_flag_ver'] = date('mdHis');
				$query = http_build_query($config);
				$storage->write(CONFIG_DOMAIN, md5(CONFIG_DOMAIN), $query);
				$key 	 = 'sae_set_global_define#'.CONFIG_DOMAIN;
				CACHE::delete($key);
*/
				CACHE::flush();
				APP::ajaxRst(true);
			}
			APP::ajaxRst(false);
		}
		$this->_display('cache_clear');
	}


}
?>
