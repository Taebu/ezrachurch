<?php
include_once("./qpass_config.php"); 
include_once("$g4_path/common.php"); 
include_once("./lib_qpass_inc.php"); 
admin_check(); 
extract($_REQUEST);

/* 코드추출*/ 
if($mode != "search" && $questionUid) 
{
	$sql = sprintf("select exam_uid, cat_index from qpass_question where uid = '%s' ",$questionUid); 
//	echo $sql;
	$code = sqlFetchArrayQ($sql); 
	$examUid = $code['exam_uid'];
	$cat_index = $code['cat_index'];
} 

//echo $examUid;

if($examUid) 
{ 
	$sql = sprintf("select small_code from qpass_exam where uid = '%s' ",$examUid); 
	$small_code = sqlFetchArrayQ($sql); 
	$small_code = $small_code['small_code'];
	$big_code = substr($small_code, 0,2); 
	$mid_code = substr($small_code, 0,4); 
} 

$g4['title'] = "Qpass 문제관리"; 
include_once("./head_qpass.php"); 

/* echo "examUid $examUid and catIndex $cat_index and smallCode $small_code"; */
/* 페이지 복귀시 DB처리*/ 

if($mode == 'register') 
{ 
	$sql = "insert into qpass_question (exam_uid, cat_index, question, answer, answer01, answer02, answer03, answer04, answer05, comment, view_index, reg_time) ";
	$sql .= sprintf("values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now() )",$examUid, $cat_index,$question,$answer,$answer01,$answer02,$answer03,$answer04,$answer05,$comment,$view_index); 
	/*echo $sql;*/ 
	sql_query($sql); 
}
else if($mode == 'update' && $uid) 
{ 
	for($i=0; $i <= 5; $i++) 
	{ 
		if(${"delFile0".$i} == 1) 
		{
			/*echo "del $i<br/>";*/ 
			$destUrl = "./upfile/qpass{$uid}_{$i}"; 
			if( file_exists($destUrl) ) unlink($destUrl); 
		} 
	} 
	
	$sql = "update qpass_question set 
	exam_uid = '$examUid', 
	cat_index = '$cat_index', 
	question = '$question', 
	answer = '$answer', 
	answer01 = '$answer01', 
	answer02 = '$answer02', 
	answer03 = '$answer03', 
	answer04 = '$answer04', 
	answer05 = '$answer05', 
	comment='$comment', 
	view_index = '$view_index' 
	where uid = '$uid' ";
	/*echo $sql;*/ 
	sql_query($sql); 
	$questionUid = $uid; 
	} else if($mode == 'updateList' && $questionUid) { 
		$sql = sprintf("update qpass_question set view_index = '%s' where uid = '%s' ",$view_index,$questionUid); 
		/*echo $sql;*/ 
		sql_query($sql); 
	} else if($mode == 'deleteList' && $questionUid) { 
		/* 업로드된 이미지가 있으면 삭제*/ 
		delete_questionUpfile($questionUid); 
		$sql = sprintf("delete from qpass_question where uid = '%s' ",$questionUid); 
		/*echo $sql;*/
		sql_query($sql); 
	} else if($mode == 'showForm') { ; } 

if($mode == 'register' || $mode == 'update') 
{ 
///	echo "<pre>";
///	print_r($_FILES);

	/* 파일 업로드 처리.*/ 
	for($i=0; $i <= 5; $i++)
	{ 
		$upload_file=$_FILES["file0".$i]['tmp_name'];
		$each_file = ${"file0".$i}; 
		if(is_uploaded_file($upload_file)) 
		{ 
			if(!$uid) $uid = mysql_insert_id(); 
			$dest = sprintf("upfile/qpass%s_%s",$uid,$i);  
			echo $dest;
			if(!move_uploaded_file($upload_file, $dest) ) 
			{
				echo $i." 번째 파일업로드가 제대로 되지 않았습니다. <br/>"; 
			} 
		} 
	} 
} 
?>
<form name='cat_form' method='post' style='margin:0' action='<?php echo $PHP_SELF?>'>
<input type='hidden' name='mode' value=''>
<table width='100%' cellspacing='0' cellpadding='2' style='margin-top:10px;' border='0'>
<tr>
<td align='center' valign='top' width='' class='title01'>문제 관리 :  <select name='big_code' size='1' style='width:150' onchange="this.form.mid_code.value = ''; this.form.small_code.value = ''; this.form.submit()">
<?php
$sql = "select * from qpass_catBig order by big_code"; 

