<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员用户列表 - 帐号管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body class="main-body">
<div class="main-wrap">
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>管理员设置</p></div>
	<div class="main-cont">
    <h3 class="title">管理员用户列表</h3>
    <div class="set-area">
        <table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
            <colgroup>
                <col class="w70"/>
                <col />
                <col class="w110" />
                <col class="w150" />
                <col class="w130" />
            </colgroup>
            <thead class="tb-tit-bg">
                <tr>
                    <th><div class="th-gap">编号</div></th>
                    <th><div class="th-gap">管理员昵称</div></th>
                    <th><div class="th-gap">权限</div></th>
                    <th><div class="th-gap">添加时间</div></th>
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
                        <td><a href="<?php echo URL('ta', 'id='.$value['sina_uid'] ,'index.php');?>" target="_blank"><?php if(isset($value['userinfo']['nickname'])) echo F('escape', $value['userinfo']['nickname']); ?></a></td>
                        <td><?php echo $value['group_name'];?></td>
                        <td><?php echo date('Y-m-d H:i:s', $value['add_time']);?></td>
                        <td>
                            <?php if($admin_root && $value['id'] != $admin_id):?>
                                <a class="icon-permission" href="javascript:delConfirm('<?php echo URL('mgr/admin.del', 'id=' . $value['id']);?>','您确定取消<?php echo $value['userinfo']['nickname'];?>的管理员权限吗？')">取消管理员权限</a>
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>
                <?php endif;?>
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>
