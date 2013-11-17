<?php
/**************************************************
*  Created:  2010-06-08
*
*  語言檔
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

$_LANG = array();
/// controllers
/// action
$_LANG['controller__action__applyDomain__haveSet'] = '已設定個性域名，拒絕訪問';
$_LANG['controller__action__applyDomain__formatError'] = '格式不正確';
$_LANG['controller__action__applyDomain__domainUsed'] = '域名已被使用';
$_LANG['controller__action__applyDomain__dbError'] = '資料庫操作失敗';

/// 添加話題
$_LANG['controller__action__addSubject__topicKeyNotEmpty'] = '話題關鍵字不能為空';
$_LANG['controller__action__addSubject__topicRepeat'] = '話題重複，未被添加';
$_LANG['controller__action__addSubject__dbError'] = '資料庫操作失敗';

/// 刪除話題
$_LANG['controller__action__deleteSubject__topicKeyNotEmpty'] = '話題關鍵字不能為空';
$_LANG['controller__action__deleteSubject__notSubTopic'] = '不存在該話題訂閱的歷史記錄';
$_LANG['controller__action__deleteSubject__dbError'] = '資料庫操作失敗';

/// 檢查話題是否已被收藏
$_LANG['controller__action__isSubjectFollowed__topicKeyNotEmpty'] = '話題關鍵字不能為空';
$_LANG['controller__action__isSubjectFollowed__topicNotFavs'] = '該話題未被收藏';
$_LANG['controller__action__isSubjectFollowed__topicHavedFavs'] = '該話題已經被收藏';
$_LANG['controller__action__isSubjectFollowed__dbError'] = '資料庫操作失敗';

/// 獲取某人所有訂閱的
$_LANG['controller__action__getAllSubject__dbError'] = '資料庫操作失敗';
$_LANG['controller__action__getAllSubject__userId'] = '用戶uid無效';

/// 活動
$_LANG['controller__event__shareEvent'] = '我發起了一個活動，大家都來關注一下：';

/// feedback
$_LANG['controller__feedBack__save__disabled'] = '管理員已禁用意見回饋組件';

/// 線上訪談
$_LANG['controller__interview__paramsNotExist'] = '訪談不存在或參數不正確';

/// 線上直播
$_LANG['controller__live__topic'] = '一起來聊聊：%s';

/// 內容輸出
$_LANG['controller__outPut__weiboShow'] = '微博秀';
$_LANG['controller__outPut__recFollower'] = '推薦關注用戶';
$_LANG['controller__outPut__followTopic'] = '關注話題';
$_LANG['controller__outPut__keyFollow'] = '一鍵關注';
$_LANG['controller__outPut__qunWeibo'] = '群組微博';

/// 設定
$_LANG['controller__setting__notLogin'] = '您尚未登入';
$_LANG['controller__setting__sizeLimit'] = '上載背景圖片的大小不能超過2M，請重新選擇';
$_LANG['controller__setting__uploadImgType'] = '上載的圖片文件不為PNG/JPG格式，請重新選擇';
$_LANG['controller__setting__copyImgError'] = '複製文件時出錯,上載失敗';
$_LANG['controller__setting__serverError'] = '伺服器錯誤，請稍候重試';

/// share
$_LANG['controller__share__paramNotUrl'] = '參數不存在url';
$_LANG['controller__share__fromWho'] = '（分享自 @%s）';

/// 詳細微博頁面
$_LANG['controller__show__weiboDelOrShielding'] = '該微博已被刪除或屏蔽';

///
$_LANG['controller__show__notAdmin'] = '不是管理員';
$_LANG['controller__show__missParameter'] = '缺少參數';
$_LANG['controller__show__apiError'] = '介面出錯';
$_LANG['controller__show__shieldWeibo'] = '屏蔽微博失敗,可能該微博已經在屏蔽列表';
$_LANG['controller__show__weiboIdNotAllowEmpty'] = '微博ID不能為空';
$_LANG['controller__show__reportContentEmpty'] = '舉報內容不能為空';

/// ta
$_LANG['controller__ta__haveBlocked'] = '對不起，該用戶已經被屏蔽了';

/// controller 公共使用的
$_LANG['controller__common__pageNotExist'] = '抱歉你所訪問的頁面不存在';
$_LANG['controller__common__liveNotExist'] = '抱歉你所訪問的直播不存在';
$_LANG['controller__common__interviewNotExist'] = '抱歉你所訪問的節目不存在';
$_LANG['controller__common__userNotExist'] = '抱歉你所訪問的用戶不存在';
$_LANG['controller__common__dataNotExist'] = '抱歉你所訪問的資料不存在';
$_LANG['controller__common__eventNotExist'] = '抱歉你所訪問的活動不存在';

/// 函數
$_LANG['function__error__serverBusy'] = '伺服器忙，請<a href="javascript:window.location.reload()">刷新</a>重試';
$_LANG['function__common__pageNotExist'] = '抱歉你所訪問的頁面不存在';

$_LANG['function__formatTime__secAgo'] = '%d秒前';
$_LANG['function__formatTime__minAgo'] = '%d分鐘前';
$_LANG['function__formatTime__todayTime'] = '今天 %s';
$_LANG['function__formatTime__monDay'] = '%s月%s日 %s';
$_LANG['function__formatTime__yearMonDay'] = '%s年%s月%s日 %s';
$_LANG['function__formatTime__showTimeSun'] = '周日';
$_LANG['function__formatTime__showTimeMon'] = '週一';
$_LANG['function__formatTime__showTimeTues'] = '週二';
$_LANG['function__formatTime__showTimeWed'] = '週三';
$_LANG['function__formatTime__showTimeThur'] = '週四';
$_LANG['function__formatTime__showTimeFri'] = '週五';
$_LANG['function__formatTime__showTimeSatur'] = '週五';
$_LANG['function__formatTime__showTimeFormat'] = '%s年%s月%s日 %s %s';

$_LANG['function__mblogHtml__weibo'] = '我</a>：%s</p>';
$_LANG['function__mblogHtml__orRepost'] = '原文轉發';
$_LANG['function__mblogHtml__orComment'] = '原文評論';
$_LANG['function__mblogHtml__delete'] = '刪除';
$_LANG['function__mblogHtml__repost'] = '轉發';
$_LANG['function__mblogHtml__favs'] = '收藏';
$_LANG['function__mblogHtml__comment'] = '評論';
$_LANG['function__mblogHtml__source'] = '來自 %s';

$_LANG['function__shareWeibo__shareEventWeibo'] = '我發現了一個很棒的活動“%s”　地點：%s　時間：%s年%s月%s日　活動鏈接：%s'; 
$_LANG['function__shareWeibo__shareEventAttend'] = '我剛剛參加了一個很棒的活動“%s”　地點：%s　時間：%s年%s月%s日　活動鏈接：%s'; 
$_LANG['function__shareWeibo__shareLiveWeibo'] = '給大家推薦一個不錯的直播，來看看吧：“%s”，直播時間%s-%s，特邀嘉賓%s，直播地址：%s';
$_LANG['function__shareWeibo__shareLiveTip'] = '提醒：“<a href="%s">%s</a>“將在%s分鐘後開始，請您關注';
$_LANG['function__shareWeibo__shareInterviewWeibo'] = '給大家推薦一個不錯的訪談，來看看吧：“%s”，訪談時間%s-%s，訪談嘉賓%s ，訪談地址：%s';
$_LANG['function__shareWeibo__shareInterviewTip'] = '提醒：線上訪談 “<a href="%s">%s</a>“ 將在(%s)分後開始，請您關注';

$_LANG['function__showAd__close'] = '關閉';

$_LANG['function__userFilter__missParams'] = '被檢查的資料缺少必要的資料項目';

$_LANG['function__verified__sinaVerify'] = '新浪認證';
$_LANG['function__verified__sinaVerifyTip1'] = '<img src="%s" alt="新浪認證" title="新浪認證" />';
$_LANG['function__verified__sinaVerifyTip2'] = '<div class="vip-card"><img src="%s" alt="新浪認證" title="新浪認證" /></div>';
$_LANG['function__verified__verifyTitle'] = '認證';

$_LANG['core__dsMgr__class_authorizationFail'] = '獲取授權資訊失敗';
/// 頁面標題
$_LANG['pageTitle__comDemo__title'] = '%s的Baby is %s';
$_LANG['pageTitle__pub__title'] = '微博廣場';
$_LANG['pageTitle__pubLook__title'] = '隨便看看';
$_LANG['pageTitle__pubTopic__title'] = '話題排行榜';
$_LANG['pageTitle__pubHotForward__title'] = '熱門轉發';
$_LANG['pageTitle__pubHotComments__title'] = '熱門評論';
$_LANG['pageTitle__searchRecommend__title'] = '可能感興趣的人';
$_LANG['pageTitle__search__title'] = '綜合搜索';
$_LANG['pageTitle__searchUser__title'] = '用戶搜索';
$_LANG['pageTitle__searchWeibo__title'] = '微博搜索';
$_LANG['pageTitle__index__title'] = '我的首頁';
$_LANG['pageTitle__accountLogin__title'] = '登入方式選擇';
$_LANG['pageTitle__accountBind__title'] = '綁定授權- 新浪微博';
$_LANG['pageTitle__accountIsBinded__title'] = '重新綁定授權';
$_LANG['pageTitle__indexAtme__title'] = '提到我的';
$_LANG['pageTitle__indexComments__title'] = '我的評論';
$_LANG['pageTitle__indexCommentsend__title'] = '我的評論';
$_LANG['pageTitle__indexMessages__title'] = '我的私信';
$_LANG['pageTitle__indexNotices__title'] = '我的通知';
$_LANG['pageTitle__indexFavorites__title'] = '我的收藏';
$_LANG['pageTitle__indexProfile__title'] = '我的微博';
$_LANG['pageTitle__indexFans__title'] = '我的粉絲';
$_LANG['pageTitle__indexFollow__title'] = '我的關注';
$_LANG['pageTitle__indexSetinfo__title'] = '設定';
$_LANG['pageTitle__indexInfo__title'] = '詳細資訊';
$_LANG['pageTitle__ta__title'] = '%s的微博';
$_LANG['pageTitle__taProfile__title'] = '%s的微博';
$_LANG['pageTitle__taFans__title'] = '關注%s的人';
$_LANG['pageTitle__taFollow__title'] = '%s關注的人';
$_LANG['pageTitle__taMention__title'] = '提到%s的微博';
$_LANG['pageTitle__setting__title'] = '個人資料設定';
$_LANG['pageTitle__settingUser__title'] = '個人資料設定';
$_LANG['pageTitle__settingTag__title'] = '個人標籤設定';
$_LANG['pageTitle__settingMyface__title'] = '頭像設定';
$_LANG['pageTitle__settingShow__title'] = '顯示設定';
$_LANG['pageTitle__settingBlacklist__title'] = '黑名單';
$_LANG['pageTitle__settingNotice__title'] = '提醒設定';
$_LANG['pageTitle__settingAccount__title'] = '帳號設定';
$_LANG['pageTitle__settingDomain__title'] = '個性域名';
$_LANG['pageTitle__show__title'] = '%s的微博';
$_LANG['pageTitle__showRepos__title'] = '%s的微博';
$_LANG['pageTitle__event__title'] = '活動';
$_LANG['pageTitle__eventMine__title'] = '我的活動';
$_LANG['pageTitle__eventDetails__title'] = '%s';
$_LANG['pageTitle__eventMember__title'] = '%s';
$_LANG['pageTitle__eventCreate__title'] = '發起活動';
$_LANG['pageTitle__eventModify__title'] = '編輯活動';
$_LANG['pageTitle__live__title'] = '線上直播';
$_LANG['pageTitle__liveDetails__title'] = '%s';
$_LANG['pageTitle__liveLivelist__title'] = '線上直播列表';
$_LANG['pageTitle__interview__title'] = '線上訪談';
$_LANG['pageTitle__interviewPage__title'] = '線上訪談列表';
$_LANG['pageTitle__wbcomViewPhoto__title'] = '查看圖片';
$_LANG['pageTitle__wbcomReplyComment__title'] = '回覆微博';
$_LANG['pageTitle__wbcomSendWBFrm__title'] = '發微博';
$_LANG['pageTitle__wbcomSendMsgFrm__title'] = '發私信';
$_LANG['pageTitle__accountShowLogin__title'] = '登入微博';

/// 首頁 - 我的首頁
$_LANG['index__default__emptyWeiboTip'] = '您還沒有微博資訊。';
$_LANG['index__default__endPageTip'] = '已到最後一頁';
$_LANG['index__default__showMoreWeiboTip'] = '想看更多微博？<br />你可以<a href="%s">關注更多的人</a>，或者在<a href="%s">上方輸入框</a>裡，說說身邊的新鮮事兒。';
$_LANG['index__default__notFoundTip'] = '找不到符合條件的微博，返回查看<a href="%s">全部微博</a>';
$_LANG['index__default__listTitle'] = '我的首頁';
$_LANG['index__default__skinSetTitle'] = '模板設定';
$_LANG['index__default__closeTips'] = '點擊關閉';
$_LANG['index__default__componmentHome'] = '我的首頁';

/// 首頁 - 提到我的
$_LANG['index__atme__notFoundTip'] = '找不到符合條件的微博，返回查看<a href="%s">全部微博</a>';
$_LANG['index__atme__listTitle'] = '提到我的';
$_LANG['index__atme__emptyWeiboTip'] = '目前，還沒有人提到你呢，敬請期待。';

/// 首頁 - 評論
$_LANG['index__comment__mycomments'] = '我的評論';
$_LANG['index__comment__comments'] = '收到的評論';
$_LANG['index__comment__commentsend'] = '發出的評論';

/// 首頁 - 我的粉絲
$_LANG['index__fans__myFans'] = '我的粉絲';

/// 首頁 - 我的關注
$_LANG['index__follow__myFollow'] = '我的關注';

/// 首頁 - 我的收藏
$_LANG['index__favs__notFoundTip'] = '還沒有收藏任何微博';
$_LANG['index__favs__emptyFavsTip'] = '還沒有收藏任何微博';
$_LANG['index__favs__listTitle'] = '我的收藏';

/// 首頁 - 我的私信
$_LANG['index__message__listTitle'] = '我的私信';
$_LANG['index__message__listTip'] = '溫馨提示：私信的接收方必須是發送方的粉絲';
$_LANG['index__message__sendMessage'] = '發私信';

/// 首頁 - 我的通知
$_LANG['index__notice__myNotice'] = '我的通知';
$_LANG['index__notice__listTitle'] = '我收到的通知';
$_LANG['index__notice__emptyNoticeTip'] = '還沒有收到任何通知';

/// ta - 粉絲
$_LANG['ta__fans__taFans'] = '的粉絲';

/// ta - 關注
$_LANG['ta__follow__taFollow'] = '的關注';

/// 活動
$_LANG['events__defaultAction__event'] = '活動';
$_LANG['events__defaultAction__hotRec'] = '熱門推薦';
$_LANG['events__defaultAction__myEvent'] = '我的活動';
$_LANG['events__myEvent__eventTitle'] = '活動';
$_LANG['events__myEvent__hotRec'] = '熱門推薦';
$_LANG['events__myEvent__myEvent'] = '我的活動';
$_LANG['events__myEvent__myAttend'] = '我參加的';
$_LANG['events__myEvent__myCreate'] = '我發起的';
$_LANG['events__eventList__allNewsEvent'] = '全部活動';
$_LANG['events__common__back'] = '返回';
$_LANG['events__common__create'] = '發起活動';

/// 登入
$_LANG['login__account__chooseLoginWay'] = '您還沒有登入，請選擇登入方式：';
$_LANG['login__account__loginTip'] = '登入';
$_LANG['login__account__regTip'] = '註冊帳號';
$_LANG['login__account__weiboAccount'] = '新浪微博帳號';
$_LANG['login__account__otherAccount'] = '%s或新浪微博帳號';
$_LANG['login__account__weiboAccountLogin'] = '新浪微博帳號登入';
$_LANG['login__account__regWeiboTip'] = '開通微博';
$_LANG['login__account__chooseAccountLogin'] = '提示：您可以使用%s登入本網站';
$_LANG['login__account__feedback'] = '回饋';
$_LANG['login__account__help'] = '幫助';
$_LANG['login__account__goRegWeibo'] = '立即註冊微博';
$_LANG['login__account__whyToRegWeibo'] = '上億的用戶在使用，你還在猶豫什麼';
$_LANG['login__account__goLogin'] = '立即登入';
$_LANG['login__account__theyAreHere'] = '他們在微博';
$_LANG['login__account__theyAreSay'] = '他們在說';
$_LANG['login__account__popularRec'] = '人氣推薦';

/// 隨便看看
$_LANG['lookLook__pub__change'] = '換一批';
$_LANG['lookLook__pug__casualLookTitle'] = '隨便看看';
$_LANG['lookLook__pug__casualLook'] = '隨便看看';
$_LANG['lookLook__pug__errorMsg'] = '“隨便看看”模組遇到問題：%s （錯誤代碼： %s ）';

/// 詳細微博頁
$_LANG['mblogDetail__show__myTitle'] = '我';
$_LANG['mblogDetail__show__aWeibo'] = '的微博';

/// pub
$_LANG['pubTopic__pub__localTopicTop'] = '本站話題排行榜';
$_LANG['pubTopic__pub__weiboTopicTop'] = '新浪微博話題排行榜';
$_LANG['pubTopic__pub__oneHourTopicTop'] = '1小時話題榜';
$_LANG['pubTopic__pub__todayTopicTop'] = '今日話題榜';
$_LANG['pubTopic__pub__weekTopicTop'] = '本周話題榜';

/// 設定
$_LANG['setting__setting__baseInfo'] = '基本資料';
$_LANG['setting__setting__perTags'] = '個人標籤';
$_LANG['setting__setting__noticeTip'] = '以下資訊將顯示在您的<a href="%s">微博頁</a>，方便大家瞭解你。';
$_LANG['setting__setting__errorTips'] = '無法獲取使用者資訊';

/// 名人堂
$_LANG['celeb__starChildSortList__other'] = '其他';
$_LANG['celeb__starChildSortList__fameTitle'] = '%s - 名人堂';
$_LANG['celeb__starChildSortList__fame'] = '名人堂';
$_LANG['celeb__starChildSortList__categoryEmptyTip'] = '此分類暫無數據';
$_LANG['celeb__starChildSortList__letterSearch'] = '按字母檢索';

///  線上訪談
$_LANG['interview__page__titleTip'] = '精彩訪談';
$_LANG['interview__page__remindMeTip'] = '線上訪談 "%s" 即將開始';
$_LANG['interview__page__remindMe'] = '提醒我';
$_LANG['interview__page__notStarted'] = '<span class="unplayed">(未開始)</span>';
$_LANG['interview__page__end'] = '<span class="finish">(已結束)</span>';
$_LANG['interview__page__going'] = '<span class="active">(進行中)</span>';
$_LANG['interview__page__adminEmptyTip'] = '還沒有線上訪談，你可以在 後臺管理中心-擴展工具-線上訪談 添加設定';
$_LANG['interview__page__emptyTip'] = '還沒有線上訪談，你可以看看其他頁面。 ';

/// 搜索
$_LANG['search__defaultAction__seeAll'] = '查看全部';
$_LANG['search__defaultAction__fromSina'] = '來自新浪';
$_LANG['search__defaultAction__local'] = '本站';
$_LANG['search__defaultAction__emptySearch'] = '找不到符合條件的微博，請輸入其他關鍵字再試';

$_LANG['search__weibo__fromSina'] = '來自新浪';
$_LANG['search__weibo__local'] = '本站';
$_LANG['search__weibo__seeAll'] = '全部';
$_LANG['search__weibo__text'] = '文字';
$_LANG['search__weibo__pic'] = '圖片';
$_LANG['search__weibo__video'] = '視頻';
$_LANG['search__weibo__title'] = '找到的微博如下';
$_LANG['search__weibo__emptySearch'] = '找不到符合條件的微博，請輸入其他關鍵字再試';

$_LANG['search__user__fromSina'] = '來自新浪';
$_LANG['search__user__local'] = '本站';
$_LANG['search__user__emptySearch'] = '找不到符合條件的用戶，請輸入其他關鍵字再試';

/// include
$_LANG['include__header__searchTip'] = '搜微博/找人';
$_LANG['include__header__set'] = '設定';
$_LANG['include__header__skin'] = '換背景';
$_LANG['include__header__feedback'] = '建議';
$_LANG['include__header__centralAdmin'] = '<a class="manage" href="%s"  target="_blank">管理中心</a>|';
$_LANG['include__header__logout'] = '登出';
$_LANG['include__header__bindSinaWeibo'] = '綁定SINA微博';
$_LANG['include__header__login'] = '登入';
$_LANG['include__header__ideas'] = '有意見？有想法？那就來吧！';
$_LANG['include__header__anonymous'] = '匿名';
$_LANG['include__header__inputContent'] = '請輸入意見內容';
$_LANG['include__header__contact'] = '聯絡方式：';
$_LANG['include__header__email'] = '郵箱地址';
$_LANG['include__header__inputContact'] = '請留下您的聯絡方式，方便我們及時回饋資訊給您';
$_LANG['include__header__submit'] = '提交';
$_LANG['include__header__inputContent'] = '請輸入意見內容';
$_LANG['include__header__close'] = '關閉';
$_LANG['include__header__contentLimit'] = '不能超過250個漢字';
$_LANG['include__header__phone'] = '聯繫電話';

/// site nav
$_LANG['include__siteNav__myWeibo'] = '我的微博';
$_LANG['include__siteNav__myMessage'] = '我的消息';
$_LANG['include__siteNav__myFavs'] = '我的收藏';
///////////////////////////////////////////////////////////////////////////////////
/// pls

$_LANG['pls__common__userSkin__defaultTitle'] = '默認';
/// 我 ta - 微博
$_LANG['pls__userTimeline__profile__emptyWeiboTip'] = '%s 還沒有開始發微博，請等待。';
$_LANG['pls__userTimeline__profile__notFoundTip'] = '找不到符合條件的微博，返回查看<a href="%s">全部微博</a>';
$_LANG['pls__myUserTimeline__profile__listTitle'] = '我的微博';
$_LANG['pls__userTimeline__profile__listTitle'] = '%s的微博';

/// 活動 pls
$_LANG['pls__eventComment__emptyCommentTip'] = '暫時沒有評論';

/// interview 線上訪談
$_LANG['pls__intervies__indexList__timeFormat'] = 'm月d日 H:i';

/// live 線上直播
$_LANG['pls__live__liveIndexList__day'] = '%s天';
$_LANG['pls__live__liveIndexList__hour'] = '%s小時';
$_LANG['pls__live__liveIndexList__min'] = '%s分';
$_LANG['pls__live__liveIndexList__sec'] = '%s秒';
$_LANG['pls__live__liveWblist__endTip'] = '直播內容<span><label for="only"><input type="checkbox" name="gMtype" value="1" id="only">只看嘉賓和主持人</label></span><span class="close">(已結束)</span>';
$_LANG['pls__live__liveWblist__startTip'] = '直播內容<span><label for="only"><input type="checkbox" name="gMtype" value="1" id="only">只看嘉賓和主持人</label></span><span>(共有<span id="liveWbNum">%s</span>條)</span>';
$_LANG['pls__live__liveWblist__emptyLiveTip'] = '暫時沒有相關的話題微博';

/// 粉絲
$_LANG['pls__users__fansList__women'] = '她';
$_LANG['pls__users__fansList__men'] = '他';
$_LANG['pls__users__fansList__myEmptyNoticeTip'] = '真悲劇，還沒有人關注你，你可以試試多<a href="%s">關注別人</a>。';
$_LANG['pls__users__fansList__taEmptyNoticeTip'] = '還沒人關注%s，你可憐一下%s吧，關注一下';
$_LANG['pls__users__followersList__myEmptyNoticeTip'] = '你還沒有關注任何人';
$_LANG['pls__users__followersList__taEmptyNoticeTip'] = '%s還沒有關注任何人';

/// 推薦
$_LANG['pls__users__recommendUserWeight__title'] = '推薦關注以下用戶';

/// 感興趣
$_LANG['pls__users__interestUsers__title'] = '你可能感興趣的人';

/// 組件 component
/// 使用者組模組
$_LANG['pls__component11__categoryUser__getGroupsError'] = 'components/categoryUser.getGroups 從資料庫中獲取失敗或者無數據';
$_LANG['pls__component11__categoryUser__getError'] = 'components/categoryUser.get返回錯誤的非陣列類型資料。錯誤資訊：%s(Errno: %s)';

/// 話題模組
$_LANG['pls__component12__todayTopic__apiError'] = 'components/todayTopic.getTopicWB 返回API錯誤：%s(%s)';
$_LANG['pls__component12__todayTopic__dbError'] = 'components/todayTopic.getTopicWB 返回錯誤的非陣列資料類型或者返回資料為空';

/// banner模組
$_LANG['pls__component13__banner__emptyTip'] = '無圖片';

/// 最新微博模組
$_LANG['pls__component14__pubTimeline__apiError'] = 'components/pubTimelineBaseApp.get返回API錯誤：%s(%s)';

/// 最新開通微博的用戶列表
$_LANG['pls__component15__newestWbUser__emptyTip'] = '無本站最新開通微博的資料，或者緩存返回錯誤的非陣列資料類型。';

/// 明星推薦列表
$_LANG['pls__component2__star__apiError'] = 'components/star.get 返回API錯誤：%s(%s)';
$_LANG['pls__component2__star__dbError'] = 'components/star.get 無數據。';
$_LANG['pls__component2__star__Error'] = 'components/star.get 返回錯誤的非陣列類型資料。';

/// 使用者推薦模組
$_LANG['pls__component3__recommentUser__getError'] = 'components/recommendUser.get 返回錯誤的非陣列類型資料。';

/// 人氣關注榜模組
$_LANG['pls__component4__concern__getError'] = 'components/concern.get 從資料庫獲取錯誤：資料為空或者返回錯誤的非陣列資料。';

/// 微博頻道模組
$_LANG['pls__component5__listIdEmptyTip'] = 'ListId為空';
$_LANG['pls__component5__list__apiError'] = 'API返回不存在用戶列表。';
$_LANG['pls__component5__getUsers__error'] = '獲取components/officialWB.getUsers失敗或為空，故不再獲取微博列表。components/officialWB.getUsers錯誤資訊：%s';

/// 熱門話題清單模組
$_LANG['pls__component6__hotTopic__error'] = 'components/hotTopic.get 返回錯誤的非陣列類型資料。';

/// 可能感興趣的人
$_LANG['pls__component7__guessYouLike__apiError'] = 'components/guessYouLike.get 返回API錯誤：%s(%s)';
$_LANG['pls__component7__guessYouLike__dbError'] = 'components/guessYouLike.get返回列表為空。';
$_LANG['pls__component7__guessYouLike__Error'] = 'components/guessYouLike.get 返回錯誤的非陣列類型資料！';

/// 同城微博模組
$_LANG['pls__component8__getProvinces__apiError'] = 'xweibo/xwb.getProvinces 返回API錯誤：%s(%s)';
$_LANG['pls__component8__cityWB__apiError'] = 'components/cityWB.get 返回API錯誤：%s(%s)';

/// 隨便看看模組
$_LANG['pls__component9__pubTimeline__apiError'] = 'components/pubTimeline.get 錯誤：%s(%s)';
$_LANG['pls__component9__pubTimeline__dbError'] = 'components/pubTimeline.get返回錯誤的非陣列類型資料！';
$_LANG['pls__component9__pubTimeline__error'] = 'components/pubTimeline.get沒有資料';

///当前站点最新微博模块
$_LANG['pls__component14__login__emptyTip'] = '還沒有人發言哦，趕緊去說點什麼吧';

/// 模組pipe基礎
$_LANG['pls__component__abstract__errorMsg'] = '未填寫問題原因';
$_LANG['pls__component__abstract__emptyTitle'] = '未知模組';
$_LANG['pls__component__abstract__apiError'] = '<div class="int-box ico-load-fail">%s（模組ID：%s）遇到問題：%s</div>';

/// 各類別模組通用pipe
$_LANG['pls__component__common__hotWB_emptyTip'] = '還沒有熱門微博。';
$_LANG['pls__component__common__hotWB_apiError'] = 'components/hotWB.getComment 返回API錯誤：%s(%s)';
$_LANG['pls__component__common__hotWB_dbError'] = '獲取熱門微博資訊失敗，請<a href="#" rel="e:rl">刷新</a>再試!';
///////////////////////////////////////////////////////////////////////////////////

/// modules template

$_LANG['modules__ajaxUsers__profileImage'] = '%s的頭像';

/// 黑名單
$_LANG['modules__blockUserList__pageTip'] = '已到最後一頁';

/// 綁定
$_LANG['modules__bindAccount__bindWeiboTitle'] = '帳號綁定';
$_LANG['modules__bindAccount__bindWeibo'] = '登入成功，繼續操作需綁定新浪微博帳號';
$_LANG['modules__bindAccount__whyBind'] = '為什麼要進行帳號綁定？';
$_LANG['modules__bindAccount__noticeUseful'] = '%s基於新浪微博開發，您需要綁定一個新浪微博帳號，方可使用全部功能。';
$_LANG['modules__bindAccount__needBind'] = '每次登入都需要綁定嗎？';
$_LANG['modules__bindAccount__onlyOne'] = '不需要，您只需要綁定一次，之後就可以直接進入%s了！';
$_LANG['modules__bindAccount__noWeibo'] = '沒有新浪微博帳號怎麼辦？';
$_LANG['modules__bindAccount__clickToRegWeibo'] = '點擊這裡註冊，只需1分鐘！';
$_LANG['modules__bindAccount__regWeibo'] = '註冊新浪微博帳號';

/// 評論
$_LANG['modules__comment__pageTip'] = '已到最後一頁';
$_LANG['modules__comment__myComment'] = '暫時還沒有收到任何評論';
$_LANG['modules__comment__CommentSend'] = '暫時還沒有發出任何評論';
$_LANG['modules__comment__selectAll'] = '全選';
$_LANG['modules__comment__delete'] = '刪除';
$_LANG['modules__comment__reply'] = '回覆';
$_LANG['modules__comment__replyWeibo'] = '回覆微博：';

/// 發起活動
$_LANG['modules__evnetForm__title'] = '活動標題：';
$_LANG['modules__evnetForm__titleMsg'] = '請填寫活動標題';
$_LANG['modules__evnetForm__titleLengthMsg'] = '不能超過20個漢字';
$_LANG['modules__evnetForm__phone'] = '聯絡方式：';
$_LANG['modules__evnetForm__phoneMsg'] = '請填寫聯繫電話';
$_LANG['modules__eventForm__realname'] = '連絡人：';
$_LANG['modules__eventForm__realnameMsg'] = '請填寫真實姓名';
$_LANG['modules__evnetForm__addr'] = '活動地點：';
$_LANG['modules__evnetForm__addrMsg'] = '請填寫活動地點';
$_LANG['modules__evnetForm__addrTooLongMsg'] = '不能超過30個漢字';
$_LANG['modules__evnetForm__startTime'] = '開始時間：';
$_LANG['modules__eventForm__startTimeMsg'] = '請填寫開始時間';
$_LANG['modules__eventForm__endTime'] = '結束時間：';
$_LANG['modules__eventForm__endTimeMsg'] = '請填寫結束時間';
$_LANG['modules__eventForm__cost'] = '人均費用：';
$_LANG['modules__eventForm__freeCost'] = '免費';
$_LANG['modules__eventForm__cost__units'] = '元';
$_LANG['modules__eventForm__costMsg'] = '請填寫人均費用';
$_LANG['modules__eventForm__other'] = '其他要求：';
$_LANG['modules__eventForm__otherTip'] = '要求參與者填寫聯絡方式和簡單說明';
$_LANG['modules__eventForm__desc'] = '活動介紹：';
$_LANG['modules__eventForm__descMsg'] = '請填寫活動介紹';
$_LANG['modules__eventForm__descLengthMsg'] = '最多2000字';
$_LANG['modules__eventForm__pic'] = '封面：';
$_LANG['modules__eventForm__uploading'] = '上載中...';
$_LANG['modules__eventForm__picReq'] = '請上載小於1M的JPG、PNG、GIF格式圖片，尺寸為120*120PX';
$_LANG['modules__eventForm__submit'] = '確認';

/// 評論活動
$_LANG['modules__eventComment__topic'] = '關於<a href="%s">%s</a>的討論';
$_LANG['modules__eventComment__publish'] = '發佈';
$_LANG['modules__eventComment__length'] = '還可以輸入140個字';

/// 活動詳細頁面
$_LANG['modules__eventInfo__eventPic'] = '活動封面';
$_LANG['modules__eventInfo__eventTime'] = '時　　間：';
$_LANG['modules__eventInfo__eventAddr'] = '地　　點：';
$_LANG['modules__eventInfo__eventName'] = '發<i></i>起<i></i>者：';
$_LANG['modules__eventInfo__eventPhone'] = '聯絡方式：';
$_LANG['modules__eventInfo__eventState'] = '狀　　態：';
$_LANG['modules__eventInfo__eventStateClose'] = '關閉';
$_LANG['modules__eventInfo__eventStateBan'] = '封禁';
$_LANG['modules__eventInfo__eventStateComplete'] = '已完成';
$_LANG['modules__eventInfo__eventStateRec'] = '推薦';
$_LANG['modules__eventInfo__eventStateGoing'] = '正常進行中';
$_LANG['modules__eventInfo__eventStateNotStart'] = '活動報名中';
$_LANG['modules__eventInfo__eventJoinNum'] = '參加人數：';
$_LANG['modules__eventInfo__eventShare'] = '分享到我的微博';
$_LANG['modules__eventInfo__eventJoined'] = '已參加';
$_LANG['modules__eventInfo__eventToJoin'] = '我要參加';
$_LANG['modules__eventInfo__eventDesc'] = '活動簡介:';
$_LANG['modules__eventInfo__eventJoinMemberNum'] = '這個活動的參加者：<span>共<a href="%s">%s</a>人</span>';
$_LANG['modules__eventInfo__eventMemberFollowed'] = '已關注';
$_LANG['modules__eventInfo__eventMemberToFollow'] = '加關注';

/// 活動清單頁面
$_LANG['modules__eventList__eventPic'] = '活動封面';
$_LANG['modules__eventList__eventTime'] = '時　　間：';
$_LANG['modules__eventList__eventAddr'] = '地　　點：';
$_LANG['modules__eventList__eventName'] = '發<i></i>起<i></i>者：';
$_LANG['modules__eventList__eventPhone'] = '聯絡方式：';
$_LANG['modules__eventList__eventState'] = '狀　　態：';
$_LANG['modules__eventList__eventStateClose'] = '關閉';
$_LANG['modules__eventList__eventStateBan'] = '封禁';
$_LANG['modules__eventList__eventStateComplete'] = '已完成';
$_LANG['modules__eventList__eventStateRec'] = '推薦';
$_LANG['modules__eventList__eventStateGoing'] = '正常進行中';
$_LANG['modules__eventList__eventJoinNum'] = '參加人數：';
$_LANG['modules__eventList__eventShare'] = '分享到我的微博';
$_LANG['modules__eventList__eventJoined'] = '已參加';
$_LANG['modules__eventList__eventToJoin'] = '我要參加';
$_LANG['modules__eventList__eventClose'] = '關閉';
$_LANG['modules__eventList__eventEdit'] = '編輯';
$_LANG['modules__eventList__eventDelete'] = '刪除';
$_LANG['modules__eventList__eventDesc'] = '活動簡介:';
$_LANG['modules__eventList__eventJoinMemberNum'] = '這個活動的參加者：<span>共<a href="%s">%s</a>人</span>';
$_LANG['modules__eventList__eventMemberFollowed'] = '已關注';
$_LANG['modules__eventList__eventMemberToFollow'] = '加關注';
$_LANG['modules__eventList__myEventEmptyTip'] = '我沒有發起過活動';
$_LANG['modules__eventList__myAttendEventEmptyTip'] = '我沒有參加過活動';
$_LANG['modules__eventList__eventEmptyTip'] = '暫時沒有任何活動';

/// 活動成員列表
$_LANG['modules__eventMembers__eventJoinMemberNum'] = '這個活動參與者<span>(共%s人)</span>';
$_LANG['modules__eventMembers__eventMemberFollowed'] = '已關注';
$_LANG['modules__eventMembers__eventMemberToFollow'] = '加關注';
$_LANG['modules__eventMembers__eventPhone'] = '聯絡方式：';
$_LANG['modules__eventMembers__eventNotes'] = '備註：';

/// feed
$_LANG['modules__feed__master'] = '主持人';
$_LANG['modules__feed__guest'] = '嘉賓';
$_LANG['modules__feed__repost'] = '轉發';
$_LANG['modules__feed__comment'] = '評論';
$_LANG['modules__feed__retError1'] = '內容有錯！';
$_LANG['modules__feed__retError2'] = '該用戶已經被屏蔽';
$_LANG['modules__feed__retError3'] = '原微博已被屏蔽';
$_LANG['modules__feed__retRepost'] = '原文轉發';
$_LANG['modules__feed__retComment'] = '原文評論';
$_LANG['modules__feed__delete'] = '刪除';
$_LANG['modules__feed__fav'] = '收藏';
$_LANG['modules__feed__unfav'] = '取消收藏';
$_LANG['modules__feed__source'] = '來自 %s';
$_LANG['modules__feed__informationIsNotAudited'] = '信息未審核';
$_LANG['modules__feed__report'] = '舉報';
$_LANG['modules__feed__blocked'] = '已屏蔽';
$_LANG['modules__feed__blockWeibo'] = '屏蔽該微博';

/// feedlist 模組
$_LANG['modules__feedList__emptyTip'] = '該模組下沒有微博，<a href="#" rel="e:rl">刷新</a>試試？';

/// inhibit
$_LANG['modules__inhibit__loginError'] = '登入失敗!';
$_LANG['modules__inhibit__reason'] = '原因：您已經被禁止訪問此網站';

/// input
$_LANG['modules__input__inputTitle'] = '有什麼新鮮事告訴大家？';
$_LANG['modules__input__inputLength'] = '您還可以輸入<span>140</span>字';
$_LANG['modules__input__inputFace'] = '表情';
$_LANG['modules__input__inputUploading'] = '正在上載..';
$_LANG['modules__input__inputImage'] = '圖片';
$_LANG['modules__input__inputVideo'] = '視頻';
$_LANG['modules__input__inputMusic'] = '音樂';
$_LANG['modules__input__inputTopic'] = '話題';
$_LANG['modules__input__inputSuccess'] = '發佈成功！';
$_LANG['modules__input__inputVerify'] = '資訊已進入審核中';
$_LANG['modules__input__inputReqLogin'] = '您需要綁定新浪微博帳號後才可以發佈，';
$_LANG['modules__input__inputGoBind'] = '現在就去綁定';

/// isbind
$_LANG['modules__isBind__agreement'] = '新浪網路服務使用協定';
$_LANG['modules__isBind__sinaWeibo'] = '新浪微博';
$_LANG['modules__isBind__changAccount'] = '您的<em>%s</em>新浪微博帳號已綁定過了，換個帳號試試吧';
$_LANG['modules__isBind__autoJumpTip'] = '[<span  id="time_sec">5</span>]秒後自動跳轉，如果流覽器沒有反應，請<a href="%s">點擊這裡</a>';


/// login
$_LANG['modules__login__loginWay'] = '您還沒有登入，請選擇登入方式：';
$_LANG['modules__login__whoLogin'] = '%s登入';
$_LANG['modules__login__regWeibo'] = '註冊帳號';
$_LANG['modules__login__weiboAccount'] = '新浪微博帳號';
$_LANG['modules__login__orWeiboAccount'] = '%s或新浪微博帳號';
$_LANG['modules__login__weiboAccountLogin'] = '新浪微博帳號登入';
$_LANG['modules__login__goSinaReg'] = '開通微博';
$_LANG['modeles__login__chooseLoginWayTip'] = '提示：您可以使用%s登入本網站';


/// 詳細微博頁
$_LANG['modules__mblog__pubComment'] = '發表評論';
$_LANG['modules__mblog__comment'] = '評論';
$_LANG['modules__mblog__inputLength'] = '您還可以輸入<span>70</span>字';
$_LANG['modules__mblog__atTheSameTimePubWeibo'] = '同時發一條微博';
$_LANG['modules__mblog__indexPage'] = '首頁';
$_LANG['modules__mblog__prePage'] = '上一頁';
$_LANG['modules__mblog__nextPage'] = '下一頁';

/// 推薦
$_LANG['modules__recommendGuide__hotRecTitle'] = '熱門推薦：';
$_LANG['modules__recommendGuide__hotRec'] = '熱門推薦';
$_LANG['modules__recommendGuide__chooseUsersNum'] = '已選擇了<span>0</span>個用戶';
$_LANG['modules__recommendGuide__ship'] = '跳過';

/// 推薦用戶
$_LANG['modules__recommendUserWeight__categoryUser'] = '分類用戶推薦'; 

/// 搜索用戶
$_LANG['modules__searchUser__emptyTip'] = '找不到符合條件的用戶，請輸入其他關鍵字再試';
$_LANG['modules__searchUser__followed'] = '已關注';
$_LANG['modules__searchUser__addFollow'] = '添加關注';
$_LANG['modules__searchUser__fansNum'] = '粉絲數：%s人';
$_LANG['modules__searchUser__desc'] = '簡介：';
$_LANG['modules__searchUser__tags'] = '標籤：';
$_LANG['modules__searchUser__lookUserTags'] = '查看該用戶的所有標籤';

/// 熱門活動
$_LANG['modules__sideHotEvents__moreTip'] = '更多';
$_LANG['modules__sideHotEvents__hotEvent'] = '熱門活動';

/// 最新活動
$_LANG['modules__sideNewsEvents__moreTip'] = '更多';
$_LANG['modules__sideNewsEvents__newsEvent'] = '最新活動';

$_LANG['modules__sideEvents__time'] = '時間：';

/// 側欄粉絲
$_LANG['modules__sidebarFans__whofansNum'] = '%s粉絲（%s）';
$_LANG['modules__sidebarFans__moreTip'] = '更多';

/// 私信
$_LANG['modules__message__endPage'] = '已到最後一頁';
$_LANG['modules__message__emptyTip'] = '還沒有收到或發出任何私信';
$_LANG['modules__message__meSendto'] = '<a href="%s"> 我</a>發送給';
$_LANG['modules__message__reply'] = '回覆';
$_LANG['modules__message__delete'] = '刪除';

/// 推薦使用者公用範本之：人物排列
$_LANG['modules__modFameList__profileImageUrl'] = '%s的頭像';
$_LANG['modules__modFameList__emptyTip'] = '暫無數據';

/// mod find
$_LANG['modules__modFind__findPeople'] = '找人';
$_LANG['modules__modFind__source'] = '本站及新浪微博';
$_LANG['modules__modFind__onlyLocal'] = '僅本站';
$_LANG['modules__modFind__inputSearch'] = '請輸入搜索條件！';

/// mod search
$_LANG['modules__modSearch__general'] = '綜合';
$_LANG['modules__modSearch__weibo'] = '微博';
$_LANG['modules__modSearch__user'] = '用戶';
$_LANG['modules__modSearch__search'] = '搜索';
$_LANG['modules__modSearch__nickname'] = '昵稱';
$_LANG['modules__modSearch__desc'] = '簡介';
$_LANG['modules__modSearch__tags'] = '標籤';
$_LANG['modules__modSearch__pubWeibo'] = '發微博';
$_LANG['modules__modSearch__attendTopic'] = '參與該話題';
$_LANG['modules__modSearch__followTopic'] = '關注該話題';
$_LANG['modules__modSearch__followed'] = '已關注';
$_LANG['modules__modSearch__cancelFollowed'] = '取消關注';

/// mode search user
$_LANG['modules__modSearchUserPre__seeAll'] = '查看全部';
$_LANG['modules__modSearchUserPre__sourceSina'] = '來自新浪';
$_LANG['modules__modSearchUserPre__local'] = '本站';
$_LANG['modules__modSearchUserPre__profileImageUrl'] = '%s的頭像';
$_LANG['modules__modSearchUserPre__emptyTip'] = '找不到符合條件的用戶，請輸入其他關鍵字再試';

/// notice
$_LANG['modules__notices__endPage'] = '已到最後一頁';
$_LANG['modules__notices__emptyTip'] = '還沒有收到任何通知';
$_LANG['modules__notices__admin'] = '管理員';

/// page link title p
$_LANG['modules__pageLink__pos'] = '當前位置：';

/// subject followed
$_LANG['modules__subjectFollowed__followedTopic'] = '關注的話題';
$_LANG['modules__subjectFollowed__emptyFollowedTopic'] = '他沒有關注任何話題';
$_LANG['modules__subjectFollowed__delete'] = '刪除';
$_LANG['modules__subjectFollowed__add'] = '添加';

/// user account
$_LANG['modules__userAccount__cancelBindTip'] = '您已經將新浪微博帳號與本網站綁定使用，您可以在本頁面取消此綁定關係。';
$_LANG['modules__userAccount__weiboSina'] = '微博帳號：';
$_LANG['modules__userAccount__cancelBind'] = '取消綁定';
$_LANG['modules__userAccount__aboutBind'] = '關於綁定：';
$_LANG['modules__userAccount__desc1'] = '將新浪微博帳號綁定網站之後，您可以在此網站上使用微博功能，並能與新浪微博共用資料。';
$_LANG['modules__userAccount__desc2'] = '取消綁定後，您將無法繼續在本網站使用微博相關功能。';
$_LANG['modules__userAccount__desc3'] = '當前正在使用新浪微博，如需修改密碼，請<a href="http://login.sina.com.cn/member/security/password.php" target="_blank">點擊</a>此處。';

/// user blacklist
$_LANG['modules__userBlackList__desc'] = '被加入黑名單的用戶將無法關注你、評論你。如果你已經關注他，也會自動解除關係。';
$_LANG['modules__userBlackList__emptyTip'] = '還沒有人被你拉入黑名單呢。';
$_LANG['modules__userBlackList__howToBlackUser'] = '如何將某個用戶加入自己的黑名單？';
$_LANG['modules__userBlackList__setBlackUser'] = '進入某個用戶的微博，在 @他 旁邊的“更多”下拉清單中可以進行設定。';
$_LANG['modules__userBlackList__blacked'] = '已被您加入黑名單的用戶：';
$_LANG['modules__userBlackList__cancelBlack'] = '解除';

/// user display edit
$_LANG['modules__userDisplayEdit__chooseViewWay'] = '請選擇以下情況的顯示方式';
$_LANG['modules__userDisplayEdit__pageWeiboCount'] = '每頁微博顯示數量';
$_LANG['modules__userDisplayEdit__pageWeiboViewCount'] = '請選擇在我的首頁、我的微博、TA的首頁、@提到我的頁面中，每頁顯示微博數量';
$_LANG['modules__userDisplayEdit__pageCommentCount'] = '每頁評論顯示數量';
$_LANG['modules__userDisplayEdit__pageCommentViewCount'] = '請選擇在我的評論、單條微博的全部評論頁面中，每頁顯示評論數量';
$_LANG['modules__userDisplayEdit__10'] = '10條';
$_LANG['modules__userDisplayEdit__20'] = '20條';
$_LANG['modules__userDisplayEdit__30'] = '30條';
$_LANG['modules__userDisplayEdit__40'] = '40條';
$_LANG['modules__userDisplayEdit__50'] = '50條';

/// user domain
$_LANG['modules__userDomain__setDomain'] = '你已經設定個性域名';
$_LANG['modules__userDomain__youDomain'] = '您的個性化域名是：';
$_LANG['modules__userDomain__addFavLink'] = '加入我的最愛';
$_LANG['modules__userDomain__inviteFollow'] = '邀請朋友關注我';
$_LANG['modules__userDomain__copyLink'] = '複製連接';
$_LANG['modules__userDomain__sendLink'] = '我將以上連接發給親朋好友，他們接受邀請後會成為你的粉絲。';
$_LANG['modules__userDomain__whySetDomain'] = '記得自己的微博客地址是什麼嗎？設定個性域名，讓朋友更容易記住！';
$_LANG['modules__userDomain__inputLength'] = '可以輸入6至20位的英文或數字（必須包含英文字符）';
$_LANG['modules__userDomain__saveNotAllowModify'] = '儲存後不得修改！';
$_LANG['modules__userDomain__setPerDomain'] = '設定個性域名';
$_LANG['modules__userDomain__domainPreview'] = '域名預覽：';
$_LANG['modules__userDomain__nameAlreadyToken'] = '域名已經被佔用！';

/// user head
$_LANG['modules__userHead__sendMessage'] = '發私信';
$_LANG['modules__userHead__talkToWho'] = '對 @%s 說';
$_LANG['modules__userHead__woman'] = '她';
$_LANG['modules__userHead__man'] = '他';
$_LANG['modules__userHead__more'] = '更多';
$_LANG['modules__userHead__mutualConcern'] = '相互關注';
$_LANG['modules__userHead__cancel'] = '取消';
$_LANG['modules__userHead__addBlack'] = '加入黑名單';
$_LANG['modules__userHead__blacked'] = '已加入黑名單';
$_LANG['modules__userHead__sureDelete'] = '確定將TA從你的黑名單移除？';
$_LANG['modules__userHead__pubWeibo'] = '我要發微博';

/// user header edit
$_LANG['modules__userHeaderEdit__choosePic'] = '請點擊“瀏覽”按鈕，選擇你電腦中的圖片作為微博頭像';
$_LANG['modules__userHeaderEdit__imageSize1'] = '你的圖片文件超出';
$_LANG['modules__userHeaderEdit__imageSize2'] = 'M或寬高超出2880像素，請選擇文件和尺寸較小的圖片';
$_LANG['modules__userHeaderEdit__imageTypeError'] = '圖片文件類型錯誤';
$_LANG['modules__userHeaderEdit__saveHeaderError'] = '儲存頭像出錯';
$_LANG['modules__userHeaderEdit__DamageImage'] = '損壞的圖片文件（擴展名與圖片類型不相符）';
$_LANG['modules__userHeaderEdit__imageUploading'] = '正在上載...';
$_LANG['modules__userHeaderEdit__notAllowModify'] = '抱歉，目前不允許修改個人頭像，請聯繫網站管理員！';
$_LANG['modules__userHeaderEdit__modifySuccess'] = '修改頭像成功';
$_LANG['modules__userHeaderEdit__chooseHeaderPic'] = '選擇照片';
$_LANG['modules__userHeaderEdit__loadingPicWaitFor'] = '正在讀取中，請稍候...';
$_LANG['modules__userHeaderEdit__browse'] = '瀏覽...';
$_LANG['modules__userHeaderEdit__imageUploadNotice1'] = '您上載的頭像會自動生成三種尺寸，\n請注意中小尺寸的頭像是否清晰';
$_LANG['modules__userHeaderEdit__imageUploadNotice2'] = '大尺寸頭像，180×180像素';
$_LANG['modules__userHeaderEdit__imageUploadNotice3'] = '中尺寸頭像\n50×50像素\n(自動生成)';
$_LANG['modules__userHeaderEdit__imageUploadNotice4'] = '小尺寸頭像\n30×30像素\n(自動生成)';
$_LANG['modules__userHeaderEdit__rotate'] = '向右旋轉';
$_LANG['modules__userHeaderEdit__rotateLeft'] = '向左旋轉';
$_LANG['modules__userHeaderEdit__imageTypeLimit'] = '僅支援JPG、GIF、PNG圖片文件，且文件小於';
$_LANG['modules__userHeaderEdit__editor'] = '編輯區';
$_LANG['modules__userHeaderEdit__previewArea'] = '預覽區';

/// user hot
$_LANG['modules__userHot__starRec'] = '名人推薦';
$_LANG['modules__userHot__profileImageUrl'] = '%s的頭像';

/// user info edit
$_LANG['modules__userInfoEdit__baseInfo'] = '基本資料';
$_LANG['modules__userInfoEdit__tags'] = '個人標籤';
$_LANG['modules__userInfoEdit__mustOption'] = '為必填項';
$_LANG['modules__userInfoEdit__nickname'] = ' 昵稱：';
$_LANG['modules__userInfoEdit__inputNick'] = '請輸入昵稱';
$_LANG['modules__userInfoEdit__nickLength'] = '大於4個字母，不超過20個字母或10個漢字';
$_LANG['modules__userInfoEdit__addr'] = ' 所在地：';
$_LANG['modules__userInfoEdit__inputAddr'] = '請選擇所在地';
$_LANG['modules__userInfoEdit__choosePro'] = '省/直轄市';
$_LANG['modules__userInfoEdit__chooseCity'] = '城市/地區';
$_LANG['modules__userInfoEdit__sex'] = ' 性別：';
$_LANG['modules__userInfoEdit__m'] = ' 男';
$_LANG['modules__userInfoEdit__f'] = ' 女';
$_LANG['modules__userInfoEdit__desc'] = '一句話介紹：';
$_LANG['modules__userInfoEdit__descLengthLimit'] = '長度超過限制';

/// user list
$_LANG['modules__userList__profileImageUrl'] = '%s的頭像';

/// user menu
$_LANG['modules__userMenu__myIndex'] = '我的首頁';
$_LANG['modules__userMenu__atMe'] = '提到我的';
$_LANG['modules__userMenu__myComment'] = '我的評論';
$_LANG['modules__userMenu__myMessage'] = '我的私信';
$_LANG['modules__userMenu__myNotice'] = '我的通知';
$_LANG['modules__userMenu__myFavs'] = '我的收藏';

/// user notice
$_LANG['modules__userNotice__setNoticeWay'] = '設定您想要的提醒方式，隨時隨地接收微博的更新。';
$_LANG['modules__userNotice__needTip'] = '哪些內容通過微博小黃籤提示我';
$_LANG['modules__userNotice__newsCommentTip'] = '新評論提醒';
$_LANG['modules__userNotice__newsFansTip'] = '新增粉絲提醒';
$_LANG['modules__userNotice__newsMessageTip'] = '新私信提醒';
$_LANG['modules__userNotice__newsAtMe'] = '@提到我提醒';
$_LANG['modules__userNotice__newsNoticeTip'] = '新通知提醒';
$_LANG['modules__userNotice__setAtMeAddNum'] = '設定哪些@提到我的微博計入@提醒數字中';
$_LANG['modules__userNotice__weiboAuthor'] = '微博的作者是：';
$_LANG['modules__userNotice__allPeople'] = '所有人';
$_LANG['modules__userNotice__followPeople'] = '關注的人';
$_LANG['modules__userNotice__weiboType'] = '微博的類型是：';
$_LANG['modules__userNotice__allWeibo'] = '所有微博';
$_LANG['modules__userNotice__oriWeibo'] = '原創的微博';

/// user preview
$_LANG['modules__userPreview__follow'] = '關注';
$_LANG['modules__userPreview__fans'] = '粉絲';
$_LANG['modules__userPreview__weibo'] = '微博';
$_LANG['modules__userPreview__needBindWeibo'] = '您已經成功登入！要使用%s微博功能，您需要綁定新浪微博帳號。';
$_LANG['modules__userPreview__regWeibo'] = '註冊微博帳號';
$_LANG['modules__userPreview__regAccount'] = '註冊帳號';

/// user setting
$_LANG['modules__userSetting__info'] = '個人資料';
$_LANG['modules__userSetting__modifyHeader'] = '修改頭像';
$_LANG['modules__userSetting__setDisplay'] = '顯示設定';
$_LANG['modules__userSetting__blackList'] = '黑名單';
$_LANG['modules__userSetting__setTip'] = '提醒設定';
$_LANG['modules__userSetting__setAccount'] = '帳號設定';
$_LANG['modules__userSetting__domain'] = '個性域名';

/// user skin
$_LANG['modules__userSkin__linkColor'] = '主鏈接色';
$_LANG['modules__userSkin__customSkin'] = '自訂皮膚';
$_LANG['modules__userSkin__deleteBg'] = '刪除背景';
$_LANG['modules__userSkin__uploadPic'] = '上載圖片';
$_LANG['modules__userSkin__setBgImg'] = '設定背景圖';
$_LANG['modules__userSkin__bgTile'] = '背景平鋪';
$_LANG['modules__userSkin__bgFixed'] = '背景固定';
$_LANG['modules__userSkin__left'] = '居左';
$_LANG['modules__userSkin__align'] = '居中';
$_LANG['modules__userSkin__right'] = '居右';
$_LANG['modules__userSkin__chooseScheme'] = '你還可以選擇配色方案，豐富背景和字體顏色';
$_LANG['modules__userSkin__sublinkColor'] = '輔鏈接色';
$_LANG['modules__userSkin__mainBgColor'] = '主背景色';
$_LANG['modules__userSkin__titleFontColor'] = '標題字體色';
$_LANG['modules__userSkin__mainContentColor'] = '主文字色';

/// user tag
$_LANG['modules__userTag__me'] = '我';
$_LANG['modules__userTag__whoTag'] = '%s的標籤';
$_LANG['modules__userTag__emptyTip'] = '你還沒有設定標籤。<br /><a href="%s">立即添加</a>';
$_LANG['modules__userTag__set'] = '設定';

/// user tag edit
$_LANG['modules__userTagEdit__whyAddTag'] = '添加描述自己職業、興趣愛好等方面的詞語，讓更多人找到你，讓你找到更多同好';
$_LANG['modules__userTagEdit__chooseTag'] = '選擇最適合你的詞語，多個請用空格分開';
$_LANG['modules__userTagEdit__addTag'] = '添加標籤';
$_LANG['modules__userTagEdit__interest'] = '你可能感興趣的標籤(點擊直接添加)：';
$_LANG['modules__userTagEdit__addedTag'] = '我已經添加的標籤：';
$_LANG['modules__userTagEdit__aboutTag'] = '關於標籤：';
$_LANG['modules__userTagEdit__desc1'] = '標籤是自訂描述自己職業、興趣愛好的關鍵字，讓更多人找到你，讓你找到更多同好。';
$_LANG['modules__userTagEdit__desc2'] = '已經添加的標籤將顯示在“我的微博”頁面右側欄中，方便大家瞭解你。';
$_LANG['modules__userTagEdit__desc3'] = '在此查看你自己添加的所有標籤，還可以方便地管理，最多可添加10個標籤。';
$_LANG['modules__userTagEdit__desc4'] = '點擊你已添加的標籤，可以搜索到有同樣興趣的人。';

/// user total
$_LANG['modules__userTotal__weiboGuest'] = '新浪微博來賓';
$_LANG['modules__userTotal__weiboNum'] = '微博';
$_LANG['modules__userTotal__follow'] = '關注';
$_LANG['modules__userTotal__fans'] = '粉絲';

/// userlist
$_LANG['modules__userList__haveMutualInterest'] = '已互相關注';
$_LANG['modules__userList__removeFans'] = '移除粉絲';
$_LANG['modules__userList__cancelFollowed'] = '取消關注';
$_LANG['modules__userList__sendMessage'] = '發私信';
$_LANG['modules__userList__fansNum'] = '粉絲數：%s人';

/// weibolist
$_LANG['modules__weiboList__newsWeiboTip'] = '有新微博，點擊查看';
$_LANG['modules__weiboList__all'] = '全部';
$_LANG['modules__weiboList__ori'] = '原創';
$_LANG['modules__weiboList__image'] = '圖片';
$_LANG['modules__weiboList__video'] = '視頻';
$_LANG['modules__weiboList__music'] = '音樂';
$_LANG['modules__weiboList__lookNewsWeibo'] = '<a href="#">有<em></em>條新微博，點擊查看</a>';
$_LANG['modules__weiboList__endPage'] = '已到最後一頁';

/// error
$_LANG['modules__errorInhibit__errorTitle'] = '禁止登入';
$_LANG['modules__errorInhibit__errorMsg'] = '對不起，你已經被禁止登入了！ ';
$_LANG['modules__errorInhibit__errorTip'] = '登出，並回到首頁';
$_LANG['modules__errorDelete__errorTitle'] = '禁止登入';
$_LANG['modules__errorDelete__errorMsg'] = '對不起，該用戶已經被屏蔽了！ ';
$_LANG['modules__errorDelete__errorTip'] = '<a href="javascript:history.go(-1);">返回上一頁</a> <a href="%s">我的首頁</a> ';

/// template html title
$_LANG['template__titleTip__click__close'] = '點擊關閉';


$_LANG['modules_celeb_classify_list_adminEmptyTip'] = '名人堂還沒有內容，請到<b>後臺管理中心</b>-<b>用戶管理</b>-<a href="%s">名人管理</a>中添加設定';
$_LANG['modules_celeb_classify_list_emptyTip'] = '名人堂還沒有內容，等待管理員添加，你可以訪問其他頁面碰碰運氣';


$_LANG['modules_user_recommend_block_more'] = '更多';
$_LANG['modules_user_recommend_block_selectAll'] = '全選';
$_LANG['modules_user_recommend_block_followMore'] = '關注已選';

/// 組件
$_LANG['modules_component_component_1_hotForward'] = '熱門轉發';
$_LANG['modules_component_component_1_hotComment'] = '熱門評論';

// 下面兩行為組件通用
$_LANG['modules_component_component_2_follow'] = '加關注';
$_LANG['modules_component_component_2_followed'] = '已關注';
$_LANG['modules_component_component_2_headTitle'] = '的頭像';
$_LANG['modules_component_component_2_Forward'] = '向前';
$_LANG['modules_component_component_2_back'] = '向後';

$_LANG['modules_component_component_5_empty'] = '所設定的自訂微博列表不存在，請通知管理員進行設定。';
$_LANG['modules_component_component_5_sysError'] = '系統繁忙，微博清單獲取不正常，請<a href="#" rel="e:rl">刷新</a>再試!';
$_LANG['modules_component_component_5_memberList'] = '列表成員：';

$_LANG['modules_component_component_7_reason_topic'] = '你們有相同的話題';
$_LANG['modules_component_component_7_reason_reason'] = '你們在同一個地區';
$_LANG['modules_component_component_7_reason_tag'] = '你們有相同的標籤';

$_LANG['modules_component_component_8_changeCity'] = '切換城市';
$_LANG['modules_component_component_8_selectArea'] = '請選擇地區：';
$_LANG['modules_component_component_8_weiboEmpty'] = '暫無微博';

$_LANG['modules_component_component_9_more'] = '更多';

$_LANG['modules_component_component_10_saySomething'] = '我也說幾句';
$_LANG['modules_component_component_10_somebodyFace'] = '%s的頭像';
$_LANG['modules_component_component_10_fans'] = '粉絲<span>%s</span>人';
$_LANG['modules_component_component_10_topicEmpty'] = '此話題暫無相關內容。';
$_LANG['modules_component_component_10_tryToGetAgain'] = '獲取熱門微博資訊失敗，請<a href="#" rel="e:rl">刷新</a>再試!';

$_LANG['modules_component_component_18_eventTitle'] = '活動列表';
$_LANG['modules_component_component_18_empty'] = '記錄為空';
$_LANG['modules_component_component_18_eventTime'] = '時間：';

/// 直播與訪談
$_LANG['modules_interview_emcee_list_manager'] = '主持人';
$_LANG['modules_interview_emcee_list_follow'] = '加關注';
$_LANG['modules_interview_emcee_list_followed'] = '已關注';

$_LANG['modules_interview_program_list_interviewList'] = '訪談列表';
$_LANG['modules_interview_program_list_more'] = '更多';
$_LANG['modules_interview_program_list_ready'] = '<span class="unplayed">(未開始)</span>';
$_LANG['modules_interview_program_list_closed'] = '<span class="finish">(已結束)</span>';
$_LANG['modules_interview_program_list_running'] = '<span class="active">(進行中)</span>';
$_LANG['modules_interview_program_list_members'] = '主持人：';
$_LANG['modules_interview_program_list_timeField'] = '時&nbsp;&nbsp;&nbsp;&nbsp;間：';
$_LANG['modules_interview_program_list_time'] = 'Y年m月d日 H:i';

$_LANG['modules_interview_user_sidebar_guest'] = '特邀嘉賓';
$_LANG['modules_interview_user_sidebar_allFollow'] = '全部關注';

$_LANG['modules_interview_about_live_about'] = '關於線上訪談';

$_LANG['modules_interview_answerweibo_list_hasNew'] = '有<span></span>條新微博，點擊查看';
$_LANG['modules_interview_answerweibo_list_master_count'] = '訪談內容<span>(共有<em class="que-num">%s</em>個問題 <em class="rep-num"> %s</em>個回覆)</span>';
$_LANG['modules_interview_answerweibo_list_notmaster_count'] = '訪談內容<span class="close">(已結束，共 %s個回覆)</span>';
$_LANG['modules_interview_answerweibo_list_weiboEmpty'] = '暫時沒有微博';


$_LANG['modules_interview_answerweibo_nopage_count'] = '訪談內容<span>(共有<em class="que-num">%s</em>個問題 <em class="rep-num">%s</em>個回覆)</span>';
$_LANG['modules_interview_answerweibo_nopage_weiboEmpty'] = '暫時沒有微博';

$_LANG['modules_interview_askweibo_list_hasNew'] = '有<span></span>條新微博，點擊查看';
$_LANG['modules_interview_askweibo_list_fansAsk'] = '網友提問';
$_LANG['modules_interview_askweibo_list_weiboEmpty'] = '暫時沒有微博';


$_LANG['modules_interview_askweibo_nopage_counts'] = '網友提問<span>(共有<em class="que-num">%s</em>個問題)</span>';
$_LANG['modules_interview_askweibo_nopage_weiboEmpty'] = '暫時沒有微博';


$_LANG['modules_interview_closeed_closeed'] = '已結束';
$_LANG['modules_interview_closeed_time'] = '訪談時間：<span>%s</span>';
$_LANG['modules_interview_closeed_description'] = '訪談簡介：';

$_LANG['modules_interview_feed_withAnswer_masker'] = '主持人';
$_LANG['modules_interview_feed_withAnswer_guest'] = '嘉賓';
$_LANG['modules_interview_feed_withAnswer_forward'] = '轉發';
$_LANG['modules_interview_feed_withAnswer_comment'] = '評論';
$_LANG['modules_interview_feed_withAnswer_weiboIllegal'] = '內容有錯！';
$_LANG['modules_interview_feed_withAnswer_userHasBeDisabled'] = '該用戶已經被屏蔽';
$_LANG['modules_interview_feed_withAnswer_sourceWeiboHasBeDisabled'] = '原微博已被屏蔽';
$_LANG['modules_interview_feed_withAnswer_forwardSource'] = '原文轉發';
$_LANG['modules_interview_feed_withAnswer_commentSource'] = '原文評論';
$_LANG['modules_interview_feed_withAnswer_answer'] = '回答';
$_LANG['modules_interview_feed_withAnswer_delete'] = '刪除';
$_LANG['modules_interview_feed_withAnswer_forward'] = '轉發';
$_LANG['modules_interview_feed_withAnswer_favCancel'] = '取消收藏';
$_LANG['modules_interview_feed_withAnswer_fav'] = '收藏';
$_LANG['modules_interview_feed_withAnswer_comment'] = '評論';
$_LANG['modules_interview_feed_withAnswer_from'] = '來自';
$_LANG['modules_interview_feed_withAnswer_report'] = '舉報';
$_LANG['modules_interview_feed_withAnswer_disabled'] = '已屏蔽';
$_LANG['modules_interview_feed_withAnswer_disableWeibo'] = '屏蔽該微博';


$_LANG['modules_interview_going_ask'] = '<div class="title-txt">我有一個問題向</div><div class="btn-guest"><span>嘉賓列表</span><em class="arrow"></em>';
$_LANG['modules_interview_going_going'] = '進行中';
$_LANG['modules_interview_going_time'] = '訪談時間：';
$_LANG['modules_interview_going_recommend'] = '推薦給好友';
$_LANG['modules_interview_going_title'] = '訪談簡介：';

$_LANG['modules_interview_guest_going_title'] = '我有一個想法和大家分享：';
$_LANG['modules_interview_guest_going_ready'] = '<span class="not-started">未開始</span>';
$_LANG['modules_interview_guest_going_going'] = '<span class="going">進行中</span>';
$_LANG['modules_interview_guest_going_time'] = '訪談時間：';
$_LANG['modules_interview_guest_going_recommend'] = '推薦給好友';
$_LANG['modules_interview_guest_going_description'] = '訪談簡介：';

$_LANG['modules_interview_guestweibo_list_myQuestion'] = '我的問題';
$_LANG['modules_interview_guestweibo_list_allQuestion'] = '所有問題';
$_LANG['modules_interview_guestweibo_list_myAnswered'] = '我回答過的';
$_LANG['modules_interview_guestweibo_list_hasNew'] = '有<span></span>條新微博，點擊查看';
$_LANG['modules_interview_guestweibo_list_weiboEmpty'] = '暫時沒有提問，<a href="javascript:void(0);" onclick="location.reload();">刷新</a>試試';
$_LANG['modules_interview_guestweibo_list_answeredEmpty'] = '您暫時沒有回答任何問題';

$_LANG['modules_interview_index_list_title'] = '精彩訪談';
$_LANG['modules_interview_index_list_toBegin'] = '線上訪談 "%s" 即將開始';
$_LANG['modules_interview_index_list_remindMe'] = '提醒我';
$_LANG['modules_interview_index_list_ready'] = '<span class="unplayed">(未開始)</span>';
$_LANG['modules_interview_index_list_closed'] = '<span class="finish">(已結束)</span>';
$_LANG['modules_interview_index_list_going'] = '<span class="active">(進行中)</span>';
$_LANG['modules_interview_index_list_guest'] = '特邀嘉賓';
$_LANG['modules_interview_index_list_left'] = '左';
$_LANG['modules_interview_index_list_right'] = '右';
$_LANG['modules_interview_index_list_more'] = '更多';
$_LANG['modules_interview_index_list_moreRecommend'] = '更多推薦';
$_LANG['modules_interview_index_list_admin_inertviewEmpty'] = '還沒有線上訪談，你可以在 後臺管理中心-擴展工具-線上訪談 添加設定';
$_LANG['modules_interview_index_list_inertviewEmpty'] = '還沒有線上訪談，你可以看看其他頁面。';


$_LANG['modules_interview_live_contact_contact'] = '聯絡方式';

$_LANG['modules_interview_master_title'] = '我有一個想法和大家分享：';
$_LANG['modules_interview_master_ready'] = '<span class="not-started">未開始</span>';
$_LANG['modules_interview_master_going'] = '<span class="going">進行中</span>';
$_LANG['modules_interview_master_time'] = '訪談時間：';
$_LANG['modules_interview_master_recommend'] = '推薦給好友';
$_LANG['modules_interview_master_description'] = '訪談簡介：';


$_LANG['modules_interview_not_start_title'] = '<div class="title-txt">我有一個問題向</div><div class="btn-guest"><span>嘉賓列表</span><em class="arrow"></em>';
$_LANG['modules_interview_not_start_ask'] = '提問';
$_LANG['modules_interview_not_start_ready'] = '未開始';
$_LANG['modules_interview_not_start_time'] = '訪談時間：';
$_LANG['modules_interview_not_start_toBegin'] = '線上訪談 "%s" 即將開始';
$_LANG['modules_interview_not_start_remind'] = '定制訪談提醒';
$_LANG['modules_interview_not_start_reommmend'] = '推薦給好友';
$_LANG['modules_interview_not_start_description'] = '訪談簡介：';
$_LANG['modules_interview_login_tip'] = '登入之後可查看更多精彩訪談內容，還可參與嘉賓互動。';
$_LANG['modules_interview_login_tag'] = '立即登入';

$_LANG['modules_interview_user_list_s1_title'] = '微博主持人';
$_LANG['modules_interview_user_list_s1_followed'] = '已關注';
$_LANG['modules_interview_user_list_s1_follow'] = '加關注';
$_LANG['modules_interview_user_list_s1_master'] = '官方主持人';

$_LANG['modules_interview_feedAnswer_forward'] = '轉發';
$_LANG['modules_interview_feedAnswer_comment'] = '評論';

$_LANG['modules_microlive_live_detail_info_running'] = '進行中';
$_LANG['modules_microlive_live_detail_info_ready'] = '未開始';
$_LANG['modules_microlive_live_detail_info_closed'] = '已結束';
$_LANG['modules_microlive_live_detail_info_title'] = '直播簡介';
$_LANG['modules_microlive_live_detail_info_fieldTime'] = '直播時間：';
$_LANG['modules_microlive_live_detail_info_recommend'] = '推薦給好友';

$_LANG['modules_microlive_live_detail_users_master'] = '主持人';
$_LANG['modules_microlive_live_detail_users_guest'] = '特邀嘉賓';
$_LANG['modules_microlive_live_detail_users_allFollow'] = '全部關注';
$_LANG['modules_microlive_live_detail_users_followed'] = '<a href="#" class="followed-btn">已關注</a>';
$_LANG['modules_microlive_live_detail_users_addFollower'] = '<a href="#" class="addfollow-btn" rel="e:fl,t:1">加關注</a>';
$_LANG['modules_microlive_live_detail_login_tip'] = '登入之後可查看更多精彩訪談內容，還可參與嘉賓互動。';
$_LANG['modules_microlive_live_detail_login_tag'] = '立即登入';


$_LANG['modules_microlive_news_live_running'] = '進行中';
$_LANG['modules_microlive_news_live_ready'] = '未開始';
$_LANG['modules_microlive_news_live_closed'] = '已結束';
$_LANG['modules_microlive_news_live_remind'] = '提醒我';
$_LANG['modules_microlive_news_live_timeout'] = '距開始時間還剩：';
$_LANG['modules_microlive_news_live_guest'] = '特邀嘉賓';
$_LANG['modules_microlive_news_live_lift'] = '左';
$_LANG['modules_microlive_news_live_right'] = '右';
$_LANG['modules_microlive_news_live_emptyForAdmin'] = '還沒有線上直播，你可以在 後臺管理中心-擴展工具-線上直播 添加設定';
$_LANG['modules_microlive_news_live_empty'] = '還沒有線上直播，你可以看看其他頁面。';
$_LANG['modules_microlive_news_live_more'] = '更多';
$_LANG['modules_microlive_news_live_moreRecommend'] = '更多推薦';

$_LANG['modules_microlive_news_live_list_title'] = '精彩直播';
$_LANG['modules_microlive_news_live_list_running'] = '進行中';
$_LANG['modules_microlive_news_live_list_ready'] = '未開始';
$_LANG['modules_microlive_news_live_list_closed'] = '已結束';
$_LANG['modules_microlive_news_live_list_remind'] = '提醒我';
$_LANG['modules_microlive_news_live_list_emptyForAdmin'] = '還沒有線上直播，你可以在 後臺管理中心-擴展工具-線上直播 添加設定';
$_LANG['modules_microlive_news_live_list_empty'] = '還沒有線上直播，你可以看看其他頁面。';

$_LANG['modules_microlive_side_live_base_info_title'] = '關於線上直播';
$_LANG['modules_microlive_side_live_base_info_contact'] = '聯絡方式';

$_LANG['modules_microlive_side_live_base_master_title'] = '微博主持人';
$_LANG['modules_microlive_side_live_base_master_master'] = '官方主持人';

$_LANG['modules_microlive_side_news_live_more'] = '更多';
$_LANG['modules_microlive_side_news_live_title'] = '直播列表';
$_LANG['modules_microlive_side_news_live_running'] = '進行中';
$_LANG['modules_microlive_side_news_live_ready'] = '未開始';
$_LANG['modules_microlive_side_news_live_close'] = '已結束';
$_LANG['modules_microlive_side_news_live_master'] = '主持人：';
$_LANG['modules_microlive_side_news_live_timeField'] = '時&nbsp;&nbsp;&nbsp;&nbsp;間：';

$_LANG['modules_share_main_title'] = '轉發 - ';
$_LANG['modules_share_main_using'] = '你正在使用';
$_LANG['modules_share_main_account'] = '帳號';
$_LANG['modules_share_main_changeAccount'] = '換個帳號？';
$_LANG['modules_share_main_redirect'] = '轉發到我的微博';
$_LANG['modules_share_main_inputLest'] = '你還可以輸入<span>140</span>字';
$_LANG['modules_share_main_publish'] = '發佈微博';
$_LANG['modules_share_main_js_input'] = '您還可以輸入<span>';
$_LANG['modules_share_main_js_lengthLimit'] = '已超出<span>';
$_LANG['modules_share_main_js_front'] = '</span>字';

$_LANG['modules_share_success_title'] = '轉發成功 - ';
$_LANG['modules_share_success_succ'] = '轉發成功！';
$_LANG['modules_share_success_goto'] = '<a href="%s" target="_blank">去我的微博</a>看看，或<a href="javascript:window.close();">點擊這裡</a>關閉視窗';
$_LANG['modules_share_success_close'] = '<span id="timer">3</span>秒後視窗自動關閉，<a href="javascript:window.close();">點擊這裡</a>立即關閉';
$_LANG['modules_share_success_comeTo'] = '去我的微博';

/// 單元輸出
$_LANG['modules_unit_t_follow_followTooManyUser'] = '你今天已經關注了足夠多的人，先去看看他們在說些什麼吧？';
$_LANG['modules_unit_t_follow_empty'] = '該使用者清單沒有資料，請到使用者管理中添加用戶。';
$_LANG['modules_unit_t_follow_followed'] = '<span>已關注</span>';
$_LANG['modules_unit_t_follow_my'] = '<span>我自己</span>';

$_LANG['modules_unit_t_oneclick_follow_followed'] = '關注成功';
$_LANG['modules_unit_t_oneclick_follow_nologin'] = '目前尚未登入%s，請<a id="loginBtn" target="_blank" href="%s">登入</a>後關注！';
$_LANG['modules_unit_t_oneclick_follow_userlistEmpty'] = '用戶列表為空';

$_LANG['modules_unit_t_show_followedTooManyUsers'] = '你今天已經關注了足夠多的人，先去看看他們在說些什麼吧？';
$_LANG['modules_unit_t_show_fans'] = '粉絲';
$_LANG['modules_unit_t_show_people'] = '人';
$_LANG['modules_unit_t_show_forward'] = '轉發';
$_LANG['modules_unit_t_show_comment'] = '評論';
$_LANG['modules_unit_t_show_empty'] = '暫時沒有微博資訊';
$_LANG['modules_unit_t_show_refresh'] = '獲取微博資訊失敗，請<a href="#" rel="e:rl">刷新</a>再試!';

$_LANG['modules_unit_t_topic_input'] = '您還可以輸入';
$_LANG['modules_unit_t_topic_letter'] = '字';
$_LANG['modules_unit_t_topic_overflow'] = '已超出';
$_LANG['modules_unit_t_topic_talkAbout'] = '大家都在聊';
$_LANG['modules_unit_t_topic_succ'] = '發佈成功！';
$_LANG['modules_unit_t_topic_error'] = '錯誤資訊！';
$_LANG['modules_unit_t_topic_nologin'] = '<a href="%s" target="_blank" id="loginA">登入%s</a>,即可參與話題討論';
$_LANG['modules_unit_t_topic_forward'] = '轉發';
$_LANG['modules_unit_t_topic_comment'] = '評論';
$_LANG['modules_unit_t_topic_from'] = '來自';
$_LANG['modules_unit_t_topic_empty'] = '暫時沒有關注該話題的微博資訊%s';
$_LANG['modules_unit_t_topic_publishAgain'] = '，立刻發一條吧！';
$_LANG['modules_unit_t_topic_refresh'] = '獲取該話題的微博資訊失敗，請<a href="#" rel="e:rl">刷新</a>再試!';

$_LANG['modules_unit_t_weibo_allMembers'] = '全部成員';
$_LANG['modules_unit_t_weibo_talkAbout'] = '他們在說';
$_LANG['modules_unit_t_weibo_forward'] = '轉發';
$_LANG['modules_unit_t_weibo_comment'] = '評論';
$_LANG['modules_unit_t_weibo_from'] = '來自';
$_LANG['modules_unit_t_weibo_empty'] = '獲取群組微博失敗，可能服務器繁忙';
$_LANG['modules_unit_t_weibo_refresh'] = '獲取該話題的微博資訊失敗，請<a href="javascript:location.reload();">刷新</a>再試!';
$_LANG['modules_unit_t_weibo_nousers'] = '該使用者清單沒有資料，請到使用者管理中添加用戶。';

$_LANG['modules__userPrivacyNotice__showNumTip'] = '本頁僅顯示了“%s”的最近20條微博，<a href="#" rel="e:lg">登入</a>之後可以查看Ta的所有微博';
$_LANG['modules__userPrivacyNotice__copyright'] = '%s未登入%s，此處資訊均來自新浪微博，Powered By <a href="http://weibo.com/" target="_blank">新浪微博</a>';

$_LANG['modules__footer__wap'] = 'WAP 版';
/// class
$_LANG['xwbPreAction__common__underReview'] = '正在審核中';

$_LANG['pageClass__title__prePage'] = '上一頁';
$_LANG['pageClass__title__nextPage'] = '下一頁';
$_LANG['pageClass__title__indexPage'] = '首頁';
$_LANG['pageClass__title__pageStyle'] = '[prev]上一頁[/prev] [nav] [next]下一頁[/next] 總記錄數[recordCount]';

/// adapter
/// account
$_LANG['adapter__account__dzUcenter__loginError'] = '登入失敗，請檢查遠端登入驗證介面';
$_LANG['adapter__account__xauthCookie__tokenMustStart'] = 'XAUTH_TK_DATA_SIGN_FUNC 不能為空，為保證安全，TOKEN必須啟用簽名';
$_LANG['adapter__account__xauthCookie__keyMustChange'] = '為保證安全，帳號適配器中的簽名和加密公開金鑰你必須更改 XAUTH_TK_DATA_ENCRIPT_KEY ';
$_LANG['adapter__account__xauthCookie__notFoundFun'] = '無法在當前帳號適配器中找到你請求的遠程ACTION方法[%s]';
$_LANG['adapter__account__xauthCookie__loginError'] = '登入失敗，請檢查遠端登入驗證介面';
$_LANG['adapter__account__xauthCookie__notFoundClassFun'] = '無法在本類中找到你配置的簽名方法[%s]';
$_LANG['adapter__account__xauthCookie__dataFormatErr'] = '帳號適配器配置 [XAUTH_TK_DATA_FORMAT] 錯誤';
$_LANG['adapter__account__xauthCookie__tokenEmpty'] = 'TOKEN為空，或者無法將TOKEN資料轉換成[%s]格式的字串';
$_LANG['adapter__account__xauthCookie__notFoundsecFun'] = '無法在帳號適配器中找到你配置的加密解密方法[%s]';

/// upload
$_LANG['adapter__load__fileUpload__uploadDirNotExist'] = '上載目錄%s不存在';
$_LANG['adapter__load__fileUpload__uploadDirNotWritable'] = '上載目錄%s不可寫';
$_LANG['adapter__load__fileUpload__success'] = '上載成功!';
$_LANG['adapter__load__fileUpload__uploadFileSize'] = '上載文件大小不符！';
$_LANG['adapter__load__fileUpload__illegalUploadFiles'] = '非法上載文件！';
$_LANG['adapter__load__fileUpload__uploadFileErr1'] = '上載的文件超過了 php.ini 中 upload_max_filesize 選項限制的值';
$_LANG['adapter__load__fileUpload__uploadFileErr2'] = '上載檔的大小超過了 HTML 表單中 MAX_FILE_SIZE 選項指定的值';
$_LANG['adapter__load__fileUpload__uploadFileErr3'] = '檔只有部分被上載';
$_LANG['adapter__load__fileUpload__uploadFileErr4'] = '沒有檔被上載';
$_LANG['adapter__load__fileUpload__uploadFileErr5'] = '找不到暫存檔案夾';
$_LANG['adapter__load__fileUpload__uploadFileErr6'] = '檔寫入失敗';
$_LANG['adapter__load__fileUpload__uploadFileErr7'] = '未知上載錯誤！';

/// 共同使用
$_LANG['common__apiError__limitTip'] = '出錯啦，該網站調用API次數已超過限制，請聯繫站長解決！<br><a href="http://bbs.x.weibo.com/viewthread.php?tid=1262&extra=page%3D1" target="_blank">查看解決方案</a>';
$_LANG['common__template__followed'] = '已關注';
$_LANG['common__template__save'] = '儲存';
$_LANG['common__template__cancel'] = '取消';
$_LANG['common__template__OK'] = '確定';
$_LANG['common__template__toFollow'] = '加關注';
$_LANG['common__template__goTop'] = '返回頂部';

$_LANG['js__controller__setting__provinceCity'] = 
<<<END
{"provinces":[{"id":11,"name":"北京","citys":[{"1":"東城區"},{"2":"西城區"},{"3":"崇文區"},{"4":"宣武區"},{"5":"朝陽區"},{"6":"豐檯區"},{"7":"石景山區"},{"8":"海澱區"},{"9":"門頭溝區"},{"11":"房山區"},{"12":"通州區"},{"13":"順義區"},{"14":"昌平區"},{"15":"大興區"},{"16":"懷柔區"},{"17":"平穀區"},{"28":"密雲縣"},{"29":"延慶縣"}]},
{"id":12,"name":"天津","citys":[{"1":"和平區"},{"2":"河東區"},{"3":"河西區"},{"4":"南開區"},{"5":"河北區"},{"6":"紅橋區"},{"7":"塘沽區"},{"8":"漢沽區"},{"9":"大港區"},{"10":"東麗區"},{"11":"西青區"},{"12":"津南區"},{"13":"北辰區"},{"14":"武清區"},{"15":"寶坻區"},{"21":"寧河縣"},{"23":"靜海縣"},{"25":"薊縣"}]},
{"id":13,"name":"河北","citys":[{"1":"石傢莊"},{"2":"唐山"},{"3":"秦皇島"},{"4":"邯鄲"},{"5":"邢檯"},{"6":"保定"},{"7":"張傢口"},{"8":"承德"},{"9":"滄州"},{"10":"廊坊"},{"11":"衡水"}]},
{"id":14,"name":"山西","citys":[{"1":"太原"},{"2":"大同"},{"3":"陽泉"},{"4":"長治"},{"5":"晉城"},{"6":"朔州"},{"7":"晉中"},{"8":"運城"},{"9":"忻州"},{"10":"臨汾"},{"23":"呂梁"}]},
{"id":15,"name":"內濛古","citys":[{"1":"呼和浩特"},{"2":"包頭"},{"3":"烏海"},{"4":"赤峰"},{"5":"通遼"},{"6":"鄂爾多斯"},{"7":"呼倫貝爾"},{"22":"興安盟"},{"25":"錫林郭勒盟"},{"26":"烏蘭察佈盟"},{"28":"巴彥淖爾盟"},{"29":"阿拉善盟"}]},
{"id":21,"name":"遼寧","citys":[{"1":"沈陽"},{"2":"大連"},{"3":"鞍山"},{"4":"撫順"},{"5":"本谿"},{"6":"丹東"},{"7":"錦州"},{"8":"營口"},{"9":"阜新"},{"10":"遼陽"},{"11":"盤錦"},{"12":"鐵嶺"},{"13":"朝陽"},{"14":"葫蘆島"}]},
{"id":22,"name":"吉林","citys":[{"1":"長春"},{"2":"吉林"},{"3":"四平"},{"4":"遼源"},{"5":"通化"},{"6":"白山"},{"7":"松原"},{"8":"白城"},{"24":"延邊朝鮮族自治州"}]},
{"id":23,"name":"黑龍江","citys":[{"1":"哈爾濱"},{"2":"齊齊哈爾"},{"3":"雞西"},{"4":"鶴崗"},{"5":"雙鴨山"},{"6":"大慶"},{"7":"伊春"},{"8":"佳木斯"},{"9":"七檯河"},{"10":"牡丹江"},{"11":"黑河"},{"12":"綏化"},{"27":"大興安嶺"}]},
{"id":31,"name":"上海","citys":[{"1":"黃浦區"},{"3":"盧灣區"},{"4":"徐匯區"},{"5":"長寧區"},{"6":"靜安區"},{"7":"普陀區"},{"8":"閘北區"},{"9":"虹口區"},{"10":"杨浦區"},{"12":"閔行區"},{"13":"寶山區"},{"14":"嘉定區"},{"15":"浦東新區"},{"16":"金山區"},{"17":"松江區"},{"18":"青浦區"},{"19":"南匯區"},{"20":"奉賢區"},{"30":"崇明縣"}]},
{"id":32,"name":"江蘇","citys":[{"1":"南京"},{"2":"無錫"},{"3":"徐州"},{"4":"常州"},{"5":"蘇州"},{"6":"南通"},{"7":"連雲港"},{"8":"淮安"},{"9":"鹽城"},{"10":"揚州"},{"11":"鎮江"},{"12":"泰州"},{"13":"宿遷"}]},
{"id":33,"name":"浙江","citys":[{"1":"杭州"},{"2":"寧波"},{"3":"溫州"},{"4":"嘉興"},{"5":"湖州"},{"6":"紹興"},{"7":"金華"},{"8":"衢州"},{"9":"舟山"},{"10":"檯州"},{"11":"麗水"}]},
{"id":34,"name":"安徽","citys":[{"1":"郃肥"},{"2":"蕪湖"},{"3":"蚌埠"},{"4":"淮南"},{"5":"馬鞍山"},{"6":"淮北"},{"7":"銅陵"},{"8":"安慶"},{"10":"黃山"},{"11":"滁州"},{"12":"阜陽"},{"13":"宿州"},{"14":"巢湖"},{"15":"六安"},{"16":"亳州"},{"17":"池州"},{"18":"宣城"}]},
{"id":35,"name":"福建","citys":[{"1":"福州"},{"2":"廈門"},{"3":"莆田"},{"4":"三明"},{"5":"泉州"},{"6":"漳州"},{"7":"南平"},{"8":"龍巖"},{"9":"寧德"}]},
{"id":36,"name":"江西","citys":[{"1":"南昌"},{"2":"景德鎮"},{"3":"萍鄉"},{"4":"九江"},{"5":"新餘"},{"6":"鷹潭"},{"7":"贛州"},{"8":"吉安"},{"9":"宜春"},{"10":"撫州"},{"11":"上饶"}]},
{"id":37,"name":"山東","citys":[{"1":"濟南"},{"2":"青島"},{"3":"淄博"},{"4":"棗莊"},{"5":"東營"},{"6":"煙檯"},{"7":"濰坊"},{"8":"濟寧"},{"9":"泰安"},{"10":"威海"},{"11":"日炤"},{"12":"萊蕪"},{"13":"臨沂"},{"14":"德州"},{"15":"聊城"},{"16":"濱州"},{"17":"菏澤"}]},
{"id":41,"name":"河南","citys":[{"1":"鄭州"},{"2":"開封"},{"3":"洛陽"},{"4":"平頂山"},{"5":"安陽"},{"6":"鶴壁"},{"7":"新鄉"},{"8":"焦作"},{"9":"濮陽"},{"10":"許昌"},{"11":"漯河"},{"12":"三門峽"},{"13":"南陽"},{"14":"商丘"},{"15":"信陽"},{"16":"週口"},{"17":"駐馬店"}]},
{"id":42,"name":"湖北","citys":[{"1":"武漢"},{"2":"黃石"},{"3":"十堰"},{"5":"宜昌"},{"6":"襄樊"},{"7":"鄂州"},{"8":"荊門"},{"9":"孝感"},{"10":"荊州"},{"11":"黃岡"},{"12":"鹹寧"},{"13":"隨州"},{"28":"恩施土傢族苗族自治州"}]},
{"id":43,"name":"湖南","citys":[{"1":"長沙"},{"2":"株洲"},{"3":"湘潭"},{"4":"衡陽"},{"5":"邵陽"},{"6":"嶽陽"},{"7":"常德"},{"8":"張傢界"},{"9":"益陽"},{"10":"郴州"},{"11":"永州"},{"12":"懷化"},{"13":"婁底"},{"31":"湘西土傢族苗族自治州"}]},
{"id":44,"name":"廣東","citys":[{"1":"廣州"},{"2":"韶關"},{"3":"深圳"},{"4":"珠海"},{"5":"汕頭"},{"6":"彿山"},{"7":"江門"},{"8":"湛江"},{"9":"茂名"},{"12":"肇慶"},{"13":"惠州"},{"14":"梅州"},{"15":"汕尾"},{"16":"河源"},{"17":"陽江"},{"18":"清遠"},{"19":"東莞"},{"20":"中山"},{"51":"潮州"},{"52":"揭陽"},{"53":"雲浮"}]},
{"id":45,"name":"廣西","citys":[{"1":"南寧"},{"2":"柳州"},{"3":"桂林"},{"4":"梧州"},{"5":"北海"},{"6":"防城港"},{"7":"欽州"},{"8":"貴港"},{"9":"玉林"},{"10":"百色"},{"11":"賀州"},{"12":"河池"}]},
{"id":46,"name":"海南","citys":[{"1":"海口"},{"2":"三亞"},{"90":"其他"}]},
{"id":50,"name":"重慶","citys":[{"1":"萬州區"},{"2":"涪陵區"},{"3":"渝中區"},{"4":"大渡口區"},{"5":"江北區"},{"6":"沙坪壩區"},{"7":"九龍坡區"},{"8":"南岸區"},{"9":"北碚區"},{"10":"萬盛區"},{"11":"雙橋區"},{"12":"渝北區"},{"13":"巴南區"},{"14":"黔江區"},{"15":"長壽區"},{"22":"綦江縣"},{"23":"潼南縣"},{"24":"銅梁縣"},{"25":"大足縣"},{"26":"荣昌縣"},{"27":"璧山縣"},{"28":"梁平縣"},{"29":"城口縣"},{"30":"豐都縣"},{"31":"墊江縣"},{"32":"武隆縣"},{"33":"忠縣"},{"34":"開縣"},{"35":"雲陽縣"},{"36":"奉節縣"},{"37":"巫山縣"},{"38":"巫谿縣"},{"40":"石柱土傢族自治縣"},{"41":"秀山土傢族苗族自治縣"},{"42":"酉陽土傢族苗族自治縣"},{"43":"彭水苗族土傢族自治縣"},{"81":"江津市"},{"82":"郃川市"},{"83":"永川市"},{"84":"南川市"}]},
{"id":51,"name":"四川","citys":[{"1":"成都"},{"3":"自貢"},{"4":"攀枝花"},{"5":"瀘州"},{"6":"德陽"},{"7":"綿陽"},{"8":"廣元"},{"9":"遂寧"},{"10":"內江"},{"11":"樂山"},{"13":"南充"},{"14":"眉山"},{"15":"宜賓"},{"16":"廣安"},{"17":"達州"},{"18":"雅安"},{"19":"巴中"},{"20":"資陽"},{"32":"阿壩"},{"33":"甘孜"},{"34":"涼山"}]},
{"id":52,"name":"貴州","citys":[{"1":"貴陽"},{"2":"六盤水"},{"3":"遵義"},{"4":"安順"},{"22":"銅仁"},{"23":"黔西南"},{"24":"畢節"},{"26":"黔東南"},{"27":"黔南"}]},
{"id":53,"name":"雲南","citys":[{"1":"崑明"},{"3":"麴靖"},{"4":"玉谿"},{"5":"保山"},{"6":"昭通"},{"23":"楚雄"},{"25":"紅河"},{"26":"文山"},{"27":"思茅"},{"28":"西雙版納"},{"29":"大理"},{"31":"德宏"},{"32":"麗江"},{"33":"怒江"},{"34":"迪慶"},{"35":"臨滄"}]},
{"id":54,"name":"西藏","citys":[{"1":"拉薩"},{"21":"昌都"},{"22":"山南"},{"23":"日喀則"},{"24":"那麴"},{"25":"阿裡"},{"26":"林芝"}]},
{"id":61,"name":"陝西","citys":[{"1":"西安"},{"2":"銅川"},{"3":"寶雞"},{"4":"鹹陽"},{"5":"渭南"},{"6":"延安"},{"7":"漢中"},{"8":"榆林"},{"9":"安康"},{"10":"商洛"}]},
{"id":62,"name":"甘肅","citys":[{"1":"蘭州"},{"2":"嘉峪關"},{"3":"金昌"},{"4":"白銀"},{"5":"天水"},{"6":"武威"},{"7":"張掖"},{"8":"平涼"},{"9":"酒泉"},{"10":"慶陽"},{"24":"定西"},{"26":"隴南"},{"29":"臨夏"},{"30":"甘南"}]},
{"id":63,"name":"青海","citys":[{"1":"西寧"},{"21":"海東"},{"22":"海北"},{"23":"黃南"},{"25":"海南"},{"26":"果洛"},{"27":"玉樹"},{"28":"海西"}]},
{"id":64,"name":"寧夏","citys":[{"1":"銀川"},{"2":"石嘴山"},{"3":"吳忠"},{"4":"固原"}]},
{"id":65,"name":"新疆","citys":[{"1":"烏魯木齊"},{"2":"剋拉瑪依"},{"21":"吐魯番"},{"22":"哈密"},{"23":"昌吉"},{"27":"博爾塔拉"},{"28":"巴音郭楞"},{"29":"阿剋蘇"},{"30":"剋孜勒蘇"},{"31":"喀什"},{"32":"和田"},{"40":"伊犁"},{"42":"塔城"},{"43":"阿勒泰"}]},
{"id":71,"name":"檯灣","citys":[{"1":"檯北"},{"2":"高雄"},{"90":"其他"}]},
{"id":81,"name":"香港","citys":[{"1":"香港"}]},
{"id":82,"name":"澳門","citys":[{"1":"澳門"}]},
{"id":100,"name":"其他","citys":[]},
{"id":400,"name":"海外","citys":[{"1":"美國"},{"2":"英國"},{"3":"法國"},{"4":"俄羅斯"},{"5":"加拿大"},{"6":"巴西"},{"7":"澳大利亞"},{"8":"印尼"},{"9":"泰國"},{"10":"馬來西亞"},{"11":"新加坡"},{"12":"菲律賓"},{"13":"越南"},{"14":"印度"},{"15":"日本"},{"16":"其他"}]}]}
END;
