								<?php if (empty($list)) {?>
									<!-- comments list empty tip -->
									<div class="default-tips">
										<div class="icon-tips"></div>
										<?php if (V('g:page', 1) > 1):?>
										<p><?php LO('modules__comment__pageTip');?></p>
										<?php else:?>
											<?php if ($type == 'to'):?>
											<p><?php LO('modules__comment__myComment');?></p>
											<?php else:?>
											<p><?php LO('modules__comment__CommentSend');?></p>
											<?php endif;?>
										<?php endif;?>
									</div>
									<!-- end comments list empty tip -->
									<?php } else {?>
                                    <div class="list-handle">
                                        <!--<span class="total">143条</span>-->
										<label><input type="checkbox" rel="e:sa" /><?php LO('modules__comment__selectAll');?></label><em>|</em><a href="javascript:;" rel="e:da"><?php LO('modules__comment__delete');?></a>
                                    </div>
									<ul id="cmtCt">
                                <?php if ($list):?>
                                <?php foreach ($list as $item):?>
                                <?php 
									if (!empty($item['filter_state']) 
										|| !empty($item['user']['filter_state']) 
										|| !empty($item['user']['status']['filter_state']) 
										|| (isset($item['user']['status']['retweeted_status']) && !empty($item['user']['status']['retweeted_status']['filter_state'])) 
										|| (isset($item['user']['status']['retweeted_status']['user']) && !empty($item['user']['status']['retweeted_status']['user']['filter_state']))
										|| !empty($item['status']['user']['filter_state'])
										|| (isset($item['status']['retweeted_status']) && !empty($item['status']['retweeted_status']['filter_state']))
										|| (isset($item['status']['retweeted_status']['user']) && !empty($item['status']['retweeted_status']['user']['filter_state']))) {
											continue;	
									}
                                ?>
                                <?php if (!empty($item['status']['text'])):?>
                                <li rel="c:<?php echo $item['id'];?>,n:<?php echo htmlspecialchars($item['user']['screen_name']);?>,w:<?php echo $item['status']['id'];?>">
                                    <?php if ($item['status']['user']['id'] == $uid || $item['user']['id'] == $uid):?>
                                    <label class="checkbox"><input type="checkbox" rel="cdl" /></label>
                                    <?php endif;?>
                                    <div class="comment-list-main">
                                        <div class="user-pic">
											<a href="<?php  echo URL('ta',array('id' => $item['user']['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['user']['profile_image_url']);?>" alt="" title="<?php echo F('escape', $item['user']['screen_name']);?>" /></a>
                                        </div>
                                        <div class="comment-c">
                                            <p class="c-info"><a href="<?php  echo URL('ta',array('id' => $item['user']['id']));?>"><?php echo F('escape', $item['user']['screen_name']);?><?php echo F('verified', $item['user']);?></a> <?php echo APP::F('format_text', $item['text']);?>(<?php echo APP::F('format_time', $item['created_at']);?>)</p>
                                            <div class="c-for" id="cmtBoxCt">
											<a class="ico-reply" href="javascript:;" rel="e:rp" rel="<?php echo F('escape', $item['user']['screen_name']);?>"><?php LO('modules__comment__reply');?></a>
                                                <?php if ($item['status']['user']['id'] == $uid  || $item['user']['id'] == $uid):?>
												<a class="ico-del hidden" href="javascript:;" rel="e:dl"><?php LO('modules__comment__delete');?></a>
                                                <?php endif;?>
												<p><?php LO('modules__comment__replyWeibo');?><a href="<?php  echo URL('show',array('id' => $item['status']['id']));?>"><?php echo F('format_text', F('cut_string', $item['status']['text'], 50), 'comment'); ?></a></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php endif;?>
                                <?php endforeach;?>
                                <?php endif;?>
                            </ul>
    
                                    <div class="list-handle">
                                        <!--<span class="total">143条</span>-->
										<label><input type="checkbox" rel="e:sa" /><?php LO('modules__comment__selectAll');?></label><em>|</em><a href="javascript:;" rel="e:da"><?php LO('modules__comment__delete');?></a>
                                    </div>
                                    <!-- 分页 结束-->
									<?php TPL::module('page', array('list' => $list, 'limit' => $limit));?>
                                    <!-- 分页 结束-->
								<?php };?>
