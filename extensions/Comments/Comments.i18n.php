<?php
/**
 * Internationalization file for the Comments extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author David Pean <david.pean@gmail.com>
 */
$messages['en'] = array(
	'comment-comment' => 'Comment',
	'comments-db-locked' => '<h3>Adding Comments</h3>The database is currently locked for routine database maintenance, after which it will be back to normal. Please check back later!',
	'comment-voted-label' => 'Voted',
	'comment-loading' => 'Loading...',
	'comment-auto-refresher-enable' => 'Enable Comment Auto-Refresher',
	'comment-auto-refresher-pause' => 'Pause Comment Auto-Refresher',
	'comment-reply-to' => 'Reply to',
	'comment-cancel-reply' => 'Cancel',
	'comment-block-warning' => 'Are you sure you want to permanently ignore all comments from',
	'comment-delete-warning' => 'Are you sure you want delete this comment?',
	'comment-block-anon' => 'this Anonymous user (via their IP address)',
	'comment-block-user' => 'user',
	'comment-sort-by-date' => 'Sort by Date',
	'comment-sort-by-score' => 'Sort by Score',
	'comment-show-comment-link' => 'Show Comment',
	'comment-manage-blocklist-link' => 'Manage Ignore List',
	'comment-ignore-message' => 'You are ignoring the author of this comment',
	'comment-you' => ' You',
	'comment-reply' => 'Reply',
	'comment-login-required' => 'You must be logged in to add comments',
	'comment-not-allowed' => 'You are not allowed to post comments.',
	'comment-post' => 'Post Comment',
	'comment-submit' => 'Add your Comment',
	'comment-score-text' => 'Score',
	'comment-permalink' => 'Permalink',
	'comment-delete-link' => 'Delete Comment',
	'comment-anon-name' => 'Anonymous User',
	'comment-anon-message' => '{{SITENAME}} welcomes <b>all comments</b>.  If you don\'t want to be anonymous, <a href="$1">register</a> or <a href="$2">log in</a>.  It\'s free.',
	'comment-ignore-item' => '<a href="$1">$2</a> on $3 <a href="$4">(unblock)</a>',
	'comment-ignore-no-users' => 'There are no users currently blocked.',
	'comment-ignore-remove-message' => 'Are you sure you want to unblock user <b>$1</b>\'s comments?',
	'comment-ignore-unblock' => 'Unblock',
	'comment-ignore-cancel' => 'Cancel',
	'comment-ignore-title' => 'Comment Ignore List',
	'commentignorelist' => 'Comment Ignore List',
	'comments-no-comments-of-day' => 'There are no comments of the day.', // for the <commentsoftheday/> parser hook
	'commentslogpage' => 'Comments log',
	'commentslogpagetext' => 'This is a log of comments.',
	'commentslogentry' => '', # For compatibility, don't translate this
	'commentslog-create-entry' => 'New comment',
	'comments-create-text' => '[[$1]] - $2', # Don't translate this
	'comments-time-ago' => '$1 ago',
	'comments-time-days' => '{{PLURAL:$1|one day|$1 days}}',
	'comments-time-hours' => '{{PLURAL:$1|one hour|$1 hours}}',
	'comments-time-minutes' => '{{PLURAL:$1|one minute|$1 minutes}}',
	'comments-time-seconds' => '{{PLURAL:$1|one second|$1 seconds}}',
	'log-show-hide-comments' => '$1 comment log', // For Special:Log
	// For Special:ListUsers - new commentadmin group
	'group-commentadmin' => 'Comment Administrators',
	'group-commentadmin-member' => 'Comment Administrator',
	// For Special:ListGroupRights
	'right-comment' => 'Submit comments',
	'right-commentadmin' => 'Administrate user-submitted comments',
);


$messages['zh-hans'] = array(
	'comment-comment' => '评论',
	'comments-db-locked' => '<h3>添加评论</h3>数据库被锁死，正在进行维护，请过一段时间后再来~！',
	'comment-voted-label' => '投票',
	'comment-loading' => '读取中...',
	'comment-auto-refresher-enable' => '开启评论自动刷新',
	'comment-auto-refresher-pause' => '关闭评论自动刷新',
	'comment-reply-to' => '回复给',
	'comment-cancel-reply' => '取消',
	'comment-block-warning' => '你确信你要永久的忽视全部来自这里的评论吗？',
	'comment-delete-warning' => '你确信你想删除这段评论？',
	'comment-block-anon' => '匿名用户（阿卡林~）（显示IP地址）',
	'comment-block-user' => '用户',
	'comment-sort-by-date' => '按时间顺序排列',
	'comment-sort-by-score' => '按分数高低排列',
	'comment-show-comment-link' => '显示评论',
	'comment-manage-blocklist-link' => '管理忽略评论列表',
	'comment-ignore-message' => '你忽略了来自这个人的评论',
	'comment-you' => ' 你',
	'comment-reply' => '回复',
	'comment-login-required' => '登陆后才能留言',
	'comment-not-allowed' => '你没有足够的权限来留言',
	'comment-post' => '发表评论',
	'comment-submit' => '添加你的评论',
	'comment-score-text' => '分数',
	'comment-permalink' => '永久链接',
	'comment-delete-link' => '删除评论',
	'comment-anon-name' => '未登录的阿卡林',
	'comment-anon-message' => '{{SITENAME}} 欢迎 <b>评论</b>~！  如果你不想当阿卡林, 请<a href="$1">注册</a> 或者 <a href="$2">登陆</a>。',
	'comment-ignore-item' => '<a href="$1">$2</a> 在 $3 <a href="$4">(解除小黑屋)</a>',
	'comment-ignore-no-users' => '目前没有用户被关入小黑屋。',
	'comment-ignore-remove-message' => '你确信你要把<b>$1</b>的评论移出黑名单？',
	'comment-ignore-unblock' => '解除封锁',
	'comment-ignore-cancel' => '取消',
	'comment-ignore-title' => '阿卡林掉的（忽略）评论列表',
	'commentignorelist' => '阿卡林掉的（忽略）评论列表',
	'comments-no-comments-of-day' => '目前没有今日热评', // for the <commentsoftheday/> parser hook
	'commentslogpage' => '评论日志',
	'commentslogpagetext' => '这是评论的日志',
	'commentslogentry' => '', # For compatibility, don't translate this
	'commentslog-create-entry' => '新评论',
	'comments-create-text' => '[[$1]] - $2', # Don't translate this
	'comments-time-ago' => '$1 之前',
	'comments-time-days' => '{{PLURAL:$1|一天|$1 天}}',
	'comments-time-hours' => '{{PLURAL:$1|一小时|$1 小时}}',
	'comments-time-minutes' => '{{PLURAL:$1|一分钟|$1 分钟}}',
	'comments-time-seconds' => '{{PLURAL:$1|一秒|$1 秒}}',
	'log-show-hide-comments' => '$1 评论日志', // For Special:Log
	// For Special:ListUsers - new commentadmin group
	'group-commentadmin' => '评论管理',
	'group-commentadmin-member' => '评论管理员',
	// For Special:ListGroupRights
	'right-comment' => '提交评论',
	'right-commentadmin' => '管理用户提交的评论',
);