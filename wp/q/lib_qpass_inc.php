<?php
/*lib_qpass_inc.php*/


// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_row($result)
{
    if(function_exists('mysqli_fetch_row') && G5_MYSQLI_USE)
        $row = @mysqli_fetch_row($result);
    else
        $row = @mysql_fetch_row($result);

    return $row;
}

/* mysql 추가함수 그룹*/
function sqlFetchArrayQ($sql) 
{ 
	$result = sql_query($sql);
	$row = sql_fetch_array($result);
	//if(mysql_errno() > 0) echo "원문: ".$sql."<br/>";
	return $row;
}

function sqlFetchRow($sql) 
{ 
	$result = sql_query($sql);
	$row = sql_fetch_row($result);
	//if(mysql_errno() > 0) echo "원문: ".$sql."<br/>";
	return $row;
}

function sql_resultMsg($errno, $errorMsg) 
{ 
	if($errno > 0)
	{
		echo $errorMsg;
		exit;
	} else { 
		/*echo "<script>alert('정상 처리되었습니다.\\t');</script>";*/
	}
}

/* 권한 그룹*/
function admin_check() 
{
	global $is_admin;
	if($is_admin != "super")
		alert("관리자만 접근가능합니다.\\t", "./");
}

/* get 그룹*/
function get_bigName($bigCode) 
{
	$sql = "select big_name from qpass_catBig where big_code = '$bigCode' ";
	$bigName = sqlFetchArrayQ($sql);
	return $bigName['big_name'];
}

function get_midName($midCode) 
{
	$sql = "select mid_name from qpass_catMid where mid_code = '$midCode' ";
	$midName = sqlFetchArrayQ($sql);
	return $midName['mid_name'];
}

function get_smallName($small_code) 
{
	$sql = "select small_name from qpass_catSmall where small_code = '$small_code' ";
	$examName = sqlFetchArrayQ($sql);
	return $examName['small_name'];
}

function get_examName($uid) 
{
	$sql = sprintf("select exam_name from qpass_exam where uid = '%s' ",$uid);
	$examName = sqlFetchArrayQ($sql);
	return $examName['exam_name'];
}

function get_examComment($uid) {
	$sql = "select exam_comment from qpass_exam where uid = '$uid' ";
	$exam_comment = sqlFetchArrayQ($sql);
	return $exam_comment['exam_comment'];
}

function get_catSubject($examUid, $cat_index) 
{
	$i_add = $cat_index + 1;
	if($i_add < 10) $i_add = "0".$i_add;
	$catTitle = "cat_title".$i_add;
	$sql = sprintf("select %s from qpass_exam where uid = '%s' ",$catTitle,$examUid);
	$sub_catTitle = sqlFetchArrayQ($sql);
	return $sub_catTitle[$catTitle];
}

function get_qpass_bigCat($bigCode) 
{
	$sql = "select * from qpass_catBig order by big_code";
	$result = sql_query($sql);
	$optionText = "";
	while( $row = sql_fetch_array($result) ) {
		if($bigCode == $row['big_code'])
			$optionText .= sprintf("<option value='%s' selected>%s</option>",$row['big_code'],$row['big_name']);
		else
			$optionText .= sprintf("<option value='%s'>%s</option>",$row['big_code'],$row['big_name']);
	}
	return $optionText;
}

function get_qpass_midCat($bigCode, $midCode) 
{
	if($bigCode == "") return;
	$sql = "select * from qpass_catMid where left(mid_code, 2) = '$bigCode' order by mid_code";
	$result = sql_query($sql);
	$optionText = "";
	while( $row = sql_fetch_array($result) ) {
	if($midCode == $row['mid_code'])
		$optionText .= sprintf("<option value='%s' selected>%s</option>",$row['mid_code'],$row['mid_name']);
	else
		$optionText .= sprintf("<option value='%s'>%s</option>",$row['mid_code'],$row['mid_name']);

	}
	return $optionText;
}

function get_qpass_smallCat($midCode, $smallCode) 
{
	if($midCode == "") return;
	$sql = "select * from qpass_catSmall where left(small_code, 4) = '$midCode' order by small_code";
	$result = sql_query($sql);
	$optionText = "";
	while( $row = sql_fetch_array($result) ) {
		if($smallCode == $row['small_code'])
			$optionText .= sprintf("<option value='%s' selected>%s</option>",$row['small_code'],$row['small_name']);
	else 
		$optionText .= sprintf("<option value='%s'>%s</option>",$row['small_code'],$row['small_name']);
	}
	return $optionText;
}

function get_examOptions($small_code, $examUid, $asc="asc") 
{
	if($small_code == "") return;
	$selectText = "";
	$sql = sprintf("select uid, exam_name from qpass_exam where small_code = '%s' order by uid $asc",$small_code,$asc);
	$result = sql_query($sql);
	while( $row = sql_fetch_array($result) ) {
		if($examUid == $row['uid'])
			$selectText .= sprintf("<option value='%s' selected>%s</option>",$row['uid'],$row['exam_name']);
		else $selectText .= sprintf("<option value='%s'>%s</option>",$row['uid'],$row['exam_name']);
	} return $selectText;
}

