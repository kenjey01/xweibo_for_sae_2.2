<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组件列表 - 组件设置 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
</head>
<body>
<?php
	//标示show_num类型
	// 1: 用户数 2:微博数
	$num_type = '';

	switch ($id) {
		case '1':
		case '5':
		case '8':
		case '9':
		case '10':
		case '12':
			$num_type = '微博';
		break;

		case '6':
			$num_type = '话题';
		break;
		
		default: 
			$num_type = '用户';
	}
?>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：组件管理<span> &gt; </span>组件设置<span> &gt; </span><?php echo F('escape', $com['name']);?></div>
    <div class="set-wrap">
		<div class="sub-set02">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form name="config" id="form1" action="<?php echo URL('mgr/components.set');?>" method="post">
			<?php
				if ($id == 10) { //今日话题

			?>
				<div class="set1">
					<div class="sub-set-l">组件使用的话题列表：</div>
					<div class="sub-set-r"><a href="<?php echo URL('mgr/weibo/todayTopic.topicList', array('category'=>2));?>">今日话题列表</a></div>
				</div>

			<?php
				} elseif ($id == 12) { //话题微博
			?>
			
				<div class="set1">
					<div class="sub-set-l">默认使用的话题：</div>
					<div class="sub-set-r"><input class="input-txt" type="text" vrel="ne=m:不能为空" warntip="#titleErr" name="topic" value="<?php echo F('escape', $cfg['topic']) ?>"/><span class="tips-error hidden" id="titleErr"></span></div>
				</div>
				
			<?php 
				}
				if (isset($cfg['show_num'])):
			?>
                	<div class="set1">
                		<div class="sub-set-l">默认显示的<?php echo $num_type;?>数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number2">
			<?php
				//建议
				$showNumSugg = '';

				$valids = array();

				switch ($id) {
					case 2:
					case 3:
					case 1:
					case 5:
					case 6:
						$showNumSugg = '设置范围3至20之间';
						array_push($valids, 'bt=min:3,max:20,m:范围为3-20');
					break;

					default:
						$showNumSugg = '设置范围3至10之间';
						array_push($valids, 'bt=min:3,max:10,m:范围为3-10');
				}

				if (in_array($id, array(2,3,7))) {
					$showNumSugg .= ',推荐为3的倍数';
				}

				array_push($valids, 'int=m:只能输入数字');
				array_push($valids, 'ne=m:不能为空');

			?>
                    			<input class="input-txt" name="show_num" type="text"<?php echo !empty($valids) ? 'vrel='.join('|', $valids):''?> value="<?php echo $cfg['show_num'];?>" warntip="#showNumErr"/><span id="showNumErr" class="tips-error hidden"></span><?php if ($showNumSugg):?><p class="sub-tips">（<?php echo $showNumSugg;?>）</p><?php endif;?>
                       		</label>
                    	</div>
                	</div>
			<?php endif; ?>	
					<input type="hidden" name="id" value="<?php echo $id;?>"/>
                	<div class="button"><input id="submitBtn" type="submit" value="提交" /></div>
            	</form>
    		</div>
        </div>
    </div>
</div>
<script type="text/javascript">
var valid = new Validator({
	form: '#form1'
});
</script>
</body>
</html>
