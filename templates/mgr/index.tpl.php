<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理中心</title>
<link type="text/css" rel="stylesheet" href="<?php echo W_BASE_URL;?>css/admin/admin.css" media="screen" />
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
$(function(){
	admin.index.init();
	$('#map').click(function(){
		Xwb.use('MgrDlg',{
			dlgcfg:{
				title:'后台管理导航',
				cs : ' win-fixed map '
			},
			modeUrl:Xwb.request.mkUrl('mgr/admin','map'),
			actiontrig : function(e){
				if(e.get('e') == 'reload'){
					var arr = e.get('data').split('|');
					//admin.index.selectMainMenu(Number(arr[0]),arr.length == 2 ? Number(arr[1]):null );
					//this.dlg.close();
					location.href="?_="+Math.random()+"#"+arr.join(',');
				}
			},
			afterDisplay:function(){
				this.dlg.jq().css({'marginLeft':'0px','marginTop':'0px'});
				this.dlg.center();
			}
		});
	});
});
</script>
</head>

<body>
		<div id="header">
			<h1>Xweibo管理中心</h1>
			<ul>
				<?php if (isset($menu) && is_array($menu)) {foreach ($menu as $m_index => $m_menu) {?>
				<li><a href="#"><?php echo $m_menu['title'];?></a></li>
				<?php }}?>
			</ul>
			<p>
				<span>欢迎回来：<?php echo $real_name;?></span>
				<span class="line">|</span>
				<a href="javascript:;" id="map">地图导航</a> 
				<span class="line">|</span>
				<a href="index.php" target="_blank" class="home">微博首页</a>
				<span class="line">|</span>
				<a href="<?php echo URL('mgr/admin.logout');?>">退出</a>
			</p>
		</div>

			<div id="mainDiv" class="main-frame">
				<iframe src="<?php echo URL('mgr/admin.default_page');?>" id="mainframe" name="mainframe" width="100%" height="100%" frameborder="0" title="main frame content"></iframe>
			</div>
			<div id="side-menu">
				<?php if (isset($menu) && is_array($menu)) {foreach ($menu as $m_index => $m_menu) {?>
				<div class="menu-group">
					<?php if (isset($m_menu['sub']) && is_array($m_menu)) {foreach ($m_menu['sub'] as $l_index => $l_menu) {?>
					
					<h2 <?php if($l_index == 0) {?> class="first"<?php }?>><?php echo $l_menu['title'];?></h2>
					<ul>
						<?php if (isset($l_menu['sub']) && is_array($l_menu['sub'])) {foreach ($l_menu['sub'] as $s_index => $s_menu) {?>
						<li><a href="<?php echo URL($s_menu['url'][0],isset($s_menu['url'][1])?$s_menu['url'][1]:'');?>"  router="<?php echo $m_index . '/' . $l_index . '/' . $s_index;?>" target="mainframe"><?php echo $s_menu['title'];?></a></li>
						<?php }}?>
					</ul>
					<?php }}?>
				</div>
				
				<?php }}?>
			</div>
<?php if (XWB_SERVER_ENV_TYPE!=='sae'){?>
<script type="text/javascript">
var update_url = '<?php echo WB_UPGRADE_CHK_URL;?>';
var version = '<?php echo WB_VERSION;?>';
if (update_url && version)
{
	checkNewVer(update_url, version);
}
</script>
<?php }?>
<script type='text/javascript'>
if(!window.Xwb)Xwb={};
	Xwb.cfg={
		basePath : '<?php echo W_BASE_URL;?>'
	}
Xwb.request.basePath = Xwb.cfg.basePath;

//初始化 自适应窗口大小
var autoSize = function(){
	var height = document.documentElement.clientHeight - 89;
	$('#side-menu').css('height',height+'px');
	$('#mainDiv').css('height',height+'px');
}
autoSize();
$(window).resize(autoSize);

</script>
</body>

</html>
