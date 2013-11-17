<?php
/**
 *  前台皮肤定制颜色配置文件提取
 */

class getSkinColors {
	
	function default_action() {
		$rst = array();
		//$io=APP::ADP('io');
		
		///problems here
		
		//$cons=$io->read(P_CUSTOM_COLORS_INI);
		
		///SAE平台限制使用本地IO,该操作一般只执行一次加载,永久缓存,同样parse_ini_file会使用本地IO
		if(file_exists(P_CUSTOM_COLORS_INI)){
			$cons = file_get_contents(P_CUSTOM_COLORS_INI);
			//var_dump($cons);
			$cons_arr = explode("\r\n", $cons);
			$colorGroupId = - 1;
			foreach ($cons_arr as $con) {
				$con = trim($con);
				if (preg_match("/^\/.*\/$/", $con)) {
					$colorGroupId++;
					$rst[$colorGroupId] = array();
				}
				elseif (preg_match("/^(#[a-fA-F0-9]{3,6});?$/", $con, $matches)) {
					$rst[$colorGroupId][] = $matches[1];
				}
			}	
		}
		
		return RST($rst);
	}
}
?>