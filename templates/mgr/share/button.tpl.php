<?php
//$Id: button.tpl.php 17061 2011-06-13 01:31:06Z heli $
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}

$shareurl = W_BASE_HTTP. W_BASE_URL. 'share.html';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>转发按钮 - 网站整合 - 组件扩展</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/swfobject.js"></script>
<script type="text/javascript">
	var Box=Xwb.ui.MsgBox;
	var flashvars={
		bg_up:'css/component/retweet/bgimg/share_btn.png',
		bg_over:'css/component/retweet/bgimg/share_btn.png',
		bg_color:'0xFFFFFF'
	};
	var params = {
		AllowScriptAccess:"always",
		wmode:"opaque",
		salign:"TL"
		};
	swfobject.embedSWF("<?php echo W_BASE_URL;?>flash/clipboard.swf", "clip", "100", "30", "9.0.0", "<?php echo W_BASE_URL;?>flash/expressInstall.swf",flashvars,params);
	function clipStr()
	{
		try{
			return document.getElementById('share_code').value;
			//return $('share_code').value;
		}catch(e){
			Box.alert("提示",'无法获取分享按钮代码，请手动复制。');
			return undefined;
		}
	}
	function copytoclip(ob)
	{
	if(ob.success){
		Box.alert("提示","复制成功！");
	}else{
		Box.alert("提示","复制失败，请手动复制。");
		}
	}


	$(function(){
		var modeScript=['<','script type="text/javascript" charset="utf-8">\n', 
'(function(){ \n', 
 ' var _w = {_w} , _h = {_h}; \n', 
  'var param = { \n', 
  '  url:location.href,\n',  
  '  type:"{type}", /**type类型有b/d/f/h/j/l*/ \n', 
  '  count:"{count}", /**是否显示分享数，1显示(可选)*/ \n', 
  '  appkey:"<?php echo WB_AKEY; ?>", /**您申请的应用appkey,显示分享来源(可选)*/ \n', 
  '  title:encodeURI(document.title), /**分享的文字内容(可选，默认为所在页面的title)*/ \n', 
  '  relateUid:"{relateUid}", /**关联用户的UID，分享微博会@该用户(可选)*/ \n', 
  '  rnd:new Date().valueOf(), \n', 
  '	 lang:"<?php echo APP::getLang();?>" \n',
  '}\n', 
  'var temp = []; \n', 
  'for( var p in param ){ \n', 
  '  temp.push(p + "=" + encodeURIComponent( param[p] || "" ) ) \n', 
  '} \n', 
'document.write(\'','<','iframe allowTransparency="true" frameborder="0" scrolling="no" src="<?php echo $shareurl;?>?\' + temp.join(\'&\') + \'" width="\'+ _w+\'" height="\'+_h+\'">','<','/iframe>\') \n', 
 
,'})()<','/script>'].join('');;
		var count = '0', type = 'b',relateUid = '', _w= '190' , _h='32', v=0 ;
		var val={
			//'a':{count:'1',_w:'190',_h:'32'},
			'b':{count:'',_w:'158',_h:'32'},
			//'c':{count:'1',_w:'145',_h:'24'},
			'd':{count:'',_w:'120',_h:'24'},
			//'e':{count:'1',_w:'118',_h:'16'},
			'f':{count:'',_w:'105',_h:'16'},
			//'g':{count:'1',_w:'96',_h:'32'},
			'h':{count:'',_w:'32',_h:'32'},
			//'i':{count:'1',_w:'88',_h:'25'},
			'j':{count:'',_w:'24',_h:'24'},
			//'k':{count:'1',_w:'75',_h:'16'},
			'l':{count:'',_w:'16',_h:'16'}
		};
		replachScript();
		$('[rel="change"]').each(function(){
			$(this).change(function(){
				var self=$(this);
				if(this.name == 'site_name'){
					$('.tips-error').addClass('hidden');
					if($(this).val() == ''){
						relateUid = '0';
						$('#txtout').html('').hide();	
						replachScript();
						return;
					}
					$('#txtout').ajaxStart(function(){
						$('#txtout').html('查询中...').show();
					})
					$.ajax({
						url:"admin.php?m=mgr/share.searchUser",
						data:{'username':$(this).val()},
						type:'POST',
						success:function(r){
							if(r.errno == 0){
								$('#txtout').html('预览：（分享自 <a href="index.php?m=ta&id=' + r.rst.id + '" target="_blank">@'+ r.rst.screen_name + '</a>）').show();
								$('.tips-error').addClass('hidden');
								relateUid=r.rst.id;
								replachScript();
							} else {
								relateUid= '0' ;
								$('#txtout').hide();
								$('.tips-error').html(r.err).removeClass('hidden');
							}
						}
					})
					return;
				}
				var allradio=$('input:checked');
				v = 0;
				for(var i=0;i<allradio.length;i++){
					v+= parseInt( allradio.get(i).value );
				}
				type = String.fromCharCode( 96 + v );
				//count = val[type].count;
				count = 0;
				_w = val[type]._w;
				_h = val[type]._h;
				replachScript();
			});
		});
		function replachScript(){
			var m= modeScript;
			m=m.replace('{count}',count);
			m=m.replace('{_w}',_w);
			m=m.replace('{_h}',_h);
			m=m.replace('{type}',type);
			m=m.replace('{relateUid}',relateUid);
			$('[name="share_code"]').val(m)
			var ifshow=$('#ifShow');
			var ifsrc='<?php echo $shareurl?>?url=<?php echo urlencode(W_BASE_HTTP. W_BASE_URL); ?>&type='+type+'&count='+count+'&relateUid='+relateUid+'&appkey='+'<?php echo WB_AKEY; ?>'+'&title=<?php echo urlencode('演示将转发按钮放到'. V('-:sysConfig/site_name'). '首页的效果，默认截取所在页面title'); ?>&rnd='+new Date().valueOf();
			ifshow.attr({width:_w+'px',height:_h+'px',src:ifsrc});
			
		}
	})
