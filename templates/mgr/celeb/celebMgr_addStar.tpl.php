				<form action="<?php echo URL('mgr/celeb_mgr.saveStar');?>" method="post"  name="add-newlink" id="staruserfrm">
					<input type="hidden" name="old_c_id1" value="<?php echo isset($info['c_id1']) ? $info['c_id1'] : V('g:pid', ''); ?>" />
					<input type="hidden" name="old_c_id2" value="<?php echo isset($info['c_id2']) ? $info['c_id2'] : V('g:cid', ''); ?>" />
					<input type="hidden" name="sina_uid" value="<?php echo isset($info['sina_uid']) ? $info['sina_uid'] : ''; ?>" />
                    <div class="form-box">
                        <?php if (!isset($info['nick'])): ?>
                        <div class="form-row">
                            <label for="nickname" class="form-field">用户昵称</label>
                            <div class="form-cont">
                                <input name="nickname" id="nickname" class="ipt-txt" type="text" value="" vrel="_f|sinan|ne=m:请输入昵称|sz=max:20,ww,m:最多10个汉字" warntip="#nicknameTip"/><span id="nicknameTip" class="tips-error hidden"></span>
                            </div>
                        </div>  
                        <?php else: ?>
                        <div class="form-row">
                            <label class="form-field">用户昵称</label>
                            <div class="form-cont">
                            	<span class="text"><?php echo F('escape', $info['nick']); ?></span>
                            </div>
                        </div>      
                         <?php endif; ?>
                        <div class="form-row">
                            <label class="form-field">顶级分类</label>
                            <div class="form-cont">
                                <select name="c_id1" class="select" onchange="javascript:ajax_load_add(this.value);">
                                <?php 
                                    $firstId = (isset($info['c_id1']) ? $info['c_id1'] : $cat_id); 
                                    foreach ($topCat as $cat_id => $cat_name):
                                        echo ('<option value="' . $cat_id . '"' . ( ($firstId==$cat_id) ? ' selected="selected"' : '') . '>' . $cat_name . '</option>');
                                   endforeach; ?>
                               </select>
                           </div>
                        </div>      
                        <div class="form-row">
                            <label class="form-field">二级分类</label>
                            <div class="form-cont">
                            	<span id="add_cid_2_span"><select name="c_id2" class="ipt-txt"><option value="0">二级分类</option></select></span>
                            </div>
                        </div>      
                        <div class="form-row">
                            <label class="form-field">字母索引</label>
                            <div class="form-cont">
                            	<select name="char_index" class="select"><?php for($i = 1; $i <= 26; $i++): echo ('<option value="' . $i . '"' . (($i == isset($info['char_index'])?$info['char_index']:0) ? ' selected="selected"' : '') . '>' . chr(64 + $i) . '</option>'); endfor; ?><option value="0"<?php echo ((!isset($info['char_index']) || (int)$info['char_index'] < 1 ||  (int)$info['char_index'] > 26) ? ' selected="selected"' : '');?>>其它</option></select>
                            </div>
                        </div>      
                        <div class="form-row">
                            <label for="sort" class="form-field">排序值</label>
                            <div class="form-cont">
                            	<input name="sort" id="sort" class="ipt-txt" type="text" value="<?php echo isset($info['sort']) ? (int)$info['sort'] : '0'; ?>" vrel="_f|sz=max:4,m:不能大于4位数|ne=m:不能为空" warntip="#sortTip"/><span id="sortTip" class="tips-error hidden"></span>
                            </div>
                        </div>
                        <div class="btn-area">
                            <a class="btn-general highlight" href="#" id="pop_ok"><span>确定</span></a>
                            <a class="btn-general" href="#" id="pop_cancel"><span>取消</span></a>
                        </div>
                    </div>
                </form>
