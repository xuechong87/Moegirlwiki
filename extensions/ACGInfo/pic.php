<?php
//解析bilibili的API并返回图片值
$recordStr = file_get_contents("http://api.bilibili.tv/view?type=json&appkey=ee70e4476a107242&id=$id&page=1");
		if ($recordStr == 'error') {
            $title = 'API错误';
        } else {
        $json = json_decode($recordStr);
        $title = $json->title;
			$pic= $json->pic;
}

header("Location:www.baidu.com"); 

?>