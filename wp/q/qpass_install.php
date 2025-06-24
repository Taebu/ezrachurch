<?php
include_once("./qpass_config.php");
include_once("$g4_path/common.php");

$file = implode("", file("./qpass_tables.sql"));
eval("\$file = \"$file\";");

$f = explode(";", $file);

for ($i=0; $i < count($f); $i++) {

	  if (trim($f[$i]) == "") continue;
      sql_query($f[$i]) or die( mysql_error() );
}

echo "<p align='center'>큐패스(Qpass)1.0 테이블이 모두 정상적으로 생성되었습니다.<br/>사용설명서를 참고하여 큐패스 팝업창을 호출하는 링크를 만드세요.</p>";
?>

