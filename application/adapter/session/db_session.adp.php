<?php
/**
 * @file			db_session.adp.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2011-03-18
 * @Modified By:	heli/2011-03-21
 * @Brief			数据库存储session 处理类
 */

class db_session {
	var $sess_id	= null;
    var $key		= 'sess_';
    var $timeout	= 1800;

	var $sess_db_host;
	var $sess_db_name;
	var $sess_db_user;
	var $sess_db_passwd;
	var $sess_db_port;
	var $sess_link = null;
	var $sess_table;

	function db_session() {
		$this->sess_db_host = DB_HOST;
		$this->sess_db_name = DB_NAME;
		$this->sess_db_user = DB_USER;
		$this->sess_db_passwd = DB_PASSWD;
		$this->sess_db_port = DB_PORT;
		$this->sess_table = DB_PREFIX.'sessions';
	}

	function adp_init($config=array()) {
		$this->db_session();
	}

	/**
	 * session 开始存储之前执行的方法
	 *
	 */
	function open(){
		$this->sess_link = @mysql_connect($this->sess_db_host, $this->sess_db_user, $this->sess_db_passwd);
		if (!$this->sess_link) {
			echo "MySQL Error: " . mysql_error();
		}

		if (!mysql_select_db($this->sess_db_name, $this->sess_link)) {
			echo "MySQL Error: " . mysql_error();
		}

		mysql_query("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary, sql_mode=''");
	}

	/**
	 * 存储session变量的值
	 */
	function write($id, $data) {
		$expiry = time() + $this->timeout;
		$value = addslashes($data);
		$key = md5($this->key . $id);

		$sql = "REPLACE INTO $this->sess_table VALUES ('$key', $expiry, '$value')";
		$ret = mysql_query($sql, $this->sess_link);

		return $ret;

		/*
		$sql = "INSERT INTO $this->sess_table VALUES ('$key', $expiry, '$value')";
		$ret = mysql_query($sql, $this->sess_link);

		if (!$ret) {
			$sql = "UPDATE $this->sess_table SET expiry = $expiry, value = '$value' WHERE sesskey = '$key' AND expiry > " . time();
			$ret = mysql_query($sql, $this->sess_link);
		}

		return $ret;
		 */
    }

	/**
	 * 读取session存储的值
	 */
    function read($id) {
		$key = md5($this->key . $id);
		$sql = "SELECT value FROM $this->sess_table WHERE sesskey = '$key' AND expiry >	" . time();
		$result = mysql_query($sql, $this->sess_link);

		if ($result) {
			if (list($value) = mysql_fetch_row($result)) {
				return $value;
			}
		}

		return false;
    }

	/**
	 * session 存储完后执行的方法
	 */
	function close(){
		mysql_close($this->sess_link);
		return true;
	}

	/**
	 * session 存储值过期执行的方法
	 */
	function gc(){
		$sql = "DELETE FROM $this->sess_table WHERE expiry < " . time();
		$result = mysql_query($sql, $this->sess_link);

		return mysql_affected_rows($this->sess_link);
	}

	/**
	 * 消除session值
	 */
	function destroy($id) {
		$key = md5($this->key . $id);
		$sql = "DELETE FROM $this->sess_table WHERE sesskey = '$key'";
		$ret = mysql_query($sql, $this->sess_link);

		return $ret;
	}
}
