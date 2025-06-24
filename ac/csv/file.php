<?php
include_once "../db_con.php";
include_once "../subject.php";
include_once($_SERVER['DOCUMENT_ROOT'].'/wp/common.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/ac/commons.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CSV import</title>
	<script src="/wp/js/jquery-1.8.3.min.js"></script>

<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<STYLE>
a{
    COLOR: BLUE;
    FONT-WEIGHT: 900;
    text-decoration: underline !important;
}
</STYLE>
</head>
<body>
	
<h1>회계보고 csv 파일 임포트 구현</h1>

예시

샘플 : <a href="./sample.csv" >다운로드</a>
<pre>
type에 
+ 은 입금
- 는 출금
++ 예산신청액
-- 지출 결의

입니다.
</pre>
<form name="upload_form" method="post" enctype="multipart/form-data" id="sms5_fileup_frm">
<div>
<?php
if($is_admin)
{
echo "<select name='ab_class' id='ab_class'>";
foreach($SUBJECT['ko'] as $key =>$value)
{
	if($key==$_GET['ab_class'])
		printf("<option value='%s' selected>%s</option>",$key,$value);
	else
		printf("<option value='%s'>%s</option>",$key,$value);
}
echo "</select>";
}else{

printf("<input type='hidden' name='ab_class' id='ab_class' value='%s'>",$executive['ab_class']);
}
echo $SUBJECT['ko'][$executive['ab_class']];
?>
</div>

<div id="sms5_fileup">
    <label for="csv">파일선택</label>
    <input type="file" name="csv" id="csv" onchange="document.getElementById('upload_info').style.display='none';">
    <span id="upload_button">
        <input type="button" value="파일전송" onclick="upload();" class="btn_submit btn">
    </span>
</div>
<div id="display_area"></div><!-- #display_area -->
<input type='button' value='회계 보고 로 돌아가기' onclick="location.href='/ac/list.php'">
</form>
<script>
function upload(w)
{

	   var form = new FormData();
	   var object = [];
	   var i = 0;
        form.append( "csv", $("#csv")[0].files[0] );
        form.append( "ab_class", $("#ab_class").val() );
        if(w=="Y")
		{
	        form.append( "filesave", "Y");
		}
         $.ajax({
            url : "upload.php",
			type : "POST",
			dataType:"json",
            processData : false,
            contentType : false,
            data : form,
            success:function(data) {
				if(data.success){
			   $("#display_area").html("DB에 Import 작업이 잘 처리 되었습니다.");
				}else{
				object.push("<h5>결과 미리 보기</h5>"); 
				object.push("<table class='reference'>");
				object.push("<tr>");
				object.push("<th>");
				object.push("No");
				object.push("</th><th>");
				object.push("ab_date");
				object.push("</th><th>");
				object.push("ab_type");
				object.push("</th><th>");
				object.push("ab_contents");
				object.push("</th><th>");
				object.push("ab_amount");
				object.push("</th><th>");
				object.push("ab_etc");
				object.push("</th><th>");
				object.push("ab_datetime");
				object.push("</th><th>");
				object.push("ab_class");
				object.push("</th></tr>");
               $.each(data.csv,function(key,val){
					i++;
					object.push("<tr>");
					object.push("<td>");
					object.push(i);
					object.push("</td><td>");
					object.push(val.ab_date);
					object.push("</td><td>");
					object.push(val.ab_type);
					object.push("</td><td>");
					object.push(val.ab_contents);
					object.push("</td><td>");
					object.push(val.ab_amount);
					object.push("</td><td>");
					object.push(val.ab_etc);
					object.push("</td><td>");
					object.push(val.ab_datetime);
					object.push("</td><td>");
					object.push(val.ab_class);
					object.push("</td></tr>");
               });
				object.push("</table>");
				object.push("이대로 적용하시겠습니까?");
				object.push("<br>");
				object.push("<input type='button' value='예' onclick=javascript:upload('Y');>");
				object.push("<input type='button' value='아니오' onclick=javascript:reset_form();>");
			   $("#display_area").html(object.join(""));
					
				}
			   
           }
           ,error: function (jqXHR) 
           { 
               alert(jqXHR.responseText); 
           }
       });
/*
    var f = document.upload_form;

    if (typeof w == 'undefined') {
        document.getElementById('upload_button').style.display = 'none';
        document.getElementById('uploading').style.display = 'inline';
        document.getElementById('upload_info').style.display = 'none';
        f.action = 'upload.php?confirm=1';
    } else {
        document.getElementById('upload_button').style.display = 'none';
        document.getElementById('upload_info').style.display = 'none';
        document.getElementById('register').style.display = 'block';
        f.action = 'upload.php';
    }
    (function($){
        if(!document.getElementById("fileupload_fr")){
            var i = document.createElement('iframe');
            i.setAttribute('id', 'fileupload_fr');
            i.setAttribute('name', 'fileupload_fr');
            i.style.display = 'none';
            document.body.appendChild(i);
        }
        f.target = 'fileupload_fr';
        f.submit();
    })(jQuery);
	*/
}
function reset_form()
{
	$("#display_area").html("DB Import 작업이 취소 되었습니다.");
}
</script>
</body>
</html>
