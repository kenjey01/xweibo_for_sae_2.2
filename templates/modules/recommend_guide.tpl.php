                    <div class="welcome">
						<!--<span><input type="checkbox" rel="e:sa"/>关注他们</span>
						<a class="intro-btn" href="<?php //echo URL('index');?>" rel="e:submit">">进入我的微博</a>-->
					</div>
					<?php if (V('-:sysConfig/wb_page_type', '1') == '2'): ?>
					<div class="form-info">
						<span class="tab-s4" id="cate_menu">
						<strong><?php LO('modules__recommendGuide__hotRecTitle');?></strong>
							<?php if (is_array($category)):
								$i = 0;
								foreach($category as $key =>$item): ?>
                                    <a <?php if ($i == 0) {?>class="current"<?php }?> rel="e:tab" href="<?php echo URL('welcome.recommendUsers', 'cid='.$key);?>"><?php echo $item;?></a>
								    <?php 
								        $i++;
								    endforeach;
								endif;
							?>
						</span>
					</div>
					<?php endif; ?>
                    <div class="active-wrap">
                    	<?php if (V('-:sysConfig/wb_page_type', '1') == '1'): ?>
                    	<div class="cate-menu">
						<h3><?php LO('modules__recommendGuide__hotRec');?></h3>
							<ul id="cate_menu">
								<?php if (is_array($category)):
									$i = 0;
									foreach($category as $key =>$item): ?>
	                                    <li <?php if ($i == 0) {?>class="current"<?php }?> rel="e:tab"><a href="<?php echo URL('welcome.recommendUsers', 'cid='.$key);?>"><?php echo $item;?></a></li>
									    <?php 
									        $i++;
									    endforeach;
									endif;
								?>
							</ul>
                        </div>
                        <?php endif; ?>
                        <div class="user-list user-list-narrow">
                        	<div class="user-list-wrap">
                        		<?php //TPL::module('user_list', array('users' => $users, 'fids' => $fids)); ?>
                        	</div>
                            <div class="select-user">
							<span class="all"><label for="check"><input type="checkbox" rel="e:sa" id="check" /><?php LO('modules__recommendGuide__chooseUsersNum');?></label></span>
                                	<a class="click-btn" rel="e:submit" href="<?php echo URL('index');?>"></a>
									<a class="end" href="<?php echo URL('index');?>"><?php LO('modules__recommendGuide__ship');?>&gt;&gt;</a>
                            </div>
                        </div>
                    </div>
