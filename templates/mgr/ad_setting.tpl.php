<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组件列表 - 组件设置 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：组件管理<span> &gt; </span>插件设置<span> &gt; </span>页首页尾广告</div>
    <div class="set-wrap">
		<div class="set-ad">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
            	<form method="post" action="<?php echo URL('mgr/plugins.save', array('id' => V('r:id')));?>">
                	<div class="code-area">
                		<p>请输入页尾广告代码：</p>
                        <label>
                        	<textarea rows="" cols="" class="input-txt sub-ad" name="ad_footer"><?php echo F('escape', DS('common/sysConfig.get', 'g1/86400', 'ad_footer'));?></textarea>
                        </label>
                	</div>
                	<div class="button operate-area"><input type="submit" value="提交" name="ad"></div>
                </form>
    		</div>
        </div>
    </div>
</div>
</body>
</html>
