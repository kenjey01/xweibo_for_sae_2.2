<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="<?php echo W_BASE_URL;?>js/jquery.js"></script>
<script src="<?php echo W_BASE_URL;?>js/xwb-all.js"></script>

<TITLE> Xpipe测试 </TITLE>
<style >
td,div,pre{font-size: 12px;}
.b{border:1px solid blue; padding: 5px;color:blue;}
.r{border:1px solid red; padding: 5px;color:red;}
.hidden{display:none;}
</style>
</HEAD>

 <BODY>
	<div class="b">
		<h1>
		<center>Xpipe与模板使用综合演示<br><br></center> 	
		<?php echo $tpl_var;?> ,顶布局测试, 现在是　<?php echo $date_str, " " , $time_str;?></h1>
		
		<hr size="1">
		<?php $tn=0; ?>
		
		<table style="height: 500px;">
		
		<tr>
		<td>顺序执行:</td>
		<td>
		<?php
			Xpipe::debug($tpl_var);
			Xpipe::debug(range(1,3));
		?>
		<?php Xpipe::pagelet('demo/plTest.test', "top".$tn++); ?>
		</td>
		</tr>
		
		<tr>
		<td>嵌套执行:</td>
		<td><?php Xpipe::pagelet('demo/plTest.pg', "嵌套"); ?></td>
		</tr>
		
		<tr>
		<td>顺序执行:</td>
		<td><?php Xpipe::pagelet('demo/plTest.test', "top".$tn++); ?></td>
		</tr>
		
		<tr>
		<td>顺序执行:</td>
		<td><?php Xpipe::pagelet('demo/plTest.test', "top".$tn++); ?></td>
		</tr>
		
		</table>
	</div>
	<?php TPL::plugin('demo/inc/pipeHelp');?>
 </BODY>
</HTML>