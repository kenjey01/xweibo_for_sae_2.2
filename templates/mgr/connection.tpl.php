<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微博插件通信 - 功能设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>js/datepick/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/datepick/jquery.datepick.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body>
<!--<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：功能设置<span> &gt; </span>与论坛微博插件通信</div>
    <div class="set-wrap">

	<?php if ($connected) {?>
	<button onclick="$.get('connection.disconnect')">关闭通信</button>
	<?php } else {?>
	论坛地址：<input type="text" value="<?php echo $url?>" /><button onclick="$.get('connection.connect',{'url':'http://用户输入地址'})">开启通信</button>
	<?php }?>
	<div><div>
    </div>
</div>-->
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>与论坛插件通信</p></div>
    <div class="main-cont">
		<h3 class="title">与论坛插件通信</h3>
		<div class="set-area">
        	<div class="form-s1">
            	<p class="tips">如果你安装了Xweibo for Discuz 插件，可以通过设置共享双方帐号绑定关系和内容的互推。</p>
                <p class="tips">在开始设置之前请先确定：</p>
                <ul>
                	<li>1.你的xweibo和xweibo for Discuz 插件使用的是同一个appkey；</li>
                    <li>2.你的论坛所使用的程序是DiscuzX1.5,Discuz6.0-7.2；</li>
                    <li>3.你所装的xweibo版本是2.0或者以上的</li>
                    <li>4.你所装的xweibo for Discuz 插件版本在2.0或以上</li>
                </ul>

            </div>

            <div class="search-area">
                <div class="item">
                    <?php if ($connected) {?>
<?php echo $url?>
                        <a href="#" id="closecon" class="btn-general"><span>关闭通信</span></a>
                    <?php } else {?>
                        <label><strong>论坛地址</strong></label>
                        <input type="text" id="connect_url" class="ipt-txt w200" value="<?php echo $url?>" />
                        <a href="#" id="opencon" class="btn-general"><span>开启通信</span></a>
						（示例：http://论坛地址/插件目录/xapi.php）
                    <?php }?>
                </div>
            </div>

        </div>
    </div>
<script>
	$(function(){

		$('#closecon').click(function(){
			Xwb.ui.MsgBox.confirm('提示','确认要关闭通信吗?',function(i){
				if(i== 'ok'){
					Xwb.request.q('<?php echo URL('mgr/connection.disconnect');?>',{},function(r){
						if(r.isOk()){
							window.location.reload(true);
						} else {
							Xwb.ui.MsgBox.alert('提示',r.getError());
						}
					});
				}
			})
		});

		$("#opencon").click(function(){
					Xwb.request.q('<?php echo URL('mgr/connection.connect');?>',{ 'url':$('#connect_url').val() },function(r){
						if(r.isOk()){
							window.location.reload(true);
						} else {
							Xwb.ui.MsgBox.alert('提示',r.getError());
						}
					});
		})
	});
</script>
</body>
</html>
