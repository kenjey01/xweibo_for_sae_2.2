<?php
/**
 * @file			sae_mail.adp.php
 * @CopyRright (c)	1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			Yang.Zhang <zhangyang@staff.sina.com.cn>
 * @Create Date 	2010-12-30
 * @Modified By 	Yang.Zhang/2010-12-30
 * @Brief			Description
 */

class sae_mailer
{
	var $mail;
	function sae_mailer() {
		$this->mail = new SaeMail();
	}
	/**
	 *
	 * 添加附件
	 * 附件和邮件正文的总大小不可超过1MB。..
	 * @param $attach key为文件名称,附件类型由文件名后缀决定,value为文件内容;文件内容支持二进制
	 * @return true/false
	 */
	function setAttach($attach)
	{
		return $this->mail->setAttach($attach);
	}
	/**
	 *
	 * 由于采用邮件队列发送,本函数返回成功时,只意味着邮件成功送到发送队列,并不等效于邮件已经成功发送.
	 * 邮件编码默认为UTF-8,如需发送其他编码的邮件,
	 * 请使用setOpt()方法设置charset,
	 * 否则收到的邮件标题和内容都将是空的.
	 * @param $to 要发送到的邮件地址,多个邮件地址之间用英文逗号","隔开
	 * @param $subject 邮件标题
	 * @param $msgbody 邮件内容
	 * @param $smtp_user smtp用户名，必须为邮箱地址。注：和setOpt()中的smtp_user不同。
	 * @param $smtp_pass smtp用户密码
	 * @param $smtp_host smtp服务host,使用sina,gmail,163,265,netease,qq,sohu,yahoo的smtp时可不填
	 * @param $smtp_port smtp服务端口,使用sina,gmail,163,265,netease,qq,sohu,yahoo的smtp时可不填
	 * @param $smtp_tls smtp服务是否开启tls(如gmail),使用sina,gmail,163,265,netease,qq,sohu,yahoo的smtp时可不填
	 * @return true/false
	 */
	function quickSend($to, $subject, $msgbody, $smtp_user, $smtp_pass, $smtp_host , $smtp_port , $smtp_tls)
	{
		return $this->mail->quickSend($to,$subject,$msgbody,$smtp_user,$smtp_pass,$smtp_host,$smtp_port,$smtp_tls);
	}

	/**
	 * 发送邮件
	 *
	 * @param $to 要发送到的邮件地址,多个邮件地址之间用英文逗号","隔开
	 * @param $subject 邮件标题
	 * @param $body 邮件内容
	 * @param $smtp_tls smtp服务是否开启tls(如gmail),使用sina,gmail,163,265,netease,qq,sohu,yahoo的smtp时可不填
	 * @param $content_type 内容类型 HTML|TEXT, 默认是HTML
	 *
	 * @return bool
	 */
	function sendEmails($to, $subject = '', $body = '', $smtp_tls = false, $content_type = 'HTML')
	{
		$content_type = strtoupper($content_type);
		$this->mail->setOpt(array('content_type' => $content_type));
		$result = $this->mail->quickSend($to, $subject, $body, XWB_SMTP_USER, XWB_SMTP_PASS, XWB_SMTP_HOST, XWB_SMTP_PORT, $smtp_tls);
		if (!$result) {
			return $this->errno(). ' ' . $this->errmsg();
		}
		return $result;
	}

	/**
	 * 发送邮件
	 * @return true/false
	 */
	function send()
	{
		return $this->mail->send();
	}

	/**
	 *  设置发送参数,此处设置的参数只有使用send()方法发送才有效;quickSend()时将忽略此设置.
		-----------------------------------------
	    KEY        VALUE
	    -----------------------------------------
	    from        string (only one)
	    -----------------------------------------
	    to        string (多个用,分开)
	    -----------------------------------------
	    cc        string (多个用,分开)
	    -----------------------------------------
	    smtp_host    string
	    -----------------------------------------
	    smtp_port    port,default 25
	    -----------------------------------------
	    smtp_username    string
	    -----------------------------------------
	    smtp_password    string
	    -----------------------------------------
	    subject        string,最大长度256字节
	    -----------------------------------------
	    content        text
	    -----------------------------------------
	    content_type    "TEXT"|"HTML",default TEXT
	    -----------------------------------------
	    charset        default utf8
	    -----------------------------------------
	    tls        default false
	    -----------------------------------------
	    compress        string 设置此参数后，SaeMail会将所有附件压缩成一个zip文件，此参数用来指定压缩后的文件名。
	    -----------------------------------------
	 * @param $options
	 * @return
	 */
	function setOpt($options)
	{
		return $this->mail->setOpt($options);
	}
	/**
	 *
	 * 取得错误信息
	 * @return
	 */
	function errmsg()
	{
		return $this->mail->errmsg();
	}
	/**
	 * 取得错误码
	 * @return
	 */
	function errno()
	{
		return $this->mail->errno();
	}
}
?>

