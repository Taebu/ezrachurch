<?php
include_once "./db_con.php";
include_once "./subject.php";
include_once($_SERVER['DOCUMENT_ROOT'].'/wp/common.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/ac/commons.php');
$ab_date=date("Y-m-d");
?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<script src="/wp/js/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" href="/wp/css/jquery.ui.min.css">  
<style>
</style>
<script src="/wp/js/jquery.ui.min.js"></script>
<script>	
function set_write()
{
	     var formData = new FormData($("#westminster")[0]);
		$.ajax({
			url:"./set_write2.php",
			dataType:"json",
			type:"POST",
            data:formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
			enctype: 'multipart/form-data',
            success:function(data){

//			if(data.success){
//				alert("입력되었습니다.");
				location.href='./list.php';
//			}else{
//					alert(data.message);
//				}
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
})
});
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

var is_help_show = false;
function show_help(type)
{
	if(!is_help_show)
	{
		$("#help_ab_type").show();
	}else{
		$("#help_ab_type").hide();
	}
	is_help_show = !is_help_show;
}
</script>
<style>
textarea{margin: 0px; width: 90%; height: 239px;font-size: 19px;padding: 10px;}
input{padding:10px;font-size:19px;margin-right:10px;width: 90%;}
.help{padding:0px;font-size:10px;margin:0px;width: 15px;}
	img{padding-right: 5px;padding-bottom: 5px;}
	#help_ab_type{display:none;}
</style>
<?php
function get_numeric($str)
{
	return  preg_replace("/[^0-9]*/s", "", $str); ;
}
echo "<form id='westminster'>";
echo "<input type='hidden' name='table' value='account_book'>";
printf("<input type='hidden' name='bf_date' value='%s'>",date("Ymd"));
echo "<input type='hidden' name='page_start_size' id='page_start_size' value='1'>";
echo '<table class="ibk_info">';
echo '<tbody id="page_area">';
echo '<tr>';
echo '<td>장</td><td>';

if($is_admin)
{
echo "<select name='ab_class'>";
foreach($SUBJECT['ko'] as $key =>$value)
{
	if($key==$_GET['ab_class'])
		printf("<option value='%s' selected>%s</option>",$key,$value);
	else
		printf("<option value='%s'>%s</option>",$key,$value);
}
echo "</select>";
}

if($is_multiple){
	echo "<select name='ab_class'>";
	foreach($account_users as $key =>$value)
	{
	if($value['ab_class']==$_GET['ab_class'])
		printf("<option value='%s' selected>%s</option>",$value['ab_class'],$SUBJECT['ko'][$value['ab_class']]);
	else
		printf("<option value='%s'>%s</option>",$value['ab_class'],$SUBJECT['ko'][$value['ab_class']]);
	}
	echo "</select>";
}else if(!$is_admin){
	printf("<input type='hidden' name='ab_class' id='ab_class' value='%s'>",$executive['ab_class']);
	echo $SUBJECT['ko'][$executive['ab_class']];
}
echo '</th></tr>';	

echo '<tr>';
echo '<td>날짜 yyyy-mm-dd</td><td>';
printf("<input type='text' name='ab_date' id='ab_date' value='%s'>",$ab_date);
echo '</th></tr>';	
echo '<tr>';
echo '<td>ab_type <input type="button" value="?" class="help" onclick="javascript:show_help(\'ab_type\')"></td><td>';

echo "<select name='ab_type'>";
echo "<option value='In'>입금</option>";
echo "<option value='Out'>출금</option>";
echo "<option value='Budget'>예산신청액</option>";
echo "<option value='Expenditure'>지출결의</option>";
echo "<option value='BudgetPlan'>내년 예산안</option>";
echo "</select>";
echo "<div id='help_ab_type'>";
echo "<pre>";
echo "입금(In)\r\n";
echo "해당 분기에 이월금, 청구한 예산 입금, 기타 수익을 입력합니다.\r\n";
echo "\r\n";
echo "<b>출금(Out)</b>\r\n";
echo "해당 분기에 출금 내역 및 영수증 파일을 첨부하고, 해당 구매 링크 참고할 사항을 기입합니다.\r\n";
echo "\r\n";
echo "<b>예산신청액(Budget)</b>\r\n";
echo "해당 분기에 감안한 지출내역과 향후 개획을 합산 하여 예산을 이월금과 분리 하여 각각 청구 합니다.\r\n";
echo "\r\n";
echo "<b>지출결의(Expenditure)</b>\r\n";
echo "해당 분기에 지출내역에 해당 하는 상세 지출 내역을 기록 합니다.\r\n";
echo "\r\n";
echo "<b>내년 예산안(BudgetPlan)</b>\r\n";
echo "매년 4분기에 해당 하는 내용을 정리하여 매년 4분기에 입력 합니다. (1~3분기는 입력 할 필요가 없습니다.\r\n";
echo "\r\n";
echo "\r\n";
echo "회계 범위는 \r\n";
echo "1분기 : 전년 12월 9일 ~ 3월 8일 입니다. \r\n";
echo "2분기 : 금년 3월 10일 ~ 6월 9일 입니다. \r\n";
echo "3분기 : 금년 6월 10일 ~ 9월 8일 입니다. \r\n";
echo "4분기 : 금년 9월 9일 ~ 12월 8일 입니다. \r\n";
echo "\r\n";
echo "\r\n";
echo "두 개의 파일 인수인계 서 입니다. 옥신덕 집사님이 제작 해주셨습니다.\r\n";
echo "<h4>입금 출금</h4>\r\n";
echo '<video controls width="830">';
echo '  <source src="/ac/lib/media/account_help2.mp4" type="video/mp4" />';
echo '</video>';
echo "\r\n";
echo "\r\n";
echo "<h4>예산신청액, 지출결의</h4>\r\n";
echo '<video controls width="830">';
echo '  <source src="/ac/lib/media/account_help1.mp4" type="video/mp4" />';
echo '</video>';
echo "</pre>";
echo "</div><!-- #help_ab_type -->";
echo '</th></tr>';	
echo '<tr>';
echo '<td>입출금</td><td>';
echo "<input type='text' name='ab_amount' value=''>";
echo '</th></tr>';
echo '<tr>';
echo '<td>link1</td><td>';
echo "<input type='text' name='ab_link1' value=''>";
echo '</th></tr>';	
echo '<tr>';
echo '<tr>';
echo '<td>link2</td><td>';
echo "<input type='text' name='ab_link2' value=''>";
echo '</th></tr>';	
echo '<tr>';
echo '<td>내용
<br>
"일반헌금","절기헌금","기타"
는 당회의 합산 금액으로 입금으로 입력시 합계에서 제외 됩니다. 세개의 단어만 피해 주세요.
</td><td>';
echo "<textarea name='ab_contents'></textarea>";
echo '</td></tr>';	
echo '<tr>';
echo '<td>기타</td><td>';
echo "<textarea name='ab_etc'></textarea>";
echo '</td></tr>';	
echo '<tr>';
echo '<td>이미지들</td><td>';
echo '<input type="file" name="file[]" id="files" class="frm_input" multiple accept="image/*"  onchange="loadFile(event)">';	
echo '<div id="output_area"></div>';
echo "<p>여러개 등록 시 컨트롤 또는 쉬프트로 선택 해 주세요.</p>";
echo '</td></tr>';	
echo '</tbody>';

echo "</table>";

echo "<input type='button' value='쓰기' onclick='set_write();'>";