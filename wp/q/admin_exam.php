<?php
include_once("./qpass_config.php");
include_once("$g4_path/common.php");
include_once("./lib_qpass_inc.php");
admin_check();
if($examUid) $uid = $examUid;
if($uid) {
	$sql = "select small_code from qpass_exam where uid = '$uid' ";
	$small_code = sqlFetchArrayQ($sql);
	$small_code = $small_code['small_code'];
} 
/**/
if($small_code) { 
	$big_code = substr($small_code, 0,2);
	$mid_code = substr($small_code, 0,4);
}

$g4['title'] = "Qpass 시험관리";

include_once("./head_qpass.php");

if($mode == 'register') {
	$sql = "insert into qpass_exam set ";
	$sql.= sprintf("small_code='%s', ",$small_code);
	$sql.= sprintf("exam_name='%s', ",$exam_name);
	$sql.= sprintf("cat_countTotal='%s', ",$cat_countTotal);
	$sql.= sprintf("cat_count01='%s', ",$cat_count01);
	$sql.= sprintf("cat_count02='%s', ",$cat_count02);
	$sql.= sprintf("cat_count03='%s', ",$cat_count03);
	$sql.= sprintf("cat_count04='%s', ",$cat_count04);
	$sql.= sprintf("cat_count05='%s', ",$cat_count05);
	$sql.= sprintf("cat_count06='%s', ",$cat_count06);
	$sql.= sprintf("cat_count07='%s', ",$cat_count07);
	$sql.= sprintf("cat_count08='%s', ",$cat_count08);
	$sql.= sprintf("cat_count09='%s', ",$cat_count09);
	$sql.= sprintf("cat_count10='%s', ",$cat_count10);
	$sql.= sprintf("cat_title01='%s', ",$cat_title01);
	$sql.= sprintf("cat_title02='%s', ",$cat_title02);
	$sql.= sprintf("cat_title03='%s', ",$cat_title03);
	$sql.= sprintf("cat_title04='%s', ",$cat_title04);
	$sql.= sprintf("cat_title05='%s', ",$cat_title05);
	$sql.= sprintf("cat_title06='%s', ",$cat_title06);
	$sql.= sprintf("cat_title07='%s', ",$cat_title07);
	$sql.= sprintf("cat_title08='%s', ",$cat_title08);
	$sql.= sprintf("cat_title09='%s', ",$cat_title09);
	$sql.= sprintf("cat_title10='%s', ",$cat_title10);
	$sql.= sprintf("exam_comment='%s', ",$exam_comment);
	$sql.= sprintf("time_limit='%s', ",$time_limit);
	$sql.= sprintf("view_ox='%s', ",$view_ox);
	$sql.= sprintf("reg_time=%s; ","now()");
	
	/*echo $sql;*/
	sql_query($sql);
} else if($mode == 'update' && $uid) {
	$sql = "update qpass_exam set exam_name = '$exam_name', cat_countTotal = '$cat_countTotal', cat_count01 ='$cat_count01', cat_count02 ='$cat_count02', cat_count03 ='$cat_count03', cat_count04 ='$cat_count04', cat_count05 ='$cat_count05', cat_count06 ='$cat_count06', cat_count07 ='$cat_count07', cat_count08 ='$cat_count08', cat_count09 ='$cat_count09', cat_count10 ='$cat_count10', cat_title01 ='$cat_title01', cat_title02 ='$cat_title02', cat_title03 ='$cat_title03', cat_title04 ='$cat_title04', cat_title05 ='$cat_title05', cat_title06 ='$cat_title06', cat_title07 ='$cat_title07', cat_title08 ='$cat_title08', cat_title09 ='$cat_title09', cat_title10 ='$cat_title10', exam_comment = '$exam_comment', time_limit = '$time_limit', view_ox = '$view_ox' where uid = '$uid' "; 
	/*echo $sql;*/
	sql_query($sql);
	//sql_resultMsg( mysql_errno(), mysql_error() );
}else if($mode == 'updateList' && $uid) {
	$sql = "update qpass_exam set view_ox = '$view_ox' where uid = '$uid' "; 
	/*echo $sql;*/
	sql_query($sql);
} else if($mode == 'deleteList' && $uid) { 
	/* 소속 문제들 및 업로드이미지 삭제*/
	delete_examUpfile($uid);
	
	/* 응시결과 삭제 */
	$sql = "delete from qpass_result where exam_uid = '$uid' ";
	sql_query($sql);
	$sql = "delete from qpass_exam where uid = '$uid' ";
	
	/*echo $sql; */
	sql_query($sql);
	$uid = "";
} else if($mode == 'form' ) {
	$uid = "";
}
?>

