<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>安装流程_第三步</title>
<link rel="stylesheet" media="screen"  href="css/base.css"/>
</head>

<body>
	<div id="wrap">
		<!-- header -->
        <?php include_once 'templates/header.php';?>
		<!-- end header -->
		<div id="main">
			<div class="content-box">
				<div class="step3 step-bg"></div>
				<div class="ct-mid">
					<div class="title-info">
						<h3 id="show_install_text">正在安装</h3>
					</div>	
					<div class="box-scroll-y" id="show_table">
						<?php foreach ($table_list as $item):?>
						  <p style="display:none"><?php echo $_LANG['create_table'].' '.$item[0].$_LANG['create_talbe_success'];?></p>
						<?php endforeach;?>	
					</div>
					<div class="btn-area" id="show_install_btn">
						<a href="#" class="btn-common all-bg"><span>下一步</span></a>
					</div>
				</div>
				<div class="ct-bot"></div>
			</div>
		</div>
	</div>
</body>

<script>
var p = document.getElementById('show_table').getElementsByTagName('p');
var n = 0;
var timer = 0;
function show_tables()
{
	
	if (n > p.length - 1) {
		clearInterval(timer);
		//
		document.getElementById('show_install_text').innerHTML = '<?php echo $_LANG['done'];?>';
		//
		document.getElementById('show_install_btn').innerHTML = '<a href="index.php?method=done" class="btn-common all-bg"><span><?php echo $_LANG['next_button'];?></span></a>';
		return;
	}
	if (n >= 0) {
		p[n].style.display = '';
		document.getElementById('show_table').scrollTop = document.getElementById('show_table').scrollHeight;
		n++;
	} 
}

function setIntervals(){
	timer = setInterval('show_tables()',50);
}

setIntervals();
</script>
</html>
