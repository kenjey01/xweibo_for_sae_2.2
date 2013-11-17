<?php
include(P_ADMIN_MODULES . '/action.abs.php');
class ad_mod extends action {

	function ad_mod() {
		parent :: action();
	}

	function ad_list() {
			DD('ad.getUsingAd');
		// 所有已启用的广告
		$data = DS('ad.getUsingAd', 'g0', 1);
		//TPL::assign('using_data', $data);
		// 被禁用的广告
		$data2 = DS('ad.getUsingAd', 'g0', 0);
		$data = array_merge($data, $data2);
		TPL::assign('data', $data);
		$this->_display('ad/ad_manager');
	}

	function stateChg() {
		$id = V('g:id');
		if (!$id) {
			$this->_error('设置失败，缺少广告ID', array('ad_list'));
		}
		$state = V('g:state', 0);
		if ($state != 0) {
			$state = 1;
		}
		$data = array(
				'using' => $state
				);
		$rs = DS('ad.save', '', $data, $id);
		if ($rs) {
			DD('ad.getUsingAd');
		}
		$this->_redirect('ad_list');
	}

	function edit() {
		$id = V('g:id');
		if (!$id) {
			$this->_error('设置失败，缺少广告ID', array('ad_list'));
		}
		if ($this->_isPost()) {
			$content = V('p:content', '');
			$data = array(
					'content' => $content,
					'add_time' => time()
					);
			if (in_array(V('p:flag'), array('global_left', 'global_right'))) {
				$data['config'] = json_encode(array('topic_get' => V('p:topic_get')));
			}
			$rs = DS('ad.save', '', $data, $id);
			if ($rs) {
				DD('ad.getUsingAd');
			}
			$this->_succ('已经成功保存，现返回到管理页面',array('ad_list'));
		}
		$data = DS('ad.getAd', '', $id);
		$config = $data['config'];
		if (empty($config)) {
			$config = '[]';
		}
		$config = json_decode($config, true);
		TPL::assign('config', $config);
		TPL::assign('data', $data);
		$this->_display('ad/ad_setting');
	}

	function _getPartnerConfig() {
		$info = array(
				'partnerid' => 40602,
				'name' => 'ChinaZ联盟',
				'template' => <<<EOT
<script>
PFP_CONF = {
			'partnerid': {partnerid;}, // 联盟ID
			'siteid': {siteid;}, // 站点ID
			'blockid': {blockid;} // 广告位ID
		};
</script>
<script type="text/javascript" src="http://pfp.sina.com.cn/pfpnew/xweibo/pfp.js"></script>
EOT
);
		$ad_site_id = DS('common/sysConfig.get', '', 'ad_setting');
		if (!$ad_site_id) {
			return false;
		}
		//$result = DR('common/sysConfig.set', '', $key, $value);
		$info['siteid'] = $ad_site_id;
		return $info;
	}

	function _getAdCode($ad_info) {
		$cfg = $this->_getPartnerConfig();
		if (!$cfg) {
			return false;
		}
		// 该部分内容可以写入数据库
		$mapping = array(
			'global_global_bottom' => 2,
			'global_global_left' => 1,
			'global_global_right' => 6,
			'pub_sidebar' => 5,
			'pub_today_topic' => 3,
			'index_publish' => 4,
			'index_sidebar' => 5,
			'ta_sidebar' => 5
		);
		$find = array(
				'{width;}',
				'{height;}',
				'{partnerid;}',
				'{siteid;}',
				'{blockid;}',
				'{format;}'
				);
		$replace = array(
				$ad_info['width'],
				$ad_info['height'],
				$cfg['partnerid'],
				$cfg['siteid'],
				$mapping[$ad_info['page'] . '_' . $ad_info['flag']],
				'iframe'
				);
		return str_replace($find, $replace, $cfg['template']);
	}

	function getAd() {
		$aid = V('r:aid');
		if (!$aid) {
			exit;
		}
		$info = DS('ad.getAd', '', $aid);
		echo $this->_getAdCode($info);
	}

	/**
	 * 替换所有广告“广告标识码”
	 */
	function _replaceAllAdCode($code) {
		$info = DS('ad.getAd', '');
		$data = array(
				'content' => '',
				'add_time' => time(),
				'using' => 1
				);
		foreach ($info as $row) {
			$data['content'] = $this->_getAdCode($row);//preg_replace('/([\'"]siteid[\'"][ \t]*:[ \t]*[\'"])[^,}\n]+([\'"].*[\n,])/', '${1}' .$code . '\\2', $row['content']);
			$rs = DS('ad.save', '', $data, $row['id']);
		}
		DD('ad.getUsingAd');
	}

	function adSetCode() {
		if ($this->_isPost()) {
			// 保存代码
			$code = V('p:code', '');
			if (empty($code)) {
				$this->_error('请填写广告标识码', array('adSetCode'));
			}
			DS('common/sysConfig.set', '', 'ad_setting', $code);
			// 替换所有广告
			$this->_replaceAllAdCode($code);
			$this->_succ('已经成功保存并替换所有广告', array('adSetCode'));
		}
		$ad_site_id = DS('common/sysConfig.get', '', 'ad_setting');
		if (!$ad_site_id) {
			$ad_site_id = '';
		}
		TPL::assign('ad_site_id', $ad_site_id);
		$this->_display('ad/china_z');
	}
}
