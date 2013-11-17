<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>站点设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/jquery.min.js'></script>
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/admin/admin_lib.js'></script>
<script>
	window.onload = function() {
		$('#preview_loading').hide();
	}


	function preview(o) {
		$('#preview_loading').show();
		$('#logo_form').submit();
	}
	
	function uploadFinished(state, url) {
		$('#logo_form').get(0).reset();

		$('#preview_loading').hide();
		if (state != '200') {
			alert(state);
			return;
		}
		$('#logo_preview').attr('src', url);
		$('#logo').val(url);

	}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>站点设置</p></div>
    <div class="main-cont">
        <h3 class="title">站点信息设置</h3>
        <div class="set-area">
        	<div class="form web-info-form">
            	<form action="" name="form1" method="post" id="this_form">
                    <div class="form-row">
                        <label class="form-field">网站名称</label>
                        <div class="form-cont">
                            <input name="site_name" class="input-txt" vrel="sz=max:10,m:请缩减至十个字内|ne=m:不能为空" warntip="#nameTip" type="text" value="<?php echo $config['site_name']; ?>" /><span class="tips-error hidden" id="nameTip"></span>
                            
                        </div>
                    </div>
                    <div class="form-row">
                        <label class="form-field">网站备案信息代码</label>
                        <div class="form-cont">
                            <input name="site_record" class="input-txt" vrel="sz=max:30,m:最多30个中文或60个英文字母" type="text" warntip="#codeErr" value="<?php echo $config['site_record']; ?>" /><span class="tips-error hidden" id="codeErr"></span>
                            <p class="form-tips">（备案信息将显示在页面底部）</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="declare" class="form-field">网站第三方统计代码</label>
                        <div class="form-cont">
                            <textarea name="third_code" class="input-area area-s4 code-area" cols="10" rows="10"><?php echo htmlspecialchars($config['third_code']); ?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="declare" class="form-field">继承新浪微博用户关系</label>
                        <div class="form-cont">
                        	<label><input type="radio" name="local_relation" value="0" <?php if ( !(isset($config['open_user_local_relationship']) && $config['open_user_local_relationship']) ) {echo 'checked="checked"'; }?> />是</label>
                        	<label><input type="radio" name="local_relation" value="1" <?php if ( isset($config['open_user_local_relationship']) && $config['open_user_local_relationship'] ) {echo 'checked="checked"'; }?> />否</label>
                            <p class="form-tips">继承新浪微博用户关系后，你的网站用户关系如关注数、粉丝数会与新浪微博同步</p>
                    	</div>
                    </div>
<!--                    <div class="form-row">-->
<!--                        <label class="form-field">选择前台使用语言</label>-->
<!--                        <div class="form-cont">-->
<!--                        	<label><input type="radio" name="wb_lang_type" value="zh_tw" <?php if (isset($config['wb_lang_type'])  && ('zh_tw'==$config['wb_lang_type'])){echo 'checked="checked"'; } ?> />繁体中文</label>-->
<!--                        	<label><input type="radio" name="wb_lang_type" value="zh_cn" <?php if (!isset($config['wb_lang_type']) || ('zh_cn'==$config['wb_lang_type'])){echo 'checked="checked"'; } ?> />简体中文版</label>-->
<!--                        </div>-->
<!--                    </div>-->
					<div class="form-row">
                        <label class="form-field" for="declare">网站首页设置</label>
                        <div class="form-cont">
                        	<label><input type="radio" value="0" <?php if ( !(isset($config['sysLoginModel'])&&$config['sysLoginModel']) ){echo 'checked="checked"'; } ?> name="sysLoginModel">微博广场作为网站首页</label>
							<br/>
                        	<label><input type="radio" value="1" <?php if ( isset($config['sysLoginModel'])&&$config['sysLoginModel'] ){echo 'checked="checked"'; } ?> name="sysLoginModel">类似新浪微博的未登录首页（用户需要登录才能访问广场页）</label>
                    	</div>
                    </div>
                    <input type="hidden" name="logo" id="logo" value="<?php echo $config['logo'];?>" />
                </form>
            </div>
        </div>
        
        <form id="logo_form" target="logo_upload" method="post" action="<?php echo URL('mgr/setting.uploadLogo')?>" enctype="multipart/form-data">
        <h3 class="title">请选择需要在网站中使用的LOGO图案</h3>
        <div class="set-area">
            <div class="form web-info-form">
                <div class="form-row">
                	<label for="upload_file" class="form-field">选择图片</label>
                    <div class="form-cont">
                            <input type="file" class="btn-file" id="upload_file" value="<?php echo $config['logo']; ?>" name="logo" onChange="preview(this)"/>
                            <p class="form-tips">请选择PNG格式的本地图片文件，文件大小不超过500KB，图片大小不超过200*65px</p>
                    </div>
                    
                </div>
                <div class="form-row logo_preview">
                    <label for="upload_file" class="form-field">效果预览</label>
                    <div class="form-cont">
                        <img id="logo_preview" src="<?php echo $config['logo'] ? F('fix_url', $config['logo']) : W_BASE_URL . WB_LOGO_DEFAULT_NAME;?>" />
                        <div class="preview_loading" id="preview_loading">正在上传图片，请稍候...</div>
                    </div>
                    <iframe name="logo_upload" style="display:none;"></iframe>
                </div>
                <div class="btn-area"><a href="#" id="submitBtn" class="btn-general highlight" name="保存修改"><span>提交</span></a></div>
            </div>
        </div>
        </form>
    </div>
    
    
</div>
<script type="text/javascript">
var valid = new Validator({
	form: '#this_form',
	trigger: '#submitBtn'
});
</script>
</body>
</html>
