<?php
include('action.abs.php');
class user_verify_mod extends action {
	function user_verify_mod() {
		parent :: action();
	}

    /*
     * 搜索用户
     */
	function search() {
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$num = ($page -1) * $each;
                                
		$rss = DR('mgr/userCom.getAllVerify', '', $offset, $each);

        foreach($rss['rst'] as $value) {
			$admin = '';
			$admin = DR('mgr/userCom.getByUid', '', $value['operator']);
            //$admin_info = DR('xweibo/xwb.getUserShow', '', $admin['rst']['sina_uid']);
            $value['admin_info'] = $admin['rst'];
            $value['http_url'] = W_BASE_HTTP . URL('ta', 'id='.$value['sina_uid'], 'index.php');
            $rs[$value['sina_uid']] = $value;
        }

		$rs = isset($rs)?$rs:array();
		$rss = DR('mgr/userCom.getAllVerify');
        $count = count($rss['rst']);

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);

		TPL :: assign('num', $num);
		TPL :: assign('pager', $pager->makePage());
        TPL :: assign('list', $rs);
        TPL :: display('mgr/user/authenticate_userlist', '', 0, false);
	}

    /*
     * 用户认证操作（给用户加V）
     */
    function authentication() {
		if($this->_isGet()) {
			$is_v = (int)V('g:v',0);
			$id = V('g:id',0);
			$nick = urldecode(V('g:nick',0));
			$reason = urldecode(V('g:reason',0));
		}

		if($this->_isPost()) {
			$is_v = 1;
			$nick = trim(V('p:nick',''));
			$reason = trim(V('p:reason', ''));
            $user_info = DR('xweibo/xwb.getUserShow', '', null, null, $nick);
            if(empty($user_info['rst'])) {
                $this->_error('该用户不存在！', URL('mgr/user_verify.search'));
            }
            $id = $user_info['rst']['id'];
        }
		
        //如果为加v操作
        if($id) {
			if($is_v && $nick) {
				 $rs = DR('mgr/userCom.getVerifyById', '', $id);
                 if($rs['rst']) {
                     $this->_error('该用户已被认证！', URL('mgr/user_verify.search'));
                 }

                 $data = array(
                                  'sina_uid' => $id,
                                  'nick' => $nick,
                                  'reason' => $reason,
                                  'add_time' =>APP_LOCAL_TIMESTAMP,
                                  'operator' => USER::uid(),
                                );
				 $rs = DR('mgr/userCom.saveVerify', '', $data);
                 if(!$rs['rst']) {
                     $this->_error('操作失败！', URL('mgr/user_verify.search'));
                 }
             }else{      //为解除v操作
				 $rs = DR('mgr/userCom.getVerifyById', '', $id);
                 if(!$rs['rst']) {
                      $this->_error('该用户已取消认证！', URL('mgr/user_verify.search'));
                 }

				 $rs = DR('mgr/userCom.delVerify', '', $id);
                 if(!$rs['rst']) {
                      $this->_error('操作失败！', URL('mgr/user_verify.search'));
                 }
             }
			// 清除缓存
			DD('mgr/userCom.getVerify');
         }

         $this->_succ('操作已成功', array('search'));
	}

	/**
	* 修改认证理由
	* 
	*/
	function updateVerifyReason() {
		$sina_uid = V('p:sina_uid', 0);
		$reason = trim(V('p:reason', ''));
		
		if (empty($sina_uid) || empty($reason)) {
			 $this->_error('参数错误', URL('mgr/user_verify.search'));
		}
		
		$data = array('reason' => $reason);
		$result = DR('mgr/userCom.saveVerify', '', $data, $sina_uid, 'sina_uid');
		if (!empty($result['errno'])) {
			$this->_error('修改失败，请重试', URL('mgr/user_verify.search'));
		}
		
		$this->_succ('修改成功', URL('mgr/user_verify.search'));
	}
	
	/*
	 * 取消所选认证
	 */
	function delAuthen() {
		$ids = V('g:ids');
		$id_arr = explode(',', $ids);
		
		if(!is_array($id_arr)) {
			$this->_error('参数错误！', URL('mgr/user_verify.search'));
		}
		
		foreach($id_arr as $id) {
			$rs = DR('mgr/userCom.getVerifyById', '', $id);
			if(!$rs['rst']) {
				$this->_error('该用户已取消认证！', URL('mgr/user_verify.search'));
			}

			$rs = DR('mgr/userCom.delVerify', '', $id);
			if(!$rs['rst']) {
				$this->_error('操作失败！', URL('mgr/user_verify.search'));
			}
		}
		
		DD('mgr/userCom.getVerify');
		$this->_succ('操作已成功', array('search'));

	}
	
	/*
	* 上传认证大图标
	*/
	function uploadAuthBigIcon() {
		if ($this->_isPost()) {
			$file = V('f:big');
			$state = 200;
			while ($file && $file['tmp_name']) {
				if ($file['size'] > 100 * 1024) {
					$state = '上传认证大图标的大小不能超过100K';
					break;
				}
				$info = getimagesize($file['tmp_name']);
				if ($info[2] != 3) {
					$state = '上传的图片文件不为PNG格式，请重新选择';
					break;
				}
				if ($info[0] > 100 || $info[1] > 30) {
					$state = '上传的图片长宽(100x30)超过限制，请重新选择';
					break;
				}

				$file_obj = APP::ADP('upload');
				$file_arr = explode('.', AUTH_BIG_ICON_PREVIEW_FILE_NAME);
				if (!$file_obj->upload('big', array_shift($file_arr), P_VAR_NAME, 'png')) {
					$state = '复制文件时出错,上传失败' . $file['tmp_name'] . '===' . P_VAR . AUTH_BIG_ICON_PREVIEW_FILE_NAME;
					break;
				}
				//获取上传文件的信息
				$logo = $file_obj->getUploadFileInfo();
				break;
			}
			echo '<script>parent.uploadFinished("' . $state. '","' . F('fix_url', $logo['savepath']) . '");</script>';
		}
	}

	/*
	* 上传认证小图标
	*/
	function uploadAuthSmallIcon() {
		if ($this->_isPost()) {
			$file = V('f:small');
			$state = 200;			
			while ($file && $file['tmp_name']) {
				if ($file['size'] > 100 * 1024) {
					$state = '上传认证小图标的大小不能超过100K';
					break;
				}
				$info = getimagesize($file['tmp_name']);
				if ($info[2] != 3) {
					$state = '上传的图片文件不为PNG格式，请重新选择';
					break;
				}
				if ($info[0] > 12 || $info[1] > 12) {
					$state = '上传的图片长宽(12x12)超过限制，请重新选择';
					break;
				}

				$file_obj = APP::ADP('upload');
				$file_arr = explode('.', AUTH_SMALL_ICON_PREVIEW_FILE_NAME);
				if (!$file_obj->upload('small', array_shift($file_arr), P_VAR_NAME, 'png')) {
					$state = '复制文件时出错,上传失败' . $file['tmp_name'] . '===' . P_VAR . AUTH_SMALL_ICON_PREVIEW_FILE_NAME;
					break;
				}
				
				//获取上传文件的信息
				$logo = $file_obj->getUploadFileInfo();
				break;
			}			
			echo '<script>parent.uploadSmallFinished("' . $state. '","' . F('fix_url', $logo['savepath']) . '");</script>';
		}
	}

	/*
	 * 设置站点认证方式
	 */
	function webAuthenWay() {
		if ($this->_isPost()) {
			$authen_type = V('p:authen_type', 0);
			$big_file = V('p:big_file','');
			$small_file = V('p:small_file','');
			$alt = htmlspecialchars(trim(V('p:alt','')));
			
			if (!is_array($authen_type)) {
				$authen_type = (array)$authen_type;
			}
			$authen_type = array_sum($authen_type);
			
			if (!in_array($authen_type, array(0, 1, 2, 3))) {
				$this->_error('参数错误', array('webAuthenWay'));
			}
			
			$big = $big_file ? $big_file : 'img/logo/big_auth_icon.png';//AUTH_BIG_ICON_DEFAULT_NAME;
			$small = $small_file ? $small_file : 'img/logo/small_auth_icon.png';//AUTH_SMALL_ICON_DEFAULT_NAME;
			
			if ($authen_type == 2 || $authen_type == 3) {
				if ($big_file) {
					if(XWB_SERVER_ENV_TYPE == "sae") {
						$file_arr = explode('.', AUTH_BIG_ICON_PREVIEW_FILE_NAME);
						$file_content = IO::read(array_shift($file_arr));
						$url = IO::write(P_VAR . AUTH_BIG_ICON_FILE_NAME, $file_content);
						$big = $url;
					}elseif(is_file(P_VAR . AUTH_BIG_ICON_PREVIEW_FILE_NAME)) {
						$file_content = IO::read(P_VAR . AUTH_BIG_ICON_PREVIEW_FILE_NAME);
						IO::write(P_VAR . AUTH_BIG_ICON_FILE_NAME, $file_content);
						$big = P_VAR_NAME . AUTH_BIG_ICON_FILE_NAME;
					}
				}

				if ($small_file) {
					if(XWB_SERVER_ENV_TYPE == "sae") {
						$file_arr = explode('.', AUTH_SMALL_ICON_PREVIEW_FILE_NAME);
						$file_content = IO::read(array_shift($file_arr));
						$url = IO::write(P_VAR . AUTH_SMALL_ICON_FILE_NAME, $file_content);
						$small = $url;
					}elseif(is_file(P_VAR . AUTH_SMALL_ICON_PREVIEW_FILE_NAME)) {
						$file_content = IO::read(P_VAR . AUTH_SMALL_ICON_PREVIEW_FILE_NAME);
						IO::write(P_VAR . AUTH_SMALL_ICON_FILE_NAME, $file_content);
						$small = P_VAR_NAME . AUTH_SMALL_ICON_FILE_NAME;
					}
				}

				$rs = DR('common/sysConfig.set', '', 'authen_big_icon', $big);

				if (!$rs['rst']) {
					$this->_error('操作失败！', URL('mgr/user_verify.webAuthenWay'));
				}

				$rs = DR('common/sysConfig.set', '', 'authen_small_icon', $small);

				if (!$rs['rst']) {
					$this->_error('操作失败！', URL('mgr/user_verify.webAuthenWay'));
				}
			}
			
			$rs = DR('common/sysConfig.set', '', 'authen_type', $authen_type);	//设置认证方式
			$rs = DR('common/sysConfig.set', '', 'authen_big_icon', $big);		//设置大图标
			$rs = DR('common/sysConfig.set', '', 'authen_small_icon', $small);	//设置小图标
			$rs = DR('common/sysConfig.set', '', 'authen_small_icon_title', $alt);	//设置小图标alt
			
			if (!$rs['rst']) {
				$this->_error('操作失败！', URL('mgr/user_verify.webAuthenWay'));
			}
			
			$this->_succ('操作已成功', array('search'));
		}

		$rs = DR('common/sysConfig.get', '', '');
		TPL :: assign('sysconfig', $rs['rst']);
		TPL :: display('mgr/authenticate_setting', '', 0, false);
	}
}
