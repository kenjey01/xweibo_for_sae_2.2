<?php
//$Id: main.tpl.php 16806 2011-06-03 12:47:20Z heli $
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php LO('modules_share_main_title');?><?php echo F('web_page_title');?></title>
<link href="<?php echo W_BASE_URL ?>css/component/retweet/retweet.css" rel="stylesheet" type="text/css" />
<?php TPL::plugin('include/js_link');?>
</head>
<body id="retweet">
	<div id="wrap">
		<div class="wrap-in">
        	<div class="retweet">
            	<div class="retweet-in">
                    <div class="hd">
                    	<a class="logo-pic" href="<?php echo URL('pub');?>" target="_blank">
                            <img src="<?php 
                                if (V('-:sysConfig/logo',false)){
                                   echo F('fix_url', V('-:sysConfig/logo'));
                                }else{
                                   echo W_BASE_URL. WB_LOGO_DEFAULT_NAME;
                                }
                             ?>" alt="" />
                        </a>
                        <div class="hd-msg"><?php LO('modules_share_main_using');?> <a href="<?php echo URL('index');?>" target="_blank"><?php echo F('escape', USER::get('screen_name'));?></a> <?php LO('modules_share_main_account');?> | <a href="<?php echo $sharecallbackurl; ?>"><?php LO('modules_share_main_changeAccount');?></a></div>
                    </div>
                    <div class="bd">
                    	<div class="post-box" id="postBox">
                        	<div class="post-tit"><?php LO('modules_share_main_redirect');?></div>
                            <div class="key-tips" id="xwb_word_cal"><?php LO('modules_share_main_inputLest');?></div>
                            <div class="post-textarea" id="focusEl">
                            	<div class="inner">
                            		<textarea id="xwb_inputor"><?php echo APP::F('escape', $text); ?></textarea>
                            		<input type="hidden" name="relateUid" value="{$relateUid}" />
                            	</div>
                            </div>
                            <div class="share-btn"><?php LO('modules_share_main_publish');?></div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
<script type='text/javascript'>
if(!window.Xwb)Xwb={};
Xwb.cfg={	basePath :	'<?php echo W_BASE_URL;?>',
			routeMode:  <?php echo R_MODE;?>,
			routeVname: '<?php echo R_GET_VAR_NAME;?>',
			loginCfg : 	<?php echo V('-:sysConfig/login_way', 1);?>,
			wbList: 	<?php echo json_encode(APP::getData('json', 'WBDATA',array()));?>, 
			authenCfg:	'<?php echo V("-:sysConfig/authen_enable"); /*用户认证方式 1.使用站点特定的认证 0.使用新浪名人认证*/?>',
			authenTit:	'<?php echo addslashes(V("-:sysConfig/authen_small_icon_title")); /*站点认证小图标提示文字*/?>',
			webName:	'<?php echo addslashes(V("-:sysConfig/site_name")); /*本站名*/?>',
			uid: 		'<?php echo USER::uid(); /*sina uid*/?>', 
			siteUid:	'<?php echo USER::get('site_uid'); /*第三方UID*/?>',
			siteUname:	'<?php echo addslashes(USER::get('site_uname')); /* 第三方用户名 */?>',
			siteName:	'<?php echo addslashes(USER::get('site_name')); /* 第三方站点名 */?>',
			siteReg:	'<?php echo V('-:siteInfo/reg_url'); /* 第三方注册链接 */?>',
			remind: <?php /*新评论等提醒方式*/ echo V('-:userConfig/user_newfeed')?1:0;?>,
			maxid: '<?php echo APP::getData('maxid', 'WBDATA', '');?>',
			page: '<?php /*当前所在的页*/ $page = APP::getData('page', 'WBDATA'); echo !empty($page) ? $page: APP::getRequestRoute();?>',
			akey: '<?php /*appkey 上报用*/ echo WB_AKEY;?>'
};
</script>
<script>
(function(X, $){
    Xwb.request.init(X.getCfg('basePath'));

    var jqInputor = $('#xwb_inputor');
    var jqWarn = $('#xwb_word_cal');
    var exceedCS = 'out140';
    
    function checkText(){
        var v = $.trim( jqInputor.val() );
        var left = X.util.calWbText(v);
        if (left >= 0)
            jqWarn.html('<?php LO('modules_share_main_js_input');?>'+left+'<?php LO('modules_share_main_js_front');?>')
                  .removeClass(exceedCS);
        else
            jqWarn.html('<?php LO('modules_share_main_js_lengthLimit');?>'+Math.abs(left)+'<?php LO('modules_share_main_js_front');?>')
                .addClass(exceedCS);
                
        return left>=0 && v;
    }
    
    jqInputor.keyup(function(){
        checkText();
    })
    .bind('focus', function(e) {
		$('#focusEl').addClass('post-focus');
	})
	.bind('blur', function() {
		$('#focusEl').removeClass('post-focus');	
	});
    
    var loading;
    $('.share-btn').click(function(){
        if(loading)
            return;
            
        var v = $.trim(jqInputor.val());
        if(!v||!checkText()){
            jqInputor.focus();
            return;
        }
        loading = true;
        Xwb.request.post(v, function(e){
            if(e.isOk()){
                var param = Xwb.util.dequery(location.search);
                location.href = Xwb.request.mkUrl('share','success', param['relateUid']?'relateUid='+param['relateUid']:'');
            }else Xwb.ui.MsgBox.alert('', e.getMsg());
            loading = false;
        });
    });
    
    checkText();
})(Xwb, $);
</script>
</body>
</html>
