<?php
include_once("./qpass_config.php");
include_once("$g4_path/common.php");
include_once("./lib_qpass_inc.php");
$stateText = "시험응시";
$g4['title'] = "Qpass $stateText $mode";
include_once("./head_qpass.php");
if($examUid == "") 
{ 
	echo "<p align='center' style='margin: 100px 0 100px 0;color:blue;font-size:13px'>시험을 선택해 주세요</p>";
	include_once("./tail_qpass.php");
	exit;
} 

if($mode == "first") 
{
	if($member['mb_id']) 
	{
		$targetDiv_add = $targetDiv + 1;
		if($targetDiv_add < 10) $targetDiv_add = "0".$targetDiv_add;
		$tryListNum = "try_list".$targetDiv_add;
		$regTimeTitle = "reg_time".$targetDiv_add;
		/* 시험에 첫응시하는 것인지 체크*/ $sql =sprintf( "select count(*) as cnt from qpass_result where mb_id = '%s' and exam_uid = '%s' ",$member['mb_id'],$examUid);
		$takeCount = sqlFetchArrayQ($sql);
		$takeCount = $takeCount['cnt'];
		if($takeCount == 0) $sql = sprintf("insert into qpass_result (mb_id, exam_uid, %s, %s, latest_tryTime) values ('%s', '%s', '%s', now(), now() )",$tryListNum, $regTimeTitle,$member['mb_id'],$examUid,$ansTryList);
		else { $sql = "update qpass_result set $tryListNum = '$ansTryList', $regTimeTitle = now(), latest_tryTime = now() where mb_id = '$member[mb_id]' and exam_uid = '$examUid' ";
		} /*echo $sql;*/ sql_query($sql);
	} 
} else if($mode == "return") { 
	if($member['mb_id']) 
	{
		$targetDiv_add = $targetDiv;
		if($targetDiv_add < 10) $targetDiv_add = "0".$targetDiv_add;
		$tryListNum = "try_list".$targetDiv_add;
		$regTimeTitle = "reg_time".$targetDiv_add;
		$sql = "update qpass_result set $tryListNum = '', $regTimeTitle = '' where mb_id = '$member[mb_id]' and exam_uid = '$examUid' ";
		/*echo $sql;
		*/ sql_query($sql);
	} 
}
?>
<!-- 상단 타이틀 -->
<table width='960' align='center' cellspacing='0' cellpadding='1' style='margin:10px 0 5px 0;
background-color:#d9d9d9' border='0'> <tr> <td> <table width='100%' align='center' cellspacing='0' cellpadding='1' bgcolor='#F2F2F2' style='' border='0'> <tr><td>  <table width='100%' cellspacing='0' cellpadding='1' bgcolor='#f9f9f9' border='0'> <tr height='45'>   <td width='100'>&nbsp;</td> <td align='center' style='font-weight:bolder;
color:green;
font-size:13pt;'>[<?php echo get_examName($examUid)?>] <?php echo $stateText?> </td> <td width='100'><input type='button' value='첫화면' style='color:green; cursor:pointer; border:2px outset; background-color:#f0f0f0; width:55px; height:21px; padding-top:1px; ' onclick="move2main()" onfocus='this.blur()'></td> </tr> </table> </td> </tr> </table> </td> </tr> </table> <input type='hidden' id='current_i' value='0' size='3'> <input type='hidden' id='current_j' value='0' size='3'> <input type='hidden' id='current_startNum' value='' size='3'> <input type='hidden' id='current_questionTotal' value='' size='3'> <input type='hidden' id='current_mode' value='' size='3'> <form name='test_form' method='post' action='<?php echo $PHP_SELF?>' style='margin:0'> <input type='hidden' name='examUid' value='<?php echo $examUid?>'> <input type='hidden' name='mode' value=''> <input type='hidden' name='targetDiv' value=''> <input type='hidden' name='ansTryList' value=''> </form> <div id='index_div' style='<?php echo $index_view?>position:absolute; width:520; height:50; left:250; top:250; z-index:1'> <table width='520' height='100%' cellspacing='0' cellpadding='1' bgcolor='#d9d9d9' style=''> <tr><td><!-- 테두리 테이블--> <table width='100%' cellspacing='1' cellpadding='5' bgcolor='#F7F4FB' border='1'> <tr height='50'> <td align='left' style='font-weight:normal; font-size:9pt; padding: 10px 50px 10px 50px; line-height:1.4'><?php echo nl2br( get_examComment($examUid) )?></td> </tr> <tr> <td align='center' bgcolor='#F2F2F2'> <table width='100%' cellspacing='1' cellpadding='5' bordercolor='#d9d9d9' bordercolorlight='#d9d9d9' bordercolordark='white' border='1'> <tr height='33'> <td align='center' class='title01'>과목구분</td> <td align='center' class='title01'>정답수/문제수</td> <td align='center' class='title01'>응시일</td> <td align='center' class='title01'>확 인</td> </tr> 
<?php 
/* 응시 결과자료 호출*/ 
if($member['mb_id']) { 

$sql = sprintf("select * from qpass_result where mb_id = '%s' and exam_uid = '%s' ",$member['mb_id'],$examUid);
$resultResult = sql_query($sql);
$rowResult = sql_fetch_array($resultResult);

} $sql = sprintf("select * from qpass_exam where uid = '%s' ",$examUid);
$resultExam = sql_query($sql);
$rowExam = sql_fetch_array($resultExam);
/* 전체 과목수 추출*/ $course_count = $rowExam['cat_countTotal'];
/* 전체 문제수 추출*/ $sql = "select count(*) as cnt from qpass_question where exam_uid = '$examUid' ";
$question_total = sqlFetchArrayQ($sql);
$question_total = $question_total['cnt'];
$startNum = 1;
$correct_total = 0;
for($i=1; $i <= $course_count; $i++) { $i_add = $i;
$i_minus = $i - 1;
if($i_add < 10) $i_add = "0".$i_add;
$course_name = addslashes($rowExam["cat_title".$i_add]);
$div_questions = $rowExam["cat_count".$i_add];
$regdate = substr($rowResult["reg_time".$i_add], 5,11);
$sql = "select count(*) as cnt from qpass_question where exam_uid = '$examUid' and cat_index = '$i_minus' ";
$div_questionsReal= sqlFetchArrayQ($sql);
$div_questionsReal = $div_questionsReal['cnt'];
 echo "<tr height='33'><td align='center'>".$course_name."</td>";
if( !$regdate || substr($rowResult["reg_time".$i_add], 0,10) == '0000-00-00' ) { $correctCount = 0;
echo "<td align='center'>응시전 / ({$div_questionsReal}문제)</td>";
 if($div_questionsReal > 0) echo "<td colspan='2' align='center'><a href=\"javascript:start_test($i, 'first', $startNum, $div_questionsReal)\" style='color:#CC9900; font-weight:bold'>응시하기</a></td>"; else echo "<td colspan='2' align='center' style='color:#999;
font-weight:bold'>문제준비중</td>";
} else {  $correctCount = get_correctCount($rowResult["try_list".$i_add], $examUid, $i_minus);
 echo "<td align='center'> $correctCount / $div_questionsReal</td> <td align='center'>$regdate</td>";
 echo "<td align='center'><a href=\"javascript:start_test($i, 'check', $startNum, $div_questionsReal)\"><img src='./img/step_v.gif' width='15' height='15' title='응시결과 확인하기' align='absmiddle'></a>";
 echo " <a href=\"javascript:start_test($i, 'restudy', $startNum, $div_questionsReal)\"><img src='./img/step_r.gif' width='15' height='15' title='다시풀기(기록안됨)' align='absmiddle'></a>";
 echo " <a href=\"javascript:start_test($i, 'incorrect', $startNum, $div_questionsReal)\"><img src='./img/step_x.gif' width='15' height='15' title='틀린문제만 풀기' align='absmiddle'></a>";
 echo " <a href=\"javascript:restore_exam($i, '$course_name')\"><img src='./img/step_return.gif' width='15' height='15' title='원상태로 돌리기' align='absmiddle'></a>";
} echo "</td></tr>";
if($correctCount > 0) $correct_total += $correctCount;
$startNum += $div_questionsReal;
} if($correct_total) {  $score = ceil( ($correct_total * 100) / $question_total );
$scoreText = $score."점";
echo "<tr> <td class='title02_qpass'>결 과</td> <td align='center' style='font-weight:bold'>$correct_total / $question_total <span style='padding-left:10px'>($scoreText)</span></td>";
 echo "<td colspan='2' align='center'><input type='button' value='창닫기' style='color:green; cursor:pointer; border:2px outset; background-color:#f0f0f0; width:55px; height:21px; padding-top:1px; ' onclick='self.close()' onfocus='this.blur()'></td> </tr>";
} ?> </table> </td> </tr> </table> </td></tr> <!-- 출처표시 --> <tr><td align='right' class='qpass_copyright'>Qpass by <a href="http://codetree.co.kr" target='_blank'>codetree.co.kr</a></td></tr> </table> <!-- 테두리 테이블--> </div> <?php $targetDiv = "";
?> <script> var max_five = Array(10);
</script> <table width='960' height='650' align='center' cellspacing='0' cellpadding='0' style='margin:0 0 5px 0' border='0'> <tr> <td width='830' height='500' valign='top'>
<!-- 문제지 출력 --> 
<?php print_qpass_examSheet($examUid, $mode, $targetDiv);?> </td> 
<td width='130' valign='top' style='border:none'>
<!-- 답안지 출력 --> 
<?php print_qpass_answerSheet($examUid, $mode, $targetDiv);?> </td> </tr> </table> 
<script> 
/* 첫화면으로 이동*/ 
function move2main() { 
	var currentI = document.getElementById('current_i').value;
var currentJ = document.getElementById('current_j').value;
var currentDiv = document.getElementById('div'+ currentI + currentJ);
currentDiv.style.display = "none";
var currentAns = document.getElementById('ans'+ currentI);
currentAns.style.display = "none";
var indexDiv = document.getElementById('index_div');
indexDiv.style.visibility = "visible";
} 

