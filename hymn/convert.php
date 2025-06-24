<?php
$dir = "./praisejesus2000/";
$dir = "./psalms_and_hymns/";
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

$encoding = 'CP949'; // 또는 'CP949' 등 파일의 실제 인코딩으로 변경
$file=$target.$f;
$content = file_get_contents($file, true);

if ($content !== false) {
    $utf8_content = iconv($encoding, 'UTF-8', $content);

    if ($utf8_content !== false) {
        file_put_contents($file, $utf8_content);
        echo "파일 인코딩 변환 성공";
    } else {
        echo "UTF-8 변환 실패";
    }
} else {
    echo "파일 읽기 실패";
}
}
?>