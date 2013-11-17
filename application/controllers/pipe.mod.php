<?php
/**
 * @file			pipe.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2011-01-25
 * @Modified By:	xionghui/2011-01-25
 * @Brief			管道独立请求控制器文件
 */


class pipe_mod {	
	function pipe_mod() {
		// Cunstructor Here
	}
	
	function default_action() {
		echo "reach xpipe";
	}
	
	
	function t(){
		ob_end_clean();

		TPL::display('pipeTest');
	}
}
