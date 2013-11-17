						<ul>
						<?php
						
						$userTmp=$data;
						$data=array();
						foreach($userTmp as $row){
							if(isset($row['filter_state']) && !in_array(2,$row['filter_state'])){
								$data[]=$row;
							}
						}
						unset($userTmp);
						?>
						<?php
						if(empty($data)):
						?>
						<div class="search-result">
							<div class="icon-alert"></div>
							<p><strong><?php LO('modules__searchUser__emptyTip');?></strong></p>
						</div>
						<?php
						endif;
						?>
                        <?php foreach ($data as $item) { ?>
                            <li rel="u:<?php echo $item['id'];?>">
                                <div class="list-content">
                                    <div class="user-pic">
                                        <a href="<?php echo URL('ta', 'id=' . $item['id']);?>"><img src="<?php echo $item['profile_image_url']?>" alt="" /></a>
                                    </div>
                                    <div class="content-r">
									<?php if ($item['id'] !== USER::uid()) {?>
                                        <?php if ($item['following']) {?>
										<a href="#" class="followed-btn"><?php LO('modules__searchUser__followed');?></a>
                                        <?php } else {?>
										<a href="#" rel="e:fl,t:1" class="addfollow-btn"><?php LO('modules__searchUser__addFollow');?></a>
                                        <?php }?>
									<?php }?>
                                    </div>
                                    <div class="content-m">
                                        <a class="u-name" href="<?php echo URL('ta', 'id=' . $item['id']);?>"><?php echo htmlspecialchars($item['screen_name']);?></a>
                                        <?php echo F('verified', $item);?>
										<p class="ico-<?php if ($item['gender'] == 'f') {?>fe<?php }?>male"><?php echo $item['location'];?> <?php LO('modules__searchUser__fansNum', $item['followers_count']);?></p>
										<?php if (trim($item['description']) !== ''): ?><div class="u-info"><?php LO('modules__searchUser__desc');?><?php echo htmlspecialchars($item['description']); ?></div><?php endif; ?>
										<?php if (V('r:ut') === 'tags'): ?><p class="tag" rel="u:<?php echo $item['id'];?>"><?php LO('modules__searchUser__tags');?><?php echo htmlspecialchars(V('r:k')); ?> <a href="#" rel="e:allTag"><?php LO('modules__searchUser__lookUserTags');?></a></p><?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                        </ul>
