					<div id="showSetting" class="form-body">
                        <div class="form-info">
						<p><?php LO('modules__userNotice__setNoticeWay');?></p>
                        </div>
                        <form id="noticeForm">
                        <div class="setting-box">
<!--
                        	<strong>微博小黄签提醒显示位置</strong>
                            <div class="radio-box">
							<label><input name="newfeed" value="0" <?php //if (V('-:userConfig/user_newfeed') == '' || V('-:userConfig/user_newfeed') == '0'):?>checked="checked"<?php //endif;?> type="radio" />在页面顶部显示提示信息</label>
                                <label><input name="newfeed" value="1" <?php //if (V('-:userConfig/user_newfeed') == '1'):?>checked="checked"<?php //endif;?> type="radio" />在网页右下角使用气泡显示提示信息，网页打开期间始终可见</label>
                            </div>
-->
							<strong><?php LO('modules__userNotice__needTip');?></strong>
                            <div class="checkbox-box">
							<label><input name="comment" value="1" <?php if ($notice['comment'] == 1):?>checked="checked"<?php endif;?> type="checkbox" /><?php LO('modules__userNotice__newsCommentTip');?></label>
							<label><input name="follower" value="1" <?php if ($notice['follower'] == 1):?>checked="checked"<?php endif;?> type="checkbox" /><?php LO('modules__userNotice__newsFansTip');?></label>
							<?php if (HAS_DIRECT_MESSAGES){?><label><input name="dm" value="1" <?php if ($notice['dm'] == 1):?>checked="checked"<?php endif;?> type="checkbox" /><?php LO('modules__userNotice__newsMessageTip');?></label><?php } ?>
							<label><input name="mention" value="1" <?php if ($notice['mention'] == 1):?>checked="checked"<?php endif;?> type="checkbox" /><?php LO('modules__userNotice__newsAtMe');?></label>
							<label><input name="notice" value="1" <?php if (V('-:userConfig/user_newnotice') == 1):?>checked="checked"<?php endif;?> type="checkbox" /><?php LO('modules__userNotice__newsNoticeTip');?></label>
                            </div>
							<strong><?php LO('modules__userNotice__setAtMeAddNum');?></strong>
							<p><?php LO('modules__userNotice__weiboAuthor');?></p>
                            <div class="radio-box">
							<label><input name="from_user" value="0" <?php if ($notice['from_user'] == 0):?>checked="checked"<?php endif;?> type="radio" /><?php LO('modules__userNotice__allPeople');?></label>
							<label><input name="from_user" value="1" <?php if ($notice['from_user'] == 1):?>checked="checked"<?php endif;?> type="radio" /><?php LO('modules__userNotice__followPeople');?></label>
                            </div>
							<p><?php LO('modules__userNotice__weiboType');?></p>
                            <div class="radio-box bottom-line">
							<label><input name="status_type" value="0" <?php if ($notice['status_type'] == 0):?>checked="checked"<?php endif;?> type="radio" /><?php LO('modules__userNotice__allWeibo');?></label>
							<label><input name="status_type" value="1" <?php if ($notice['status_type'] == 1):?>checked="checked"<?php endif;?> type="radio" /><?php LO('modules__userNotice__oriWeibo');?></label>
                            </div>
                        </div>
                        <div class="form-row submit-btn">
						<a href="#" id="trig" class="btn-s3"><span><?php LO('common__template__save');?></span></a>
						</div>
					    </form>
                    </div>
