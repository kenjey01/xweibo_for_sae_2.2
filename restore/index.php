<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数据还原</title>
<link rel="stylesheet" media="screen"  href="css/base.css"/>
<script src="../js/jquery.min.js"></script>
<script src="../js/xwb-all.js"></script>
<script type="text/javascript">
	$(function(){
		var Req = Xwb.request;
		Xwb.use('Validator',{
			form:'#restoreForm',
			trigger  :'#submitBnt',
			haveSpace : false,
			onsuccess : function(data,next){
				var self = this;
				Req.postReq('restore.php',data,function(e){
					if(e.isOk()){
						location.href = '../index.php?m=account.logout';
					} else {
						Xwb.ui.MsgBox.alert('提示',e.getMsg());
					}
					self.lock(false);
				});
				next();	
				self.lock(true);
				return false;
			}
		})
	})
</script>
</head>

<body id="db-remove">
	<div id="wrap">
		<div id="header">
			<h1 class="logo">Xweibo</h1>
		</div>
		<div id="main">
			<div class="content-box">
				<div class="ct-top"></div>
				<form method="post" id="restoreForm">
				<div class="ct-mid">
					<div class="title-info">
						<h3><strong>数据库移植还原</strong>
						<span>连接不上网站数据库，请重新设置数据库相关信息，确保网站能正确访问。</span></h3>

					</div>	
					<div class="form-row">
						<label for="">数据库主机：</label>
						<input type="text" name="db_host" value="localhost" vrel="_f|ne" warntip="#hostTip" oktip = "#hostOk"/>
						<div class="tips-wrong hidden" id="hostTip">不能为空</div>
						<div class="tips-correct hidden" id="hostOk"><span class="icon-correct icon-bg"></span></div>
					</div>

					
					<div class="form-row">
						<label for="">数据库名：</label>
						<input type="text" name="db_schema" value="xweibo_1.1"  vrel="_f|ne" warntip="#schemaTip" oktip = "#schemaOk"/>
						<div class="tips-wrong hidden" id="schemaTip">不能为空</div>
						<div class="tips-correct hidden" id="schemaOk"><span class="icon-correct icon-bg"></span></div>
					</div>
					<div class="form-row">
						<label for="">帐号：</label>
						<input type="text" name="db_user" value="root" vrel="_f|ne" warntip="#userTip" oktip = "#userOk"/>
						<div class="tips-wrong hidden" id="userTip">不能为空</div>
						<div class="tips-correct hidden" id="userOk"><span class="icon-correct icon-bg"></span></div>
					</div>
					<div class="form-row">
						<label for="">密码：</label>
						<input type="password" name="db_password" value="" vrel="_f|ne" warntip="#passwordTip" oktip = "#passwordOk"/>
						<div class="tips-wrong hidden" id="passwordTip">不能为空</div>
						<div class="tips-correct hidden" id="passwordOk"><span class="icon-correct icon-bg"></span></div>
					</div>
					
					<div class="btn-area">
						<a href="#" class="btn-common all-bg mr50" id="submitBnt"><span>恢复</span></a>
					</div>
				</div>
				</form>
				<div class="ct-bot"></div>
			</div>
		</div>
	</div>
</body>
</html>

