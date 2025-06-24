<?php 
include_once("./qpass_config.php"); 
include_once("$g4_path/common.php"); 
include_once("./lib_qpass_inc.php"); admin_check(); 
$g4['title'] = "Qpass 중분류 관리"; 
include_once("./head_qpass.php"); 
$g4['title'] = "Qpass 중분류 관리"; 
if($mode == 'add') { 
	$sql = "select count(*) from qpass_catMid where mid_code = '$mid_code_new' "; 
	$result_count = sql_query($sql); 
	$cat_count = mysql_result($result_count, 0,0); 
	if($cat_count > 0) 
	{
		echo "<script>alert('\\n코드 $mid_code 은(는) 이미 생성된 코드이니, 목록에서 처리하세요.\\t');</script>"; 
	} else {
		$sql = "insert into qpass_catMid (mid_code, mid_name) values ('$mid_code_new', '$mid_name')"; 
		/*echo $sql;*/ 
		sql_query($sql); 
	} 
}else if($mode == 'modify' && $mid_code) { 
	$sql = "update qpass_catMid set mid_name = '$mid_name' where mid_code = '$mid_code' "; 
	/*echo $sql;*/ 
	sql_query($sql); 
} else if($mode == 'delete' && $mid_code) { 
	$sql = "delete from qpass_catMid where mid_code = '$mid_code' ";
	/*echo $sql;*/ 
	sql_query($sql); 
} 
?> 

<script type='text/javascript'> 
function code_check(code, next_field) 
{ 
	if( isNaN(code.value) ) 
	{
		alert("\n코드는 숫자만 가능합니다. (10~99)\t"); code.value = ''; 
		code.focus();
		return;
	}
	
	if( code.value.length == 1 && code.value == 0 ) 
	{
		alert("\n코드는 0 으로 시작하지 않아야 합니다.\t");
		code.value = '';
		code.focus();
		return; 
	}
	
	if(code.value.length == 2) next_field.focus(); 
} 

function add_check(f, big_code) 
{ 
	if( f.mid_code_short.value.length < 2 ) {  alert("\n코드길이를 두자리수로 입력하세요.\t"); f.mid_code_short.focus();  return; } 
	if( f.mid_name.value == '' ) {  alert("\n분류명을 입력하세요.\t"); f.mid_name.focus();  return; } f.mode.value = 'add'; f.mid_code_new.value = big_code + f.mid_code_short.value; f.submit(); 
	
} 

function mid_modify(big_code, mid_code)
{ 
	var f = document.send_form; 
	f.big_code.value = big_code; 
	f.mid_code.value = mid_code; 
	f.mid_name.value = document.getElementById('name_'+mid_code).value; 
	f.mode.value = 'modify'; f.submit();
} 

function mid_delete(code) {
	var f = document.send_form; 
	if( !confirm("\n정말 삭제합니까?\t") ) 
	return; 
	f.mid_code.value = code; 
	f.mode.value = 'delete'; 
	f.submit();
	} 
</script>

<form name='send_form' method='post' style='margin:0' action='<?php echo $PHP_SELF?>'> 
<input type='hidden' name='mode' value=''> 
<input type='hidden' name='big_code' value=''> 
<input type='hidden' name='mid_code' value=''> 
<input type='hidden' name='mid_name' value=''> 
</form> 
<form name='cat_form' method='post' style='margin:0' action='<?php echo $PHP_SELF?>'> 
<input type='hidden' name='mode' value=''> 
<input type='hidden' name='mid_code_new' value=''> 
<p align='center' style='margin:20px 0 0 0; font-weight:bold;'>중분류 목록</p> 
<table width='600' cellspacing='0' cellpadding='2' bordercolor='#D9D9D9' bordercolorlight='#D9D9D9' bordercolordark='white' align='center' style='margin-top:10px;' border='1'> 
<tr> 
<td align='center' width='120'>대분류</td> 
<td align='center' width='170'>중분류</td> 
<td align='center' width=''>중분류 수정/삭제</td> 
</tr> 
<tr> 
<td align='center'> 
<select name='big_code' size='10' style='width:98%' onchange="this.form.mid_code.value = ''; this.form.submit()"> 
<?php 
$sql = "select * from qpass_catBig order by big_code"; 
$result_big = sql_query($sql); 
while( $row_big = sql_fetch_array($result_big) ) { 
	if($big_code == '') $big_code = $row_big['big_code']; 
	/* 코드가 정해지지 않았으면 첫번째 대분류를 디폴트로 설정.*/  
	if($big_code == $row_big['big_code']) {  
		printf("<option value='%s' selected>[%s] %s</option>",$row_big['big_code'],$row_big['big_code'],$row_big['big_name']);
		$big_name = $row_big['big_name']; 
	} else printf("<option value='%s'>[%s] %s</option>",$row_big['big_code'],$row_big['big_code'],$row_big['big_name']); } ?> 
