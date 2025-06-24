<?php
include_once("./qpass_config.php");
include_once("$g4_path/common.php");
include_once("./lib_qpass_inc.php");
admin_check();
/* 코드추출*/ 
if($mode != "search" && $questionUid) {
	$sql = sprintf("select exam_uid, cat_index from qpass_question where uid = '%s' ",$questionUid);
	$code = sqlFetchArrayQ($sql);
	$examUid = $code['examUid'];
	$cat_index = $code['cat_index'];
} if($examUid) { $sql = "select small_code from qpass_exam where uid = '$examUid' ";
	$small_code = sqlFetchArrayQ($sql);
	$small_code = $small_code['small_code'];
	$big_code = substr($small_code, 0,2);
	$mid_code = substr($small_code, 0,4);
} 

$g4['title'] = "Qpass 문제관리";
include_once("./head_qpass.php");
/* echo "examUid $examUid and catIndex $cat_index and smallCode $small_code";
*/ /* 페이지 복귀시 DB처리*/ 
	if($mode == 'register') 
	{ 
		$sql = "insert into qpass_question (exam_uid, cat_index, question, answer, answer01, answer02, answer03, answer04, answer05, comment, view_index, reg_time) ";
		$sql .= sprintf("values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now() )",$examUid, $cat_index,$question,$answer,$answer01,$answer02,$answer03,$answer04,$answer05,$comment,$view_index);
		/*echo $sql;*/ 
		sql_query($sql);
} else if($mode == 'update' && $uid) { 
	for($i=0;$i <= 5;$i++) 
	{
		if(${"delFile0".$i} == 1) 
		{
			/*echo "del $i<br/>";*/ 
			$destUrl = "./upfile/qpass{$uid}_{$i}";
			if( file_exists($destUrl) ) unlink($destUrl);
		} 
	} 
	
	$sql = "update qpass_question set exam_uid = '$examUid', cat_index = '$cat_index', question = '$question', answer = '$answer', answer01 = '$answer01', answer02 = '$answer02', answer03 = '$answer03', answer04 = '$answer04', answer05 = '$answer05', comment='$comment', view_index = '$view_index' where uid = '$uid' ";
	/*echo $sql;*/
	sql_query($sql);
	$questionUid = $uid;
} else if($mode == 'updateList' && $questionUid) { 
	$sql = "update qpass_question set view_index = '$view_index' where uid = '$questionUid' ";
	/*echo $sql;*/
	sql_query($sql);
} else if($mode == 'deleteList' && $questionUid) { 
	/* 업로드된 이미지가 있으면 삭제*/ 
	delete_questionUpfile($questionUid);
	$sql = "delete from qpass_question where uid = '$questionUid' ";
	/*echo $sql;*/
	sql_query($sql);
} else if($mode == 'showForm') { ; } 

if($mode == 'register' || $mode == 'update') 
{
	/* 파일 업로드 처리.*/ 
	for($i=0;$i <= 5;$i++) 
	{
		$each_file = ${"file0$i"};
		if( is_uploaded_file($each_file) ) 
		{
			if(!$uid) $uid = mysql_insert_id();
			$dest = "upfile/qpass{$uid}_{$i}";
			
			if( !move_uploaded_file($each_file, $dest) ) 
			{
				echo " $i 번째 파일업로드가 제대로 되지 않았습니다. <br/>";
			} 
		} 
	} 
}
?> 
<?php
setlocale(LC_CTYPE, 'ko_KR.eucKR'); //CSV데이타 추출시 한글깨짐방지
ECHO ('<meta http-equiv="content-type" content="text/html; charset=utf-8">');
//connect to the database 
//$connect = mysql_connect("localhost","root",""); 
//mysql_select_db("ezrachurch",$connect); //select the table 


$host_name="localhost";
$user_name="root";
$db_name="newezra";
$db_password="";
$db = new mysqli($host_name, $user_name, $db_password, $db_name);
// 
if (isset($_FILES)&&$_FILES['csv']['size'] > 0)
{ 
    //get the csv file 
    $file = $_FILES['csv']['tmp_name']; 
    $handle = fopen($file,"r"); 
    //loop through the csv file and insert into database 
    do { 
        if ($data[0]&&$data[1]&&$data[2]&&$data[3]&&$data[4]&&$data[5]&&$data[6]&&$data[7]&&$data[8]) { 
        	$str0 = iconv("euc-kr","UTF-8", $data[0]);
        	$str1 = iconv("euc-kr","UTF-8", $data[1]);
        	$str2 = iconv("euc-kr","UTF-8", $data[2]);
        	$str3 = iconv("euc-kr","UTF-8", $data[3]);
        	$str4 = iconv("euc-kr","UTF-8", $data[4]);
        	$str5 = iconv("euc-kr","UTF-8", $data[5]);
        	$str6 = iconv("euc-kr","UTF-8", $data[6]);
        	$str7 = iconv("euc-kr","UTF-8", $data[7]);
        	$str8 = iconv("euc-kr","UTF-8", $data[8]);
        /*
        	if($data[0]==""||$date[0]==null){
        		break;
        	}*/
            sql_query("INSERT INTO `qpass_question` (`exam_uid`,`cat_index`, `question`, `answer01`, `answer02`, `answer03`, `answer04`, `answer05`, `answer`, `comment`, `view_index`, `reg_time`) VALUES (
					0,
                    '".addslashes($str0)."',
                    '".addslashes($str1)."',
                    '".addslashes($str2)."',
                    '".addslashes($str3)."',
                    '".addslashes($str4)."',
                    '".addslashes($str5)."',
                    '".addslashes($str6)."',
                    '".addslashes($str7)."',
                    '".addslashes($str8)."',
                    5,
					'".date("Y-m-d H:i:s")."'
                ) 
            ");
        } 
    } while ($data = fgetcsv($handle,1000,",","'")); 
    //redirect 
    //header('Location: gc_change.php?success=1'); die; 
    echo "<script>alert('등록되었습니다');document.form1.action='./gc_change.php?success=1';document.form1.submit();self.close();</script>";die;
} 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Import a CSV File with PHP & MySQL</title> 
</head> 
<body> 
<?php if (!empty($_GET['success'])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 

  <select name='examUid' onchange="this.form.cat_index.value=''; this.form.submit()">
<option value=''>전체시험</option>
<?php echo get_examOptions($small_code, $examUid, "desc")?>
</select> &nbsp; <select name='cat_index' onchange='this.form.submit()'>
<option value=''>전체과목</option>
<?php echo get_examCatOptions($examUid, $cat_index)?>
</select>

  Choose your file: <br /> 
  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" />
  <br/>
  <br/>
<a href="./upfile/qpass-quiz.csv">예제 파일입니다. 받아 보시고 참고 하세요.</a>

</form> 
</body> 
</html> 