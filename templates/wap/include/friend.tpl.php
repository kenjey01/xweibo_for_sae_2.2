 <table>
    	<tbody>
        	<tr>
                    <?php
		    
		    
                    //$ta_href=V('s:PHP_SELF','wap.php')."?m=ta&id={$id}";
		    if($userinfo['id']==USER::uid()) {
		     $ta_href=WAP_URL('index');
		    }
		    else {
		     $ta_href=WAP_URL('ta',"id={$userinfo['id']}");
		    }
            
            
		    
                    ?>
            	<td><a href="<?php echo $ta_href;?>"><img src="<?php echo $userinfo['face'];?>" alt="userName" /></a></td>
                <td><a href="<?php echo $ta_href;?>"><?php echo F('verified', $userinfo)?></a><br /><?php LO('include__friend__fans',$userinfo['followers_count']);?><br />
                <?php
                $genderChar=($userinfo['gender']=='m'?L('include__friend__genderMale'):L('include__friend__genderFemale'));
                ?>
                
                <?php
		//var_dump($fids['ids']);
                if(in_array($userinfo['id'],$fids)):
                ?>
		
                <?php LO('include__friend__followed');?>
		
		<?php
		elseif($userinfo['id']==USER::uid()):
		?>
		<?php LO('include__friend__mine');?>
                <?php
                else:
                ?>
                <a href="<?php echo WAP_URL('wbcom.addFollow','id='.$userinfo['id'])?>"><?php LO('include__friend__follow');?><?php echo $genderChar?></a>                
                <?php
                endif;
                ?>
                </td>
            </tr>
        </tbody>
    </table>
   
