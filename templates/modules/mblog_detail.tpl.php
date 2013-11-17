						<div class="feed-list mblog-list">
						<ul id="xwb_weibo_list_ct">
							<li rel="w:<?php echo $mblog_info['id'];?>">
							 <?php
								$uid = USER::uid();
								$mblog_info['header'] = 0;
								$mblog_info['uid'] = $uid;
								$mblog_info['author'] = true;
								$mblog_info['disable_comment'] = true;
								$mblog_info['is_show'] = $is_show;
								//Xpipe::pagelet('weibo.detail', $mblog_info);
								TPL::module('feed', $mblog_info);
							?>
							</li>
						</ul>
						</div>
						<div class="add-comment" id="topCmtBox">
						<p class="title"><?php LO('modules__mblog__pubComment');?></p>
							<div class="post-comment-main">
								<a href="javascript:;" class="icon-face-choose" rel="e:ic"></a>
								<div class="comment-r">
									<textarea class="comment-textarea style-normal" id="inputor"></textarea>
									<div>
									<a href="javascript:;" class="btn-s1" rel="e:sd"><span><?php LO('modules__mblog__comment');?></span></a>                       			
										<span class="keyin-tips" id="warn"><?php LO('modules__mblog__inputLength');?></span>
										<label><input type="checkbox" id="sync"><?php LO('modules__mblog__atTheSameTimePubWeibo');?></label>
									</div>
								</div>
							</div>
						</div>
						<div class="comment-list all-comment"  id="xwb_cmt_list" wbid="<?php echo $mblog_info['id'];?>">
							<ul id="cmtCt"></ul>
							<div class="list-footer hidden" id="pager">
								<div class="page" id="page">
								<a class="btn-s1" href="javascript:;" id="first" rel="e:fi"><span><?php LO('modules__mblog__indexPage');?></span></a><a class="btn-s1" href="javascript:;" id="pre" rel="e:pr"><span><?php LO('modules__mblog__prePage');?></span></a><a class="btn-s1" href="javascript:;" id="next" rel="e:nx"><span><?php LO('modules__mblog__nextPage');?></span></a>
								</div>
							</div>
						</div>	