function get_examCatOptions($examUid, $selectedIndex) 
{
	if($examUid == "")
		return;
	$selectText = "";
	$sql = "select * from qpass_exam where uid = '$examUid'";
	$result = sql_query($sql);
	$row = sql_fetch_array($result);
	if(!$row['cat_countTotal']) return;
	for($i=1;
	$i <= $row['cat_countTotal'];
	$i++) { $i_add = $i;
	$i_minus = $i - 1;
	if($i_add < 10) $i_add = "0".$i_add;
	$catTitle = $row["cat_title".$i_add];
	if($catTitle && $selectedIndex != '' && $i_minus == $selectedIndex)
		$selectText .= "<option value='$i_minus' selected>$catTitle</option>";
	else
		$selectText .= "<option value='$i_minus'>$catTitle</option>";
	}
	return $selectText;
}

function get_examCat($examUid, $selectedValue)
{
	if($examUid == "") return;
	$sql = "select * from qpass_exam where uid = '$examUid' ";
	if($examCat == "") 
		$selectText = "<option value=''>과목없음</option>";
	else { 
		$selectText = "<option value=''>선택하세요</option>";
	$catList = explode("|", $examCat);
	for($i=0;$i < sizeof($catList);$i++) {
		if( $selectedValue && trim($catList[$i]) == trim($selectedValue) )
		$selectText .= "<option value='$catList[$i]' selected>$catList[$i]</option>";
	else  $selectText .= "<option value='$catList[$i]'>$catList[$i]</option>";
	} 
	} 
	return $selectText;
}

function get_examCorrectCount($examUid, $catCount, $mb_id) 
{
	$sql = "select * from qpass_result where exam_uid = '$examUid' and mb_id = '$mb_id' ";
	$result = sql_query($sql);
	$row = sql_fetch_array($result);
	$countTotal = 0;
	for($i=1;$i <= $catCount ;$i++) 
	{
		$i_add = $i;
		if($i_add < 10) $i_add = "0".$i_add;
			$tryStr = $row["try_list".$i_add];
		$eachCount = get_correctCount($tryStr, $examUid, $i-1);
		/*echo "count: $eachCount ";exit;*/ 
		if($eachCount > 0)
		$countTotal += $eachCount;
	}
	return $countTotal;
}

function get_correctCount($tryStr, $examUid, $catIndex)
{ 
	/* 답안 리스트 추출*/ 
	$tryList = explode("|Q|", $tryStr);
	/* 정답 리스트 추출*/
	$sql = "select answer from qpass_question where exam_uid = '$examUid' and cat_index = '$catIndex' order by view_index asc, uid asc";
	/*echo $sql .$tryStr;*/ 
	$resultAns = sql_query($sql);
	$i = 0;
	$correctCount = 0;
	while( $rowAns = sql_fetch_array($resultAns) )
	{ 
		/*echo $i." : ".$rowAns[answer]." and ".$tryList[$i]."<br/>";*/ 
		$answer = str_replace(" ", "", $rowAns['answer']);
		//	echo "answer : ".$answer;
			$ansTry = str_replace(" ", "", $tryList[$i++]);
		//	echo $answer;
		if($ansTry == "") continue;
		if( $answer == $ansTry ) $correctCount++;
		else if( preg_match("/,/i", $answer) ) {
			$ansList = explode(",", $answer);
			for($j=0;$j < sizeof($ansList);$j++) {
				$answerEach = str_replace(" ", "", $ansList[$j]);
			if($answerEach == $ansTry) $correctCount++;
			  /*echo "answerEach : $answerEach<br/>";*/
			  }
		}
	}
  return $correctCount;
} 

