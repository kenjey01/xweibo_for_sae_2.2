<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>安装流程_第二步</title>
<link rel="stylesheet" media="screen"  href="css/base.css"/>
</head>

<body>
	<div id="wrap">
		<!-- header -->
        <?php include_once 'templates/header.php';?>
		<!-- end header -->
		<div id="main">
			<div class="content-box">
				<div class="step2 step-bg"></div>
				<form name="theForm" action="index.php?step=2" method="post" class="step">
				<div class="ct-mid">
					<div class="title-info">
						<h3>数据库设置<span></span></h3>
					</div>	
					<div class="form-row">
						<label for=""><span>*</span><?php echo $_LANG['db_host'];?>：</label>
						<input type="text"  value="<?php echo $db_host;?>" disabled="disabled"/>
					</div>
					
					<div class="form-row">
						<label for=""><span>*</span><?php echo $_LANG['db_name'];?>：</label>
						<input type="text"  value="<?php echo $db_name;?>" disabled="disabled"/>
						<div class="tips-correct"></div>
					</div>
					<div class="form-row">
						<label for=""><span>*</span><?php echo $_LANG['db_user'];?>：</label>
						<input type="text"  value="<?php echo $db_user;?>" disabled="disabled"/>
					</div>
					<div class="form-row">
						<label for=""><span>*</span><?php echo $_LANG['db_passwd'];?>：</label>
						<input type="password" name="db_passwd" disabled="disabled"/>
					</div>
					<div class="form-row">
						<label for=""><span>*</span><?php echo $_LANG['db_prefix'];?>：</label>
						<input type="text" value="<?php echo $db_prefix;?>" disabled="disabled"/>
					</div>
					<div class="form-row">
						<label for=""><span>*</span><?php echo $_LANG['wb_lang_type'];?>：</label>
						<select name="wb_lang_type" id="wb_lang_type">
							<option value="zh_cn" selected>简体中文</option>
							<option value="zh_tw">繁體中文</option>
						</select>
						<p><?php echo $_LANG['wb_lang_type_comment'];?></p>
					</div>
					<div class="attach">
						<label for=""><input type="checkbox" name="cover" checked="checked" value="2" /><?php echo $_LANG['is_cover_database_tip'];?></label>
					</div>
					<div class="btn-area">
						<a href="index.php" class="btn-common all-bg mr50"><span>上一步</span></a>
						<a href="javascript:f_submit();" class="btn-common all-bg"><span>下一步</span></a>
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
			isIE = function(){
				if (navigator.appName == 'Microsoft Internet Explorer') {
					return true;
				 }
				return false;
			}

			trim = function(text){
				return (text || "").replace( /^\s+|\s+$/g, "").replace(/^　+|　+$/g, "");
			}
			

			f_submit = function(){
				document.theForm.submit();
				return;
			}

})();
</script>
