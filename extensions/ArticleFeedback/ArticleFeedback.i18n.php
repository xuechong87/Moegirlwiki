<?php
$messages = array();

/** English
 * @author Nimish Gautam
 * @author Sam Reed
 * @author Brandon Harris
 * @author Trevor Parscal
 * @author Arthur Richards
 */
$messages['en'] = array(
	'articlefeedback' => 'Article feedback dashboard',
	'articlefeedback-desc' => 'Article feedback',
	/* ArticleFeedback survey */
	'articlefeedback-survey-question-origin' => 'What page were you on when you started this survey?',
	'articlefeedback-survey-question-whyrated' => 'Please let us know why you rated this page today (check all that apply):',
	'articlefeedback-survey-answer-whyrated-contribute-rating' => 'I wanted to contribute to the overall rating of the page',
	'articlefeedback-survey-answer-whyrated-development' => 'I hope that my rating would positively affect the development of the page',
	'articlefeedback-survey-answer-whyrated-contribute-wiki' => 'I wanted to contribute to {{SITENAME}}',
	'articlefeedback-survey-answer-whyrated-sharing-opinion' => 'I like sharing my opinion',
	'articlefeedback-survey-answer-whyrated-didntrate' => "I didn't provide ratings today, but wanted to give feedback on the feature",
	'articlefeedback-survey-answer-whyrated-other' => 'Other',
	'articlefeedback-survey-question-useful' => 'Do you believe the ratings provided are useful and clear?',
	'articlefeedback-survey-question-useful-iffalse' => 'Why?',
	'articlefeedback-survey-question-comments' => 'Do you have any additional comments?',
	'articlefeedback-survey-submit' => 'Submit',
	'articlefeedback-survey-title' => 'Please answer a few questions',
	'articlefeedback-survey-thanks' => 'Thanks for filling out the survey.',
	'articlefeedback-survey-disclaimer' => 'By submitting, you agree to transparency under these $1.',
	'articlefeedback-survey-disclaimerlink' => 'terms',
	/* ext.articleFeedback and jquery.articleFeedback */
	'articlefeedback-error' => 'An error has occurred. Please try again later.',
	'articlefeedback-form-switch-label' => 'Rate this page',
	'articlefeedback-form-panel-title' => 'Rate this page',
	'articlefeedback-form-panel-explanation' => 'What\'s this?',
	'articlefeedback-form-panel-explanation-link' => 'Project:ArticleFeedback',
	'articlefeedback-form-panel-clear' => 'Remove this rating',
	'articlefeedback-form-panel-expertise' => 'I am highly knowledgeable about this topic (optional)',
	'articlefeedback-form-panel-expertise-studies' => 'I have a relevant college/university degree',
	'articlefeedback-form-panel-expertise-profession' => 'It is part of my profession',
	'articlefeedback-form-panel-expertise-hobby' => 'It is a deep personal passion',
	'articlefeedback-form-panel-expertise-other' => 'The source of my knowledge is not listed here',
	'articlefeedback-form-panel-helpimprove' => 'I would like to help improve Wikipedia, send me an e-mail (optional)',
	'articlefeedback-form-panel-helpimprove-note' => 'We will send you a confirmation e-mail. We will not share your e-mail address with outside parties as per our $1.',
	'articlefeedback-form-panel-helpimprove-email-placeholder' => 'email@example.org', // Optional
	'articlefeedback-form-panel-helpimprove-privacy' => 'feedback privacy statement',
	'articlefeedback-form-panel-submit' => 'Submit ratings',
	'articlefeedback-form-panel-pending' => 'Your ratings have not been submitted yet',
	'articlefeedback-form-panel-success' => 'Saved successfully',
	'articlefeedback-form-panel-expiry-title' => 'Your ratings have expired',
	'articlefeedback-form-panel-expiry-message' => 'Please reevaluate this page and submit new ratings.',
	'articlefeedback-report-switch-label' => 'View page ratings',
	'articlefeedback-report-panel-title' => 'Page ratings',
	'articlefeedback-report-panel-description' => 'Current average ratings.',
	'articlefeedback-report-empty' => 'No ratings',
	'articlefeedback-report-ratings' => '$1 ratings',
	'articlefeedback-field-trustworthy-label' => 'Trustworthy',
	'articlefeedback-field-trustworthy-tip' => 'Do you feel this page has sufficient citations and that those citations come from trustworthy sources?',
	'articlefeedback-field-trustworthy-tooltip-1' => 'Lacks reputable sources',
	'articlefeedback-field-trustworthy-tooltip-2' => 'Few reputable sources',
	'articlefeedback-field-trustworthy-tooltip-3' => 'Adequate reputable sources',
	'articlefeedback-field-trustworthy-tooltip-4' => 'Good reputable sources',
	'articlefeedback-field-trustworthy-tooltip-5' => 'Great reputable sources',
	'articlefeedback-field-complete-label' => 'Complete',
	'articlefeedback-field-complete-tip' => 'Do you feel that this page covers the essential topic areas that it should?',
	'articlefeedback-field-complete-tooltip-1' => 'Missing most information',
	'articlefeedback-field-complete-tooltip-2' => 'Contains some information',
	'articlefeedback-field-complete-tooltip-3' => 'Contains key information, but with gaps',
	'articlefeedback-field-complete-tooltip-4' => 'Contains most key information',
	'articlefeedback-field-complete-tooltip-5' => 'Comprehensive coverage',
	'articlefeedback-field-objective-label' => 'Objective',
	'articlefeedback-field-objective-tip' => 'Do you feel that this page shows a fair representation of all perspectives on the issue?',
	'articlefeedback-field-objective-tooltip-1' => 'Heavily biased',
	'articlefeedback-field-objective-tooltip-2' => 'Moderate bias',
	'articlefeedback-field-objective-tooltip-3' => 'Minimal bias',
	'articlefeedback-field-objective-tooltip-4' => 'No obvious bias',
	'articlefeedback-field-objective-tooltip-5' => 'Completely unbiased',
	'articlefeedback-field-wellwritten-label' => 'Well-written',
	'articlefeedback-field-wellwritten-tip' => 'Do you feel that this page is well-organized and well-written?',
	'articlefeedback-field-wellwritten-tooltip-1' => 'Incomprehensible',
	'articlefeedback-field-wellwritten-tooltip-2' => 'Difficult to understand',
	'articlefeedback-field-wellwritten-tooltip-3' => 'Adequate clarity',
	'articlefeedback-field-wellwritten-tooltip-4' => 'Good clarity',
	'articlefeedback-field-wellwritten-tooltip-5' => 'Exceptional clarity',
	'articlefeedback-pitch-reject' => 'Maybe later',
	'articlefeedback-pitch-or' => 'or',
	'articlefeedback-pitch-thanks' => 'Thanks! Your ratings have been saved.',
	'articlefeedback-pitch-survey-message' => 'Please take a moment to complete a short survey.',
	'articlefeedback-pitch-survey-body' => '',
	'articlefeedback-pitch-survey-accept' => 'Start survey',
	'articlefeedback-pitch-join-message' => 'Did you want to create an account?',
	'articlefeedback-pitch-join-body' => 'An account will help you track your edits, get involved in discussions, and be a part of the community.',
	'articlefeedback-pitch-join-accept' => 'Create an account',
	'articlefeedback-pitch-join-login' => 'Log in',
	'articlefeedback-pitch-edit-message' => 'Did you know that you can edit this page?',
	'articlefeedback-pitch-edit-body' => '',
	'articlefeedback-pitch-edit-accept' => 'Edit this page',
	'articlefeedback-survey-message-success' => 'Thanks for filling out the survey.',
	'articlefeedback-survey-message-error' => 'An error has occurred.
Please try again later.',
	'articlefeedback-privacyurl' => 'http://wikimediafoundation.org/wiki/Feedback_privacy_statement',
	/* Special:ArticleFeedback */
	'articleFeedback-table-caption-dailyhighsandlows' => 'Today\'s highs and lows',
	'articleFeedback-table-caption-dailyhighs' => 'Pages with highest ratings: $1',
	'articleFeedback-table-caption-dailylows' => 'Pages with lowest ratings: $1',
	'articleFeedback-table-caption-weeklymostchanged' => 'This week\'s most changed',
	'articleFeedback-table-caption-recentlows' => 'Recent lows',
	'articleFeedback-table-heading-page' => 'Page',
	'articleFeedback-table-heading-average' => 'Average',
	'articlefeedback-table-noratings' => '-',
	'articleFeedback-copy-above-highlow-tables' => 'This is an experimental feature.  Please provide feedback on the [$1 discussion page].',
	'articlefeedback-dashboard-bottom' => "'''Note''': We will continue to experiment with different ways of surfacing articles in these dashboards.  At present, the dashboards include the following articles:
* Pages with highest/lowest ratings: articles that have received at least 10 ratings within the last 24 hours.  Averages are calculated by taking the mean of all ratings submitted within the last 24 hours.
* Recent lows: articles that got 70% or more low (2 stars or lower) ratings in any category in the last 24 hours. Only articles that have received at least 10 ratings in the last 24 hours are included.",
	/* Special:Preferences */
	'articlefeedback-disable-preference' => "Don't show the Article feedback widget on pages",
	/* EmailCapture */
	'articlefeedback-emailcapture-response-body' => 'Hello!

Thank you for expressing interest in helping to improve {{SITENAME}}.

Please take a moment to confirm your e-mail by clicking on the link below: 

$1

You may also visit:

$2

And enter the following confirmation code:

$3

We will be in touch shortly with how you can help improve {{SITENAME}}.

If you did not initiate this request, please ignore this e-mail and we will not send you anything else.

Best wishes, and thank you,
The {{SITENAME}} team',
);

