<?php
include('action.abs.php');
class user_recommend_mod extends action 
{
	const OFFICAL_WB_TYPE = 4;
	
	function user_recommend_mod() {
		parent :: action();
	}

    /*
    * 获取全部分类
    */
	function getReSort() {
		$rs = $rst = $rss = "";
		$rs = DR('mgr/userRecommendCom.getById');
		$rss = $this->_relatedSort($rs['rst']);

        TPL :: assign('list', $rss);
		TPL :: assign('userlist', $rst);
		TPL :: assign('group_id', 0);
		TPL :: assign('group_name', '');
        TPL :: display('mgr/recommended_user', '', 0, false);
    }

    /*
     * 根据id删除类别
     */
	function delReSortById($id = null, $limit = null) {
		if(!$id) {
			$id = (int)V('g:id',0);	//分组id
		}
					
		if(!$id) {
			$this->_error('参数错误！', URL('mgr/user_recommend.getReSort'));
		}

		$rs = DR('mgr/userRecommendCom.getById', '', $id);

		if(!$rs['rst'][0]) {
			$this->_error('该纪录不存在！', URL('mgr/user_recommend.getReSort'));
		}

		if($rs['rst'][0]['native']) {
			$this->_error('该纪录不能删除！', URL('mgr/user_recommend.getReSort'));
		}
					
		$rs = DR('mgr/userRecommendCom.delById', '', $id);

		if(!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/user_recommend.getReSort'));
		}

		if(!$limit) {
			$this->_succ('操作已成功', array('getReSort'));
		}
	}

	/*
	* 删除所选的全部类别
	*/
	function delAllReSort() {
		$ids = V('p:ids',0);	//分组id

		if(!$ids) {
			$this->_error('参数错误！', URL('mgr/user_recommend.getReSort'));
		}

		foreach($ids as $id) {
			$this->delReSortById($id, 'all');
		}

		$this->_succ('操作已成功', array('getReSort'));
	}

	/*
	* 添加新类别
	*/
	function addReSort() {
		$group_name = V('p:name',0);	//分组id
		$json = V('g:json', false);		// 是否返回json
		if(!$group_name) {
			$this->_error('类别名称不存在！', URL('mgr/user_recommend.getReSort'), $json?1:null);
		}

		$rs = DR('mgr/userRecommendCom.addSort', '', $group_name);

		if(!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/user_recommend.getReSort'), $josn?2:null);
		}
					
		$this->_succ('操作已成功', array('getReSort'), $json?array('group_id' =>$rs['rst']):null);
	}

	
	
