<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户封禁、屏蔽 - 用户管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#submit').click(function(){
		$('#form').submit();
		return false;
		});
	});
</script>
</head>
<body class="main-body">
	<?php
	function action($value,$type){
		if($type==$value){
			echo 'checked=checked';
		}
	}
	?>
	<div class="path"><p>当前位置：用户管理<span>&gt;</span>禁止用户</p></div>
    <div class="main-cont">
		<form method='post' id='form' action=<?php echo URL('mgr/users.userAction');?>>
		<input type="hidden" name="call_back" value="<?php echo isset($callBack) ? $callBack : ''; ?>" />
        <h3 class="title">用户封禁、屏蔽</h3>
		<div class="set-area">
        	<div class="form">
                <div class="form-row">
                	<label for="compere" class="form-field">要操作的用户</label>
                    <div class="form-cont">
                        <input type="text" name='name' value='<?php if(isset($screen_name)){echo $screen_name;}?>'  class="input-txt w130"/>
                    </div>
                </div>
                <div class="form-row">
                	<label for="compere" class="form-field">权限设置</label>
                    <div class="form-cont">
                        <p><label for="s1"><input id="s1" name='type' value='4' <?php if(isset($type)) {action(4,$type);} else {echo 'checked=checked';}?>  class="ipt-radio" type="radio" />正常</label></p>
                        <p><label for="s2"><input id="s2" name='type' value='1' <?php if(isset($type)) action(1,$type)?> class="ipt-radio" type="radio" />禁止发言<span class="form-tips">（发微博、评论、关注等一切行为，只能浏览）</span></label></p>
                        <p><label for="s3"><input id="s3" name='type' value='2' <?php if(isset($type)) action(2,$type)?> class="ipt-radio" type="radio" />禁止访问</label></p>
                        <p><label for="s4"><input id="s4" name='type' value='3' <?php if(isset($type)) action(3,$type)?> class="ipt-radio" type="radio" />清除用户<span class="form-tips">（清除该用户在本站的所有信息）</span></label></p>
                    </div>
                </div>
				<div class="btn-area"><a href="#" class="btn-general highlight" id='submit'><span>确认</span></a></div>
               
            </div>
        </div>
        
  
		</form>
    </div>
</body>
</html>
