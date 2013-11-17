            	<form id="addTopicForm" action="<?php echo URL('mgr/weibo/todayTopic.addCategory','', 'admin.php');?>" method="post"  name="changes-newlink">
                	<div  class="form-box">
                        <div class="form-row">
                            <label for="topic_name" class="form-field">列表名称</label>
                            <div class="form-cont">
                            	<input name="topic_name" id="topic_name" class="ipt-txt" vrel="_f|ne=m:不能为空|sz=max:15,m:15个汉字以内" warntip="#nameTip" type="text" value="<?php echo isset($info['topic_name'])? $info['topic_name']:'';?>"/>
                                <span class="tips-error hidden" id="nameTip"></span>
                            </div>
                        </div>
                        <div class="btn-area">
                            <a class="btn-general highlight" href="#" id="pop_ok"><span>确定</span></a>
                            <a class="btn-general" id="pop_cancel" href="#"><span>取消</span></a>
                        </div>
                    </div>
                        <?php if (isset($info['topic_id'])) {?>
                        <input type="hidden" name="topic_id" value="<?php echo $info['topic_id'];?>">
                        <?php  }?>
                </form>