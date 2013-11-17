<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<style type="text/css">
html{ background:#F2F5F8;}
body{ background:#F2F5F8;}
</style>
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/jquery.min.js'></script>
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/admin/admin.js'></script>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico">
<script language="javascript" type="text/javascript">
function refreshCc() {
	var ccImg = document.getElementById("checkCodeImg");
	if (ccImg) {
		ccImg.src= ccImg.src + '&' +Math.random();
	}
}
$(function() {
	$('input[type="text"],textarea,input[type="password"]').blur(function() {
		checkForm(this);
	});
	$('#username').focus();
});
function ajax_submit() {
	if (!checkForm($('#loginFrm').get(0))) {
		return false;
	}

	var url = '<?php echo URL('mgr/admin.login',array('ajax'=>1));?>';
	var data = {
			'sina_uid': $('#sina_uid').val(),
			'password': $('#password').val(),
			'verify_code': $('#verify_code').val()
		};
	$.post(url, data, function(json){
		if ('string' == typeof json) {
			json = eval('(' + json + ')');
		}
		if (json.state == '200') {
			window.location.href = '<?php echo URL('mgr/admin.index');?>';
		} else {
			if (json.state == '402') {
				$('#verify_code_msg').html(json.msg).addClass("tips-error").show();
				$('#username_msg').hide();
			} else if (json.state == '403') {
				window.top.location.href = "<?php echo URL('account.sinaLogin','cb=login&loginCallBack=' . urlencode(URL('mgr/admin.login', '', 'admin.php')), 'index.php');?>";
			} else {
				$('#username_msg').html(json.msg).addClass("tips-error").show();
				$('#verify_code_msg').hide();
			}
		}
	})
}

//if(window.self!=window.top) window.open(window.location,'_top');
</script>
</head>
<body>
<div id="login-wrap">
	<div class="login-main">
    	<div class="login-tit">
        	<div class="admin-logo"></div>
            <div class="tit"></div>
        </div>
        <div class="login-cont">
        	<form id="loginFrm" action="" method="post" onsubmit="ajax_submit();return false;">
            	<div class="account1">
                	<label>微博帐号：</label>
                    <strong><?php echo $real_name;?></strong>（<?php echo $sina_uid;?>）
                    <a href="<?php echo URL('account.logout','','index.php');?>">换个帐号</a>
                </div>
                <div class="account1">
                	<label for="">密码：</label>
                    <input class="input-txt w180" id="password" name="password" type="password" />
                    <span id="username_msg"></span>
                </div>
				<?php if(IS_USE_CAPTCHA):?>
                <div class="account2">
                	<label for="">验证码：</label>
                    <input class="input-txt w180" id="verify_code" name="verify_code" type="text" autocomplete="off" />
                    <span id="verify_code_msg"></span>
                </div>
                <div class="account3">
                	<img id="checkCodeImg" src="<?php echo APP::mkModuleUrl('authImage.paint','w=70&h=25');?>" />
                    <a href="javascript:refreshCc();">看不清楚，换一张</a>
                </div>
				<?php endif;?>
				<input type="hidden" name="sina_uid" id="sina_uid" value="<?php echo $sina_uid;?>" />
                <input class="admin-btn" onfocus="this.blur()" name="" type="submit" value="登 录" />
                <!--<input class="admin-btn-no" name=""  type="submit" value="登 录" />-->
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php if($is_admin_report): USER::set('isAdminReport', '');?>
	<!-- report -->
	<img src="<?php echo F('report','register');?>" class="hidden"/>
<?php endif;?>
