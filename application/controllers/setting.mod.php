<?php
/**
 * @file			set.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	heli/2010-11-15
 * @Brief			个人设置控制器-Xweibo
 */

class setting_mod {

	var $uInfo	= false;
	var $cfg	= array();
	var $avatarTemp = '';
	var $avatarPath = '';

	function setting_mod(){

		$this->avatarPath	= 'avatarTemp/'.date("Y_m/d/H");
		$this->avatarTemp	= W_BASE_URL.P_URL_UPLOAD.'/'.$this->avatarPath;

		$this->cfg		= array(
			'upload_path'	=> $this->avatarPath,
			'allowed_types' => 'jpg|gif|jpeg|png',
			'max_size'	=> 5*1024*1024);
	}

	/// 默认 ACTION
	function default_action(){
		//$this->profile();
		if (HAS_DIRECT_UPDATE_PROFILE) {
			$this->user();
		} else {
			$this->tag();
		}
	}

	/// 个人资料设置
	function user() {
		if (!HAS_DIRECT_UPDATE_PROFILE) {
			APP::redirect('setting.tag', 2);
		}
		APP::setData('page', 'setting.user', 'WBDATA');
		TPL::display('setting_base');	
	}

	/// 头像设置
	function myface() {
		if (!HAS_DIRECT_UPDATE_PROFILE_IMAGE) {
			APP::redirect('setting.tag', 2);
		}
		$uInfo = DR('xweibo/xwb.getUserShow', '', USER::uid());
		$uInfo = $uInfo['rst'];

		//print_r(V('s'));exit;
		$uData = array();
		$uData['edit_tab']	= V('g:edit', 'info');
		$uData['avatar']	= APP::F('profile_image_url', $uInfo['profile_image_url'], 'profile');
		$uData['sina_uid']	= $uInfo['id'];
		$uData['nick']		= $uInfo['screen_name'];
		$uData['gender']	= $uInfo['gender'];
		$uData['province']	= $uInfo['province'];
		$uData['city']		= $uInfo['city'];
		$uData['description']	= $uInfo['description'];
		$uData['_uploadPicApi']	= urlencode(URL('setting.upload'));
		$uData['_savePicApi']	= urlencode(URL('setting.saveAvatar'));
		//print_r($uData);exit;
		APP::setData('page', 'setting.myface', 'WBDATA');
		TPL::assign('U', $uData);
		TPL::display('setting_modify_head');
	}

	/// 显示设置
	function show() {
		APP::setData('page', 'setting.show', 'WBDATA');
		TPL::display('setting_display');
	}

	/// 标签设置
	function tag() {
		APP::setData('page', 'setting.tag', 'WBDATA');

		//TPL::assign('taglist', $taglist['rst']);
		//TPL::assign('tagsuglist', $tagsuglist['rst']);
		TPL::display('setting_tags');
	}

	/// 提醒设置
	function notice() {
		//$notice = DR('xweibo/xwb.getNotice');

		APP::setData('page', 'setting.notice', 'WBDATA');

		//TPL::assign('notice', $notice['rst']);
		TPL::display('setting_notice');
	}

	/// 隐私设置
	function privacy() {
		TPL::display('setting_privacy');
	}

	/// 黑名单设置
	function blacklist() {
		//$blacklist = DR('xweibo/xwb.getBlocks');
		//$blacklist = $blacklist['rst'];

		APP::setData('page', 'setting.blacklist', 'WBDATA');

		//TPL::assign('blacklist', $blacklist);
		TPL::display('setting_blacklist');
	}

	/// 帐号设置
	function account() {
		APP::setData('page', 'setting.account', 'WBDATA');
		TPL::display('setting_account');
	}

