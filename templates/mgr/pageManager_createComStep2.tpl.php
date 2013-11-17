<div class="form-box">	
<form id="addForm" action="<?php echo URL('mgr/page_manager.doCreateComponent');?>" method="post"  name="changes-newlink">
	<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
	<input type="hidden" name="data[component_id]" value="<?php echo $component_id; ?>">
	
	<?php 
/*
	if ( 16== $component_id ) {	// 微博发布框不用设置
		echo '<div id="componentPropertyDiv"></div>';
		return FALSE;
	}
*/
	?>		
	<div id="componentPropertyDiv">

	<?php if ( 16 != $component_id ) {	// 微博发布框不用设置?>
		<div class="form-row">
             <label class="form-field">标题</label>
            <div class="form-cont">
                 <input class="input-txt w130" type="text" vrel="ne=m:不能为空" warntip="#titleErr" name="data[title]" value="<?php echo V('r:title','')?>"/>
                 <span class="tips-error hidden" id="titleErr"></span>
            </div>
            
		</div>
	<?php }?>
    <?php 
  		// 各组件特有的设置
      	$id	= $component_id;
        //var_dump	($data);
            			
		if ($id == 2) { //名人推荐
			$rs 		  = DR('mgr/userRecommendCom.getById');
			$isGroupIdSet = isset($data['param']['group_id']);
			$topic_id 	  = isset($data['param']['topic_id']) ? $data['param']['topic_id'] : 0;
							
			// 设置默认选中的用户分组
			$selected_group_id = 0;
			$selected_group_id = $isGroupIdSet ? $data['param']['group_id']:$selected_group_id;
			if ($group_id = V('g:group_id', false)) {
				$selected_group_id = $group_id;
			} else {
				foreach ($rs['rst'] as $r) {
					$selected_group_id = $r['group_id'];
					break;
				}
			}
			// 新浪名人推荐类型
			$hotCategory = array(
				'1'  => '人气关注',
				'2'  => '影视名星',
				'3'  => '港台名人',
				'4'  => '模特',
				'5'  => '美食&健康',
				'6'  => '体育名人',
				'7'  => '商界名人',
				'8'  => 'IT互联网',
				'9'  => '歌手',
				'10' => '作家',
				'11' => '主持人',
				'12' => '媒体总编',
				'13' => '炒股高手'
			);
		?>
		<div class="form-row">
            <label  class="form-field">数据来源</label>
            <div class="form-cont">
            	<input type="hidden" name="param[topic_get]" value="1" />
                <label id="topicIdLabel" for="topic_id" style="<?php if (!$topic_id){echo "display:none;"; } ?>">
                <select name="param[topic_id]" id="topic_id">
                    <?php
                        foreach ($hotCategory as $key => $aCate) {
                            echo '<option  value="'.$key.'"'. ($topic_id && $topic_id == $key ? ' selected':'') .'>' . F('escape', $aCate) . '</option>';
                    }?>
                </select>
                </label>
                <label id="groupIdLabel" style="<?php if ($topic_id){echo "display:none;"; } ?>">
                <select name="param[group_id]">
                    <?php
                        foreach ($rs['rst'] as $row) {
                            if ($row['type'] < 1) {
                                echo '<option '.($selected_group_id==$row['group_id']?'selected="selected':'').'" value="'.$row['group_id'].'"'. ($isGroupIdSet && $data['param']['group_id']==$row['group_id'] ? ' selected':'') .'>' . F('escape', $row['group_name']) . '</option>';
                            }
                    }?>
                </select>
                </label>
                <a href="javascript:;" id="showArea">创建一个用户组</a>
                <span id="addArea" class="hidden">
                  分组名称: <input type="text" class="input-txt w130" id="Groupname"> <a href="javascript:;" class="icon-add" id="addGroup"> 添加分组 </a> <a href="javascript:;" class="icon-del" id="calGroup">取消 </a>
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
		<?php
			} elseif ($id == 3) {	// 用户推荐
				$rs 			= DR('mgr/userRecommendCom.getById');
				$isGroupIdSet 	= isset($data['param']['group_id']);

				// 设置默认选中的用户分组
				$selected_group_id = 0;
				for ($i=0,$count=count($rs['rst']); $i<$count; $i++) {
					if ($rs['rst'][$i]['type'] < 1 && !$selected_group_id) {
						$selected_group_id = $rs['rst'][$i]['group_id'];
					}
				}
				$selected_group_id = $isGroupIdSet ? $data['param']['group_id']:$selected_group_id;
				if ($group_id = V('g:group_id', false)) {
					$selected_group_id = $group_id;
				}
		?>
		<div class="form-row">
			<label class="form-field">数据来源</label>
			<div class="form-cont">
            	<select name="param[group_id]">
                <?php
                    foreach ($rs['rst'] as $row) {
                        if ($row['type'] < 1) {
                            echo '<option value="'.$row['group_id'].'"'. ($selected_group_id==$row['group_id'] ? ' selected':'') .'>' . F('escape', $row['group_name']) . '</option>';
                        }
                }?>
                </select>
                <a href="javascript:;" id="showArea">创建一个用户组</a>
                <span id="addArea" class="hidden">
                  分组名称: <input type="text" class="input-txt w130" id="Groupname"> <a href="javascript:;" class="icon-add" id="addGroup"> 添加分组 </a> <a href="javascript:;" class="icon-del" id="calGroup">取消 </a>
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
		<?php
			} elseif ($id == 18) {	// 用户推荐
		?>
		<div class="form-row">
			<label class="form-field">数据来源</label>
            <div class="form-cont">
                <select name="param[event_list_type]">
                    <option value='1'>最新活动</option>
                    <option value='2'>推荐活动</option>
                </select>
            </div>
		</div>	
			
			
			
		<?php } elseif ($id==5) { //自定义微博  	?>
		<div class="form-row">
            <label id="selectListLabel"  class="form-field" rel="sel5">数据来源</label>
            <div class="form-cont">
                <select name="param[list_id]" id="listIdSelect"  rel="sel5">
                    <option value="0">选择已有的微博列表</option>			
                    <?php 
                        DR('xweibo/xwb.setToken', FALSE, 2);	// Set The Site Tocken
                        $rs   		= DR('xweibo/xwb.getUserLists', FALSE, SYSTEM_SINA_UID);
                        $list 		= isset($rs['rst']['lists']) ? $rs['rst']['lists'] : array();
                        $curListId	= isset($data['param']['list_id']) ? $data['param']['list_id'] : 0;
                        $optionHtm 	= '<option #selected# value="#listId#">#list_name#</option>';
                        $listid = V('g:listId', $curListId);
                        
                        
                        foreach ($list as $aList) {
                            $listData['#listId#'] 		= $aList['id'];
                            $listData['#list_name#'] 	= F('escape', $aList['name']);
                            $listData['#selected#'] 	= ($listid==$aList['id']) ? 'selected' : '';
                            echo str_replace(array_keys($listData), array_values($listData), $optionHtm);
                        }
                        DR('xweibo/xwb.setToken', FALSE, 1);	// Set The Normal Tocken
                    ?>
                </select>
            	<input type="hidden" name="param[uid]" value="<?php echo SYSTEM_SINA_UID;?>">
                <?php if( 20 < count($list) ) {?>
                    
                    <p  rel="sel5">系统只支持创建20个微博列表数据源。<a href="<?php echo URL('mgr/site_list'); ?>">管理我的微博列表</a></p>
                    
                <?php } else { ?>
					<span id="show_div">
						<a href="<?php echo URL('mgr/site_list');?>">管理微博列表</a>&nbsp;
						<a href="javascript:;" id="showArea">增加微博列表</a>
					</span>
                    <span id="addArea" class="hidden">
                      微博列表: <input type="text" class="input-txt w130" name='name' id="Groupname"> <a href="javascript:;" class="icon-add" id="addGroup"> 添加列表 </a> <a href="javascript:;" class="icon-del" id="calGroup">取消 </a>
                    </span>
                    <span class="tips-error hidden" id="newListNameErr">该列表已存在</span>
                <?php } ?>
            </div>
        </div>
		
		<?php 
		
		//var_dump($list);
		if($listid){
			$ret = $rs = DR('components/officialWB.getUsers', '', $listid, 0);
		}
		
		?>
		<div class="form-row">
        	<label class="form-field">&nbsp;</label>
        	<div class="form-cont table-cont">
                <table class="add-table" id="addTable" cellpadding="0">
                    <tr>
                        <th class="pic">头像</th>
                        <th>昵称</th>
                        <th class="operate">操作</th>
                    </tr>
                    <?php if (isset($ret['rst']['users']) && is_array($ret['rst']['users'])) { foreach ($ret['rst']['users'] as $row) {?>
                    <tr rel="u:<?php echo $row['id'];?>">
                        <td><span class="user-pic"><img src="<?php echo F('profile_image_url', $row['id'], 'comment')?>"></span></td>
                        <td><p class="text"><?php echo $row['screen_name'];?></p></td>
                        <td>
                            <a rel="e:Udel" class="icon-del" href="javascript:;">删除</a>
                        </td>
                    </tr>
                    <?php }}?>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="text"  class="input-txt w130" name="nickname" id="nickname"/> <span class="tips-error hidden">该用户不存在</span> </td>
                        <td><a href="javascript:;" class="icon-add" rel="e:addUser">添加</a></td>
                    </tr>
                </table>
            </div>
		</div>
			
			
		<?php
			} elseif ($id == 6) { //热门话题
			 $list 		= DR('xweibo/topics.getCategoryByType');
			 $topic_get	= isset($data['param']['topic_get']) ? (int)$data['param']['topic_get'] : 0;
			 $topic_id	= ($topic_get == 0 && isset($data['param']['topic_id'])) ? $data['param']['topic_id']  : 0;
		?>
		<div class="form-row">
            <label class="form-field">数据来源</label>
            <div class="form-cont">
            	<p class="input-item">
                    <label for="topic_get1">
                        <input class="ipt-radio" type="radio" value="1" name="param[topic_get]" id="topic_get1" <?php if ($topic_get <=1){ echo ' checked '; }?> onclick="javascript:$('#topic_idLabel').hide();">同步新浪微博的热门话题
                    </label>
                </p>
                <p class="input-item">
                    <label for="topic_get3">
                        <input class="ipt-radio" type="radio" value="2" name="param[topic_get]" id="topic_get3" <?php if ($topic_get == 2){ echo ' checked '; }?> onclick="javascript:$('#topic_idLabel').hide();">自动获取站内热门话题
                    </label>
                </p>
                <p class="input-item">
                    <label for="topic_get2">
                        <input class="ipt-radio" type="radio" <?php if ($topic_id > 0){ echo 'checked'; }?> value="0" name="param[topic_get]" id="topic_get2" onclick="javascript:$('#topic_idLabel').show();">使用自定义话题列表
                    </label>
                </p>
                
                <div id="topic_idLabel" <?php if($topic_id < 1) {echo " style='display:none;' ";} ?>>
                        <p class="input-item">推荐话题列表 <span class="form-tips"></span></p>
                        <p class="input-item"><input type="text" class="input-txt w130" name="param[topics][]" /> <a href="javascript:;" class="icon-add" onclick="addIcs(this);">添加</a></p>
                        <!--
                        <select name="param[topic_id]">
                        <?php  foreach($list['rst'] as $row): if ($row['type'] < 1) {?>
                            <option value="<?php echo $row['topic_id'];?>"<?php if($row['topic_id']==$topic_id):?> selected<?php endif;?>><?php echo F('escape', $row['topic_name']);?></option>
                        <?php } endforeach; ?>
                        </select>
                        -->
                </div>
            </div>
		</div>


		<?php } elseif ($id == 10) { //今日话题 ?>
		<div class="form-row">
			<label class="form-field">设定话题</label>
            <div class="form-cont">
            	<input class="input-txt w130" type="text" name="param[topic]" />
            </div>
		</div>
		
	
		<?php } elseif ($id == 12) { //话题微博 ?>
		<div class="form-row">
			<label class="form-field">话题关键字</label>
			<div class="form-cont">
            	<input class="input-txt w130" type="text" vrel="ne=m:不能为空" warntip="#titleErr" name="param[topic]" value=""/>
                <span class="tips-error hidden" id="titleErr"></span>
            </div>
        </div>
	
	
		<?php } elseif ($id == 13) { //页面内焦点图 ?>
		<div class="form-row">
			<label class="form-field">链接</label>
            <div class="form-cont">
				<input class="input-txt w130" type="text" name="param[link]" value="<?php echo isset($data['param']['link']) ? $data['param']['link'] : 'http://'; ?>"/>
				<input type="hidden" name="param[src]" id="imgSrc" value="" />
                <p class="form-tips">如不需要链接，此处留空即可</p>
            </div>
		</div>
		<div class="form-row">
            <label class="form-field">图片宽度:</label>
            <div class="form-cont">
                 <p class="text">560px</p>
                <input type="hidden" name="param[width]" value="560" />
            </div>
		</div>
        <div class="form-row">
			<label class="form-field">图片高度: </label>
            <div class="form-cont">
            	
                <p><input class="input-txt w130" type="text" name="param[height]" value="<?php echo isset($data['param']['height']) ? $data['param']['height'] : ''; ?>"/></p>
                <p class="form-tips">高度为空时，默认为上传图片的高度</p>
            </div>
        </div>
				
		<?php } elseif ( 16 == $component_id ) {	// 微博发布框不用设置?>
		确定添加一个微博发布框吗?
		<?php }
			// 数量设置
			if (in_array($id, array(1,4,7,9,10,14,15,17,18,19))) 
			{
				$num_type = '';		// 显示数量的名称
				switch ($id) 
				{
					case '1':
					case '5':
					case '8':
					case '9':
					case '10':
					case '12':
					case '14':
					case '17':
						$num_type = '微博';
					break;
					
					case '6':
						$num_type = '话题';
					break;
					case '18':
					case '19':
						$num_type = '条';
					break;
					default: 
						$num_type = '用户';
				}
			
				// 显示数量的建议
				$showNumSugg = '';
				$valids 	 = array();
				switch ($id) {
					case 2:
					case 3:
					case 1:
					case 5:
					case 6:
					case 14:
					case 17:
					case 19:
						$showNumSugg = '设置范围3至20之间';
						array_push($valids, 'bt=min:3,max:20,m:范围为3-20');
					break;
					case 15:
					case 18:
						$showNumSugg = '设置值最少为3';
						array_push($valids, 'bt=min:3,m:最少为3');
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
				
				// 组件显示数量
				$validsStr 		= !empty($valids) ? 'vrel='.join('|', $valids)						: '';
				$showNumSugTip 	= $showNumSugg ? '<p class="form-tips">('. $showNumSugg .')</p>' 	: '';
				$showNumValue	= isset($data['param']['show_num']) ? $data['param']['show_num'] 	: '';
				if($id==18||$id==19){
					$showNumValue=3;
				}
				//var_dump($data);
				$showNumHtml = '<div class="form-row">
		                   			<label for="number2" class="form-field">显示'. $num_type .'数</label>
									<div class="form-cont">
		                   				<input class="input-txt w130" name="param[show_num]" type="text" '. $validsStr .' value="'. $showNumValue .'" warntip="#showNumErr"/>
										<span id="showNumErr" class="tips-error hidden"></span>
		                   				'. $showNumSugTip .'
									</div>
								</div>';
				
				echo $showNumHtml;
			} 
			
			
			
			// 微博来源
			if (in_array($id, array(8, 9, 10, 12))) 
			{
				$source			 = isset($data['param']['source']) ? $data['param']['source'] : FALSE;
				$checkSourceGet1 = $source ? ' checked="checked" ' 	: '';
				$checkSourceGet2 = !$source ? ' checked="checked" ' : '';
				$comeFromHtml = '<div class="form-row">
									<label class="form-field">数据来源</label>
									<div class="form-cont">	
										<p class="input-item">
											<label for="source_get1">
												<input class="ipt-radio" type="radio" value="1" ' .$checkSourceGet1 .' name="param[source]" id="source_get1" >仅显示来自本站微博
											</label>
										</p>
										<p class="input-item">
											<label for="source_get2">
												<input class="ipt-radio" type="radio" value="0" '. $checkSourceGet2 .' name="param[source]" id="source_get2">显示来自新浪全局的微博
											</label>
										</p>
									</div>	
								</div>';
				echo $comeFromHtml;
			}elseif(in_array($id, array(1, 17))){
				$comeFromHtml = '<div class="form-row">
									<label class="form-field">数据来源</label>
									<div class="form-cont">
										<p class="text">
											<input type="hidden" value="0" name="param[source]">来自新浪全局的微博
										</p>
									</div>
								</div>';
				echo $comeFromHtml;
			}
			
			
			// 分页设置
			if (in_array($id, array(5,8,12))) 
			{
				$pageSetting = '<div class="form-row">
									<label class="form-field">显示方式</label>
									<div class="form-cont">				
										<p class="input-item"><input class="ipt-radio" type="radio" name="param[page_type]" value="1" #pageTypeChecked# >分页显示，每页显示<input class="input-txt w30 input-disabled" type="text" name="param[show_num]" value="#showNumValue#" vrel="ne" disabled="disabled" />条</p>
										
										<p class="input-item"><input class="ipt-radio" type="radio" name="param[page_type]" value="0" #pageSizeChecked# >仅显示<input class="input-txt w30" type="text" name="param[show_num]" value="#showNumValue#" vrel="ne" checked="checked" />条</p>
									</div>
								</div>';
				
				$pageType 							= isset($data['param']['page_type']) ? $data['param']['page_type'] : '';
				$settingValue['#pageTypeChecked#']  = $pageType ? 'checked' : '';
				$settingValue['#pageSizeChecked#']  = empty($pageType) ? 'checked' : '';
				$settingValue['#showNumValue#']		= isset($data['param']['show_num']) ? intval($data['param']['show_num']) : 15;
				echo str_replace(array_keys($settingValue), array_values($settingValue), $pageSetting);
			}
		?>
  		</form>
                
                
 		<?php if ($id == 13) {  // 页面内焦点图组件上传图片  
           		$imgPreview = isset($data['param']['src']) ? $data['param']['src'] : '';
    	?>
 		<form id="img_form" target="img_upload" method="post" action="<?php echo URL('mgr/page_manager.uploadImage'); ?>" enctype="multipart/form-data">
        	<div class="form-row">
				<label for="img"  class="form-field">Banner图片</label>
                <div class="form-cont">
					<input type="file" class="btn-file" id="upload_file" name="img" onChange="preview(this)" />
                    <div id="img_preview" <?php if( empty($imgPreview) ){echo 'style="display:none"'; }?> class="img-preview">
                        <p>效果预览:</p>
                        <img src="<?php echo $imgPreview; ?>" style="width:220px; height:50px;" />
                    </div>
                    <div class="preview_loading" id="preview_loading" style="display:none;">正在上传图片，请稍候...</div>
                    <iframe name="img_upload" style="display:none;"></iframe>
                </div>
			</div>
		</form>
        <?php } ?>
        <div class="btn-area">
            <a class="btn-general highlight" href="#" id="submitBtn"><span>确定</span></a>
            <a class="btn-general" href="#" id="pop_cancel"><span>取消</span></a>
        </div>
        </div>
</div>
