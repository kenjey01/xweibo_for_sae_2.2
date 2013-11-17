<?php

class authImage_mod {
	function authImage_mod () {}
	
	function default_action() {
		$this->paint();
	}
	function paint(){
		ob_clean();
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

		@session_start();
		$autocode = APP :: N('SimpleCaptcha');
		$autocode->CreateImage();
/*
		$w = V("g:w",70)*1;
		$h = V("g:h",25)*1;
		
		//print_r(array($w,$h));exit;
		$authcode = APP :: N('authCode');
		$authcode->setImage(array('type'=>'png','width'=>$w,'height'=>$h));
		$authcode->paint();
*/
	}
}


?>