	/// 个人资料编辑
	function profile(){
		$uInfo = DR('xweibo/xwb.getUserShow', '', USER::uid());

		//print_r(V('s'));exit;
		$uData = array();
		$uData['edit_tab']	= V('g:edit', 'info');
		$uData['avatar']	= APP::F('profile_image_url', $uInfo['profile_image_url'], 'profile');
		$uData['sina_uid']	= $uInfo['id'];
		$uData['nick']		= $uInfo['screen_name'];
		$uData['gender']	= $uInfo['gender'];
		$uData['province']	= $uInfo['province'];
		$uData['city']		= $uInfo['city'];
		$uData['description']	= $uInfo['description'];
		$uData['_uploadPicApi']	= urlencode(URL('setting.upload'));
		$uData['_savePicApi']	= urlencode(URL('setting.saveAvatar'));
		//print_r($uData);exit;
		TPL::assign('U', $uInfo['rst']);
		TPL::display('setting_base');
	}
	function flashURL(){
		$url = V('g:url');
		$url = base64_decode($url);
		echo file_get_contents($url);
	}
	/// 图像更改步骤1<#sae#>
	function upload() {

		//if (1) {print_r(V('p'));print_r(V('f'));}
		$this->_chkUid();

		$r = array('w'=>180,'h'=>180, 'url'=>'');
		
		$uploadObj = APP::ADP('upload');
		$fileName = $uploadObj->getName();
		$uploadObj->upload('avatarFile',$fileName);
		$rst = $uploadObj->getUploadFileInfo();
		if ($rst['errcode'] != 0) {
			APP::ajaxRst(false, 40002, $rst['errmsg']); exit;
		}else{
			if (strtolower(XWB_SERVER_ENV_TYPE)==='sae'){
				$saeimg = APP::ADP('image');
				$saeimg->loadFile($rst['webpath']);
				$imgInfo = $saeimg->getImgInfo();
				if ($imgInfo['width'] > 1024) {
					$saeimg->resize(1024,0,true);
					$saeimg->save($fileName);
				}else if($imgInfo['height'] > 1024){
					$imgObj->resize(0,1024,true);
					$imgObj->save($fileName);
				}
				$r['url'] = URL('setting.flashURL','url='.base64_encode($rst['webpath']));
			}else{
				$pImg = $rst['savepath'];
				if ( !$this->_chkImgType($pImg) ){
					APP::ajaxRst(false, 40010, 'Bad img type!'); exit;
				}
	
				$imgObj = APP::N('images');
				$imgObj->loadFile($pImg);
				$imgInfo = $imgObj->getImgInfo();
				if ($imgInfo['width'] > 1024 || $imgInfo['height'] > 1024 ) {
					$imgObj->resize(1024,1024,true);
					$imgObj->save($pImg);
				}
				$r['url'] = $rst['webpath'];
			}
			/**/
			APP::ajaxRst($r); exit;
		}
	}

	function _chkImgType($p){
		$ext	= strtolower(end(explode('.', $p)));
		$imtT	= getimagesize($p);
		$rExt	= trim(strtolower(end(explode('/',$imtT['mime'] ))));

		if ($rExt=='jpeg') $rExt='jpg';
		if ($ext=='jpeg')  $ext='jpg';
		return $rExt === $ext;
	}

	/// 图像保存 更新到微博<#sae#>
	function saveAvatar(){
		$this->_chkUid();
		$imgData = V('p:uploadField');
		if (strtolower(XWB_SERVER_ENV_TYPE)==='sae'){
			$avatarFile = 'avatar_tmp_'.$this->uInfo['sina_uid'];
			file_put_contents(SAE_TMP_PATH.$avatarFile,base64_decode($imgData));
	
			$rst = DS('xweibo/xwb.updateProfileImage', '', SAE_TMP_PATH.$avatarFile);
		}else{
			$avatarFile = P_VAR_UPLOAD.'/'.$this->avatarPath.'/avatar_tmp_'.$this->uInfo['sina_uid'].'.jpg';
			IO::write($avatarFile, base64_decode($imgData));
			$rst = DS('xweibo/xwb.updateProfileImage', '', $avatarFile);
		}
		//$this->_chkApiRst($rst, 40050);
		APP::ajaxRst(true);exit;
		
		
		
	}
	