	/*
	* 添加新用户
	*/
	function addReUser() 
	{
		$group_id 	= (int)V('r:group_id',0);	//分组id
		$nickname 	= V('p:nickname','');		//成员昵称
		$remark 	= V('p:remark','');			//备注   备注不为必填项
		$json = V('g:json', false);		// 是否返回json

		if(!$group_id || !$nickname) {
			$this->_error('类别或昵称不存在！', URL('mgr/user_recommend.getReSort'));
		}

		// Check User In Api
		$user_info = DR('xweibo/xwb.getUserShow', '', null, null, $nickname);
        if(empty($user_info['rst'])) {
			$this->_error('该用户不存在！', URL('mgr/user_recommend.getUserById', 'group_id='.$group_id), $json?1:null);
        }

        // 删除缓存
		DD('mgr/userRecommendCom.getUserById');		
		
		//if($remark === '') {
		//	$this->_error('备注不存在！', URL('mgr/user_recommend.getUserById' ,'group_id='.$group_id), $json?2:null);
		//}

		$data = array(
					'group_id' 	=> $group_id,
					'uid' 		=> $user_info['rst']['id'],
					'nickname' 	=> $nickname,
					'remark' 	=> $remark
				);

		// Check Data
		$rs = DR('mgr/userRecommendCom.getUserById', '', $group_id);
		if(count($rs['rst']) >= 3 && $group_id == 3) {  //自动关注限制为3个
			$this->_error('用户数已达上限，不能继续添加！', URL('mgr/user_recommend.getUserById','group_id='.$group_id), $json?3:null);
		}elseif(count($rs['rst']) >= 20) {		//其他限制为20个
			$this->_error('用户数已达上限，不能继续添加！', URL('mgr/user_recommend.getUserById','group_id='.$group_id), $json?4:null);
		}

		
		$rs = DR('mgr/userRecommendCom.addUser', '', $data);
		if(!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/user_recommend.getUserById','group_id='.$group_id), $json?5:null);
		}
		$this->_succ('操作已成功', array('getUserById&group_id='.$group_id), $json?array('uid' =>$user_info['rst']['id'], 'profile_img'=> F('profile_image_url',$user_info['rst']['id'], 'comment')):null);
	}

	
	/*
	* 根据分组gruop_id获取用户数据
	*/
	function getUserById()
	{
		$group_id = (int)V('g:group_id',0);	//分组id
		if(!$group_id) {
			$this->_error('类别id不存在！', URL('mgr/user_recommend.getReSort'));
		}
		TPL :: assign('group_id', $group_id);
		

		// Build Data
		$rs = $rst = $rss = array();
		if($group_id)	//获取其他数据
		{			
			$rs  = DR('mgr/userRecommendCom.getById', '', $group_id);
			$rss = DR('mgr/userRecommendCom.getUserById', '', $group_id);
			//$http_url = W_BASE_HTTP . URL('ta', 'id='.$value['sina_uid'], 'index.php');
            if($rss['rst']) {
                foreach($rss['rst'] as $value) {
					$value['http_url'] = W_BASE_HTTP . URL('ta', 'id='.$value['uid'], 'index.php');
					$rst[] = $value;
                }
            }

			TPL :: assign('group_name', $rs['rst'][0]['group_name']);
			TPL :: assign('userlist', $rst);
			TPL :: display('mgr/recommended_user_list', '', 0, false);
		} else {
			$rs = DR('mgr/userRecommendCom.getById');
			$rss = $this->_relatedSort($rs['rst']);
			
			TPL :: assign('list', $rss);
			TPL :: display('mgr/recommended_user', '', 0, false);
		}
	}

	
	
	/*
	* 根据group_id和uid删除用户数据
	*/
	function delUserById() 
	{
		$uid 		= V('r:uid',0);		//用户uid
		$group_id 	= (int)V('r:group_id','');	//类别id
		$json = V('g:json', false);		// 是否返回json

		if(!$group_id) {
			$this->_error('参数错误！', URL('mgr/user_recommend.getReSort'), $json?1:null);
		}
					
		if(!$uid) {
			$this->_error('参数错误！', URL('mgr/user_recommend.getUserById','group_id=' . $group_id), $json?2:null);
		}

		
		// Delete From DB
		$rs = DR('mgr/userRecommendCom.delByUid', '', $uid, $group_id);
		if(!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/user_recommend.getUserById','group_id=' . $group_id), $json?3:null);
		}

		$this->_succ('操作已成功', array('getUserById&group_id='.$group_id), $json?true:null);
	}

	
	
	/*
	* 根据group_id和uid串修改推荐用户排序
	*/
	function userSortById() 
	{
		$uids 		= V('p:uids', '');			//用户uid串
		$group_id 	= (int)V('p:group_id',0);	//类别id

		if(!$group_id || $group_id == 4) {
			exit('{"rst":false,"errno":0,"err":"参数错误！"}');
			//$this->_error('参数错误！', URL('mgr/user_recommend.getReSort'));
		}

		if(!$uids) {
			exit('{"rst":false,"errno":0,"err":"参数错误！"}');
			//$this->_error('参数错误！', URL('mgr/user_recommend.getUserById','group_id=' . $group_id));
		}

		//$uid_arr = explode(",", $uids);
		foreach($uids as $key=>$uid) {
			$rs = DR('mgr/userRecommendCom.userSortById', '', $uid, $group_id, $key+1);
			if(!$rs['rst']) {
				exit('{"rst":false,"errno":0,"err":"操作失败！"}');
				//$this->_error('操作失败！', URL('mgr/user_recommend.getUserById','group_id=' . $group_id));
			}
		}

		DR('mgr/userRecommendCom.cleanRelated', '', $group_id);
		exit('{"rst":true,"errno":0,"err":"操作已成功!"}');
		//$this->_succ('操作已成功', array('getUserById&group_id='.$group_id));
	}

	
	