/* 인덱스에서의 선택 처리*/ 
function start_test(i, mode, startNum, eachTotal) 
{ 
	var f = document.test_form;
	targetDiv = i-1;
	/*alert(mode);*/
	f.mode.value = mode;
	document.getElementById('current_mode').value = mode;
	document.getElementById('current_startNum').value = startNum;
	document.getElementById('current_questionTotal').value = eachTotal;
	var finishBtn = document.getElementById('btnFinish'+ targetDiv);
	var resultDisplay = document.getElementById('resultDisplay'+targetDiv);
	resultDisplay.innerHTML = "";

	if(mode == "first") { 
		/* 응시하기*/ 
	
	} else if(mode == "restudy") { 
		/* 다시풀기*/  
		unscoring_targetDiv(targetDiv, startNum, eachTotal);
		finishBtn.style.display = "block";
	} else if(mode == "restudyCheck") { 
		/* 다시풀기 결과확인하기*/ 
		scoring_targetDiv(targetDiv, startNum, eachTotal);
		finishBtn.style.display = "none";
	} else if(mode == "check") { 
		/* 응시결과 확인하기*/ 
		unscoring_targetDiv(targetDiv, startNum, eachTotal);
		/* 체크후 답안제출없이 첫화면으로 이동시 리셋이 필요*/  resave_ansTry(startNum, eachTotal);
		scoring_targetDiv(targetDiv, startNum, eachTotal);
		finishBtn.style.display = "none";
	}else if(mode == "incorrect") { 
		/* 틀린문제 다시풀기*/ 
		unscoring_targetDiv(targetDiv, startNum, eachTotal);
		/* 체크후 답안제출없이 첫화면으로 이동시 리셋이 필요*/
		resave_ansTry(startNum, eachTotal);
		 scoring_targetDiv(targetDiv, startNum, eachTotal);
		/*alert("OK");return;*/ 
		finishBtn.style.display = "block";
	} else if(mode == "incorrectCheck") {
		/* 틀린문제 다시풀기 결과확인하기*/ 
		scoring_targetDiv(targetDiv, startNum, eachTotal);
		finishBtn.style.display = "none";
	} 
	
	replace_div(targetDiv, 0);
	document.getElementById('index_div').style.visibility = 'hidden';
} 

