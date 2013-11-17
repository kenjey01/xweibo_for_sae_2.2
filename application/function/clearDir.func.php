<?php
/**
* 删除文件夹,包括子文件夹,如果有文件或文件夹删除不成功则返回false
*
*/
function clearDir($dir) {
	if (!is_dir($dir)) {
		return false;
	}
	$objects = scandir($dir); 
    foreach ($objects as $object) { 
		if ($object != "." && $object != "..") {
			$name =  $dir."/".$object;
			if (filetype($name) == "dir") {
				if (!clearDir($name)) {
					return false;
				}
				$rs = @rmdir($name); 
			} else {
				$rs = @unlink($name); 
			}
			if (!$rs) {
				return false;
			}
       } 
     } 
     reset($objects); 
	return true;
}
?>