<form name='list_form' method='post' style='margin:0' action='<?=$PHP_SELF?>'>
<input type='hidden' name='mode' value=''>
<input type='hidden' name='uid' value=''>
<input type='hidden' name='view_ox' value=''>
</form>
<form name='cat_form' method='post' style='margin:0' action='<?=$PHP_SELF?>'>
<input type='hidden' name='mode' value=''>
<table width='100%' cellspacing='0' cellpadding='2' style='margin-top:10px;' border='0'>
<tr>
<td align='center' valign='top' width='' class='title01'>시험 관리 :  <select name='big_code' size='1' style='width:150' onchange="this.form.mid_code.value = ''; this.form.small_code.value = ''; this.form.submit()">
<?php
$sql = "select * from qpass_catBig order by big_code";
/* where big_code != 99 */
$result_big = sql_query($sql);
while( $row_big = sql_fetch_array($result_big) ) {
	if($big_code == '')
	$big_code = $row_big['big_code'];
	/* 코드가 정해지지 않았으면 첫번째 대분류를 디폴트로 설정.*/
	if($big_code == $row_big['big_code']) {
		printf("<option value='%s' selected>%s</option>",$row_big['big_code'],$row_big['big_name']);
		$big_name = $row_big['big_name'];
	} else
		printf("<option value='%s'>%s</option>",$row_big['big_code'],$row_big['big_name']);
}
?>
</select>
<select name='mid_code' size='<?=$mid_size?>' style='width:150' onchange="this.form.small_code.value = ''; this.form.submit()">
<?php
$sql = "select * from qpass_catMid where mid_code like '{$big_code}__' order by mid_code";
$result_mid = sql_query($sql);
while( $row_mid = sql_fetch_array($result_mid) ) { 
	if($mid_code == '')
	$mid_code = $row_mid['mid_code'];
	/* 코드가 정해지지 않았으면 첫번째 중분류를 디폴트로 설정.*/
	if($mid_code == $row_mid['mid_code']) {
		printf("<option value='%s' selected>%s</option>",$row_mid['mid_code'],$row_mid['mid_name']);
		$mid_name = $row_mid['mid_name']; }
	else
		printf("<option value='%s'>%s</option>",$row_mid['mid_code'],$row_mid['mid_name']);
	}
?>
</select>
<select name='small_code' size='<?=$small_size?>' style='width:150; background-color:#FFF8CF' onchange='this.form.submit()'>
<?php

$sql = "select * from qpass_catSmall where small_code like '{$mid_code}__' order by small_code";
$result_small = sql_query($sql);
while( $row_small = sql_fetch_array($result_small) ) { 
	if($small_code == '')
	$small_code = $row_small['small_code'];
	/* 코드가 정해지지 않았으면 첫번째 중분류를 디폴트로 설정.*/
	if($small_code == $row_small['small_code']) {
		printf("<option value='%s' selected>%s</option>",$row_small['small_code'],$row_small['small_name']);
		$small_name = $row_small['small_name'];
	} else 
		printf("<option value='%s'>%s</option>",$row_small['small_code'],$row_small['small_name']);
	$next_code = substr($row_small['small_code'], 4,2) + 1; 
	}
	if($next_code == '')
	$next_code = 10;
