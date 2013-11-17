						<!-- 访谈内容 开始-->  
                        <div class="title-box">
                        	<h3><?php LO('modules_interview_answerweibo_nopage_count', $wbList['allAskCnt'], $wbList['replyCnt']); ?></h3>
                        </div>
                        
						<div class="feed-list talk-list">
                        	<!-- 问答列表 开始 -->
                            <?php if( $wbList['answerCnt']<=0 ){ ?>
								<div class="default-tips" id="emptyTip">
									<div class="icon-tips"></div>
									<p><?php LO('modules_interview_answerweibo_nopage_weiboEmpty');?></p>
								</div>
								<ul id="xwb_weibo_list_ct"></ul>
							<?php } else 
								{ 
									echo '<ul id="xwb_weibo_list_ct">';
									$curUid = 'false';	// 设置为特殊字符，目的不显示删除链接
									
									foreach ($wbList['answerList'] as $aWbTmp)
									{
										// 评论微博
										if ( isset($aWbTmp['comWb']) )
										{
											$wb			= $aWbTmp['comWb'];
											$wb['uid'] 	= $curUid;
										
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
												$wb['uid'] 	= $curUid;
											
												echo '<div class="talk-content fans-ask" rel="w:'. $wb['id'].'">';
				                                    TPL::module('feed', $wb);
												echo '<div class="ask-icon"></div></div>';
											}
											
											// 答微博
											if (isset($aWbTmp['answerWb']) && is_array($aWbTmp['answerWb']) )
											{
												foreach ($aWbTmp['answerWb'] as $wb)
												{
													$wb['uid'] = $curUid;
													
													echo '<div class="talk-content guest-reply" rel="w:'. $wb['id'].'">';
				                                    TPL::module('interview/feed_answer', $wb);
													echo '<div class="reply-icon"></div></div>';
												}
											}
											
											echo '</div>';
										}
									}
									echo '</ul>';
								}
								?>
                            
                            <!-- 分页 结束-->
                            <?php 
                            	if ( isset($limit) ) 
                            	{
                            		TPL::module('page', array('list'=>$wbList['answerList'], 'count'=>$wbList['answerCnt'], 'limit'=>$limit, 'type'=>'event'));
                            	}?>
                            <!-- 分页 结束-->
                        </div>
						<!-- 访谈内容 结束-->
