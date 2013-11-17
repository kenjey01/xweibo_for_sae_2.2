<?php
include('action.abs.php');
class users_mod extends action {
	function users_mod() {
		parent :: action();
	}

    /*
     * 用户解，封禁操作
     */
	function ban() {
		$is_ban = (int)V('g:ban',0);
        $sina_uid = V('g:id',0);
		$p = V('g:p','');

        //如果为封禁操作
        if($sina_uid) {
			if($is_ban) {
				$rs = DR('mgr/userCom.getBanByUid', '', $sina_uid);
				if($rs['rst']) {
					$this->_error('该用户已被封禁！', URL('mgr/users.search'));
                }

				if($p == 'ban') {
					$rs = DR('xweibo/xwb.getUserShow', '', $sina_uid);		//屏蔽站外用户
					if(!$rs['rst']) {
						$this->_error('该用户不存在！', URL('mgr/users.search'));
					}
					$nickname = $rs['rst']['screen_name'];
				}else{
					$rs = DR('mgr/userCom.getByUid', '', $sina_uid);		//屏蔽站内用户
					if(!$rs['rst']) {
						$this->_error('该用户不存在！', URL('mgr/users.search'));
					}
					$nickname = $rs['rst']['nickname'];
				}

                $data = array(
                               'sina_uid' => $sina_uid,
                               'ban_time' => APP_LOCAL_TIMESTAMP,
							   'nick' => $nickname
						);
				$rs = DR('mgr/userCom.saveBan', '', $data);
                if(!$rs['rst']) {
                     $this->_error('操作失败！', URL('mgr/users.search'));
                }
             }else{      //为解禁操作
				 $rs = DR('mgr/userCom.getBanByUid', '', $sina_uid);
                 if(!$rs['rst']) {
                     $this->_error('该用户已解禁！', URL('mgr/users.search'));
                 }

				 $rs = DR('mgr/userCom.delBan', '', $sina_uid);
                 if(!$rs['rst']) {
                     $this->_error('操作失败！', URL('mgr/users.search'));
                 }
             }
		}
        if($p == 'ban') {
			$this->_succ('操作已成功', array('getBanUser'));
		}else{
			$this->_succ('操作已成功', array('search'));
		}
	}

   /*
    * 用户认证操作（给用户加V）
    */
	function authentication() {
		$is_v = (int)V('g:v',0);
        $id = V('g:id',0);
        $nick = urldecode(V('g:nick',0));

        
        if($id) {
             if($is_v && $nick) {		//授予认证操作
				  $rs = DR('mgr/userCom.getVerifyById', '', $id);
                  if($rs['rst']) {
						$this->_error('该用户已被认证！', URL('mgr/users.search'));
                  }

                  $data = array(
                                  'sina_uid' => $id,
                                  'nick' => $nick,
                                  'add_time' => APP_LOCAL_TIMESTAMP,
                                  'operator' => USER::uid(),
                   );

				  $rs = DR('mgr/userCom.saveVerify', '', $data);
                  if(!$rs['rst']) {
                        $this->_error('操作失败！', URL('mgr/users.search'));
                  }
              }else{      //取消认证操作
				  $rs = DR('mgr/userCom.getVerifyById', '', $id);
                  if(!$rs['rst']) {
						$this->_error('该用户已取消认证！', URL('mgr/users.search'));
                  }

				  $rs = DR('mgr/userCom.delVerify', '', $id);
                  if(!$rs['rst']) {
                        $this->_error('操作失败！', URL('mgr/users.search'));
                  }
              }
         }
		// 清除缓存
		DD('mgr/userCom.getUseBanByName');

        $this->_succ('操作已成功', array('search'));
	}
	
	

	/*
    * 搜索用户
    */
	function search() {
		$nickname = urldecode(V('r:keyword', ''));
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$num = ($page -1) * $each;

		$rss = $rs = "";
		$rss = DR('mgr/userCom.getByName', '', $nickname, $offset, $each);
		
		

        foreach($rss['rst'] as $value) {
            //调用微博个人资料接口
			//$userinfo = DR('xweibo/xwb.getUserShow', '', $value['sina_uid']);
            //$value['userinfo'] = $userinfo['rst'];
                                    
            //搜索是否为加V用户
            /*
			$rst = DR('mgr/userCom.getVerifyById', '', $value['sina_uid']);
            if($rst['rst']) {
				$value['is_verify'] = 1;
            }else{
				$value['is_verify'] = 0;
			}
			*/
			
            //搜索是否为封禁用户
			//$rst = DR('mgr/userCom.getBanByUid', '', $value['sina_uid']);

//            if($rst['rst']) {
//				$value['is_ban'] = 1;
//            }else{
//				$value['is_ban'] = 0;
//			}
			$value['action_type']=F('user_action_check',array(1,2,3),$value['sina_uid'],TRUE);
			if($value['action_type']==FALSE){
				$value['action_type']=4;
			}

            $rs[$value['sina_uid']] = $value;
			
			

        }

		$rss = DR('mgr/userCom.getByName', '', $nickname);
        $count = count($rss['rst']);

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		

		TPL :: assign('num', $num);
		TPL :: assign('pager', $pager->makePageForKeyWord('',array('keyword'=>urlencode($nickname))));
		TPL :: assign('count', $count);
		TPL :: assign('nickname', $nickname);
        TPL :: assign('list', $rs); 
        TPL :: display('mgr/user/user_list', '', 0, false);
	}

