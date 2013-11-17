 
            	<form name="form1" method="post" action="" id="this_form">
                	<div class="form-box">
                    	<div class="form-row">
                        	<label class="form-field">审核制度</label>
                            <div class="form-cont">
								<p class="input-item">
									<label><input name="data[strategy]" type="radio" value="0" <?php echo (isset($config['strategy'])&&$config['strategy']) ? '' : 'checked'; ?> />先发布,后审核</label>
									<label><input name="data[strategy]" type="radio" value="1" <?php echo (isset($config['strategy'])&&$config['strategy']) ? 'checked' : ''; ?> />先审核,后发布</label>
								</p>
                            </div>
                        </div>
                        
               			<div id="strategy1Div" <?php echo (isset($config['strategy'])&&$config['strategy']) ? '' : 'style="display:none"'; ?> >
						<div class="form-row">
                        	<label class="form-field">审核范围</label>
                            <div class="form-cont">
								<p class="input-item">
									<label><input name="data[type]" type="radio" value="0" <?php echo (isset($config['type'])&&in_array($config['type'], array(1,2))) ? '' : 'checked'; ?> />全站</label>
									<label><input name="data[type]" type="radio" value="1" <?php echo (isset($config['type'])&&$config['type']==1) ? 'checked' : ''; ?> />指定用户审核</label>
									<label><input name="data[type]" type="radio" value="2" <?php echo (isset($config['type'])&&$config['type']==2) ? 'checked' : ''; ?> />指定用户不审核</label>
								</p>
                            </div>
                        </div>
						<div class="form-row" rel="t1">
							<label class="form-field">开始时间</label>
							<div class="input-item form-cont">
                                <label><input id="start" type="text" class="input-txt w100" name="data[start]" value="<?php echo isset($config['start']) ? date('Y-m-d', $config['start']) : ''; ?>" /></label>
                                <select name="data[start_h]" id="start_h" class="hour">
	                            <?php
	                                $start_h = isset($config['start']) ? date('G', $config['start']) : '';
	                                for($i=0; $i < 24; $i++):
	                            ?>
	                                <option value="<?php echo sprintf('%02d', $i);?>"<?php if($start_h==$i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
	                            <?php endfor;?>
	                            </select>
                            </div>
						</div>
						
						<div class="form-row" rel="t1">
							 <label class="form-field">结束时间</label>
                            <div class="input-item form-cont">
								<label><input id="end" type="text" class="input-txt w100" name="data[end]" value="<?php echo isset($config['end']) ? date('Y-m-d', $config['end']) : ''; ?>" /></label>
								<select name="data[end_h]" id="end_h" class="hour">
	                            <?php
	                                $start_h = isset($config['end']) ? date('G', $config['end']) : '';
	                                for($i=0; $i < 24; $i++):
	                            ?>
	                                <option value="<?php echo sprintf('%02d', $i);?>"<?php if($start_h==$i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
	                            <?php endfor;?>
	                            </select>
								<p class="form-tips">不选表示任何时间发布的微博都要审核</p>
                            </div>
						</div>
						<div class="form-row"  rel="t1">
							<label class="form-field">关键字</label>
							<div class="input-item form-cont">
                                <input id="page-decs" type="text" class="input-txt" name="data[keyword]" value="<?php echo isset($config['keyword']) ? implode(',', $config['keyword']) : ''; ?>" />
                            </div>
						</div>
						<div class="form-row"  rel="t2">
							<label class="form-field">指定用户</label>
							<div class="form-cont">
                                <textarea class="input-area area-s7" name="data[user]"><?php echo isset($config['user']) ? $config['user'] : ''; ?></textarea>
                                <p class="form-tips">多个用户昵称用“|”隔开</p>
                            </div>
						</div>
						</div>
						
                        <div class="btn-area">
                            <a href="#" class="btn-general highlight" id="pop_ok" ><span>保存</span></a>
                            <a class="btn-general " href="#" rel="e:cal"><span>取消</span></a>
                        </div>
                    </div>
                </form>
