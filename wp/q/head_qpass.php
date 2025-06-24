<?php
//print_r($g4);
include_once("../head.sub.php");


if($examUid)
{
	$sql = sprintf("select small_code, cat_countTotal from qpass_exam where uid = '%s' ",$examUid);
	$code = sqlFetchArrayQ($sql);
	$smallCode = $code['small_code'];
	$cat_countTotal = $code['cat_countTotal'];
}

if($smallCode) {

	$bigCode = substr($smallCode, 0,2);
	$midCode = substr($smallCode, 0,4);
}

?>

<link rel='stylesheet' href='style_qpass.css' type='text/css'>
<table width='970' align='center' cellspacing='0' cellpadding='0' style='margin: 5px 0 0 0; border:solid 1px #ccc' border='0'><!-- 1차 -->
<tr>
<td width='100%' height='55' style='border-bottom:solid 1px #ccc'>
	<table width='100%' height='100%' cellpadding='0' cellspacing='0' border='0'><!-- 2차 -->
	<tr>
		<td width='140' align='center'><a href="./" style='font-family:tahoma; font-size:22px; color:orange'>Ezrapass</a></td>
		<td valign='top'>
			<table width='100%' cellpadding='0' cellspacing='0' border='0'><!-- 3차 -->
			<tr><!-- 아웃로그인 라인 -->
			<td valign='top'>
<?php
if($member['mb_id']) { include "./login_after_inc.php"; }
else               { include "./login_before_inc.php"; }
?>
				
				</td>
				</tr>

				
				<tr><!-- 탑메뉴  라인 -->
				<td>
<?php
include "./menu_top_inc.php"; 
?>				
				</td>
				</tr>

				</table>

		
		
		
		</td>

		</tr>
		</table>

</td>
</tr>



<tr>
<td height='685' valign='top' style=''>