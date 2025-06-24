<?php
$dir = "./torrent/";
$target = $dir;

$handle  = opendir($target); // 디렉토리 open

$files = array();

// 디렉토리의 파일을 저장
while (false !== ($filename = readdir($handle))) {
    // . or .. 제외
    if($filename == "." || $filename == ".."){
        continue;
    }

    // 파일인 경우만 목록에 추가한다.
    if(is_file($target . "/" . $filename)){
        $files[] = $filename;
    }
}

closedir($handle); // 디렉토리 close

sort($files); // sort = 정렬 , rsort = 역순
$json= array();
$i=0;
foreach($files as $f)
{
	$item = array();
	$item['id']=++$i;
	$item['name']=$f;
	array_push($json,$item);
}
echo json_encode($json);