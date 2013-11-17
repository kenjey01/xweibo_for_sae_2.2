								<div class="user-list user-list-mode">
									<p class="result"><?php LO('modules__eventMembers__eventJoinMemberNum', $event_info['join_num']*1);?></p>
                                    <ul>
									<?php if (is_array($members)) {foreach($members as $row) {?>
										<?php
											$mid = $row['sina_uid'];
										?>
                                        <li rel="u:<?php echo $mid;?>">
                                            <div class="list-content">
                                                <div class="user-pic">
                                                    <a href="<?php echo URL('ta', 'id=' .$mid)?>"><img alt="" src="<?php echo $users_info[$mid]['profile_image_url']?>"></a>
                                                </div>
                                                <div class="content-r">
												<?php if ($mid != USER::uid()) {?>
												<?php if (!empty($listFans) && in_array($mid, $listFans)) {?>
												<span class="followed-btn"><?php LO('modules__eventMembers__eventMemberFollowed');?></span>
												<?php } else {?>
												<a href="#" class="addfollow-btn" rel="e:fl,t:1"><?php LO('modules__eventMembers__eventMemberToFollow');?></a>
												<?php }}?>
                                                </div>
                                                <div class="content-m">
                                                    <a href="<?php echo URL('ta', 'id=' .$mid)?>" class="u-name"><?php echo htmlspecialchars($users_info[$mid]['screen_name']);?></a><span class="loc"><?php echo $users_info[$mid]['location'];?></span>
													<?php if($users_info[$mid]['description']) {?><div class="u-info"><a href="#" class="black"><?php echo htmlspecialchars($users_info[$mid]['description']);?></a></div><?php } ?>
													<?php if (USER::uid()==$event_info['sina_uid']||USER::get('isAdminAccount') ) {?>
														<?php if ($row['contact']):?><p class="phone"><span><?php LO('modules__eventMembers__eventPhone');?></span><?php echo htmlspecialchars($row['contact']);?></p><?php endif; ?>
														<?php if ($row['notes']):?><p><span><?php LO('modules__eventMembers__eventNotes');?></span><?php echo htmlspecialchars($row['notes']);?></p><?php endif; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </li>
<?php }}?>
                                    </ul>
                                    <!-- 分页 开始-->
                                    <div class="list-footer">
										<?php TPL::module('page', array('list' => $members, 'count' => $count, 'limit' => $limit, 'type' => 'event'));?>
									</div>
                                    <!-- 分页 结束-->
                                </div>
