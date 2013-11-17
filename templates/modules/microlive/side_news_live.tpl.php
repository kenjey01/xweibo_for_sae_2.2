<div class="program-list">
                    	<div class="tit-hd">
                        	<a href="<?php echo URL('live');?>" class="more"><?php LO('modules_microlive_side_news_live_more');?>&gt;&gt;</a>
                            <h3><?php LO('modules_microlive_side_news_live_title');?></h3>
                        </div>
                        <div class="bd">
                        	<ul>
								<?php if ($list):?>
								<?php foreach ($list as $item):?>
                            	<li>
									<p><a href="<?php echo URL('live.details', 'id='.$item['id']);?>" target="_blank"><?php echo F('escape', $item['title']);?></a>
									<?php if ($item['start_time'] <= APP_LOCAL_TIMESTAMP && $item['end_time'] > APP_LOCAL_TIMESTAMP):?>
									<span class="active">(<?php LO('modules_microlive_side_news_live_running');?>)</span>
									<?php elseif ($item['start_time'] > APP_LOCAL_TIMESTAMP):?>
									<span class="unplayed">(<?php LO('modules_microlive_side_news_live_ready');?>)</span>
									<?php else:?>
									<span class="finish">(<?php LO('modules_microlive_side_news_live_close');?>)</span>
									<?php endif;?>
									</p>
                                    <p><span class="label"><?php LO('modules_microlive_side_news_live_master');?></span>
									<span class="emcee">
									<?php 
									$master_list = explode(',', $item['master']);
									foreach ($master_list as $var):
									?>
									<?php echo empty($var) ? '' : F('escape', $list_member[$var]['screen_name']);?>
									<?php endforeach;?>
									</span></p>
										<p><span class="label"><?php LO('modules_microlive_side_news_live_timeField');?></span><span class="time"><?php echo F('format_time.foramt_show_time', $item['start_time']);?></span></p>
                                </li>
								<?php endforeach;?>
								<?php endif;?>
                            </ul>
                        </div>
                    </div>