/** Message documentation (Message documentation)
 * @author Amire80
 * @author Arthur Richards
 * @author Brandon Harris
 * @author EugeneZelenko
 * @author Krinkle
 * @author Minh Nguyen
 * @author Mormegil
 * @author Nedergard
 * @author Nemo bis
 * @author Nike
 * @author Praveenp
 * @author Purodha
 * @author Raymond
 * @author Sam Reed
 * @author Siebrand
 * @author Toliño
 * @author Yekrats
 */
$messages['qqq'] = array(
	'articlefeedback' => 'The title of the feature. It is about reader feedback.
	
Please visit http://prototype.wikimedia.org/articleassess/Main_Page for a prototype installation.',
	'articlefeedback-desc' => '{{desc}}',
	'articlefeedback-survey-question-whyrated' => 'This is a question in the survey with checkboxes for the answers. The user can check multiple answers.',
	'articlefeedback-survey-answer-whyrated-contribute-rating' => 'This is a possible answer for the "Why did you rate this article today?" survey question.',
	'articlefeedback-survey-answer-whyrated-development' => 'This is a possible answer for the "Why did you rate this article today?" survey question.',
	'articlefeedback-survey-answer-whyrated-contribute-wiki' => 'This is a possible answer for the "Why did you rate this article today?" survey question.',
	'articlefeedback-survey-answer-whyrated-sharing-opinion' => 'This is a possible answer for the "Why did you rate this article today?" survey question.',
	'articlefeedback-survey-answer-whyrated-didntrate' => 'This is a possible answer for the "Why did you rate this article today?" survey question.',
	'articlefeedback-survey-answer-whyrated-other' => 'This is a possible answer for the "Why did you rate this article today?" survey question. The user can check this to fill out an answer that wasn\'t provided as a checkbox.
{{Identical|Other}}',
	'articlefeedback-survey-question-useful' => 'This is a question in the survey with "yes" and "no" (prefswitch-survey-true and prefswitch-survey-false) as possible answers.',
	'articlefeedback-survey-question-useful-iffalse' => 'This question appears when the user checks "no" for the "Do you believe the ratings provided are useful and clear?" question. The user can enter their answer in a text box.',
	'articlefeedback-survey-question-comments' => 'This is a question in the survey with a text box that the user can enter their answer in.',
	'articlefeedback-survey-submit' => 'This is the caption for the button that submits the survey.
{{Identical|Submit}}',
	'articlefeedback-survey-title' => 'This text appears in the title bar of the survey dialog.',
	'articlefeedback-survey-thanks' => 'This text appears when the user has successfully submitted the survey.',
	'articlefeedback-survey-disclaimer' => 'This text appears on the survey form below the comment field and above the submit button. $1 is a link pointing to the privacy policy. The link text is in the {{msg-mw|articlefeedback-survey-disclaimerlink}} message.',
	'articlefeedback-survey-disclaimerlink' => 'Label of the link in {{msg-mw|Articlefeedback-survey-disclaimer}}.',
	'articlefeedback-form-panel-explanation' => '{{Identical|What is this}}',
	'articlefeedback-form-panel-explanation-link' => 'Do not translate "Project:". Also translate the "ArticleFeedback" special page name at [[Special:AdvancedTranslate]].',
	'articlefeedback-form-panel-helpimprove' => 'This message should use {{SITENAME}}.',
	'articlefeedback-form-panel-helpimprove-note' => '$1 is a link pointing to the privacy policy. The link text is in the {{msg-mw|articlefeedback-form-panel-helpimprove-privacy}} message.',
	'articlefeedback-form-panel-helpimprove-email-placeholder' => '{{Optional}}',
	'articlefeedback-form-panel-helpimprove-privacy' => 'Used in {{msg-mw|articlefeedback-form-panel-helpimprove-note}}.',
	'articlefeedback-report-ratings' => "Needs plural support.
This message is used in JavaScript by module 'jquery.articleFeedback'.
$1 is an integer, and the rating count.",
	'articlefeedback-field-complete-label' => 'This is an adjective, as in the question "Is this article complete?"',
	'articlefeedback-pitch-or' => '{{Identical|Or}}',
	'articlefeedback-pitch-join-body' => 'Based on {{msg-mw|Articlefeedback-pitch-join-message}}.',
	'articlefeedback-pitch-join-accept' => '{{Identical|Create an account}}',
	'articlefeedback-pitch-join-login' => '{{Identical|Log in}}',
	'articlefeedback-privacyurl' => 'This URL can be changed to point to a translated version of the page if it exists.',
	'articleFeedback-table-heading-page' => 'This is used in the [[mw:Extension:ArticleFeedback|Article Feedback extension]].
{{Identical|Page}}',
	'articleFeedback-table-heading-average' => '{{Identical|Average}}',
	'articlefeedback-table-noratings' => '{{Optional}}

Text to display in a table cell if there is no number to be shown',
	'articleFeedback-copy-above-highlow-tables' => 'The variable $1 will contain a full URL to a discussion page where the dashboard can be discussed - since the dashboard is powered by a special page, we can not rely on the built-in MediaWiki talk page.',
	'articlefeedback-emailcapture-response-body' => 'Body of an e-mail sent to a user wishing to participate in [[mw:Extension:ArticleFeedback|article feedback]] (see the extension documentation).
* <code>$1</code> – URL of the confirmation link
* <code>$2</code> – URL to type in the confirmation code manually.
* <code>$3</code> – Confirmation code for the user to type in',
);


