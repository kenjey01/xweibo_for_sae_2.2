<?php
/**
 * @file			xwb.com.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-11-15
 * @Modified By:	heli/2010-11-15
 * @Brief			微博api操作类
 */

// 根据配进include不同的文件，以达到xwb继承同一名字但是方法不同的父类
if ( XWB_PARENT_RELATIONSHIP ) {
	include_once P_CLASS.'/weiboLocal.class.php';
} else {
	include_once P_CLASS.'/weiboSina.class.php';
}

class xwb extends xwbParentClass
 {


	/**
	 * 构造函数
	 *
	 * @param @oauth_token
	 * @param @oauth_token_secret
	 * @return
	 */
	function xwb($oauth_token = NULL, $oauth_token_secret = NULL)
	{
		parent::xwbParentClass($oauth_token, $oauth_token_secret);
	}


	/**
	 * 检查方法参数 
	 *
	 * @param array $params
	 * @return	
	 */
	function validation($params)
	{
		if (array_key_exists('any', $params)) {
			if (empty($params['any'])) {
				return RST('', '1010000', 'Parameter can not be empty');
			}	
			if (isset($params['any']['name']) && (F('filter', $params['any']['name'], 'content') !== true)) {
				return RST('', '1010007', 'Parameters contain sensitive characters');
			}
			if (isset($params['any']['description ']) && (F('filter', $params['any']['description'], 'content') !== true)) {
				return RST('', '1010007', 'Parameters contain sensitive characters');
			}
			return false;
		}
		foreach ($params as $key => $var) {
			$key_array = explode('|', $key);
			foreach ($key_array as $v) {
				$v_array = explode(':', $v);
				switch ($v_array[0]) {
					case 'required':
						if ($var == '') {
							return RST('', '1010000', 'Parameter can not be empty');
						}
						break;
					case 'max_length':
						if (!empty($var) && mb_strwidth($var, 'UTF-8') > $v_array[1] * 2) {
							return RST('', '1010005', 'Parameter length exceeds limit');
						}
						break;
					case 'array':
						if (!empty($var) && is_array($var)) {
							return RST('', '1010007', 'Parameter length exceeds limit');
						}
						break;
					case 'numeric':
						if (!empty($var) && !is_numeric($var)) {
							return RST('', '1010002', 'Parameter must be a number');
						} 	
						break;
					case 'valid_email':
						if (!empty($var) && !preg_match('#^\w+(\.\w+)*@\w+(\.\w)+$#', $var)) {
							return RST('', '1010003', 'Parameters for the email to format');
						}
						break;
					case 'valid_sina_email':
						if (!empty($var) && preg_match('#^\w+(\.\w)*@(\w\.)*sina\.[com|cn]$#', $var)) {
							return RST('', '1010006', 'Parameters for the email to format');
						}
						break;
					case 'json':
						if (!empty($var) && !json_decode($var, true)) {
							return RST('', '1010004', 'Parameters for json request directly to format');
						}
						break;
					case 'filter':
						if (!empty($var) && (F('filter', $var, 'content') !== true)) {
							return RST('', '1010007', 'Parameters contain sensitive characters');
						}
						break;
				} 
			}
		}
		return false; 
	}

	/**
	 * 获取未读数 
	 * 
	 * @return array	
	 */
	function getUnread($since_id = null)
	{
		$result = parent::getUnread(1, $since_id);
		$ret = $result['rst'];
		if (isset($ret['new_status']) && $ret['new_status'] > 0) {
			//删除'我的首页'缓存
			DD('xweibo/xwb.getFriendsTimeline'); 
		} 
		if (isset($ret['comments']) && $ret['comments'] > 0) {
			//删除'我收到的评论'缓存
			DD('xweibo/xwb.getCommentsToMe'); 
		} 
		if (isset($ret['dm']) && $ret['dm'] > 0) {
			//删除'我的私信'缓存
			if ( !HAS_DIRECT_MESSAGES ){ $result['rst']['dm']=0; }
			DD('xweibo/xwb.getDirectMessages'); 
		} 
		if (isset($ret['mentions']) && $ret['mentions'] > 0) {
			//删除'提到我的'缓存
			DD('xweibo/xwb.getMentions'); 
		} 
		if (isset($ret['followers']) && $ret['followers'] > 0) {
			//删除'我的粉丝'缓存
			DD('xweibo/xwb.getFollowers'); 
		} 
		return $result;
	}

	/**
	 * 获取用户发布的微博信息列表
	 *
	 * @param $id int|string
	 * @param $user_id int
	 * @param $name string
	 * @param $since_id int
	 * @parmas $max_id int
	 * @param $count int
	 * @param $page int
	 * @param $useType string
	 * @return array|string
	 */
	 function getUserTimeline($id = null, $user_id = null, $name = null, $since_id = null, $max_id = null, $count = null, $page = null, $feature = 0, $oauth = true, $base_app = '0')
	 {
		 $valid_params = array();
		 $valid_params['id|required'] = $id.$user_id.$name;
		 $valid = $this->validation($valid_params);
		 if ($valid !== false) {
			return $valid; 
		 }

		$response = parent::getUserTimeline($id, $user_id, $name, $since_id, $max_id, $count, $page, $feature, $oauth, $base_app);

		return $response;
	 }


	/**
	 * 获取指定微博的评论列表
	 *
	 * @param $id int
	 * @param $count int
	 * @param $page int
	 * @param $useType string
	 * @return array|string
	 */
	 function getComments($id, $count = null, $page = null)
	 {
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		}

		$response = parent::getComments($id, $count, $page);

		return $response;
	 }


	/**
	 * 批量获取一组微博的评论数及转发数
	 *
	 * @param $ids string
	 * @param $useType string
	 * @return array|string
	 */
	 function getCounts($ids, $oauth = true)
	 {
		$valid_params = array();
		$valid_params['id|required'] = $ids;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		}

		$response = parent::getCounts($ids, $oauth);

		return $response;
	 }


	 //访问接口

	/**
	 * 根据ID获取单条微博信息内容
	 *
	 * @param $id int
	 * @param $user_id int
	 * @param $name string
	 * @param $useType string
	 * @return array|string
	 */
	 function getStatuseShow($id)
	 {
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::getStatuseShow($id);

		return $response;
	 }


	/**
	 * 发布一条微博信息
	 *
	 * @param $status string
	 * @param $useType string
	 * @return array|string
	 */
	 function update($status)
	 {
		$status = trim($status);
		$valid_params = array();
		$valid_params['status|required|filter|max_length:140'] = $status;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::update($status);

		return $response;
	 }


	 /**
	  * 上传图片并发布一条微博信息
	  *
	  * @param $status string
	  * @param $pid string
	  * @param $lat string
	  * @param $long string
	  * @param $useType string
	  * @return array|string
	  */
	 function upload($status, $pic, $lat = null, $long = null)
	 {
		$status = trim($status);
		//检查参数
		$valid_params = array();
		$valid_params['status|required|max_length:140'] = $status;
		$valid_params['pic|required'] = $pic;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::upload($status, $pic, $lat, $long);

		return $response;
	 }

	/**
	 * 上传图片，返回pcid，缩略图，原图
	 *
	 * @param $pic string
	 * @param $useType string
	 * @return array|string
	 */
	 function uploadPic($pic)
	 {	
		//检查参数
		$valid_params = array();
		$valid_params['pic|required'] = $pic;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::uploadPic($pic);

		return $response;
	 }

	 /**
	  * 发布图片微博
	  *
	  * @param $status string
	  * @param $picid string
	  * @param $url string
	  * @param $useType string
	  * @return array|string
	  */
	 function uploadUrlText($status, $picid = null, $picurl = null)
	 {
		$status = trim($status);
		$picid = trim($picid);
		//检查参数
		$valid_params = array();
		$valid_params['status|required|filter'] = $status;
		//$valid_params['picid|required'] = $picid;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::uploadUrlText($status, $picid, $picurl);

		return $response;
	 }


	/**
	 * 删除微博
	 *
	 * @param $id int
	 * @param $useType string
	 * @return array|string
	 */
	 function destroy($id)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::destroy($id);

		return $response;
	 }


	/**
	 * 转发一条微博信息（可加评论）
	 *
	 * @param $id int
	 * @param $status string
	 * @param $useType string
	 * @return array|string
	 */
	 function repost($id, $status = null, $is_comment = 0)
	 {
		$url = WEIBO_API_URL.'statuses/repost.'.$this->format;
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid_params['status|filter|max_length:140'] = $status;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::repost($id, $status, $is_comment);

		return $response;
	 }


	/**
	 * 删除当前用户的微博评论信息
	 *
	 * @param $id int
	 * @param $useType string
	 * @return array|string
	 */
	 function commentDestroy($id)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::commentDestroy($id);
		
	 	// 本地备份
	 	if ( isset($response['rst']['id']) && $this->_needLocalCopy() ) {
	 		DR('CommentCopy.delCopy', FALSE, $response['rst']['id']);
	 	}

		return $response;
	 }

	 /**
	  * 批量删除评论 
	  *
	  * @param string $ids 评论id, 多个用逗号隔开(最多20个)
	  * @return array	
	  */
	 function commentDestroyBatch($ids)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['ids|required'] = $ids;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::commentDestroyBatch($ids);
		
	 	// 本地备份
	 	$idList	= $this->_getRspIdList($response['rst']);
	 	if ( !empty($idList) && $this->_needLocalCopy() ) {
	 		DR('CommentCopy.delCopy', FALSE,  $idList);
	 	}
	 	
		return $response;
	 }


	/**
	 * 对一条微博信息进行评论
	 *
	 * @param int|string $id 微博id
	 * @param string $comment 评论内容
	 * @param int|string $cid 要评论的评论id
	 * @return array
	 */
	 function comment($id, $comment, $cid = null)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid_params['comment|required|filter'] = $comment;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::comment($id, $comment, $cid);
		
	 	 // 本地备份
	 	if ( isset($response['rst']['id']) && $this->_needLocalCopy() ) {
	 		DR('CommentCopy.addCopy', FALSE, $response['rst']);
	 	}

		return $response;
	 }
	 
	 /**
	  * 回复微博评论信息
	  *
	  * @param $id int
	  * @param $cid int
	  * @param $comment string
	  * @param $useType string
	  * @return array|string
	  */
	 function reply($id, $cid, $comment)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid_params['cid|required'] = $cid;
		$valid_params['comment|required|filter'] = $comment;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::reply($id, $cid, $comment);

		return $response;
	 }



	 //用户接口

	/**
	 * 根据用户ID获取用户资料（授权用户）
	 *
	 * @param $id int|string
	 * @param $user_id int
	 * @param $name string
	 * @param $useType string
	 * @param bool $oauth 
	 * @return array|string
	 */
	function getUserShow($id = null, $user_id = null, $name = null, $oauth = true)
	{
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id.$user_id.$name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::getUserShow($id, $user_id, $name, $oauth);

		return $response;
	}


	/**
	 * 获取当前用户关注对象列表及最新一条微博信息
	 *
	 * @param $id int|string
	 * @parmas $user_id int
	 * @param $name string
	 * @param $cursor
	 * @param $count
	 * @param $useType string
	 * @return array|string
	 */
	 function getFriends($id = null, $user_id = null, $name = null, $cursor = null, $count = null)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id.$user_id.$name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::getFriends($id, $user_id, $name, $cursor, $count);

		return $response;
	 }


	/**
	 * 获取当前用户粉丝列表及最新一条微博信息
	 *
	 * @param $id int|string
	 * @param $user_id int
	 * @param $name string
	 * @param $cursor string
	 * @param $count int
	 * @param $useType string
	 * @return array|string
	 */
	 function getFollowers($id = null, $user_id = null, $name = null, $cursor = null, $count = null)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id.$user_id.$name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::getFollowers($id, $user_id, $name, $cursor, $count);

		return $response;
	 }

   /**
	* 获取用户优质粉丝列表，每次最多返回20条，包括用户的最新的微博 
	*
	* @param int|string $user_id 用户user id
	* @param int $count 获取条数
	* @param bool $oauth 是否要用身份认证 默认为true需要, false为不需要
	* @return array
	*/
	function getMagicFollowers($user_id, $count = null, $oauth = true)
	{
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $user_id;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::getMagicFollowers($user_id, $count, $oauth);

		return $response;
	}


	/**
	 * 发送一条私信
	 *
	 * @param $id int|string
	 * @param $text string
	 * @param $name string
	 * @param $user_id int
	 * @param $useType string
	 * @return array|string
	 */
	 function sendDirectMessage($id, $text, $name, $user_id = null)
	 {
	    $text = trim($text);
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id.$name;
		$valid_params['text|required|max_length:140'] = $text;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::sendDirectMessage($id, $text, $name, $user_id);

		return $response;
	 }


	/**
	 * 删除一条私信
	 *
	 * @param $id int
	 * @param $useType string
	 * @return array|string
	 */
	 function deleteDirectMessage($id)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::deleteDirectMessage($id);

		return $response;
	 }



	 //关注接口

	/**
	 * 关注某用户
	 *
	 * @param $id int|string
	 * @param $user_id int
	 * @param $name string
	 * @param $follow string
	 * @param $useType string
	 * @return array|string
	 */
	 function createFriendship($id = null, $user_id = null, $name = null, $follow = null)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id.$user_id.$name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::createFriendship($id, $user_id, $name, $follow);

		return $response;
	 }


	/**
	 * 取消关注或移除粉丝
	 *
	 * @param int|string $user_id 用户user id
	 * @param string $name 用户昵称
	 * @param int $is_follower 默认为0。1表示为移除粉丝，0表示为取消关注
	 * @return array
	 */
	 function deleteFriendship($user_id = null, $name = null, $is_follower = 0)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $user_id.$name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::deleteFriendship($user_id, $name, $is_follower);

		return $response;
	 }

	 /**
	  * 批量添加关注
	  *
	  * @param string $ids 用户id, 多个用逗号隔开(最多20个)
	  * @return array	
	  */
	 function createFriendshipBatch($ids)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['ids|required'] = $ids;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::createFriendshipBatch($ids);
		return $response;
	 }


	/**
	 * 是否关注某用户
	 *
	 * @param $user_a int
	 * @param $user_b int
	 * @param $useType string
	 * @return array|string
	 */
	 function existsFriendship($user_a, $user_b)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['user_a|required'] = $user_a;
		$valid_params['user_b|required'] = $user_b;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::existsFriendship($user_a, $user_b);

		return $response;
	 }


	/**
	 * 获取两个用户关系的详细情况
	 *
	 * @param $target_id int
	 * @param $target_screen_name string
	 * @param $source_id int
	 * @param $source_screen_name string
	 * @param $useType string
	 * @return array|string
	 */
	 function getFriendship($target_id = null, $target_screen_name = null, $source_id = null, $source_screen_name = null)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['target_id|required'] = $target_id.$target_screen_name.$source_id.$source_screen_name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::getFriendship($target_id, $target_screen_name, $source_id, $source_screen_name);

		return $response;
	 }



	 //Social Graph接口

	/**
	 * 获取用户关注对象uid列表
	 *
	 * @param $id int
	 * @param $user_id int
	 * @param $name string
	 * @param $cursor string
	 * @param $count int
	 * @param $useType string
	 * @return array|string
	 */
	 function getFriendIds($id = null, $user_id = null, $name = null, $cursor = null, $count = null)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id.$user_id.$name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::getFriendIds($id, $user_id, $name, $cursor, $count);

		return $response;
	 }


	/**
	 * 获取用户粉丝对象uid列表
	 *
	 * @param $id int
	 * @param $user_id int
	 * @param $name string
	 * @param $useType string
	 * @return array|string
	 */
	 function getFollowerIds($id = null, $user_id = null, $name = null, $cursor = null, $count = null)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id.$user_id.$name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 
		
		$response = parent::getFollowerIds($id, $user_id, $name, $cursor, $count);

		return $response;
	 }



	/**
	 * 更改头像
	 *
	 * @param $image string
	 * @param $useType string
	 * @return array|string
	 */
	 function updateProfileImage($image)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['image|required'] = $image;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 
		
		$response = parent::updateProfileImage($image);

		return $response;
	 }


	/**
	 * 更改资料
	 *
	 * @param $name string
	 * @param $gender string
	 * @param $province int
	 * @param $city int
	 * @param $description string
	 * @param $params
	 * @param $useType string
	 * @return array|string
	 */
	 function updateProfile($params)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['any'] = $params;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::updateProfile($params);

		return $response;
	 }


	/**
	 * 注册新浪微博帐号
	 *
	 * @param $params array nick gender password email province city ip
	 * @return array|string
	 */
	 function register($params)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['nick|required'] = isset($params['nick']) ? $params['nick'] : null;
		$valid_params['gender|required'] = isset($params['gender']) ? $params['gender'] : null;
		$valid_params['password|required'] = isset($params['password']) ? $params['password'] : null;
		$valid_params['email|required|valid_sina_email'] = isset($params['email']) ? $params['email'] : null;
		$valid_params['province|required'] = isset($params['province']) ? $params['province'] : null;
		$valid_params['city|required'] = isset($params['city']) ? $params['city'] : null;
		$valid_params['ip|required'] = isset($params['ip']) ? $params['ip'] : null;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::register($params);

		return $response;
	 }

   /**
	* 更新用户提醒设置
	*
	* @param array $params array('comment' => int|string 新评论提醒，0—不提醒，1—提醒，默认值1,
	*							'follower' => int|string 新粉丝提醒，0—不提醒，1—提醒，默认值1,
	*							'dm' => int|string 新私信提醒，0—不提醒，1—提醒，默认值1,
	*							'mention' => int|string @提到我提醒，0—不提醒，1—提醒，默认值1,
	*							'from_user' => int|string 设置哪些提到我的微博计入提醒数，微博作者身份，0--所有人，1—关注的人,
	*							'status_type' => int|string 设置哪些提到我的微博计入提醒数，微博类型，0—所有微博，1—原创的微博)
	* @return array|string
	*/
	function updateNotice($params)
	{
		//检查参数
		$valid_params = array();
		$valid_params['any'] = $params;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
			return $valid;
		}

		$response = parent::updateNotice($params);

		return $response;
	}

	/**
	 * 设置隐私信息
	 *
	 * @param array $params array('comment' => int|string 谁可以评论当前用户的微博 0所有 1我关注的人 默认0, 
	 *								'message' => int|string 谁可以给当前用户发私信 0所有 1我关注的人 默认0, 
	 *								'realname' => int|string 是否允许别人通过真实名称搜索到我 0允许 1不允许 默认1,
	 *								'geo' => int|string 发布微博 是否允许微博保存并显示所处的地理位置 0允许 1不允许 
	 *								默认0, 
	 *								'badge' => int|string 勋章展现状态，值—1私密状态，0公开状态，默认值0)
	 * @return array|string
	 */
	 function updatePrivacy($params)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['any'] = $params;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
			return $valid;
		}

		$response = parent::updatePrivacy($params);

		return $response;
	 }

	/**
	 * 将用户加入黑名单 
	 *
	 * @param int|string $user_id 用户id
	 * @param string $screen_name 用户昵称
	 * @return array
	 */
	function createBlocks($user_id = null, $screen_name = null)
	{
		//检查参数
		$valid_params = array();
		$valid_params['user_id|required'] = $user_id.$screen_name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
			return $valid;
		}
			
		$response = parent::createBlocks($user_id, $screen_name);

		return $response;
	}

	/**
	 * 删除黑名单 
	 *
	 * @param int|string $user_id 用户id
	 * @param string $screen_name 用户昵称
	 * @return array
	 */
	function deleteBlocks($user_id = null, $screen_name = null)
	{
		//检查参数
		$valid_params = array();
		$valid_params['user_id|required'] = $user_id.$screen_name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
			return $valid;
		}
			
		$response = parent::deleteBlocks($user_id, $screen_name);

		return $response;
	}

	/**
	 * 检测是否是黑名单用户  
	 *
	 * @param int|string $user_id 用户id
	 * @param string $screen_name 用户昵称
	 * @return array
	 */
	function existsBlocks($user_id = null, $screen_name = null)
	{
		//检查参数
		$valid_params = array();
		$valid_params['user_id|required'] = $user_id.$screen_name;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
			return $valid;
		}
			
		$response = parent::existsBlocks($user_id, $screen_name);

		return $response;
	}




	/**
	 * 添加收藏
	 *
	 * @param $id int
	 * @param $useType string
	 * @return array|string
	 */
	 function createFavorite($id)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 
		
		$response = parent::createFavorite($id);

		return $response;
	 }


	/**
	 * 删除当前用户收藏的微博信息
	 *
	 * @param $id int
	 * @param $useType string
	 * @return array|string
	 */
	 function deleteFavorite($id)
	 {
		//检查参数
		$valid_params = array();
		$valid_params['id|required'] = $id;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::deleteFavorite($id);

		return $response;
	 }


	// search user

	/**
	 * 搜索微博用户
	 *
	 * @param $params array
	 * @param $useType bool
	 * @return array|string
	 */
	function searchUser($params, $oauth = true)
	{
		//检查参数
		$valid_params = array();
		$valid_params['q|required'] = isset($params['q']) ? $params['q'] : null;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::searchUser($params, $oauth);

		return $response;
	}


	/**
	 * 搜索微博文章
	 *
	 * @param array $param array('base_app' => string,
	 *								'q' => string 关键字,
	 *								'page' => int 页码数,
	 *								'rpp' => int 获取条数,
	 *								'callback' => string,
	 *								'geocode' => string)
	 * @param bool $oauth
	 * @return array
	 */
	function search($params, $oauth = true)
	{
		//检查参数
		$valid_params = array();
		$valid_params['q|required'] = isset($params['q']) ? $params['q'] : null;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 
		
		$response = parent::search($params, $oauth);

		return $response;
	}


	/**
	 * 搜索微博文章
	 *
	 * @param $q string
	 * @param $filter_ori stirng
	 * @param $filter_pic string
	 * @param $province int
	 * @param $city int
	 * @param $starttime string
	 * @param $endtime string
	 * @param $page int
	 * @param $count int
	 * @param $callback string
	 * @param $useType string
	 * @return array|string
	 */
	function searchStatuse($params, $oauth = true)
	{
		//检查参数
		$valid_params = array();
		$valid_params['q|required'] = isset($params['q']) ? $params['q'] : null;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::searchStatuse($params, $oauth);

		return $response;
	}


	/**
	 * 设置某个用户某个新消息的未读数为0
	 *
	 * @param string $type 1--评论数，2--@数，3--私信数，4--关注我的数
	 * @param string $useType
	 * @return unknown
	 */
	function resetCount($type = 1)
	{
		//检查参数
		$valid_params = array();
		$valid_params['type|required|numeric'] = $type;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::resetCount($type);

		return $response;
	}

	/**
	 * 获取授权认证的页面url 
	 *
	 * @param string $callbackUrl 回调url
	 *
	 * @return	
	 */
	function getTokenAuthorizeURL($callbackUrl, $lang = false)
	{
		if (!$lang) {
			switch(APP::getLang()) {
				case 'zh_cn':
					$lang = 'zh-Hans';
					break;
				case 'zh_tw':
					$lang = 'zh-Hant';
					break;
				case 'en':
					$lang = 'en';
					break;
			}
		}

		$token = $this->getRequestToken();
		if (!is_array($token) || !empty($token['errno'])){
			return 	$token;
		}
		$token = $token['rst'];
		USER::setOAuthKey($token, false);

		return RST($this->getAuthorizeURL($token, true, $callbackUrl, $lang));
	}

	/**
	 * 创建标签 
	 *
	 * @param string $tags 标签 多个用逗号隔开
	 * @return array	
	 */
	function createTags($tags)
	{
		//检查参数
		$valid_params = array();
		$valid_params['tags|required|filter|max_length:7'] = $tags;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::createTags($tags);

		return $response; 
	}

	/**
	 * 删除标签 
	 *
	 * @param int|string $tag_id 标签id
	 * @return array	
	 */
	function deleteTags($tag_id)
	{
		//检查参数
		$valid_params = array();
		$valid_params['tag_id|required'] = $tag_id;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		}
		
		$response = parent::deleteTags($tag_id);

		return $response; 
	}

	/**
	 * 将微博接口的表情转为本地替换用的表情数据
	 *
	 *
	 */
	function getRepFaces($lang = false) {
		$rs = DR('xweibo/xwb.emotions', '', $lang);

		$result = array(
			'search' => array(),
			'replace' => array()
		);

		if ($rs['errno'] == 0) {
			foreach ($rs['rst'] as $face) {
				if ($face['type'] == 'face') {
					array_push($result['search'], $face['phrase']);
					array_push($result['replace'], '<img title="'.F('escape', substr($face['phrase'], 1, -1)).'" src="' . $face['url'] .'">');
				}
			}
		}

		return RST($result);
	}
	
	
	

	/**
	  *  添加话题收藏 
	  */
	
	function addSubject($sina_uid,$subject_txt) {
	   $this->db=APP::ADP('db');
       $this->table_subject=$this->db->getTable(T_PAGE_SUBJECT);
	   
	   $sql=sprintf("select id,is_use from %s where sina_uid='%s' and subject='%s';",$this->table_subject,$sina_uid,$subject_txt);
	   $ret=$this->db->query($sql);
	   if(empty($ret)){
			  $data=array('sina_uid'=>$sina_uid, 'subject'=>$subject_txt);
			  $ret=$this->db->save($data,'',T_PAGE_SUBJECT);
			  if($ret){
					 return RST('',0);//正常
			  }
			  else{
					 return RST('',2);//数据库错误
			  }			  
	   }
	   elseif(!empty($ret)&&isset($ret[0])&&$ret[0]['is_use']=='0'){
			  $data=array('is_use'=>1);
			  $id=$ret[0]['id'];
			  $ret=$this->db->save($data,$id,T_PAGE_SUBJECT);
			  if($ret){
					 return RST('',0);//正常
			  }
			  else{
					 return RST('',2);//数据库错误
			  }
			  
	   }
	   else{
			  return RST('',1);//重复记录
	   }
	}
	
	
	/**
	  *  删除话题收藏
	  */
	function deleteSubject($sina_uid,$subject_txt) {
	   $this->db=APP::ADP('db');
       $this->table_subject=$this->db->getTable(T_PAGE_SUBJECT);
	   
	   $sql=sprintf("select id from %s where sina_uid='%s' and subject='%s' and is_use=1;",$this->table_subject,$sina_uid,$subject_txt);
	   $ret=$this->db->query($sql);
	   
	   if(!empty($ret)&&isset($ret[0])){
			  $id=$ret[0]['id'];
			  $data=array('is_use'=>0);
			  $ret=$this->db->save($data,$id,T_PAGE_SUBJECT);
			  if($ret){
					 return RST('',0);//正常
			  }
			  else{
					 return RST('',2);//数据库错误
			  }
			  
	   }
	   else{
			  return RST('',1);//不存在该话题订阅的历史记录
	   }
	}
	

	
	/**
	  *  检查话题是否已被收藏 
	  */
	function isSubjectFollowed($sina_uid,$subject_txt) {
	   $this->db=APP::ADP('db');
       $this->table_subject=$this->db->getTable(T_PAGE_SUBJECT);
	   //查询是不区分话题内容的大小写的
	   $sql=sprintf("select 1 from %s where sina_uid='%s' and subject='%s' and is_use=1;",$this->table_subject,$sina_uid,$subject_txt);
	   $ret=$this->db->query($sql);
	   
	   if(empty($ret)){
			  return RST('',0);//未被收藏
	   }
	   else{
			  return RST('',1);//已被收藏
	   }
	   
		
	}
	
	
	/**
	  *  获取用户订阅的话题列表
	  */
	function getSubjectList($sina_uid) {
	   $this->db=APP::ADP('db');
       $this->table_subject=$this->db->getTable(T_PAGE_SUBJECT);
	   $sql=sprintf("select subject from %s where sina_uid='%s' and is_use=1;",$this->table_subject,$sina_uid);
	   $ret=$this->db->query($sql);
	   return RST($ret);

	}
	
	/**
	 * 获取一批指定用户的微博timeline
	 * 
	 * @param mixed $user_id 用户ID,一次最多20个
	 * @param mixed $screen_name 用户昵称，一次最多20个
	 * @param int $count 指定要返回的记录条数。默认20，最大200
	 * @param int $page 指定返回结果的页码
	 * @param int $feature 微博类型，0全部，1原创，2图片，3视频，4音乐. 返回指定类型的微博信息内容
	 * @param int $base_app 是否基于当前应用来获取数据。1为限制本应用微博，0为不做限制
	 * @param bool $oauth
	 */
	function getBatchTimeline($params, $oauth = true)
	{
		//检查参数
		$valid_params = array();
		$valid_params['user_id|required'] = isset($params['user_id']) ? $params['user_id'] : (isset($params['screen_name']) ? $params['screen_name'] : null);
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		} 

		$response = parent::getBatchTimeline($params, $oauth);

		return $response;
	}
	
	function getStatusesBatchShow($ids, $del_ctrl = true, $oauth = true)
	{
		//检查参数
		$valid_params = array();
		$valid_params['ids|required'] = $ids;
		$valid = $this->validation($valid_params);
		if ($valid !== false) {
		   return $valid; 
		}

		$response = parent::getStatusesBatchShow($ids, $del_ctrl, $oauth);

		return $response;
	}
}