</script>
</head>

<body class="main-body">
	<div class="path"><p>当前位置：扩展工具<span>&gt;</span>转发按钮</p></div>
    <div class="main-cont">
    	<h3 class="title">转发按钮</h3>
    	<div class="set-area">
        	<div class="form">
            	<div class="form-row">
                	<p class="form-tips">将转发按钮嵌入到你的网站里，你的访客点击它就能将你的网页转发到你的微博，同时也会转发到新浪微博，分享给他们的粉丝，增加你的网站的访问流量。</p>
                </div>
                <div class="form-row">
                    <label class="form-field">选择样式</label>
                    <div class="form-cont">
                        <input id="model1" class="ipt-radio" name="select-a" type="radio" value="0" checked="checked" rel="change">
                        <label for="model1">按钮</label>
                        <input id="model2" class="ipt-radio" name="select-a" type="radio" value="6" rel="change">
                        <label for="model2">图标</label>
                    </div>
                </div>
                <div class="form-row">
                    <label class="form-field">选择大小</label>
                    <div class="form-cont">
                        <input id="model3" class="ipt-radio" name="select-b" type="radio" value="2" checked="checked" rel="change">
                        <label for="model3">大</label>
                    	<input id="model4" class="ipt-radio" name="select-b" type="radio" value="4" rel="change">
                        <label for="model4">中</label>
                    	<input id="model5" class="ipt-radio" name="select-b" type="radio" value="6" rel="change">
                        <label for="model5">小</label>
                    </div>
                </div>
                <!--
                <div class="form-row">
                	<label class="form-field">&nbsp;</label>
                    <div class="form-cont">
                        <label for="show-number">
                            <input id="show-number" class="ipt-checkbox" type="checkbox" value="-1" rel="change"/>
                            <strong>显示转发数</strong> 
                            <span class="form-tips">显示当前页面的url在微博被转次数</span>
                        </label>
                    </div>
                </div>
                -->
                <div class="form-row">
                    <label class="form-field">预览</label>
                    <div class="form-cont">
                        <iframe id="ifShow" allowTransparency="true" frameborder="0" scrolling="no"></iframe>
                    </div>
                </div>
                <div class="form-row">
                    <label for="site-name" class="form-field">关联帐号</label>
                    <div class="form-cont">
                        <input id="site-name" name="site_name" class="input-txt w200"  type="text" value="" rel="change">
						<span class="tips-error hidden">错误信息</span>
                        <p class="form-tips">该帐号转发时会被@,并在转发后提示关注他。</p>
						<span id="txtout" class="form-tips"></span>
                    </div>
                </div>
                <div class="form-row">
                    <label for="share_code" class="form-field">转发代码</label>
                    <div class="form-cont">
                        <textarea name="share_code" id="share_code" class="input-area area-s3 code-area" cols="50" rows="30"></textarea>
                    </div>
                </div>
                <div class="btn-area">
                	<span id="clip">
                        <a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>
                    </span>
                    <span class="form-tips">复制这段代码，粘贴到你的网站上任意位置</span>
                </div>
            </div>
        </div>
	</div>
</body>
</html>