	/// 用户ID检验
	function _chkUid(){
		if ( !V(V_FLASH_PHPSESSID, false) || !USER::isUserLogin() ){
			APP::ajaxRst(false, 40003, 'UID confirm error ');exit;
		}
	}

	/// 检查API结果 如果有错误直接退出 , 并输出错误代码
	function _chkApiRst($v, $err_code=0){
		if (!is_array($v) || !empty($v['error_code']) || !empty($v['error'])) {
			APP::ajaxRst(false, $err_code, $v['error_code'].":".$v['error']);
			exit;
		}
	}
	

	  
	/**
	  *  皮肤设置和获取
	  *  post：设置的登录用户的样式，返回样式
	  *  get：有预览样式文件
	  *  无参数的get，获取登录用户的默认样式
	  */
	function setSkin() {
		  ///todo
		  //6个色块、一个背景图、背景图三个属性
		$skin_id = trim(V('p:skin_id'));
		if(is_numeric($skin_id)){
			$rs = DS('common/userConfig.set', '', 'user_skin', $skin_id);
			APP::ajaxRst(TRUE);
		}
		else{
			//p:custom_skin is json obj:
			//{bg:url,tiled:bool,fixed:bool,align:1|2|3,color:[c1,c2,c3,c4,c5,c6]}
			//cn is #333444 like string
			//only cn is required
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
			
			//$cs='{"colors":"#066664,#134333,#233333,2,#433333,#533333","bg":"http://demo.xweibo.cn/img/skinbg/6c9964624f003470f23399da453f098c.jpg","tiled":1,"fixed":1,"align":1}';//166
			//$a=strlen($cs);
			
			if($cs!=NULL){
				$customSkin=json_decode($cs,TRUE);
				$customSkin['colors']=explode(',',$customSkin['colors']);
				
				///这里数据库字段可能需要修改成合适的长度
				$rs = DS('common/userConfig.set', '', 'user_skin', $cs);
				DD('common/userConfig.get');
				APP::ajaxRst(TRUE);
				//TPL::assign('customSkin',$customSkin);
				//TPL::display('customSkin');	
			}
			
		}
		
	}
	/**
	  *  动态获取皮肤 
	  */
	function getSkin(){
		//获取所有参数
		$preview=V('g:preview',FALSE);
		$sina_uid=V('g:id',FALSE);
		$usesys=V('g:sys',FALSE);//使用系统的自定义皮肤
		if($preview||$sina_uid||$usesys){
			if($preview){
				$customSkin=F('parse_skin',$preview);		
			}
			elseif($sina_uid){
				$skin_rst = DR('common/userConfig.get', '', 'user_skin', $sina_uid);
				$customSkin=json_decode($skin_rst['rst'],TRUE);
				$customSkin['colors']=explode(',',$customSkin['colors']);
			}
			elseif($usesys){
				$default_custom_skin=USER::sys('skin_custom');
				$customSkin=json_decode($default_custom_skin,TRUE);
				$customSkin['colors']=explode(',',$customSkin['colors']);
			}
			//TPL::assign('customSkin',$customSkin);
			//TPL::display('customSkin');
			
			$customSkin['lang_opt'] = APP::getLang();
			//暂时不使用默认的模板引擎
			APP::redirect( W_BASE_URL . 'css/default/skin_define/skin.css.php'.'?customSkin='.json_encode($customSkin),3);
		}		
	}
	function _isPost() {
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			return true;
		}
		return false;
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
				///以sina_uid md5为名保存文件
				if (!$file_obj->upload('skinbg', WB_SKIN_BGIMG_UPLOAD_DIR . md5($sina_uid), P_VAR_NAME, 'png,jpeg,jpg', $maxSize)) {
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
	 * 个性化域名设置
	 */
    function domain() 
    {
		if ( USED_PERSON_DOMAIN ) {
        	TPL::display('setting_domain');
		} else {
			APP::redirect('setting');
		}
    }
}
?>
