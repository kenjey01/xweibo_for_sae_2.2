<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/mod/mysetting.js"></script>
<div class="tab-s3">
<?php if (HAS_DIRECT_UPDATE_PROFILE):?>
<span class="person-current"><span><a href="<?php echo URL('setting.user');?>"><?php LO('modules__userSetting__info');?></a></span></span>
<?php else:?>
<span class="person-current"><span><a href="<?php echo URL('setting.tag');?>"><?php LO('modules__userSetting__info');?></a></span></span>
<?php endif;?>
<?php if (HAS_DIRECT_UPDATE_PROFILE_IMAGE):?>
<span class="modify-current"><span><a href="<?php echo URL('setting.myface');?>"><?php LO('modules__userSetting__modifyHeader');?></a></span></span>
<?php endif;?>
<span class="display-current"><span><a href="<?php echo URL('setting.show');?>"><?php LO('modules__userSetting__setDisplay');?></a></span></span>
<span class="blacklist-current"><span><a href="<?php echo URL('setting.blacklist');?>"><?php LO('modules__userSetting__blackList');?></a></span></span>
<span class="warn-current"><span><a href="<?php echo URL('setting.notice');?>"><?php LO('modules__userSetting__setTip');?></a></span></span>
<?php if ( USER::uid() && (V('-:sysConfig/login_way', 1)!=1) && USER::get('site_uid')) { ?>
<span class="account-current"><span><a href="<?php echo URL('setting.account');?>"><?php LO('modules__userSetting__setAccount');?></a></span></span>
<?php }?>
<?php if ( USED_PERSON_DOMAIN ) { ?>
<span class="host-current"><span><a href="<?php echo URL('setting.domain');?>"><?php LO('modules__userSetting__domain');?></a></span></span>
<?php }?>
</div>