function resave_ansTry(startNum, eachTotal) { var tryNum;
var endNum = startNum + eachTotal - 1;
for(var i=startNum;i <= endNum;i++) { 
	tryNum = document.getElementById('ans_trySame'+i).value;
document.getElementById('ans_try'+i).value = tryNum;
} } 
function restore_exam(targetDiv, course) { /*alert(targetDiv);*/ if(!confirm(course + " 시험을 정말 응시이전의 상태로 되돌립니까?\t")) return;
var f = document.test_form;
f.mode.value = "return";
f.targetDiv.value = targetDiv;
f.submit();
} /* 해당 구역으로 이동*/ 


/* 해당 구역으로 이동*/
function replace_div(divNum, fiveNum) {
	/* 현재 블럭 감추기*/
	var currentI = document.getElementById('current_i').value;
	var currentJ = document.getElementById('current_j').value;
	var currentDiv = document.getElementById('div' + currentI + currentJ);

	currentDiv.style.display = "none";

	/* 대상 블럭 보이기*/
	var targetDiv = document.getElementById("div" + divNum + fiveNum);
	targetDiv.style.display = "block";
	/*alert(fiveNum); return;*/

	/* 해당 답안지 변경*/
	var targetAns = document.getElementById("ans" + divNum);
	targetAns.style.display = "block";

	document.getElementById('current_i').value = divNum;
	document.getElementById('current_j').value = fiveNum;
}

