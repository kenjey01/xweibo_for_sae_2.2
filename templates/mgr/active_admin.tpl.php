<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>激活管理员帐号</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<style type="text/css">
html,body{ background:#F2F5F8;}
</style>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript">
	function check() {
		var err=true;
		$('.tips-error').hide();
		if(!$('#appkey').val()) {
			$('#appkeys').show();
			err=false;
			return false;
		}

		if(!$('#secret').val()) {
			$('#secrets').show();
			err=false;
			return false;
		}

		if(!$('#pwd').val()) {
			$('#pwds').show();
			err=false;
			return false;
		}

		if($('#repwd').val() != $('#pwd').val()) {
			$('#repwds').show();
			err=false;
			return false;
		}

		if(!$('#name').val()) {
			$('#names').show();
			err=false;
			return false;
		}

		if(!$('#email').val()) {
			$('#emails').show();
			err=false;
			return false;
		}

		if(!$('#email').val() || !/^.+?@.+\.\w+?$/.test($('#email').val())) {
			$('#emails').show();
			err=false;
			return false;
		}

		if(!$('#tel').val()) {
			$('#tels').show();
			err=false;
			return false;
		}

		if(!$('#qq').val() && !$('#msn').val()) {
			$('#msns').show();
			err=false;
			return false;
		}

		if($('#qq').val() !='' && !/^\d/.test($('#qq').val())) {
			$('#qqs').show();
			err=false;
			return false;
		}
		if(err){
			var url = '<?php echo URL('mgr/active_admin.saveActive');?>';
			var data = {
				'pwd': $('#pwd').val(),
				'repwd': $('#repwd').val(),
				'name': $('#name').val(),
				'email': $('#email').val(),
				'tel': $('#tel').val(),
				'qq': $('#qq').val(),
				'msn': $('#msn').val(),
				'appkey': $('#appkey').val(),
				'secret': $('#secret').val()
			};
			$.post(url, data, function(json){
				json = eval('(' + json + ')');
				if (json.state == '200') {
					window.location.href = '<?php echo URL('mgr/admin.index');?>';
				}else{
					if (json.state == '1001') {
						$('#appkeys').html(json.msg).addClass("tips-error").show();
						return false;
					}

					if (json.state == '1002') {
						$('#secrets').html(json.msg).addClass("tips-error").show();
						return false;
					}
				}
			});
		}
	}
</script>
</head>
<body>
<div id="login-active">
    <div class="active-tit"><a href=""></a></div>
    <div class="active-cont">
    	<div class="con-border">
        	<h4 class="main-title">激活管理员帐号</h4>
            <form action="" method="post" onsubmit="check();return false;">
            	<div class="active-area">
            		<div class="admin-tit"><span class="icon-pwd"></span>管理员密码设置<span>(该密码用于登录Xweibo管理后台)</span></div>
                	<div class="admin-cont">
            			<div class="info-row">
                			<label><span class="required">*</span>微博帐号：</label>
                    		<strong><?php echo $real_name;?></strong>（<?php echo $sina_uid;?>）
                    		<a href="<?php echo URL('mgr/active_admin.changeAccount','app_key='.$app_key.'&app_secret='.$app_secret,'admin.php');?>">换个帐号登录</a>
                		</div>
                		<div class="info-row">
                			<label><span class="required">*</span>APPKEY：</label>
                    		<input class="input-txt w150" name="appkey" id="appkey" type="text" value="<?php echo $app_key;?>" />
							<span class="tips-error" id="appkeys" style="display:none">请输入APPKEY</span>
                            <p class="tips">请登录<A href="http://open.t.sina.com.cn/loginnew.php?source=xweibo" target="_blank">新浪微博开放平台</A>，查询您申请的APPKEY</p>
						</div>
						 <div class="info-row">
                			<label><span class="required">*</span>APPKEY SECRET：</label>
                    		<input class="input-txt w150" name="secret" id="secret" type="text" value="<?php echo $app_secret;?>" />
                    		<span class="tips-error" id="secrets" style="display:none">请输入APPKEY SECRET</span>
                		</div>
                		<div class="info-row">
                			<label><span class="required">*</span>管理后台密码：</label>
                    		<input class="input-txt w150" name="pwd" id="pwd" type="password" />
                    		<span class="tips-error" id="pwds" style="display:none">请输入密码</span>
                		</div>
                        <div class="info-row">
                			<label><span class="required">*</span>确认密码：</label>
                    		<input class="input-txt w150" name="repwd" id="repwd" type="password" />
                    		<span class="tips-error" id="repwds" style="display:none">二次密码不一致</span>
                		</div>
        			</div>
                	<div class="admin-tit"><span class="icon-pwd"></span>联系方式<span>(以下资料将用于我们与您联系，为您解决问题或通知您最新产品动态)</span></div>
                	<div class="admin-cont">
                		<div class="info-row">
                			<label><span class="required">*</span>姓名：</label>
                    		<input class="input-txt w120" name="name" id="name" type="text" />
                    		<span class="tips-error" id="names" style="display:none">请输入姓名</span>
                		</div>
                		<div class="info-row">
                			<label><span class="required">*</span>电子邮箱：</label>
                    		<input class="input-txt w200" name="email" id="email" type="text" />
                    		<span class="tips-error" id="emails" style="display:none">邮箱为空或格式不正确</span>
                            <p class="tips">此邮箱地址将作为找回管理员帐号密码的安全邮箱，设定后不可更改</p>
                		</div>
                        <div class="info-row">
                			<label><span class="required">*</span>联系电话：</label>
                    		<input class="input-txt w120" name="tel" id="tel" type="text" />
                    		<span class="tips-error" id="tels" style="display:none">请输入电话</span>
                		</div>
                        <P class="tips">QQ和MSN任意选填一项即可</P>
                		<div class="info-row">
                			<label><span class="required">*</span>QQ：</label>
                    		<input class="input-txt w120" name="qq" id="qq" type="text" />
							<span class="tips-error" id="qqs" style="display:none">QQ号码格式不正确</span>
                		</div>
                		<div class="info-row">
                			<label><span class="required">*</span>MSN：</label>
                    		<input class="input-txt w200" name="msn" id="msn" type="text" />
                    		<span class="tips-error" id="msns" style="display:none">请输入QQ或MSN</span>
                		</div>
        			</div>
                </div>
                <div class="active-save">
                	<input name="" class="admin-btn" type="submit" value="保 存" />
                    <!--<input name="" class="admin-btn-no" type="submit" value="保 存" />-->
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

