                    <?php if (!USER::isUserLogin()):?>
                    <div class="weibo-notice">
                        <!-- 用户未登录显示 开始-->
						<p class="login-notice"><?php LO('modules__userPrivacyNotice__showNumTip', F('escape', $userinfo['screen_name']));?></p>
                        <!-- 用户未登录显示 结束-->
    
                        <?php if (isset($userinfo['is_localsite_user']) && $userinfo['is_localsite_user'] == 0):?>
                        <!-- 对方未登录过此微博显示 开始-->
						<p class="copyright"><?php LO('modules__userPrivacyNotice__copyright', F('escape', $userinfo['screen_name']), F('escape', V('-:sysConfig/site_name')));?></p>
                        <!-- 对方未登录过此微博显示 结束-->
                        <?php endif;?>
                    </div>
                    <?php else:?>
                        <?php if (isset($userinfo['is_localsite_user']) && $userinfo['is_localsite_user'] == 0):?>
                        <div class="weibo-notice">
                            <!-- 对方未登录过此微博显示 开始-->
							<p class="copyright"><?php LO('modules__userPrivacyNotice__copyright', F('escape', $userinfo['screen_name']), F('escape', V('-:sysConfig/site_name')));?></p>
                            <!-- 对方未登录过此微博显示 结束-->
                        </div>
                        <?php endif;?>
                    <?php endif;?>