/* where big_code != 99 */ 
$result_big = sql_query($sql); 
while( $row_big = sql_fetch_array($result_big) ) 
{ 
	if($big_code == '') $big_code = $row_big['big_code']; 
	/* 코드가 정해지지 않았으면 첫번째 대분류를 디폴트로 설정.*/  
	if($big_code == $row_big['big_code']) { 
		printf("<option value='%s' selected>%s</option>",$row_big['big_code'],$row_big['big_name']); 
		$big_name = $row_big['big_name']; 
	} else
	printf("<option value='%s'>%s</option>",$row_big['big_code'],$row_big['big_name']);
} 
?>
</select>  <select name='mid_code' size='<?php echo $mid_size?>' style='width:150' onchange="this.form.small_code.value = ''; this.form.submit()">
<?php
$sql = "select * from qpass_catMid where mid_code like '{$big_code}__' order by mid_code"; 
$result_mid = sql_query($sql); 
while( $row_mid = sql_fetch_array($result_mid) ) 
{ 
	if($mid_code == '') $mid_code = $row_mid['mid_code']; 
	/* 코드가 정해지지 않았으면 첫번째 중분류를 디폴트로 설정.*/  
	if($mid_code == $row_mid['mid_code']) { 
		printf("<option value='%s' selected>%s</option>",$row_mid['mid_code'],$row_mid['mid_name']);
		$mid_name = $row_mid['mid_name']; 
	} else printf("<option value='%s'>%s</option>",$row_mid['mid_code'],$row_mid['mid_name']);
}
?>
</select>
<select name='small_code' size='<?php echo $small_size?>' style='width:150; background-color:#FFF8CF' onchange='this.form.submit()'>
<?php
$sql = "select * from qpass_catSmall where small_code like '{$mid_code}__' order by small_code"; 
$result_small = sql_query($sql); 
while($row_small = sql_fetch_array($result_small)) 
{ 
	if($small_code == '') $small_code = $row_small['small_code']; 
	/* 코드가 정해지지 않았으면 첫번째 중분류를 디폴트로 설정.*/  
	if($small_code == $row_small['small_code']) 
	{
		printf("<option value='%s' selected>%s</option>",$row_small['small_code'],$row_small['small_name']); 
		$small_name = $row_small['small_name']; 
	} else printf("<option value='%s'>%s</option>",$row_small['small_code'],$row_small['small_name']); 
	$next_code = substr($row_small['small_code'], 4,2) + 1; 
} 
if($next_code == '') $next_code = 10; 
?>
</select>
<span style='padding-left:20px'><a href="./admin_exam.php?small_code=<?php echo $small_code?>" title='시험관리페이지'><img src='./img/btn_examAdm.gif' width='47' height='20' align='absmiddle'></a></span>
</td>
</tr>
</table>
</form>
<form name='search_form' method='post' style='margin: 10px 0 10px 0' action="<?php echo $PHP_SELF?>">
<input type='hidden' name='mode' value='search'>
<input type='hidden' name='small_code' value='<?php echo $small_code?>'>
<table width='800' align='center' cellpadding='0' cellspacing='0' style='margin: 0' border='0'>
<tr>
<td align='right'>
<select name='examUid' onchange="this.form.cat_index.value=''; this.form.submit()">
<option value=''>전체시험</option>
<?php echo get_examOptions($small_code, $examUid, "desc")?>
</select> &nbsp; <select name='cat_index' onchange='this.form.submit()'>
<option value=''>전체과목</option>
<?php echo get_examCatOptions($examUid, $cat_index)?>
</select>
<span id='questionForm' style='padding-left:15px'><a href="javascript:show_registerForm('<?php echo $questionUid?>')"><img src='./img/btn_questionReg2.gif' width='47' height='20' align='absmiddle' title='문제등록하기'></a></span>
</td>
</tr>
</table>
</form>
<form name='list_form' method='post' style='margin:0' action='<?php echo $PHP_SELF?>'>
<input type='hidden' name='mode' value=''>
<input type='hidden' name='questionUid' value=''>
<input type='hidden' name='view_index' value=''>
</form>
<div id='list_div' style='margin: 0 0 0 0'><?php 
//printf("%s,%s,%s,%s",$small_code, $examUid, $cat_index, $questionUid);
print_question_list_adm($small_code, $examUid, $cat_index, $questionUid); ?></div>
<div id='detail_div' style='margin: 0 0 0 0'>
<?php 
if($questionUid)
{ 
	$sql = sprintf("select * from qpass_question where uid = '%s' ",$questionUid); 
	$resultQuestion = sql_query($sql); 
	$rowQuestion = sql_fetch_array($resultQuestion); 
	$selectedCatSubject = $rowQuestion['cat_index']; 
} else { 
	$selectedCatSubject = $cat_index; 
} 

