						<div id="infomation" class="form-body">
                            <div class="form-info">
							<p><?php LO('modules__userBlackList__desc');?></p>
                            </div>
							<?php if (empty($blacklist)):?>
                            <div class="blacklist-con">
							<p><?php LO('modules__userBlackList__emptyTip');?></p>
								<p><strong><?php LO('modules__userBlackList__howToBlackUser');?></strong><?php LO('modules__userBlackList__setBlackUser');?></p>
                            </div>
							<?php else:?>
                            <div class="blacklist-con">
							<p><?php LO('modules__userBlackList__blacked');?></p>
                                <?php 
									foreach ($blacklist as $item):
									$id = $item['blocked_user']['user']['id'];
								?>
                                <div class="blacklist" rel="u:<?php echo $id;?>">
								<span class="operate"><a href="#" rel="e:dbl"><?php LO('modules__userBlackList__cancelBlack');?></a></span>
                                    <span class="date"><?php echo $item['blocked_user']['add_time'];?></span>
                                    <span class="username"><a href="<?php echo URL('ta', array('id' => $id, 'name' => $item['blocked_user']['user']['screen_name']));?>"><?php echo F('escape', $item['blocked_user']['user']['screen_name']);?></a></span>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <?php endif;?>
                        </div>