	/*
	* 根据group_id和uid删除所选用户数据
	*/
	function delAllUserById() 
	{
		$uids 		= V('g:uids', '');			//用户uid串
		$group_id 	= (int)V('g:group_id',0);	//类别id
		
		$uid_arrs = explode(',', $uids);
		if(!$group_id) {
			$this->_error('参数错误！', URL('mgr/user_recommend.getReSort'));
		}

		if(!is_array($uid_arrs)) {
			$this->_error('参数错误！', URL('mgr/user_recommend.getUserById','group_id=' . $group_id));
		}

		
		// Delete From DB
		foreach ($uid_arrs as $value) {
			$uid_arr[] = '"' .mysql_escape_string($value) . '"';
		}

		$uids 	= implode(',', $uid_arr);
		$rs 	= DR('mgr/userRecommendCom.delAllByUid', '', $uids, $group_id);
		if(!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/user_recommend.getUserById','group_id=' . $group_id));
		}

		$group = DS('mgr/userRecommendCom.getById', '', $group_id);
		!empty($group) && !empty($group[0]['related_id']) && DR('PageModule.clearCache', '', explode(',', $group[0]['related_id']), $group_id);
		
		$this->_succ('操作已成功', array('getUserById&group_id='.$group_id));
	}

	
	
	/*
	 * 修改用户备注
	 */
	function setUserRemark() {
		$group_id = (int)V('r:group_id',0);	//类别id
		$uid = V('r:uid',0);	//用户id
		$remark = trim(V('p:remark',''));	//备注
		$json = V('g:json', false);		// 是否返回json

		if(!$group_id || !$uid) {
			$this->_error('参数错误！', URL('mgr/user_recommend.getReSort'), $json?1:null);
		}

		$data = array('remark'=>$remark);
		$rs = DR('mgr/userRecommendCom.updateUser', '', $data, $uid, $group_id);
		if(!$rs['rst'] && 0!==$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/user_recommend.getUserById','group_id=' . $group_id), $json?2:null);
		}

		$this->_succ('操作已成功', array('getUserById&group_id='.$group_id), $json?true:null);
	}

	/*
	 * 构建组件
	 */
	function _relatedSort($rs) {
		$arr = $rss = "";
		foreach($rs as $value) {
			$arr = explode(',', $value['related_id']);
			$rows = $value['related_name'] = "";
			if($arr) {
				//组件id
				$com_ids = array();

				//插件id
				$pin_ids = array();

				foreach($arr as $a) {
					$parts = explode(':', $a);

					if (count($parts) != 2) {
						continue;
					}

					if ($parts[1] == 1) { //组件
						$com_ids[] = $parts[0];
					} elseif ($parts[1] == 2) { //插件
						$pin_ids[] = $parts[0];
					}
				}

				if (!empty($com_ids)){

					$rows = DR('PageModule.getComponents', '', $com_ids);
					if($rows) {
						foreach($rows['rst'] as $row) {
							if($value['related_name']) {
								$value['related_name'] .= ',' . $row['name'];
							}else{
								$value['related_name'] .= $row['name'];
							}
						}
					}				
				}

				if (!empty($pin_ids)) {
					$rows = DS('Plugins.getList', '', $pin_ids);

					foreach($rows as $row) {
						if($value['related_name']) {
							$value['related_name'] .= ',' . $row['title'];
						}else{
							$value['related_name'] .= $row['title'];
						}
					}
				}
			}

			$rss[$value['group_id']] = $value;
		}

		return $rss;
	}
}