$catName = $big_name." > ".$mid_name." > ".$small_name; 
if($examUid) { 
	$examName = get_examName($examUid); 
	$catName .= " > ".$examName; 
} 

if($questionUid) $formTitle = "<span style='color:blue'>[$catName]</span><span style='color:red; padding-left:10px'>문제수정</span>"; 
else $formTitle = "<span style='color:blue'>[$catName]</span><span style='color:orange; padding-left:10px'>문제등록</span>";
?>
<form name='detail_form' method='post' action='<?php echo $PHP_SELF?>' enctype="multipart/form-data">
<input type='hidden' name='mode' value=''>
<input type='hidden' name='small_code' value='<?php echo $small_code?>'>
<input type='hidden' name='cat_countTotal' value='<?php echo $cat_countTotal?>'>
<p align='center' style='margin: 0 0 10px 0; font-weight:bold;'><?php echo $formTitle?></p>
<table width='800' align='center' cellspacing='0' cellpadding='3' bordercolor='#D9D9D9' bordercolorlight='#D9D9D9' bordercolordark='white' border='1'>
<tr>
<td width='100' align='center' class='title02_qpass'>시험명</td>
<td width='300'>
<?php 
//printf("%s,examUid : %s",$small_code, $examUid);?>
<select name='examUid' style='width:295' onchange="location.href='admin_question.php?examUid='+this.value">
<option value=''>선택전</option>
<?php 
echo get_examOptions($small_code, $examUid)?>
</select>
</td>
<td width='130' align='center' class='title02_qpass'>문제고유번호</td>
<td width='270' align='center'>
<?php if($questionUid) { echo $questionUid; echo "<input type='hidden' name='uid' value='$questionUid'>"; } else echo "자동생성"; ?>
</td>
</tr>
<tr>
<td width='100' align='center' class='title02_qpass'>문제 <?php if($questionUid == "") {?>
<a href="javascript:toggleView_layer('question')" onfocus='this.blur()'><img src='<?php echo $g5['admin_path']?>/img/icon_help.gif' width='15' height='15' align='absmiddle'></a>
<div id='question' class='help01_qpass' style='margin: 0 0 0 0; position:absolute; visibility:hidden; width:270'>
<span style='font-size:11px; font-weight:normal'>문제나 답항의 이미지 삽입은 먼저 문제를 등록하신 후 문제수정에서 가능합니다.</span>
</div>
<?php }?>
</td>
<td colspan='3' width=''><textarea name='question' rows='3' class='ed' style='width:70%; ime-mode:active' tabindex='1'><?php echo $rowQuestion['question']?></textarea>
<?php if($questionUid) {?>
<input name='file00' type='file' class='border_common_qpass' style='width:28%' style='cursor:pointer' onchange="img_insert('0')">
<?php if(file_exists("./upfile/qpass{$questionUid}_0") ) {?>
<br/>
<img src='./upfile/qpass<?php echo $questionUid?>_0'>
<input type='checkbox' name='delFile00' value='1' onfocus='this.blur()'> 이미지삭제 <?php }?>
<?php }?>
</td>
</tr>
<tr>
<td width='100' align='center' class='title02_qpass'>정답 <a href="javascript:toggleView_layer('answer')" onfocus='this.blur()'><img src='<?php echo $g4['admin_path']?>/img/icon_help.gif' width='15' height='15' align='absmiddle'></a>
<div id='answer' class='help01_qpass' style='margin: 0 0 0 0; position:absolute; visibility:hidden; width:270'>
<span style='font-size:11px; font-weight:normal'>주관식일 경우 정답은 30자 이내로 입력하시고,<br/> 답항 1,2,3,4,5에는 아무것도 입력하지 마세요. 다수정답은 콤마(,)로 구분하세요.</span>
</div>
</td>
<td width='300'><input type='text' name='answer' maxlength='50' value='<?php echo $rowQuestion['answer']?>' class='ed' style='width:99%' tabindex='2'></td>
<td width='100' align='center' class='title02_qpass'>교시분류</td>
<td width=''>
<select name='cat_index'>
<option value=''>선택전</option>
<?php echo get_examCatOptions($examUid, $selectedCatSubject)?>
</select>
</td>
</tr>
<?php 

