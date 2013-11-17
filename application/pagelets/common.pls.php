<?php
class common_pls {
	
	function sideComponents($p) {
		$param = array(
			'type' => 2
		);
		$p = array_merge($param, $p);
		$modules = DS('PageModule.getPageModules', '', $p['type'], 1);
		
		if(isset($modules[2])){
			foreach ($modules[2] as $mod) {
				Xpipe::pagelet('component/component_'. $mod['component_id']. '.run', $mod );
			}
		}

	}
	
	/**
	 * 本方法即将废弃，请直接使用：
	 * Xpipe::pagelet('component/component_'. $mod['component_id']. '.run', $mod );
	 * @deprecated
	 */
	function componet($mod) {
		Xpipe::pagelet('component/component_'. $mod['component_id']. '.run', $mod );
	}
	
	function userPreview($userinfo = null) {
		TPL::module('user_preview', array('uInfo'=>$userinfo));
	}

	function userMenu() {
		TPL::module('user_menu');
	}

	function userTag($userinfo=null) {
		TPL::module('user_tag', array('userinfo'=>$userinfo));   
	}
	
	function siteNav() {
		TPL::plugin('include/site_nav');
	}

	function userSkin() {
		$skinSort=DR('mgr/skinCom.getSkinSortById',96400);//获取皮肤分类
		$rs = DR('mgr/skinCom.getSkinById', 86400,null,0);//获取所有的皮肤
		$skinDirs=DR('mgr/skinCom.scanSkinDirectory');//获取目录中含有的真实皮肤
		///初始化时防止后台未初始化皮肤数据？还是改成数据初始化到库里面
		if(!is_array($rs['rst'])&&empty($rs['rst'])){
			foreach($skinDirs['rst'] as $value) {
			$rss = DR('mgr/skinCom.readSkinConfig', '', $value['location'] . '/' . SKIN_CONFIG);
			if($rss['rst']) {
				$info = DR('mgr/skinCom.getskinByName', '', $value['name']);
				if(!$info['rst']) {
					$rss['rst']['directory'] = $value['name'];
					DR('mgr/skinCom.InsertSkinInfo', '', $rss['rst']);
				}
			}
			}
			$rs = DR('mgr/skinCom.getSkinById', 86400,null,0);//获取所有的皮肤
		}
		
		$skinSortIndex=array('0'=>array('name'=> L('pls__common__userSkin__defaultTitle'),'skins'=>array()));
		foreach($skinSort['rst'] as $sort){
			$skinSortIndex[$sort['style_id']]=array('name'=>$sort['style_name'],'skins'=>array());
		}
		$realSkin=array();
		foreach($skinDirs['rst'] as $skinDir){
			$name=$skinDir['name'];
			if(is_array($rs['rst']))
			foreach($rs['rst'] as $k=>$skinDB){
				if($name==$skinDB['directory']){
					$s=array('name'=>$skinDB['name'],'directory'=>$name,'skin_id'=>$skinDB['skin_id'],'style_id'=>$skinDB['style_id'],
							 'thumbnail'=> W_BASE_URL . P_CSS_PRE.'/'.$name.'/thumbpic.png',
							 'sort_num'=>$skinDB['sort_num']
							 );
					$realSkin[]=$s;
					$skinSortIndex[$skinDB['style_id']]['skins'][]=$s;
					break;
				}
			}
		}
		//获取用户自定义属性
		$sina_uid=USER::uid();
		$rs = DR('common/userConfig.get', '', 'user_skin', $sina_uid);
		if(!is_numeric($rs['rst'])&&$rs['rst']!=NULL){
			$customSkin=json_decode($rs['rst'],TRUE);
		}
		//rst id name directory desc state style_id
		///列出目录和数据库中都含有的皮肤
		//scanSkinDirectory
		$realSkin=array_sort($realSkin,'sort_num',SORT_ASC);
		$data=array('skinSort'=>$skinSortIndex,'allSkin'=>$realSkin);
		if(isset($customSkin)){
			$data['customSkin']=$customSkin;
		}
		$data['colorConf']=DS('getSkinColors','g/0');
		
		TPL::module('user_skin',$data);
		
	}
	


	function userTotal($userinfo) {
		TPL::module('user_total', array('uInfo'=>$userinfo));
	}

	function magicFriends($userinfo) {
		$followers = DR('xweibo/xwb.getMagicFollowers', '', $userinfo['id'], 9, USER::isUserLogin()?true:false);
		$followers = $followers['rst']['users'];
		TPL::module('sidebar_fans', array('userinfo' => $userinfo, 'followers'=>$followers));
	}
	
	function subjectFollowed($sina_id){
		$list = DR('xweibo/xwb.getSubjectList', '',$sina_id);
		TPL::module('subject_followed',array('list'=>$list));
	}

	function message() {
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;
		/// 调用获取当前用户收到的最新私信列表 api
		$result = DR('xweibo/xwb.getDirectMessages', CACHE_MESSAGES, $limit, $page);
		$re_list = $result['rst'];

		/// 调用获取当前用户发送的最新私信列表 api
		$result = DR('xweibo/xwb.getSentDirectMessages', '', $limit, $page);
		$send_list = $result['rst'];

		$re_list = empty($re_list) ? $re_list = array() : $re_list;
		$send_list = empty($send_list) ? $send_list = array() : $send_list;
		$list = array_merge($re_list, $send_list);
		if ($list) {
			$compare = create_function('$a, $b', 'return strcasecmp(strtotime($b["created_at"]), strtotime($a["created_at"]));');
			/// 根据时间排序
			usort($list, $compare);
		}
		$params = array(
			'list' => $list,
			'page' => $page,
			'limit' => $limit
		);
		TPL::module('message', $params);
	}
	
	function notices($sina_uid) {
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;
		
		/// 调用获取当前用户收到的最新私信列表 api
		$result = DR('notice.getNoticeList', '', $sina_uid, ($page - 1) * $limit, $limit);
		$list = $result['rst'];
		
		$params = array(
			'list' => $list,
			'page' => $page,
			'limit' => $limit
		);
		
		TPL::module('notices', $params);
	}

	function searchMod() {
		TPL::module('mod_search');
	}
	
}
