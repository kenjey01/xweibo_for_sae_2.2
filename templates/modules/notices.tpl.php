						<?php if (empty($list)):?>
							<div class="default-tips">
								<div class="icon-tips"></div>
								<?php if (V('g:page', 1) > 1):?>
								<p><?php LO('modules__notices__endPage');?></p>
								<?php else:?>
								<p><?php LO('modules__notices__emptyTip');?></p>
								<?php endif;?>
							</div>
						<?php else:?>
						<div class="sys-notice">
							<ul>
								<?php foreach ($list as $item):?>
								<li>
									<div class="user-pic">
										<img src="<?php echo W_BASE_URL ?>img/system_pic.png" alt="" />
									</div>
									<div class="sys-con">
										<h3><span><?php LO('modules__notices__admin');?></span>：<?php echo htmlspecialchars($item['title']); ?></h3>
										<p><?php echo nl2br($item['content']); ?></p>
										<div class="ft">
											<div class="sys-date"><?php echo date("Y-m-d H:i:s", $item['available_time']) ?></div>
										</div>
									</div>
								</li>
								<?php endforeach;?>
							</ul>
			
									<!-- 分页 -->
									<?php TPL::module('page', array('list' => $list, 'limit' => $limit));?>
									<!-- end 分页 -->
						</div>
						<?php endif;?>