?>
</select>
<span style='padding-left:20px'><a href="./admin_question.php?small_code=<?=$small_code?>" title='문제관리페이지'><img src='./img/btn_questionAdm.gif' width='47' height='20' align='absmiddle'></a></span>
</td>
</tr>
</table>
</form>
<p align='center'>
<?php
$catName = $big_name." > ".$mid_name." > ".$small_name; 
$view_line = 10;
/* 목록수*/
print_qpass_examList_adm($small_code, $view_line, $uid);
echo "</p>";
if($uid) {
	$sql = sprintf("select * from qpass_exam where uid = '%s' ",$uid);
//	echo $sql;
	$result = sql_query($sql);
	$row = sql_fetch_array($result);
	$detailTitle = "[ <span style='color:blue'>".$row['exam_name']."</span> ] 시험수정"; 
} else {
	$detailTitle = "[ <span style='color:blue'>".$catName."</span> ] 시험등록";
} ?>
<form name='detail_form' method='post' action='<?=$PHP_SELF?>' style='margin:0'>
<input type='hidden' name='mode' value=''>
<input type='hidden' name='uid' value='<?=$uid?>'>
<input type='hidden' name='small_code' value='<?=$small_code?>'>
<p align='center' style='margin: 20px 0 0 0; font-weight:bold'><?=$detailTitle?></p>
<p align='center'>
<table width='700' align='center' cellpadding='2' cellspacing='0' bordercolor='#D9D9D9' bordercolorlight='#D9D9D9' bordercolordark='white' style='margin:0 auto;' border='1'>
<tr>
<td width='80' class='title02_qpass'>시험명</td>
<td width='270'><input type='text' name='exam_name' class='ed' value='<?php echo $row['exam_name']?>' style='width:99%; ime-mode:active'>
</td>
<td width='80' class='title02_qpass'>등록일시</td>
<td width='270'>
<?php
if($uid)
echo $row['reg_time'];
else
echo "자동생성"; 
?>
</td>
</tr>
<tr>
<td width='100' class='title02_qpass'>시험노출</td>
<td>  <select name='view_ox'>
<option value='1'>예</option>
<?php if($row['view_ox'] == -1) echo "<option value='-1' selected>아니오</option>"; else echo "<option value='-1'>아니오</option>"; ?>
</select>
</td>
<td class='title02_qpass'>시간제한</td>
<td>없음 <?php if($uid) $time_limit = $row['time_limit']; else $time_limit = 0; ?>
<input type='hidden' class='ed' style='width:35; text-align:center' name='time_limit' value='<?php echo $time_limit?>'><!--분&nbsp; (0 이면 무제한) -->
</td>
</tr>
<tr>
<td width='100' class='title02_qpass'>전체교시</td>
<td colspan='3'>
<select id='cat_countTotal' name='cat_countTotal' onchange="change_catLine(this.value, 'inserting')">
<option value=''>선택전</option>
<?php
for($i=1; $i <= 10; $i++) {
if($i == $row['cat_countTotal']) 
echo "<option value='$i' selected>{$i}교시</option>";
else 
echo "<option value='$i'>{$i}교시</option>"; 
} ?>
</select>
</td>
</tr>
<tr>
<td colspan='4'>
<table width='100%' cellpadding='0' cellspacing='0' bordercolor='#D9D9D9' bordercolorlight='#D9D9D9' bordercolordark='white' border='1'>
<?php
for($i=1; $i <= 10; $i++) {
if($i < 10)
	$i_add = "0".$i;
else
	$i_add = $i;
?>
<tr id='catLine_<?php echo $i?>' style='display:none'>
<td width='100' class='title02_qpass'><a href="javascript:insert_catTitle('<?php echo $i?>')" style='text-decoration:underline'><?php echo $i?> 교시</a></td>
<td> 교시명 : <input type='text' id='cat_title<?php echo $i_add?>' name='cat_title<?php echo $i_add?>' value="<?php echo $row["cat_title".$i_add]?>" maxlength='50' class='ed' style='width:120'>
<span style='padding-left:10px'>문제수 : <select id='cat_count<?php echo $i_add?>' name='cat_count<?php echo $i_add?>' onchange="change_catCount('<?php echo $i?>')">
<option value=''>선택전</option>
<?php
for($j=1; $j <= 1250; $j++) {
if($j == $row["cat_count".$i_add])
	$selectText = "selected";
else
	$selectText = "";
echo "<option value='$j' $selectText>$j</option>";
}
?>
</select>
</span>
<?php
if($i==1)
echo "&nbsp;&nbsp;&nbsp; 교시명&nbsp; 예1) <span style='color:blue'>국어</span> &nbsp;&nbsp; 예2) <span style='color:blue'>1교시</span> ";
?>
</td>
</tr>
<?php }?>
</table>
</td>
</tr>
<tr>
<td width='100' class='title02_qpass'>시험설명</td>
<td colspan='3'>
<textarea name='exam_comment' rows='5' class='ed' style='width:99%'><?php echo $row['exam_comment']?></textarea>
</td>
</tr>
</table>
</p>
<?php if($uid) {
echo "<p align='center' style='margin: 15px 0 40px 0'><input type='button' value='시험수정' onclick=\"register_check(this.form, 'update')\" onfocus='this.blur()' style='padding-top:2px; font-size:12px; cursor:pointer; height:24px; width:60px;'>";
echo " <input type='button' value='등록폼' onclick=\"register_form(this.form)\" onfocus='this.blur()' style='padding-top:2px; font-size:12px; cursor:pointer; height:24px; width:45px;'>";
echo " <input type='button' value='응시화면' onclick=\"location.href = 'qpass_takeExam.php?examUid=$uid'\" onfocus='this.blur()' style='padding-top:2px; font-size:12px; cursor:pointer; height:24px; width:60px;'></p>";
} else {
	echo "<p align='center' style='margin: 15px 0 40px 0'><input type='button' value='시험등록' onclick=\"register_check(this.form, 'register')\" onfocus='this.blur()' style='padding-top:2px; font-size:12px; cursor:pointer; height:24px; width:60px;'></p>";
}
echo "</form>";
include_once("./tail_qpass.php");
?>
<script type='text/javascript'>

