<div class="u-intro">
		<table>
			<tr>
				<td class="u-img" valign="top"><img src="<?php echo APP::F('profile_image_url', $userinfo['profile_image_url'], 'index')?>" alt="" /></td>
				<td>
					<div><?php echo F('verified', $userinfo)?>
					
					&nbsp;
					<?php
					if($userinfo['gender']=='m'):
					?>
					<?php LO('include__taHeader__genderMale');?>
					<?php
					else:
					?>
					<?php LO('include__taHeader__genderFemale');?>
					<?php
					endif;
					?>
					/<?php
					echo $userinfo['location']
					?>
					
					</div>
					<div><?php
					$des = F('escape',$userinfo['description']);
					echo mb_strlen($des) > 20 ? mb_substr($des,0,20,'utf8')."..." : $des;
					?></div>
					<div>
						<a href="<?php echo WAP_URL('ta.profile',"id={$userinfo['id']}&name={$userinfo['screen_name']}")?>"><?php LO('include__taHeader__info');?></a>
						<?php
						    if(USER::isUserLogin()) {
								$fids = DR('xweibo/xwb.getFriendIds', 'p', USER::uid(), null, null, -1, 5000);
								$fids = $fids['rst']['ids'];
								//var_dump($fids);
							    }
							    else {
								$fids=array();
							    }
						?>
						
						<?php
						$genderChar=($userinfo['gender']=='m'? L('include__taHeader__he'):L('include__taHeader__she'));
						if(in_array($userinfo['id'],$fids)):
						?>
						<a href="<?php echo WAP_URL('wbcom.cancelFollowAlert','id='.$userinfo['id'])?>"><?php LO('include__taHeader__nofollow');?></a>
						<?php
						elseif($userinfo['id']==USER::uid()):
						?>
						<?php LO('include__taHeader__mine');?>
						<?php
						else:
						?>
						<a href="<?php echo WAP_URL('wbcom.addFollow','id='.$userinfo['id'])?>"><?php LO('include__taHeader__follow');?><?php echo $genderChar?></a>                
						<?php
						endif;
						?>
						
					</div>
				</td>
			</tr>
		</table>
	</div>
        <div class='c'>
		<?php
		if(V('g:m')=='ta'):
		?>
		<span><?php LO('include__taHeader__weibo');?>[<?php echo $userinfo['statuses_count']?>]</span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('ta',"id={$userinfo['id']}&name={$userinfo['screen_name']}")?>"><?php LO('include__taHeader__weibo');?>[<?php echo $userinfo['statuses_count']?>]</a>
		<?php
		endif;
		?>
		
		
		
		<?php
		if(V('g:m')=='ta.follow'):
		?>
		<span><?php LO('include__taHeader__follow');?>[<?php echo $userinfo['friends_count']?>]</span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('ta.follow',"id={$userinfo['id']}")?>"><?php LO('include__taHeader__follow');?>[<?php echo $userinfo['friends_count']?>]</a>
		<?php
		endif;
		?>
		

		<?php
		if(V('g:m')=='ta.fans'):
		?>
		<span><?php LO('include__taHeader__fans');?>[<?php echo $userinfo['followers_count']?>]</span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('ta.fans',"id={$userinfo['id']}")?>"><?php LO('include__taHeader__fans');?>[<?php echo $userinfo['followers_count']?>]</a>
		<?php
		endif;
		?>
		
		
		<?php
		if(V('g:m')=='ta.mention'):
		?>
		<span><?php LO('include__taHeader__atWho', $genderChar);?></span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('ta.mention',"k=".urlencode($userinfo['screen_name']))?>"><?php LO('include__taHeader__atWho', $genderChar);?></a>
		<?php
		endif;
		?>
		
		
		
		
		
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	