</select> 
</td> 
<td align='center'> 
<select name='mid_code' size='10' style='width:98%' onchange='this.form.submit()'> 
<?php 
$sql = "select * from qpass_catMid where mid_code like '{$big_code}__' order by mid_code"; 
$result_mid = sql_query($sql); 
while( $row_mid = sql_fetch_array($result_mid) ) 
{ 
	if($mid_code == '') $mid_code = $row_mid['mid_code']; 
	/* 코드가 정해지지 않았으면 첫번째 중분류를 디폴트로 설정.*/  
	if($mid_code == $row_mid['mid_code']) 
	{ 
		printf("<option value='%s' selected>[%s] %s</option>",$row_mid['mid_code'],$row_mid['mid_code'],$row_mid['mid_name']);
		$mid_name = $row_mid['mid_name']; } 
		else printf("<option value='%s'>[%s] %s</option>",$row_mid['mid_code'],$row_mid['mid_code'],$row_mid['mid_name']);
		$next_code = substr($row_mid['mid_code'], 2,2) + 1; 
	} 
	if($next_code == '') $next_code = 10; ?> 
</select> 
<?php /*echo $sql;*/?> 
</td> 
<td align='center' valign='top'> 
<table width='100%' cellspacing='0' cellpadding='1' style='margin-top:7px;'> 
<tr>  <td align='center' width='60'>코드</td> 
<td align='center'>분류명</td> 
<td align='center' width='80'>처리</td>  </tr>  <tr>  <td align='center'><?php echo $mid_code?></td> 
<td align='center'><input type='text' id='name_<?php echo $mid_code?>' maxlength='30' value='<?php echo $mid_name?>' class='ed' style='width:100%'></td> 
<td align='center'><input type='button' value='수정' onclick="mid_modify('<?php echo $big_code?>', '<?php echo $mid_code?>')" onfocus='this.blur()' style='padding-top:1px; height:20px; width:30px; font-size:12px'> 
<input type='button' value='삭제' onclick='mid_delete(<?php echo $mid_code?>)' onfocus='this.blur()' style='padding-top:1px; height:20px; width:30px; font-size:12px'> 
</td>  </tr> 
</table> 
</td> 
</tr> 
</table> 
<p align='center' style='margin:30px 0 0 0; font-weight:bold;'><span style='color:blue'>[<?php echo $big_name?>]</span> 중분류 추가</p> 
<p align='center'> 
<table width='600' cellspacing='0' cellpadding='5' bordercolor='#D9D9D9' bordercolorlight='#D9D9D9' bordercolordark='white' align='center' style='margin:0 auto;' border='1'> 
<tr> 
<td align='center' width='70'>코드</td> 
<td align='center' width='440'>분류명</td> 
<td align='center' width='90'>처리</td> 
</tr> 
<tr> 
<td align='center'><?php echo $big_code?> 
<input type='text' name='mid_code_short' size='2' maxlength='2' class='ed' style='text-align:left;' onkeyup='code_check(this, this.form.mid_name)' value='<?php echo $next_code?>'></td> 
<td align='left'><input type='text' name='mid_name' maxlength='30' class='ed' style='width:100%; ime-mode:active;'></td> 
<td align='center' width='90'> 
<input type='button' value="추가하기" onclick="add_check(this.form, '<?php echo $big_code?>')" style='cursor:pointer; padding-top:1px; height:20px; width:60px;'> 
</td> 
</tr> 
<tr><td colspan='3' align='center' style='color:green;'>코드는 칸 안에 10 ~ 99 사이 숫자로 입력하세요.</td></tr> 
</table> 
</p> 
</form> 
<?php include_once("./tail_qpass.php"); ?> 