/** Simplified Chinese (‪中文（简体）‬)
 * @author Bencmq
 * @author Hydra
 * @author Liangent
 * @author PhiLiP
 * @author Shizhao
 * @author Xiaomingyan
 * @author 白布飘扬
 * @author 阿pp
 */
$messages['zh-hans'] = array(
	'articlefeedback' => '条目评分面板',
	'articlefeedback-desc' => '条目评分',
	'articlefeedback-survey-question-origin' => '当你开始这项统计调查的时候正在访问哪个页面？',
	'articlefeedback-survey-question-whyrated' => '请告诉我们你今天为本条目打分的原因（选择所有合适的选项）：',
	'articlefeedback-survey-answer-whyrated-contribute-rating' => '我想对条目的总体评价作贡献',
	'articlefeedback-survey-answer-whyrated-development' => '我希望我的评价能给此页带来正面的影响',
	'articlefeedback-survey-answer-whyrated-contribute-wiki' => '我想对萌娘百科做出贡献',
	'articlefeedback-survey-answer-whyrated-sharing-opinion' => '我愿意分享我的观点',
	'articlefeedback-survey-answer-whyrated-didntrate' => '我今天没有进行评价，但我希望对本功能作出反馈。',
	'articlefeedback-survey-answer-whyrated-other' => '其他',
	'articlefeedback-survey-question-useful' => '你认为提供的评分有用并清晰吗？',
	'articlefeedback-survey-question-useful-iffalse' => '为什么？',
	'articlefeedback-survey-question-comments' => '你还有什么想说的吗？',
	'articlefeedback-survey-submit' => '提交',
	'articlefeedback-survey-title' => '请回答几个问题',
	'articlefeedback-survey-thanks' => '谢谢您回答问卷。',
	'articlefeedback-survey-disclaimer' => '如果你同意依此$1发布你的意见，请提交。',
	'articlefeedback-survey-disclaimerlink' => '条款',
	'articlefeedback-error' => '发生了一个错误。请稍后重试。',
	'articlefeedback-form-switch-label' => '给本文评分',
	'articlefeedback-form-panel-title' => '给本文评分',
	'articlefeedback-form-panel-explanation' => '这是什么？',
	'articlefeedback-form-panel-explanation-link' => 'Project:条目评分工具',
	'articlefeedback-form-panel-clear' => '移除该评分',
	'articlefeedback-form-panel-expertise' => '我非常了解与本主题相关的知识（可选）',
	'articlefeedback-form-panel-expertise-studies' => '我有与其有关的萌学位',
	'articlefeedback-form-panel-expertise-profession' => '这是我专业的一部分',
	'articlefeedback-form-panel-expertise-hobby' => '个人对此有深厚的兴趣',
	'articlefeedback-form-panel-expertise-other' => '文中未列出我所了解知识的来源',
	'articlefeedback-form-panel-helpimprove' => '我想帮助改善萌娘百科，请给我发送一封电子邮件（可选）',
	'articlefeedback-form-panel-helpimprove-note' => '我们将向您发送确认电子邮件。基于$1，我们不会与任何人共享您的地址。',
	'articlefeedback-form-panel-helpimprove-privacy' => '反馈隐私政策',
	'articlefeedback-form-panel-submit' => '提交评分',
	'articlefeedback-form-panel-pending' => '你的评分尚未提交',
	'articlefeedback-form-panel-success' => '保存成功',
	'articlefeedback-form-panel-expiry-title' => '你的评分已过期',
	'articlefeedback-form-panel-expiry-message' => '请重新评估本页并重新评分。',
	'articlefeedback-report-switch-label' => '查看条目评分',
	'articlefeedback-report-panel-title' => '条目评分',
	'articlefeedback-report-panel-description' => '当前平均分。',
	'articlefeedback-report-empty' => '无评分',
	'articlefeedback-report-ratings' => '$1人评分',
	'articlefeedback-field-trustworthy-label' => '节操度',
	'articlefeedback-field-trustworthy-tip' => '你觉得本条目有足够的节操吗？',
	'articlefeedback-field-trustworthy-tooltip-1' => '没有节操！',
	'articlefeedback-field-trustworthy-tooltip-2' => '我的节操很少',
	'articlefeedback-field-trustworthy-tooltip-3' => '有很多节操',
	'articlefeedback-field-trustworthy-tooltip-4' => '相当有节操',
	'articlefeedback-field-trustworthy-tooltip-5' => '很有节操！',
	'articlefeedback-field-complete-label' => '完整性',
	'articlefeedback-field-complete-tip' => '您觉得本条目是否已经涵盖了所有必要的内容？',
	'articlefeedback-field-complete-tooltip-1' => '缺少绝大多数信息',
	'articlefeedback-field-complete-tooltip-2' => '只含有少量信息',
	'articlefeedback-field-complete-tooltip-3' => '包括了主要的信息，但是还缺少很多',
	'articlefeedback-field-complete-tooltip-4' => '包括了大部分主要的信息',
	'articlefeedback-field-complete-tooltip-5' => '完整全面',
	'articlefeedback-field-objective-label' => '客观性',
	'articlefeedback-field-objective-tip' => '你觉得本条目所描述的所有观点对相关问题的表述是否公平合理，具有代表性？',
	'articlefeedback-field-objective-tooltip-1' => '存在严重的偏见',
	'articlefeedback-field-objective-tooltip-2' => '有一定偏见',
	'articlefeedback-field-objective-tooltip-3' => '稍有偏见',
	'articlefeedback-field-objective-tooltip-4' => '没有明显的偏见',
	'articlefeedback-field-objective-tooltip-5' => '完全没有偏见',
	'articlefeedback-field-wellwritten-label' => '可读性',
	'articlefeedback-field-wellwritten-tip' => '你觉得本条目内容的组织和撰写是否精心完美？',
	'articlefeedback-field-wellwritten-tooltip-1' => '不知所云',
	'articlefeedback-field-wellwritten-tooltip-2' => '难以理解',
	'articlefeedback-field-wellwritten-tooltip-3' => '比较清晰',
	'articlefeedback-field-wellwritten-tooltip-4' => '相当清晰',
	'articlefeedback-field-wellwritten-tooltip-5' => '非常清晰',
	'articlefeedback-pitch-reject' => '以后再说',
	'articlefeedback-pitch-or' => '或者',
	'articlefeedback-pitch-thanks' => '谢谢！你的评分已保存。',
	'articlefeedback-pitch-survey-message' => '请花些时间完成简短的调查。',
	'articlefeedback-pitch-survey-accept' => '开始调查',
	'articlefeedback-pitch-join-message' => '您要创建帐户吗？',
	'articlefeedback-pitch-join-body' => '帐户将帮助您跟踪您所做的编辑，参与讨论，并成为社群的一分子。',
	'articlefeedback-pitch-join-accept' => '创建帐户',
	'articlefeedback-pitch-join-login' => '登录',
	'articlefeedback-pitch-edit-message' => '您知道您可以编辑这个页面吗？',
	'articlefeedback-pitch-edit-accept' => '编辑本页',
	'articlefeedback-survey-message-success' => '谢谢您回答问卷。',
	'articlefeedback-survey-message-error' => '出现错误。
请稍后再试。',
	'articlefeedback-privacyurl' => 'http://wikimediafoundation.org/wiki/Feedback_privacy_statement',
	'articleFeedback-table-caption-dailyhighsandlows' => '今日评分动态',
	'articleFeedback-table-caption-dailyhighs' => '评分最高的条目：$1',
	'articleFeedback-table-caption-dailylows' => '评分最低的条目：$1',
	'articleFeedback-table-caption-weeklymostchanged' => '本周最多更改',
	'articleFeedback-table-caption-recentlows' => '近期低分',
	'articleFeedback-table-heading-page' => '页面',
	'articleFeedback-table-heading-average' => '平均',
	'articleFeedback-copy-above-highlow-tables' => '这是一个实验性功能。请在 [$1 讨论页] 提供反馈意见。',
	'articlefeedback-dashboard-bottom' => "'''注意'''：我们仍将尝试用各种不同的方式在面板上组织条目。目前，此面板包括下列条目：
* 最高或最低分的条目：在过去24小时内至少得到10次评分的条目。平均值计算以过去24小时内提交的所有评分为准。
* 近期低分：过去24小时内，在任何类别得到过70%或低分（2星或更低）的条目。只会展示在过去24小时内至少得到10次评分的条目。",
	'articlefeedback-disable-preference' => '不在页面上显示条目评分工具',
	'articlefeedback-emailcapture-response-body' => '您好！

谢谢您表示愿意帮助我们改善萌娘百科。

请花一点时间，点击下面的链接来确认您的电子邮件：

$1

您还可以访问：

$2

然后输入下列确认码：

$3

我们会在短期内联系您，并向您介绍帮助我们改善萌娘百科的方式。

如果这项请求并非由您发起，请忽略这封电子邮件，我们不会再向您发送任何邮件。

祝好，致谢，
{{SITENAME}}团队',
);