for($i=1; $i <= 5; $i++) 
{
	?>
<tr>
<td width='100' align='center' class='title02_qpass'>답항<?php echo $i?></td>
<td colspan='3' width=''>
<textarea name='answer0<?php echo $i?>' rows='3' class='ed' style='width:70%' tabindex='<?php echo $i+2?>'><?php echo $rowQuestion["answer0".$i]?></textarea>
<?php if($questionUid) {?>
<input name='file0<?php echo $i?>' type='file' class='border_common_qpass' style='width:28%' style='cursor:pointer' onchange="img_insert('<?php echo $i?>')">
<?php if(file_exists("./upfile/qpass{$questionUid}_{$i}") ) {?>
<br/>
<img src='./upfile/qpass<?php echo $questionUid?>_<?php echo $i?>'>
<input type='checkbox' name='delFile0<?php echo $i?>' value='1' onfocus='this.blur()'> 이미지삭제 <?php }?>
<?php } ?>
</td>
</tr>
<?php 
} 
/* end of for*/
?>
<tr>
<td width='100' align='center' class='title02_qpass'>해설 <a href="javascript:toggleView_layer('comment')" onfocus='this.blur()'><img src='<?php echo $g4['admin_path']?>/img/icon_help.gif' width='15' height='15' align='absmiddle'></a>
<div id='comment' class='help01_qpass' style='margin: 0 0 0 0; position:absolute; visibility:hidden; width:270'>
<span style='font-size:11px; font-weight:normal'>문제응시때는 보이지 않고, 채점후 결과페이지에서 답항들 아래에 노출됩니다.</span>
</div>
</td>
<td colspan='3' width=''><textarea name='comment' rows='3' class='ed' style='width:70%' tabindex='7'><?php echo $rowQuestion['comment']?></textarea>
<?php if($questionUid) {?>
<input name='file05' type='file' class='border_common_qpass' style='width:28%; cursor:pointer' onchange="img_insert('5')">
<?php if(file_exists("./upfile/qpass{$questionUid}_5") ) {?>
<br/>
<img src='./upfile/qpass<?php echo $questionUid?>_5'>
<input type='checkbox' name='delFile05' value='1' onfocus='this.blur()'> 이미지삭제 <?php }?>
<?php }?>
</td>
</tr>
<tr>
<td width='100' align='center' class='title02_qpass' style='line-height:2.0'>문제+답항들 <br/>
<input type='button' value='분산' onclick="question_distribute(this.form)" onfocus='this.blur()' style='padding-top:1px; font-size:12px; cursor:pointer; height:20px; width:40px;'>
<a href="javascript:toggleView_layer('distribute')" onfocus='this.blur()'><img src='<?php echo $g4['admin_path']?>/img/icon_help.gif' width='15' height='15' align='absmiddle'></a>
<div id='distribute' class='help01_qpass' style='margin: 0 0 0 0; position:absolute; visibility:hidden; width:270'>
<span style="font-size:11px; font-weight:normal">외부에서 복사한 문제와 답항들을 붙여넣기하시고 분산버튼을 클릭하시면 자동으로 문제와 답항들로 분산됩니다. 각 항목은 한번의 줄바꿈으로 구분되어야 합니다. 답항 맨앞의 ①②③④⑤ 원문자와 가,나,다,라,마 는 자동제거 됩니다. <br> 입력예) <br>다음중 조류에 속하지 않는 것은?<br>참새<br>제비<br>펭귄<br>박쥐</span>
</div>
</td>
<td colspan='3' width=''><textarea id='together' rows='3' class='ed' style='width:99%'></textarea>
</td>
</tr>
<tr>
<td width='100' align='center' class='title02_qpass'>우선순위 <a href="javascript:toggleView_layer('priority')" onfocus='this.blur()'><img src='<?php echo $g5['admin_path']?>/img/icon_help.gif' width='15' height='15' align='absmiddle'></a>
<div id='priority' class='help01_qpass' style='margin: 0 0 0 0; position:absolute; visibility:hidden; width:220'>
<span style='font-size:11px; font-weight:normal'>각 시험에서 문제가 나열되는 순서는,<br/>1. 교시가 빠른 문제,<br/>2. 우선순위가 빠른 문제, <br/>3. 고유번호가 빠른 문제입니다. <br/>교시나 우선순위를 변경할 시,<br/>문제순서가 변경되므로, 기응시한<br/> 자료는 채점결과가 달라지게 되니<br/> 유의하세요.</span>
</div>
</td>
<?php if($rowQuestion['view_index']) $view_index = $rowQuestion['view_index']; else $view_index = 5; ?>
<td colspan='3' width=''><input type='text' name='view_index' maxlength='100' value='<?php echo $view_index?>' class='ed' style='width:50; text-align:center'>
</td>
</tr>
</table>
<?php if($questionUid) {?>
<p align='center' style='margin: 15px 0 40px 0'><input type='button' value='문제수정' onclick="register_check(this.form, 'update')" onfocus='this.blur()' style='padding-top:2px; font-size:12px; cursor:pointer; height:24px; width:60px;'>
<input type='button' value='응시화면' onclick="location.href = 'qpass_takeExam.php?examUid=<?php echo $examUid?>'" onfocus='this.blur()' style='padding-top:2px; font-size:12px; cursor:pointer; height:24px; width:60px;'></p>
<?php } else {?>
<p align='center' style='margin: 15px 0 40px 0'><input type='button' value='문제등록' onclick="register_check(this.form, 'register')" onfocus='this.blur()' style='padding-top:2px; font-size:12px; cursor:pointer; height:24px; width:60px;'></p>
<?php }?>
</form>
</div>
<?php include_once("./tail_qpass.php"); ?>

