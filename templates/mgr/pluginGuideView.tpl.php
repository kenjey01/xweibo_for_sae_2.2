<div class="form-box" id="xwb_dlg_ct">
	<form id="form1" action="<?php echo URL('mgr/plugins.itemgroup', V('g:item_id', false)?'op=edit':'op=add');?>" name="cateform" method="post">
		<div class="form-row">
        	<label class="form-field">类别名称</label>
            <div class="form-cont">
                <input type="text" name="item_name" id="content" class="input-txt w130" vrel="ne=m:不能为空" warntip="#textErr" value="<?php echo isset($info['item_name'])?$info['item_name']:''?>">
                <?php if( V('g:item_id', false)){?>
                 <input type="hidden" value="<?php echo V('g:item_id');?>" name="id" />
                <?php } ?>
            </div>
			<span id="textErr" class="hidden tips-error">验证错误提示</span>	
		</div>	
		
		<div class="form-row add-area-row">		
        	<label class="form-field">数据来源</label>
            <div class="form-cont">
				<?php
                $rs	= DR('mgr/userRecommendCom.getById');
                $selected_group_id = 0;
                if ($group_id = V('g:group_id', false)) {
                    $selected_group_id = $group_id;
                } elseif (isset($info['item_id'])) {
                    $selected_group_id = $info['item_id'];
                } else {
                    foreach ($rs['rst'] as $group) {
                        $selected_group_id = $group['group_id'];
                        break;
                    }
                }
                ?>
                <select name="item_id" id="groupID" class="matic-slect-w">
                    <?php
                    foreach ($rs['rst'] as $row) {
                        if ($row['type'] < 1) {
                            echo '<option value="'.$row['group_id'].'"'. ($selected_group_id==$row['group_id'] ? ' SELECTED="SELECTED"':'') .'>' . F('escape', $row['group_name']) . '</option>';
                        }
                    }?>
                </select>	
                <a href="javascript:;" id="showArea">创建一个用户组</a>
                <span id="addArea" class="hidden">
                  分组名称: <input type="text" class="input-txt w100" id="Groupname"> <a class="icon-add" href="javascript:;" id="addGroup"> 添加分组 </a> <a href="javascript:;" class="icon-del" id="calGroup">取消 </a>
                </span>
                <span class="tips-error hidden" id="newListNameErr">该用户组已存在</span>
            </div>
		</div>

		<?php 
		$param = array('group_id' => $selected_group_id, 'show_num' =>20);
		$ret = DR('components/recommendUser.get','', $param);
		?>
		<div class="form-row">
        	<label class="form-field">&nbsp;</label>
			<div class="form-cont table-cont">
				<table class="add-table" id="addTable" cellpadding="0">
					<tbody>
						<tr>
							<th class="pic">头像</th>
							<th>昵称</th>
							<th>推荐理由</th>
							<th class="operate">操作</th>
						</tr>
					<?php if (isset($ret['rst']) && is_array($ret['rst'])) { foreach ($ret['rst'] as $row) {?>
					<tr rel="u:<?php echo $row['uid'];?>">
						<td><span class="user-pic"><img src="<?php echo F('profile_image_url', $row['uid'], 'comment')?>"></span></td>
						<td><p class="text"><?php echo $row['nickname'];?></p></td>
						<td><p class="text"><?php echo $row['remark'];?></p></td>
						<td>
							<a rel="e:Uedit" class="icon-edit" href="javascript:;">编辑</a>
							<a rel="e:Udel" class="icon-del" href="javascript:;">删除</a>
						</td>
					</tr>
					<?php }}?>
					<tr>
						<td>&nbsp;</td>
						<td><input type="text"  class="input-txt w130" name="nickname" id="nickname"/> <span class="tips-error hidden">该用户不存在</span> </td>
						<td><input type="text" class="input-txt w130" name="remark" id="remark"/></td>
						<td><a href="javascript:;" class="icon-add" rel="e:addUser">添加</a></td>
					</tr>
				</table>
			</div>
		</div>
	</form>
    <div class="btn-area">		
        <a class="btn-general highlight" href="javascript:;" id="submitBtn"><span>确定</span></a>
        <a class="btn-general" href="javascript:;" id="pop_cancel"><span>取消</span></a>
    </div>
</div>
