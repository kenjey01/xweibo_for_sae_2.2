<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>页头设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
</head>
<body id="login-set" class="main-body">
	<div class="path"><p>当前位置：界面管理<span>&gt;</span>页头设置</p></div>
    <div class="main-cont">
    	<h3 class="title">页头设置</h3>
    	<form action="<?php echo URL('mgr/setting.updateHeader'); ?>" method="post" id="headForm">
    	<div class="set-area">
        	<div class="form-s1">
            	<p class="tips"><strong>模式选择：<span class="stress">(仅布局为3栏时设置有效)</span></strong></p>
            	<p class="operate">
                    <label for="model1"><input id="model1" class="ipt-radio" name="data[model]" type="radio" value="1" <?php if($model <= 1 || $model > 3) echo 'checked="checked"'; ?> onclick="javascript:showDesc(1,2,3);" />默认页头</label>
                </p>
                <p class="operate">
                    <label for="model2"><input id="model2" class="ipt-radio" name="data[model]" type="radio" value="2" <?php if($model == 2) echo 'checked="checked"'; ?> onclick="javascript:showDesc(2,1,3);" />输入页头html代码</label>
                </p>
                
                <div  id="descDiv_2" <?php if($model != 2) echo 'style="display:none"'; ?> >
                	<p class="tips">请将静态页头代码填入以下区域，并提交确认即可</p>

					 <textarea name="data[headerHtml]" class="input-area code-area" cols="" rows=""><?php echo $headerHtml; ?></textarea>
                </div>
				<div  id="descDiv_3" <?php if($model != 3) echo 'style="display:none"'; ?> >
                	<p class="tips">请按如下步骤进行页头对接（视频教程）</p>
					<ul>
                    	<li>1.点击此处下载DZ插件并安装</li>
                        <li>2.在dz插件中配置云云</li>
                        <li>3.返回在xweibo配置云云</li>
                    </ul>
                </div>
                <div class="btn-area">
                	<a href="javascript:$('#headForm').submit();" class="btn-general highlight" name="保存设置"><span>保存设置</span></a>
                </div>
            </div>
        </div>
        
        </form>
    </div>
<script>
	function showDesc(showNum, hidenNum1, hidenNum2){
		$("#descDiv_"+showNum).show();
		$("#descDiv_"+hidenNum1).hide();
		$("#descDiv_"+hidenNum2).hide();
	}
</script>
</body>
</html>
