<?php
function ajaxRst($rst,$errno=0,$err='', $return = false) {
	$r = array('rst'=>$rst,'errno'=>$errno*1,'err'=>$err);
	if ($return) {
		return json_encode($r);
	}
	else {
		header('Content-type: application/json');
		echo json_encode($r);exit;
	}
}
/**
* 数据备份类
* 该程序认为数据表结构已存在
*/
class backupAndRestore{
	var $table_prefix = ''; // 表前缀

	var $connect = null; // mysql连接
	var $rowLimit = 10; // 每次读取的记录数
	var $sqlSizeLimit; // SQL长度
	var $fileSizeLimit;// 单一文件大小

	var $file_prefix = 'backup_';
	var	$file_index = 1; // 文件名索引
	var	$file_suffix = '.sql.php';
	var $dump_path = '';	// 存放备份文件路径 
	var $base_path = ''; // 存放备份文件基础目录
	var $index_file = ''; // 备份索引文件

	/**
	 * 初始化
	 * @param $dump_base_path string 备份文件存放基础目录
	 */
	function backupAndRestore($dump_base_path) {
		$this->base_path = $dump_base_path;
	}

	/**
	 * 设置mysql连接资源符
	 * @param $connect source mysql连接资源符
	 */
	function setConnect($connect) {
		$this->connect = $connect;
	}

	/**
	 * 导出指定前缀的数据表，默认导出所有表
	 * @param $prefix string 表前缀
	 */
	function setTablePrefix($prefix = '') {
		$this->table_prefix = $prefix;
	}

	/**
	 * 删除记录
	 * @param $path array|string 记录标识
	 */
	function del($path) {
		$path = (array)$path;
		// 测试目录是否存在
		for ($i=0,$count=count($path); $i<$count; $i++) {
			$path[$i] = trim($path[$i], '/');
			$p = $this->base_path .'/'. $path[$i] . '/';
			if (!is_dir($p)) {
				return false;
			}
		}
		// 删除索引文件中对应的记录
		$r_path = array();// 成功删除的记录路径
		$fn = P_VAR_BACKUP_SQL .'/index.php'; 
		$f = file ($fn);
		$index = array();
		foreach ($f as $i => $r) {
			$e = explode('|', $r);
			if (in_array($e[0] , $path)) {
				$r_path[] = $e[0];
			} else {
				$index[] = trim($r, "\n");
			}
		}
		$f = implode("\n", $index) . "\n";
		file_put_contents($fn, $f);

		for ($i=0,$count=count($r_path); $i<$count; $i++) {
			$path = $this->base_path .'/'. $r_path[$i] . '/';
			F('clearDir', $path);
			rmdir($path);
		}
	}

	function restore($path) {
		$path = trim($path, '/');
		if (!$this->connect) {
			//die('请先使用connect()方法连接数据库');
			ajaxRst(false, 1040025, '请先使用connect()方法连接数据库');
		}
		$this->dump_path = $this->base_path .'/'. $path . '/';
		$this->index_file = $this->dump_path . $this->file_prefix . 'index' . '.php';
		$files = file($this->index_file);
		array_shift($files);
		foreach ($files as $file) {

			$file = trim($file,"\n");
			if (!is_file($this->dump_path . $file)) {
				//exit('找不到文件:' . $file);
				ajaxRst(false, 1040027, '找不到文件要恢复的文件');
			}
		}
		
		foreach ($files as $file) {
			$file = trim($file,"\n");
			$sqls = file($this->dump_path . $file);
			array_shift($sqls);
			for ($i=0,$count=count($sqls); $i<$count; $i++) {
				$rs = mysql_query($sqls[$i], $this->connect);
				if (!$rs) {
					//die(mysql_error($this->connect) . "<br />\n SQL:" .$sqls[$i]);
					ajaxRst(false, 1040028, '执行备份的SQL时出错');
				}
			}
		}
		return true;
	}

	/**
	 * 导出数据库,导出前请先用connect()连接数据库
	 * @param $path string 备份的相对目录(前后不带'/')
	 */
	function backup($path) {
		$path = trim($path, '/');
		if (!$this->connect) {
			//die('请先使用connect()方法连接数据库');
			ajaxRst(false, 1040025, '请先使用connect()方法连接数据库');
		}
		if (!is_dir($this->base_path . '/' . $path)) {
			//die('指定的存放路径不存在');
			ajaxRst(false, 1040026, '指定的存放路径不存在');
		}
		$this->dump_path = $this->base_path .'/'. $path . "/";
		$this->index_file = $this->dump_path . $this->file_prefix . 'index' . '.php';
		$this->fileSizeLimit = 1024 * 1024; // 限制单一文件大小为2M
		$this->sqlSizeLimit = 1 *1024; // 限制一条SQL长度
		
		file_put_contents($this->index_file, '<?php exit("Access deny");?>'. "\n");
		
		// 开始备份
		$total_size = $this->dump();

		// 写入备份日志
		$index_fn = $this->base_path . '/index.php';
		if (!file_exists($index_fn)) {
			$str = '<?php exit("Access deny");?>' . "\n";
			file_put_contents($index_fn, $str);
		}
		$index_info = $path . '|' . $total_size . '|' . date('Y-m-d H:i:s') . "\n";
		file_put_contents($index_fn, $index_info, FILE_APPEND);
	}