<script type='text/javascript'> 

function img_insert(num) {

	 var f = document.detail_form;
	 var ans, comment;
	 /*alert(num);*/

	 var imgHtml = "<img src='upfile/qpass"+f.uid.value+"_"+num+"' align='absmiddle'>";

	 if(num == 0) {
		 f.question.value += imgHtml;
	 }
	 else if(num < 6) {

		  ans = eval("f.answer0"+num);
		  ans.value += imgHtml;
	 }
	 else if(num == 6) {
		   f.comment.value += imgHtml;  
	 }
	 else if(num == 7) {
		 f.questionComment.value += imgHtml;
	 }

}





function register_check(f, mode) {

	  if(f.examUid.value == "") {

		    alert("시험을 선택하세요.");
		    f.examUid.focus();

		    return;
	  }


	  if(f.question.value == "") {

		    alert('문제를 입력하세요.');
			f.question.focus();

			return;
	  }

	  if(f.answer.value == "") {

		    alert('정답을 입력하세요.');
			f.answer.focus();

			return;
	  }

	  if(f.cat_countTotal.value > 0 && f.cat_index.value == "") {

		    alert('과목분류를 선택하세요.');
			f.cat_index.focus();

			return;
	  }

//	  if(f.isObjective.value == 1) {  // 객관식인데 답항이 없는지 체크
//
//		  if(f.answer01.value == "" || f.answer02.value == "" || f.answer03.value == "" || f.answer04.value == "") {
//			  alert("객관식인데 답항이 입력되지 않았습니다.");  return;
//		  }
//	  }


	  if(f.answer01.value && ( f.answer02.value == ""|| f.answer03.value == ""||f.answer04.value == "" )) {

		    alert('일부 답항만 입력되었습니다.');
			return;
	  }

	  if(f.answer02.value && f.answer01.value == "") {

		    alert('일부 답항만 입력되었습니다.');
			
			f.answer01.focus();
			return;
	  }


      f.mode.value = mode;
	  f.submit();
}



