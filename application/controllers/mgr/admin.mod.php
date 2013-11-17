<?php
/**************************************************
*  Created:  2010-10-28
*
*  文件说明
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/
include('action.abs.php');
class admin_mod extends action {
	function admin_mod() {
		parent :: action();
	}

	function index() {
		TPL::assign('menu', $this->_getUserMenu(USER::aid()));
		$this->_display('index');
	}

	function map() {
		TPL::assign('menu', $this->_getUserMenu(USER::aid()));
		$this->_display('map');
	}

	function default_page () {
		$counts = array(
			'wb' =>0,
			'user' =>0,
			'comment' =>0,
			't_wb' => 0,
			't_user' => 0,
			't_comment' => 0
		);
		$counts['wb'] = DS('xweibo/weiboCopy.counts');
		$counts['comment'] = DS('CommentCopy.counts');
		$counts['user'] = DS('mgr/userCom.counts');

		$counts['t_wb'] = DS('xweibo/weiboCopy.counts','','today');
		$counts['t_comment'] = DS('CommentCopy.counts', '', 'today');
		$counts['t_user'] = DS('mgr/userCom.counts', '', 'today');

		TPL::assign('counts', $counts);
		$this->_display('default');
	}

	/**
	* 用户登录
	*/
	function login() {
		if ($this->_isPost()) {
			$sina_uid = trim(V('p:sina_uid'));
			$pwd = trim(V('p:password'));
			$verify_code = strtolower(V('p:verify_code'));

			if (empty($sina_uid) || empty($pwd)) {
				exit('{"state":"401", "msg":"帐号或密码错误"}');
			}

			$rs = $rss = '';
			$rss = DR('mgr/adminCom.getAdminByUid', '', $sina_uid);
			if (!isset($rss['rst'][0])) {
				exit('{"state":"401", "msg":"帐号或密码错误"}');
			}

			$rs = $rss['rst'][0];			
			if ($rs['pwd'] != md5($pwd)) {
				exit('{"state":"401", "msg":"帐号或密码错误"}');
			}
			
			//检查是否启用验证码
			if(IS_USE_CAPTCHA) {
				$autocode = APP :: N('SimpleCaptcha');
				if (!$autocode->checkAuthcode($verify_code)) {
					exit('{"state":"402", "msg":"验证码错误"}');
				}
			}

			session_regenerate_id();   //防御Session Fixation
			USER::set('__CLIENT_ADMIN_ROOT', $rs['group_id']);	//设置管理员权限
			USER::aid($rs['id']);	
			
			if ( V('g:ajax') ) {
				exit('{"state":"200"}');
			} 
			
			APP::redirect(URL('mgr/admin.index'), 3);
		}

		//判断数据库中是否存在管理员
		$rs = DR('mgr/adminCom.getAdminByUid');
		if(!$rs['rst']) {
			//如果数据库中没有管理员数据，跳转到安装页面
			$this->_display('active_href');
			exit;
		}

		if(!USER::isUserLogin()) {
			exit('{"state":"401", "msg":"您未登录！"}');
		}
		
		$sina_uid = USER::uid();
		$name = USER::get('screen_name');
		
	    $user = DS('mgr/userCom.getByUid','p',$sina_uid);
		//第一次登录，用户信息入库
		if (empty($user) || !isset($user['sina_uid'])){
			$inData = array();
			$inData['first_login']	= APP_LOCAL_TIMESTAMP;
			$inData['sina_uid']	= $sina_uid;
			$inData['nickname']	= $name;
			$r = DR('mgr/userCom.insertUser', '', $inData);  
		}

		TPL :: assign('is_admin_report', USER::get('isAdminReport'));	//获取是否上报
		TPL::assign('sina_uid', $sina_uid);
		TPL::assign('real_name', $name);
		$this->_display('login');
	}
		
	/**
	* 退出登录
	*/
	function logout() {
		USER::aid('');
		USER::set('__CLIENT_ADMIN_ROOT', '');
		session_regenerate_id();   //防御Session Fixation
		//USER::resetInfo();
		APP :: redirect('mgr/admin.login', 2);
	}

	/**
	* 绘制验证码
	*/
	function authcode() {
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
/*
		$autocode = APP :: N('authCode');
		$autocode->setImage(array('type'=>'png','width'=>70,'height'=>25));
		$autocode->paint();
*/
		session_start();
		$autocode = APP :: N('SimpleCaptcha');
		$autocode->CreateImage();

	}


    /*
    * 管理员列表
    */
	function userlist() {
         //实例化微博api
        $wbApi = APP::N('weibo');

		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$num = ($page -1) * $each;
		$sina_uid = V('g:keyword', '');

		$rss = $rs = '';
        //获取管理员数量
        $count = DR('mgr/adminCom.getAdminNum');

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count['rst'], 'linkNumber' => 10);
		$pager->setParam($page_param);
		TPL :: assign('pager', $pager->makePage());

        //获取管理员基本信息
        $rss = DR('mgr/adminCom.getAdminByUid', '', $sina_uid, $offset, $each);
		//获取当前操作者的数据
		//$p = DR('mgr/adminCom.getAdminById', '', $this->_getUid());
 
        //$http_url = 'http://' . V('S:HTTP_HOST') . ':' . V('S:SERVER_PORT') . '/index.php?m=ta&id=';
		
        foreach($rss['rst'] as $value) {
              //调用微博个人资料接口
              $userinfo = DR('mgr/userCom.getByUid', '', $value['sina_uid']);
              $value['userinfo'] = $userinfo['rst'];
              $value['http_url'] = W_BASE_HTTP . URL('ta', 'id='.$value['sina_uid'], 'index.php');;
              $rs[$value['sina_uid']] = $value;
        }

		TPL :: assign('num', $num);
		TPL :: assign('list', $rs);
		//TPL :: assign('admin', $p['rst']);
		TPL :: display('mgr/admin/adminlist', '', 0, false);
	}

    /*
     * 管理员删除
     */
	function del() {
		$id = V('g:id', 0);
		if ($this->_getUid() == $id) {
			$this->_error('不能对自己进行删除操作', array('userlist'));
		}
		
		$p = DR('mgr/adminCom.getAdminById', '', $this->_getUid());	//获取当前操作者的数据
		if(!$p['rst']['group_id'] == '1') {
			$this->_error('您无权限删除', array('search'));
		}

		$rs = DR('mgr/adminCom.delAdmin', '', $id);
		if ($rs['rst']) {
			$this->_succ('操作已成功', array('userlist'));
		}
		
		$this->_error('删除失败',  array('userlist'));
	}
	
	function page_link(){
		$router=V('g:router','home/0/0');
		$router=explode('/',$router);
		//var_dump($router);
		$menu=$this->menu;
		//var_dump($menu);
		$link=array();
		$link[0]=array('title'=>$menu[$router[0]]['title'],
					   'url'=>$menu[$router[0]]['sub'][0]['sub'][0]['url']
					   );
		//$link[1]=$menu[$router[0]]['sub'][$router[1]]['title'];
		$link[2]=array('title'=>$menu[$router[0]]['sub'][$router[1]]['sub'][$router[2]]['title'],
					   'url'=>$menu[$router[0]]['sub'][$router[1]]['sub'][$router[2]]['url']);
		
		
		//var_dump($link);
		TPL::module('page_link',array('link'=>$link));
	}

    /*
     * 管理员修改密码
     */
	function repassword() {
		$rs = DR('mgr/adminCom.getAdminById', '', $this->_getUid());	//获取当前操作者的数据
		if ($this->_isPost()) {
			$id = (int)V('p:id', 0);
			$new_pwd = trim(V('p:pwd'));
			$re_pwd = trim(V('p:re_pwd'));
			$old_pwd = trim(V('p:old_pwd'));

			if (!$new_pwd) {
				$this->_error('请输入新密码', URL('mgr/admin.repassword', 'id='. $id));
			}
			if ($new_pwd !== $re_pwd) {
				$this->_error('两次输入的新密码不一致', URL('mgr/admin.repassword', 'id='. $id));
			}

			$p = DR('mgr/adminCom.getAdminById', '', $id);
			//$rs = DR('mgr/adminCom.getAdminById', '', $this->_getUid());	//获取当前操作者的数据
			if (!$p['rst']) {
					$this->_error('不存在的用户', URL('mgr/admin.repassword', 'id='. $id));
			}
			// 如果是本人修改密码，则一定要验证旧密码
			if ($rs['rst']['id'] == $id && md5($old_pwd) !== $p['rst']['pwd']) {
				$this->_error('输入的旧密码不正确', URL('mgr/admin.repassword', 'id='. $id));
			}
			//判断当前操作者是否为超级管理员或本人
			if($rs['rst']['group_id'] == '1' || $rs['rst']['id'] == $id) {
				$data = array(
						'pwd' => md5($new_pwd)
				);
				$rs = DR('mgr/adminCom.saveAdminById', '', $data, $id);
				if (!$rs['rst']) {
					$this->_error('修改密码失败, 新密码可能与旧密码相同', URL('mgr/admin.repassword', 'id='. $id));
				}
				$this->_succ('操作已成功', array('repassword'));
			}else{
				$this->_error('您无权限修改', URL('mgr/admin.repassword', 'id='. $id));
			}
		}

		TPL :: assign('info', $rs['rst']);
		TPL :: assign('nick', $this->_getUserInfo('screen_name'));
		TPL :: display('mgr/admin/change_password', '', 0, false);

	}

   /*
    * 搜索用户
    */
	function search() {
		$nickname = V('p:keyword', '');
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		
        if(empty($nickname)) {
			TPL :: display('mgr/admin/add_admin', '', 0, false);
            exit;
        }

		$rss = $rst = '';
		$rss = DR('mgr/userCom.getByName', '', $nickname, $offset, $each);
        if(empty($rss['rst'])) {
			TPL :: display('mgr/admin/add_admin', '', 0, false);
            exit;
        }

        foreach($rss['rst'] as $value) {
            //调用微博个人资料接口
			$rs = '';
			$userinfo = DR('xweibo/xwb.getUserShow', '', $value['sina_uid']);
            $value['userinfo'] = $userinfo['rst'];
            //搜索是否为加V用户
			$rs = DR('mgr/userCom.getVerifyById', '', $value['sina_uid']);
            if($rs['rst']) {
                $value['is_verify'] = 1;
            }

             //搜索是否为封禁用户
			$rs = DR('mgr/userCom.getBanByUid', '', $value['sina_uid']);
            if($rs['rst']) {
                 $value['is_ban'] = 1;
            }

            $rst[$value['sina_uid']] = $value;

          }

         $count = count($rst);

		 $pager = APP :: N('pager');
		 $page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		 $pager->setParam($page_param);

		 TPL :: assign('pager', $pager->makePage());
         TPL :: assign('list', $rst);
         TPL :: display('mgr/admin/add_admin', '', 0, false);
	}

   /*
    * 管理员添加
    */
	function add() {
		$sina_uid = trim(V('p:uid'));
		$pwd = trim(V('p:pwd'));

		if (empty($sina_uid)) {
			$this->_error('用户id不能为空', array('search'));
		}

		$rst = DR('mgr/userCom.getByUid', '', $sina_uid);
		if (!$rst['rst']) {
			$this->_error('该用户不存在', array('search'));
		}

		$p = DR('mgr/adminCom.getAdminById', '', $this->_getUid());	//获取当前操作者的数据
		if(!$p['rst']['group_id'] == '1') {
			$this->_error('您无权限添加', array('search'));
		}

		$rs = DR('mgr/adminCom.getAdminByUid', '', $sina_uid);
        if($rs['rst']) {
            $this->_error('该用户已是管理员', array('search'));
        }
                                
		$data = array(
						'sina_uid' => $sina_uid,
						'pwd' => md5($pwd),
						'group_id' => V('p:group_id'),
						'add_time' =>APP_LOCAL_TIMESTAMP
						
					);
		$rs = DR('mgr/adminCom.saveAdminById', '', $data);
		if ($rs['rst']) {
			$this->_succ('操作已成功', array('userlist'));
		}
		$this->_error('添加失败', array('search'));
	}
}
