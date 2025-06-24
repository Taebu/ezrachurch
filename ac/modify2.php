<?php
include_once "./db_con.php";
include_once "./subject.php";
include_once($_SERVER['DOCUMENT_ROOT'].'/wp/common.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/ac/commons.php');


/* get_image_file($ab_no) */
function get_image_file($ab_no)
{
	global $mysqli;
  $sql=array();
  $result=array();
  $images=array();
  $sql[]="SELECT * FROM `account_image_file` ";
  $sql[]=sprintf("WHERE ab_no=%s order by ab_class, bf_no ;",$ab_no);
  $query = $mysqli->query(join("",$sql));
  //while($list=$query->fetch(PDO::FETCH_ASSOC)){
  while($list=$query->fetch_assoc()){

	  $imgurl1=sprintf("/upload/%s/%s/",$list['ab_class'],$list['bf_date']);
      $imgurl2=sprintf("%s_%s/%s",$ab_no,$list['bf_no'],$list['bf_file']); 
	  $imgurl=sprintf("%s%s",$imgurl1,$imgurl2);
	  $list['url']=$imgurl;
	  array_push($images,$list);

  }
  return $images;
}

?>
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<script src="/wp/js/jquery-1.8.3.min.js"></script>
  <link rel="stylesheet" href="/wp/css/jquery.ui.min.css">  
  <script src="/wp/js/jquery.ui.min.js"></script>

<script>	

function set_modify()
{

	     var formData = new FormData($("#westminster")[0]);

		$.ajax({
			url:"./set_modify2.php",
			dataType:"json",
			type:"POST",
            data:formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
			enctype: 'multipart/form-data',
            success:function(data){
				if(data.success){
				//alert("수정되었습니다.");
//				location.href='/ac/modify2.php?ab_no='+$("#ab_no").val();
				location.href='/ac/list.php';
				}else{
					alert(data.message);
				}
			}
		});
}

/* datepicker */
var dateoption={dateFormat: "yy-mm-dd",
dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
dayNames: [ "일", "월", "화", "수", "목", "금", "토" ],
monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
showOn:"both", buttonImage: "https://jqueryui.com/resources/demos/datepicker/images/calendar.gif"
};

  $( function() {
    $("#ab_date").datepicker(dateoption);
  });
</script>
<style>
select,input{padding:5px 10px 10px 10px;font-size:15px;margin-right:10px;width: 90%;}
textarea{margin: 0px; ;width: 90%; height: 239px;}
.boxsizingBorder {
    -webkit-box-sizing: border-box;
       -moz-box-sizing: border-box;
            box-sizing: border-box;
}
</style>
<script>
(function() {
    function adjustHeight(textareaElement, minHeight) {
        // compute the height difference which is caused by border and outline
        var outerHeight = parseInt(window.getComputedStyle(el).height, 10);
        var diff = outerHeight - el.clientHeight;

        // set the height to 0 in case of it has to be shrinked
        el.style.height = 0;

        // set the correct height
        // el.scrollHeight is the full height of the content, not just the visible part
        el.style.height = Math.max(minHeight, el.scrollHeight + diff) + 'px';
    }


    // we use the "data-adaptheight" attribute as a marker
    var textAreas = [].slice.call(document.querySelectorAll('textarea[data-adaptheight]'));

    // iterate through all the textareas on the page
    textAreas.forEach(function(el) {

        // we need box-sizing: border-box, if the textarea has padding
        el.style.boxSizing = el.style.mozBoxSizing = 'border-box';

        // we don't need any scrollbars, do we? :)
        el.style.overflowY = 'hidden';

        // the minimum height initiated through the "rows" attribute
        var minHeight = el.scrollHeight;

        el.addEventListener('input', function() {
            adjustHeight(el, minHeight);
        });

        // we have to readjust when window size changes (e.g. orientation change)
        window.addEventListener('resize', function() {
            adjustHeight(el, minHeight);
        });

        // we adjust height to the initial content
        adjustHeight(el, minHeight);

    });

}());