/* 채점 표시 전부 없애기*/ 
function unscoring_targetDiv(targetDiv, startNum, eachTotal) { var f = document.test_form;
var ans_try, ans_real;
var endNum = startNum + eachTotal - 1;
var itemType;
for(var i=startNum;
i <= endNum;
i++) { /* 문제지 번호*/  document.getElementById('ques_ox'+i).style.backgroundImage = "";
 /* 문제지 문항*/ for(var j=1;j<=5;j++) { itemType = document.getElementById('quesitem'+i+j);
 /*if(i>= 4) alert("type01 : "+ i+ j + itemType);*/ if(itemType != null) document.getElementById('quesitem'+i+j).style.backgroundImage = "";
} /* 해설 안보이게 처리 */ if( document.getElementById('comment'+i) ) {  document.getElementById('comment'+i).style.display = "none";
}  /* 답안지 번호*/ document.getElementById('ans_num'+i).style.backgroundImage = "";
 /* 답안지 문항*/ for(var j=1;
j<=5;
j++) {  itemType = document.getElementById('answer'+i+j);
 /*if(i>= 4) alert("type01 : "+ i+ j + itemType);*/ if(itemType != null) document.getElementById('answer'+i+j).src = "./img/num"+ j + ".gif";
else if( document.getElementById('ansInsert_text'+i) ) { /* 주관식*/  var insSpan = document.getElementById('ansInsert_span'+i);
 var insText = document.getElementById('ansInsert_text'+i);
insSpan.style.display = "none";
  insText.value = "";
 insText.style.display = "";
} }  /* 답안지 정답 체크*/ for(var j=1;j<=6;j++) {  itemType = document.getElementById('ans_td'+i+j);
if(itemType != null) document.getElementById('ans_td'+i+j).style.backgroundImage = "";
}   /* 응시기록 리셋*/ document.getElementById('ans_try'+i).value = "";
} } function scoring_targetDiv(targetDiv, startNum, eachTotal) {  var f = document.test_form;
var ans_try, ans_real, selectType, oxState;
var correctCount=0;
var mode = document.getElementById('current_mode').value;
var endNum = eval(startNum) + eval(eachTotal) - 1;
/*alert(endNum);*/ for(var i=startNum;
i <= endNum;
i++) { ans_try = document.getElementById('ans_try'+i).value;
ans_real = document.getElementById('ans_real'+i).value;
/* 주관/객관 설정변수*/  if( document.getElementById('ansInsert_span'+i) ) selectType = 1;
else { selectType = 0;
} oxState = get_OX_state(ans_try, ans_real, selectType);
/*if(i == endNum) alert(oxState.length);*/ /* 해설 뷰*/ if( mode != "incorrect" && document.getElementById('comment'+i) ) {  document.getElementById('comment'+i).style.display = "block";
} /* 1단계 : 문제지 문항, 답안지 문항에 정답,오답 표시*/ if(oxState.substr(0,1) == "1") { /* 정답*/ correctCount++;
/* 문제지 문제번호에 o 표시*/ document.getElementById('ques_ox'+i).style.backgroundImage = "url('./img/re_o.gif')";
/* 답안지 문제번호에 o 표시*/ document.getElementById('ans_num'+i).style.backgroundImage = "url('./img/ans_O.gif')";
document.getElementById('ans_num'+i).style.backgroundRepeat = "no-repeat";
} else { /* 오답*/  if(mode != "incorrect") { /* 틀린문제풀기에서 오답은 그냥둠*/   /* 문제지 문제번호에 x 표시*/  document.getElementById('ques_ox'+i).style.backgroundImage = "url('./img/re_x.gif')";
  /* 답안지 문제번호에 x 표시*/  document.getElementById('ans_num'+i).style.backgroundImage = "url('./img/x24.gif')";
 document.getElementById('ans_num'+i).style.backgroundRepeat = "no-repeat";
 } } /* 2단계 : 답안지에서 정답 표시(복수정답 고려)*/ if( selectType == 0 ) { /* 객관식*/ if(mode == "incorrect" && oxState.substr(0,1) == "0") { /* 틀린문제풀기에서 오답이면 패스*/ } else {   if(oxState.length == 1) { /* 단수정답*/  document.getElementById('ans_td'+i+ans_real).style.backgroundImage = "url(./img/circle_blue22.gif)";
 document.getElementById('ans_td'+i+ans_real).style.backgroundRepeat = "no-repeat";
} else { /* 복수정답*/   for(var j=1;
j <= oxState.length-1;
j++) { /* 1, 0 자리 고려*/  ans_index = oxState.substr(j,1);
 document.getElementById('ans_td'+i+ans_index).style.backgroundImage = "url('./img/circle_blue22.gif')";
 document.getElementById('ans_td'+i+ans_index).style.backgroundRepeat = "no-repeat";
 } } } } else if( document.getElementById('ansInsert_span'+i) ) { /* 주관식*/  var insSpan = document.getElementById('ansInsert_span'+i);
var insText = document.getElementById('ansInsert_text'+i);
insSpan.innerHTML = "<span style='color:blue; font-weight:bold'>"+ ans_real + "</span>/" + ans_try;
 if(mode == "incorrect" && oxState.substr(0,1) == "0") {   insSpan.style.display = "none";
 insText.style.display = "";
} else { /* 정답이면 ans_try에 값 세팅*/   insSpan.style.display = "";
 insText.value = ans_try;
insText.style.display = "none";
 } } /* 3단계 : 문제지 답항표시(복수정답 고려), 답안지에서 시도답항 표시*/ /*if(i == endNum) alert(ans_try);*/  if(selectType == 0) {  if(mode == "incorrect" && oxState.substr(0,1) == "0") { /* 틀린문제풀기에서 오답은 그냥둠*/ } else {   /* 문제지 표시*/ if(oxState.length == 1) { /* 단수정답*/  if(oxState == "1") { /* 정답 */   document.getElementById('quesitem'+i+ans_real).style.backgroundImage = "url(./img/ov38.gif)";
 document.getElementById('quesitem'+i+ans_real).style.backgroundRepeat = "no-repeat";
 }  else { /* 오답*/   /* 정답 단독표시*/  document.getElementById('quesitem'+i+ans_real).style.backgroundImage = "url(./img/o3524.gif)";
 document.getElementById('quesitem'+i+ans_real).style.backgroundRepeat = "no-repeat";
 if(ans_try > 0) { /* 시도는 했는데 오답*/   document.getElementById('quesitem'+i+ans_try).style.backgroundImage = "url(./img/red_v38.gif)";
  document.getElementById('quesitem'+i+ans_try).style.backgroundRepeat = "no-repeat";
 }  } } else { /* 복수정답*/   var circleType;
  for(var j=1; j <= oxState.length-1; j++) { /* 1, 0 자리 고려*/  ans_index = oxState.substr(j,1);
 /*alert(ans_index);*/  if(ans_try > 0 && ans_try == ans_index) circleType = "ov38";
/* 둥근원+체크표시*/  else { circleType = "o3524";
}  document.getElementById('quesitem'+i+ans_index).style.backgroundImage = "url('./img/"+ circleType +".gif')";
 document.getElementById('quesitem'+i+ans_index).style.backgroundRepeat = "no-repeat";
 } }  /* 답안지 시도문항 표시*/ if(ans_try > 0) document.getElementById('answer'+i+ans_try).src = "./img/num"+ ans_try + "_gray.gif";
} }  } /* 결과 표시*/ var resultDisplay = document.getElementById('resultDisplay'+targetDiv);
resultDisplay.innerHTML = correctCount + " / " + eachTotal;
}

