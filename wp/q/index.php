<?php
include_once("./qpass_config.php");
include_once($g4_path."/common.php");

include_once("./lib_qpass_inc.php");

$g4['title'] = "Qpass 문제은행";  
$g4['body_script'] = "onload='window.focus()'";

include_once("./head_qpass.php");

if($smallCode) $targetCode = $smallCode;
else if($midCode) $targetCode = $midCode;
else if($bigCode) $targetCode = $bigCode;
else  $targetCode = "";


if($member['mb_id'] == "") {

	  echo "<p align='center' style='margin: 100px 0 100px 0;color:blue; font-size:13px'>로그인 하신 후 이용가능합니다.</p>";
}
else if($targetCode) {
	  
	  $listing_line = 10;  /* 목록수 */
//	  printf("%s,%s",$targetCode, $listing_line);
	  print_qpass_examList($targetCode, $listing_line, "desc");
}
else {

	  echo "<p align='center' style='margin: 100 0 100 0;color:blue; font-size:13px'>시험을 선택해 주세요</p>";
}


include_once("./tail_qpass.php");
?>