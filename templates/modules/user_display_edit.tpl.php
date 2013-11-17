					<form id="showForm">
                        <div id="showSetting" class="form-body">
                            <div class="form-info">
							<p><?php LO('modules__userDisplayEdit__chooseViewWay');?></p>
                            </div>
                            <div class="setting-box">
							<strong><?php LO('modules__userDisplayEdit__pageWeiboCount');?></strong>
								<p><?php LO('modules__userDisplayEdit__pageWeiboViewCount');?></p>
                                <div class="radio-box">
								<label><input name="feedtotal" value="10" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 10):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__10');?></label>
									<label><input name="feedtotal" value="20" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 20):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__20');?></label>
									<label><input name="feedtotal" value="30" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 30):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__30');?></label>
									<label><input name="feedtotal" value="40" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 40):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__40');?></label>
									<label><input name="feedtotal" value="50" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 50):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__50');?></label>
                                </div>
								<strong><?php LO('modules__userDisplayEdit__pageCommentCount');?></strong>
								<p><?php LO('modules__userDisplayEdit__pageCommentViewCount');?></p>
                                <div class="radio-box bottom-line">
								<label><input name="commenttotal" value="10" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 10):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__10');?></label>
									<label><input name="commenttotal" value="20" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 20):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__20');?></label>
									<label><input name="commenttotal" value="30" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 30):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__30');?></label>
									<label><input name="commenttotal" value="40" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 40):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__40');?></label>
									<label><input name="commenttotal" value="50" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 50):?>checked="checked"<?php endif;?> /><?php LO('modules__userDisplayEdit__50');?></label>
                                </div>
                            </div>
                            <div class="form-row submit-btn">
							<a href="#" class="btn-s3" id="trig"><span><?php LO('common__template__save');?></span></a>
                            </div>
                        </div>
                        <input type="submit" class="hidden" />
                        </form>
