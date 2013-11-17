<div class="map-cont clear">
                	<ul class="adobe-content">
<?php $count = 0;?>
				<?php if (isset($menu) && is_array($menu)) {$g_index=-1; foreach ($menu as $m_index => $m_menu) {?>
					<?php $first = 0;$p_index=0;$g_index++;?>
					<?php if (isset($m_menu['sub']) && is_array($m_menu)) {foreach ($m_menu['sub'] as $l_index => $l_menu) {?>
                        <li <?php  if ($count % 2 ==0){?>class="odd"<?php }?>>
							<?php if ($first == 0) {?>
                            <h4><?php echo $m_menu['title']?></h4>
							<?php }?>
                            <em><?php echo $l_menu['title'];?></em><span class="arr">&gt;</span>
							<?php
							$t = array();
							if (isset($l_menu['sub']) && is_array($l_menu['sub'])) {foreach ($l_menu['sub'] as $s_index => $s_menu) {
								$s_menu['link']=$g_index.'|'.($p_index++);
								/*$t[] = '<a  target="_self" href="javascript:window.location=\'' .$s_menu['link']. '\';window.location.reload();">' . $s_menu['title'] . '</a>';*/
								$t[] = '<a href="javascript:;" rel="e:reload,data:' .$s_menu['link']. '">' . $s_menu['title'] . '</a>';
								
							?>


						<?php }
							echo implode('|', $t);
						}?>
                        </li>
						<?php $first ++;$count++;?>
					<?php }}?>
				<?php }}?>
                        
                    </ul>
                </div>