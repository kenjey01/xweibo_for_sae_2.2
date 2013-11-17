<?php
include(P_ADMIN_MODULES . '/action.abs.php');
class backup_mod extends action {
	function backup_mod()
	{
		parent :: action();
	}

	function backupData() {
		set_time_limit(15);
		$backup_path = P_VAR_BACKUP_SQL;
		if ($this->_isPost()){
			$info = array();
			do {
				$dn = date('Y-m-d_His');//. '_'.rand(1,9999);
			} while (file_exists($backup_path. '/' .$dn));
			if (!mkdir($backup_path. '/' .$dn)) {
				APP::ajaxRst(false, 1040020, '创建备份目录失败');
			}
			$db = APP::ADP('db');
			$br = APP::N('backupAndRestore', $backup_path);
			$br->setConnect($db->getConnect('read'));
			$br->backup($dn);
			APP::ajaxRst(true);
		}
		$index_fn = $backup_path . '/index.php';
		if (file_exists($index_fn)) {
			$records = file($index_fn);
			array_shift($records);
			TPL::assign('records', $records);
		}
		
		$this->_display('db_backup');
	}

	function remove() {
		if (!$this->_isPost()){
			APP::ajaxRst(false, 1040017, '只能使用POST方法');
		}
		$flag = V('p:flags',false);
		if (!$flag) {
			APP::ajaxRst(false, 1040018, '缺少参数');
		}
		
		$br = APP::N('backupAndRestore', P_VAR_BACKUP_SQL);
		$br->del(explode(',', trim($flag, ', ')));
		APP::ajaxRst(true);
	}

	function restore() {
		if (!$this->_isPost()) {
			APP::ajaxRst(false, 1040017, '只能使用POST方法');
		}
		$name = V('r:name', false);
		if (!$name) {
			APP::ajaxRst(false, 1040018, '缺少参数');
		}
		if (!preg_match('/^[a-z\d_\-]+$/i', $name)) {
			APP::ajaxRst(false, 1040019, '参数格式不正确');
		}
		$backup_path = P_VAR_BACKUP_SQL;
		$db = APP::ADP('db');
		$br = APP::N('backupAndRestore', $backup_path);
		$br->setConnect($db->getConnect('write'));
		$br->restore($name);
		APP::ajaxRst(true);
	}
}

