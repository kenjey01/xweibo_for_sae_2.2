<div id="picture" class="form-body">
									
	<?php if( $domain_name=USER::get('domain_name') ): ?>
	<div id="domainOk" class="domain-cont">
		<div class="success-wrap" style="width:70%">
			<div class="success">
				<span class="success-icon"></span>
				<p><?php LO('modules__userDomain__setDomain');?></p>
				<p class="overhead-info"><?php LO('modules__userDomain__youDomain');?><a href="<?php echo W_BASE_HTTP.W_BASE_URL.$domain_name; ?>" id="domainUrl" ><?php echo W_BASE_HTTP.W_BASE_URL.$domain_name; ?></a></p>
			</div>
			<p><a id="addFavLink" class="ico-fav" href="javascript:void(0);"><?php LO('modules__userDomain__addFavLink');?></a><a href="javascript:void(0);" id="showCopyDiv" class="ico-invite hidden"><?php LO('modules__userDomain__inviteFollow');?></a></p>
			<div class="set-domain hidden" style="margin-top:30px;" id="copyDiv">
				<div class="input-wrap">
                    <input type="text" class="input style-normal" id="u_domain" value="<?php echo W_BASE_HTTP.W_BASE_URL.'i/'.$domain_name; ?>">
					<a href="javascript:void(0);" class="search-host" id="copyToClipboard"><?php LO('modules__userDomain__copyLink');?></a>
				</div>
				<p class="example"><?php LO('modules__userDomain__sendLink');?></p>
			</div>
		</div>
	</div>
	
	<?php else: ?> 
	<div id="domainOk" class="domain-cont hidden">
		<div class="success-wrap" style="width:70%">
			<div class="success">
				<span class="success-icon"></span>
				<p><?php LO('modules__userDomain__setDomain');?></p>
				<p class="overhead-info"><?php LO('modules__userDomain__youDomain');?><a href="<?php echo W_BASE_HTTP.W_BASE_URL; ?>" id="domainUrl"><?php echo W_BASE_HTTP.W_BASE_URL; ?></a></p>
			</div>
			<p><a href="javascript:void(0);" class="ico-fav"><?php LO('modules__userDomain__addFavLink');?></a><a href="javascript:void(0);" id="showCopyDiv" class="ico-invite hidden"><?php LO('modules__userDomain__inviteFollow');?></a></p>
			<div class="set-domain hidden" style="margin-top:30px;" id="copyDiv">
				<div class="input-wrap">
                    <input type="text" class="input style-normal" id="u_domain" value="">
					<a href="javascript:void(0);" class="search-host" id="copyToClipboard"><?php LO('modules__userDomain__copyLink');?></a>
				</div>
				<p class="example"><?php LO('modules__userDomain__sendLink');?></p>
			</div>
		</div>
	</div>
	
	<div id="domainSet" class="domain-cont">
		<div class="desc">
		<p><?php LO('modules__userDomain__whySetDomain');?></p>
			<ul>
			<li><span><?php LO('modules__userDomain__inputLength');?></span></li>
				<li><span><?php LO('modules__userDomain__saveNotAllowModify');?></span></li>
			</ul>
		</div>
		<form id="domainForm">
		<div class="set-domain">
		<h4><?php LO('modules__userDomain__setPerDomain');?></h4>
			<p class="example"><?php LO('modules__userDomain__domainPreview');?><span id="domainPreview"><?php echo W_BASE_HTTP.W_BASE_URL; ?></span></p>
			<div class="input-wrap">
                <input type="text" vrel="_f=ch:1|ne|domain" warntip="#errTip" class="input style-normal" name="domain" id="domain" maxlength="30">
				<a href="#" class="search-host" id="domainTrig"><?php LO('common__template__OK');?></a>
			</div>
			<span class="wrong-txt tips-wrong hidden" id="errTip"><?php LO('modules__userDomain__nameAlreadyToken');?></span>
			<input class="hidden" type="submit" value=""/>
		</div>
	    </form>
	</div>
	<?php endif; ?>
                   						
</div>
