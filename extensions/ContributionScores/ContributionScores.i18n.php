<?php
/**
 * Internationalisation file for extension ContributionScores.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'contributionscores'                 => 'Contribution scores',
	'contributionscores-desc'            => 'Polls the wiki database for highest [[Special:ContributionScores|user contribution volume]]',
	'contributionscores-info'            => "Scores are calculated as follows:
*One (1) point for each unique page edited
*Square root of (total edits made) - (total unique pages) * 2
Scores calculated in this manner weight edit diversity over edit volume.
Basically, this score measures primarily unique pages edited, with consideration for high edit volume - assumed to be a higher quality page.",
	'contributionscores-top'             => '(Top $1)',
	'contributionscores-days'            => 'Last {{PLURAL:$1|day|$1 days}}',
	'contributionscores-allrevisions'    => 'All revisions',
	'contributionscores-score'           => 'Score',
	'contributionscores-pages'           => 'Pages',
	'contributionscores-changes'         => 'Changes',
	'contributionscores-username'        => 'Username',
	'contributionscores-invalidusername' => 'Invalid username',
	'contributionscores-invalidmetric'   => 'Invalid metric',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author JtFuruhata
 * @author Kalan
 * @author Purodha
 * @author Raymond
 */
$messages['qqq'] = array(
	'contributionscores-desc' => 'Extension description displayed on [[Special:Version]].',
	'contributionscores-info' => 'see http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/ContributionScores/ContributionScores_body.php?view=markup

:COUNT(DISTINCT rev_page) AS page_count
:COUNT(rev_id) AS rev_count
:page_count+SQRT(rev_count-page_count)*2 AS wiki_rank',
	'contributionscores-top' => 'Second part of the headings of [[Special:ContributionScores]]. PLURAL is supported but not used by the English original message.',
	'contributionscores-days' => 'Heading of [[Special:ContributionScores]].',
	'contributionscores-allrevisions' => 'Used as a header of [[Special:ContributionScores]]',
	'contributionscores-pages' => '{{Identical|Pages}}',
	'contributionscores-username' => '{{Identical|Username}}',
);



/** Yue (粵語)
 * @author PhiLiP
 * @author Shinjiman
 */
$messages['yue'] = array(
	'contributionscores' => '貢獻分數',
	'contributionscores-desc' => '根據響wiki數據庫畀出最高嘅[[Special:ContributionScores|用戶貢獻容量]]',
	'contributionscores-info' => '分數會用下面嘅計法去計:
*每一個唯一一版編輯過嘅有1分
*(總編輯數)嘅平方根 - (總唯一頁數) * 2
響呢方面計嘅分數會睇編輯多樣性同編輯量相比。 基本噉講，呢個分數係會依主要嘅唯一編輯過嘅頁，同埋考慮高編輯量 - 假設係一篇高質量嘅文章。',
	'contributionscores-top' => '(最高$1名)',
	'contributionscores-days' => '最近$1日',
	'contributionscores-allrevisions' => '全部修訂',
	'contributionscores-score' => '分數',
	'contributionscores-pages' => '版',
	'contributionscores-changes' => '更改',
	'contributionscores-username' => '用戶名',
	'contributionscores-invalidusername' => '無效嘅用戶名',
	'contributionscores-invalidmetric' => '無效嘅公制',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author PhiLiP
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'contributionscores' => '贡献积分榜',
	'contributionscores-desc' => '统计WIKI中的[[Special:ContributionScores|用户贡献量]]排名',
	'contributionscores-info' => '分数使用以下的算法计算:
*每编辑一次记1分
*然后用（总编辑数）的平方根 - （总页面数） * 2 得出分数
分数根据编辑量以及编辑的多样性得出。这个统计榜 假设 对同一页面的编辑次数越多，编辑质量越高。',
	'contributionscores-top' => '（最多$1名）',
	'contributionscores-days' => '最近$1天',
	'contributionscores-allrevisions' => '全部修订',
	'contributionscores-score' => '分数',
	'contributionscores-pages' => '页面',
	'contributionscores-changes' => '更改',
	'contributionscores-username' => '用户名',
	'contributionscores-invalidusername' => '无效的用户名',
	'contributionscores-invalidmetric' => '无效的公制',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author PhiLiP
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'contributionscores' => '貢獻分數',
	'contributionscores-desc' => '根據在wiki數據庫中給出最高的[[Special:ContributionScores|用戶貢獻容量]]',
	'contributionscores-info' => '分數會用以下的的計分法去計算:
*每一個唯一頁面編輯過的有1分
*（總編輯數）的平方根 - （總唯一頁面數） * 2
在這方面計算的分數會參看編輯多的樣性跟編輯量相比。 基本說，這個分數是會依主要的唯一編輯過嘅頁面，以及考慮高編輯量 - 假設是一篇高質量的文章。',
	'contributionscores-top' => '（最高$1名）',
	'contributionscores-days' => '最近$1天',
	'contributionscores-allrevisions' => '全部修訂',
	'contributionscores-score' => '分數',
	'contributionscores-pages' => '頁面',
	'contributionscores-changes' => '更改',
	'contributionscores-username' => '用戶名',
	'contributionscores-invalidusername' => '無效的用戶名',
	'contributionscores-invalidmetric' => '無效的公制',
);