function show_registerForm(questionUid) {

	  var f = document.search_form;

	  if(questionUid) {
	  
	        f.mode.value = 'showForm';
	        f.submit();
	  }
	  else {

		    toggleView_block('detail_div');
			location.href = "#detail_div";
	  }
}




function question_modify(uid) {

	 var f = document.list_form;
	 var view_index = document.getElementById('view_index'+uid).value;


	 f.view_index.value = view_index;
	 f.mode.value = 'updateList';
	 
	 f.questionUid.value = uid;
	 f.submit();
}

function question_delete(uid) {

	 var f = document.list_form;

	 if( !confirm('삭제합니까?') ) return;

	 f.mode.value = 'deleteList';
	 f.questionUid.value = uid;

	 f.submit();
}



function delete_indexing_dot(str) {

	  if(str == '') return str;
	  var ch;

	  str = qpass_ltrim(str);

	  ch = str.substr(0,1);

	  if(ch == ".") return str.substr(1, str.length);
	  else  return str;
}


function delete_indexing_num(str) {

	  var list = qpass_split(str, ".");

	  if( isNaN(list[0]) ) return str;
	  else {

		    var numLen = list[0].length;
			str = str.substr(numLen+1, str.length);

			return qpass_ltrim(str);
	  }
}


function delete_indexing_char(str) {

	  if(str == '') return str;
	  var ch;

	  for(var i=0; i < str.length; i++) {

		    ch = str.substr(i,1);

		    if(ch == '①' || ch == '②'  || ch == '③' || ch == '④' || ch == '⑤') {

			     str = str.substr(i+1, str.length);
				 return qpass_ltrim(str);
		    }
			else if(ch == '가' || ch == '나' || ch == '다' || ch == '라' || ch == '마') {
			     
				 str = str.substr(i+1, str.length);
				 str = delete_indexing_dot(str);

				 return qpass_ltrim(str);
			}
	 
	  }
	  return str;
}


function qpass_ltrim(str) {
      
	  if(str == '') return str;

	  for(var i=0; i < str.length; i++) {

		   if(str.substr(i,1) != ' ') {

			   return str.substr(i, str.length);
		   }
	  }
}


