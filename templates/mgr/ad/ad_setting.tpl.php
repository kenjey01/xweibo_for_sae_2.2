<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告位管理 - 广告流程管理 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
function ad_submit(action, type) {
	form = $('#ad_from').get(0);
	if (type == 'preview') {
		form.action = action;
		form.target = '_blank';
	} else {
		form.action = '';
		form.target = '';
	}
	form.submit();
}
	function insert() {
		$.get('<?php echo URL('mgr/ad.getAd','aid='.$data['id'], 'admin.php')?>', function(data) {
				if (!data) {
				delConfirm('<?php echo URL('mgr/ad.adSetCode','', 'admin.php')?>','您可能没有设置“广告标识码”,是否现在进入设置页？');
				return;
				}
			$input = $('#code_input');
			$input.val(data);
		});
	}
</script>
</head>
<body class="main-body">
<div class="main-wrap">
	<div class="path"><p>当前位置：界面管理<span>&gt;</span><a href="<?php echo URL('mgr/ad.ad_list')?>">广告</a><span>&gt;</span><?php echo $data['name'];?></p></div>
    <div class="main-cont">
        <h3 class="title"><?php echo $data['name'];?>设置</h3>
		<div class="set-area">
			<div class="form-s1">
					<ul>
						<li>1.广告代码支持html代码（包括JS代码）。<br />比如，加入图片广告，填入的代码一般为:<?php echo htmlspecialchars('<a href="xxx"><img src="http://xxx.com/xxx.gif" alt="xxx" /></a>');?></li>
						<li>2.广告代码为空时，页面会自动隐藏广告位</li>
						<li>3.以下广告设置全局生效</li>
					</ul>
            	<form id="ad_from" action="" method="post">
					<div class="form">
						<div class="form-row">
							<div class="form-cont">
								<label class="label"><?php echo $data['name'];?> ：<span class="form-tips">(<?php echo $data['remarks'];?>)</span></label>
								<textarea id="code_input" name="content" class="input-area area-s6 code-area" cols="" rows=""><?php echo htmlspecialchars($data['content']);?></textarea>
							</div>
						</div>
						<div id="submit" class="form-cont">
							<a class="btn-general highlight" href="javascript:ad_submit('', 'save');" ><span>保存</span></a>
							<a class="btn-general " href="javascript:ad_submit('<?php echo URL($data['page']=='global'?'index':$data['page'] ,($data['page'] =='ta' ?'id=1076590735':'') . '#ad_' .$data['flag'], 'index.php');?>', 'preview')" ><span>预览</span></a>
						</div>
					<input type="hidden" name="flag" value="<?php echo $data['flag'];?>" />
					<input type="hidden" name="page" value="<?php echo $data['page'];?>" />
					<input type="hidden" name="id" value="<?php echo $data['id'];?>" />
					</div>
				</form>
			</div>
		</div>
   </div>
</div>
</body>
</html>