/* print 그룹*/
function print_question_list_adm($small_code, $examUid, $selectedIndex, $questionUid) 
{
	global $question_listCount, $currentPage;
	if(!$currentPage) $currentPage = 1;
	$sql_add = "";
	if($selectedIndex != '')
		$sql_add = "and q.cat_index = '$selectedIndex' ";
	if($examUid) {
		$sql = "select q.* ";
		$common_sql = "from qpass_question q where q.exam_uid = '$examUid' $sql_add order by q.cat_index, q.view_index, q.uid";
	} else {
		$sql = "select q.*, e.uid as examUid ";
		$common_sql = "from qpass_exam e, qpass_question q where e.uid=q.exam_uid and e.small_code = '$small_code' $sql_add order by e.uid, q.cat_index, q.view_index, q.uid";
	}
	$count_sql = "select count(*) as cnt ".$common_sql;
	/*echo $count_sql;*/
	$totalLine = sqlFetchArrayQ($count_sql);
	$totalLine = $totalLine['cnt'];
	$startLine = ($currentPage-1) * $question_listCount;
	$sql .= $common_sql." limit $startLine, $question_listCount";

	/*echo $sql." and $startLine";*/
	/*echo $sql." and $startLine";*/
	$result = sql_query($sql);
	$row = sql_fetch_array($result);
	echo "<table width='800' align='center' cellpadding='0' cellspacing='0' bordercolor='#D9D9D9' bordercolorlight='#D9D9D9' bordercolordark='white' style='margin-top:3px' border='1'>";
	echo "<tr>";
	echo "<td width='30' class='title02_qpass'>순서</td>";
	echo "<td width='100' class='title02_qpass'>시험명</td>";
	echo "<td width='80' class='title02_qpass'>과목명</td>";
	echo "<td width='' class='title02_qpass'>문 제</td>";
	echo "<td width='60' class='title02_qpass'>우선순위</td>";
	echo "<td class='title02_qpass'>처리</td>";
	echo "</tr>";

	if(!$row)
	{
		 $smallName = get_smallName($small_code);
		echo "<tr height='100'><td colspan='6' align='center'><span style='color:#bb0000'>등록된 문제가 없습니다.</span></td></tr></table>";
		return;
	}

	$lineCount = 1;
	$revCount = $totalLine - $startLine;
	do {
		if($questionUid == $row['uid']) {
			$lineColor = ";color:blue";
	} else
		$lineColor = "";
	if($row['examUid']) $examUid = $row['examUid'];
	$examName = get_examName($examUid);
	$catSubject = get_catSubject($examUid, $row['cat_index']);
	if($catSubject == "") $catSubject = "&nbsp;";
	$questionText = sprintf("<a href='admin_question.php?questionUid=%s' onfocus='this.blur()' style='%s'>%s</a>",$row['uid'],$lineColor,$row['question']);
	$indexText =  sprintf("<input type='text' name='view_index%s' maxlength='5' value='%s' class='ed' style='width:30;text-align:center %s'>",$row['uid'],$row['view_index'],$lineColor);
	$processText = sprintf("<input type='button' value='수정' style='cursor:pointer;padding-top:1px;height:19px;width:30px;font-size:11px %s' onclick=\"question_modify('%s')\" onfocus='this.blur()'>",$lineColor,$row['uid']);
	$processText .= sprintf(" &nbsp;<input type='button' value='삭제' style='cursor:pointer;padding-top:1px;height:19px;width:30px;font-size:11px %s' onclick=\"question_delete('%s')\" onfocus='this.blur()'>",$lineColor,$row['uid']);
	echo "<tr>";
	echo "<td align='center' style='$lineColor'>$revCount</td>";
	echo "<td align='center'><a href='admin_exam.php?examUid=$examUid' style='$lineColor'>$examName</a></td>";
	echo "<td align='center' style='$lineColor'>$catSubject</td>";
	echo "<td width=''>$questionText</td>";
	echo "<td width='' align='center'>$indexText</td>";
	echo "<td width='80' align='center'>$processText</td>";
	echo "</tr>";
	$lineCount++;
	$revCount--;
	} while( $row = sql_fetch_array($result) );
	echo "</table>";
	print_qpass_pages($totalLine, $question_listCount, $currentPage, "&small_code=$small_code&examUid=$examUid&cat_index=$selectedIndex");
}

function print_qpass_examList_adm($smallCode, $view_line, $uid) 
{
	global $currentPage;
	if(!$currentPage) $currentPage = 1;
	$common_sql = sprintf("from qpass_exam where small_code = '%s' order by uid desc",$smallCode);
	$count_sql = "select count(*) as cnt ".$common_sql;
	/*echo $count_sql;*/ $totalLine = sqlFetchArrayQ($count_sql);
	$totalLine = $totalLine['cnt'];
	$startLine = ($currentPage-1) * $view_line;
	$lineCount = 1;
	$sql = "select * ".$common_sql." limit $startLine, $view_line";
	/*echo $sql;*/ $resultExam = sql_query($sql);
	$rowExam = sql_fetch_array($resultExam);
	 /* 제목라인*/
	 echo "<table width='700' align='center' cellpadding='2' cellspacing='0' bordercolor='#D9D9D9' bordercolorlight='#D9D9D9' bordercolordark='white' style='margin:0 auto;' border='1'>";
	echo "<tr>";
	echo "<td width='30' class='title02_qpass'>순서</td>";
	echo "<td width='' class='title02_qpass'>시험명</td>";
	echo "<td width='100' class='title02_qpass'>등록일시</td>";
	echo "<td width='40' class='title02_qpass'>문제수</td>";
	echo "<td width='80' class='title02_qpass'>시험노출</td>";
	echo "<td class='title02_qpass'>처리</td>";
	echo "</tr>";
	if($rowExam == "") { echo "<tr height='100'> <td colspan='6' align='center' style='color:#bb0000'>등록된 시험이 없습니다. </td> </tr> </table>";
	return;
	} $revCount = $totalLine - $startLine;
	do { 
		if($uid == $rowExam['uid']) 
		{
			$lineColor = ";color:blue";
		} else $lineColor = "";

		$sql = sprintf("select count(*) as cnt from qpass_question where exam_uid = '%s' ",$rowExam['uid']);
		$questionCount = sqlFetchArrayQ($sql);
		$questionCount = $questionCount['cnt'];
		
		$viewText = sprintf("<select id='view_ox%s' style='%s'>",$rowExam['uid'],$lineColor);
		
		if($rowExam['view_ox'] == 1) $viewText .= "<option value='1' selected>예</option> <option value='-1'>아니오</option></select>";
		else if($rowExam['view_ox'] == -1) $viewText .= "<option value='1'>예</option> <option value='-1' selected>아니오</option></select>";
		
		$processText = "<input type='button' value='수정' style='cursor:pointer;padding-top:1px;height:19px;width:30px;font-size:11px $lineColor' onclick=\"exam_modify('$rowExam[uid]')\" onfocus='this.blur()'>";
		$processText .= " &nbsp;<input type='button' value='삭제' style='cursor:pointer;padding-top:1px;height:19px;width:30px;font-size:11px $lineColor' onclick=\"exam_delete('$rowExam[uid]')\" onfocus='this.blur()'>";
		$processText .= " &nbsp;<input type='button' value='문제관리' style='cursor:pointer;padding-top:1px;height:19px;width:55px;font-size:11px $lineColor' onclick=\"location.href='admin_question.php?examUid=$rowExam[uid]'\" onfocus='this.blur()'>";
		
		echo "<tr>";
		echo "<td align='center' style='$lineColor'>$revCount</td>";
		echo "<td><a href='admin_exam.php?uid=$rowExam[uid]' style='$lineColor'>$rowExam[exam_name]</a></td>";
		echo "<td align='center' style='$lineColor'>".substr($rowExam['reg_time'], 0,16)."</td>";
		echo "<td align='center' style='$lineColor'>$questionCount</td>";
		echo "<td align='center'>$viewText</td>";
		echo "<td align='center' width='140'>$processText</td>";
		echo "</tr>";
		$revCount--;
	} while( $rowExam = sql_fetch_array($resultExam) );
	echo "</table>";
	
	print_qpass_pages($totalLine, $view_line, $currentPage, "exam");
	return;
}

