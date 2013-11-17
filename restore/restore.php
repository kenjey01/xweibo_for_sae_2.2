<?php

if (!(isset($_POST['db_host']) && isset($_POST['db_user']) && isset($_POST['db_password']) && isset($_POST['db_schema']))) {
	die('{"rst":false, "errno":1040023, "err":请填写数据库的相关信息}');
}

$connect = mysql_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_password']);
if (!$connect) {
	die('{"rst":false, "errno":1040021, "err":错误的帐号密码}');
}
$select_db = mysql_select_db($_POST['db_schema']);
if (!$select_db) {
	die('{"rst": false, "errno":1040022, "err":"指定的数据库可能不存在"}');
}
mysql_query('SET NAMES UTF8', $connect);


include('../user_config.php');
include('../application/cfg.php');
include('../application/class/backupAndRestore.class.php');

$index_fn =P_VAR_BACKUP_SQL . '/index.php';
if (!file_exists($index_fn)) {
	die('{"rst": false, "errno":1040024, "err":"没有可以恢复的数据"}');
}
$f = file($index_fn);
array_shift($f);
$info = array_pop($f);
if (!$info) {
	die('{"rst": false, "errno":1040024, "err":"没有可以恢复的数据"}');
}
$info = explode('|', $info);
$sql_index_fn = P_VAR_BACKUP_SQL . '/' . $info[0] . '/backup_index.php';
if (!file_exists($sql_index_fn)) {
	die('{"rst": false, "errno":1040024, "err":"没有可以恢复的数据"}');
}

$br = new backupAndRestore(P_VAR_BACKUP_SQL);
$br->setConnect($connect);
$br->restore($info[0]);

die('{"rst": true, "errno":0, "err":""}');

?>
