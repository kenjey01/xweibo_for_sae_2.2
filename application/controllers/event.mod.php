<?php
/**
 * @file			event.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli1 <heli1@staff.sina.com.cn>
 * @Create Date:	2011-03-24
 * @Modified By:	heli1/2011-03-24
 * @Brief			活动控制器-Xweibo
 */

class event_mod {

	function event_mod() {
	}

	/**
	 * 活动首页
	 */
	function default_action() {
		TPL::display('events');
	}

	/**
	 * 发起活动
	 */
	function create() {
		TPL::display('events_form');
	}

	/**
	 * 编辑活动
	 */
	function modify() {
		$eid = V('g:eid');
		/// 编辑的id为空
		if (empty($eid)) {
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__eventNotExist')));
		}

		TPL::display('events_form');
	}

	/**
	 * 我的活动
	 */
	function mine() {
		/// 默认是我参加的活动
		$type = V('g:type', 'attend');
		
		TPL::assign('type', $type);
		TPL::display('my_events');
	}

	/**
	 * 活动列表
	 */
	function eventlist() {

		TPL::display('eventlist');
	}

	/**
	 * 活动详情
	 */
	function details() {
		/// 活动id
		$eid = V('g:eid', '');
		if (empty($eid)) {
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__eventNotExist')));
		}

		///获取活动的详细信息
		$info = DS('events.getEventById', '', $eid);
		if (empty($info) || 
			(isset($info['state']) && ($info['state'] == 2 || $info['state'] == 3) && (isset($info['sina_uid']) && $info['sina_uid'] != USER::uid()))) {
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__eventNotExist')));
		}

		TPL::assign('info', $info);
		TPL::display('events_details');
	}

	/**
	 * 参加活动的成员列表
	 */
	function member() {
		$eid = V('r:eid');
		if (!$eid) {
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__eventNotExist')));
		}
		$event_info = DS('events.getEventById', '', $eid);
		TPL::assign('event_info', $event_info);
		TPL::display('events_person');

	}
	
	/**
	 * 保存活动
	 */
	function saveEvent(){
		if(strtolower(V('s:REQUEST_METHOD'))=='post'){
			$id = trim(V('p:id',''));
			if($id){
				if(!is_numeric($id)){
					//非法数据
					APP::ajaxRst(false,'3001005');
					exit;
				}
				$data = DR('events.getEventById','',$id);
				$event = $data['rst'];
				//是否有权限编辑此活动
				if($event===false || sizeof($event)==0 || $event['sina_uid']!= USER::uid() || $event['state']=='3'){
					APP::ajaxRst(false,'3001005');
					exit;
				}
				$id = $event['id'];
			}
			//检查数据
			$data = $this->_checkData($id);
			$result = DR('events.save','',$data,$id);
			
			$eid = $id;
			if(!$id && $result['rst'])
			{				
				$eid = $result['rst'];
				//发起者默认参加此活动
				DR('events.joinEvent','',$eid, USER::uid(), $data['phone'], mb_substr($data['desc'], 0, 50, 'UTF-8'));
				
		
				// 先审后发
				$wbContent = $this->_get_wb_content($data, $eid);
				if ( F('strategy', $wbContent) )
				{
					// 图片发送给api
					$wbVerify['picid'] = $data['pic'];
					if ( count(explode('://', $data['pic']))>1 )
					{
						$picRst = DR('xweibo/xwb.uploadPic', FALSE, $data['pic']);
						if ( isset($picRst['rst']['pic_id']) ) {
							$wbVerify['picid']	= $picRst['rst']['pic_id'];
						}
					}
					
					$wbVerify['weibo']			= $wbContent;
					$wbVerify['type'] 			= 'event';
					$wbVerify['extend_id'] 		= $eid;
					$wbVerify['extend_data'] 	= json_encode(array('event_id'=>$eid, 'event_wb'=>1));
					$wbVerify['sina_uid']		= USER::uid();
					$wbVerify['nickname']		= USER::get('screen_name');
					$userToken					= USER::getOAuthKey(TRUE);
					$wbVerify['access_token']	= $userToken['oauth_token'];
					$wbVerify['token_secret']	= $userToken['oauth_token_secret'];
					$wbVerify['dateline']		= APP_LOCAL_TIMESTAMP;
			
					$result = DR('weiboVerify.addWeiboVerify', FALSE, $wbVerify);
				}
				else 	// 先发后审
				{
					//发活动的微博失败不处理
					$wb = DR('xweibo/xwb.upload', '', $wbContent, $data['pic']);
	
					if($wb['errno']==0 && $wb['rst']['id']!='')
					{				
						///查询是否开启数据备份
						$plugins = DR('Plugins.get', '', 6);
						$plugins = $plugins['rst'];
						if (isset($plugins['in_use']) && $plugins['in_use'] == 1) {
							$db = APP::ADP('db');
	
							$db->setTable('weibo_copy');
							$data_weibo = array();
							$data_weibo['id'] = $wb['rst']['id'];
							$data_weibo['weibo'] = $wb['rst']['text'];
							$data_weibo['uid'] = $wb['rst']['user']['id'];
							$data_weibo['nickname'] = $wb['rst']['user']['screen_name'];
							$data_weibo['addtime'] = APP_LOCAL_TIMESTAMP;
							$data_weibo['disabled'] = 0;
							$db->save($data_weibo);
						}
	
						$result2 = DR('events.save','',array('wb_id'=>$wb['rst']['id']),$eid);				
					}
				}
			}
			
			if($result['rst']!==false){
				//跳转到活动详细页				
				APP::ajaxRst(array('eid'=>$eid, 'url' => URL('event.details',array('eid'=>$eid))));
				exit;
			}
		}
		APP::ajaxRst(false,'3001004');
	}

