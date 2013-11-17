						<div class="feed-list">
                            <!--feed标题，信息过滤-->
                            <div class="title-box">
                                <div class="talk-tab">
                                	<span <?php if (!in_array($type, array('all', 'myAnswered')) ){ echo 'class="cur"'; } ?> ><span>
                                		<a href="<?php echo URL('interview', array('id'=>$interview['id'])) ?>"><?php LO('modules_interview_guestweibo_list_myQuestion');?></a>
                                	</span></span>
                                	<span <?php if ($type=='all'){ echo 'class="cur"'; } ?> ><span>
                                		<a href="<?php echo URL('interview', array('id'=>$interview['id'], 'type'=>'all')); ?>"><?php LO('modules_interview_guestweibo_list_allQuestion');?></a>
                                	</span></span>
                                	<span <?php if ($type=='myAnswered'){ echo 'class="cur"'; } ?> ><span>
                                		<a href="<?php echo URL('interview', array('id'=>$interview['id'], 'type'=>'myAnswered')); ?>"><?php LO('modules_interview_guestweibo_list_myAnswered');?></a>
                                	</span></span>
                                </div>
                                <div class="feed-refresh hidden">
                                    <a href="#"><?php LO('modules_interview_guestweibo_list_hasNew');?></a>
                                </div>
                            </div>
                            
                            <!-- 我的问题微博列表  开始-->
                            <?php if( $wbList['myCnt']<=0 ){ ?>
                            	<div class="default-tips" id="emptyTip">
									<div class="icon-tips"></div>
									<p><?php if ( $type=='myAnswered' ) {LO('modules_interview_guestweibo_list_answeredEmpty');} else {LO('modules_interview_guestweibo_list_weiboEmpty');} ?></p>
								</div>
								<ul id="xwb_weibo_list_ct"></ul>
							<?php } else { ?>
							
								<ul id="xwb_weibo_list_ct">
								<?php
									$noAnswer	= ($type=='myAnswered');
									$currentUid = 'false';	// 设置为特殊字符，目的不显示删除链接
									foreach ($wbList['myList'] as $aWbTmp)
									{
										// 问答型微博
										if ($type=='myAnswered')
										{
											// 评论微博
											if ( isset($aWbTmp['comWb']) )
											{
												$wb			= $aWbTmp['comWb'];
												$wb['uid'] 	= $currentUid;
											
												echo '<div class="emcee-com"><div class="talk-content" rel="w:'. $wb['id'].'">';
				                                    TPL::module('feed', $wb);
												echo '<div class="emcee-icon"></div></div></div>';
												continue;
											}
											
											
											// 问答微博开始
											if (isset($aWbTmp['askWb']) || isset($aWbTmp['answerWb']))
											{										
												echo '<div class="inte-list">';
												
												// 问微博
												if ( isset($aWbTmp['askWb']) )
												{
													$wb			= $aWbTmp['askWb'];
													$wb['uid'] 	= $currentUid;
												
													echo '<div class="talk-content fans-ask" rel="w:'. $wb['id'].'">';
					                                    TPL::module('feed', $wb);
													echo '<div class="ask-icon"></div></div>';
												}
												
												// 答微博
												if ( isset($aWbTmp['answerWb']) && is_array($aWbTmp['answerWb']) )
												{
													foreach ($aWbTmp['answerWb'] as $wb)
													{
														$wb['uid'] = $currentUid;
														
														echo '<div class="talk-content guest-reply" rel="w:'. $wb['id'].'">';
					                                    TPL::module('interview/feed_answer', $wb);
														echo '<div class="reply-icon"></div></div>';
													}
												}
												
												echo '</div>';
											}
										}
										else if ( isset($aWbTmp['askWb']['id']) )	// 带回答微博
										{
											$wb				= $aWbTmp['askWb'];
											$wb['uid'] 		= $currentUid;
											$wb['noAnswer'] = $noAnswer;
											echo '<li rel="w:'.$wb['id'].'">';
												TPL::module('interview/feed_withAnswer', $wb);
											echo '</li>';
										}
									}
								}
								?>
								</ul>
							<!-- 我的问题微博列表  结束-->
							
                            <!-- 分页 结束-->
                           <?php TPL::module('page', array('list'=>$wbList['myList'], 'count'=>$wbList['myCnt'], 'limit'=>$limit, 'type'=>'event'));?>
                            <!-- 分页 结束-->
                        </div>
