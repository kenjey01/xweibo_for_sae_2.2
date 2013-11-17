            	<?php if (empty($componentList)) {echo "没有可新增的组件";} else {?>
            	<form id="addForm" action="<?php echo URL('mgr/page_manager.doCreateComponent');?>" method="post"  name="changes-newlink">
            		<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
            		
            		<div class="frm-row">
            			<label>组件类型:</label>
						<select name="data[component_id]">
							<?php
								foreach ($componentList as $aComponent) 
								{
									echo '<option value="' . $aComponent['component_id'].'">' . F('escape', $aComponent['name']) . '</option>';
								}
							?>
						</select>
            		</div>
            		
            		<?php if ($propertiesHtm) { echo $propertiesHtm; } ?>
					<div class="btn-area">
						<a class="btn-general highlight" href="#" id="submitBtn">确定</a>
						<a class="btn-general" href="#" id="pop_cancel">取消</a>
					</div>
                <?php }?>