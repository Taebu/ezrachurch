<?php
//if($is_admin == "super" && preg_match("/admin_", $PHP_SELF) ) {    // 관리자 메뉴
if($is_admin == "super") {    // 관리자 메뉴
	  $catBigColor = $catMidColor = $catSmallColor = $examColor = $questionColor = "";

	  if( preg_match("/catBig/i", $PHP_SELF) ) $catBigColor = "style='color:red' ";
	  else if( preg_match("/catMid/i", $PHP_SELF) ) $catMidColor = "style='color:red' ";
	  else if( preg_match("/catSmall/i", $PHP_SELF) ) $catSmallColor = "style='color:red' ";
	  else if( preg_match("/exam/i", $PHP_SELF) ) $catExamColor = "style='color:red' ";
	  else if( preg_match("/question/i", $PHP_SELF) ) $catQuestionColor = "style='color:red' ";
	
	  echo "<a href='admin_catBig.php' $catBigColor>대분류관리</a>";
	  echo "<span style='padding-left:10px'><a href='admin_catMid.php'$catMidColor>중분류관리</a></span>";
	  echo "<span style='padding-left:10px'><a href='admin_catSmall.php'$catSmallColor>소분류관리</a></span>";

	  
	  echo "<span style='padding-left:30px'><a href='admin_exam.php'$catExamColor>시험관리</a></span>";
	  echo "<span style='padding-left:10px'><a href='admin_question.php'$catQuestionColor>문제관리</a></span>";
	  echo "<span style='padding-left:10px'><a href='admin_cvs.php?examUid=1'$catQuestionColor>문제DB관리</a></span>";

}
else {    // 사용자 메뉴

	  // 대분류 출력
	
	  echo "<form name='catTop_form' method='post' style='margin:0' action='index.php'>";
	  echo "<span style='font-weight:bold; font-size:13px'>시험선택 :</span> ";

	  echo "<select name='bigCode' onchange='bigOptChange(this.form)'>";
	  echo "<option value=''>선택하세요</option>";
	  echo get_qpass_bigCat($bigCode);
	  echo "</select>";


      // 중분류 출력
	  if($bigCode) {
		  
		    echo "<span style='padding-left:7px'>";
			echo "<select name='midCode' onchange='midOptChange(this.form)'>";
	        echo "<option value=''>전 체</option>";
			echo get_qpass_midCat($bigCode, $midCode);
	        echo "</select>";
			echo "</span>";

	  }


      // 소분류 출력
	  if($bigCode && $midCode) {
		  
		    echo "<span style='padding-left:7px'>";
			echo "<select name='smallCode' onchange='this.form.submit()'>";
	        echo "<option value=''>전 체</option>";
			echo get_qpass_smallCat($midCode, $smallCode);
	        echo "</select>";
			echo "</span>";
	  }

	  if($is_admin == "super" && $examUid) echo "<span style='padding-left:15px'><a href='admin_exam.php?examUid=$examUid' style='text-docortation:underline; color:crimson; font-size:11px'>시험관리</a></span>";

	  echo "</form>";
}


?>

<script>

function bigOptChange(f) {

      //alert(f.smallCode);  
	  
	  if( typeof(f.midCode) != "undefined" ) f.midCode.value = "";
	  if( typeof(f.smallCode) != "undefined" ) f.smallCode.value = "";

	  f.submit();
}


function midOptChange(f) {

	  if( typeof(f.smallCode) != "undefined" ) f.smallCode.value = "";
	  f.submit();
}

</script>