function print_qpass_examList($targetCode, $viewLine, $asc="asc") 
{
	global $currentPage, $member;
	
	if(!$currentPage) $currentPage = 1;
	$codeLen = strlen($targetCode);
	
	if($codeLen < 2) return;
	
	$where_sql = sprintf("where view_ox = 1 and left(small_code, $codeLen) = '%s' ",$targetCode);
	$common_sql = "from qpass_exam ".$where_sql ;
	$count_sql = "select count(*) as cnt ".$common_sql;

	/* echo $count_sql; */
	$totalLine = sqlFetchArrayQ($count_sql);
	$totalLine = $totalLine['cnt'];

	$startLine = ($currentPage-1) * $viewLine;
	$lineCount = 1;
	
	/* 제목라인*/
	echo "<table width='800' align='center' cellpadding='5' cellspacing='0' style='margin-top:7px' border='0'>";
	echo "<tr height='30'>";
	echo "<td width='35' class='td_border_commonTitle_qpass'>순서</td>";
	echo "<td width='' class='td_border_commonTitle_qpass'>분류</td>";
	echo "<td width='' class='td_border_commonTitle_qpass'>시험명</td>";
	echo "<td width='40' class='td_border_commonTitle_qpass'>문제수</td>";
	echo "<td width='' class='td_border_commonTitle_qpass'>출제일시</td>";
	echo "<td width='80' class='td_border_commonTitle_qpass'>응시하기</td>";
	echo "<td width='80' class='td_border_rightTitle_qpass'>응시결과</td>";
	echo "</tr>";
	if($totalLine == 0) {
		echo "<tr height='100'><td colspan='7' class='ed' align='center'>등록된 시험이 없습니다.</td></tr>";
	
	echo "</table>";
	return;
	}

	$sql = "select uid, small_code, exam_name, reg_time, cat_countTotal ".$common_sql;

	if($asc) $sql .= "order by uid $asc";
	$sql .= " limit $startLine, $viewLine";
	//echo $sql;
	$result = sql_query($sql);
	$revCount = $totalLine - $startLine;
	while( $row = sql_fetch_array($result))
	{
		/* 셀 보드 설정*/
		if($lineCount < $viewLine && $revCount > 1) {
		$common_style = "td_border_common_qpass";
		$right_style = "td_border_right_qpass";
	} else {
		$common_style = "td_border_bottom_qpass";
		$right_style = "td_border_bottomright_qpass";
	}
//	print_r($row);
//    [uid] => 9
//    [small_code] => 101010
//    [exam_name] => CH23_20140919
//    [reg_time] => 2014-10-25 14:41:21
//    [cat_countTotal] => 1

	$bigName = get_bigName(substr($row['small_code'], 0,2));
	$midName = get_midName(substr($row['small_code'], 0,4));
	$smallName = get_smallName($row['small_code']);
	$catText = sprintf("%s &gt; %s &gt; %s",$bigName,$midName,$smallName);
	$sql = sprintf("select count(*) as cnt from qpass_question where exam_uid = '%s' ",$row['uid']);
	$questionCount = sqlFetchArrayQ($sql);
	$questionCount = $questionCount['cnt'];
	$regText = substr($row['reg_time'], 0,16);

	if($questionCount > 0)
		$takeExamText = sprintf("<a href='qpass_takeExam.php?examUid=%s'><img src='./img/btn_takeExam.gif' width='57' height='20'></a>",$row['uid']);
	else { 
		$takeExamText = "-";
	} 

	/* 응시결과 추출*/
	if($member['mb_id']) 
	{
		$sql = sprintf("select count(*) as cnt from qpass_result where mb_id = '%s' and exam_uid = '%s' ",$member['mb_id'],$row['uid']);
		/*echo $sql;*/
		//list($resultCount) = sqlFetchArrayQ($sql);
		$resultCount = sqlFetchArrayQ($sql);
		$resultCount = $resultCount['cnt'];
	}
	//echo "resultCount : ".$resultCount;
	//echo "<br>";
	if($resultCount > 0) {
		$correctCount = get_examCorrectCount($row['uid'], $row['cat_countTotal'], $member['mb_id']);
	$score = ceil( ($correctCount * 100) / $questionCount );
	$resultText = sprintf("%s/%s (%s점)",$correctCount,$questionCount,$score);
	} else {
		$resultText = "<span style='color:#bb8800'>응시전</span>";
	}  
	echo "<tr height='27'>";
	printf("<td width='40' align='center' class='%s'>%s</td>",$common_style,$revCount);
	printf("<td width='' class='%s'>%s</td>",$common_style,$catText);
	printf("<td width='' class='%s'>%s</td>",$common_style,$row['exam_name']);
	printf("<td width='' align='center' class='%s'>%s</td>",$common_style,$questionCount);
	printf("<td width='100' align='center' class='%s'>%s</td>",$common_style,$regText);
	printf("<td width='80' align='center' class='%s'>%s</td>",$common_style,$takeExamText);
	printf("<td width='80' align='center' class='%s'>%s</td>",$right_style,$resultText);
	echo "</tr>";
	$revCount--;
	$lineCount++;
	}
	echo "</table>";
	print_qpass_pages($totalLine, $viewLine, $currentPage, "examHome");
}

