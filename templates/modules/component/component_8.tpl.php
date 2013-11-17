<?php
	/**
	 * 同城微博模块模板
	 * 需要参数参见component_8_pls
	 * @version $Id$
	 */
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>

<div class="pub-feed-list" id="cityWb">
    <div class="title-box">
        <div class="change-city">
        	<p class="city"><?php if ($province && $city):?><span><?php echo F('escape', $province.','.$city);?></span><?php if (!empty($citys)):?>[<a href="#" name="city" id="cityBtn"><?php LO('modules_component_component_8_changeCity');?></a>]<?php endif;?><?php endif;?></p>
			<?php if (!empty($citys)):?>
			<div class="win-pop win-city hidden" id="win_city">
                <div class="win-t"><div></div></div>
                <div class="win-con">
                    <div class="win-con-in">
						<div class="select-area">
							<label for="sel-city"><?php LO('modules_component_component_8_selectArea');?></label>
							<select name="" id="sel-area">
							<?php
								foreach($provinces as $p) {
									echo '<option value="'.$p['id'].'"'.($province_id==$p['id']?' selected':'').'>'.$p['name'].'</option>';
								}
							?>
							</select>
						</div>
                        <div class="win-box" id="citys">
						<?php foreach($citys as $ct):?>
                            <a href="<?php echo URL($route, array('province' => $province_id, 'city' => key($ct), 'page_id'=>$page_id));?>#city"><?php echo F('escape', current($ct));?></a>
						<?php endforeach;?>
                        </div>
                    </div>
                    <div class="win-con-bg"></div>
                </div>
                <div class="win-b"><div></div></div>
                <div class="arrow"></div>
                <a href="#" class="ico-close-btn" id="xwb_cls"></a>
            </div>
			<?php endif;?>
        </div>
        <h3><?php echo F('escape', $mod['title']);?></h3>
    </div>
    
	<div class="feed-list">
		<?php	
			if (!empty($weiboList)) {
				TPL::module('feedlist', array('list' => $weiboList));
			}elseif(isset($weiboErrMsg) && defined('IS_DEBUG') && IS_DEBUG){
				echo $weiboErrMsg;
			}else{
				echo L('modules_component_component_8_weiboEmpty');
			}
        ?>
    </div>
	<?php if (USER::isUserLogin() /*&& $source */&& $page_type):?>
		<?php TPL::module('page', array('list' => $weiboList, 'limit' => $show_num));?>
	<?php endif;?>
</div>
