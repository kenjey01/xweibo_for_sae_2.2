<?php
class accountProxy{
	/**
	 * 添加一个代理帐号
	 */
	function add($data) {
		$db = APP::ADP('db');
		$db->setTable(T_ACCOUNT_PROXY);
		$db->setIgnoreInsert(true);
		$rs = $db->save($data);
		return RST($rs);
	}

	/**
	 * 得到帐号列表
	 */
	function getList() {
		$db = APP::ADP('db');
		$db->setTable(T_ACCOUNT_PROXY);
		$rs = $db->query('SELECT * FROM '. $db->getTable(T_ACCOUNT_PROXY));
		return RST($rs);
	}

	/**
	 * 删除帐号
	 */
	function delAccount($id) {
		$db = APP::ADP('db');
		$db->setTable(T_ACCOUNT_PROXY);
		$rs = $db->delete($id);
		return RST($rs);
	}

	/**
	 * 判断是否已经设置代理帐号
	 */
	function issetProxy() {
		$list = $this->getList();
		$rs = !empty($list['rst']);
		return RST($rs);
	}

	/**
	 * 得到随机帐号
	 */
	function getRandomAccount() {
		$rows = $this->getList();
		$count = count($rows['rst']);
		if ($count < 1) {
			return RST(false);
		}
		$rand = rand(0, $count-1);
		return RST($rows['rst'][$rand]);
	}
}
?>
