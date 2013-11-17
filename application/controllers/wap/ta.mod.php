<?php
/**
 * @file			ta.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	heli/2010-11-15
 * @Brief			'ta的'控制器-Xweibo
 */

class ta_mod extends action {
    
    function ta_mod() {
    	parent::action();
    }
    /**
     * ta的首页
     *
     *
     */
    
    function profile() {


        //过滤类型
        $filter_type = V('g:filter_type');
        $id = V('g:id');
        $name = V('g:name');
        
        if (USER::isUserLogin()) {
            
            if (empty($id) && empty($name)) {

                /// 提示不存在
                
                $this->_showErr(L('controller__ta__profile__emptyTip'),WAP_URL('pub'));
                
            }
            $userinfo = DR('xweibo/xwb.getUserShow', 'p', null, $id, $name);
        } else {
            
            if (empty($name)) {
                DS('xweibo/xwb.setToken', '', 2);
                $oauth = true;
            } else {
                $id = null;
                $oauth = false;
            }
            $userinfo = DR('xweibo/xwb.getUserShow', '', $id, null, $name, $oauth);
        }
        $userinfo = F('user_filter', $userinfo['rst'], true);
        
        if (empty($userinfo)) {

            /// 提示不存在
            
            $this->_showErr(L('controller__ta__profile__emptyTip'),WAP_URL('pub'));
        } elseif (!empty($userinfo['filter_state'])) {

            /// 屏蔽用户
           
            $this->_showErr(L('controller__ta__profile__theUserHavedShied'),WAP_URL('pub'));
        }

        //页面代号
        APP::setData('page', 'ta', 'WBDATA');
        TPL::assign('uid', USER::uid());
        TPL::assign('userinfo', $userinfo);
        $this->_display('ta_profile');
    }
    /**
     * ta的关注列表
     *
     *
     */
    
    function follow() {

        $id = V('g:id');
        $name = V('g:name');
        $limit = 10;
        $page = V('g:page', 1);
        
        if (USER::isUserLogin()) {
            
            if (empty($id) && empty($name)) {

                /// 提示不存在
                $this->_showErr(L('controller__tab__follow__errorUrl'),WAP_URL('pub'));
            }
            $userinfo = DR('xweibo/xwb.getUserShow', 'p', null, $id, $name);
        } else {
            
            if (empty($name)) {
                DS('xweibo/xwb.setToken', '', 2);
                $oauth = true;
            } else {
                $id = null;
                $oauth = false;
            }
            $userinfo = DR('xweibo/xwb.getUserShow', '', $id, null, $name, $oauth);
        }

        //过滤过敏用户
        $userinfo = F('user_filter', $userinfo['rst'], true);
        
        if (empty($userinfo)) {

            /// 提示不存在
             $this->_showErr(L('controller__tab__follow__errorUrl'),WAP_URL('pub'));
        }
        $list = DR('xweibo/xwb.getFriends', '', $userinfo['id'], null, null, ($page - 1) * $limit, $limit);
        TPL::assign('uid', USER::uid());
        TPL::assign('userinfo', $userinfo);
        TPL::assign('list', isset($list['rst']['users']) ? $list['rst']['users'] : $list['rst']);

        //TPL::display('ta_follow');
        $this->_display('ta_friends');
        $this->_setBackURL();
    }
    
    function mention() {

        $k = V('g:k', false);
        
        if (!$k) {
            APP::redirect(URL('search'));
        }

        //搜索我微博
        
        if ($k !== false && !empty($k)) {
            $base_app = V('r:base_app', '0');
            
            if ($base_app != 1) {
                $base_app = 0;
            }
            $filter_pic = (int)V('r:filter_pic', 0);
            
            if ($filter_pic > 2 || $filter_pic < 0) {
                $filter_pic = 0;
            }
            $each_page = 10;
            $p = V('g:page', 1);
            $q = array(
                'needcount' => 'true',
                'q' => $k,
                'base_app' => $base_app,
                'page' => $p,
                'count' => $each_page,
                'filter_pic' => $filter_pic,
                'needcount' => 'true'
            );
            $results = DR('xweibo/xwb.searchStatuse', '', $q);
            $result = $results['rst'];
            
            if ($results['errno']) {
                $result['results'] = array();
                $result['total_count_maybe'] = 0;
            }
            TPL::assign('total_count_maybe', $result['total_count_maybe']);
            $result = $result['results'];
            $result = F('weibo_filter', $result);
            TPL::assign('each_page', $each_page);
            $rs = array_slice($result, 0, $each_page);
            TPL::assign('list', $result);
            TPL::assign('extends', array(
                'k' => $k,
                'base_app' => $base_app
            ));
        }
        APP::setData('page', 'search.weibo', 'WBDATA');

        //发微博对话框和搜索结果框
        TPL::assign('content', $k);
        $this->_display('ta_mention');
    }
    /**
     *
     * ta的profile
     *
     *
     */
    