function get_OX_state(ans_try, ans_real, selectType) {
	/* selectType 주관식 여부.*/ 
	ans_try = spaceOut_qpass(ans_try);
	ans_real = spaceOut_qpass(ans_real);
if(ans_try == ans_real) return "1";
/* 주관/객관 공용*/
if(selectType == 0) {
	/* 객관식*/
	if(ans_real.length == 1) { 
		return "0";
	} 
	/* 답안과 정답이 다른데, 단수정답이면 오답*/ 
	else { /* 다수정답인 경우*/
		if( ans_try !='' && ans_real.indexOf(ans_try) != -1)
			/* 시도를 하고, 정답이 들어있으면 정답열을 리턴*/
			return '1' + all_answer_num(ans_real);
		else
			return '0' + all_answer_num(ans_real);
	}
} else { 
	/* 주관식*/ 
		return compare_strings(ans_real, ans_try);
}
} 

function compare_strings(ans_real, ans_try) { 
if(ans_try == "") return "0";
	ans_try = spaceOut_qpass(ans_try);
var realList = ans_real.split(",");
for(var i=0; i < realList.length; i++) { 
	if(spaceOut_qpass(realList[i]) == ans_try) return "1";
} return "0";
}

function all_answer_num(str) {
	var new_str = "";
	var ch = '';
for(var i=0; i < str.length; i++) { ch = str.substr(i,1);
if(ch != ',' && ch !='/' && ch != '') new_str = new_str + '' + ch;
} 
return new_str;
} 