function set_image_delete(v)
{
    //alert(v);
    var param = {'table':'account_book','ab_image_file':v,'mode':"image_delete",'ab_no':$("#ab_no").val()};
    $.ajax({
        url:"./set_modify.php",
        dataType:"json",
        type:"POST",
        data:param,
        success:function(data){
            if(data.success)
            {
                alert("삭제성공");


                $("#image_file_area").html("");

                $("#image_file_area").html('<input type="file" name="ab_image_file" id="ab_image_file" class="frm_input" value="">');
            }
        }
    });    
}

function del_img(ab_no,i,type){		
	var param="mode=image_delete&ab_no="+ab_no+"&bf_no="+i+"&type="+type;		
	var object=[];		
	$.ajax({		
		url:"./set_modify2.php",		
		method:"POST",		
		data:param,		
		dataType:"json",		
		success:function(data){		
			if(data.success){
				alert("삭제성공");
				$("#img"+ab_no+"_"+i).html(object.join(""));
				
				location.href='/ac/modify2.php?ab_no='+$("#ab_no").val();
			}else{		
				alert("삭제실패 혹은 통신불량!!!");		
			}		
		}		
	});		
	//alert(st_no+"_"+i);		
}

  var loadFile = function(event) {
	var img = new Image();
    var output = document.getElementById('output_area');
	output.innerHTML="";
	for(var i = 0;i<event.target.files.length;i++){
		
		img = new Image(150,100);
		output.appendChild(img);
		img.src = URL.createObjectURL(event.target.files[i]);
	}
  };


</script>

<style>
textarea{margin: 0px; width: 337px; height: 239px;padding: 15px;line-height: 1.5em;
    border-radius: 25px;}
input{padding:10px;font-size:19px;margin-right:10px;width: 90%;}

	img{padding-right: 5px;padding-bottom: 5px;}
</style>

<?php

function get_numeric($str)
{
	return  preg_replace("/[^0-9]*/s", "", $str); ;
}

if($is_admin){
$sql=sprintf("select ab_no from `account_book` where ab_no<'%s' order by ab_no desc limit 1;",$ab_no);
}else{
$sql=sprintf("select ab_no from `account_book` where ab_no<'%s' and ab_class='%s' order by ab_no desc limit 1;",$ab_no,$executive['ab_class']);
}

$query=$mysqli->query($sql);
$pre=$query->fetch_assoc();

if($is_admin){
$sql=sprintf("select ab_no from `account_book` where ab_no>'%s' limit 1;",$ab_no);
}else{
$sql=sprintf("select ab_no from `account_book` where ab_no>'%s' and ab_class='%s'  limit 1;",$ab_no,$executive['ab_class']);
}


$query=$mysqli->query($sql);
$ord=$query->fetch_assoc();
if($pre)
{
    printf("<a href='./modify2.php?ab_no=%s' class='btn btn_primary'>이전</a>",$pre['ab_no']);
}else{  
    echo "<a class='btn btn_danger'>이전이 없습니다.</a>";
}

if($ord)
{
    printf("<a href='./modify2.php?ab_no=%s' class='btn btn_primary'>다음</a>",$ord['ab_no']);

}else{  
    echo "<a class='btn btn_danger'>다음이 없습니다.</a>";
}


$sql=sprintf("select * from `account_book` where ab_no='%s';",$ab_no);
$query=$mysqli->query($sql);
$view=$query->fetch_assoc();

