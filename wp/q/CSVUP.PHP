<?php
setlocale(LC_CTYPE, 'ko_KR.eucKR'); //CSV데이타 추출시 한글깨짐방지
ECHO ('<meta http-equiv="content-type" content="text/html; charset=utf-8">');

IF($upfile_name){
    //폴더내에 동일한 파일이 있는지 검사하고 있으면 삭제
     if(file_exists("../data/$upfile_name") ){
               unlink("../data/$upfile_name");
    }
    if(!$upfile) {
        ECHO("<script>window.alert('지정된 용량(2M)을 초과');
                      history.go(-1)
                    </script>");
        EXIT;
    }
    if( strlen($upfile_size) < 7 ) {
        $filesize = sprintf("%0.2f KB", $upfile_size/1000);
    }else{
        $filesize = sprintf("%0.2f MB", $upfile_size/1000000);
    }
    if(!copy($upfile, "../bbs/data/$upfile_name")){
        ECHO("<script>window.alert('디렉토리에 복사실패');
                      history.go(-1)
                    </script>");
         EXIT;
    }
    if(!unlink($upfile)){
         ECHO("<script>window.alert('임시 파일삭제 실패');
                       history.go(-1)
                    </script>");
         EXIT;
    }
}

$dbtable  = "qpass_question";
//DB접속정보를 함수로 미리 구현해놓고

$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_password = 'apmsetup';
$mysql_db = 'ezrachurch';

$connect_db = mysql_connect( "localhost", "root", "apmsetup") or die( "SQL server에 연결할 수 없습니다.");
$connect  = mysql_select_db($mysql_db, $connect_db);



//$connect  = dbconn();
// 저장된 파일을 읽어 들인다
$csvLoad  = file("../data/$upfile_name");
// 행으로 나누어서 배열에 저장
$csvArray = split("\n",implode($csvLoad));

// 행으로 나눠진 배열 갯수 만큼 돌린다($enter[0]에는 필드 이름이 있으므로 $i는 1번 부터 시작하고 총 갯수는 $csvArray에서 1를 뺀다
for($i=1;$i<count($csvArray)-1;$i++){
    //각 행을 콤마를 기준으로 각 필드에 나누고 DB입력시 에러가 없게 하기위해서 addslashes함수를 이용해 \를 붙인다
    $field     = split(",",addslashes($csvArray[$i]));
    //나누어진 각 필드에 앞뒤에 공백을 뺸뒤 ''따옴표를 붙이고 ,콤마로 나눠서 한줄로 만든다.
    $value     = "'" . trim(implode("','",$field)) . "'";
    // php쿼리문을 이용해서 입력한다.
    $insertSQL = sprintf("INSERT INTO %s (%s) VALUES (%s)", $dbtable , $csvArray[0], $value);
    $Result       = mysql_query($insertSQL) or die(mysql_error());
}
//입력이 된후 업로드된 파일을 삭제한다
unlink("../data/$upfile_name"); 

 

if($Result){
   ECHO("<script>window.alert('주소록을 성공적으로 저장하였습니다.');
                 history.go(-1)
               </script>");
}


@mysql_close();
?>