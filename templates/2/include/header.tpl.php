<div id="header">
	<div class="nav">
    <div class="inner-nav" id="xwbInnerNav">
		<?php
			$header = "";
			$header = json_decode(V('-:sysConfig/head_link'),true);
			if($header){
				$count = count($header);
				$i = 1;
		?>
        <span class="defined-link">
		<?php foreach($header as $value){ ?>
			<a target="_blank" href="<?php echo $value['link_address'];?>"><?php echo $value['link_name'];?></a>
			<?php if($i < $count) echo '|'; $i++;}?>
		</span>
		<?php }?>
        <div class="nav-right">
            <form class="search-box skin-bg" onsubmit="return false" id="xwb_search_form">
                <input class="search-btn skin-bg" type="submit" value="" id="xwb_trig"/>
				<input class="search-input"  type="text" value="<?php LO('include__header__searchTip');?>"  id="xwb_inputor"/>
                </form>
			<span class="user-link">
		<?php
			$uid = User::uid();

			$plugins = DS('Plugins.get','',5);
			if ($uid) {
		?>
                <a href="<?php echo URL('index');?>"><?php echo F('escape', USER::get('screen_name'));?></a>
				<a href="<?php echo URL('setting');?>"><?php LO('include__header__set');?></a>
				<a href="<?php echo URL('index','skinset=1');?>"><?php LO('include__header__skin');?></a>|
			<?php if ($plugins['in_use']) {?>
			<a href="#" onclick="Xwb.use('feedback').display(true);return false;"><?php LO('include__header__feedback');?></a>|
			<?php }?>
                <?php
			if (USER::get('isAdminAccount')){
				LO('include__header__centralAdmin', W_BASE_URL_PATH.'admin.php');
			}
			?>
				<a href="<?php echo URL('account.logout');?>"><?php LO('include__header__logout');?></a>
                
		<?php
			} else {
		?>
			<?php if ($plugins['in_use']) {?>
			<a href="#" onclick="Xwb.use('feedback').display(true);return false;"><?php LO('include__header__feedback');?></a>
			<?php }?>
			<?php
			   if (V('-:sysConfig/login_way', 1)!=1 && USER::get('site_uid')){
			?>
				<a href="<?php echo URL('account.bind', '');?>" rel="e:lg"><?php LO('include__header__bindSinaWeibo');?></a>
				<a href="<?php echo URL('account.logout');?>"><?php LO('include__header__logout');?></a>
			<?php
			   }else{
			?>
			 
				<a href="<?php echo URL('account.login');?>" rel="e:lg"><?php LO('include__header__login');?></a>
		<?php
			   }
			}
		?>
		</span>
            </div>
        </div>
        <div class="nav-bg"></div>
	</div>
	
	<div class="hd-in">
		<?php 
			$headerModel 		= V('-:sysConfig/'.HEADER_MODEL_SYSCONFIG ); 
			$customHeader 		= 2;
			$interfaceHeader 	= 3; 
			if ( $customHeader==$headerModel ) 	// 输入页头Html模式
			{ 
				echo V('-:sysConfig/'.HEADER_HTMLCODE_SYSCONFIG );
			}
			else if ( $interfaceHeader==$headerModel ) 	// 接口调用页头
			{ 
				// for more
			}
			else {	// 默认页面
		?>
			<h1 class="logo">
				<a href="<?php echo URL('pub');?>" title="Xweibo">
					<img src="<?php echo F('get_logo_src','web');?>" id="logo" alt="" />
				</a>
			</h1>
			<?php if (!in_array(APP::getRequestRoute(), array('live','live.details','interview'))) {?>
			<div class="hd-xad">
				<?php echo F('show_ad', 'global_header', 'hd-xad-in');?>
			</div>
			<?php }?>
	<?php }?>
	</div>
</div>
<?php if ($plugins['in_use']) { ?>
<div class="win-pop win-feedback win-fixed hidden" id="feedbackBox">
	<div class="win-t"><div></div></div>
	<div class="win-con">
		<div class="win-con-in">
		<h4 class="win-tit x-bg"><?php LO('include__header__feedback');?></h4>
			<div class="win-box">
				<div class="win-box-inner">
					<form id="fbForm" method="post" action="<?php echo URL('feedback.save');?>">
					<p><?php LO('include__header__ideas');?></p>
						<div class="feedback-box">
							<div class="user-info">
								<img src="<?php echo USER::isUserLogin() ? F('profile_image_url', USER::uid(),'index') : W_BASE_URL. 'css/default/bgimg/icon_guest.png';?>" alt="" />
								<p><?php echo  USER::isUserLogin() ? USER::get('screen_name'):L('include__header__anonymous');?></p>
							</div>
							<div class="fill-textarea">
							<textarea class="style-normal" name="content" warntip="#feedbackTip" vrel="ne=m:<?php LO('include__header__inputContent');?>|sz=max:500,ww,m:<?php LO('include__header__contentLimit');?>"></textarea>
							</div>
						</div>
						<div class="feedback-box">
						<div class="input-title"><span><?php LO('include__header__contact');?></span></div>
							<div class="input-area">
							<div class="input-field"><input type="text" vrel="_ft|ft|mail" warntip="#feedbackTip" class="input-define style-normal" name="mail" value="<?php LO('include__header__email');?>"/></div>
								<div class="input-field"><input type="text" warntip="#feedbackTip" class="input-define style-normal" vrel="_ft|ft|int|radio" name="tel" value="<?php LO('include__header__phone');?>" /></div>
								<p><?php LO('include__header__inputContact');?></p>
								<div class="btn-area">
								<a class="btn-s1" href="#" id="trig"><span><?php LO('include__header__submit');?></span></a>
								</div>
								<span class="tips-wrong hidden" id="feedbackTip"><?php LO('include__header__inputContent');?></span>
								<input type="submit" class="hidden" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="win-con-bg"></div>
	</div>
	<div class="win-b"><div></div></div>
	<a class="ico-close-btn" href="#" id="xwb_cls" title="<?php LO('include__header__close');?>"></a>
</div>
<?php }?>
