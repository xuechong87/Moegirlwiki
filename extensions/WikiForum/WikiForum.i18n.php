﻿<?php
/**
 * Internationalisation file for WikiForum extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Michael Chlebek
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['en'] = array(
	'wikiforum-desc' => '[[Special:WikiForum|Forum]] extension for MediaWiki',
	'wikiforum' => 'Discussion board',

	// Configuration variables -- do not translate!
	'wikiforum-day-definition-new' => '3',
	'wikiforum-max-threads-per-page' => '20',
	'wikiforum-max-replies-per-page' => '10',

	'wikiforum-anonymous' => 'Anonymous',
	'wikiforum-announcement-only-description' => 'Announcement forum (only moderators can add threads)',
	'wikiforum-by' => '$1<br />by $2',
	'wikiforum-description' => 'Description:',
	'wikiforum-forum-is-empty' => 'This forum is currently empty.
Please contact a forum administrator to have some categories and forums added.',
	'wikiforum-forum-name' => 'Forum $1',
	'wikiforum-name' => 'Name:',
	'wikiforum-button-preview' => 'Preview',
	'wikiforum-preview' => 'Preview',
	'wikiforum-preview-with-title' => 'Preview: $1',
	'wikiforum-save' => 'Save',
	'wikiforum-error-search' => 'Search error',
	'wikiforum-error-search-missing-query' => 'You must supply a term to search for!',
	'wikiforum-search-hits' => 'Found {{PLURAL:$1|one hit|$1 hits}}',
	'wikiforum-search-thread' => 'Thread: $1',
	'wikiforum-thread-deleted' => 'thread deleted',
	'wikiforum-topic-name' => 'Forum - $1',
	'wikiforum-updates' => 'Newly updated forums',

	'wikiforum-write-thread' => 'New topic',
	'wikiforum-replies' => 'Replies',
	'wikiforum-views' => 'Views',
	'wikiforum-thread' => 'Thread',
	'wikiforum-threads' => 'Threads',
	'wikiforum-latest-reply' => 'Latest reply',
	'wikiforum-latest-thread' => 'Latest thread',
	'wikiforum-forum' => 'Forum: $1 > $2',
	'wikiforum-overview' => 'Overview',
	'wikiforum-pages' => 'Pages:',
	'wikiforum-thread-closed' => 'Thread closed',
	'wikiforum-new-thread' => 'New thread',
	'wikiforum-edit-thread' => 'Edit thread',
	'wikiforum-delete-thread' => 'Delete thread',
	'wikiforum-close-thread' => 'Close thread',
	'wikiforum-reopen-thread' => 'Reopen thread',
	'wikiforum-write-reply' => 'Write a reply',
	'wikiforum-edit-reply' => 'Edit reply',
	'wikiforum-delete-reply' => 'Delete reply',
	'wikiforum-save-thread' => 'Save thread',
	'wikiforum-save-reply' => 'Save reply',
	'wikiforum-thread-title' => 'Title of your thread',
	'wikiforum-no-threads' => 'No threads are available at the moment.',

	'wikiforum-posted' => 'Posted at $1 by $2',
	'wikiforum-edited' => 'Edited at $1 by $2',
	'wikiforum-closed-text' => 'Thread was closed at $1 by $2',

	'wikiforum-cat-not-found' => 'Category not found',
	'wikiforum-cat-not-found-text' => 'Category does not exist - go back to $1',
	'wikiforum-forum-not-found' => 'Forum not found',
	'wikiforum-forum-not-found-text' => 'Forum does not exist - go back to $1',
	'wikiforum-thread-not-found' => 'Thread not found',
	'wikiforum-thread-not-found-text' => 'Thread does not exist or was already deleted - go back to $1.',

	'wikiforum-error-thread-reopen' => 'Error while reopening thread',
	'wikiforum-error-thread-close' => 'Error while closing thread',
	'wikiforum-error-general' => 'Object not found or no rights to perform this action.',
	'wikiforum-error-no-rights' => 'You don\'t have the rights to perform this action.',
	'wikiforum-error-not-found' => 'Object not found.',
	'wikiforum-error-no-text-or-title' => 'Title or text not correctly filled out.',
	'wikiforum-error-no-reply' => 'Reply not correctly filled out.',
	'wikiforum-error-double-post' => 'Double-click protection: thread already added.', // @todo FIXME: better wording
	'wikiforum-error-thread-closed' => 'Thread is currently closed. It\'s not possible to add a new reply here.',

	'wikiforum-error-delete' => 'Error while deleting',
	'wikiforum-error-sticky' => 'Error while changing sticky attribute',
	'wikiforum-error-move-thread' => 'Error while moving thread',
	'wikiforum-error-add' => 'Error while adding',
	'wikiforum-error-edit' => 'Error while editing',

	'wikiforum-add-category' => 'Add category',
	'wikiforum-edit-category' => 'Edit category',
	'wikiforum-delete-category' => 'Delete category',
	'wikiforum-add-forum' => 'Add forum',
	'wikiforum-edit-forum' => 'Edit forum',
	'wikiforum-delete-forum' => 'Delete forum',
	'wikiforum-sort-up' => 'sort up',
	'wikiforum-sort-down' => 'sort down',
	'wikiforum-remove-sticky' => 'Remove sticky',
	'wikiforum-make-sticky' => 'Make sticky',
	'wikiforum-move-thread' => 'Move thread',
	'wikiforum-paste-thread' => 'Paste thread',
	'wikiforum-quote' => 'Quote',

	// For Special:ListGroupRights
	'right-wikiforum-admin' => 'Add, edit and delete categories and forums on [[Special:WikiForum|the discussion board]]',
	'right-wikiforum-moderator' => 'Edit and delete threads and replies on [[Special:WikiForum|the discussion board]]',

	// Forum admin group, as per discussion with Jedimca0 on 30 December 2010
	'group-forumadmin' => 'Forum administrators',
	'group-forumadmin-member' => '{{GENDER:$1|forum administrator}}',
	'grouppage-forumadmin' => '{{ns:project}}:Forum administrators',
);


/** Simplified Chinese (‪中文(简体)‬)
 * @author Hzy980512
 */