function print_qpass_pages($total_line, $view_line, $currentPage, $place) 
{
	global $view_pages, $bigCode, $midCode, $smallCode, $small_code, $uid;
	if($place == "exam")
		$parameter_add = "&small_code=$small_code";
	else if($place == "examHome")
		$parameter_add = "&bigCode=$bigCode&midCode=$midCode&smallCode=$smallCode";
	else if($place)
		$parameter_add = $place;
	if($view_line)
		$total_page = ceil($total_line/$view_line);

	if($total_page <= 1)
		return;

	$page_end = ceil($currentPage/$view_pages) * $view_pages ;
	$page_start = $page_end - $view_pages + 1;

	echo "<table width='100%' cellspacing='0' cellpadding='5' style='margin-top:5px' border='0'><tr><td align='center' style='font-size:12px'>";

	if($page_end > $view_pages) echo "<a href='?currentPage=1{$parameter_add}'>[처음]</a> ";
	$next_current = $page_end-$view_pages;

	if($page_end > $view_pages) echo "<a href='?currentPage=$next_current{$parameter_add}'>[이전]</a>";
	for($i=$page_start;$i<=$page_end && $i<=$total_page;$i++){
		if($i == $currentPage) {
			echo "<span style='color:#E42101'>$i</span> ";
	} else {
		echo "<a href='?currentPage=$i{$parameter_add}'>[$i]</a> ";
	}
	}
	$next_current = $page_end+1;
	if($page_end < $total_page)
		echo "<a href='?currentPage=$next_current{$parameter_add}'>[다음]</a>";

	if($page_end < $total_page)
		echo "<a href='?currentPage=$total_page{$parameter_add}'>[맨끝]</a>";
		echo "</td></tr></table>";
	return;
}