function distribute_filtering_question(str) {

	  var str = qpass_ltrim(str);
	  //str = delete_indexing_num(str);

      return str;
}

function distribute_filtering_answer(str) {

	  var str = qpass_ltrim(str);
	  str = delete_indexing_char(str);

      return str;
}

function question_distribute(f) {

	  var list = qpass_split(f.together.value+"\n", "\n");

	  f.question.value = distribute_filtering_question(list[0]);

	  f.answer01.value = distribute_filtering_answer(list[1]);
	  f.answer02.value = distribute_filtering_answer(list[2]);
	  f.answer03.value = distribute_filtering_answer(list[3]);
	  f.answer04.value = distribute_filtering_answer(list[4]);

	  if(list[5]) {
		  f.answer05.value = distribute_filtering_answer(list[5]);
	  }

      f.together.value = "";
}

function qpass_split(str, limiter) {

	  var ch;
	  var arrayCount = 0;
	  var tempStr = "";

	  var list = new Array("", "", "", "", "", "");

	  for(var i=0; i < str.length; i++) {

		    ch = str.substr(i,1);

			if(ch != limiter)  {
				 tempStr = tempStr + "" + ch; 
			}
			else {

                  list[arrayCount++] = tempStr;
				  tempStr = "";

				  if(arrayCount >= 6) break;
			}
	  }

	  return list;
}



/* 공용 함수화*/



function toggleView_block(id) {

	  targetDiv = document.getElementById(id);

	  if(targetDiv.style.display == "none") targetDiv.style.display = "block";
	  else if(targetDiv.style.display == "block") targetDiv.style.display = "none";
}


function toggleView_layer(id) {

	  targetLayer = document.getElementById(id);

	  if(targetLayer.style.visibility == "hidden") targetLayer.style.visibility = "visible";
	  else if(targetLayer.style.visibility == "visible") targetLayer.style.visibility = "hidden";
}



function help_qpass(id, left, top)
{
    menu(id);
    return;


    var el_id = document.getElementById(id);

    submenu = el_id.style;
    submenu.left = 50 + left;
    submenu.top  = 15 + top;

    selectBoxVisible();

    if (el_id.style.display != 'none')
        selectBoxHidden(id);
}


function excelUpload() {

    var w = window.open("excelUploadUTF.php", "uploadWin", "top=100, width=500, height=250, resizable=1, scrollbars=1");
	w.focus();
}


var lineCount = "31";

function checkAll(chk) {

	//alert(lineCount);

	for(var i=1; i < lineCount; i++) {

		document.getElementById("chkBox"+i).checked = chk;
	}
}

function get_checkedStr() {
	
	var checkStr = "";

	for(var i=1; i < lineCount; i++) {

		if(document.getElementById("chkBox"+i).checked == true) {
		
			if(checkStr != "") {  checkStr += ";";  }
			checkStr += document.getElementById("chkBox"+i).value;
		}
	}

	return checkStr;
}


function checkedMove() {

	var checkStr = get_checkedStr();

	if(checkStr == "") {
		alert("선택된 라인이 없습니다.");  return;
	}

	if( !document.getElementById("courseMove")  || !document.getElementById("courseMove").value) {

		alert("시험과목이 선택되지 않았습니다.");  return;
	}

	if( !confirm("이동할까요?") ) {  return;  }
	//alert(checkStr);

	var f = document.sendForm;

	f.mode.value = "multiMove";
	f.checkStr.value = checkStr;
	f.targetExamUid.value = document.getElementById("examUidMove").value;
	f.courseIndex.value = document.getElementById("courseMove").value;
	
	//alert(f.targetExamUid.value);  return;
	f.submit();
}


function checkedDelete() {

	var checkStr = get_checkedStr();

	if(checkStr == "") {
		alert("선택된 라인이 없습니다.");  return;
	}

	if( !confirm("삭제할까요?") ) {  return;  }

	//alert(checkStr);

	var f = document.sendForm;

	f.mode.value = "multiDelete";
	f.checkStr.value = checkStr;
	f.submit();
}


