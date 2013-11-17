<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ChinaZ联盟</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/mgr.js"></script>
<script>
function replaceAll() {
	$.get('<?php echo URL('mgr/ad.replaceAllAd','', 'admin.php');?>', function() {
		alert('已经成功保存并更新');
	});
}
</script>
</head>

<body>
<div class="main-wrap">
<div class="path"><span class="path-icon"></span>当前位置：组件管理<span> &gt; </span>盈利计划推介<span> &gt; </span>ChinaZ联盟</div>
<div class="set-wrap">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int set-area-init-pad">
            	<form method="post" action="">
					
                	<div class="focus-set">
                    	<p><strong>ChinaZ-Xweibo付费推广计划</strong></p>
						<p>1，您需要先加入ChinaZ-Xweibo付费推广计划方可开始使用Xweibo盈利；<a href="http://union.chinaz.com/userpages/xweiboapply.aspx?appkey=" target="_blank">点击申请</a></p>
						<p>2，请将网站Appkey填入以下输入框，并点击“更新广告位”按钮，所有付费广告将立刻生效展现。</p>
                    	<label for="focus-title">
						    AppKey:
                        	<input type="text" name="code" class="input-txt home-focus-w" value="<?php echo $ad_site_id;?>"/>
                        </label>
						<span class="sub-tips sub-tips-block">请务必输入真实的AppKey，有任何问题，请联系ChinaZ联盟</span>
                    </div>
                    <div class="button button-long"><input name="" type="submit" value="保存并更新到所有广告位" /></div>
					
                    <span class="sub-tips sub-tips-block">点击此按钮，将自动把ChinaZ广告代码直接应用于本站所有广告位。</span>
                    <div class="button button-long"><input name="" type="button" onclick="window.open('http://union.chinaz.com/userpages/xweiboincomes.aspx')" value="查看收入报表" /></div>
                    <span class="sub-tips sub-tips-block">点击将链接至chinaz联盟查看收入报表</span>
                </form>
    		</div>
        </div>
		</div>
</body>
</html>
