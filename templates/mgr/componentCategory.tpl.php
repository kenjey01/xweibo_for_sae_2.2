				<div class="tab-box">
					<h5 class="tab-nav clear" id="tabHead">
						<?php if (isset($component_cty) && is_array($component_cty)) {foreach ($component_cty as $key => $name) {?>
						<?php if(V('g:componentType')!=2||$key!='wb'){?>
						<a href="#"><span><?php echo $name;?></span></a>
						<?php }?>
						<?php }}?>
					</h5>
					<div class="tab-con" id="tabMain">
						<?php if (isset($componentList) && is_array($componentList)) {?>
						<?php if(V('g:componentType')!=2){?>
						<ul class="pic-item clear">
							<?php if (isset($componentList['wb']) && is_array($componentList['wb'])) { foreach($componentList['wb'] as $component) {?>
							<li class="modules-<?php echo $component['component_id'];?>"><?php echo $component['name'];?><a rel="e:openPop,url:<?php echo URL('mgr/page_manager.createComponentView',array('component_id' => $component['component_id'],'page_id' => $page_id));?>,title:<?php echo $component['name'];?>,component_id:<?php echo $component['component_id'];?>"></a></li>
							<?php }}?>
						</ul>
						<?php }?>
						<ul class="pic-item clear">
							<?php if (isset($componentList['user']) && is_array($componentList['user'])) { foreach($componentList['user'] as $component) {?>
							<li class="modules-<?php echo $component['component_id'];?>"><?php echo $component['name'];?><a rel="e:openPop,url:<?php echo URL('mgr/page_manager.createComponentView',array('component_id' => $component['component_id'],'page_id' => $page_id));?>,title:<?php echo $component['name'];?>,component_id:<?php echo $component['component_id'];?>"></a></li>
							<?php }}?>
						</ul>
						
						<ul class="pic-item clear">
							<?php if (isset($componentList['others']) && is_array($componentList['others'])) { foreach($componentList['others'] as $component) {?>
							<li class="modules-<?php echo $component['component_id'];?>"><?php echo $component['name'];?><a rel="e:openPop,url:<?php echo URL('mgr/page_manager.createComponentView',array('component_id' => $component['component_id'],'page_id' => $page_id));?>,title:<?php echo $component['name'];?>,component_id:<?php echo $component['component_id'];?>"></a></li>
							<?php }}?>
						</ul>
						
						<?php }?>
					</div>
				</div>
