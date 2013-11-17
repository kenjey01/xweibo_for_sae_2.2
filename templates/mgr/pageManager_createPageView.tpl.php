            	<?php if (empty($pageList)) {echo "没有可创建的页面";} else {?>
            	<form id="addForm" action="<?php echo URL('mgr/page_manager.doCreatePage');?>" method="post"  name="changes-newlink">
                	<div class="form-box">
                        <div class="form-row">
                            <label class="form-field">页面名称</label>
                            <div class="form-cont">
                                <input name="data[page_name]" class="ipt-txt" vrel="_f|ne=m:不能为空|sz=max:15,m:15个汉字以内" warntip="#nameTip" type="text" value=""/>
                                <span class="tips-error hidden" id="nameTip"></span>
                            </div>
                        </div>
                        <div class=" form-row" style='display:none'>
                                <label class="form-field">页面类型:</label>
                                <select name="data[prototype_id]" >
                                    <?php
                                        foreach ($pageList as $aPage) 
                                        {
                                            echo '<option value="' . $aPage['id'].'">' . F('escape', $aPage['name']) . '</option>';
                                        }
                                    ?>
                                </select>
                        </div>
                        <div class="form-row">
                            <label class="form-field">页面描述</label>
                            <div class="form-cont">
                            	<textarea name="data[desc]" class="input-area w250" ></textarea>
                            </div>
                        </div>
                        <div class="btn-area">
                            <a class="btn-general highlight" href="#" id="submitBtn"><span>确定</span></a>
                            <a class="btn-general" href="#" id="pop_cancel"><span>取消</span></a>
                        </div>
                    </div>
                </form>
                <?php }?>