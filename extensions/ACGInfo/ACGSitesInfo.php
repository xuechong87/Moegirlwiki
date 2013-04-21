<?php
/**
 * 安全设置调用
 */
if (!defined('MEDIAWIKI')) {
    die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}
 
/**
 * 扩展的基本信息
 */
$wgExtensionCredits['other'][] = array(
    'path'           => __FILE__,
    'name'           => 'ACGInfo',
    'version'        => '1.0 beta',
    'author'         => 'dreamon',
	'url'            => '',
    'descriptionmsg' => '用于通过API调用,显示指定ID的视频信息(网站仅限于avfun,bilibili,niconico)',

);

$wgHooks['ParserFirstCallInit'][] = 'efSampleParserInit';
//<ACGInfo id="87033"></ACGInfo>
// Hook our callback function into the parser
function efSampleParserInit( Parser &$parser ) {
        $parser->setHook( 'ACGInfo', 'ShowHTMLInfo' );
        return true;
}

 
// Execute 
function ShowHTMLInfo( $input, array $args, Parser $parser, PPFrame $frame ) {
        $id = $args['id'];
		$recordStr = file_get_contents("http://api.bilibili.tv/view?type=json&appkey=ee70e4476a107242&id=$id&page=1");
		if ($recordStr == 'error') {
            $title = 'API错误';
        } else {
            $json = json_decode($recordStr);
            $title = $json->title;
			$pic = $json->pic;
			$description = $json->description;
			$tag = $json->tag;
			$play = $json->play;
			$review = $json->review;
			$favorites = $json->favorites;
        }
        $str = <<<Info
<table class="wikitable" width="80%">
<tr>
<td width="5" rowspan="3" style="background:#0088ff;"> </td>
<td width="120" height="90" rowspan="2"> <img src="$pic" /> </td>

<td width="490" colspan="2"><a href="http://acg.tv/av$id"><b>$title</b></a>
</td></tr>
<tr>
<td width="80" colspan="2">简介:$description
</td></tr>
<tr>
<td height="10"><a href="http://acg.tv/av$id"><small>av$id</small></a></td>

<td><font color="#999999"><small>Tag:$tag</small></font></td>
<td width="200"><font color="#999999"><small>播放:$play 评论:$review 收藏:$favorites</small></font>
</td></tr>
</table>
Info;
        return $str;
        //return htmlspecialchars($str, ENT_COMPAT | ENT_XHTML, "UTF-8");
}
?>