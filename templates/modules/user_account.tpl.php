						<div id="showSetting" class="form-body">
                            <div class="form-info">
							<p><?php LO('modules__userAccount__cancelBindTip');?></p>
                            </div>
                        </div>
						<div class="tags-title"><p><strong><?php LO('modules__userAccount__weiboSina');?><?php echo USER::uid();?></strong></p></div>
                        <div class="account-set">
                            <div class="logo-pic">
                                <div class="logo1">
									<?php 
                                        if (V('-:sysConfig/logo',false)){
                                            echo '<img src="'.V('-:sysConfig/logo').'"/>';
                                        }else{
                                            echo '<img src="'.W_BASE_URL_PATH.WB_LOGO_DEFAULT_NAME.'"/>';
                                        }
                                    ?>
                            	</div>
                                <div class="logo2"><img src="<?php echo W_BASE_URL_PATH;?>img/logo/sina_logo.png" alt="" /></div>
                                <div class="icon-two-way"></div>
                            </div>
                            <div class="btn-area">
							<a href="<?php echo URL('account.unBind')?>" class="btn-s3" id="unbind"><span><?php LO('modules__userAccount__cancelBind');?></span></a>
							</div>
						</div>
						<div class="tags-title"><p><?php LO('modules__userAccount__aboutBind');?></p></div>
                        <div class="about-tags-list">
							<p>&middot;<?php LO('modules__userAccount__desc1');?></p>
							<p>&middot;<?php LO('modules__userAccount__desc2');?></p>
							<p>&middot;<?php LO('modules__userAccount__desc3');?></p>
                        </div>