    function default_action() {

        $id = V('g:id');
        $name = V('g:name');
        $limit = 10;
        $page = V('g:page', 1);
        $filter_type = V('g:filter_type');
        
        if (USER::isUserLogin()) {
            if (USER::uid() == $id) {
				APP::redirect('index', 2); //为本人则跳转到我的首页
            }
            
            if (empty($id) && empty($name)) {

                /// 提示不存在
                $this->_showErr(L('controller__ta__defaultAction__emptyTip'),WAP_URL('pub'));
                
            }
            $userinfo = DR('xweibo/xwb.getUserShow', 'p', null, $id, $name);
        } else {
            
            if (empty($name)) {
                DS('xweibo/xwb.setToken', '', 2);
                $oauth = true;
            } else {
                $id = null;
                $oauth = false;
            }
            $userinfo = DR('xweibo/xwb.getUserShow', '', $id, null, $name, $oauth);
        }
        $userinfo = F('user_filter', $userinfo['rst'], true);
        
        if (empty($userinfo)) {

            /// 提示不存在
            
            $this->_showErr(L('controller__ta__defaultAction__emptyTip'),WAP_URL('pub'));
        } elseif (!empty($userinfo['filter_state'])) {

            /// 屏蔽用户
          
            $this->_showErr(L('controller__ta__defaultAction__theUserHavedShied'),WAP_URL('pub'));
        }
        
        if (USER::isUserLogin()) {
            $oauth = true;
            $count = $limit;
        } else {
            $oauth = false;
        }
        $list = DR('xweibo/xwb.getUserTimeline', '', $id, null, $name, null, null, $limit, $page, $filter_type, $oauth);
        TPL::assign('userinfo', $userinfo);
        TPL::assign('list', $list['rst']);
        TPL::assign('page', $page);
        $this->_display('ta_weibo');
        $this->_setBackURL();
    }
    /**
     * ta的粉丝列表
     *
     *
     */
    
    function fans() {

        $id = V('g:id');
        $name = V('g:name');
        $limit = 10;
        $page = V('g:page', 1);
        
        if (USER::isUserLogin()) {
            
            if (empty($id) && empty($name)) {
                 $this->_showErr(L('controller__ta__fans__emptyTip'),WAP_URL('pub'));
                
            }
            $userinfo = DR('xweibo/xwb.getUserShow', 'p', null, $id, $name);
        } else {
            
            if (empty($name)) {
                DS('xweibo/xwb.setToken', '', 2);
                $oauth = true;
            } else {
                $id = null;
                $oauth = false;
            }
            $userinfo = DR('xweibo/xwb.getUserShow', '', $id, null, $name, $oauth);
        }

        //过滤过敏用户
        $userinfo = F('user_filter', $userinfo['rst'], true);
        
        if (empty($userinfo)) {

            /// 提示不存在
            
            $this->_showErr(L('controller__ta__fans__emptyTip'),WAP_URL('pub'));
        }

        /// 如果是自己，跳转到首页
        
        if (($name && $name == USER::v('srceen_name')) || $id == USER::uid()) {
            APP::redirect('index.fans', 2);
        }
        $list = DR('xweibo/xwb.getFollowers', '', $userinfo['id'], null, null, ($page - 1) * $limit, $limit);
        TPL::assign('list', isset($list['rst']['users']) ? $list['rst']['users'] : $list['rst']);
        TPL::assign('uid', USER::uid());
        TPL::assign('userinfo', $userinfo);
        $this->_display('ta_friends');
        $this->_setBackURL();
    }

    //function profile()
    
    //{

    
    //	$this->default_action();

    
    //}

    
}