echo "<form id='westminster' enctype='multipart/form-data'>";
echo sprintf("<input type='hidden' name='ab_no' id='ab_no' value='%s'>",$view['ab_no']);
echo "<input type='hidden' name='table' value='account_book'>";
echo "<input type='hidden' name='mode' value='modify'>";
echo '<table class="ibk_info">';
echo '<tr>';
echo '<th>보드번호</th><th>';
echo $view['ab_no'];
echo '</th></tr>';	
echo '<tr>';
echo '<td>장</td><td>';
echo "<select name='ab_class'>";
foreach($SUBJECT['ko'] as $key =>$value)
{
	if($view['ab_class']==$key){
	printf("<option value='%s' selected>%s</option>",$key,$value);
	}else{
	printf("<option value='%s'>%s</option>",$key,$value);
	}
}
echo "</select>";
echo '</th></tr>';	

echo '<tr>';
echo '<td>날짜 yyyy-mm-dd</td><td>';
printf("<input type='text' name='ab_date' id='ab_date' value='%s'>",$view['ab_date']);
echo '</th></tr>';	
echo '<tr>';
echo '<td>ab_type</td><td>';

$ab_type = array(
"Out"=>"출금",
"In"=>"입금",
"Expenditure"=>"지출결의",
"Budget"=>"예산신청액",
"BudgetPlan"=>"내년예산안"
);
echo "<select name='ab_type'>";
foreach($ab_type as $key=>$value)
{
if($key==$view['ab_type'])
 printf("<option value='%s' selected>%s</option>",$key,$value);
else
 printf("<option value='%s'>%s</option>",$key,$value);
}
echo '</select>';
echo '</th></tr>';	
echo '<tr>';
echo '<td>입출금액</td><td>';

printf("<input type='text' name='ab_amount' value='%s'>",number_format($view['ab_amount']));
echo '</th></tr>';	
echo '<tr>';
echo '<td>내용</td><td>';
printf("<textarea name='ab_contents' cols='30' rows='10' style='width:100%%;line-height:2em;'>%s</textarea>",$view['ab_contents']);
echo '</td></tr>';	
echo '<tr>';
echo '<td>기타</td><td>';
printf("<textarea name='ab_etc' cols='30' rows='10' style='width:100%%;line-height:2em;'>%s</textarea>",$view['ab_etc']);
echo '</td></tr>';	
echo '<tr>';
echo '<td>link1</td><td>';
printf("<input type='text' name='ab_link1' value='%s'>",$view['ab_link1']);
echo '</th></tr>';	
echo '<tr>';
echo '<tr>';
echo '<td>link2</td><td>';
printf("<input type='text' name='ab_link2' value='%s'>",$view['ab_link2']);
echo '</th></tr>';	
echo '<tr>';
echo '<td>이미지들</td><td>';
$images = get_image_file($view['ab_no']);

if(count($images)==0)
{
echo '<input type="file" name="file[]" id="files" class="frm_input" multiple accept="image/*"  onchange="loadFile(event)">';	
echo '<div id="output_area"></div>';

}else{
	$ab_file_length=(int)$view['ab_file'];
echo '<div id="output_area">';

for($i=0;$i<count($images);$i++){
	printf("<img src='%s' width='150' height='100' id='img%s_%s'>",$images[$i]['url'],$images[$i]['ab_no'],$images[$i]['bf_no']);
	printf("<a href='javascript:del_img(%s,%s,\"%s\")'>삭제</a>",$view['ab_no'],$images[$i]['bf_no'],$images[$i]['ab_class']);

}
echo '</div>';
}

echo "<p>여러개 등록 시 컨트롤 또는 쉬프트로 선택 해 주세요.</p>";
echo '</td></tr>';	
echo "</table>";

echo "<input type='button' value='수정' onclick='set_modify();'>";

echo "<input type='button' value='리스트' onclick=\"location.href='./list.php'\">";

?>
<script>
const input = document.querySelector('[name=ab_amount]');
input.addEventListener('keyup', function(e) {
  let value = e.target.value;
  value = Number(value.replaceAll(',', ''));
  if(isNaN(value)) {         //NaN인지 판별
    input.value = 0;   
  }else {                   //NaN이 아닌 경우
    const formatValue = value.toLocaleString('ko-KR');
    input.value = formatValue;
  }
});

</script>