/** Traditional Chinese (‪中文（繁體）‬)
 * @author Anakmalaysia
 * @author Hydra
 * @author Mark85296341
 * @author Shizhao
 * @author Waihorace
 * @author 白布飘扬
 */
$messages['zh-hant'] = array(
	'articlefeedback' => '條目評分公告板',
	'articlefeedback-desc' => '條目評分',
	'articlefeedback-survey-question-origin' => '在你開始這個調查的時候你在哪一頁？',
	'articlefeedback-survey-question-whyrated' => '請讓我們知道你為什麼今天要評價本頁（選擇所有適用的項目）：',
	'articlefeedback-survey-answer-whyrated-contribute-rating' => '我想對整體評分作出貢獻',
	'articlefeedback-survey-answer-whyrated-development' => '我希望我的評分將積極影響發展的頁面',
	'articlefeedback-survey-answer-whyrated-contribute-wiki' => '我想幫助 萌娘百科',
	'articlefeedback-survey-answer-whyrated-sharing-opinion' => '我喜歡分享我的意見',
	'articlefeedback-survey-answer-whyrated-didntrate' => '我今天沒有進行評價，但我希望對此功能進行評價',
	'articlefeedback-survey-answer-whyrated-other' => '其他',
	'articlefeedback-survey-question-useful' => '你是否相信你提供的評價是有用而且清楚的？',
	'articlefeedback-survey-question-useful-iffalse' => '為什麼？',
	'articlefeedback-survey-question-comments' => '你有什麼其他意見？',
	'articlefeedback-survey-submit' => '提交',
	'articlefeedback-survey-title' => '請回答幾個問題',
	'articlefeedback-survey-thanks' => '感謝您填寫此調查。',
	'articlefeedback-survey-disclaimer' => '若要幫助我們改善此功能，您可以將您的反饋意見匿名分享給萌娘百科社區。$1',
	'articlefeedback-survey-disclaimerlink' => '條款',
	'articlefeedback-error' => '發生了錯誤。請稍後再試。',
	'articlefeedback-form-switch-label' => '評價本頁',
	'articlefeedback-form-panel-title' => '評價本頁',
	'articlefeedback-form-panel-explanation' => '這是什麼？',
	'articlefeedback-form-panel-explanation-link' => 'Project:条目评分工具',
	'articlefeedback-form-panel-clear' => '刪除本次評分',
	'articlefeedback-form-panel-expertise' => '我非常了解與本主題相關的知識（可選）',
	'articlefeedback-form-panel-expertise-studies' => '我有與其有關萌學學位',
	'articlefeedback-form-panel-expertise-profession' => '這是我專業的一部分',
	'articlefeedback-form-panel-expertise-hobby' => '這是一個深刻個人興趣',
	'articlefeedback-form-panel-expertise-other' => '我的知識來源不在此列',
	'articlefeedback-form-panel-helpimprove' => '我想幫助改善萌娘百科，請給我發送一封電子郵件（可選）',
	'articlefeedback-form-panel-helpimprove-note' => '我們將向您發送確認電子郵件。基於$1，我們不會與第三方分享您的地址。',
	'articlefeedback-form-panel-helpimprove-privacy' => '反饋隱私政策',
	'articlefeedback-form-panel-submit' => '提交評分',
	'articlefeedback-form-panel-pending' => '你的評分尚未提交',
	'articlefeedback-form-panel-success' => '保存成功',
	'articlefeedback-form-panel-expiry-title' => '你的評分已過期',
	'articlefeedback-form-panel-expiry-message' => '請重新評估本頁並重新評分。',
	'articlefeedback-report-switch-label' => '查看本頁評分',
	'articlefeedback-report-panel-title' => '本頁評分',
	'articlefeedback-report-panel-description' => '目前平均評分。',
	'articlefeedback-report-empty' => '無評分',
	'articlefeedback-report-ratings' => '$1 評級',
	'articlefeedback-field-trustworthy-label' => '節操度',
	'articlefeedback-field-trustworthy-tip' => '你覺得這個頁面有足夠的節操嗎？',
	'articlefeedback-field-trustworthy-tooltip-1' => '沒有節操！',
	'articlefeedback-field-trustworthy-tooltip-2' => '我的節操很少',
	'articlefeedback-field-trustworthy-tooltip-3' => '有很多節操',
	'articlefeedback-field-trustworthy-tooltip-4' => '相當有節操',
	'articlefeedback-field-trustworthy-tooltip-5' => '很有節操！',
	'articlefeedback-field-complete-label' => '完成',
	'articlefeedback-field-complete-tip' => '您覺得此頁內容基本上是否已經全面涵蓋了該主題相關的內容？',
	'articlefeedback-field-complete-tooltip-1' => '缺少絕大多數信息',
	'articlefeedback-field-complete-tooltip-2' => '包含一些信息',
	'articlefeedback-field-complete-tooltip-3' => '包含關鍵信息，但還有缺少',
	'articlefeedback-field-complete-tooltip-4' => '包含大部分關鍵的信息',
	'articlefeedback-field-complete-tooltip-5' => '全面覆盖',
	'articlefeedback-field-objective-label' => '客觀性',
	'articlefeedback-field-objective-tip' => '你覺得本頁所顯示的觀點是否對本主題公平，能反映多方的意見？',
	'articlefeedback-field-objective-tooltip-1' => '嚴重偏見',
	'articlefeedback-field-objective-tooltip-2' => '有些偏見',
	'articlefeedback-field-objective-tooltip-3' => '稍有偏見',
	'articlefeedback-field-objective-tooltip-4' => '沒有明顯的偏見',
	'articlefeedback-field-objective-tooltip-5' => '完全不帶偏見',
	'articlefeedback-field-wellwritten-label' => '可讀性',
	'articlefeedback-field-wellwritten-tip' => '你覺得此頁內容組織和撰寫是否完美？',
	'articlefeedback-field-wellwritten-tooltip-1' => '不可理解',
	'articlefeedback-field-wellwritten-tooltip-2' => '很難理解',
	'articlefeedback-field-wellwritten-tooltip-3' => '足够清晰',
	'articlefeedback-field-wellwritten-tooltip-4' => '清楚明確',
	'articlefeedback-field-wellwritten-tooltip-5' => '非常清晰',
	'articlefeedback-pitch-reject' => '也許以後再說',
	'articlefeedback-pitch-or' => '或者',
	'articlefeedback-pitch-thanks' => '謝謝！您的評分已保存。',
	'articlefeedback-pitch-survey-message' => '請花一點時間來完成簡短的調查。',
	'articlefeedback-pitch-survey-accept' => '開始調查',
	'articlefeedback-pitch-join-message' => '你想要創建帳戶嗎？',
	'articlefeedback-pitch-join-body' => '帳戶將幫助您跟蹤您所做的編輯，參與討論，並成為社區的一部分。',
	'articlefeedback-pitch-join-accept' => '創建帳戶',
	'articlefeedback-pitch-join-login' => '登入',
	'articlefeedback-pitch-edit-message' => '您知道您可以編輯此頁嗎？',
	'articlefeedback-pitch-edit-accept' => '編輯此頁',
	'articlefeedback-survey-message-success' => '謝謝您回答問卷。',
	'articlefeedback-survey-message-error' => '出現錯誤！
請稍後再試。',
	'articlefeedback-privacyurl' => 'http://wikimediafoundation.org/wiki/Feedback_privacy_statement',
	'articleFeedback-table-caption-dailyhighsandlows' => '今天的新鮮事',
	'articleFeedback-table-caption-dailyhighs' => '最高評級的頁面：$1',
	'articleFeedback-table-caption-dailylows' => '最低評級的頁面：$1',
	'articleFeedback-table-caption-weeklymostchanged' => '本週最多改變',
	'articleFeedback-table-caption-recentlows' => '近期低點',
	'articleFeedback-table-heading-page' => '頁面',
	'articleFeedback-table-heading-average' => '平均',
	'articleFeedback-copy-above-highlow-tables' => '這是一個試驗性的功能。請在[$1 討論頁]提供反饋意見。',
	'articlefeedback-dashboard-bottom' => "'''注意'''：我們仍將嘗試用各種不同的方式在面板上組織條目。目前，此面板包括下列條目：
* 最高或最低分的頁面：在過去24小時內至少得到10次評分的條目。平均值計算以過去24小時內提交的所有評分為準。
* 近期低分：過去24小時內，在任何類別得到過70%或低分（2星或更低）的條目。只會展示在過去24小時內至少得到10次評分的條目。",
	'articlefeedback-disable-preference' => '不在頁面顯示條目反饋部件',
	'articlefeedback-emailcapture-response-body' => '您好！

謝謝您表示願意幫助我們改善{{SITENAME}}。

請花一點時間，點擊下面的鏈接來確認您的電子郵件：

$1

您還可以訪問：

$2

然後輸入下列確認碼：

$3

我們會在短期內聯繫您，並向您介紹幫助我們改善{{SITENAME}}的方式。

如果這項請求並非由您發起，請忽略這封電子郵件，我們不會再向您發送任何郵件。

祝好，致謝，
{{SITENAME}}團隊',
);

