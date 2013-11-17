<?php
/**************************************************
*  Created:  2010-10-27
*
*  文件说明
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/
class userCom {

	/*
	 * 插入或更新一条用户登录数据
     * @param array() $data		用户数据数组
	 * @param int $id		sina_uid
     * @return boolean
	 */
	function insertUser($data, $id = '') {
		if(!is_array($data)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}
		
		$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_USERS);
		$rs = $db->save($data, $id, '', 'sina_uid');
		
		return RST($rs);
	}

	/**
	 * 返回统计所有微博数
	 * @return int
	 */
	function counts($type = '') {
		$db = APP :: ADP('db');
		$sql = 'SELECT COUNT(*)AS count FROM ' . $db->getTable(T_USERS);
		if ($type === 'today')  {
			$sql .= ' WHERE  FROM_UNIXTIME(`first_login`,"%Y%m%d")="'. date('Ymd') . '"';
		}
		$count = $db->getOne($sql);
		return RST($count);
	}

	/*
	* 根据用户名称获取用户数据
    * @param string $nickname
    * @param int $offset
    * @param int $each
    * @return array()
	*/
	function getByName($nickname, $offset = 0, $each = 0) {
		if (!is_numeric($offset) || !is_numeric($each)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');
		$keyword = (string)$db->escape($nickname);

		$where = $limit = "";
		if($keyword !== '') {
			$where = ' WHERE `nickname` LIKE "%' . $keyword . '%" ';
		}

		if($each) {
			$limit =  ' LIMIT ' . $offset . ',' . $each;
		}

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USERS. $where . ' ORDER BY `first_login` DESC ' . $limit;
		return RST($db->query($sql));
	}
	
	
   /**
	* 根据用户名称获取用户SinaID
    * @param string $nickname
    * @return bigint
	*/
	function getSinaUidByName($nickname) 
	{
		if( $nickname=$db->escape($nickname) ) 
		{
			$db 	= APP::ADP('db');
			$table 	= $db->getTable(T_USERS);
			$sql	= "Select sina_uid From $table Where nickname='$nickname'";
			return $db->getOne($sql);
		}

		return FALSE;
	}
	

	/**
	* 根据sina_uid称获取用户数据
    * @param int $sina_uid
    * @return array()
	*/
	function getByUid($sina_uid) {
		if (!is_numeric($sina_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}
	
		$db = APP :: ADP('db');
		$sina_uid = $db->escape($sina_uid);

		$where = " WHERE `sina_uid` = '" . $sina_uid . "'"; 

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USERS. $where . ' ORDER BY `sina_uid` DESC ';
		return RST($db->getRow($sql));
	}

	/**
	* 根据附属站 uid称获取用户数据
    * @param int $sina_uid
    * @return array()
	*/
	function getBySiteUid($site_uid) {
		if (!is_numeric($site_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}
	
		$db = APP :: ADP('db');
		$site_uid = $db->escape($site_uid);

		$where = " WHERE `uid` = '" . $site_uid . "'";

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USERS. $where . ' ORDER BY `sina_uid` DESC ';
		return RST($db->getRow($sql));
	}
	
 	/**
	* 获取所有的用户加V用户
    * @param int $offset
    * @param int $each
    * @return boolean
	*/
	function getAllVerify($offset = 0, $each = 0) {
		if (!is_numeric($offset) || !is_numeric($each)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}
                                
		$db = APP :: ADP('db');

		$limit = "";
		if($each) {
			$limit =  ' LIMIT ' . $offset . ',' . $each;
		}
		
		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_VERIFY. ' ORDER BY `add_time` DESC ' . $limit;
		return RST($db->query($sql));
	}
	
	/**
	 * 得到一key/value对应的认证用户列表,其中key为sina_uid,value为用户昵称
	 * @return array
	 */
	function getVerify() {
		$db = APP::ADP('db');
		$sql = 'SELECT * FROM ' . $db->getTable(T_USER_VERIFY);
		$rst = $db->query($sql);
		if ($rst === false) {
			return RST(false);
		}
		$data = array();
		for ($i=0,$count=count($rst); $i<$count; $i++) {
			$data[(string)$rst[$i]['sina_uid']] = array('nick' => $rst[$i]['nick'], 'reason' => $rst[$i]['reason']);
		}
		return RST($data);
	}

	/**
	* 根据用户id获取被禁封用户
    * @param int $sina_uid
    * @return array
	*/
	function getUseBanById($sina_uid) {
		if(empty($sina_uid)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}

		if (!is_numeric($sina_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_BAN . ' WHERE `sina_uid` = "' . $sina_uid . '"  ORDER BY `sina_uid` DESC';
		return RST($db->getRow($sql));
	}

	/**
	* 根据用户昵称获取被禁封用户
    * @param string $name
    * @return array
	*/
	function getUseBanByName($name, $offset = 0, $each = 0) {
		$where = '';
		$db = APP :: ADP('db');
		$name = $db->escape($name);
		if($name) {
			$where = ' WHERE `nick` like "%' . $name . '%"';
		}

		$limit = "";
		if($each) {
			$limit =  ' LIMIT ' . $offset . ',' . $each;
		}

		$db = APP :: ADP('db');

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_BAN . $where . ' ORDER BY `ban_time` DESC ' . $limit;
		return RST($db->query($sql));
	}

	/**
	* 根据用户id获取用户是否加V
    * @param int $sina_uid
    * @return boolean
	*/
	function getVerifyById($sina_uid) {
		if (!is_numeric($sina_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');
		$keyword = $db->escape($sina_uid);

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_VERIFY. ' WHERE `sina_uid` = "' . $keyword . '" ORDER BY `sina_uid` DESC ';
		if($db->getOne($sql)) {
			return RST(true);
		}else{
            return RST(false);
		}
	}

    /*
     * 存储用户加v
     * @param int $id
     * @param array $data
     * @return boolean
     */
	function saveVerify($data, $id = '', $id_name = 'id') {
		$db = APP :: ADP('db');
		$this->_cleanCache();
		$db->save($data, $id, T_USER_VERIFY, $id_name);
		return RST(true);
	}

    /*
     * 删除用户加v
     * @param int $id
     * @return boolean
     */
	function delVerify($id) {
		$db = APP :: ADP('db');
		$db->setTable(T_USER_VERIFY);
		$this->_cleanCache();
		return RST($db->delete($id, '', 'sina_uid'));
	}

	/**
	* 根据sina_uid获取用户是否为封禁用户
    * @param int $sina_uid
    * @return boolean
	*/
	function getBanByUid($sina_uid) {
		if(empty($sina_uid)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}

		if (!is_numeric($sina_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');
		$keyword = $db->escape($sina_uid);

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_BAN. ' WHERE `sina_uid` = ' . $keyword . ' ORDER BY `sina_uid` DESC ';
		if($db->getOne($sql)) {
             return RST(true);
		}else{
             return RST(false);
		}
	}

    /*
     * 存储禁封用户
     * @param int $id
     * @param array $data
     * @return boolean
     */
	function saveBan($data, $id = '') {
		$db = APP :: ADP('db');
		$db->setTable(T_USER_BAN);
		$this->_cleanCache();
        return RST($db->save($data, $id));
	}


    /*
     * 删除禁封用户
     * @param int $id
     * @return boolean
     */
	function delBan($id) {
		$db = APP :: ADP('db');
		$db->setTable(T_USER_BAN);
		$this->_cleanCache();
		return RST($db->delete($id, '', 'sina_uid'));
	}

	/*
	 * 清除缓存
	 */
	function _cleanCache() {
		DD('mgr/userCom.getByUid');
		DD('mgr/userCom.getByName');
		DD('mgr/userCom.getBySiteUid');
		DD('mgr/userCom.getAllVerify');
		DD('mgr/userCom.getVerify');
		DD('mgr/userCom.getUseBanById');
		DD('mgr/userCom.getUseBanByName');
		DD('mgr/userCom.getVerifyById');
		DD('mgr/userCom.getBanByUid');
	}
	
	
  /**
    * 设置用户的短domain
    * 
    * @param mixed $uid
    * @param mixed $domain
    */
    function setUserDomain($uid, $domain) 
    {
    	if ($uid && $domain)
    	{
	        $db  	= APP::ADP('db');
	        $table 	= $db->getTable(T_USERS);
	        $domain = $db->escape($domain);
	        $sql 	= "Update $table Set domain_name='$domain' Where sina_uid='$uid'";
	        
	        if ($db->execute($sql) !== false)
	        {
	        	USER::set('domain_name', $domain);
	        	return TRUE;
	        }
    	}
    	return FALSE;
    }
    
    
    /**
    * 根据用户短域名，从数据查询用户　
    * 
    * @param mixed $domain
    */
    function getUidByDomain($domain) 
    {
    	if ($domain)
    	{
	        $db  	= APP::ADP('db');
	        $table 	= $db->getTable(T_USERS);
	        $domain = $db->escape($domain);
	        return $db->getOne("Select sina_uid From $table Where domain_name='$domain'");
    	}
    	return FALSE;
    }
    
    
    /**
    * 根据用户短域名，从数据查询用户　
    * 
    * @param mixed $domain
    */
    function isDomainExist($domain) 
    {
    	$result = FALSE;
    	
    	if ($domain)
    	{
	        $db  	= APP::ADP('db');
	        $table 	= $db->getTable(T_USERS);
	        $domain = $db->escape($domain);
	        
	        // 检查是否已有用户设置相同域名
	        $result = $db->getRow("Select * From $table Where domain_name='$domain'");
	        
	        // 检查是否域名保留字
	        if ( empty($result) )
	        {
	        	$kdTable = $db->getTable(KEEP_USERDOMAIN);
	        	$result  = $db->getRow("Select * From $kdTable Where keep_domain='$domain'");
	        }
    	}
    	return empty($result) ? FALSE : TRUE;
    }
	/**
	  *  对某个用户进行操作 
	  */
	function setUserAction($sina_uid,$action_type){
		if(isset($sina_uid)&&in_array($action_type,array(1,2,3,4))){
			$db  	= APP::ADP('db');
			$table 	= $db->getTable(T_USER_ACTION);
			$rst=$db->query(sprintf("select id from %s where sina_uid='%s'",$table,$sina_uid));
			if(empty($rst)){
				$id='';
			}
			else{
				$id=$rst[0]['id'];
			}
			$rst=$db->save(array('sina_uid'=>$sina_uid,'action_type'=>$action_type),$id,T_USER_ACTION);
			if($rst){
				return TRUE;
			}
		}
		else{
			return NULL;
		}
	}
	
	/**
	  *  获取是所有禁止用户列表 
	  */
	function getUserActionList(){
			$db  	= APP::ADP('db');
			$table 	= $db->getTable(T_USER_ACTION);
			$rst=$db->query(sprintf("select sina_uid,action_type from %s",$table));
			return RST($rst);
	}
	
	/**
	  *  获取某用户的看控制列表
	  *  
	  */
	function getUserAction($sina_uid){
			$db  	= APP::ADP('db');
			$table 	= $db->getTable(T_USER_ACTION);
			$rst=$db->query(sprintf("select action_type from %s where sina_uid=%s",$table,$sina_uid));
			if(empty($rst)){
				$rst=array();
				$rst[0]=array();
				$rst[0]['action_type']=4;
			}
			return RST($rst);
	}
	
	
	/**
	 * 获取新浪关系的 本地关注排行版
	 * @param $showNum
	 */
	function getSinaFollowerTop($showNum)
	{
		$db  	= APP::ADP('db');
		$table	= $db->getTable(T_USERS);
		$sql	= "Select sina_uid From $table Order By followers_count Desc Limit $showNum";
		$temp	= $db->query($sql);
		$list	= array();
		
		if (is_array($temp))
		{
			foreach($temp as $val)
			{
				array_push($list, $val['sina_uid']);
			}	
		}
		return $list;
	}
	
}
