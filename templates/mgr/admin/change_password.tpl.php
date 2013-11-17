<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码 - 帐号管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
</head>
<body class="main-body">
<div class="main-wrap">
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>修改密码</p></div>
    <div class="main-cont">
        <h3 class="title">修改密码</h3>
		<div class="set-area">
        	<div class="form">
            	<form action="" method="post" id="passwordForm">
                <div class="form-row">
                	<label class="form-field">帐号</label>
                    <div class="form-cont">
                        <p class="text"><?php echo $info['sina_uid'];?></p>
                    </div>
                </div>
                <div class="form-row">
                	<label class="form-field">昵称</label>
                    <div class="form-cont">
                        <p class="text"><?php echo $nick;?></p>
                    </div>
                </div>
                <div class="form-row">
                	<label for="old_pwd" class="form-field">请输入旧密码</label>
                    <div class="form-cont">
                        <input id="old_pwd" name="old_pwd" class="input-txt w120" type="password" />
                    </div>
                </div>
                <div class="form-row">
                	<label for="pwd" class="form-field">请输入新密码</label>
                    <div class="form-cont">
                        <input id="pwd" name="pwd" class="input-txt w120" type="password" />
                    </div>
                </div>
                 <div class="form-row">
                	<label for="re_pwd" class="form-field">请再输入一次</label>
                    <div class="form-cont">
                        <input id="re_pwd" name="re_pwd" class="input-txt w120" type="password" />
                    </div>
                </div>
                <input name="id" type="hidden" value="<?php echo $info['id'];?>" />
                <div class="btn-area">
                	<a href="javascript:$('#passwordForm')[0].submit();" class="btn-general highlight"><span>提交</span></a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
