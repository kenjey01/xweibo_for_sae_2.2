<!-- 精彩访谈 开始-->
                            	<?php if ( !empty($last) ) { ?>
                                <div class="tit-hd">
                                	<h3><?php LO('modules_interview_index_list_title');?></h3>
                                </div>
                                <div class="talk-newest">
                                	<div class="bd">
                                    	<div class="item">
                                        	<div class="cover">
                                            	<a href="<?php echo URL('interview', array('id'=>$last['id']) ); ?>" target="_blank"><img src="<?php echo $last['cover_img']; ?>" alt="<?php echo $last['title']; ?>" /></a>
                                            </div>
                                            <div class="info">
                                           		<?php if ( isset($last['notice']) && $last['notice'] ) { ?><a class="ico-remind" href="#" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', L('modules_interview_index_list_toBegin', $last['title']));?>,c:<?php echo F('share_weibo', 'interview_tips', $last);?>,n:<?php echo $last['notice'];?>"><?php LO('modules_interview_index_list_remindMe');?></a> <?php } ?>
                                            	<h4><a href="<?php echo URL('interview', array('id'=>$last['id']) ); ?>" target="_blank"><?php echo $last['title']; ?></a>
                                            		<?php if ($last['status']=='P'){echo L('modules_interview_index_list_ready'); } elseif ($last['status']=='E'){ echo L('modules_interview_index_list_closed'); } else {echo L('modules_interview_index_list_going');}?>
                                            	</h4>
                                                <p class="time"><?php echo date($last['dateFormat'], $last['start_time']).'-'.date($last['dateFormat'], $last['end_time'])?></p>
                                            	<p><?php echo $last['desc']; ?></p>
                                            </div>
                                        </div>
                                        <?php if ( is_array($last['guest']) ) { ?>
                                        <div class="guests-list">
                                        	<div class="list-hd">
                                            	<h4><?php LO('modules_interview_index_list_guest');?></h4>
                                            </div>
                                        	<div class="list-bd" id="scrollor">
                                            	<ul>
                                            		<?php foreach ($last['guest'] as $aGuest) { ?>
                                                	<li>
                                                    	<a class="user-pic" href="<?php echo URL('ta', array('id'=>$aGuest['id'])); ?>">
                                                    	<img src="<?php echo $aGuest['profile_image_url']; ?>" alt="<?php echo $aGuest['screen_name']; ?>" /></a>
                                                    	<p><a href="<?php echo URL('ta', array('id'=>$aGuest['id'])); ?>"><?php echo $aGuest['screen_name'] . F('verified', $aGuest); ?></a></p>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <a href="#" class="arrow-l-s2 arrow-l-s2-disabled"><?php LO('modules_interview_index_list_left');?></a>
                                            <a href="#" class="arrow-r-s2 <?php if ( count($last['guest'])<6 ) { echo 'arrow-r-s2-disabled'; }?>"><?php LO('modules_interview_index_list_right');?></a>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
                                 <?php } ?>
                                <!-- 精彩访谈 结束-->
                                
                                
                                <!-- 更多 开始 -->
                                <?php if ( is_array($list) ) { ?>
                                <div class="tit-hd">
                                	<?php if ( $count>$limit+1 ) {?>
                          		    <a href="<?php echo URL('interview.page'); ?>" class="more"><?php LO('modules_interview_index_list_more');?>&gt;&gt;</a>
                          		    <?php } ?>
                                	<h3><?php LO('modules_interview_index_list_moreRecommend');?></h3>
                                </div>
                                
                                <div class="talk-list">
                                	<?php foreach ($list as $aRecord) {?>
                                    <div class="item">
                                        <div class="cover">
                                        	<a href="<?php echo URL('interview', array('id'=>$aRecord['id']) ); ?>" target="_blank"><img src="<?php echo $aRecord['cover_img']; ?>" alt="<?php echo $aRecord['title']; ?>" /></a>
                                        </div>
                                        <div class="info">
											<?php if ( isset($aRecord['notice']) && $aRecord['notice'] ) { ?><a class="ico-remind" href="#" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', L('modules_interview_index_list_toBegin', $aRecord['title']));?>,c:<?php echo F('share_weibo', 'interview_tips', $aRecord);?>,n:<?php echo $aRecord['notice'];?>"><?php LO('modules_interview_index_list_remindMe');?></a> <?php } ?>
                                            <h4><a href="<?php echo URL('interview', array('id'=>$aRecord['id']) ); ?>" target="_blank"><?php echo $aRecord['title']; ?></a>
                                            	<?php if ($aRecord['status']=='P'){echo L('modules_interview_index_list_ready'); } elseif ($aRecord['status']=='E'){ echo L('modules_interview_index_list_closed'); } else {echo L('modules_interview_index_list_going');}?>
                                            </h4>
                                            <p class="time"><?php echo date($aRecord['dateFormat'], $aRecord['start_time']).'-'.date($aRecord['dateFormat'], $aRecord['end_time'])?></p>
                                            <p><?php echo $aRecord['desc']; ?></p>
                                        </div>
                                    </div>  
                                    <?php } ?>                              
                                </div>
                                <?php } 
                                
                                // 没有访谈时显示提示
                                if ( empty($last) && empty($list) ) { 
                                ?>
								<div class="default-tips">
									<div class="icon-tips"></div>
									<?php if (USER::get('isAdminAccount')):?>
									<p><?php LO('modules_interview_index_list_admin_inertviewEmpty');?></p>
									<?php else:?>
									<p><?php LO('modules_interview_index_list_inertviewEmpty');?> </p>
									<?php endif;?>
								</div>
                                <?php } ?>
                                <!-- 更多 结束 -->