function spaceOut_qpass(str) { var newStr="", ch="";
for(var i=0; i < str.length; i++) { ch = str.substr(i,1);
if(ch != " ") newStr = newStr + "" + ch;
} /*alert(newStr);*/ 
	return newStr;
} 

function get_ansReal(question_num) { 
	var targetDiv = document.getElementById('current_i').value;
} 

function answer_check(question_num, ans_num) { 
	var currentMode = document.getElementById('current_mode').value;
var incorrectRight="";
if(currentMode == "incorrect") { 
	var ans_try = document.getElementById('ans_trySame'+question_num).value;
	var ans_real = document.getElementById('ans_real'+question_num).value;
	incorrectRight = get_OX_state(ans_try, ans_real);
	/*alert(ans_real + " and " + incorrectRight);*/ 
} 
if(currentMode == "check" || currentMode == "restudyCheck" || currentMode == "incorrectCheck") { alert("큐패스(Qpass) 1.0 by codetree.co.kr ");
return;
} else if(incorrectRight.substr(0,1)=="1") { alert("바쁘시더라도 차근차근 풀어보세요.\t");
return;
}  var ans = document.getElementById('answer'+question_num+ans_num);
var ques = document.getElementById('quesitem'+question_num+ans_num);
/* 먼저 기존 칠한게 있으면 지우기*/ for(i=1; i <= 5 ; i++) { document.getElementById('answer'+question_num+i).src = "./img/num"+ i + ".gif";
document.getElementById('quesitem'+question_num+i).style.backgroundImage = "";
} var ansIndex = question_num - document.getElementById('current_startNum').value;
move2question(ansIndex);
ques.style.backgroundImage = "url('./img/red_v38.gif')";
ques.style.backgroundRepeat = "no-repeat";
ans.src = "./img/num"+ ans_num + "_gray.gif";
/* 폼에 값 저장하기*/ /*alert(question_num);return;*/ document.getElementById('ans_try'+question_num).value = ans_num;
} 

