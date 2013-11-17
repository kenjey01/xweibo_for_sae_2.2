<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户列表 - 用户管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

$(function(){
	new Validator({
		form: '#searchUser',
		trigger:'#submitBtn'
	});
});

//-->
</script>
</head>
<body class="main-body">
	<?php
	function action_echo($type){
		switch($type){
			case 1:
				echo '禁止发言';
				break;
			case 2;
				echo '禁止访问';
				break;
			case 3:
				echo '已被清除';
				break;
			case 4:
			default:
				
		}
	}
	?>
	<div class="path"><p>当前位置：用户管理<span>&gt;</span>用户管理</p></div>
    <div class="main-cont">
    	<h3 class="title">用户列表</h3>
		<div class="set-area">
        	<p class="tips-desc">请输入昵称搜索用户，然后选择相应的添加操作</p>
        	<div class="search-area">
            	<form action="<?php echo URL('mgr/users.search');?>" id="searchUser" method="post">
                	<div class="item">
                    	<label><strong>搜索包含以下昵称的用户</strong></label>
                        <input name="keyword" class="ipt-txt w200" type="text" vrel="sz=max:20,m:请限制在10个中文或20个英文以下。|ne" warntip="#nameTip" />
                        <a href="javascript:;" id="submitBtn" class="btn-general"><span>搜索</span></a>
                        <span class="tips-error hidden" id="nameTip"></span>
                    </div>
                </form>
			</div>
            <p class="tips-desc"><?php if($nickname):?>您的搜索结果如下：<?php else:?>已成功开通了本站微博的用户总计<span><?php echo $count;?></span>个，列表如下：<?php endif;?></p>
            <table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
                <colgroup>
                    <col class="w70" />
                    <col />
                    <col class="w150" />
                    <col class="w80" />
                    <col class="w80" />
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">昵称</div></th>
                        <th><div class="th-gap">开通时间</div></th>
                        <th><div class="th-gap">状态</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot class="tb-tit-bg">
                    <tr>
                        <td colspan="5">
                            <div class="pre-next">
                                <?php echo $pager;?>
                            </div>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                <?php if($list):?>
                 <?php foreach($list as $value):?>
                    <tr>
                        <td><?php echo ++$num;?></td>
                        <td><a href="<?php echo URL('ta', 'id='.$value['sina_uid'], 'index.php');?>" target="_blank"><?php echo F('escape', $value['nickname']); ?></a></td>
                        <td><?php echo date('Y-m-d H:i:s', $value['first_login']);?></td>
                        <td><?php action_echo($value['action_type'])?></td>
                        <td>
                            <a class='icon-operate' href="<?php echo URL('mgr/users.userAction','type=4&id='.$value['sina_uid'])?>">操作</a>							
                        </td>
                    </tr>
                 <?php endforeach;?>
                <?php else:?>
                    <tr><td colspan="5"><p class="no-data">没有搜索到任何记录</p></td></tr>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
