<?php
$dir = "./text/";
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

foreach ($files as $f) { // 파일명 출력
	$file = file_get_contents($target.$f, true);

	$new_text = preg_replace('/\r\n\r\n/', '<br>', $file);
	$new_text= rtrim(nl2br($new_text),'<br>');
	printf("update newezra.new_hymn set nh_contents='%s' where nh_number='%s';",$new_text,intval(str_replace(".txt", "", $f)));
    echo "<br />";
}
