<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_LANG['step1_title'];?></title>
<link rel="stylesheet" media="screen"  href="css/base.css"/>
</head>

<body>
	<div id="wrap">
		<!-- header -->
        <?php include_once 'templates/header.php';?>
		<!-- end header -->
		<div id="main">
			<div class="content-box">
				<div class="step1 step-bg"></div>
				<form name="theForm" method="post" action="index.php?step=2&method=check_app" class="step">
				<div class="ct-mid">
					<div class="title-info">
						<h3><?php echo $_LANG['site_name'];?></h3>
					</div>
					<div class="form-row">
						<label for=""><span>*</span><?php echo $_LANG['site_name'];?>：</label><input name="site_name" id="site_name" value="<?php echo isset($site_name) ? htmlspecialchars($site_name) : '';?>" type="text" />
						<div id="site_name_msg" class="check-tips-box tips-wrong"   style="display:none;">
							<p><span class="icon-wrong icon-bg"></span><?php echo $_LANG['js_check_input_empty'];?></p>
						</div>
						<div class="tips-correct" id="site_name_tips"   style="display:none;"><span class="icon-correct icon-bg"></span></div>
					</div>
					<div class="form-row">
						<label for=""><span>*</span><?php echo $_LANG['site_info'];?>：</label><textarea name="site_info" id="site_info"><?php echo isset($site_info) ? htmlspecialchars($site_info) : '';?></textarea>
						<div id="site_info_msg" class="check-tips-box tips-wrong"   style="display:none;">
							<p><span class="icon-wrong icon-bg"></span><?php echo $_LANG['js_check_input_empty'];?></p>
						</div>
						<div class="tips-correct" id="site_info_tips"   style="display:none;"><span class="icon-correct icon-bg"></span></div>
					</div>
					<div class="form-row">
						<label for=""><span>*</span>APP KEY：</label><input name="app_key" id="app_key" value="<?php echo isset($app_key) ? htmlspecialchars($app_key) : '';?>" type="text" />
						<div id="app_key_msg" class="check-tips-box tips-wrong"   style="display:none;">
							<p><span class="icon-wrong icon-bg"></span><?php echo $_LANG['js_check_input_empty'];?></p>
						</div>
						<div class="tips-correct" id="app_key_tips"   style="display:none;"><span class="icon-correct icon-bg"></span></div>
						<p><?php echo $_LANG['web_login'];?><a href="http://open.t.sina.com.cn/loginnew.php?source=xweibo" target="_blank"><?php echo $_LANG['open_site_name'];?></a><?php echo $_LANG['you_app_key'];?></p>
					</div>
					<div class="form-row">
						<label for=""><span>*</span>APP Secret：</label><input name="app_secret" id="app_secret" value="<?php echo isset($app_secret) ? htmlspecialchars($app_secret) : '';?>" type="text" />
						<div id="app_secret_msg" class="check-tips-box tips-wrong"   style="display:none;">
							<p><span class="icon-wrong icon-bg"></span><?php echo $_LANG['js_check_input_empty'];?></p>
						</div>
						<div class="tips-correct" id="app_secret_tips"   style="display:none;"><span class="icon-correct icon-bg"></span></div>
						<p><?php echo $_LANG['app_secret_notice'];?></p>
					</div>
					<div class="btn-area">
						<a href="index.php?step=1" class="btn-common all-bg mr50"><span><?php echo $_LANG['pre_button'];?></span></a>
						<a href="javascript:f_submit();" class="btn-common all-bg"><span><?php echo $_LANG['next_button'];?></span></a>
					</div>
				</div>
				</form>
				<div class="ct-bot"></div>
			</div>
		</div>
	</div>
</body>
</html>
<script>
(function(){
		var 
			trim = function(text){
				return (text || "").replace( /^\s+|\s+$/g, "").replace(/^　+|　+$/g, "");
			}
			
			f_submit = function(){
				var i, sign = true;
				for(i = 0; i < document.theForm.elements.length; i++) {
					if (document.theForm.elements[i].type == 'text' || document.theForm.elements[i].type == 'textarea') {
						if (trim(document.theForm.elements[i].value) == '') {
							document.getElementById(document.theForm.elements[i].name+'_msg').style.display = 'inline-block';
							sign = false;
						} else {
							document.getElementById(document.theForm.elements[i].name+'_msg').style.display = 'none';
						}
					}
				}
				if (sign == true) {
					document.theForm.submit();
				}
				return;
			}

		//初始化表单输入框检测
		for(i = 0; i < document.theForm.elements.length; i++) {
			if (trim(document.theForm.elements[i].value) != '') {
				document.getElementById(document.theForm.elements[i].name+'_msg').style.display = 'none';
				document.getElementById(document.theForm.elements[i].name+'_tips').style.display = 'block';
			}
			if(window.addEventListener){  //FF  
				document.getElementById(document.theForm.elements[i].name).addEventListener("blur", function(evt){var evt = window.event?window.event:evt,target=evt.srcElement||evt.target;if (trim(target.value) != ''){document.getElementById(target.name+'_msg').style.display = 'none';document.getElementById(target.name+'_tips').style.display = 'block';}}, false);
				document.getElementById(document.theForm.elements[i].name).addEventListener("blur", function(evt){var evt = window.event?window.event:evt,target=evt.srcElement||evt.target;if (trim(target.value) == ''){document.getElementById(target.name+'_msg').style.display = 'inline-block';document.getElementById(target.name+'_tips').style.display = 'none';}}, false);
			}else{  //IE chrome  
				document.getElementById(document.theForm.elements[i].name).attachEvent("onblur", function(evt){var evt = window.event?window.event:evt,target=evt.srcElement||evt.target;if (trim(target.value) != ''){document.getElementById(target.name+'_msg').style.display = 'none';document.getElementById(target.name+'_tips').style.display = 'block';}});
				document.getElementById(document.theForm.elements[i].name).attachEvent("onblur", function(evt){var evt = window.event?window.event:evt,target=evt.srcElement||evt.target;if (trim(target.value) == ''){document.getElementById(target.name+'_msg').style.display = 'inline-block';document.getElementById(target.name+'_tips').style.display = 'none';}});
			}
		}
})();
</script>

