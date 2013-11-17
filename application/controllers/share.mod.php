<?php
/**
 * 转发模块（前台）
 * @author yaoying<yaoying@staff.sina.com.cn>
 * @version $Id: share.mod.php 16573 2011-05-30 08:52:05Z heli $
 *
 */
class share_mod{
	/**
	 * 关联帐号用户数据
	 * @var array
	 */
	var $_relateUidData = array();
	
	function share_mod(){
	}
	
	function default_action(){
		$this->main();
	}
	
	/**
	 * 显示转发用户操作页面
	 */
	function main(){
		$assignData = array();
		$url = (string)V('G:url');
		$title = (string)V('G:title');
		
		if(empty($url)){
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__share__paramNotUrl')));
		}
		
		$this->_getRelateUidData();
		
		$assignData['text'] = $this->_organizeText($url, $title);
		$assignData['relateUid'] = isset($this->_relateUidData['id']) ? $this->_relateUidData['id'] : 0;
		$assignData['sharecallbackurl'] = $this->_organizeSwitchUrl($url, $title, $assignData['relateUid']);
		TPL::module('share/main', $assignData);
	}
	
	/**
	 * 显示转发成功的页面
	 */
	function success(){
		$this->_getRelateUidData();
		
		$friendshipExist = false;
		if(isset($this->_relateUidData['id'])){
			if($this->_relateUidData['id'] != USER::uid()){
				$friendShipCheck = DR('xweibo/xwb.existsFriendship', null, USER::uid(), $this->_relateUidData['id']);
			}
			if(isset($friendShipCheck['rst']['friends']) && (bool)$friendShipCheck['rst']['friends'] == true){
				$friendshipExist = true;
			}
		}
		
		$assignData['relateUidData'] = $this->_relateUidData;
		$assignData['friendshipExist'] = $friendshipExist;
		TPL::module('share/success', $assignData);
	}
	
	/**
	 * 组织文字
	 * @param string $url
	 * @param string $title
	 * @return string
	 */
	function _organizeText($url, $title){
		$text = urldecode($title). ' '. $url;
		if(isset($this->_relateUidData['screen_name'])){
			$text .= L('controller__share__fromWho', $this->_relateUidData['screen_name']);
		}
		return $text;
	}
	
	/**
	 * 根据relateUid，获取对应的用户数据并填充到{@link share_mod::_relateUidData}中
	 */
	function _getRelateUidData(){
		$relateUid = (string)V('r:relateUid');
		if(!is_numeric($relateUid) || $relateUid < 1){
			return ;
		}
		
		$userinfo = DR('xweibo/xwb.getUserShow', null, null, $relateUid);
		if($userinfo['errno'] != 0 || !isset($userinfo['rst']) || !is_array($userinfo['rst'])){
			return ;
		}else{
			$this->_relateUidData = $userinfo['rst'];
		}
	}
	
	/**
	 * 组织"换个帐号"的链接
	 * @param string $url
	 * @param string $title
	 * @param bigint $relateUid
	 * @return URL
	 */
	function _organizeSwitchUrl($url, $title, $relateUid){
		$sharecallbackurl = URL('share', 'url='. urlencode($url). '&title='. urlencode($title). '&relateUid='. $relateUid);
		return URL('account.logout', 'loginCallBack='. urlencode(URL('account.login', 'loginCallBack='. urlencode($sharecallbackurl))));
	}
	
}