	/**
	 * 连接数据库
	 * @param $host string mysql主机
	 * @param $user string mysql用户名
	 * @param $password string mysql密码
	 * @param $db string 要连接的数据表名
	 * @param $charset string 数据库使用的字符集
	 * @return source mysql连接资源符
	 */
	function connect($host, $user, $password, $db, $charset='UTF8') {
		$connect = mysql_connect($host, $user, $password);
		if (!$connect) {
			//die('connect error');
			ajaxRst(false, 1040029, '连接时出错，可能输入的帐号信息不正确');
		}
		mysql_select_db($db, $connect);
		mysql_query('SET NAMES '. $charset);
		return $this->connect = $connect;
	}

	/**
	 * 导出数据
	 * @return int 导出的文件总大小
	 */
	function dump() {
		$tables = $this->getTables($this->table_prefix);
		$total_size = 0;
		for ($i=0,$count=count($tables);$i < $count; $i++) {
			$total_size += $this->getTableSql($tables[$i]);
		}
		return $total_size;
	}

	/**
	 * 导出单一表的数据
	 * @param $table string 数据表名
	 * @return int 导出指定表的文件总大小
	 */
	function getTableSql($table) {
		$sql_dump = '';
		
		// 记录所有文件
		$files = array();

		// 得到记录行数
		$sql = 'SELECT COUNT(*) FROM '.$table;
		$rs = mysql_query($sql);
		$rs = mysql_fetch_row($rs);
		$counts = $rs[0];

		$base_sql = 'SELECT * FROM ' . $table;
		$limit = ceil($counts/$this->rowLimit);
		$dump_sql_size = 0;
		$dump_sql_base = '';
		$dump_sql_base_size = 0;
		$has_base_sql = false;
		$file_data = '<?php exit("Access deny");?>' . "\n" . 'TRUNCATE TABLE `' . $table . "`;\n";
		$backup_size = 0; //备份该表使用的空间
		$data = array();
		for ($i=0; $i < $limit ;$i++) {
			$sql = $base_sql . ' LIMIT ' . ($i * $this->rowLimit) . ',' . $this->rowLimit;
			$rs = mysql_query($sql, $this->connect);
			while($row = mysql_fetch_assoc($rs)) {
				// 取得insert 头
				if (!$has_base_sql) {
					$dump_sql_base .= 'INSERT INTO `' . $table . '`';
					// 
					$fields = array();
					foreach ($row as $key=>$value) {
						$fields[] = $key;
					}
					$dump_sql_base .= '(`' . implode('`,`', $fields). '`) VALUES ';
					$dump_sql_base_size = strlen($dump_sql_base);
					$has_base_sql = true;
				}

				$tmp = array();
				foreach ($row as $v) {
					$tmp[] = mysql_real_escape_string($v);
				}

				$str = '("' .implode('","', $tmp) . '")';

				$str_size = strlen($str);
				// 如果sql长度大于sql长度限制，则新建一条sql
				if ($dump_sql_size + $str_size > $this->sqlSizeLimit) {
					$sql_data = implode(',', $data) . ";\n";
					$sql_dump = $dump_sql_base . $sql_data;
					// 如果长度大于文件大小限制，则新建一个文件
					if (strlen($file_data . $sql_dump) > $this->fileSizeLimit) {
						// 写文件
						$fn =  $this->file_prefix . $table . '_' . $this->file_index . $this->file_suffix;
					
						$files[] = $fn;
						$fn = $this->dump_path . $fn;
						file_put_contents($fn, "<?php exit('Access deny');?>\n");
						file_put_contents($fn, $file_data, FILE_APPEND);
						$backup_size += strlen($file_data);
						$this->file_index++;
						$file_data = '';
					}

					$file_data .= $sql_dump;
					$dump_sql_size = $dump_sql_base_size;
					$data = array();
				}
				$dump_sql_size += $str_size;
				$data[] = $str;
			}
			
		}
		if (!empty($data)) {
			$sql_data = implode(',', $data) . ";\n";
		} else {
			$sql_data = '';
		}
		$sql_dump = $dump_sql_base . $sql_data;
		$file_data .= $sql_dump;
		$fn =  $this->file_prefix . $table . '_' . $this->file_index . $this->file_suffix;
		$files[] = $fn;
		$fn = $this->dump_path . $fn;
		file_put_contents($fn, $file_data);
		$backup_size += strlen($file_data);
		$this->file_index++;

		if (!empty($files)) { 
			$index_data = implode("\n", $files) . "\n";
			file_put_contents($this->index_file, $index_data, FILE_APPEND);
		}
		return $backup_size;
	}

	/**
	 * 得到Xweibo要使用所有表
	 * @param $prefix string 表前缀
	 * @return array
	 */
	function getTables($prefix) {
		$sql = 'SHOW TABLES';
		$result = mysql_query($sql, $this->connect);
		$list = array();

		$tables = array();
		$sql_dump = '';
		while ($row = mysql_fetch_row($result)) {
			if ($prefix === '' || strpos($row[0], $prefix) === 0) {
				$tables[] = $row[0];
			}
		}
		return $tables;
	}
}

?>
