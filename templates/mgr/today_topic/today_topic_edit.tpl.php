            	<form id="pop_form" action="<?php echo URL('mgr/weibo/todayTopic.edit', '', 'admin.php');?>" method="post"  name="add-newlink">
            		<div class="form-box">
                    	 <div class="form-row">
            				<label for="topic" class="form-field">话题内容</label>
                        	<div class="form-cont">
            					<input id="topic" name="topic" class="ipt-txt" type="text" value="<?php echo isset($info['topic'])? $info['topic'] : '';?>" vrel="_f|ne=m:不能为空|sz=max:15,m:15个汉字以内" warntip="#mdyTip"/>
                                <span class="tips-error hidden" id="mdyTip">错误提示</span>
                            </div>
            			</div>
						<?php if ((int)V('g:topic_id', 0) === 2 || isset($info) && (int)$info['topic_id'] === 2) {?>
                    	<div class="form-row">
                            <label for="ext1" class="form-field">生效时间：</label>
                            <div class="form-cont">
                                <input id="ext1" name="ext1" class="ipt-txt" type="text" vrel="_f|dt" warntip="#ext1Tip" value="<?php echo  date('Y/m/d H:i', isset($info['ext1'])?$info['ext1'] : time());?>"/>
                                <span class="tips-error hidden" id="ext1Tip"></span>
                            </div>
                        </div>
                        <?php }?>
                        <div class="btn-area">
                            <a class="btn-general  highlight" id="pop_ok" href="#"><span>确定</span></a>
                            <a class="btn-general" id="pop_cancel" href="#"><span>取消</span></a>
                        </div>
                    </div>
					<input type="hidden" name="topic_id" value="<?php echo isset($info['topic_id']) ? $info['topic_id'] : V('g:topic_id');?>">
					<input type="hidden" name="id" value="<?php echo isset($info['id']) ? $info['id'] : '';?>" />
                </form>
