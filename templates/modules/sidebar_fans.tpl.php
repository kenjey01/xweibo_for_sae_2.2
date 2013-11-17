					<!-- fans -->
                    <div class="mod-aside user-sidebar">
						<div class="hd"><h3><?php LO('modules__sidebarFans__whofansNum', F('escape', $userinfo['screen_name']), $userinfo['followers_count']);?></h3></div>
                        <div class="bd">
                            <ul>
                                <?php if ($followers):?>
                                <?php foreach ($followers as $item):?>
                                <li>
                                    <a href="<?php  echo URL('ta',array('id' => $item['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['profile_image_url']);?>" alt="<?php echo htmlspecialchars($item['screen_name']);?>" /></a>
                                    <p><a href="<?php echo URL('ta',array('id' => $item['id']));?>"><?php echo F('escape', $item['screen_name']);?></a></p>
                                </li>
                                <?php endforeach;?>
                                <?php endif;?>
                            </ul>
                            <?php if ($userinfo['followers_count'] > 9):?>
							<a href="<?php echo URL('ta.fans', 'id='.$userinfo['id']);?>" class="more-user"><?php LO('modules__sidebarFans__moreTip');?></a>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- end fans -->
