                                <div class="set-tags">
								<p><?php LO('modules__userTagEdit__whyAddTag');?></p>
                                    <div class="tags-box">
                                        <div class="top tags-bg"></div>
                                        <div class="mid">
                                            <div class="tags-field">
                                                <div class="tags-input">
												<form id="tagForm">
												<input type="text" vrel="_f|ne=w:<?php LO('modules__userTagEdit__chooseTag');?>|checktag" warntip="#tip" class="input-txt blur-txt style-normal" name="tags" id="tagInputor" value="<?php LO('modules__userTagEdit__chooseTag');?>"/><a href="#" class="btn-s3" id="trig"><span><?php LO('modules__userTagEdit__addTag');?></span></a>
														<input type="submit" class="hidden" />
														</form>
                                                </div>
												<p class="hidden" id="tip"></p>
                                            </div>
                                            <?php if(is_array($tagsuglist)): ?>
                                            <div class="tags-interest" id="selection">
                                                <div class="select-tags">
												<p><?php LO('modules__userTagEdit__interest');?></p>
													<?php foreach($tagsuglist as $tag):?>
													<a href="#" rel="e:ct,t:<?php echo $tag['value'];?>" ><span>+</span><?php echo $tag['value'];?></a>
													<?php endforeach;?>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="bot tags-bg"></div>
                                    </div>
									<div class="tags-title"><p><?php LO('modules__userTagEdit__addedTag');?></p></div>
                                    <div class="tags-area">
                                        <div class="tags-list">
											<ul id="tagList">
											<?php if (is_array($taglist)):?>
											<?php foreach($taglist as $tag):?>
											<?php foreach ($tag as $key => $item):?>
											<li><a href="<?php echo URL('search.user', array('k' => $item, 'ut' => 'tags')); ?>" class="a1"><?php echo F('escape', $item);?></a><a href="#" class="close-ico" rel="e:dt,id:<?php echo $key;?>"></a></li>
											<?php endforeach;?>
											<?php endforeach;?>
											<?php endif;?>
											</ul>
                                        </div>
                                    </div>
									<div class="tags-title"><p><?php LO('modules__userTagEdit__aboutTag');?></p></div>
                                    <div class="about-tags-list">
										<p>&middot;<?php LO('modules__userTagEdit__desc1');?></p>
										<p>&middot;<?php LO('modules__userTagEdit__desc2');?></p>
										<p>&middot;<?php LO('modules__userTagEdit__desc3');?></p> 
										<p>&middot;<?php LO('modules__userTagEdit__desc4');?></p>
                                    </div>
                                </div>