	/*
	 * 搜索所有站内，外用户
	 */
	function searchAllBanUser() {
		$nickname = trim(V('p:keyword', ''));
		//$userinfo = DR('xweibo/xwb.getUserShow', null, null, null, $nickname);
		if(empty($nickname)) {
			TPL :: display('mgr/user/users_ban_search', '', 0, false);
			exit;
		}

		$rs = $rss = $rst = '';
		$rss = DR('xweibo/xwb.searchUser', null, array('q' => $nickname,'count' => 10,'page' => 1));
		if (!$rss['errno'] && is_array($rss['rst'])) {
			foreach($rss['rst'] as $value) {
				//搜索是否为封禁用户
				$rst = DR('mgr/userCom.getBanByUid', '', $value['id']);
				if($rst['rst']) {
					$value['is_ban'] = 1;
				}else{
					$value['is_ban'] = 0;
				}
				$rs[] = $value;
			}
		}
		TPL :: assign('list', $rs);
        TPL :: display('mgr/user/users_ban_search', '', 0, false);
	}

	/*
	 * 搜索站内禁封用户
	 */
	function getBanUser() {
		$nickname = urldecode(trim(V('r:keyword', '')));
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$num = $offset;

		$rs = DR('mgr/userCom.getUseBanByName', null, $nickname, $offset, $each);

		$rss = DR('mgr/userCom.getUseBanByName', null, $nickname);
        $count = count($rss['rst']);

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		
		TPL :: assign('pager', $pager->makePageForKeyWord('',array('keyword'=>urlencode($nickname))));
		TPL :: assign('list', $rs['rst']);
		TPL :: assign('num', $num);
        TPL :: display('mgr/user/users_ban', '', 0, false);
	}
	
	
	/**
	  *  对用户进行1禁言、2禁止登录和3清除用户（禁止发言、禁止登录、禁止他人查看、禁止他的微博展示） 4恢复正常
	  */
	
	function userAction()
	{
		$type		 = (int)V('r:type',NULL);
		$screen_name = V('r:name',NULL);
		$sina_uid	 = V('r:id',NULL);
		
		//判断sina_uid是否存在于新浪账户
		if((($screen_name!=NULL&&trim($screen_name)!='')||$sina_uid!=NULL)&&in_array($type,array(1,2,3,4)))
		{
			if(!isset($sina_uid)){
				$rst=DR('xweibo/xwb.getUserShow','',NULL,NULL,trim($screen_name));
				if($rst['errno']==0&&isset($rst['rst']['id'])){
					$sina_uid=$rst['rst']['id'];
				}
			}
			else{
				$rst=DR('xweibo/xwb.getUserShow','',NULL,$sina_uid);
				if($rst['errno']==0&&isset($rst['rst']['screen_name'])){
					$screen_name=$rst['rst']['screen_name'];
					TPL::assign('screen_name',$screen_name);
				}
				$ret=DR('mgr/userCom.getUserAction','',$sina_uid);
				if($ret['errno']==0){
					$type=$ret['rst'][0]['action_type'];
					TPL::assign('type',$type);
					$onlyDisplay=TRUE;
				}
			}
			if(isset($sina_uid)&&(!isset($onlyDisplay)||$onlyDisplay==FALSE)){

				DD('mgr/userCom.getUserActionList');
				if($type!=NULL){
					DR('mgr/userCom.setUserAction','',$sina_uid,$type);
					if($type==3){
						DD('UserFollow.getLocalFollowTop');		
					}
					if(in_array($type,array(3))){
						///删除用户需要批处理一批信息
						//屏蔽其发布的活动
						DR('events.batchUpdateEvents', '', $sina_uid, 3);
						//批量删除用户组里面的数据
						DR('mgr/userRecommendCom.delUserByUid', '', $sina_uid);
						// 删除用户发的所有通过审核的微博
						$rs = DR('xweibo/weiboCopy.deleteByUid','',$sina_uid);
						// 删除用户发的未通过审核的微博
						$rs = DR('weiboVerify.deleteByUid', '', $sina_uid);
						// 删除用户发的未通过审核的评论
						$rs = DR('CommentVerify.delCommentByUid', '', $sina_uid);
					}
					
					$redirect = V('r:call_back', array('userAction'));
					$this->_succ('操作已成功', $redirect);
						
				}
			}
			elseif(!isset($sina_uid)){
				$this->_error('不存在该昵称的用户',URL('mgr/users.userAction'));
				//用户不存在
			}	
		}
		elseif(in_array($type,array(1,2,3,4))&&($screen_name==NULL||trim($screen_name)=='')){
			//screen name is NULL
			$this->_error('操作的用户名不能为空',URL('mgr/users.userAction'));
			//有原始页面
			
		}
		
		$callBack = $sina_uid ? URL('mgr/users.search') : URL('mgr/users.userAction');
		TPL::assign('callBack', $callBack);
		TPL::display('mgr/user/user_action','',0,FALSE);
	}
	
	
}
