<?php
/**
 * DES/ECB/PKCS5Padding 
 * $c = new desByMcrypt();
 * $key = "12345678";
 * $s = $c->encrypt("123456789abcdefg", $key);
 * echo $s."\n";
 * echo $c->decrypt($s, $key)."\n";
 */
class desByMcrypt {
	
	function desByMcrypt (){}
	
	function encrypt($encrypt, $key) {
		$encrypt = $this->pkcs5_pad($encrypt);
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB), MCRYPT_RAND);
		$passcrypt = mcrypt_encrypt(MCRYPT_DES, $key, $encrypt, MCRYPT_MODE_ECB, $iv);

		return base64_encode($passcrypt);
		// return bin2hex($passcrypt);
	}

	function decrypt($decrypt, $key) {
		$decoded = base64_decode($decrypt);
		// $decoded = pack("H*", $decrypt);
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB), MCRYPT_RAND);
		$decrypted = mcrypt_decrypt(MCRYPT_DES, $key, $decoded, MCRYPT_MODE_ECB, $iv);
		return $this->pkcs5_unpad($decrypted);
	}

	function pkcs5_unpad($text) {
		$pad = ord($text{strlen($text)-1});
		if ($pad > strlen($text)) return $text;
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return $text;
		return substr($text, 0, -1 * $pad);
	}

	function pkcs5_pad($text) {
		$len = strlen($text);
		$mod = $len % 8;
		$pad = 8 - $mod;
		return $text.str_repeat(chr($pad),$pad);
	}

}
?>