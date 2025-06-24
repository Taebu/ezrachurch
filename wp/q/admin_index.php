<?php
include_once("./qpass_config.php");
include_once("$g4_path/common.php");

if($is_admin != "super")
	alert("관리자만 접근가능합니다.\\t", "./");

include_once("./lib_qpass_inc.php");
include_once("./head_qpass.php");

if($mode == "update") 
{
	$sql ="update qpass_config set delete_limit = '$delete_limit'";

	/*echo $sql;*/
	sql_query($sql);

	if(!mysql_errno())
		echo "<script>alert('정상 수정되었습니다.')</script>";
}


$sql  = "select delete_limit from qpass_config";
$result = sql_query($sql);

$row = sql_fetch_array($result);

/* 오래된 자료 삭제*/
if($row->delete_limit > 0) 
{
	  $sql = "delete from qpass_result where to_days( curdate() ) - to_days( latest_tryTime ) > $row->delete_limit";
	  sql_query($sql);
}

$sql = "select count(*) as cnt from qpass_result";
$resultCount = sqlFetchArrayQ($sql);
$resultCount = $resultCount['cnt'];
$sql = "select count(*) as cnt from qpass_result";
$result = sql_query($sql);
list($test)= mysqli_fetch_row($result);

echo $test;
?>

<p class='title03_qpass'>관리자 메인</p>
<form name='configForm' method='post'>
<input type='hidden' name='mode' value='update'>
<table width='100%' align='center' cellpadding='2' cellspacing='0' style='margin-top:15px' border='0'>
<tr height='35'>
<td>&nbsp;</td>
<td colspan='3' align='right'>현재 총 응시건수 : <?php echo $resultCount?>건</td>
<td>&nbsp;</td>
</tr>
<tr height='35'>
<td>&nbsp;</td>
<td width='100' class='title02_qpass' style="border: solid 1px #ccc">시험기록 삭제</td>
<td width='300' align='left' style="border-top: solid 1px #ccc; border-bottom: solid 1px #ccc">
응시후 <input type=text name='delete_limit' size='5' class='textInput_qpass' value='<?php echo $row->delete_limit?>'> 일 경과시 자동삭제 (공백은 무기한)</td>
<td width='100' align='center' style="border: solid 1px #ccc"><input type='button' value='수정' style='padding:2px; cursor:pointer' onclick='pre_check(this.form)'></td>
<td>&nbsp;</td>
</tr>
<td>&nbsp;</td>
<td colspan='3' align='left' style="padding-top:15px; color:#bb8800">
관리자가 로그인 할때마다 설정된 날보다 오래된, <span style='color:crimson'>응시 기록</span>이 자동으로 삭제됩니다. <br/>
삭제하지 않고 기록을 계속 보존하려면 공백으로 두세요.<br/> 
(총건수가 수만건이내면 공백으로 두셔도 무관)</td>
<td>&nbsp;</td>
</tr>
</table>
</form>

<script>
function pre_check(f) {
  if( isNaN(f.delete_limit.value) ) {
	  alert('숫자 또는 공백을 입력하세요.    ');
	  f.delete_limit.focus();
	  return;
  }
  f.submit();
}
</script>
<?php include_once("./tail_qpass.php");?>