function print_qpass_answerSheet($examUid, $mode) 
{
	if($examUid == "")
		return;
	$sql = sprintf("select * from qpass_exam where uid = '%s' ",$examUid);
	$resultExam = sql_query($sql);
	$rowExam = sql_fetch_array($resultExam);
	/* 전체 과목수 추출*/
	$course_count = $rowExam['cat_countTotal'];
	/* 전체 문제수 추출*/
	$sql = sprintf("select count(*) as cnt from qpass_question where exam_uid = '%s' ",$examUid);
	$question_total = sqlFetchArrayQ($sql);
	$question_total = $question_total['cnt'];
	//echo $question_total;
	/* 과목별 문제수 추출*/
	if($course_count == 1) $question_count[0] = $question_total;
	else {
		for($i=0;$i < $course_count;$i++)
		{ 
			$i_add = $i + 1;

			if($i_add < 10) $i_add = "0".$i_add;
			$cat_subject = $rowExam["cat_title".$i_add];
			$sql = sprintf("select count(*) as cnt from qpass_question where exam_uid = '%s' and cat_index = '%s' ",$examUid,$i);
			/*echo $sql."<br/>";*/
			$question_each = sqlFetchArrayQ($sql);
			$question_each = $question_each['cnt'];
			$question_count[$i] = $question_each;
		}
	}
	//print_r($question_count);
	$ans_count = 1;
	$max_div = $course_count - 1;
	for($i=0;$i <= $max_div;$i++) 
	{
		$i_add = $i + 1;
		if($i_add < 10)
		$i_add = "0".$i_add;
		$course_name = $rowExam["cat_title".$i_add];
		echo "<div id = 'ans$i' style='display:none;width:100%;height:100%;padding-left:4px'>";
		echo "<table width='100%' height='30' align='center' cellspacing='0' cellpadding='2'><tr><td align='center' style='color:green;font-weight:bold;border:solid 1px #ccc;border-bottom:none'>$course_name</td></tr></table>";
		echo "<table width='100%' align='center' cellspacing='0' cellpadding='2' border='0'>";

		for($j=0;$j < $question_count[$i];$j++) 
		{
			/* 과목별 문제수만큼 루프*/
			/* 셀 보드 설정*/ 
			if($j < $question_count[$i]-1) {
				$common_style = "td_border_common_qpass";
				$right_style = "td_border_right_qpass";
			} else {
				$common_style = "td_border_bottom_qpass";
				$right_style = "td_border_bottomright_qpass";
			} 

			if($ans_count > $question_total)
				continue;
			$chooseStyle = get_chooseStyle($examUid, $i, $j);

			 printf("<tr height='25'> <td id='ans_num%s' width='23' valign='bottom' align='center' class='$common_style' style='padding-bottom:3px;font-weight:bold;color:green'><a href='javascript:move2question(%s)' style='color:green' onfocus='this.blur()'>%s</a></td>",$ans_count,$j,$ans_count);
			//printf("chooseStyle :%s",$chooseStyle);
			if($chooseStyle == 1) {
				printf("<td id='ans_td%s1' width='20' align='center' class='%s'><a href='javascript:answer_check(%s, 1)' onfocus='this.blur()'><img id='answer%s1' src='./img/num1.gif' align='absmiddle'></td>",$ans_count,$common_style,$ans_count,$ans_count);
				printf("<td id='ans_td%s2' width='20' align='center' class='%s'><a href='javascript:answer_check(%s, 2)' onfocus='this.blur()'><img id='answer%s2' src='./img/num2.gif' align='absmiddle'></td>",$ans_count,$common_style,$ans_count,$ans_count);
				printf("<td id='ans_td%s3' width='20' align='center' class='%s'><a href='javascript:answer_check(%s, 3)' onfocus='this.blur()'><img id='answer%s3' src='./img/num3.gif' align='absmiddle'></td>",$ans_count,$common_style,$ans_count,$ans_count);
				printf("<td id='ans_td%s4' width='20' align='center' class='%s'><a href='javascript:answer_check(%s, 4)' onfocus='this.blur()'><img id='answer%s4' src='./img/num4.gif' align='absmiddle'></td>",$ans_count,$right_style ,$ans_count,$ans_count);
				printf("<td id='ans_td%s5' width='20' align='center' class='%s'><a href='javascript:answer_check(%s, 5)' onfocus='this.blur()'><img id='answer%s5' src='./img/num5.gif' align='absmiddle'></td>",$ans_count,$right_style ,$ans_count,$ans_count);
				echo "</tr>";
			} else {
				printf("<td id='ansInsert_td%s' colspan='5' class='%s'><input type='text' id='ansInsert_text%s' maxlength='10' value='' class='ed' style='width:99%'> <span id='ansInsert_span%s' style='display:none'></span></td> </tr>",$ans_count,$right_style,$ans_count,$ans_count);
			}
			$ans_count++;
		} /* for($j=0;$j < $question_count[$i];$j++)  */
	echo "</table>";
	echo "<p id='btnFinish{$i}' align='center' style='display:block;margin: 20px 0 0 0'><input type='button' value='답안제출' onclick='finish_exam($i);' style='color:#222222;cursor:pointer;border:2px outset;background-color:#f0f0f0;width:65px;height:21px;padding-top:1px;' onfocus='this.blur()'></p>";
	echo "<p id='resultDisplay{$i}' align='center' style='margin: 20px 0 0 0'></p>";
	echo "</div>";
	} /* for($i=0;$i <= $max_div;$i++) */
}

function get_chooseStyle($examUid, $i, $j)
{
	$sql = "select answer01 from qpass_question ";
	$sql.= sprintf("where exam_uid = '%s' and cat_index = '%s' order by view_index asc, uid asc limit %s, 1",$examUid,$i,$j);
	/* echo $sql;*/
	$answer01 = sqlFetchArrayQ($sql);
	$answer01 = $answer01['answer01'];
	/*return 1;*/
	if($answer01)
		return 1;
	else
		return 0;
}

