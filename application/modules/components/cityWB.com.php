<?php
/**
* 同城微博
*
* @version $1.1: categoryUser.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class cityWB extends PageModule{

	var $component_id = 8;

	var $wb_cache_time = 60;

	function cityWB() {
		parent :: PageModule();
	}
	
	/*
	 * 获取指定城市、指定条数的微博
	 *
	 * @param $city_code int 城市代号
	 * @param $num 返回的条数，普通用户最多２０
	 *
	 * @return array
	 *
	 */
	function get($province = '', $city = '', $num = null, $page = null, $source=FALSE) {
//		$area = DR('xweibo/xwb.getProvinces');

		$page 	= $page ? $page: 1;
		$source = $source ? $source : (isset($cfg['source']) ? $cfg['source'] : '0');
		
		if (!$num) {
			$cfg = $this->configList();
			$num = $cfg['show_num'] ? $cfg['show_num']: 3;
		}

		//如果没指定，使用用户所设置的地区
		$uid = USER::uid();

		if (!($province || $city) && $uid) {
			$ret = DR('xweibo/xwb.verifyCredentials', 'g/1:300', $uid);
			if ($ret['errno'] == 0) {
				$info = &$ret['rst'];
				$province = $info['province'];
				$city = $info['city'];
			}
		}

		if (USER::isUserLogin() /* && $source*/) {
			$rs = DR('xweibo/xwb.searchStatuse', null, array('base_app' => $source, 'q' => '的', 'city' => $city, 'province' => $province, 'count' => $num * 2, 'page' => $page));
		} else {
			$rs = DR('xweibo/xwb.searchStatuse', null, array('base_app' => $source, 'q' => '的', 'city' => $city, 'province' => $province, 'count' => $num * 2, 'page' => $page), false);
		}

		if ($rs['errno'] == 0 && count($rs['rst']) > $num) {
			$rs['rst'] = array_slice($rs['rst'], 0, $num);
		}

		return $rs;
	}
}
