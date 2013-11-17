<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title',$userinfo['screen_name']);?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
	<?php
	TPL::plugin('wap/include/top_logo','',false);
	TPL::plugin('wap/include/nav', array('is_top' => true), false);
	?>

	
<?php
	TPL::plugin('wap/include/ta_header', array("userinfo"=>$userinfo), false);
?>
	
	
    <div class="row"><span><?php LO('ta__profile__label_profile');?></span></div>
    <div class="c">
	<div><?php echo F('escape', $userinfo['screen_name'], ENT_QUOTES);?>
					
					<?php
					if($userinfo['gender']=='m'):
					?>
					<?php LO('ta__profile__label_genderMale');?>
					<?php
					else:
					?>
					<?php LO('ta__profile__label_genderFemale');?>
					<?php
					endif;
					?>
					/<?php
					echo $userinfo['location']
					?></div>
					
	
	
    </div>
    <?php
    $bigURL=APP::F('profile_image_url', $userinfo['profile_image_url'], 'profile');
    ?>
    <div class="c"><a href="<?php echo $bigURL;?>"><img src="<?php echo $bigURL;?>" alt="" /></a></div>
    <div class="c">
    <?php
    echo $userinfo['description'];
    ?></div>
		<?php
	TPL::plugin('wap/include/search','',false);
	?>
	<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot',"",false);
	?>
</body>
</html>