	/**
	 * 关闭活动
	 */
	function closeEvent() {
		$eid = V('p:eid', '');
		if (empty($eid)) {
			APP::ajaxRst(false,'3002001');
			exit;			
		}

		$data = DR('events.getEventById','',$eid);
		$event = $data['rst'];
		//是否有权限编辑此活动
		if($event===false || sizeof($event)==0 || $event['sina_uid']!= USER::uid()){
			APP::ajaxRst(false,'3001005');
			exit;
		}

		$result = DR('events.updateEvents', '', $eid, 2);
		APP::ajaxRST($result['rst']);
		exit;
	}

	/**
	 * 删除活动
	 */
	function deleteEvent() {
		$eid = V('p:eid', '');
		if (empty($eid)) {
			APP::ajaxRst(false,'3002001');
			exit;			
		}

		$data = DR('events.getEventById','',$eid);
		$event = $data['rst'];
		//是否有权限编辑此活动
		if($event===false || sizeof($event)==0 || $event['sina_uid']!= USER::uid()){
			APP::ajaxRst(false,'3001005');
			exit;
		}

		$result = DR('events.deleteEvent', '', $eid);
		APP::ajaxRST($result['rst']);
		exit;
	}

	/**
	 * 评论活动
	 */
	function commentEvent() {
		$eid = V('p:eid', '');
		$content = V('p:content', '');
		if (empty($eid) || empty($content)) {
			APP::ajaxRst(false,'3002001');
			exit;			
		}

		$result = DR('events.commentEvent', '', $eid, $content);
		APP::ajaxRST($result['rst']);
		exit;
	}

	/**
	 * 参加活动
	 */
	function joinEvent() {
		$eid = V('p:eid', '');
		$contact = V('p:contact', false);
		$note = V('p:note', false);
		$other = V('p:other', 1);
		if (empty($eid)) {
			APP::ajaxRst(false,'3002001');
			exit;			
		}

		/// 要求填写备注和联系方式
		if ($other == 2) {
			if(empty($contact) || empty($note)){
				APP::ajaxRST(false,'3002002');
				exit;
			}				
		}

		$joined = DS('events.isJoinEvent', '', $eid, USER::uid());
		if ($joined) {
			APP::ajaxRst(false,'3002010');
			exit;			
		}

		$result = DR('events.joinEvent', '', $eid, USER::uid(), $contact, $note);
		APP::ajaxRST($result['rst']);
		exit;
	}

