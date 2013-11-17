									<ul>
										<?php foreach ($list['users'] as $item):?>
										<li rel="u:<?php echo $item['id'];?>,n:<?php echo F('escape', $item['screen_name']);?>">
											<div class="list-content">
												<div class="user-pic">
													<a href="<?php  echo URL('ta', array('id' => $item['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['profile_image_url']);?>" alt="" /></a>
												</div>
												<div class="content-r">
												<?php $r = APP::getRequestRoute(1);if ($r['function'] == 'fans') {?>
													<?php if (USER::uid() != $userinfo['id']):?>
														<?php if (in_array($item['id'], $fids) || $item['id'] == USER::uid()):?>
														<span class="followed-btn"><?php LO('common__template__followed');?></span>
														<?php else:?>
														<a href="#" class="addfollow-btn" rel="e:fl,t:1"><?php LO('common__template__toFollow');?></a>
														<?php endif;?>
													<?php else:?>
														<?php if (in_array($item['id'], $fids)):?>
														<div class="icon-each-follow" title="<?php LO('modules__userList__haveMutualInterest');?>"></div>
														<a href="javascript:;" id="removeFans" class="hidden" rel="e:dfan"><?php LO('modules__userList__removeFans');?></a>
														<?php else:?>
														<a rel="e:fl,t:1" class="addfollow-btn" href="#"><?php LO('common__template__toFollow');?></a>
													<?php endif;?>
														<?php if (HAS_DIRECT_MESSAGES){?><a href="javascript:;" rel="e:sdm,n:<?php echo F('escape', addslashes($item['screen_name']));?>" id="sendMsg" class="hidden"><?php LO('modules__userList__sendMessage');?></a><?php } ?>
													<?php endif;?>

												<?php } else {?>
													<?php if (USER::uid() != $userinfo['id']):?>
														<?php if (in_array($item['id'], $fids) || $item['id'] == USER::uid()):?>
														<span class="followed-btn"><?php LO('common__template__followed');?></span>
														<?php else:?>
														<a class="addfollow-btn all-bg"  rel="e:fl,t:1" href="#"></a>
														<?php endif;?>
													<?php else:?>
														<?php if (in_array($item['id'], $fids)):?>
														<div class="icon-each-follow" title="<?php LO('modules__userList__haveMutualInterest');?>"></div>
														<?php endif;?>
										<a href="javascript:;" rel="e:ufl" class="hidden" id="removeFans"><?php LO('modules__userList__cancelFollowed');?></a>
														<?php if (HAS_DIRECT_MESSAGES && in_array($item['id'], $fids)):?>
														<a href="javascript:;" rel="e:sdm" class="hidden" id="sendMsg"><?php LO('modules__userList__sendMessage');?></a>
														<?php endif;?>
													<?php endif;?>
												<?php }?>
												</div>
												<div class="content-m">
													<a class="u-name" href="<?php echo URL('ta', array('id' => $item['id']));?>">
														<?php echo F('escape', $item['screen_name']);?>
														<?php echo F('verified', $item);?>
													</a>
													<p class="<?php if ($item['gender'] == 'f'):?>ico-female<?php elseif ($item['gender'] == 'm'):?>ico-male<?php endif;?>"><?php echo F('escape', $item['location']);?> <?php LO('modules__userList__fansNum', $item['followers_count']);?></p>
													<div class="u-info"><a href="<?php echo URL('ta', array('id' => $item['id']));?>"><?php if (isset($item['status']['text'])):?><?php echo F('format_text', $item['status']['text'], 'comments');?><?php endif;?><?php if (isset($item['status']['created_at'])):?>(<?php echo F('format_time', $item['status']['created_at']);?>)<?php endif;?></a></div>
												</div>
											</div>
										</li>
										<?php endforeach;?>
									</ul>