var catAjax;

function load_midMoveSelect(catBigMove) {

	document.getElementById("midCodeMoveSpan").innerHTML = "";
	document.getElementById("smallCodeMoveSpan").innerHTML = "";
	document.getElementById("examUidMoveSpan").innerHTML = "";
	document.getElementById("courseMoveSpan").innerHTML = "";

	var toSend = "./ajax/load_midCodeOptions.php?bigCode=" + catBigMove;
	//alert(toSend); return;

	catAjax = createAjax();
	catAjax.open("get", toSend, false);

	catAjax.onreadystatechange = loadMidCodeResponse;
	catAjax.send("");
}


function loadMidCodeResponse() {

     if(catAjax.readyState == 4 && catAjax.status == 200 ) {
			
			//alert(catAjax.responseText);  //return;
			document.getElementById("midCodeMoveSpan").innerHTML = "<select id='midCodeMove' onchange='load_smallMoveSelect(this.value)'>" + catAjax.responseText + "</select>";
	 }
}


function load_smallMoveSelect(catMidMove) {

	document.getElementById("smallCodeMoveSpan").innerHTML = "";
	document.getElementById("examUidMoveSpan").innerHTML = "";
	document.getElementById("courseMoveSpan").innerHTML = "";

	var toSend = "./ajax/load_smallCodeOptions.php?midCode=" + catMidMove;
	//alert(toSend); return;

	catAjax = createAjax();
	catAjax.open("get", toSend, false);

	catAjax.onreadystatechange = loadSmallCodeResponse;
	catAjax.send("");
}


function loadSmallCodeResponse() {

     if(catAjax.readyState == 4 && catAjax.status == 200 ) {
			
			//alert(catAjax.responseText);  //return;
			document.getElementById("smallCodeMoveSpan").innerHTML = "<select id='smallCodeMove' onchange='load_examMoveSelect(this.value)'>" + catAjax.responseText + "</select>";
	 }
}


function load_examMoveSelect(catSmallMove) {

	document.getElementById("examUidMoveSpan").innerHTML = "";
	document.getElementById("courseMoveSpan").innerHTML = "";

	var toSend = "./ajax/load_examOptions.php?smallCode=" + catSmallMove;
	//alert(toSend); return;

	catAjax = createAjax();
	catAjax.open("get", toSend, false);

	catAjax.onreadystatechange = loadExamResponse;
	catAjax.send("");
}

function loadExamResponse() {

     if(catAjax.readyState == 4 && catAjax.status == 200 ) {
			
			//alert(catAjax.responseText);  //return;
			document.getElementById("examUidMoveSpan").innerHTML = "<select id='examUidMove' onchange='load_examCourses(this.value)'>" + catAjax.responseText + "</select>";
	 }
}


function load_examCourses(examMove) {

	document.getElementById("courseMoveSpan").innerHTML = "";

	var toSend = "./ajax/load_courseOptions.php?examUid=" + examMove;
	//alert(toSend); return;

	catAjax = createAjax();
	catAjax.open("get", toSend, false);

	catAjax.onreadystatechange = loadCoursesResponse;
	catAjax.send("");
}


function loadCoursesResponse() {

     if(catAjax.readyState == 4 && catAjax.status == 200 ) {
			
			//alert(catAjax.responseText);  //return;
			document.getElementById("courseMoveSpan").innerHTML = "<select id='courseMove' onchange=''>" + catAjax.responseText + "</select>";
	 }
}


function moveToggleView() {

	var moveDiv = document.getElementById("moveDiv");

	if(moveDiv.style.visibility == "hidden") {
		moveDiv.style.visibility = "visible";
	}
	else {
		moveDiv.style.visibility = "hidden";
	}
}



</script> 