	/**
	 * 上传图片
	 * 输出json
	 */
	function upload(){
		$callback = V('g:callback','');
		$redirect = 'window.location="'.W_BASE_URL.'js/blank.html?rand='.rand(1,PHP_INT_MAX) . '"';
		if(isset($_FILES['pic'])){
			$f_upload = APP::ADP('upload');
			$fileName = $f_upload->getName();			
			if($f_upload->upload('pic',	$fileName ,P_URL_UPLOAD.'/event_pic/', 'jpg,jpeg,gif,png',1)){
				$fileInfo = $f_upload->getUploadFileInfo();				
				if ($fileInfo['errcode']) {
					die("<script language=\"javascript\">$callback(".APP::ajaxRst(false, '30'.$fileInfo['errcode'], $fileInfo['errmsg'], true).");$redirect</script>");
				}
				//缩小图片
				$image = APP::ADP('image');	
				if (strtolower(IMAGE_ADAPTER)==='sae'){
					$image->loadFile($fileInfo['webpath']);
					$imageInfo = $image->getImgInfo();
					if($imageInfo['width']>120 || $imageInfo['height']>120){
						$image->resize(120,120);
						$rs = $image->save($fileName);
						$fileInfo['webpath'] = $rs;
					}
				}else{
					$image->loadFile($fileInfo['savepath']);
					$imageInfo = $image->getImgInfo();
					if($imageInfo['width']>120 || $imageInfo['height']>120){
						$image->resize(120,120);
						$image->save($fileInfo['savepath']);
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
		//if (strtolower(IMAGE_ADAPTER)==='sae') {
			$result['filepath'] = $fileInfo['webpath'];
		//} else {
			//$result['filepath'] = $fileInfo['savepath'];
		//}

		die("<script language=\"javascript\">$callback(".APP::ajaxRst($result, 0, '', true).");$redirect</script>");
	}

	/**
	 * 获取活动数据并检查
	 */
	function _checkData($id){		
		$title = trim(V('p:title',''));
		$addr = trim(V('p:addr',''));
		$desc = trim(V('p:desc',''));
		$cost = floatval(V('p:cost',0));
		$phone = trim(V('p:phone'));
		$realname = trim(V('p:realname'));
		$start_time = trim(V('p:start_date',''));
		$end_time = trim(V('p:end_date',''));
        $filePath = trim(V('p:event_pic', ''));
		$other = trim(V('p:other', 1));
        //过滤脚本
        //$title = F('filter.filter_script',$title);
        //$addr = F('filter.filter_script',$addr);
        //$desc = F('filter.filter_script',$desc);
        
		//判断必填项
		if(!$title || !$addr || !$desc){
			APP::ajaxRst(false,'3001001');
			exit;
		}
		
		//费用不能大于1万
		if($cost>10000){
			//非法数据
			APP::ajaxRst(false,'3001005');
			exit;
		}
		
		if( preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/",$start_time) == 0 || preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/",$end_time) == 0){
			APP::ajaxRst(false,'3001005');
			exit;
		}
		$start_time = strtotime($start_time.' '.(int)V('p:start_h',0).':'.(int)V('p:start_m',0));
		$end_time = strtotime($end_time.' '.(int)V('p:end_h',0).':'.(int)V('p:end_m',0));
		//结束时间要大于开始时间
		if($end_time<$start_time){
			APP::ajaxRst(false,'3001002');
			exit;
		}
		
		//上传的图片	
		$file = $filePath;
			
		$client_ip = F('get_client_ip');
		if(!$id){	
			if(!$file){
				//默认图片
				$file = W_BASE_HTTP.W_BASE_URL.'img/event_cover.jpg';
			}
			//发起活动数据
			$data = array('title'=>$title,
						  'addr'=>$addr,
						  'desc'=>$desc,
						  'cost'=>$cost,
						  'sina_uid'=> USER::uid(),
						  'nickname'=> USER::get('screen_name'),
						  'phone'=>$phone,
						  'realname'=>$realname,
						  'start_time'=>$start_time,
						  'end_time'=>$end_time,
						  'pic'=>$file,
						  'join_num'=>0,
						  'view_num'=>0,
						  'comment_num'=>0,
						  'state'=>'1',
						  'other'=> $other,
						  'modify_time'=> APP_LOCAL_TIMESTAMP, 
						  'add_time'=> APP_LOCAL_TIMESTAMP,
						  'add_ip'=>$client_ip
						);
		}else{				
			//编辑活动数据
			$data = array('title'=>$title,
						  'addr'=>$addr,
						  'desc'=>$desc,
						  'cost'=>$cost,
						  'sina_uid'=> USER::uid(),
						  'nickname'=> USER::get('screen_name'),
						  'phone'=>$phone,
						  'realname'=>$realname,
						  'start_time'=>$start_time,
						  'end_time'=>$end_time,  
						  'other'=> $other,
						  'modify_time'=> APP_LOCAL_TIMESTAMP 
						);
			if($file){
				$data['pic'] = $file;
			}
		}
		return $data;	
	}

	/**
	 * 
	 * 获取活动的微博内容
	 * @param 活动信息array() $data
	 * @param 活动id $eid
	 */
	function _get_wb_content($data=array(),$eid){
		//生成短链接
		$e_url = W_BASE_HTTP.URL('event.details',array('eid'=>$eid));
		$wb = L('controller__event__shareEvent') . $data['title'] . ' ' . $e_url;
		return $wb;
	}
}
?>