$messages['zh-hans'] = array(
	'wikiforum-desc' => 'MediaWiki的[[Special:WikiForum|论坛]]扩展',
	'wikiforum' => '萌娘百科讨论板',
	'wikiforum-anonymous' => '匿名',
	'wikiforum-announcement-only-description' => '公告版块（只有版主可以发帖）',
	'wikiforum-by' => '$1<br />由$2发起',
	'wikiforum-description' => '描述：',
	'wikiforum-forum-is-empty' => '此论坛现在没有内容。请联系论坛管理员来添加分类和版块。',
	'wikiforum-forum-name' => '版块$1',
	'wikiforum-name' => '名称：',
	'wikiforum-button-preview' => '预览：',
	'wikiforum-preview' => '预览',
	'wikiforum-preview-with-title' => '预览：$1',
	'wikiforum-save' => '保存',
	'wikiforum-error-search' => '搜索错误',
	'wikiforum-error-search-missing-query' => '必须提供关键字来进行搜索！',
	'wikiforum-search-hits' => '找到{{PLURAL:$1|一个结果|$1个结果}}',
	'wikiforum-search-thread' => '帖子：$1',
	'wikiforum-thread-deleted' => '帖子已删除',
	'wikiforum-topic-name' => '版块-$1',
	'wikiforum-updates' => '有更新的论坛',
	'wikiforum-write-thread' => '新帖子',
	'wikiforum-replies' => '回复',
	'wikiforum-views' => '查看数',
	'wikiforum-thread' => '帖子',
	'wikiforum-threads' => '帖子',
	'wikiforum-latest-reply' => '最新回复',
	'wikiforum-latest-thread' => '最新帖子',
	'wikiforum-forum' => '版块：$1 > $2',
	'wikiforum-overview' => '返回总版',
	'wikiforum-pages' => '页面：',
	'wikiforum-thread-closed' => '帖子已关闭',
	'wikiforum-new-thread' => '新帖子',
	'wikiforum-edit-thread' => '编辑帖子',
	'wikiforum-delete-thread' => '删除帖子',
	'wikiforum-close-thread' => '关闭帖子',
	'wikiforum-reopen-thread' => '开放帖子',
	'wikiforum-write-reply' => '写回复',
	'wikiforum-edit-reply' => '编辑回复',
	'wikiforum-delete-reply' => '删除回复',
	'wikiforum-save-thread' => '保存帖子',
	'wikiforum-save-reply' => '保存回复',
	'wikiforum-thread-title' => '您帖子的标题',
	'wikiforum-no-threads' => '目前没有帖子可用。',
	'wikiforum-posted' => '$2发布于$1',
	'wikiforum-edited' => '$2编辑于$1',
	'wikiforum-closed-text' => '帖子在$1被$2关闭',
	'wikiforum-cat-not-found' => '分类未找到',
	'wikiforum-cat-not-found-text' => '分类不存在 - 回到$1',
	'wikiforum-forum-not-found' => '版块未找到',
	'wikiforum-forum-not-found-text' => '板块不存在-回到$1',
	'wikiforum-thread-not-found' => '帖子未找到',
	'wikiforum-thread-not-found-text' => '帖子不存在或已被删除-回到$1',
	'wikiforum-error-thread-reopen' => '开放帖子时发生了错误',
	'wikiforum-error-thread-close' => '关闭帖子时发生错误',
	'wikiforum-error-general' => '找不到对象或无权限执行该动作。',
	'wikiforum-error-no-rights' => '你没有权限执行该动作。',
	'wikiforum-error-not-found' => '找不到对象。',
	'wikiforum-error-no-text-or-title' => '标题或文本填写不正确',
	'wikiforum-error-no-reply' => '回复填写不正确。',
	'wikiforum-error-double-post' => '双击保护：帖子已增加',
	'wikiforum-error-thread-closed' => '帖子已关闭。不能发表新回复。',
	'wikiforum-error-delete' => '删除时出现错误',
	'wikiforum-error-sticky' => '置顶时出现错误',
	'wikiforum-error-move-thread' => '移动帖子时发生错误',
	'wikiforum-error-add' => '添加时发生错误',
	'wikiforum-error-edit' => '编辑时发生错误',
	'wikiforum-add-category' => '添加分类',
	'wikiforum-edit-category' => '编辑分类',
	'wikiforum-delete-category' => '删除分类',
	'wikiforum-add-forum' => '添加版块',
	'wikiforum-edit-forum' => '编辑版块',
	'wikiforum-delete-forum' => '删除版块',
	'wikiforum-remove-sticky' => '取消置顶',
	'wikiforum-make-sticky' => '置顶帖子',
	'wikiforum-move-thread' => '移动帖子',
	'wikiforum-paste-thread' => '粘贴帖子',
	'wikiforum-quote' => '引用',
	'right-wikiforum-admin' => '在[[Special:WikiForum|讨论面板]]添加、编辑和删除分类和帖子',
	'right-wikiforum-moderator' => '在[[Special:WikiForum|讨论面板]]编辑和删除帖子和回复',
	'group-forumadmin' => '论坛管理员',
	'group-forumadmin-member' => '{{GENDER:$1|论坛管理员}}',
	'grouppage-forumadmin' => '{{ns:project}}:论坛管理员',
);