function register_check(f, mode) {
	if(f.exam_name.value == "") {
		alert('시험명을 입력하세요. ');
		f.exam_name.focus();
		return;
	}
	
	if(f.cat_countTotal.value == ""){
		alert('전체 몇교시인지 입력하세요. ');
		f.cat_countTotal.focus();
		return;
	}
	
	if(cat_lineCheck(f.cat_countTotal.value) == false )
	return;
	f.mode.value = mode;
	f.submit();
}

function cat_lineCheck(lineCount) {
	var catTitle, catCount, i_add;
	
	for(var i=1; i <= lineCount; i++) {
		i_add = i;
		
		if(i_add < 10)
		i_add = "0" + i_add;
		catTitle = document.getElementById('cat_title'+i_add);
		
		if(catTitle.value == "") {
			alert(i+ "교시명을 입력하세요.\t");
			catTitle.focus();
			return false;
		}
		
		catCount = document.getElementById('cat_count'+i_add);
		
		if(catCount.value == "") {
			alert(i+ "교시의 문제수를 선택하세요.\t");
			catCount.focus();
			return false;
			}
		}
		
		/* lineCount 다음 라인들은 값을 초기화*/
		var j_add;
		for(var j=i; j <= 10; j++) {
			j_add = j;
			if(j_add < 10)
			j_add = "0" + j_add;
			catTitle = document.getElementById('cat_title'+j_add).value = "";
			catCount = document.getElementById('cat_count'+j_add).value = "";
		}
		/*return false; for test*/
		return true;
	} 
	
function register_form(f) {
	f.mode.value = 'form';
	f.submit();
}

function exam_modify(uid) {
	var f = document.list_form;
	var view_ox = document.getElementById('view_ox'+uid).value;
	f.view_ox.value = view_ox; f.mode.value = 'updateList';
	f.uid.value = uid; f.submit();
}

function exam_delete(uid) {
	var f = document.list_form;
	if( !confirm('\n정말 삭제합니까?\t') )
	return; f.mode.value = 'deleteList';
	f.uid.value = uid; f.submit();
}

function change_catLine(num, when) {
	for(var i=1; i<= 10; i++) {
		catLine = document.getElementById("catLine_"+i);
		catLine.style.display = "none";
	}
	
	for(var i=1; i<= num; i++) {
		catLine = document.getElementById("catLine_"+i);
		catLine.style.display = "block";
	}
	
	if(when == "inserting")
	document.getElementById("cat_title01").focus();
}

function change_catCount(lineNum) {
	if(lineNum >= document.getElementById('cat_countTotal').value) {
		document.detail_form.exam_comment.focus();
		return; 
	}
	
	var nextNum = eval(lineNum) + eval(1);
	var num_add = nextNum;
	
	if(num_add < 10)
	num_add = "0" + num_add;
	document.getElementById('cat_title'+ num_add).focus();
}

function insert_catTitle(lineNum) {
	var num_add = lineNum; 
	
	if(num_add < 10) 
	num_add = "0" + num_add;
	document.getElementById('cat_title'+ num_add).value = lineNum + "교시";
	document.getElementById('cat_count'+ num_add).focus();
	return;
	}
	
	change_catLine("<?php echo $row['cat_countTotal']?>", "starting");
</script> 