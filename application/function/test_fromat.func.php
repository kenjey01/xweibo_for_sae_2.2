<?php
function test_fromat($data){
	foreach ($data as $k=>$v){
		$data[$k] = $v*3;
	}
	return $data;
}