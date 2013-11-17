<?php
/**************************************************
*  Created:  2010-06-08
*
*  语言文件
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

$_LANG = array();
/// controllers
/// action
$_LANG['controller__action__applyDomain__haveSet'] = '已设置个性域名，拒绝访问';
$_LANG['controller__action__applyDomain__formatError'] = '格式不正确';
$_LANG['controller__action__applyDomain__domainUsed'] = '域名已被使用';
$_LANG['controller__action__applyDomain__dbError'] = '数据库操作失败';

/// 添加话题
$_LANG['controller__action__addSubject__topicKeyNotEmpty'] = '话题关键字不能为空';
$_LANG['controller__action__addSubject__topicRepeat'] = '话题重复，未被添加';
$_LANG['controller__action__addSubject__dbError'] = '数据库操作失败';

/// 删除话题
$_LANG['controller__action__deleteSubject__topicKeyNotEmpty'] = '话题关键字不能为空';
$_LANG['controller__action__deleteSubject__notSubTopic'] = '不存在该话题订阅的历史记录';
$_LANG['controller__action__deleteSubject__dbError'] = '数据库操作失败';

/// 检查话题是否已被收藏
$_LANG['controller__action__isSubjectFollowed__topicKeyNotEmpty'] = '话题关键字不能为空';
$_LANG['controller__action__isSubjectFollowed__topicNotFavs'] = '该话题未被收藏';
$_LANG['controller__action__isSubjectFollowed__topicHavedFavs'] = '该话题已经被收藏';
$_LANG['controller__action__isSubjectFollowed__dbError'] = '数据库操作失败';

/// 获取某人所有订阅的
$_LANG['controller__action__getAllSubject__dbError'] = '数据库操作失败';
$_LANG['controller__action__getAllSubject__userId'] = '用户uid无效';

/// 活动
$_LANG['controller__event__shareEvent'] = '我发起了一个活动，大家都来关注一下：';

/// feedback
$_LANG['controller__feedBack__save__disabled'] = '管理员已禁用意见反馈组件';

/// 在线访谈
$_LANG['controller__interview__paramsNotExist'] = '访谈不存在或参数不正确';

/// 在线直播
$_LANG['controller__live__topic'] = '一起来聊聊：%s';

/// 内容输出
$_LANG['controller__outPut__weiboShow'] = '微博秀';
$_LANG['controller__outPut__recFollower'] = '推荐关注用户';
$_LANG['controller__outPut__followTopic'] = '关注话题';
$_LANG['controller__outPut__keyFollow'] = '一键关注';
$_LANG['controller__outPut__qunWeibo'] = '群组微博';

/// 设置
$_LANG['controller__setting__notLogin'] = '您尚未登录';
$_LANG['controller__setting__sizeLimit'] = '上传背景图片的大小不能超过2M，请重新选择';
$_LANG['controller__setting__uploadImgType'] = '上传的图片文件不为PNG/JPG格式，请重新选择';
$_LANG['controller__setting__copyImgError'] = '复制文件时出错,上传失败';
$_LANG['controller__setting__serverError'] = '服务器错误，请稍候重试';

/// share
$_LANG['controller__share__paramNotUrl'] = '参数不存在url';
$_LANG['controller__share__fromWho'] = '（分享自 @%s）';

/// 详细微博页面
$_LANG['controller__show__weiboDelOrShielding'] = '该微博已被删除或屏蔽';

///
$_LANG['controller__show__notAdmin'] = '不是管理员';
$_LANG['controller__show__missParameter'] = '缺少参数';
$_LANG['controller__show__apiError'] = '接口出错';
$_LANG['controller__show__shieldWeibo'] = '屏蔽微博失败,可能该微博已经在屏蔽列表';
$_LANG['controller__show__weiboIdNotAllowEmpty'] = '微博ID不能为空';
$_LANG['controller__show__reportContentEmpty'] = '举报内容不能为空';

/// ta
$_LANG['controller__ta__haveBlocked'] = '对不起，该用户已经被屏蔽了';

/// controller 公共使用的
$_LANG['controller__common__pageNotExist'] = '抱歉你所访问的页面不存在';
$_LANG['controller__common__liveNotExist'] = '抱歉你所访问的直播不存在';
$_LANG['controller__common__interviewNotExist'] = '抱歉你所访问的节目不存在';
$_LANG['controller__common__userNotExist'] = '抱歉你所访问的用户不存在';
$_LANG['controller__common__dataNotExist'] = '抱歉你所访问的数据不存在';
$_LANG['controller__common__eventNotExist'] = '抱歉你所访问的活动不存在';

/// 函数
$_LANG['function__error__serverBusy'] = '服务器忙，请<a href="javascript:window.location.reload()">刷新</a>重试';
$_LANG['function__common__pageNotExist'] = '抱歉你所访问的页面不存在';

$_LANG['function__formatTime__secAgo'] = '%d秒前';
$_LANG['function__formatTime__minAgo'] = '%d分钟前';
$_LANG['function__formatTime__todayTime'] = '今天 %s';
$_LANG['function__formatTime__monDay'] = '%s月%s日 %s';
$_LANG['function__formatTime__yearMonDay'] = '%s年%s月%s日 %s';
$_LANG['function__formatTime__showTimeSun'] = '周日';
$_LANG['function__formatTime__showTimeMon'] = '周一';
$_LANG['function__formatTime__showTimeTues'] = '周二';
$_LANG['function__formatTime__showTimeWed'] = '周三';
$_LANG['function__formatTime__showTimeThur'] = '周四';
$_LANG['function__formatTime__showTimeFri'] = '周五';
$_LANG['function__formatTime__showTimeSatur'] = '周五';
$_LANG['function__formatTime__showTimeFormat'] = '%s年%s月%s日 %s %s';

$_LANG['function__mblogHtml__weibo'] = '我</a>：%s</p>';
$_LANG['function__mblogHtml__orRepost'] = '原文转发';
$_LANG['function__mblogHtml__orComment'] = '原文评论';
$_LANG['function__mblogHtml__delete'] = '删除';
$_LANG['function__mblogHtml__repost'] = '转发';
$_LANG['function__mblogHtml__favs'] = '收藏';
$_LANG['function__mblogHtml__comment'] = '评论';
$_LANG['function__mblogHtml__source'] = '来自 %s';

$_LANG['function__shareWeibo__shareEventWeibo'] = '我发现了一个很棒的活动“%s”　地点：%s　时间：%s年%s月%s日　活动链接：%s'; 
$_LANG['function__shareWeibo__shareEventAttend'] = '我刚刚参加了一个很棒的活动“%s”　地点：%s　时间：%s年%s月%s日　活动链接：%s'; 
$_LANG['function__shareWeibo__shareLiveWeibo'] = '给大家推荐一个不错的直播，来看看吧：“%s”，直播时间%s-%s，特邀嘉宾%s，直播地址：%s';
$_LANG['function__shareWeibo__shareLiveTip'] = '提醒：“<a href="%s">%s</a>“将在%s分钟后开始，请您关注';
$_LANG['function__shareWeibo__shareInterviewWeibo'] = '给大家推荐一个不错的访谈，来看看吧：“%s”，访谈时间%s-%s，访谈嘉宾%s ，访谈地址：%s';
$_LANG['function__shareWeibo__shareInterviewTip'] = '提醒：在线访谈 “<a href="%s">%s</a>“ 将在(%s)分后开始，请您关注';

$_LANG['function__showAd__close'] = '关闭';

$_LANG['function__userFilter__missParams'] = '被检查的数据缺少必要的数据项';

$_LANG['function__verified__sinaVerify'] = '新浪认证';
$_LANG['function__verified__sinaVerifyTip1'] = '<img src="%s" alt="新浪认证" title="新浪认证" />';
$_LANG['function__verified__sinaVerifyTip2'] = '<div class="vip-card"><img src="%s" alt="新浪认证" title="新浪认证" /></div>';
$_LANG['function__verified__verifyTitle'] = '认证';

$_LANG['core__dsMgr__class_authorizationFail'] = '获取授权信息失败';
/// 页面标题
$_LANG['pageTitle__comDemo__title'] = '%s的Baby is %s';
$_LANG['pageTitle__pub__title'] = '微博广场';
$_LANG['pageTitle__pubLook__title'] = '随便看看';
$_LANG['pageTitle__pubTopic__title'] = '话题排行榜';
$_LANG['pageTitle__pubHotForward__title'] = '热门转发';
$_LANG['pageTitle__pubHotComments__title'] = '热门评论';
$_LANG['pageTitle__searchRecommend__title'] = '可能感兴趣的人';
$_LANG['pageTitle__search__title'] = '综合搜索';
$_LANG['pageTitle__searchUser__title'] = '用户搜索';
$_LANG['pageTitle__searchWeibo__title'] = '微博搜索';
$_LANG['pageTitle__index__title'] = '我的首页';
$_LANG['pageTitle__accountLogin__title'] = '登录方式选择';
$_LANG['pageTitle__accountBind__title'] = '绑定授权- 新浪微博';
$_LANG['pageTitle__accountIsBinded__title'] = '重新绑定授权';
$_LANG['pageTitle__indexAtme__title'] = '提到我的';
$_LANG['pageTitle__indexComments__title'] = '我的评论';
$_LANG['pageTitle__indexCommentsend__title'] = '我的评论';
$_LANG['pageTitle__indexMessages__title'] = '我的私信';
$_LANG['pageTitle__indexNotices__title'] = '我的通知';
$_LANG['pageTitle__indexFavorites__title'] = '我的收藏';
$_LANG['pageTitle__indexProfile__title'] = '我的微博';
$_LANG['pageTitle__indexFans__title'] = '我的粉丝';
$_LANG['pageTitle__indexFollow__title'] = '我的关注';
$_LANG['pageTitle__indexSetinfo__title'] = '设置';
$_LANG['pageTitle__indexInfo__title'] = '详细信息';
$_LANG['pageTitle__ta__title'] = '%s的微博';
$_LANG['pageTitle__taProfile__title'] = '%s的微博';
$_LANG['pageTitle__taFans__title'] = '关注%s的人';
$_LANG['pageTitle__taFollow__title'] = '%s关注的人';
$_LANG['pageTitle__taMention__title'] = '提到%s的微博';
$_LANG['pageTitle__setting__title'] = '个人资料设置';
$_LANG['pageTitle__settingUser__title'] = '个人资料设置';
$_LANG['pageTitle__settingTag__title'] = '个人标签设置';
$_LANG['pageTitle__settingMyface__title'] = '头像设置';
$_LANG['pageTitle__settingShow__title'] = '显示设置';
$_LANG['pageTitle__settingBlacklist__title'] = '黑名单';
$_LANG['pageTitle__settingNotice__title'] = '提醒设置';
$_LANG['pageTitle__settingAccount__title'] = '帐号设置';
$_LANG['pageTitle__settingDomain__title'] = '个性域名';
$_LANG['pageTitle__show__title'] = '%s的微博';
$_LANG['pageTitle__showRepos__title'] = '%s的微博';
$_LANG['pageTitle__event__title'] = '活动';
$_LANG['pageTitle__eventMine__title'] = '我的活动';
$_LANG['pageTitle__eventDetails__title'] = '%s';
$_LANG['pageTitle__eventMember__title'] = '%s';
$_LANG['pageTitle__eventCreate__title'] = '发起活动';
$_LANG['pageTitle__eventModify__title'] = '编辑活动';
$_LANG['pageTitle__live__title'] = '在线直播';
$_LANG['pageTitle__liveDetails__title'] = '%s';
$_LANG['pageTitle__liveLivelist__title'] = '在线直播列表';
$_LANG['pageTitle__interview__title'] = '在线访谈';
$_LANG['pageTitle__interviewPage__title'] = '在线访谈列表';
$_LANG['pageTitle__wbcomViewPhoto__title'] = '查看图片';
$_LANG['pageTitle__wbcomReplyComment__title'] = '回复微博';
$_LANG['pageTitle__wbcomSendWBFrm__title'] = '发微博';
$_LANG['pageTitle__wbcomSendMsgFrm__title'] = '发私信';
$_LANG['pageTitle__accountShowLogin__title'] = '登录微博';

/// 首页 - 我的首页
$_LANG['index__default__emptyWeiboTip'] = '您还没有微博信息。';
$_LANG['index__default__endPageTip'] = '已到最后一页';
$_LANG['index__default__showMoreWeiboTip'] = '想看更多微博？<br />你可以<a href="%s">关注更多的人</a>，或者在<a href="%s">上方输入框</a>里，说说身边的新鲜事儿。';
$_LANG['index__default__notFoundTip'] = '找不到符合条件的微博，返回查看<a href="%s">全部微博</a>';
$_LANG['index__default__listTitle'] = '我的首页';
$_LANG['index__default__skinSetTitle'] = '模板设置';
$_LANG['index__default__closeTips'] = '点击关闭';
$_LANG['index__default__componmentHome'] = '我的首页';

/// 首页 - 提到我的
$_LANG['index__atme__notFoundTip'] = '找不到符合条件的微博，返回查看<a href="%s">全部微博</a>';
$_LANG['index__atme__listTitle'] = '提到我的';
$_LANG['index__atme__emptyWeiboTip'] = '目前，还没有人提到你呢，敬请期待。';

/// 首页 - 评论
$_LANG['index__comment__mycomments'] = '我的评论';
$_LANG['index__comment__comments'] = '收到的评论';
$_LANG['index__comment__commentsend'] = '发出的评论';

/// 首页 - 我的粉丝
$_LANG['index__fans__myFans'] = '我的粉丝';

/// 首页 - 我的关注
$_LANG['index__follow__myFollow'] = '我的关注';

/// 首页 - 我的收藏
$_LANG['index__favs__notFoundTip'] = '还没有收藏任何微博';
$_LANG['index__favs__emptyFavsTip'] = '还没有收藏任何微博';
$_LANG['index__favs__listTitle'] = '我的收藏';

/// 首页 - 我的私信
$_LANG['index__message__listTitle'] = '我的私信';
$_LANG['index__message__listTip'] = '温馨提示：私信的接收方必须是发送方的粉丝';
$_LANG['index__message__sendMessage'] = '发私信';

/// 首页 - 我的通知
$_LANG['index__notice__myNotice'] = '我的通知';
$_LANG['index__notice__listTitle'] = '我收到的通知';
$_LANG['index__notice__emptyNoticeTip'] = '还没有收到任何通知';

/// ta - 粉丝
$_LANG['ta__fans__taFans'] = '的粉丝';

/// ta - 关注
$_LANG['ta__follow__taFollow'] = '的关注';

/// 活动
$_LANG['events__defaultAction__event'] = '活动';
$_LANG['events__defaultAction__hotRec'] = '热门推荐';
$_LANG['events__defaultAction__myEvent'] = '我的活动';
$_LANG['events__myEvent__eventTitle'] = '活动';
$_LANG['events__myEvent__hotRec'] = '热门推荐';
$_LANG['events__myEvent__myEvent'] = '我的活动';
$_LANG['events__myEvent__myAttend'] = '我参加的';
$_LANG['events__myEvent__myCreate'] = '我发起的';
$_LANG['events__eventList__allNewsEvent'] = '全部活动';
$_LANG['events__common__back'] = '返回';
$_LANG['events__common__create'] = '发起活动';

/// 登录
$_LANG['login__account__chooseLoginWay'] = '您还没有登录，请选择登录方式：';
$_LANG['login__account__loginTip'] = '登录';
$_LANG['login__account__regTip'] = '注册帐号';
$_LANG['login__account__weiboAccount'] = '新浪微博帐号';
$_LANG['login__account__otherAccount'] = '%s或新浪微博帐号';
$_LANG['login__account__weiboAccountLogin'] = '新浪微博帐号登录';
$_LANG['login__account__regWeiboTip'] = '开通微博';
$_LANG['login__account__chooseAccountLogin'] = '提示：您可以使用%s登录本网站';
$_LANG['login__account__feedback'] = '反馈';
$_LANG['login__account__help'] = '帮助';
$_LANG['login__account__goRegWeibo'] = '立即注册微博';
$_LANG['login__account__whyToRegWeibo'] = '上亿的用户在使用，你还在犹豫什么';
$_LANG['login__account__goLogin'] = '立即登录';
$_LANG['login__account__theyAreHere'] = '他们在微博';
$_LANG['login__account__theyAreSay'] = '他们在说';
$_LANG['login__account__popularRec'] = '人气推荐';

/// 随便看看
$_LANG['lookLook__pub__change'] = '换一批';
$_LANG['lookLook__pug__casualLookTitle'] = '随便看看';
$_LANG['lookLook__pug__casualLook'] = '随便看看';
$_LANG['lookLook__pug__errorMsg'] = '“随便看看”模块遇到问题：%s （错误代码： %s ）';

/// 详细微博页
$_LANG['mblogDetail__show__myTitle'] = '我';
$_LANG['mblogDetail__show__aWeibo'] = '的微博';

/// pub
$_LANG['pubTopic__pub__localTopicTop'] = '本站话题排行榜';
$_LANG['pubTopic__pub__weiboTopicTop'] = '新浪微博话题排行榜';
$_LANG['pubTopic__pub__oneHourTopicTop'] = '1小时话题榜';
$_LANG['pubTopic__pub__todayTopicTop'] = '今日话题榜';
$_LANG['pubTopic__pub__weekTopicTop'] = '本周话题榜';

/// 设置
$_LANG['setting__setting__baseInfo'] = '基本资料';
$_LANG['setting__setting__perTags'] = '个人标签';
$_LANG['setting__setting__noticeTip'] = '以下信息将显示在您的<a href="%s">微博页</a>，方便大家了解你。';
$_LANG['setting__setting__errorTips'] = '无法获取用户信息';

/// 名人堂
$_LANG['celeb__starChildSortList__other'] = '其他';
$_LANG['celeb__starChildSortList__fameTitle'] = '%s - 名人堂';
$_LANG['celeb__starChildSortList__fame'] = '名人堂';
$_LANG['celeb__starChildSortList__categoryEmptyTip'] = '此分类暂无数据';
$_LANG['celeb__starChildSortList__letterSearch'] = '按字母检索';

///  在线访谈
$_LANG['interview__page__titleTip'] = '精彩访谈';
$_LANG['interview__page__remindMeTip'] = '在线访谈 "%s" 即将开始';
$_LANG['interview__page__remindMe'] = '提醒我';
$_LANG['interview__page__notStarted'] = '<span class="unplayed">(未开始)</span>';
$_LANG['interview__page__end'] = '<span class="finish">(已结束)</span>';
$_LANG['interview__page__going'] = '<span class="active">(进行中)</span>';
$_LANG['interview__page__adminEmptyTip'] = '还没有在线访谈，你可以在 后台管理中心-扩展工具-在线访谈 添加设置';
$_LANG['interview__page__emptyTip'] = '还没有在线访谈，你可以看看其他页面。 ';

/// 搜索
$_LANG['search__defaultAction__seeAll'] = '查看全部';
$_LANG['search__defaultAction__fromSina'] = '来自新浪';
$_LANG['search__defaultAction__local'] = '本站';
$_LANG['search__defaultAction__emptySearch'] = '找不到符合条件的微博，请输入其他关键字再试';

$_LANG['search__weibo__fromSina'] = '来自新浪';
$_LANG['search__weibo__local'] = '本站';
$_LANG['search__weibo__seeAll'] = '全部';
$_LANG['search__weibo__text'] = '文字';
$_LANG['search__weibo__pic'] = '图片';
$_LANG['search__weibo__video'] = '视频';
$_LANG['search__weibo__title'] = '找到的微博如下';
$_LANG['search__weibo__emptySearch'] = '找不到符合条件的微博，请输入其他关键字再试';

$_LANG['search__user__fromSina'] = '来自新浪';
$_LANG['search__user__local'] = '本站';
$_LANG['search__user__emptySearch'] = '找不到符合条件的用户，请输入其他关键字再试';

/// include
$_LANG['include__header__searchTip'] = '搜微博/找人';
$_LANG['include__header__set'] = '设置';
$_LANG['include__header__skin'] = '换肤';
$_LANG['include__header__feedback'] = '用户反馈';
$_LANG['include__header__centralAdmin'] = '<a class="manage" href="%s"  target="_blank">管理中心</a>|';
$_LANG['include__header__logout'] = '退出';
$_LANG['include__header__bindSinaWeibo'] = '绑定SINA微博';
$_LANG['include__header__login'] = '登录';
$_LANG['include__header__ideas'] = '有意见？有想法？那就来吧！';
$_LANG['include__header__anonymous'] = '匿名';
$_LANG['include__header__inputContent'] = '请输入意见内容';
$_LANG['include__header__contact'] = '联系方式：';
$_LANG['include__header__email'] = '邮箱地址';
$_LANG['include__header__inputContact'] = '请留下您的联系方式，方便我们及时反馈信息给您';
$_LANG['include__header__submit'] = '提交';
$_LANG['include__header__inputContent'] = '请输入意见内容';
$_LANG['include__header__close'] = '关闭';
$_LANG['include__header__contentLimit'] = '不能超过250个汉字';
$_LANG['include__header__phone'] = '联系电话';

/// site nav
$_LANG['include__siteNav__myWeibo'] = '我的微博';
$_LANG['include__siteNav__myMessage'] = '我的消息';
$_LANG['include__siteNav__myFavs'] = '我的收藏';
///////////////////////////////////////////////////////////////////////////////////
/// pls

$_LANG['pls__common__userSkin__defaultTitle'] = '默认';
/// 我 ta - 微博
$_LANG['pls__userTimeline__profile__emptyWeiboTip'] = '%s 还没有开始发微博，请等待。';
$_LANG['pls__userTimeline__profile__notFoundTip'] = '找不到符合条件的微博，返回查看<a href="%s">全部微博</a>';
$_LANG['pls__myUserTimeline__profile__listTitle'] = '我的微博';
$_LANG['pls__userTimeline__profile__listTitle'] = '%s的微博';

/// 活动 pls
$_LANG['pls__eventComment__emptyCommentTip'] = '暂时没有评论';

/// interview 在线访谈
$_LANG['pls__intervies__indexList__timeFormat'] = 'm月d日 H:i';

/// live 在线直播
$_LANG['pls__live__liveIndexList__day'] = '%s天';
$_LANG['pls__live__liveIndexList__hour'] = '%s小时';
$_LANG['pls__live__liveIndexList__min'] = '%s分';
$_LANG['pls__live__liveIndexList__sec'] = '%s秒';
$_LANG['pls__live__liveWblist__endTip'] = '直播内容<span><label for="only"><input type="checkbox" name="gMtype" value="1" id="only">只看嘉宾和主持人</label></span><span class="close">(已结束)</span>';
$_LANG['pls__live__liveWblist__startTip'] = '直播内容<span><label for="only"><input type="checkbox" name="gMtype" value="1" id="only">只看嘉宾和主持人</label></span><span>(共有<span id="liveWbNum">%s</span>条)</span>';
$_LANG['pls__live__liveWblist__emptyLiveTip'] = '暂时没有相关的话题微博';

/// 粉丝
$_LANG['pls__users__fansList__women'] = '她';
$_LANG['pls__users__fansList__men'] = '他';
$_LANG['pls__users__fansList__myEmptyNoticeTip'] = '真悲剧，还没有人关注你，你可以试试多<a href="%s">关注别人</a>。';
$_LANG['pls__users__fansList__taEmptyNoticeTip'] = '还没人关注%s，你可怜一下%s吧，关注一下';
$_LANG['pls__users__followersList__myEmptyNoticeTip'] = '你还没有关注任何人';
$_LANG['pls__users__followersList__taEmptyNoticeTip'] = '%s还没有关注任何人';

/// 推荐
$_LANG['pls__users__recommendUserWeight__title'] = '推荐关注以下用户';

/// 感兴趣
$_LANG['pls__users__interestUsers__title'] = '你可能感兴趣的人';

/// 组件 component
/// 用户组模块
$_LANG['pls__component11__categoryUser__getGroupsError'] = 'components/categoryUser.getGroups 从数据库中获取失败或者无数据';
$_LANG['pls__component11__categoryUser__getError'] = 'components/categoryUser.get返回错误的非数组类型数据。错误信息：%s(Errno: %s)';

/// 话题模块
$_LANG['pls__component12__todayTopic__apiError'] = 'components/todayTopic.getTopicWB 返回API错误：%s(%s)';
$_LANG['pls__component12__todayTopic__dbError'] = 'components/todayTopic.getTopicWB 返回错误的非数组数据类型或者返回数据为空';

/// banner模块
$_LANG['pls__component13__banner__emptyTip'] = '无图片';

/// 最新微博模块
$_LANG['pls__component14__pubTimeline__apiError'] = 'components/pubTimelineBaseApp.get返回API错误：%s(%s)';

/// 最新开通微博的用户列表
$_LANG['pls__component15__newestWbUser__emptyTip'] = '无本站最新开通微博的数据，或者缓存返回错误的非数组数据类型。';

/// 明星推荐列表
$_LANG['pls__component2__star__apiError'] = 'components/star.get 返回API错误：%s(%s)';
$_LANG['pls__component2__star__dbError'] = 'components/star.get 无数据。';
$_LANG['pls__component2__star__Error'] = 'components/star.get 返回错误的非数组类型数据。';

/// 用户推荐模块
$_LANG['pls__component3__recommentUser__getError'] = 'components/recommendUser.get 返回错误的非数组类型数据。';

/// 人气关注榜模块
$_LANG['pls__component4__concern__getError'] = 'components/concern.get 从数据库获取错误：数据为空或者返回错误的非数组数据。';

/// 微博频道模块
$_LANG['pls__component5__listIdEmptyTip'] = 'ListId为空';
$_LANG['pls__component5__list__apiError'] = 'API返回不存在用户列表。';
$_LANG['pls__component5__getUsers__error'] = '获取components/officialWB.getUsers失败或为空，故不再获取微博列表。components/officialWB.getUsers错误信息：%s';

/// 热门话题列表模块
$_LANG['pls__component6__hotTopic__error'] = 'components/hotTopic.get 返回错误的非数组类型数据。';

/// 可能感兴趣的人
$_LANG['pls__component7__guessYouLike__apiError'] = 'components/guessYouLike.get 返回API错误：%s(%s)';
$_LANG['pls__component7__guessYouLike__dbError'] = 'components/guessYouLike.get返回列表为空。';
$_LANG['pls__component7__guessYouLike__Error'] = 'components/guessYouLike.get 返回错误的非数组类型数据！';

/// 同城微博模块
$_LANG['pls__component8__getProvinces__apiError'] = 'xweibo/xwb.getProvinces 返回API错误：%s(%s)';
$_LANG['pls__component8__cityWB__apiError'] = 'components/cityWB.get 返回API错误：%s(%s)';

/// 随便看看模块
$_LANG['pls__component9__pubTimeline__apiError'] = 'components/pubTimeline.get 错误：%s(%s)';
$_LANG['pls__component9__pubTimeline__dbError'] = 'components/pubTimeline.get返回错误的非数组类型数据！';
$_LANG['pls__component9__pubTimeline__error'] = 'components/pubTimeline.get没有数据';

///当前站点最新微博模块
$_LANG['pls__component14__login__emptyTip'] = '还没有人发言哦，赶紧去说点什么吧';

/// 模块pipe基础
$_LANG['pls__component__abstract__errorMsg'] = '未填写问题原因';
$_LANG['pls__component__abstract__emptyTitle'] = '未知模块';
$_LANG['pls__component__abstract__apiError'] = '<div class="int-box ico-load-fail">%s（模块ID：%s）遇到问题：%s</div>';

/// 各类模块通用pipe
$_LANG['pls__component__common__hotWB_emptyTip'] = '还没有热门微博。';
$_LANG['pls__component__common__hotWB_apiError'] = 'components/hotWB.getComment 返回API错误：%s(%s)';
$_LANG['pls__component__common__hotWB_dbError'] = '获取热门微博信息失败，请<a href="#" rel="e:rl">刷新</a>再试!';
///////////////////////////////////////////////////////////////////////////////////

/// modules template

$_LANG['modules__ajaxUsers__profileImage'] = '%s的头像';

/// 黑名单
$_LANG['modules__blockUserList__pageTip'] = '已到最后一页';

/// 绑定
$_LANG['modules__bindAccount__bindWeiboTitle'] = '帐号绑定';
$_LANG['modules__bindAccount__bindWeibo'] = '登录成功，继续操作需绑定新浪微博帐号';
$_LANG['modules__bindAccount__whyBind'] = '为什么要进行帐号绑定？';
$_LANG['modules__bindAccount__noticeUseful'] = '%s基于新浪微博开发，您需要绑定一个新浪微博帐号，方可使用全部功能。';
$_LANG['modules__bindAccount__needBind'] = '每次登录都需要绑定吗？';
$_LANG['modules__bindAccount__onlyOne'] = '不需要，您只需要绑定一次，之后就可以直接进入%s了！';
$_LANG['modules__bindAccount__noWeibo'] = '没有新浪微博帐号怎么办？';
$_LANG['modules__bindAccount__clickToRegWeibo'] = '点击这里注册，只需1分钟！';
$_LANG['modules__bindAccount__regWeibo'] = '注册新浪微博帐号';

/// 评论
$_LANG['modules__comment__pageTip'] = '已到最后一页';
$_LANG['modules__comment__myComment'] = '暂时还没有收到任何评论';
$_LANG['modules__comment__CommentSend'] = '暂时还没有发出任何评论';
$_LANG['modules__comment__selectAll'] = '全选';
$_LANG['modules__comment__delete'] = '删除';
$_LANG['modules__comment__reply'] = '回复';
$_LANG['modules__comment__replyWeibo'] = '回复微博：';

/// 发起活动
$_LANG['modules__evnetForm__title'] = '活动标题：';
$_LANG['modules__evnetForm__titleMsg'] = '请填写活动标题';
$_LANG['modules__evnetForm__titleLengthMsg'] = '不能超过20个汉字';
$_LANG['modules__evnetForm__phone'] = '联系方式：';
$_LANG['modules__evnetForm__phoneMsg'] = '请填写联系电话';
$_LANG['modules__eventForm__realname'] = '联系人：';
$_LANG['modules__eventForm__realnameMsg'] = '请填写真实姓名';
$_LANG['modules__evnetForm__addr'] = '活动地点：';
$_LANG['modules__evnetForm__addrMsg'] = '请填写活动地点';
$_LANG['modules__evnetForm__addrTooLongMsg'] = '不能超过30个汉字';
$_LANG['modules__evnetForm__startTime'] = '开始时间：';
$_LANG['modules__eventForm__startTimeMsg'] = '请填写开始时间';
$_LANG['modules__eventForm__endTime'] = '结束时间：';
$_LANG['modules__eventForm__endTimeMsg'] = '请填写结束时间';
$_LANG['modules__eventForm__cost'] = '人均费用：';
$_LANG['modules__eventForm__freeCost'] = '免费';
$_LANG['modules__eventForm__cost__units'] = '元';
$_LANG['modules__eventForm__costMsg'] = '请填写人均费用';
$_LANG['modules__eventForm__other'] = '其他要求：';
$_LANG['modules__eventForm__otherTip'] = '要求参与者填写联系方式和简单说明';
$_LANG['modules__eventForm__desc'] = '活动介绍：';
$_LANG['modules__eventForm__descMsg'] = '请填写活动介绍';
$_LANG['modules__eventForm__descLengthMsg'] = '最多2000字';
$_LANG['modules__eventForm__pic'] = '封面：';
$_LANG['modules__eventForm__uploading'] = '上传中...';
$_LANG['modules__eventForm__picReq'] = '请上传小于1M的JPG、PNG、GIF格式图片，尺寸为120*120PX';
$_LANG['modules__eventForm__submit'] = '确认';

/// 评论活动
$_LANG['modules__eventComment__topic'] = '关于<a href="%s">%s</a>的讨论';
$_LANG['modules__eventComment__publish'] = '发布';
$_LANG['modules__eventComment__length'] = '还可以输入140个字';

/// 活动详细页面
$_LANG['modules__eventInfo__eventPic'] = '活动封面';
$_LANG['modules__eventInfo__eventTime'] = '时　　间：';
$_LANG['modules__eventInfo__eventAddr'] = '地　　点：';
$_LANG['modules__eventInfo__eventName'] = '发<i></i>起<i></i>者：';
$_LANG['modules__eventInfo__eventPhone'] = '联系方式：';
$_LANG['modules__eventInfo__eventState'] = '状　　态：';
$_LANG['modules__eventInfo__eventStateClose'] = '关闭';
$_LANG['modules__eventInfo__eventStateBan'] = '封禁';
$_LANG['modules__eventInfo__eventStateComplete'] = '已完成';
$_LANG['modules__eventInfo__eventStateRec'] = '推荐';
$_LANG['modules__eventInfo__eventStateGoing'] = '正常进行中';
$_LANG['modules__eventInfo__eventStateNotStart'] = '活动报名中';
$_LANG['modules__eventInfo__eventJoinNum'] = '参加人数：';
$_LANG['modules__eventInfo__eventShare'] = '分享到我的微博';
$_LANG['modules__eventInfo__eventJoined'] = '已参加';
$_LANG['modules__eventInfo__eventToJoin'] = '我要参加';
$_LANG['modules__eventInfo__eventDesc'] = '活动简介:';
$_LANG['modules__eventInfo__eventJoinMemberNum'] = '这个活动的参加者：<span>共<a href="%s">%s</a>人</span>';
$_LANG['modules__eventInfo__eventMemberFollowed'] = '已关注';
$_LANG['modules__eventInfo__eventMemberToFollow'] = '加关注';

/// 活动列表页面
$_LANG['modules__eventList__eventPic'] = '活动封面';
$_LANG['modules__eventList__eventTime'] = '时　　间：';
$_LANG['modules__eventList__eventAddr'] = '地　　点：';
$_LANG['modules__eventList__eventName'] = '发<i></i>起<i></i>者：';
$_LANG['modules__eventList__eventPhone'] = '联系方式：';
$_LANG['modules__eventList__eventState'] = '状　　态：';
$_LANG['modules__eventList__eventStateClose'] = '关闭';
$_LANG['modules__eventList__eventStateBan'] = '封禁';
$_LANG['modules__eventList__eventStateComplete'] = '已完成';
$_LANG['modules__eventList__eventStateRec'] = '推荐';
$_LANG['modules__eventList__eventStateGoing'] = '正常进行中';
$_LANG['modules__eventList__eventJoinNum'] = '参加人数：';
$_LANG['modules__eventList__eventShare'] = '分享到我的微博';
$_LANG['modules__eventList__eventJoined'] = '已参加';
$_LANG['modules__eventList__eventToJoin'] = '我要参加';
$_LANG['modules__eventList__eventClose'] = '关闭';
$_LANG['modules__eventList__eventEdit'] = '编辑';
$_LANG['modules__eventList__eventDelete'] = '删除';
$_LANG['modules__eventList__eventDesc'] = '活动简介:';
$_LANG['modules__eventList__eventJoinMemberNum'] = '这个活动的参加者：<span>共<a href="%s">%s</a>人</span>';
$_LANG['modules__eventList__eventMemberFollowed'] = '已关注';
$_LANG['modules__eventList__eventMemberToFollow'] = '加关注';
$_LANG['modules__eventList__myEventEmptyTip'] = '我没有发起过活动';
$_LANG['modules__eventList__myAttendEventEmptyTip'] = '我没有参加过活动';
$_LANG['modules__eventList__eventEmptyTip'] = '暂时没有任何活动';

/// 活动成员列表
$_LANG['modules__eventMembers__eventJoinMemberNum'] = '这个活动参与者<span>(共%s人)</span>';
$_LANG['modules__eventMembers__eventMemberFollowed'] = '已关注';
$_LANG['modules__eventMembers__eventMemberToFollow'] = '加关注';
$_LANG['modules__eventMembers__eventPhone'] = '联系方式：';
$_LANG['modules__eventMembers__eventNotes'] = '备注：';

/// feed
$_LANG['modules__feed__master'] = '主持人';
$_LANG['modules__feed__guest'] = '嘉宾';
$_LANG['modules__feed__repost'] = '转发';
$_LANG['modules__feed__comment'] = '评论';
$_LANG['modules__feed__retError1'] = '内容有错！';
$_LANG['modules__feed__retError2'] = '该用户已经被屏蔽';
$_LANG['modules__feed__retError3'] = '原微博已被屏蔽';
$_LANG['modules__feed__retRepost'] = '原文转发';
$_LANG['modules__feed__retComment'] = '原文评论';
$_LANG['modules__feed__delete'] = '删除';
$_LANG['modules__feed__fav'] = '收藏';
$_LANG['modules__feed__unfav'] = '取消收藏';
$_LANG['modules__feed__source'] = '来自 %s';
$_LANG['modules__feed__informationIsNotAudited'] = '信息未审核';
$_LANG['modules__feed__report'] = '举报';
$_LANG['modules__feed__blocked'] = '已屏蔽';
$_LANG['modules__feed__blockWeibo'] = '屏蔽该微博';

/// feedlist 模块
$_LANG['modules__feedList__emptyTip'] = '该模块下没有微博，<a href="#" rel="e:rl">刷新</a>试试？';

/// inhibit
$_LANG['modules__inhibit__loginError'] = '登录失败!';
$_LANG['modules__inhibit__reason'] = '原因：您已经被禁止访问此网站';

/// input
$_LANG['modules__input__inputTitle'] = '有什么新鲜事告诉大家？';
$_LANG['modules__input__inputLength'] = '您还可以输入<span>140</span>字';
$_LANG['modules__input__inputFace'] = '表情';
$_LANG['modules__input__inputUploading'] = '正在上传..';
$_LANG['modules__input__inputImage'] = '图片';
$_LANG['modules__input__inputVideo'] = '视频';
$_LANG['modules__input__inputMusic'] = '音乐';
$_LANG['modules__input__inputTopic'] = '话题';
$_LANG['modules__input__inputSuccess'] = '发布成功！';
$_LANG['modules__input__inputVerify'] = '信息已进入审核中';
$_LANG['modules__input__inputReqLogin'] = '您需要绑定新浪微博帐号后才可以发布，';
$_LANG['modules__input__inputGoBind'] = '现在就去绑定';

/// isbind
$_LANG['modules__isBind__agreement'] = '新浪网络服务使用协议';
$_LANG['modules__isBind__sinaWeibo'] = '新浪微博';
$_LANG['modules__isBind__changAccount'] = '您的<em>%s</em>新浪微博帐号已绑定过了，换个帐号试试吧';
$_LANG['modules__isBind__autoJumpTip'] = '[<span  id="time_sec">5</span>]秒后自动跳转，如果浏览器没有反应，请<a href="%s">点击这里</a>';


/// login
$_LANG['modules__login__loginWay'] = '您还没有登录，请选择登录方式：';
$_LANG['modules__login__whoLogin'] = '%s登录';
$_LANG['modules__login__regWeibo'] = '注册帐号';
$_LANG['modules__login__weiboAccount'] = '新浪微博帐号';
$_LANG['modules__login__orWeiboAccount'] = '%s或新浪微博帐号';
$_LANG['modules__login__weiboAccountLogin'] = '新浪微博帐号登录';
$_LANG['modules__login__goSinaReg'] = '开通微博';
$_LANG['modeles__login__chooseLoginWayTip'] = '提示：您可以使用%s登录本网站';


/// 详细微博页
$_LANG['modules__mblog__pubComment'] = '发表评论';
$_LANG['modules__mblog__comment'] = '评论';
$_LANG['modules__mblog__inputLength'] = '您还可以输入<span>70</span>字';
$_LANG['modules__mblog__atTheSameTimePubWeibo'] = '同时发一条微博';
$_LANG['modules__mblog__indexPage'] = '首页';
$_LANG['modules__mblog__prePage'] = '上一页';
$_LANG['modules__mblog__nextPage'] = '下一页';

/// 推荐
$_LANG['modules__recommendGuide__hotRecTitle'] = '热门推荐：';
$_LANG['modules__recommendGuide__hotRec'] = '热门推荐';
$_LANG['modules__recommendGuide__chooseUsersNum'] = '已选择了<span>0</span>个用户';
$_LANG['modules__recommendGuide__ship'] = '跳过';

/// 推荐用户
$_LANG['modules__recommendUserWeight__categoryUser'] = '分类用户推荐'; 

/// 搜索用户
$_LANG['modules__searchUser__emptyTip'] = '找不到符合条件的用户，请输入其他关键字再试';
$_LANG['modules__searchUser__followed'] = '已关注';
$_LANG['modules__searchUser__addFollow'] = '添加关注';
$_LANG['modules__searchUser__fansNum'] = '粉丝数：%s人';
$_LANG['modules__searchUser__desc'] = '简介：';
$_LANG['modules__searchUser__tags'] = '标签：';
$_LANG['modules__searchUser__lookUserTags'] = '查看该用户的所有标签';

/// 热门活动
$_LANG['modules__sideHotEvents__moreTip'] = '更多';
$_LANG['modules__sideHotEvents__hotEvent'] = '热门活动';

/// 最新活动
$_LANG['modules__sideNewsEvents__moreTip'] = '更多';
$_LANG['modules__sideNewsEvents__newsEvent'] = '最新活动';

$_LANG['modules__sideEvents__time'] = '时间：';

/// 侧栏粉丝
$_LANG['modules__sidebarFans__whofansNum'] = '%s粉丝（%s）';
$_LANG['modules__sidebarFans__moreTip'] = '更多';

/// 私信
$_LANG['modules__message__endPage'] = '已到最后一页';
$_LANG['modules__message__emptyTip'] = '还没有收到或发出任何私信';
$_LANG['modules__message__meSendto'] = '<a href="%s"> 我</a>发送给';
$_LANG['modules__message__reply'] = '回复';
$_LANG['modules__message__delete'] = '删除';

/// 推荐用户公用模板之：人物排列
$_LANG['modules__modFameList__profileImageUrl'] = '%s的头像';
$_LANG['modules__modFameList__emptyTip'] = '暂无数据';

/// mod find
$_LANG['modules__modFind__findPeople'] = '找人';
$_LANG['modules__modFind__source'] = '本站及新浪微博';
$_LANG['modules__modFind__onlyLocal'] = '仅本站';
$_LANG['modules__modFind__inputSearch'] = '请输入搜索条件！';

/// mod search
$_LANG['modules__modSearch__general'] = '综合';
$_LANG['modules__modSearch__weibo'] = '微博';
$_LANG['modules__modSearch__user'] = '用户';
$_LANG['modules__modSearch__search'] = '搜索';
$_LANG['modules__modSearch__nickname'] = '昵称';
$_LANG['modules__modSearch__desc'] = '简介';
$_LANG['modules__modSearch__tags'] = '标签';
$_LANG['modules__modSearch__pubWeibo'] = '发微博';
$_LANG['modules__modSearch__attendTopic'] = '参与该话题';
$_LANG['modules__modSearch__followTopic'] = '关注该话题';
$_LANG['modules__modSearch__followed'] = '已关注';
$_LANG['modules__modSearch__cancelFollowed'] = '取消关注';

/// mode search user
$_LANG['modules__modSearchUserPre__seeAll'] = '查看全部';
$_LANG['modules__modSearchUserPre__sourceSina'] = '来自新浪';
$_LANG['modules__modSearchUserPre__local'] = '本站';
$_LANG['modules__modSearchUserPre__profileImageUrl'] = '%s的头像';
$_LANG['modules__modSearchUserPre__emptyTip'] = '找不到符合条件的用户，请输入其他关键字再试';

/// notice
$_LANG['modules__notices__endPage'] = '已到最后一页';
$_LANG['modules__notices__emptyTip'] = '还没有收到任何通知';
$_LANG['modules__notices__admin'] = '管理员';

/// page link title p
$_LANG['modules__pageLink__pos'] = '当前位置：';

/// subject followed
$_LANG['modules__subjectFollowed__followedTopic'] = '关注的话题';
$_LANG['modules__subjectFollowed__emptyFollowedTopic'] = '他没有关注任何话题';
$_LANG['modules__subjectFollowed__delete'] = '删除';
$_LANG['modules__subjectFollowed__add'] = '添加';

/// user account
$_LANG['modules__userAccount__cancelBindTip'] = '您已经将新浪微博帐号与本网站绑定使用，您可以在本页面取消此绑定关系。';
$_LANG['modules__userAccount__weiboSina'] = '微博帐号：';
$_LANG['modules__userAccount__cancelBind'] = '取消绑定';
$_LANG['modules__userAccount__aboutBind'] = '关于绑定：';
$_LANG['modules__userAccount__desc1'] = '将新浪微博帐号绑定网站之后，您可以在此网站上使用微博功能，并能与新浪微博共享数据。';
$_LANG['modules__userAccount__desc2'] = '取消绑定后，您将无法继续在本网站使用微博相关功能。';
$_LANG['modules__userAccount__desc3'] = '当前正在使用新浪微博，如需修改密码，请<a href="http://login.sina.com.cn/member/security/password.php" target="_blank">点击</a>此处。';

/// user blacklist
$_LANG['modules__userBlackList__desc'] = '被加入黑名单的用户将无法关注你、评论你。如果你已经关注他，也会自动解除关系。';
$_LANG['modules__userBlackList__emptyTip'] = '还没有人被你拉入黑名单呢。';
$_LANG['modules__userBlackList__howToBlackUser'] = '如何将某个用户加入自己的黑名单？';
$_LANG['modules__userBlackList__setBlackUser'] = '进入某个用户的微博，在 @他 旁边的“更多”下拉框中可以进行设置。';
$_LANG['modules__userBlackList__blacked'] = '已被您加入黑名单的用户：';
$_LANG['modules__userBlackList__cancelBlack'] = '解除';

/// user display edit
$_LANG['modules__userDisplayEdit__chooseViewWay'] = '请选择以下情况的显示方式';
$_LANG['modules__userDisplayEdit__pageWeiboCount'] = '每页微博显示数量';
$_LANG['modules__userDisplayEdit__pageWeiboViewCount'] = '请选择在我的首页、我的微博、TA的首页、@提到我的页面中，每页显示微博数量';
$_LANG['modules__userDisplayEdit__pageCommentCount'] = '每页评论显示数量';
$_LANG['modules__userDisplayEdit__pageCommentViewCount'] = '请选择在我的评论、单条微博的全部评论页面中，每页显示评论数量';
$_LANG['modules__userDisplayEdit__10'] = '10条';
$_LANG['modules__userDisplayEdit__20'] = '20条';
$_LANG['modules__userDisplayEdit__30'] = '30条';
$_LANG['modules__userDisplayEdit__40'] = '40条';
$_LANG['modules__userDisplayEdit__50'] = '50条';

/// user domain
$_LANG['modules__userDomain__setDomain'] = '你已经设置个性域名';
$_LANG['modules__userDomain__youDomain'] = '您的个性化域名是：';
$_LANG['modules__userDomain__addFavLink'] = '加入收藏夹';
$_LANG['modules__userDomain__inviteFollow'] = '邀请朋友关注我';
$_LANG['modules__userDomain__copyLink'] = '复制连接';
$_LANG['modules__userDomain__sendLink'] = '我将以上连接发给亲朋好友，他们接受邀请后会成为你的粉丝。';
$_LANG['modules__userDomain__whySetDomain'] = '记得自己的微博客地址是什么吗？设置个性域名，让朋友更容易记住！';
$_LANG['modules__userDomain__inputLength'] = '可以输入6至20位的英文或数字（必须包含英文字符）';
$_LANG['modules__userDomain__saveNotAllowModify'] = '保存后不得修改！';
$_LANG['modules__userDomain__setPerDomain'] = '设置个性域名';
$_LANG['modules__userDomain__domainPreview'] = '域名预览：';
$_LANG['modules__userDomain__nameAlreadyToken'] = '域名已经被占用！';

/// user head
$_LANG['modules__userHead__sendMessage'] = '发私信';
$_LANG['modules__userHead__talkToWho'] = '对 @%s 说';
$_LANG['modules__userHead__woman'] = '她';
$_LANG['modules__userHead__man'] = '他';
$_LANG['modules__userHead__more'] = '更多';
$_LANG['modules__userHead__mutualConcern'] = '相互关注';
$_LANG['modules__userHead__cancel'] = '取消';
$_LANG['modules__userHead__addBlack'] = '加入黑名单';
$_LANG['modules__userHead__blacked'] = '已加入黑名单';
$_LANG['modules__userHead__sureDelete'] = '确定将TA从你的黑名单移除？';
$_LANG['modules__userHead__pubWeibo'] = '我要发微博';

/// user header edit
$_LANG['modules__userHeaderEdit__choosePic'] = '请点击“浏览”按钮，选择你电脑中的图片作为微博头像';
$_LANG['modules__userHeaderEdit__imageSize1'] = '你的图片文件超出';
$_LANG['modules__userHeaderEdit__imageSize2'] = 'M或宽高超出2880像素，请选择文件和尺寸较小的图片';
$_LANG['modules__userHeaderEdit__imageTypeError'] = '图片文件类型错误';
$_LANG['modules__userHeaderEdit__saveHeaderError'] = '保存头像出错';
$_LANG['modules__userHeaderEdit__DamageImage'] = '损坏的图片文件（扩展名与图片类型不相符）';
$_LANG['modules__userHeaderEdit__imageUploading'] = '正在上传...';
$_LANG['modules__userHeaderEdit__notAllowModify'] = '抱歉，目前不允许修改个人头像，请联系网站管理员！';
$_LANG['modules__userHeaderEdit__modifySuccess'] = '修改头像成功';
$_LANG['modules__userHeaderEdit__chooseHeaderPic'] = '选择照片';
$_LANG['modules__userHeaderEdit__loadingPicWaitFor'] = '正在读取中，请稍候...';
$_LANG['modules__userHeaderEdit__browse'] = '浏览...';
$_LANG['modules__userHeaderEdit__imageUploadNotice1'] = '您上传的头像会自动生成三种尺寸，\n请注意中小尺寸的头像是否清晰';
$_LANG['modules__userHeaderEdit__imageUploadNotice2'] = '大尺寸头像，180×180像素';
$_LANG['modules__userHeaderEdit__imageUploadNotice3'] = '中尺寸头像\n50×50像素\n(自动生成)';
$_LANG['modules__userHeaderEdit__imageUploadNotice4'] = '小尺寸头像\n30×30像素\n(自动生成)';
$_LANG['modules__userHeaderEdit__rotate'] = '向右旋转';
$_LANG['modules__userHeaderEdit__rotateLeft'] = '向左旋转';
$_LANG['modules__userHeaderEdit__imageTypeLimit'] = '仅支持JPG、GIF、PNG图片文件，且文件小于';
$_LANG['modules__userHeaderEdit__editor'] = '编辑区';
$_LANG['modules__userHeaderEdit__previewArea'] = '预览区';

/// user hot
$_LANG['modules__userHot__starRec'] = '名人推荐';
$_LANG['modules__userHot__profileImageUrl'] = '%s的头像';

/// user info edit
$_LANG['modules__userInfoEdit__baseInfo'] = '基本资料';
$_LANG['modules__userInfoEdit__tags'] = '个人标签';
$_LANG['modules__userInfoEdit__mustOption'] = '为必填项';
$_LANG['modules__userInfoEdit__nickname'] = ' 昵称：';
$_LANG['modules__userInfoEdit__inputNick'] = '请输入昵称';
$_LANG['modules__userInfoEdit__nickLength'] = '大于4个字母，不超过20个字母或10个汉字';
$_LANG['modules__userInfoEdit__addr'] = ' 所在地：';
$_LANG['modules__userInfoEdit__inputAddr'] = '请选择所在地';
$_LANG['modules__userInfoEdit__choosePro'] = '省/直辖市';
$_LANG['modules__userInfoEdit__chooseCity'] = '城市/地区';
$_LANG['modules__userInfoEdit__sex'] = ' 性别：';
$_LANG['modules__userInfoEdit__m'] = ' 男';
$_LANG['modules__userInfoEdit__f'] = ' 女';
$_LANG['modules__userInfoEdit__desc'] = '一句话介绍：';
$_LANG['modules__userInfoEdit__descLengthLimit'] = '长度超过限制';

/// user list
$_LANG['modules__userList__profileImageUrl'] = '%s的头像';

/// user menu
$_LANG['modules__userMenu__myIndex'] = '我的首页';
$_LANG['modules__userMenu__atMe'] = '提到我的';
$_LANG['modules__userMenu__myComment'] = '我的评论';
$_LANG['modules__userMenu__myMessage'] = '我的私信';
$_LANG['modules__userMenu__myNotice'] = '我的通知';
$_LANG['modules__userMenu__myFavs'] = '我的收藏';

/// user notice
$_LANG['modules__userNotice__setNoticeWay'] = '设置您想要的提醒方式，随时随地接收微博的更新。';
$_LANG['modules__userNotice__needTip'] = '哪些内容通过微博小黄签提示我';
$_LANG['modules__userNotice__newsCommentTip'] = '新评论提醒';
$_LANG['modules__userNotice__newsFansTip'] = '新增粉丝提醒';
$_LANG['modules__userNotice__newsMessageTip'] = '新私信提醒';
$_LANG['modules__userNotice__newsAtMe'] = '@提到我提醒';
$_LANG['modules__userNotice__newsNoticeTip'] = '新通知提醒';
$_LANG['modules__userNotice__setAtMeAddNum'] = '设置哪些@提到我的微博计入@提醒数字中';
$_LANG['modules__userNotice__weiboAuthor'] = '微博的作者是：';
$_LANG['modules__userNotice__allPeople'] = '所有人';
$_LANG['modules__userNotice__followPeople'] = '关注的人';
$_LANG['modules__userNotice__weiboType'] = '微博的类型是：';
$_LANG['modules__userNotice__allWeibo'] = '所有微博';
$_LANG['modules__userNotice__oriWeibo'] = '原创的微博';

/// user preview
$_LANG['modules__userPreview__follow'] = '关注';
$_LANG['modules__userPreview__fans'] = '粉丝';
$_LANG['modules__userPreview__weibo'] = '微博';
$_LANG['modules__userPreview__needBindWeibo'] = '您已经成功登录！要使用%s微博功能，您需要绑定新浪微博帐号。';
$_LANG['modules__userPreview__regWeibo'] = '注册微博帐号';
$_LANG['modules__userPreview__regAccount'] = '注册帐号';

/// user setting
$_LANG['modules__userSetting__info'] = '个人资料';
$_LANG['modules__userSetting__modifyHeader'] = '修改头像';
$_LANG['modules__userSetting__setDisplay'] = '显示设置';
$_LANG['modules__userSetting__blackList'] = '黑名单';
$_LANG['modules__userSetting__setTip'] = '提醒设置';
$_LANG['modules__userSetting__setAccount'] = '帐号设置';
$_LANG['modules__userSetting__domain'] = '个性域名';

/// user skin
$_LANG['modules__userSkin__linkColor'] = '主链接色';
$_LANG['modules__userSkin__customSkin'] = '自定义皮肤';
$_LANG['modules__userSkin__deleteBg'] = '删除背景';
$_LANG['modules__userSkin__uploadPic'] = '上传图片';
$_LANG['modules__userSkin__setBgImg'] = '设置背景图';
$_LANG['modules__userSkin__bgTile'] = '背景平铺';
$_LANG['modules__userSkin__bgFixed'] = '背景固定';
$_LANG['modules__userSkin__left'] = '居左';
$_LANG['modules__userSkin__align'] = '居中';
$_LANG['modules__userSkin__right'] = '居右';
$_LANG['modules__userSkin__chooseScheme'] = '你还可以选择配色方案，丰富背景和字体颜色';
$_LANG['modules__userSkin__sublinkColor'] = '辅链接色';
$_LANG['modules__userSkin__mainBgColor'] = '主背景色';
$_LANG['modules__userSkin__titleFontColor'] = '标题字体色';
$_LANG['modules__userSkin__mainContentColor'] = '主文字色';

/// user tag
$_LANG['modules__userTag__me'] = '我';
$_LANG['modules__userTag__whoTag'] = '%s的标签';
$_LANG['modules__userTag__emptyTip'] = '你还没有设置标签。<br /><a href="%s">立即添加</a>';
$_LANG['modules__userTag__set'] = '设置';

/// user tag edit
$_LANG['modules__userTagEdit__whyAddTag'] = '添加描述自己职业、兴趣爱好等方面的词语，让更多人找到你，让你找到更多同类';
$_LANG['modules__userTagEdit__chooseTag'] = '选择最适合你的词语，多个请用空格分开';
$_LANG['modules__userTagEdit__addTag'] = '添加标签';
$_LANG['modules__userTagEdit__interest'] = '你可能感兴趣的标签(点击直接添加)：';
$_LANG['modules__userTagEdit__addedTag'] = '我已经添加的标签：';
$_LANG['modules__userTagEdit__aboutTag'] = '关于标签：';
$_LANG['modules__userTagEdit__desc1'] = '标签是自定义描述自己职业、兴趣爱好的关键词，让更多人找到你，让你找到更多同类。';
$_LANG['modules__userTagEdit__desc2'] = '已经添加的标签将显示在“我的微博”页面右侧栏中，方便大家了解你。';
$_LANG['modules__userTagEdit__desc3'] = '在此查看你自己添加的所有标签，还可以方便地管理，最多可添加10个标签。';
$_LANG['modules__userTagEdit__desc4'] = '点击你已添加的标签，可以搜索到有同样兴趣的人。';

/// user total
$_LANG['modules__userTotal__weiboGuest'] = '新浪微博来宾';
$_LANG['modules__userTotal__weiboNum'] = '微博';
$_LANG['modules__userTotal__follow'] = '关注';
$_LANG['modules__userTotal__fans'] = '粉丝';

/// userlist
$_LANG['modules__userList__haveMutualInterest'] = '已互相关注';
$_LANG['modules__userList__removeFans'] = '移除粉丝';
$_LANG['modules__userList__cancelFollowed'] = '取消关注';
$_LANG['modules__userList__sendMessage'] = '发私信';
$_LANG['modules__userList__fansNum'] = '粉丝数：%s人';

/// weibolist
$_LANG['modules__weiboList__newsWeiboTip'] = '有新微博，点击查看';
$_LANG['modules__weiboList__all'] = '全部';
$_LANG['modules__weiboList__ori'] = '原创';
$_LANG['modules__weiboList__image'] = '图片';
$_LANG['modules__weiboList__video'] = '视频';
$_LANG['modules__weiboList__music'] = '音乐';
$_LANG['modules__weiboList__lookNewsWeibo'] = '<a href="#">有<em></em>条新微博，点击查看</a>';
$_LANG['modules__weiboList__endPage'] = '已到最后一页';

/// error
$_LANG['modules__errorInhibit__errorTitle'] = '禁止登录';
$_LANG['modules__errorInhibit__errorMsg'] = '对不起，你已经被禁止登录了！';
$_LANG['modules__errorInhibit__errorTip'] = '退出登录，并回到首页';
$_LANG['modules__errorDelete__errorTitle'] = '禁止登录';
$_LANG['modules__errorDelete__errorMsg'] = '对不起，该用户已经被屏蔽了！';
$_LANG['modules__errorDelete__errorTip'] = '<a href="javascript:history.go(-1);">返回上一页</a> <a href="%s">我的首页</a>';

/// template html title
$_LANG['template__titleTip__click__close'] = '点击关闭';


$_LANG['modules_celeb_classify_list_adminEmptyTip'] = '名人堂还没有内容，请到<b>后台管理中心</b>-<b>用户管理</b>-<a href="%s">名人管理</a>中添加设置';
$_LANG['modules_celeb_classify_list_emptyTip'] = '名人堂还没有内容，等待管理员添加，你可以访问其他页面碰碰运气';


$_LANG['modules_user_recommend_block_more'] = '更多';
$_LANG['modules_user_recommend_block_selectAll'] = '全选';
$_LANG['modules_user_recommend_block_followMore'] = '关注已选';

/// 组件
$_LANG['modules_component_component_1_hotForward'] = '热门转发';
$_LANG['modules_component_component_1_hotComment'] = '热门评论';

// 下面两行为组件通用
$_LANG['modules_component_component_2_follow'] = '加关注';
$_LANG['modules_component_component_2_followed'] = '已关注';
$_LANG['modules_component_component_2_headTitle'] = '的头像';
$_LANG['modules_component_component_2_Forward'] = '向前';
$_LANG['modules_component_component_2_back'] = '向后';

$_LANG['modules_component_component_5_empty'] = '所设置的自定义微博列表不存在，请通知管理员进行设置。';
$_LANG['modules_component_component_5_sysError'] = '系统繁忙，微博列表获取不正常，请<a href="#" rel="e:rl">刷新</a>再试!';
$_LANG['modules_component_component_5_memberList'] = '列表成员：';

$_LANG['modules_component_component_7_reason_topic'] = '你们有相同的话题';
$_LANG['modules_component_component_7_reason_reason'] = '你们在同一个地区';
$_LANG['modules_component_component_7_reason_tag'] = '你们有相同的标签';

$_LANG['modules_component_component_8_changeCity'] = '切换城市';
$_LANG['modules_component_component_8_selectArea'] = '请选择地区：';
$_LANG['modules_component_component_8_weiboEmpty'] = '暂无微博';

$_LANG['modules_component_component_9_more'] = '更多';

$_LANG['modules_component_component_10_saySomething'] = '我也说几句';
$_LANG['modules_component_component_10_somebodyFace'] = '%s的头像';
$_LANG['modules_component_component_10_fans'] = '粉丝<span>%s</span>人';
$_LANG['modules_component_component_10_topicEmpty'] = '此话题暂无相关内容。';
$_LANG['modules_component_component_10_tryToGetAgain'] = '获取热门微博信息失败，请<a href="#" rel="e:rl">刷新</a>再试!';

$_LANG['modules_component_component_18_eventTitle'] = '活动列表';
$_LANG['modules_component_component_18_empty'] = '记录为空';
$_LANG['modules_component_component_18_eventTime'] = '时间：';

/// 直播与访谈
$_LANG['modules_interview_emcee_list_manager'] = '主持人';
$_LANG['modules_interview_emcee_list_follow'] = '加关注';
$_LANG['modules_interview_emcee_list_followed'] = '已关注';

$_LANG['modules_interview_program_list_interviewList'] = '访谈列表';
$_LANG['modules_interview_program_list_more'] = '更多';
$_LANG['modules_interview_program_list_ready'] = '<span class="unplayed">(未开始)</span>';
$_LANG['modules_interview_program_list_closed'] = '<span class="finish">(已结束)</span>';
$_LANG['modules_interview_program_list_running'] = '<span class="active">(进行中)</span>';
$_LANG['modules_interview_program_list_members'] = '主持人：';
$_LANG['modules_interview_program_list_timeField'] = '时&nbsp;&nbsp;&nbsp;&nbsp;间：';
$_LANG['modules_interview_program_list_time'] = 'Y年m月d日 H:i';

$_LANG['modules_interview_user_sidebar_guest'] = '特邀嘉宾';
$_LANG['modules_interview_user_sidebar_allFollow'] = '全部关注';

$_LANG['modules_interview_about_live_about'] = '关于在线访谈';

$_LANG['modules_interview_answerweibo_list_hasNew'] = '有<span></span>条新微博，点击查看';
$_LANG['modules_interview_answerweibo_list_master_count'] = '访谈内容<span>(共有<em class="que-num">%s</em>个问题 <em class="rep-num"> %s</em>个回复)</span>';
$_LANG['modules_interview_answerweibo_list_notmaster_count'] = '访谈内容<span class="close">(已结束，共 %s个回复)</span>';
$_LANG['modules_interview_answerweibo_list_weiboEmpty'] = '暂时没有微博';


$_LANG['modules_interview_answerweibo_nopage_count'] = '访谈内容<span>(共有<em class="que-num">%s</em>个问题 <em class="rep-num">%s</em>个回复)</span>';
$_LANG['modules_interview_answerweibo_nopage_weiboEmpty'] = '暂时没有微博';

$_LANG['modules_interview_askweibo_list_hasNew'] = '有<span></span>条新微博，点击查看';
$_LANG['modules_interview_askweibo_list_fansAsk'] = '网友提问';
$_LANG['modules_interview_askweibo_list_weiboEmpty'] = '暂时没有微博';


$_LANG['modules_interview_askweibo_nopage_counts'] = '网友提问<span>(共有<em class="que-num">%s</em>个问题)</span>';
$_LANG['modules_interview_askweibo_nopage_weiboEmpty'] = '暂时没有微博';


$_LANG['modules_interview_closeed_closeed'] = '已结束';
$_LANG['modules_interview_closeed_time'] = '访谈时间：<span>%s</span>';
$_LANG['modules_interview_closeed_description'] = '访谈简介：';

$_LANG['modules_interview_feed_withAnswer_masker'] = '主持人';
$_LANG['modules_interview_feed_withAnswer_guest'] = '嘉宾';
$_LANG['modules_interview_feed_withAnswer_forward'] = '转发';
$_LANG['modules_interview_feed_withAnswer_comment'] = '评论';
$_LANG['modules_interview_feed_withAnswer_weiboIllegal'] = '内容有错！';
$_LANG['modules_interview_feed_withAnswer_userHasBeDisabled'] = '该用户已经被屏蔽';
$_LANG['modules_interview_feed_withAnswer_sourceWeiboHasBeDisabled'] = '原微博已被屏蔽';
$_LANG['modules_interview_feed_withAnswer_forwardSource'] = '原文转发';
$_LANG['modules_interview_feed_withAnswer_commentSource'] = '原文评论';
$_LANG['modules_interview_feed_withAnswer_answer'] = '回答';
$_LANG['modules_interview_feed_withAnswer_delete'] = '删除';
$_LANG['modules_interview_feed_withAnswer_forward'] = '转发';
$_LANG['modules_interview_feed_withAnswer_favCancel'] = '取消收藏';
$_LANG['modules_interview_feed_withAnswer_fav'] = '收藏';
$_LANG['modules_interview_feed_withAnswer_comment'] = '评论';
$_LANG['modules_interview_feed_withAnswer_from'] = '来自';
$_LANG['modules_interview_feed_withAnswer_report'] = '举报';
$_LANG['modules_interview_feed_withAnswer_disabled'] = '已屏蔽';
$_LANG['modules_interview_feed_withAnswer_disableWeibo'] = '屏蔽该微博';


$_LANG['modules_interview_going_ask'] = '<div class="title-txt">我有一个问题向</div><div class="btn-guest"><span>嘉宾列表</span><em class="arrow"></em>';
$_LANG['modules_interview_going_going'] = '进行中';
$_LANG['modules_interview_going_time'] = '访谈时间：';
$_LANG['modules_interview_going_recommend'] = '推荐给好友';
$_LANG['modules_interview_going_title'] = '访谈简介：';

$_LANG['modules_interview_guest_going_title'] = '我有一个想法和大家分享：';
$_LANG['modules_interview_guest_going_ready'] = '<span class="not-started">未开始</span>';
$_LANG['modules_interview_guest_going_going'] = '<span class="going">进行中</span>';
$_LANG['modules_interview_guest_going_time'] = '访谈时间：';
$_LANG['modules_interview_guest_going_recommend'] = '推荐给好友';
$_LANG['modules_interview_guest_going_description'] = '访谈简介：';

$_LANG['modules_interview_guestweibo_list_myQuestion'] = '我的问题';
$_LANG['modules_interview_guestweibo_list_allQuestion'] = '所有问题';
$_LANG['modules_interview_guestweibo_list_myAnswered'] = '我回答过的';
$_LANG['modules_interview_guestweibo_list_hasNew'] = '有<span></span>条新微博，点击查看';
$_LANG['modules_interview_guestweibo_list_weiboEmpty'] = '暂时没有提问，<a href="javascript:void(0);" onclick="location.reload();">刷新</a>试试';
$_LANG['modules_interview_guestweibo_list_answeredEmpty'] = '您暂时没有回答任何问题';

$_LANG['modules_interview_index_list_title'] = '精彩访谈';
$_LANG['modules_interview_index_list_toBegin'] = '在线访谈 "%s" 即将开始';
$_LANG['modules_interview_index_list_remindMe'] = '提醒我';
$_LANG['modules_interview_index_list_ready'] = '<span class="unplayed">(未开始)</span>';
$_LANG['modules_interview_index_list_closed'] = '<span class="finish">(已结束)</span>';
$_LANG['modules_interview_index_list_going'] = '<span class="active">(进行中)</span>';
$_LANG['modules_interview_index_list_guest'] = '特邀嘉宾';
$_LANG['modules_interview_index_list_left'] = '左';
$_LANG['modules_interview_index_list_right'] = '右';
$_LANG['modules_interview_index_list_more'] = '更多';
$_LANG['modules_interview_index_list_moreRecommend'] = '更多推荐';
$_LANG['modules_interview_index_list_admin_inertviewEmpty'] = '还没有在线访谈，你可以在 后台管理中心-扩展工具-在线访谈 添加设置';
$_LANG['modules_interview_index_list_inertviewEmpty'] = '还没有在线访谈，你可以看看其他页面。';


$_LANG['modules_interview_live_contact_contact'] = '联系方式';

$_LANG['modules_interview_master_title'] = '我有一个想法和大家分享：';
$_LANG['modules_interview_master_ready'] = '<span class="not-started">未开始</span>';
$_LANG['modules_interview_master_going'] = '<span class="going">进行中</span>';
$_LANG['modules_interview_master_time'] = '访谈时间：';
$_LANG['modules_interview_master_recommend'] = '推荐给好友';
$_LANG['modules_interview_master_description'] = '访谈简介：';


$_LANG['modules_interview_not_start_title'] = '<div class="title-txt">我有一个问题向</div><div class="btn-guest"><span>嘉宾列表</span><em class="arrow"></em>';
$_LANG['modules_interview_not_start_ask'] = '提问';
$_LANG['modules_interview_not_start_ready'] = '未开始';
$_LANG['modules_interview_not_start_time'] = '访谈时间：';
$_LANG['modules_interview_not_start_toBegin'] = '在线访谈 "%s" 即将开始';
$_LANG['modules_interview_not_start_remind'] = '定制访谈提醒';
$_LANG['modules_interview_not_start_reommmend'] = '推荐给好友';
$_LANG['modules_interview_not_start_description'] = '访谈简介：';
$_LANG['modules_interview_login_tip'] = '登录之后可查看更多精彩访谈内容，还可参与嘉宾互动。';
$_LANG['modules_interview_login_tag'] = '立即登录';

$_LANG['modules_interview_user_list_s1_title'] = '微博主持人';
$_LANG['modules_interview_user_list_s1_followed'] = '已关注';
$_LANG['modules_interview_user_list_s1_follow'] = '加关注';
$_LANG['modules_interview_user_list_s1_master'] = '官方主持人';

$_LANG['modules_interview_feedAnswer_forward'] = '转发';
$_LANG['modules_interview_feedAnswer_comment'] = '评论';

$_LANG['modules_microlive_live_detail_info_running'] = '进行中';
$_LANG['modules_microlive_live_detail_info_ready'] = '未开始';
$_LANG['modules_microlive_live_detail_info_closed'] = '已结束';
$_LANG['modules_microlive_live_detail_info_title'] = '直播简介';
$_LANG['modules_microlive_live_detail_info_fieldTime'] = '直播时间：';
$_LANG['modules_microlive_live_detail_info_recommend'] = '推荐给好友';

$_LANG['modules_microlive_live_detail_users_master'] = '主持人';
$_LANG['modules_microlive_live_detail_users_guest'] = '特邀嘉宾';
$_LANG['modules_microlive_live_detail_users_allFollow'] = '全部关注';
$_LANG['modules_microlive_live_detail_users_followed'] = '<a href="#" class="followed-btn">已关注</a>';
$_LANG['modules_microlive_live_detail_users_addFollower'] = '<a href="#" class="addfollow-btn" rel="e:fl,t:1">加关注</a>';
$_LANG['modules_microlive_live_detail_login_tip'] = '登录之后可查看更多精彩访谈内容，还可参与嘉宾互动。';
$_LANG['modules_microlive_live_detail_login_tag'] = '立即登录';


$_LANG['modules_microlive_news_live_running'] = '进行中';
$_LANG['modules_microlive_news_live_ready'] = '未开始';
$_LANG['modules_microlive_news_live_closed'] = '已结束';
$_LANG['modules_microlive_news_live_remind'] = '提醒我';
$_LANG['modules_microlive_news_live_timeout'] = '距开始时间还剩：';
$_LANG['modules_microlive_news_live_guest'] = '特邀嘉宾';
$_LANG['modules_microlive_news_live_lift'] = '左';
$_LANG['modules_microlive_news_live_right'] = '右';
$_LANG['modules_microlive_news_live_emptyForAdmin'] = '还没有在线直播，你可以在 后台管理中心-扩展工具-在线直播 添加设置';
$_LANG['modules_microlive_news_live_empty'] = '还没有在线直播，你可以看看其他页面。';
$_LANG['modules_microlive_news_live_more'] = '更多';
$_LANG['modules_microlive_news_live_moreRecommend'] = '更多推荐';

$_LANG['modules_microlive_news_live_list_title'] = '精彩直播';
$_LANG['modules_microlive_news_live_list_running'] = '进行中';
$_LANG['modules_microlive_news_live_list_ready'] = '未开始';
$_LANG['modules_microlive_news_live_list_closed'] = '已结束';
$_LANG['modules_microlive_news_live_list_remind'] = '提醒我';
$_LANG['modules_microlive_news_live_list_emptyForAdmin'] = '还没有在线直播，你可以在 后台管理中心-扩展工具-在线直播 添加设置';
$_LANG['modules_microlive_news_live_list_empty'] = '还没有在线直播，你可以看看其他页面。';

$_LANG['modules_microlive_side_live_base_info_title'] = '关于在线直播';
$_LANG['modules_microlive_side_live_base_info_contact'] = '联系方式';

$_LANG['modules_microlive_side_live_base_master_title'] = '微博主持人';
$_LANG['modules_microlive_side_live_base_master_master'] = '官方主持人';

$_LANG['modules_microlive_side_news_live_more'] = '更多';
$_LANG['modules_microlive_side_news_live_title'] = '直播列表';
$_LANG['modules_microlive_side_news_live_running'] = '进行中';
$_LANG['modules_microlive_side_news_live_ready'] = '未开始';
$_LANG['modules_microlive_side_news_live_close'] = '已结束';
$_LANG['modules_microlive_side_news_live_master'] = '主持人：';
$_LANG['modules_microlive_side_news_live_timeField'] = '时&nbsp;&nbsp;&nbsp;&nbsp;间：';

$_LANG['modules_share_main_title'] = '转发 - ';
$_LANG['modules_share_main_using'] = '你正在使用';
$_LANG['modules_share_main_account'] = '帐号';
$_LANG['modules_share_main_changeAccount'] = '换个帐号？';
$_LANG['modules_share_main_redirect'] = '转发到我的微博';
$_LANG['modules_share_main_inputLest'] = '你还可以输入<span>140</span>字';
$_LANG['modules_share_main_publish'] = '发布微博';
$_LANG['modules_share_main_js_input'] = '您还可以输入<span>';
$_LANG['modules_share_main_js_lengthLimit'] = '已超出<span>';
$_LANG['modules_share_main_js_front'] = '</span>字';

$_LANG['modules_share_success_title'] = '转发成功 - ';
$_LANG['modules_share_success_succ'] = '转发成功！';
$_LANG['modules_share_success_goto'] = '<a href="%s" target="_blank">去我的微博</a>看看，或<a href="javascript:window.close();">点击这里</a>关闭窗口';
$_LANG['modules_share_success_close'] = '<span id="timer">3</span>秒后窗口自动关闭，<a href="javascript:window.close();">点击这里</a>立即关闭';
$_LANG['modules_share_success_comeTo'] = '去我的微博';

/// 单元输出
$_LANG['modules_unit_t_follow_followTooManyUser'] = '你今天已经关注了足够多的人，先去看看他们在说些什么吧？';
$_LANG['modules_unit_t_follow_empty'] = '该用户列表没有数据，请到用户管理中添加用户。';
$_LANG['modules_unit_t_follow_followed'] = '<span>已关注</span>';
$_LANG['modules_unit_t_follow_my'] = '<span>我自己</span>';

$_LANG['modules_unit_t_oneclick_follow_followed'] = '关注成功';
$_LANG['modules_unit_t_oneclick_follow_nologin'] = '目前尚未登录%s，请<a id="loginBtn" target="_blank" href="%s">登录</a>后关注！';
$_LANG['modules_unit_t_oneclick_follow_userlistEmpty'] = '用户列表为空';

$_LANG['modules_unit_t_show_followedTooManyUsers'] = '你今天已经关注了足够多的人，先去看看他们在说些什么吧？';
$_LANG['modules_unit_t_show_fans'] = '粉丝';
$_LANG['modules_unit_t_show_people'] = '人';
$_LANG['modules_unit_t_show_forward'] = '转发';
$_LANG['modules_unit_t_show_comment'] = '评论';
$_LANG['modules_unit_t_show_empty'] = '暂时没有微博信息';
$_LANG['modules_unit_t_show_refresh'] = '获取微博信息失败，请<a href="#" rel="e:rl">刷新</a>再试!';

$_LANG['modules_unit_t_topic_input'] = '您还可以输入';
$_LANG['modules_unit_t_topic_letter'] = '字';
$_LANG['modules_unit_t_topic_overflow'] = '已超出';
$_LANG['modules_unit_t_topic_talkAbout'] = '大家都在聊';
$_LANG['modules_unit_t_topic_succ'] = '发布成功！';
$_LANG['modules_unit_t_topic_error'] = '错误信息！';
$_LANG['modules_unit_t_topic_nologin'] = '<a href="%s" target="_blank" id="loginA">登录%s</a>,即可参与话题讨论';
$_LANG['modules_unit_t_topic_forward'] = '转发';
$_LANG['modules_unit_t_topic_comment'] = '评论';
$_LANG['modules_unit_t_topic_from'] = '来自';
$_LANG['modules_unit_t_topic_empty'] = '暂时没有关注该话题的微博信息%s';
$_LANG['modules_unit_t_topic_publishAgain'] = '，立刻发一条吧！';
$_LANG['modules_unit_t_topic_refresh'] = '获取该话题的微博信息失败，请<a href="#" rel="e:rl">刷新</a>再试!';

$_LANG['modules_unit_t_weibo_allMembers'] = '全部成员';
$_LANG['modules_unit_t_weibo_talkAbout'] = '他们在说';
$_LANG['modules_unit_t_weibo_forward'] = '转发';
$_LANG['modules_unit_t_weibo_comment'] = '评论';
$_LANG['modules_unit_t_weibo_from'] = '来自';
$_LANG['modules_unit_t_weibo_empty'] = '获取群组微博失败，可能服务器繁忙';
$_LANG['modules_unit_t_weibo_refresh'] = '获取该话题的微博信息失败，请<a href="javascript:location.reload();">刷新</a>再试!';
$_LANG['modules_unit_t_weibo_nousers'] = '该用户列表没有数据，请到用户管理中添加用户。';

$_LANG['modules__userPrivacyNotice__showNumTip'] = '本页仅显示了“%s”的最近20条微博，<a href="#" rel="e:lg">登录</a>之后可以查看Ta的所有微博';
$_LANG['modules__userPrivacyNotice__copyright'] = '%s未登录%s，此处信息均来自新浪微博，Powered By <a href="http://weibo.com/" target="_blank">新浪微博</a>';

$_LANG['modules__footer__wap'] = 'WAP 版';
/// class
$_LANG['xwbPreAction__common__underReview'] = '正在审核中';

$_LANG['pageClass__title__prePage'] = '上一页';
$_LANG['pageClass__title__nextPage'] = '下一页';
$_LANG['pageClass__title__indexPage'] = '首页';
$_LANG['pageClass__title__pageStyle'] = '[prev]上一页[/prev] [nav] [next]下一页[/next] 总记录数 [recordCount]';

/// adapter
/// account
$_LANG['adapter__account__dzUcenter__loginError'] = '登录失败，请检查远程登录验证接口';
$_LANG['adapter__account__xauthCookie__tokenMustStart'] = 'XAUTH_TK_DATA_SIGN_FUNC 不能为空，为保证安全，TOKEN必须启用签名';
$_LANG['adapter__account__xauthCookie__keyMustChange'] = '为保证安全，账号适配器中的签名和加密公钥你必须更改 XAUTH_TK_DATA_ENCRIPT_KEY ';
$_LANG['adapter__account__xauthCookie__notFoundFun'] = '无法在当前账号适配器中找到你请求的远程ACTION方法[%s]';
$_LANG['adapter__account__xauthCookie__loginError'] = '登录失败，请检查远程登录验证接口';
$_LANG['adapter__account__xauthCookie__notFoundClassFun'] = '无法在本类中找到你配置的签名方法[%s]';
$_LANG['adapter__account__xauthCookie__dataFormatErr'] = '账号适配器配置 [XAUTH_TK_DATA_FORMAT] 错误';
$_LANG['adapter__account__xauthCookie__tokenEmpty'] = 'TOKEN为空，或者无法将TOKEN数据转换成[%s]格式的字符串';
$_LANG['adapter__account__xauthCookie__notFoundsecFun'] = '无法在账号适配器中找到你配置的加密解密方法[%s]';

/// upload
$_LANG['adapter__load__fileUpload__uploadDirNotExist'] = '上传目录%s不存在';
$_LANG['adapter__load__fileUpload__uploadDirNotWritable'] = '上传目录%s不可写';
$_LANG['adapter__load__fileUpload__success'] = '上传成功!';
$_LANG['adapter__load__fileUpload__uploadFileSize'] = '上传文件大小不符！';
$_LANG['adapter__load__fileUpload__illegalUploadFiles'] = '非法上传文件！';
$_LANG['adapter__load__fileUpload__uploadFileErr1'] = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
$_LANG['adapter__load__fileUpload__uploadFileErr2'] = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
$_LANG['adapter__load__fileUpload__uploadFileErr3'] = '文件只有部分被上传';
$_LANG['adapter__load__fileUpload__uploadFileErr4'] = '没有文件被上传';
$_LANG['adapter__load__fileUpload__uploadFileErr5'] = '找不到临时文件夹';
$_LANG['adapter__load__fileUpload__uploadFileErr6'] = '文件写入失败';
$_LANG['adapter__load__fileUpload__uploadFileErr7'] = '未知上传错误！';

/// 共同使用
$_LANG['common__apiError__limitTip'] = '出错啦，该网站调用API次数已超过限制，请联系站长解决！<br><a href="http://bbs.x.weibo.com/viewthread.php?tid=1262&extra=page%3D1" target="_blank">查看解决方案</a>';
$_LANG['common__template__followed'] = '已关注';
$_LANG['common__template__save'] = '保存';
$_LANG['common__template__cancel'] = '取消';
$_LANG['common__template__OK'] = '确定';
$_LANG['common__template__toFollow'] = '加关注';
$_LANG['common__template__goTop'] = '返回顶部';

$_LANG['js__controller__setting__provinceCity'] = 
<<<END
{"provinces":[{"id":11,"name":"北京","citys":[{"1":"东城区"},{"2":"西城区"},{"3":"崇文区"},{"4":"宣武区"},{"5":"朝阳区"},{"6":"丰台区"},{"7":"石景山区"},{"8":"海淀区"},{"9":"门头沟区"},{"11":"房山区"},{"12":"通州区"},{"13":"顺义区"},{"14":"昌平区"},{"15":"大兴区"},{"16":"怀柔区"},{"17":"平谷区"},{"28":"密云县"},{"29":"延庆县"}]},
{"id":12,"name":"天津","citys":[{"1":"和平区"},{"2":"河东区"},{"3":"河西区"},{"4":"南开区"},{"5":"河北区"},{"6":"红桥区"},{"7":"塘沽区"},{"8":"汉沽区"},{"9":"大港区"},{"10":"东丽区"},{"11":"西青区"},{"12":"津南区"},{"13":"北辰区"},{"14":"武清区"},{"15":"宝坻区"},{"21":"宁河县"},{"23":"静海县"},{"25":"蓟县"}]},
{"id":13,"name":"河北","citys":[{"1":"石家庄"},{"2":"唐山"},{"3":"秦皇岛"},{"4":"邯郸"},{"5":"邢台"},{"6":"保定"},{"7":"张家口"},{"8":"承德"},{"9":"沧州"},{"10":"廊坊"},{"11":"衡水"}]},
{"id":14,"name":"山西","citys":[{"1":"太原"},{"2":"大同"},{"3":"阳泉"},{"4":"长治"},{"5":"晋城"},{"6":"朔州"},{"7":"晋中"},{"8":"运城"},{"9":"忻州"},{"10":"临汾"},{"23":"吕梁"}]},
{"id":15,"name":"内蒙古","citys":[{"1":"呼和浩特"},{"2":"包头"},{"3":"乌海"},{"4":"赤峰"},{"5":"通辽"},{"6":"鄂尔多斯"},{"7":"呼伦贝尔"},{"22":"兴安盟"},{"25":"锡林郭勒盟"},{"26":"乌兰察布盟"},{"28":"巴彦淖尔盟"},{"29":"阿拉善盟"}]},
{"id":21,"name":"辽宁","citys":[{"1":"沈阳"},{"2":"大连"},{"3":"鞍山"},{"4":"抚顺"},{"5":"本溪"},{"6":"丹东"},{"7":"锦州"},{"8":"营口"},{"9":"阜新"},{"10":"辽阳"},{"11":"盘锦"},{"12":"铁岭"},{"13":"朝阳"},{"14":"葫芦岛"}]},
{"id":22,"name":"吉林","citys":[{"1":"长春"},{"2":"吉林"},{"3":"四平"},{"4":"辽源"},{"5":"通化"},{"6":"白山"},{"7":"松原"},{"8":"白城"},{"24":"延边朝鲜族自治州"}]},
{"id":23,"name":"黑龙江","citys":[{"1":"哈尔滨"},{"2":"齐齐哈尔"},{"3":"鸡西"},{"4":"鹤岗"},{"5":"双鸭山"},{"6":"大庆"},{"7":"伊春"},{"8":"佳木斯"},{"9":"七台河"},{"10":"牡丹江"},{"11":"黑河"},{"12":"绥化"},{"27":"大兴安岭"}]},
{"id":31,"name":"上海","citys":[{"1":"黄浦区"},{"3":"卢湾区"},{"4":"徐汇区"},{"5":"长宁区"},{"6":"静安区"},{"7":"普陀区"},{"8":"闸北区"},{"9":"虹口区"},{"10":"杨浦区"},{"12":"闵行区"},{"13":"宝山区"},{"14":"嘉定区"},{"15":"浦东新区"},{"16":"金山区"},{"17":"松江区"},{"18":"青浦区"},{"19":"南汇区"},{"20":"奉贤区"},{"30":"崇明县"}]},
{"id":32,"name":"江苏","citys":[{"1":"南京"},{"2":"无锡"},{"3":"徐州"},{"4":"常州"},{"5":"苏州"},{"6":"南通"},{"7":"连云港"},{"8":"淮安"},{"9":"盐城"},{"10":"扬州"},{"11":"镇江"},{"12":"泰州"},{"13":"宿迁"}]},
{"id":33,"name":"浙江","citys":[{"1":"杭州"},{"2":"宁波"},{"3":"温州"},{"4":"嘉兴"},{"5":"湖州"},{"6":"绍兴"},{"7":"金华"},{"8":"衢州"},{"9":"舟山"},{"10":"台州"},{"11":"丽水"}]},
{"id":34,"name":"安徽","citys":[{"1":"合肥"},{"2":"芜湖"},{"3":"蚌埠"},{"4":"淮南"},{"5":"马鞍山"},{"6":"淮北"},{"7":"铜陵"},{"8":"安庆"},{"10":"黄山"},{"11":"滁州"},{"12":"阜阳"},{"13":"宿州"},{"14":"巢湖"},{"15":"六安"},{"16":"亳州"},{"17":"池州"},{"18":"宣城"}]},
{"id":35,"name":"福建","citys":[{"1":"福州"},{"2":"厦门"},{"3":"莆田"},{"4":"三明"},{"5":"泉州"},{"6":"漳州"},{"7":"南平"},{"8":"龙岩"},{"9":"宁德"}]},
{"id":36,"name":"江西","citys":[{"1":"南昌"},{"2":"景德镇"},{"3":"萍乡"},{"4":"九江"},{"5":"新余"},{"6":"鹰潭"},{"7":"赣州"},{"8":"吉安"},{"9":"宜春"},{"10":"抚州"},{"11":"上饶"}]},
{"id":37,"name":"山东","citys":[{"1":"济南"},{"2":"青岛"},{"3":"淄博"},{"4":"枣庄"},{"5":"东营"},{"6":"烟台"},{"7":"潍坊"},{"8":"济宁"},{"9":"泰安"},{"10":"威海"},{"11":"日照"},{"12":"莱芜"},{"13":"临沂"},{"14":"德州"},{"15":"聊城"},{"16":"滨州"},{"17":"菏泽"}]},
{"id":41,"name":"河南","citys":[{"1":"郑州"},{"2":"开封"},{"3":"洛阳"},{"4":"平顶山"},{"5":"安阳"},{"6":"鹤壁"},{"7":"新乡"},{"8":"焦作"},{"9":"濮阳"},{"10":"许昌"},{"11":"漯河"},{"12":"三门峡"},{"13":"南阳"},{"14":"商丘"},{"15":"信阳"},{"16":"周口"},{"17":"驻马店"}]},
{"id":42,"name":"湖北","citys":[{"1":"武汉"},{"2":"黄石"},{"3":"十堰"},{"5":"宜昌"},{"6":"襄樊"},{"7":"鄂州"},{"8":"荆门"},{"9":"孝感"},{"10":"荆州"},{"11":"黄冈"},{"12":"咸宁"},{"13":"随州"},{"28":"恩施土家族苗族自治州"}]},
{"id":43,"name":"湖南","citys":[{"1":"长沙"},{"2":"株洲"},{"3":"湘潭"},{"4":"衡阳"},{"5":"邵阳"},{"6":"岳阳"},{"7":"常德"},{"8":"张家界"},{"9":"益阳"},{"10":"郴州"},{"11":"永州"},{"12":"怀化"},{"13":"娄底"},{"31":"湘西土家族苗族自治州"}]},
{"id":44,"name":"广东","citys":[{"1":"广州"},{"2":"韶关"},{"3":"深圳"},{"4":"珠海"},{"5":"汕头"},{"6":"佛山"},{"7":"江门"},{"8":"湛江"},{"9":"茂名"},{"12":"肇庆"},{"13":"惠州"},{"14":"梅州"},{"15":"汕尾"},{"16":"河源"},{"17":"阳江"},{"18":"清远"},{"19":"东莞"},{"20":"中山"},{"51":"潮州"},{"52":"揭阳"},{"53":"云浮"}]},
{"id":45,"name":"广西","citys":[{"1":"南宁"},{"2":"柳州"},{"3":"桂林"},{"4":"梧州"},{"5":"北海"},{"6":"防城港"},{"7":"钦州"},{"8":"贵港"},{"9":"玉林"},{"10":"百色"},{"11":"贺州"},{"12":"河池"}]},
{"id":46,"name":"海南","citys":[{"1":"海口"},{"2":"三亚"},{"90":"其他"}]},
{"id":50,"name":"重庆","citys":[{"1":"万州区"},{"2":"涪陵区"},{"3":"渝中区"},{"4":"大渡口区"},{"5":"江北区"},{"6":"沙坪坝区"},{"7":"九龙坡区"},{"8":"南岸区"},{"9":"北碚区"},{"10":"万盛区"},{"11":"双桥区"},{"12":"渝北区"},{"13":"巴南区"},{"14":"黔江区"},{"15":"长寿区"},{"22":"綦江县"},{"23":"潼南县"},{"24":"铜梁县"},{"25":"大足县"},{"26":"荣昌县"},{"27":"璧山县"},{"28":"梁平县"},{"29":"城口县"},{"30":"丰都县"},{"31":"垫江县"},{"32":"武隆县"},{"33":"忠县"},{"34":"开县"},{"35":"云阳县"},{"36":"奉节县"},{"37":"巫山县"},{"38":"巫溪县"},{"40":"石柱土家族自治县"},{"41":"秀山土家族苗族自治县"},{"42":"酉阳土家族苗族自治县"},{"43":"彭水苗族土家族自治县"},{"81":"江津市"},{"82":"合川市"},{"83":"永川市"},{"84":"南川市"}]},
{"id":51,"name":"四川","citys":[{"1":"成都"},{"3":"自贡"},{"4":"攀枝花"},{"5":"泸州"},{"6":"德阳"},{"7":"绵阳"},{"8":"广元"},{"9":"遂宁"},{"10":"内江"},{"11":"乐山"},{"13":"南充"},{"14":"眉山"},{"15":"宜宾"},{"16":"广安"},{"17":"达州"},{"18":"雅安"},{"19":"巴中"},{"20":"资阳"},{"32":"阿坝"},{"33":"甘孜"},{"34":"凉山"}]},
{"id":52,"name":"贵州","citys":[{"1":"贵阳"},{"2":"六盘水"},{"3":"遵义"},{"4":"安顺"},{"22":"铜仁"},{"23":"黔西南"},{"24":"毕节"},{"26":"黔东南"},{"27":"黔南"}]},
{"id":53,"name":"云南","citys":[{"1":"昆明"},{"3":"曲靖"},{"4":"玉溪"},{"5":"保山"},{"6":"昭通"},{"23":"楚雄"},{"25":"红河"},{"26":"文山"},{"27":"思茅"},{"28":"西双版纳"},{"29":"大理"},{"31":"德宏"},{"32":"丽江"},{"33":"怒江"},{"34":"迪庆"},{"35":"临沧"}]},
{"id":54,"name":"西藏","citys":[{"1":"拉萨"},{"21":"昌都"},{"22":"山南"},{"23":"日喀则"},{"24":"那曲"},{"25":"阿里"},{"26":"林芝"}]},
{"id":61,"name":"陕西","citys":[{"1":"西安"},{"2":"铜川"},{"3":"宝鸡"},{"4":"咸阳"},{"5":"渭南"},{"6":"延安"},{"7":"汉中"},{"8":"榆林"},{"9":"安康"},{"10":"商洛"}]},
{"id":62,"name":"甘肃","citys":[{"1":"兰州"},{"2":"嘉峪关"},{"3":"金昌"},{"4":"白银"},{"5":"天水"},{"6":"武威"},{"7":"张掖"},{"8":"平凉"},{"9":"酒泉"},{"10":"庆阳"},{"24":"定西"},{"26":"陇南"},{"29":"临夏"},{"30":"甘南"}]},
{"id":63,"name":"青海","citys":[{"1":"西宁"},{"21":"海东"},{"22":"海北"},{"23":"黄南"},{"25":"海南"},{"26":"果洛"},{"27":"玉树"},{"28":"海西"}]},
{"id":64,"name":"宁夏","citys":[{"1":"银川"},{"2":"石嘴山"},{"3":"吴忠"},{"4":"固原"}]},
{"id":65,"name":"新疆","citys":[{"1":"乌鲁木齐"},{"2":"克拉玛依"},{"21":"吐鲁番"},{"22":"哈密"},{"23":"昌吉"},{"27":"博尔塔拉"},{"28":"巴音郭楞"},{"29":"阿克苏"},{"30":"克孜勒苏"},{"31":"喀什"},{"32":"和田"},{"40":"伊犁"},{"42":"塔城"},{"43":"阿勒泰"}]},
{"id":71,"name":"台湾","citys":[{"1":"台北"},{"2":"高雄"},{"90":"其他"}]},
{"id":81,"name":"香港","citys":[{"1":"香港"}]},
{"id":82,"name":"澳门","citys":[{"1":"澳门"}]},
{"id":100,"name":"其他","citys":[]},
{"id":400,"name":"海外","citys":[{"1":"美国"},{"2":"英国"},{"3":"法国"},{"4":"俄罗斯"},{"5":"加拿大"},{"6":"巴西"},{"7":"澳大利亚"},{"8":"印尼"},{"9":"泰国"},{"10":"马来西亚"},{"11":"新加坡"},{"12":"菲律宾"},{"13":"越南"},{"14":"印度"},{"15":"日本"},{"16":"其他"}]}]}
END;
