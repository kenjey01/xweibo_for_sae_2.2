							<form id="userinfoForm">
                            <div id="infomation" class="form-body">
                                <div class="form-info">
									<span class="tab-s4">
									<?php if (HAS_DIRECT_UPDATE_PROFILE):?>
									<a href="javascript:void(0)" class="current"><?php LO('modules__userInfoEdit__baseInfo');?></a>
									<a href="<?php echo URL('setting.tag');?>"><?php LO('modules__userInfoEdit__tags');?></a>
									<?php else:?>
									<a href="javascript:void(0)" class="current"><?php LO('modules__userInfoEdit__tags');?></a>
									<?php endif;?>
									</span>
									<span class="tips"><em>*</em><?php LO('modules__userInfoEdit__mustOption');?></span>
                                </div>
								<div class="form-con">
									<div class="form-row">
									<label for="nick" class="form-field"><span>*</span><?php LO('modules__userInfoEdit__nickname');?></label>
										<input name="nick" vrel="_f|sinan|ne=m:<?php LO('modules__userInfoEdit__inputNick');?>|sz=min:4,max:20,ww,m:<?php LO('modules__userInfoEdit__nickLength');?>" warntip="#tip_nick" class="input-a style-normal" id="nick" tipOk="#nickOk" value="<?php echo $U['screen_name'];?>" type="text" />
                                        <span class="tips-wrong hidden" id="tip_nick"></span>
                                        <span class="tips-ok hidden" id="nickOk"></span>
									</div>
									<div class="form-row">
									<span class="form-field"><span>*</span><?php LO('modules__userInfoEdit__addr');?></span>
									<select name="province" id="province" preval="<?php echo $U['province'];?>" vrel="_f|ne=m:<?php LO('modules__userInfoEdit__inputAddr');?>"  warntip="#tip_city"><option value=""><?php LO('modules__userInfoEdit__choosePro');?></option></select>
									<select name="city" id="city" preval="<?php echo $U['city'];?>"><option value=""><?php LO('modules__userInfoEdit__chooseCity');?></option></select>
									<span class="tips-wrong hidden" id="tip_city"><?php LO('modules__userInfoEdit__inputAddr');?></span>
                                        <span class="tips-ok hidden" id="nickOk"></span>
									</div>
									<div class="form-row">
									<span class="form-field"><span>*</span><?php LO('modules__userInfoEdit__sex');?></span>
									<label for="male"><input id="male" type="radio" name="gender" <?php if ($U['gender'] == 'm' || $U['gender'] == ''):?>checked="checked"<?php endif;?> value="m"/><?php LO('modules__userInfoEdit__m');?></label>
									<label for="female"><input id="female" type="radio" name="gender" value="f" <?php if ($U['gender'] == 'f'):?>checked="checked"<?php endif;?>/><?php LO('modules__userInfoEdit__f');?></label>
									</div>
									<div class="form-row">
									<label for="description" class="form-field"><?php LO('modules__userInfoEdit__desc');?></label>
										<textarea class="style-normal" name="description" id="description" vrel="_f=ch:1|sz=max:140,m:<?php LO('modules__userInfoEdit__descLengthLimit');?>,ww" warntip="#tip_description"><?php echo $U['description'];?></textarea>
										<span class="tips-wrong hidden" id="tip_description"></span>
									</div>
									<div class="form-row submit-btn">
									<a href="#" class="btn-s3" id="trig"><span><?php LO('common__template__save');?></span></a>
									</div>
								</div>
                            </div>
                       </form>
