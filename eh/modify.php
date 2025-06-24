<?php
$arrow_ip = array();
$arrow_ip[] = "14.5.85.81";
$arrow_ip[] = "172.30.1.254";
if(!in_array($_SERVER['REMOTE_ADDR'],$arrow_ip))
{
$date = new DateTimeImmutable();

$date=$date->format("y.m.d");

$day = date("Y-m-d");

$week = array("주일" , "월요"  , "화요" , "수요" , "목요" , "금요" ,"토요") ;


$weekday = $week[ date('w'  , strtotime($day)  ) ] ;


$type=$weekday;



$title="그리스도인의 자유";
$verse="고린도후서 3장 17-18절";
$author = "남궁현우 목사";
$babtizo_title = sprintf("%s %s예배 - \"%s\"(%s,%s)",$date,$type,$title,$verse,$author);
$babtizo_title = sprintf("%s %s예배 - \"%s\"(%s,%s)",$date,$type,$title,$verse,$author);
echo $babtizo_title;
echo "<br>";
echo "2 Kings Chapter. 18";
echo "<br>";
echo "18 저가 대답하되 내가 이스라엘을 괴롭게 한 것이 아니라 당신과 당신의 아비의 집이 괴롭게 하였으니 이는 여호와의 명령을 버렸고 당신이 바알들을 좇았음이라";
echo "<br>";
echo "28 이에 저희가 큰 소리로 부르고 그 규례를 따라 피가 흐르기까지 칼과 창으로 그 몸을 상하게 하더라"; 
echo "<br>";
exit();
}
?>
<link rel="stylesheet" type="text/css" href="./lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./lib/css/stdtheme.css" media="all" />
<script src="./lib/js/jquery-1.10.1.min.js"></script>

<script>	

function set_modify()
{
	var param=$("#westminster").serialize();
	$.ajax({
		url:"./set_modify.php",
		data:param,
		dataType:"json",
		type:"POST",
		success:function(data){
			if(data.success){
				if(confirm("수정되었습니다. 뷰 페이지로 이동하시겠습니까?"))
				location.href='./view.php?eh_no='+$("#eh_no").val();
			}
		}
		});
}
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
</script>
<style>
textarea{margin: 0px; width: 337px; height: 239px;padding: 15px;line-height: 1.5em;
    border-radius: 25px;}
</style>
<?php
include "./db_con.php";
include_once "./subject.php";
function get_numeric($str)
{
	return  preg_replace("/[^0-9]*/s", "", $str); ;
}

$sql=sprintf("select eh_no from `ez_holynote` where eh_no<'%s' order by eh_no desc limit 1;",$eh_no);

$query=$mysqli->query($sql);
$pre=$query->fetch_assoc();
$sql=sprintf("select eh_no from `ez_holynote` where eh_no>'%s' limit 1;",$eh_no);

$query=$mysqli->query($sql);
$ord=$query->fetch_assoc();
if($pre)
{
    printf("<a href='./modify.php?eh_no=%s' class='btn btn_primary'>이전</a>",$pre['eh_no']);
}else{  
    echo "<a class='btn btn_danger'>이전이 없습니다.</a>";
}

if($ord)
{
    printf("<a href='./modify.php?eh_no=%s' class='btn btn_primary'>다음</a>",$ord['eh_no']);
}else{  
    echo "<a class='btn btn_danger'>다음이 없습니다.</a>";
}


$sql=sprintf("select * from `ez_holynote` where eh_no='%s';",$eh_no);
$query=$mysqli->query($sql);
$view=$query->fetch_assoc();

//print_r($view);
echo "<form id='westminster'>";
echo sprintf("<input type='hidden' name='eh_no' id='eh_no' value='%s'>",$view['eh_no']);
echo "<input type='hidden' name='table' value='ez_holynote'>";
echo '<table class="ibk_info">';
echo '<tr>';
echo '<th>보드번호</th><th>';
echo $view['eh_no'];
echo '</th></tr>';	
echo '<tr>';
echo '<td>장</td><td>';
echo "<select name='eh_chapter'>";
foreach($SUBJECT['ko'] as $key =>$value)
{
	if($view['eh_chapter']==get_numeric($key)){
	printf("<option value='%s' selected>%s %s</option>",get_numeric($key),$key,$value);
	}else{
	printf("<option value='%s'>%s %s</option>",get_numeric($key),$key,$value);
	}
}
echo "</select>";
echo '</th></tr>';	
echo '<tr>';
echo '<td>장제목 [한글]</td><td>';
echo $SUBJECT['ko']["제".$view['eh_chapter']."장"];
echo '</th></tr>';	
echo '<tr>';
echo '<td>장제목 [영문]</td><td>';
echo $SUBJECT['en']["제".$view['eh_chapter']."장"];

echo '</th></tr>';	
echo '<tr>';
echo '<td>항</td><td>';
echo sprintf("<input type='text' name='eh_clause' value='%s'>",$view['eh_clause']);
echo '항</th></tr>';	
echo '<tr>';
echo '<td>제목</td><td>';
echo sprintf("<input type='text' name='eh_subject' value='%s'>",$view['eh_subject']);
echo '</th></tr>';	
echo '<tr>';
echo '<td>내용</td><td>';
echo sprintf("<textarea name='eh_content' cols='30' rows='10' style='width:100%%;line-height:2em;'>%s</textarea>",$view['eh_content']);
echo '</th></tr>';	

echo '<td>내용 (영문)</td><td>';
echo sprintf("<textarea name='eh_content_eng' cols='30' rows='10' style='width:100%%;line-height:2em;'>%s</textarea>",$view['eh_content_eng']);
echo '</th></tr>';	

echo '<tr>';
echo '<td>해설</td><td>';
echo sprintf("<textarea name='eh_commentary' cols='30' rows='10' style='width:100%%;line-height:2em'>%s</textarea>",$view['eh_commentary']);
echo '</th></tr>';	

echo '<tr>';
echo '<td>해설 (영문)</td><td>';
echo sprintf("<textarea name='eh_commentary_eng' cols='30' rows='10' style='width:100%%;line-height:2em'>%s</textarea>",$view['eh_commentary_eng']);
echo '</th></tr>';	

echo '<tr>';
echo '<td>관련구절</td><td>';
echo sprintf("<textarea name='eh_relparse' cols='30' rows='10' style='width:100%%;line-height:2em'>%s</textarea>",$view['eh_relparse']);
echo "</td></tr>";

echo '<tr>';
echo '<td>관련구절 (영문)</td><td>';
echo sprintf("<textarea name='eh_relparse_eng' cols='30' rows='10' style='width:100%%;line-height:2em'>%s</textarea>",$view['eh_relparse_eng']);
echo "</td></tr></table>";

echo "<input type='button' value='수정' onclick='set_modify();'>";

echo "<input type='button' value='리스트' onclick=\"location.href='./list.php'\">";