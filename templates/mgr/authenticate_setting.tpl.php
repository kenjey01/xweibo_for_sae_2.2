<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>认证设置 - 认证管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/jquery.min.js'></script>
<script>

	function submit() {
		$('#this_form').submit();
	}

	function bigPreview(o) {
		$('#big_preview_loading').show();
		$('#big_form').submit();
	}

	function smallPreview(o) {
		$('#small_preview_loading').show();
		$('#small_form').submit();
	}

	function uploadFinished(state, url) {
		$('#big_preview_loading').hide();
		if (state != '200') {
			alert(state);
			return;
		}

		$('#big_logo_preview').attr('src', url + '?r=' + Math.random());
		$('#big_file').val(url);
	}

	function uploadSmallFinished(state, url) {
		$('#small_preview_loading').hide();
		if (state != '200') {
			alert(state);
			return;
		}

		$('#small_logo_preview').attr('src', url+'?r='+Math.random());
		$('#small_file').val(url);
	}

	function icon(o) {
		if(o.checked) {
			$('#update_form').show();
			$('#update_form_2').show();
		}else{
			$('#update_form').hide();
			$('#update_form_2').hide();
		}
	}
</script>
<?php if($sysconfig['authen_type'] == 2 || $sysconfig['authen_type'] == 3):?><script>window.onload = function() {$('#update_form').show();$('#update_form_2').show();}</script><?php endif;?>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：用户管理<span>&gt;</span><a href="<?php echo URL('mgr/user_verify.search'); ?>">认证管理</a><span>&gt;</span>认证设置</p></div>
    <div class="main-cont">
        <h3 class="title">认证设置</h3>
		<div class="set-area">
        	<form action="<?php echo URL('mgr/user_verify.webAuthenWay');?>" method="post" name="authenticate" id="this_form">
			<div class="form-s1">
				<p class="tips"><strong>认证方式设置:</strong></p>
				<p class="operate">
                    <label>
                    	<input name="authen_type[]" class="ipt-checkbox" type="checkbox" value="1" <?php if($sysconfig['authen_type'] == 1 || $sysconfig['authen_type'] == 3) echo 'checked="checked"';?> />
                    	使用新浪名人认证
                    </label>
                </p>
                <p class="operate">
                	<label>
            			<input name="authen_type[]" class="ipt-checkbox" type="checkbox" value="2" <?php if($sysconfig['authen_type'] == 2 || $sysconfig['authen_type'] == 3) echo 'checked="checked"';?> onclick="icon(this); "/>
                        使用站点自定义认证
                	</label>
                </p>
			</div>
			<input type="hidden" name="big_file" id="big_file" value="<?php echo $sysconfig['authen_big_icon'];?>" />
			<input type="hidden" name="small_file" id="small_file" value="<?php echo $sysconfig['authen_small_icon']; ?>" />
			
            <div class="certif-desc" id="update_form" style="display:none">
            	<div class="form">
                	<div class="form-row">
                        <label class="form-field">设置认证说明</label>
                        <div class="form-cont">
                            <input class="input-txt" name="alt" type="text" value="<?php echo $sysconfig['authen_small_icon_title'];?>"/>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="certif" id="update_form_2" style="display:none">
            	<div class="form">
                	<div class="form-row file-cont">
                        <label class="form-field">请选择认证图标</label>
                        <div class="form-cont file-cont">
                            <form id="big_form" method="post" target="logo_upload" action="<?php echo URL('mgr/user_verify.uploadAuthBigIcon')?>" enctype="multipart/form-data">
                            <p>
                                <label for="logo">大图标：
                                    <input type="file" class="btn-file" value="<?php echo $sysconfig['authen_big_icon']; ?>"  name="big" onChange="bigPreview(this)"/>
                                </label>
                                <iframe name="logo_upload" style="display:none;"></iframe>
                            </p>
                            </form>
                            <form id="small_form" method="post" target="logo_upload" action="<?php echo URL('mgr/user_verify.uploadAuthSmallIcon')?>" enctype="multipart/form-data">
                            <p>
                                <label for="logo">小图标：
                                    <input type="file" class="btn-file" value="<?php echo $sysconfig['authen_small_icon']; ?>"  name="small" onChange="smallPreview(this)"/>
                                </label>
                                <iframe name="logo_upload" style="display:none;"></iframe>
                            </p>
                            </form>
                        </div>
                        <label class="form-field">效果预览：</label>
                        <div class="form-cont preview-cont">
                            <div class="preview">
                                <img id="big_logo_preview" src="<?php echo $sysconfig['authen_big_icon'] ? F('fix_url', $sysconfig['authen_big_icon']) : W_BASE_URL. 'img/logo/big_auth_icon.png';?>" />
                                <div class="preview_loading" id="big_preview_loading" style="display:none">正在上传图片，请稍候...</div>
                            </div>
                            <div class="preview">
                                <img id="small_logo_preview" src="<?php echo $sysconfig['authen_small_icon'] ? F('fix_url', $sysconfig['authen_small_icon']) :W_BASE_URL. 'img/logo/small_auth_icon.png';?>" title="<?php echo $sysconfig['authen_small_icon_title'];?>" />
                                <div class="preview_loading" id="small_preview_loading" style="display:none">正在上传图片，请稍候...</div>
                            </div>
                        </div>
                        
                        <p class="form-tips">* 请选择PNG格式的本地图片文件，文件大小不能超过100KB；<br />* 大图标大小不能超过100*30，小图标大小不能超过12*12；为显示美观，建议使用透明底素材。</p>
                    </div>
                    
                </div>
        	</div>  
            <div class="btn-area">
                <a href="#this" onclick='submit();' class="btn-general highlight" name="保存修改"><span>保存修改</span></a>
            </div>  
		</div>
	</div>
</body>
</html>