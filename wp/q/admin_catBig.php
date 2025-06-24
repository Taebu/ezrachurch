<?php
include_once("./qpass_config.php");
include_once("$g4_path/common.php");
include_once("./lib_qpass_inc.php");
admin_check();
$g4['title'] = "Qpass 대분류 관리";
include_once("./head_qpass.php");
if($mode == 'add') { 
	$sql = sprintf("select count(*) as cnt from qpass_catBig where big_code = '%s' ",$big_code);
	/*echo $sql;*/ 
	$result_count = sql_query($sql);
	$cat_count = sql_fetch($result_count);
	$cat_count =  $cat_count['cnt'];
	if($cat_count > 0) 
	{ 
		echo "<script>alert('\\n코드 $big_code 은(는) 이미 생성된 코드이니, 목록에서 처리하세요.\\t');</script>";
	} else { 
		$sql = sprintf("insert into qpass_catBig (big_code, big_name) values ('%s', '%s')",$big_code,$big_name);
//s		echo $sql;
		sql_query($sql);
//		if( mysql_errno() > 0 ) echo "error: ".mysql_error();
	} 
} else if($mode == 'modify' && $big_code) 
{	
	$sql = "update qpass_catBig set big_name = '$big_name' where big_code = '$big_code' ";
	/*echo $sql;*/ 
	sql_query($sql);
} else if($mode == 'delete' && $big_code) { 
	$sql = "delete from qpass_catBig where big_code = '$big_code' ";
	sql_query($sql);
} 

?> 
<script type='text/javascript'> 
function code_check(code, next_field) 
{ 
	if( isNaN(code.value) ) { 
		alert("\n코드는 숫자만 가능합니다. (10~99)\t");
	code.value = '';
	code.focus();
	 return;
	} if( code.value.length == 1 && code.value == 0 ) {  
		alert("\n코드는 0 으로 시작하지 않아야 합니다.\t");
	code.value = '';
	code.focus();
	 return;
}
if(code.value.length == 2) next_field.focus();
}

function add_check(f) 
{
	if( f.big_code.value.length < 2 ) {  
		alert("\n코드길이를 두자리수로 입력하세요.\t");
	f.big_code.focus();
	 return;
	} if( f.big_name.value == '' ) {  alert("\n분류명을 입력하세요.\t");
	f.big_name.focus();
	 return;
	} f.mode.value = 'add';
	f.submit();
} 

function line_modify(code) { 
	var f = document.send_form;
	f.mode.value = 'modify';
	f.big_code.value = code;
	f.big_name.value = document.getElementById('name_'+code).value;
	f.submit();
} 

function line_delete(code) { 
	var f = document.send_form;
	if( !confirm("\n정말 삭제합니까?\t") ) return;
	f.mode.value = 'delete';
	f.big_code.value = code;
	f.submit();
} 
</script> 
<form name='send_form' style='margin:0' action='<?=$PHP_SELF?>'>
<input type='hidden' name='mode' value=''>
<input type='hidden' name='big_code' value=''>
<input type='hidden' name='big_name' value=''>
</form>
<form name='cat_form' style='margin:0' action='<?=$PHP_SELF?>'>
<input type='hidden' name='mode' value=''>
<p align='center' style='margin:20px 0 0 0;
font-weight:bold;'>대분류 목록</p>
<table width='400' cellspacing='0' cellpadding='5' bordercolor='#D9D9D9' bordercolorlight='#D9D9D9' bordercolordark='white' align='center' style='margin-top:10px;' border='1'>
<tr>
<td align='center' width='50'>코드</td>
<td align='center'>분류명</td>
<td align='center' width='90'>처리</td>
</tr>
<?php
$sql = "select * from qpass_catBig order by big_code";
$result_cat = sql_query($sql);
$row_cat = sql_fetch_array($result_cat);
if(!$row_cat) { 
	echo "<tr height='50'><td colspan='3' align='center'>대분류 자료가 없습니다.</td></tr>";
	$next_code = 10;
} else { 
	do { 
		$code = $row_cat['big_code'];
		echo "<tr><td align='center' width='50'>$code</td>";
		printf("<td align='center'><input type='text' id='name_%s' value='%s' class='ed'></td>",$code,$row_cat['big_name']);
		echo "<td align='center' width='90'>";
		printf("<input type='button' value='수정' onclick='line_modify(%s)' onfocus='this.blur()' style='padding-top:1px;width:40px;height:20px;cursor:pointer;'>",$code);
		printf("<input type='button' value='삭제' onclick='line_delete(%s)' onfocus='this.blur()' style='padding-top:1px;width:40px;height:20px;cursor:pointer;'> </td> </tr>",$code);
		if($code != 99) $next_code = $code + 1;
	} while( $row_cat = sql_fetch_array($result_cat) );
} ?>
</table> 
<p align='center' style='margin:30px 0 0 0;font-weight:bold;'>대분류 추가</p>
<p align='center'>
<table align='center' width='400' cellspacing='0' cellpadding='5' bordercolor='#D9D9D9' bordercolorlight='#D9D9D9' bordercolordark='white' style='margin:0 auto;' border='1'>
	<tr>
		<td align='center' width='50'>코드</td>
		<td align='center'>분류명</td>
		<td align='center' width='90'>처리</td></tr>
	<tr>
		<td align='center' width='50'><input type='text' name='big_code' size='2' maxlength='2' class='ed' style='text-align:center;' onkeyup='code_check(this, this.form.big_name)' value='<?=$next_code?>'></td>
		<td align='center'><input type='text' name='big_name' maxlength='30' class='ed' style='width:150px;ime-mode:active;'></td>
		<td align='center' width='90'><input type='button' value="추가하기" onclick="add_check(this.form)" style='cursor:pointer;padding-top:1px;height:20px;width:60px;'></td></tr>
	<tr><td colspan='3' align='center' style='color:green;'>코드는 10 ~ 99 사이 숫자로 입력하세요.</td></tr>
</table>
</p>
	</form>
<?php include_once("./tail_qpass.php");?>