$messages['zh-hant'] = array(
	'wikiforum-desc' => 'MediaWiki的[[Special:WikiForum|论坛]]扩展',
	'wikiforum' => '萌娘百科讨论板',
	'wikiforum-anonymous' => '匿名',
	'wikiforum-announcement-only-description' => '公告版块（只有版主可以发帖）',
	'wikiforum-by' => '$1<br />由$2发起',
	'wikiforum-description' => '描述：',
	'wikiforum-forum-is-empty' => '此论坛现在没有内容。请联系论坛管理员来添加分类和版块。',
	'wikiforum-forum-name' => '版块$1',
	'wikiforum-name' => '名称：',
	'wikiforum-button-preview' => '预览：',
	'wikiforum-preview' => '预览',
	'wikiforum-preview-with-title' => '预览：$1',
	'wikiforum-save' => '保存',
	'wikiforum-error-search' => '搜索错误',
	'wikiforum-error-search-missing-query' => '必须提供关键字来进行搜索！',
	'wikiforum-search-hits' => '找到{{PLURAL:$1|一个结果|$1个结果}}',
	'wikiforum-search-thread' => '帖子：$1',
	'wikiforum-thread-deleted' => '帖子已删除',
	'wikiforum-topic-name' => '版块-$1',
	'wikiforum-updates' => '有更新的论坛',
	'wikiforum-write-thread' => '新帖子',
	'wikiforum-replies' => '回复',
	'wikiforum-views' => '查看数',
	'wikiforum-thread' => '帖子',
	'wikiforum-threads' => '帖子',
	'wikiforum-latest-reply' => '最新回复',
	'wikiforum-latest-thread' => '最新帖子',
	'wikiforum-forum' => '版块：$1 > $2',
	'wikiforum-overview' => '返回总版',
	'wikiforum-pages' => '页面：',
	'wikiforum-thread-closed' => '帖子已关闭',
	'wikiforum-new-thread' => '新帖子',
	'wikiforum-edit-thread' => '编辑帖子',
	'wikiforum-delete-thread' => '删除帖子',
	'wikiforum-close-thread' => '关闭帖子',
	'wikiforum-reopen-thread' => '开放帖子',
	'wikiforum-write-reply' => '写回复',
	'wikiforum-edit-reply' => '编辑回复',
	'wikiforum-delete-reply' => '删除回复',
	'wikiforum-save-thread' => '保存帖子',
	'wikiforum-save-reply' => '保存回复',
	'wikiforum-thread-title' => '您帖子的标题',
	'wikiforum-no-threads' => '目前没有帖子可用。',
	'wikiforum-posted' => '$2发布于$1',
	'wikiforum-edited' => '$2编辑于$1',
	'wikiforum-closed-text' => '帖子在$1被$2关闭',
	'wikiforum-cat-not-found' => '分类未找到',
	'wikiforum-cat-not-found-text' => '分类不存在 - 回到$1',
	'wikiforum-forum-not-found' => '版块未找到',
	'wikiforum-forum-not-found-text' => '板块不存在-回到$1',
	'wikiforum-thread-not-found' => '帖子未找到',
	'wikiforum-thread-not-found-text' => '帖子不存在或已被删除-回到$1',
	'wikiforum-error-thread-reopen' => '开放帖子时发生了错误',
	'wikiforum-error-thread-close' => '关闭帖子时发生错误',
	'wikiforum-error-general' => '找不到对象或无权限执行该动作。',
	'wikiforum-error-no-rights' => '你没有权限执行该动作。',
	'wikiforum-error-not-found' => '找不到对象。',
	'wikiforum-error-no-text-or-title' => '标题或文本填写不正确',
	'wikiforum-error-no-reply' => '回复填写不正确。',
	'wikiforum-error-double-post' => '双击保护：帖子已增加',
	'wikiforum-error-thread-closed' => '帖子已关闭。不能发表新回复。',
	'wikiforum-error-delete' => '删除时出现错误',
	'wikiforum-error-sticky' => '置顶时出现错误',
	'wikiforum-error-move-thread' => '移动帖子时发生错误',
	'wikiforum-error-add' => '添加时发生错误',
	'wikiforum-error-edit' => '编辑时发生错误',
	'wikiforum-add-category' => '添加分类',
	'wikiforum-edit-category' => '编辑分类',
	'wikiforum-delete-category' => '删除分类',
	'wikiforum-add-forum' => '添加版块',
	'wikiforum-edit-forum' => '编辑版块',
	'wikiforum-delete-forum' => '删除版块',
	'wikiforum-remove-sticky' => '取消置顶',
	'wikiforum-make-sticky' => '置顶帖子',
	'wikiforum-move-thread' => '移动帖子',
	'wikiforum-paste-thread' => '粘贴帖子',
	'wikiforum-quote' => '引用',
	'right-wikiforum-admin' => '在[[Special:WikiForum|讨论面板]]添加、编辑和删除分类和帖子',
	'right-wikiforum-moderator' => '在[[Special:WikiForum|讨论面板]]编辑和删除帖子和回复',
	'group-forumadmin' => '论坛管理员',
	'group-forumadmin-member' => '{{GENDER:$1|论坛管理员}}',
	'grouppage-forumadmin' => '{{ns:project}}:论坛管理员',
);