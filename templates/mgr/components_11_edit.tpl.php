<form action="" name="cateform" id="cateform" method="post" name="add-newlink">
	<div class="float-info">
		<label>
			</label><p>类别名称：</p>
			<input type="text" name="link-text" id="content" class="input-txt pop-w9" vrel="ne=m:不能为空" warntip="#textErr" value="<?php echo $item_name; ?>"><span id="textErr" class="hidden tips-error">验证错误提示</span>
	</div>
	<div class="float-info">
		<p>数据来源：</p>
		<select name="matic-yes" id="select" class="matic-slect-w">
		<?php 
			$list = DS('mgr/userRecommendCom.getById');
			foreach ($list as $aGroup)
			{
				$selectedHtm = ($aGroup['group_id']==$group_id) ? 'selected="selected"' : '';
				echo "<option value='{$aGroup['group_id']}' $selectedHtm >". F('escape', $aGroup['group_name']) ."</option>";
			}
		?>
		</select>
		<p>如果没有你想要的用户组, 你可以<a href="<?php echo URL('mgr/user_recommend.getReSort'); ?>">创建一个</a></p>
	</div>
	<div class="float-button">
		<span class="float-button-y"><input type="submit" name="确定" id="enter" value="确定" rel="ok"></span>
		<span class="float-button-n"><input type="button" name="取消" value="取消" rel="e:cal"></span>
	</div>
</form>