function print_qpass_examSheet($examUid, $mode="") 
{
	//	echo "print_qpass_examSheet";
	if($examUid == "")
		return;
	global $member;
	$sql = sprintf("select * from qpass_exam where uid = '%s' ",$examUid);
	$resultExam = sql_query($sql);
	$rowExam = sql_fetch_array($resultExam);

	/* 전체 과목수 추출*/
	$course_count = $rowExam['cat_countTotal'];

	/* 전체 문제수 추출*/
	$sql = sprintf("select count(*) as cnt from qpass_question where exam_uid = '%s' ",$examUid);
	$question_total = sqlFetchArrayQ($sql);
	$question_total = $question_total['cnt'];

	/* 답안/정답 저장폼 구성*/
	$questionCount = 1;
	for($i=0;$i < $course_count;$i++)
	{ 
		$i_add = $i + 1;
		if($i_add < 10) $i_add = "0".$i_add;
		$cat_subject = $rowExam["cat_title".$i_add];
		$sqlTry = sprintf("select try_list%s from qpass_result where mb_id = '%s' and exam_uid = '%s' ",$i_add,$member['mb_id'],$examUid);
		/*echo $sqlTry;*/
		$resultTry = sql_query($sqlTry);
		$rowTry = sql_fetch_array($resultTry);
		$tryList = explode("|Q|", $rowTry["try_list".$i_add]);
		$tryCountMin = $tryCount - 1;

		$sql = "select count(*) as cnt from qpass_question where exam_uid = '$examUid' and cat_index = '$i' ";
		$cat_questionCount = sqlFetchArrayQ($sql);
		$cat_questionCount = $cat_questionCount['cnt'];

		$sqlReal = sprintf("select answer from qpass_question where exam_uid = '%s' and cat_index = '%s' order by view_index asc, uid asc",$examUid,$i);
		/*if($i > 1) echo $sqlReal."<br/>";*/ 
		$resultReal = sql_query($sqlReal);

		for($j=0;$j < $cat_questionCount;$j++)
		{
			/*try$questionCount*/
			printf("<input type='hidden' id='ans_try%s' size='3' value='%s'>",$questionCount,$tryList[$j]);
			printf("<input type='hidden' id='ans_trySame%s' size='3' value='%s'>",$questionCount,$tryList[$j]);

			/* 복사본 준비*/
			$rowReal = sql_fetch_array($resultReal);
			$ansReal = $rowReal['answer'];

			/*ans$questionCount*/
			printf("<input type='hidden' id='ans_real%s' size='2' value='%s'>",$questionCount,$ansReal);
			$questionCount++;
		}
	}

	/* 과목별 문제수 추출*/
	if($course_count == 1)
		$question_count[0] = $question_total;
	else {
		for($i=0;$i < $course_count;$i++) 
		{
			$i_add = $i + 1;

			if($i_add < 10)
				$i_add = "0".$i_add;
			$cat_subject = $rowExam["cat_title".$i_add];
			$sql = "select count(*) as cnt from qpass_question where exam_uid = '$examUid' and cat_index = '$i' ";
			/*echo $sql."<br/>";*/
			$question_each = sqlFetchArrayQ($sql);
			$question_each = $question_each['cnt'];
			$question_count[$i] = $question_each;
		}
	}

	/* 과목별 구역수 추출*/
	for($i=0;$i < $course_count;$i++) 
	{
		$five_div[$i] = ceil($question_count[$i] / 5);
		/*echo $five_div[$i]."<br/>";*/ 
		$max_fiveCount = $five_div[$i] - 1;
		printf("<script>max_five[%s] = '%s';</script>",$i,$max_fiveCount);
	}

	$count = 1;
	$max_div = $course_count - 1;
	
	for($i=0;$i <= $max_div;$i++ ) 
	{
		/* 교시수만큼 루프*/
		/* 문제 추출*/
		$i_add = $i + 1;
		if($i_add < 10)
			$i_add = "0".$i_add;
		$cat_subject = $rowExam["cat_title".$i_add];
		$sql = sprintf("select * from qpass_question where exam_uid = '%s' and cat_index = '%s' order by view_index asc, uid asc",$examUid,$i);
		//echo $sql;
		$resultQuestion = sql_query($sql);
		$rowQuestion = sql_fetch_array($resultQuestion);
		$div_count = 1;

		//printf("j:%s, five_div : %s ",$j,$five_div[0]);
		/* 교시내 구역 카운터*/
		for($j=0;$j < $five_div[$i];$j++ ) 
		{
			/* 5문제 구역만큼 루프.*/
			/*if($member[mb_id] == 'test' && $j==0) echo "i : $i and ".$count;*/ 
				if($count > $question_total) {  
				/*echo "<script>document.test_form.end_i.value='$i';document.test_form.end_j.value='$j';</script>";*/
				break;
				}
			printf("<div id = 'div%s%s' style='display:none;width:100%%;height:100%%'>",$i,$j);
			echo "<table width='100%' cellspacing='0' cellpadding='0' style='margin-top:0px;' border='0'><tr>";
			echo "<td width='50%' valign='top' class='ed' style='padding-top:5px;'>";

			for($k=0;$k < 3;$k++ ) 
			{
				/* 5문제중 좌측 3문제 보이게 처리*/
				/*if($k==0) echo "<input type='hidden' id='start$i$j' value='$count' size='3'>";*/
				if($count > $question_total)
					continue;
				if($div_count > $question_count[$i])
					continue;

				/* 과목별 문제수보다 많으면 패스*/
				if($rowQuestion['answer01'])
					$chooseStyle = 1;
				else {
					$chooseStyle = 0;
				}
				echo "<div id='ques_ox{$count}' style='margin:0;position:absolute;background-repeat:no-repeat' width='55' height='45'><img src='./img/blank.gif' width='55' height='45'></div>";
				echo "<table width='100%' height='150' cellspacing='0' cellpadding='5' style='margin-bottom:10px;' border='0'>";
				echo "<tr> <td valign='top' align='right' width='25' class='count_qpass'>{$count}.</td> <td valign='top' class='question01_qpass'> ".nl2br( trim($rowQuestion['question']) )."</td> </tr>";
				
				if($chooseStyle == 1) 
				{   
				  printf("<tr> <td id='quesitem%s1' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 1)' onfocus='this.blur()'>① %s</a></td> </tr>",$count,$count,$rowQuestion['answer01']);
				  printf("<tr> <td id='quesitem%s2' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 2)' onfocus='this.blur()'>② %s</a></td> </tr>",$count,$count,$rowQuestion['answer02']);
				  printf("<tr> <td id='quesitem%s3' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 3)' onfocus='this.blur()'>③ %s</a></td> </tr>",$count,$count,$rowQuestion['answer03']);
				  printf("<tr> <td id='quesitem%s4' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 4)' onfocus='this.blur()'>④ %s</a></td> </tr>",$count,$count,$rowQuestion['answer04']);
				  printf("<tr> <td id='quesitem%s5' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 5)' onfocus='this.blur()'>⑤ %s</a></td> </tr>",$count,$count,$rowQuestion['answer05']);
				  
				  /*if($rowQuestion[answer05]) echo "<tr> <td colspan='2' class='question02_qpass'>⑤ $rowQuestion[answer05]</td> </tr>";*/ 
				} else { /* 주관식 */  }
				echo "</table>";

				$commentText = "";
				if($rowQuestion['comment']) 
				{
					$commentText = nl2br($rowQuestion['comment']);
					echo "<div id='comment{$count}' style='display:none;color:blue;line-height:1.5;padding:15px;padding-top:0px;'><span style='font-weight:bold;'>해설 : </span> $commentText</div>";
				}
				$count++;
				$div_count++;
				$rowQuestion = sql_fetch_array($resultQuestion);
			}
			
			echo "</td> <td valign='top' class='ed' style='padding-top:5px;border-left:none'>";
			
			for($k=3;$k < 5;$k++ )
			{
				/* 5문제중 우측 2문제 보이게 처리*/
				if($count > $question_total) continue;
				if($div_count > $question_count[$i]) continue;

				/* 과목별 문제수보다 많으면 패스*/
				if($rowQuestion['answer01']) $chooseStyle = 1;
				else {
					$chooseStyle = 0;
				}

				echo "<div id='ques_ox{$count}' style='margin:0;position:absolute;background-repeat:no-repeat' width='55' height='45'><img src='./img/blank.gif' width='55' height='45'></div>";
				echo "<table width='100%' height='150' cellspacing='0' cellpadding='5' style='margin-bottom:10px;' border='0'>";
				echo "<tr> <td valign='top' align='right' width='25' class='count_qpass'>{$count}.</td> <td valign='top' class='question01_qpass'>".nl2br( trim($rowQuestion['question']) )."</td> </tr>";

				if($chooseStyle == 1) 
				{
					printf("<tr> <td id='quesitem%s1' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 1)' onfocus='this.blur()'>① %s</a></td> </tr>",$count,$count,$rowQuestion['answer01']);
					printf("<tr> <td id='quesitem%s2' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 2)' onfocus='this.blur()'>② %s</a></td> </tr>",$count,$count,$rowQuestion['answer02']);
					printf("<tr> <td id='quesitem%s3' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 3)' onfocus='this.blur()'>③ %s</a></td> </tr>",$count,$count,$rowQuestion['answer03']);
					printf("<tr> <td id='quesitem%s4' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 4)' onfocus='this.blur()'>④ %s</a></td> </tr>",$count,$count,$rowQuestion['answer04']);
					printf("<tr> <td id='quesitem%s5' colspan='2' class='question02_qpass'><a href='javascript:answer_check(%s, 5)' onfocus='this.blur()'>⑤ %s</a></td> </tr>",$count,$count,$rowQuestion['answer05']);
					/*if($rowQuestion[answer05]) echo "<tr> <td colspan='2' class='question02_qpass'>⑤ $rowQuestion[answer05]</td> </tr>";*/
				} else { /* 주관식*/ }
				echo "</table>";

				if($rowQuestion['comment']) 
				{
					$commentText = nl2br($rowQuestion['comment']);
					echo "<div id='comment{$count}' style='display:none;color:blue;line-height:1.5;padding:15px;padding-top:0px;'><span style='font-weight:bold;'>해설 : </span> $commentText</div>";
				}

				$count++;
				$div_count++;
				$rowQuestion = sql_fetch_array($resultQuestion);
			}

			echo "&nbsp;</td></tr></table>";

			/* 이동 버튼*/
			$cat_subject = addslashes($cat_subject);
			echo "<table width='100%' height='50' cellspacing='0' cellpadding='0' border='0'>";
			echo "<tr><td width='50%' align='right' style='padding-right:12px'><input type='button' value='이전' onclick=\"previous_div('$cat_subject', $i, $j)\" class='btn01_qpass' style='width:35px;height:21px;padding-top:1px' onfocus='this.blur()'></td>";
			echo "<td style='padding-left:10px'><input type='button' value='다음' onclick=\"next_div('$cat_subject', $i, $j)\" class='btn01_qpass' style='width:35px;height:21px;padding-top:1px' onfocus='this.blur()'></td> </tr>";
			echo "</table>";
			echo "</div>";
		}
	}
}

/* delete 그룹*/
function delete_questionUpfile($questionUid) 
{
	for($i=0;$i <= 5;$i++) 
	{
		$destUrl = "./upfile/qpass{$questionUid}_{$i}";
		if( file_exists($destUrl) )
			unlink($destUrl);
	}
}

function delete_examUpfile($examUid) 
{
	$sql = "select uid from qpass_question where exam_uid = '$examUid' ";
	$result = sql_query($sql);
	while( $row = sql_fetch_array($result) ) {
		delete_questionUpfile($row['uid']);
		$sql = sprintf("delete from qpass_question where uid = '%s' ",$row['uid']);
		sql_query($sql);
	} 
	/* 응시기록도 삭제 추가*/ 
}
?>