function previous_div(courseName, divIndex, fiveIndex) {
	/*alert(divIndex);*/
	if(fiveIndex == 0) { 
		alert("여기가 " + courseName + "의 처음입니다.\t");
return;
} 
nextFive = eval(fiveIndex) - eval(1);
/*alert(nextFive);
return;*/ 
	replace_div(divIndex, nextFive);
}

function next_div(courseName, divIndex, fiveIndex) { 
	/*alert( fiveIndex + " and "+ max_five[divIndex]);return;*/
	if(fiveIndex == max_five[divIndex]) {
		alert("여기가 " + courseName + "의 마지막입니다.\t");
		return;
	} 
	nextFive = eval(fiveIndex) + eval(1);
	/*alert(nextFive);return;*/ 
	replace_div(divIndex, nextFive);
}

function move2question(ansIndex) {
	var divNum = document.getElementById('current_i').value;
	var fiveNum = Math.floor(ansIndex / 5);
	/*alert(fiveNum);return;*/ 
	replace_div(divNum, fiveNum);
}

function get_notTriedNum(startNum, endNum) { 
	var ans_try;
	for(var i=startNum; i <= endNum; i++) { 
	ans_try = document.getElementById('ans_try'+i).value;
	if(ans_try == "") return i;
} return -1;
} function finish_exam(divIndex) { /* 안푼 문제가 있는지 체크*/ var startNum = document.getElementById('current_startNum').value;
var eachTotal = document.getElementById('current_questionTotal').value;
var endNum = eval(startNum) + eval( eachTotal ) - 1;
/*alert(endNum);*/ /* 주관식 문제 이전*/ for(var i=startNum; i <= endNum; i++) { if( document.getElementById('ansInsert_text'+i) ) { document.getElementById('ans_try'+i).value = document.getElementById('ansInsert_text'+i).value;
} } var notTriedNum = get_notTriedNum(startNum, endNum);
/*alert(notTriedNum); */ if(notTriedNum != -1) {  var ansIndex = notTriedNum - document.getElementById('current_startNum').value;;
if( !confirm("안푼 문제가 있습니다. 그냥 채점합니까? \t") ) {  move2question(ansIndex);
return;
} } var f = document.test_form;
/*alert(divIndex); return;*/ nextSameIndex = divIndex + 1;
 if(f.mode.value == 'first') {  var tryList="";
for(var i=startNum; i <= endNum; i++) {  ans_try = document.getElementById('ans_try'+i).value;
tryList = tryList + ans_try + "|Q|";
}  f.ansTryList.value = tryList;
/*alert(tryList); return;*/ f.targetDiv.value = document.getElementById('current_i').value;
 f.submit();
} else if(f.mode.value == 'restudy') start_test(nextSameIndex, "restudyCheck", startNum, eachTotal);
else if(f.mode.value == 'incorrect') start_test(nextSameIndex, "incorrectCheck", startNum, eachTotal);
} </script> 
<?php include_once("./tail_qpass.php"); ?>