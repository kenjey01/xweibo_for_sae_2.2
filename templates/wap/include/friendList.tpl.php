<?php





if(!empty($list)&&isset($list[0])&&is_array($list[0]))
foreach($list as $fr){
    //var_dump($fr);
    $fr['id']=isset($fr['sina_uid'])?$fr['sina_uid']:$fr['id'];
    $fr['face']=isset($fr['face'])?$fr['face']:$fr['profile_image_url'];
    $fr['nick']=isset($fr['nick'])?$fr['nick']:$fr['screen_name'];
    $userinfo = DR('xweibo/xwb.getUserShow', '', $fr['id'], null, null, true);
    //var_dump($fr);
    if(isset($userinfo['rst'])&&is_array($userinfo['rst'])&&!empty($userinfo['rst'])) {
        $fr['followers_count']=$userinfo['rst']['followers_count'];
        $fr['following']=$userinfo['rst']['following'];
        $fr['gender']=$userinfo['rst']['gender'];
    }
    else{
        $fr['followers_count']=L('include__friendlist__error');
        $fr['following']=L('include__friendlist__error');
        $fr['gender']=L('include__friendlist__error');
        
    }
    if(USER::isUserLogin()) {
        $fids = DR('xweibo/xwb.getFriendIds', 'p', USER::uid(), null, null, -1, 5000);
        $fids = $fids['rst']['ids'];
        //var_dump($fids);
    }
    else {
        $fids=array();
    }
    echo '<div class="f-list">';
    TPL::plugin('wap/include/friend', array('userinfo'=>$fr,'fids'=>$fids), false);
    echo '</div>';
}


        
?>