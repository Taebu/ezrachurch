<?php
$arrow_ip = array();
$arrow_ip[] = "14.5.85.81";
$arrow_ip[] = "218.154.47.11";
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
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/super-build/ckeditor.js"></script>

<link rel="stylesheet" type="text/css" href="./lib/css/main.css?d=20241017" media="all" />
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
				location.href='./view.php?wm_no='+$("#wm_no").val();
			}
		}
		});
}
</script>
<script>
function myFunction() {
  var x = document.getElementById("wm_content").value;
  x = x.replace(/(?:\r\n|\r|\n)/g, '<br />');
  document.getElementById("output").srcdoc  = "<!doctype html> <html><link rel='stylesheet' type='text/css' href='./lib/css/main.css?d=20240930' media='all' /><div  class='westminster_blacktheme' style='font-size:32px;line-height: 1.3;  padding: 5px;'>" + x + "</div></html>";
}


function myFunction2() {
  var x = document.getElementById("wm_relparse").value;
  x = x.replace(/(?:\r\n|\r|\n)/g, '<br />');
  console.log(x);

  document.getElementById("output2").srcdoc  = "<!doctype html> <html><link rel='stylesheet' type='text/css' href='./lib/css/main.css?d=20240930' media='all' /><div  class='westminster_blacktheme' style='font-size:32px;line-height: 1.3;  padding: 5px;'>" + x + "</div></html>";
}
function font_color_change(color)
{
// code for Mozilla
 
  var textarea = document.getElementById("wm_content");
 
  var len = textarea.value.length;
   var start = textarea.selectionStart;
   var end = textarea.selectionEnd;
   var sel = textarea.value.substring(start, end);
 
   // This is the selected text and alert it
   //alert(sel);
 
  var replace = '<span class="'+color+'">' + sel + '</span>';
 
  // Here we are replacing the selected text with this one
 textarea.value =  textarea.value.substring(0,start) + replace + textarea.value.substring(end,len);
 myFunction();
}

function font_color_change2(color)
{
// code for Mozilla
 
  var textarea = document.getElementById("wm_relparse");
 
  var len = textarea.value.length;
   var start = textarea.selectionStart;
   var end = textarea.selectionEnd;
   var sel = textarea.value.substring(start, end);
 
   // This is the selected text and alert it
   //alert(sel);
 
  var replace = '<span class="'+color+'">' + sel + '</span>';
 
  // Here we are replacing the selected text with this one
 textarea.value =  textarea.value.substring(0,start) + replace + textarea.value.substring(end,len);
 myFunction2();
}
document.addEventListener("DOMContentLoaded", function(){
 // Handler when the DOM is fully loaded
 myFunction();
});
// 출처: https://euntori7.tistory.com/356 [@euntori world!:티스토리]

</script>
<style>
  .ck-editor__editable[role="textbox"] {
    min-height: 300px;
  }

  .ck-content .image {
    max-width: 80%;
    margin: 20px auto;
  }
</style>
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

$sql=sprintf("select wm_no from `westminster_confession` where wm_no<'%s' order by wm_no desc limit 1;",$wm_no);

$query=$mysqli->query($sql);
$pre=$query->fetch_assoc();
$sql=sprintf("select wm_no from `westminster_confession` where wm_no>'%s' limit 1;",$wm_no);

$query=$mysqli->query($sql);
$ord=$query->fetch_assoc();
if($pre)
{
    printf("<a href='./modify.php?wm_no=%s' class='btn btn_primary'>이전</a>",$pre['wm_no']);
}else{  
    echo "<a class='btn btn_danger'>이전이 없습니다.</a>";
}

if($ord)
{
    printf("<a href='./modify.php?wm_no=%s' class='btn btn_primary'>다음</a>",$ord['wm_no']);
}else{  
    echo "<a class='btn btn_danger'>다음이 없습니다.</a>";
}


$sql=sprintf("select * from `westminster_confession` where wm_no='%s';",$wm_no);
$query=$mysqli->query($sql);
$view=$query->fetch_assoc();

echo "<form id='westminster'>";
echo sprintf("<input type='hidden' name='wm_no' id='wm_no' value='%s'>",$view['wm_no']);
echo "<input type='hidden' name='table' value='westminster_confession'>";
echo '<table class="ibk_info">';
echo '<tr>';
echo '<th>보드번호</th><th>';
echo $view['wm_no'];
echo '</th></tr>';	
echo '<tr>';
echo '<td>장</td><td>';
echo "<select name='wm_chapter'>";
foreach($SUBJECT['ko'] as $key =>$value)
{
	if($view['wm_chapter']==get_numeric($key)){
	printf("<option value='%s' selected>%s %s</option>",get_numeric($key),$key,$value);
	}else{
	printf("<option value='%s'>%s %s</option>",get_numeric($key),$key,$value);
	}
}
echo "</select>";
echo '</th></tr>';	
echo '<tr>';
echo '<td>장제목 [한글]</td><td>';
echo $SUBJECT['ko']["제".$view['wm_chapter']."장"];
echo '</th></tr>';	
echo '<tr>';
echo '<td>장제목 [영문]</td><td>';
echo $SUBJECT['en']["제".$view['wm_chapter']."장"];

echo '</th></tr>';	
echo '<tr>';
echo '<td>항</td><td>';
echo sprintf("<input type='text' name='wm_clause' value='%s'>",$view['wm_clause']);
echo '항</th></tr>';	
echo '<tr>';
echo '<td>제목</td><td>';
echo sprintf("<input type='text' name='wm_subject' value='%s'>",$view['wm_subject']);
echo '</th></tr>';	
echo '<tr>';
echo '<td>내용</td><td>';
echo '<input type="button" class="btn btn_pi" value="pi:pink" onclick="javascript:font_color_change(\'pi\');">';
echo '<input type="button" class="btn btn_gr" value="gr:green" onclick="javascript:font_color_change(\'gr\');">';
echo '<input type="button" class="btn btn_ga" value="ga:gray" onclick="javascript:font_color_change(\'ga\');">';
echo '<input type="button" class="btn btn_red" value="red" onclick="javascript:font_color_change(\'red\');">';
echo '<input type="button" class="btn btn_bl" value="bl:blue" onclick="javascript:font_color_change(\'bl\');">';
echo '<input type="button" class="btn btn_darkblue" value="darkblue" onclick="javascript:font_color_change(\'db\');">';
echo '<input type="button" class="btn btn_ye" value="ye:yellow" onclick="javascript:font_color_change(\'ye\');">';
echo '<input type="button" class="btn btn_yg" value="yg:yellowgreen" onclick="javascript:font_color_change(\'yg\');">';
echo '<input type="button" class="btn btn_sb" value="sb:skyblue" onclick="javascript:font_color_change(\'sb\');">';
echo '<input type="button" class="btn btn_or" value="or:orange" onclick="javascript:font_color_change(\'or\');">';
echo '<input type="button" class="btn btn_bi" value="bi:bisque" onclick="javascript:font_color_change(\'bi\');">';
echo '<input type="button" class="btn btn_pu" value="pu:purple" onclick="javascript:font_color_change(\'pu\');">';
echo '<input type="button" class="btn btn_lsg" value="lsg:lightseagreen" onclick="javascript:font_color_change(\'lsg\');">';
echo '<input type="button" class="btn btn_mediumpurple" value="mediumpurple" onclick="javascript:font_color_change(\'mediumpurple\');">';
echo '<input type="button" class="btn btn_hp" value="hp:hotpink" onclick="javascript:font_color_change(\'hp\');">';
echo '<input type="button" class="btn btn_dy" value="dy:darkyellow" onclick="javascript:font_color_change(\'dy\');">';
echo '<input type="button" class="btn btn_dm" value="dm:darkmagenta" onclick="javascript:font_color_change(\'dm\');">';
echo '<input type="button" class="btn btn_kk" value="kk:kaki" onclick="javascript:font_color_change(\'kk\');">';
echo '<input type="button" class="btn btn_lc" value="lc:lightcoral" onclick="javascript:font_color_change(\'lc\');">';
echo '<input type="button" class="btn btn_ls" value="ls:lightsalmon" onclick="javascript:font_color_change(\'ls\');">';
echo '<input type="button" class="btn btn_black" value="black" onclick="javascript:font_color_change(\'black\');">';
echo '<input type="button" class="btn btn_dmo" value="dmo:darkmoderateorange" onclick="javascript:font_color_change(\'dmo\');">';
echo '<input type="button" class="btn btn_ldy" value="ldy:lightdarkenyellow" onclick="javascript:font_color_change(\'ldy\');">';
/*
.btn_sb,.btn_skyblue{background: skyblue;}
.btn_or,.btn_orange{background: orange;;cursor:pointer}
.btn_bi,.btn_bisque{background: bisque;;cursor:pointer}
.btn_pu,.btn_pp,.btn_purple{background: mediumpurple;cursor:pointer}
.btn_lsg,.btn_lightseagreen{background: lightseagreen;cursor:pointer}
.btn_dgr,.btn_darkgoldenrod{background: darkgoldenrod;cursor:pointer}
.btn_mediumpurple{background:mediumpurple;;cursor:pointer}
.btn_hp,.btn_hotpink{background:rgb(241,0,182);}
.btn_dy,.btn_darkyellow{background:rgb(244,206,31);}
.btn_kk,.btn_kaki{background: rgb(59,174,169);}
.btn_lo,.btn_lightorange,.btn_lightcoral,.btn_lc{background:lightcoral;}
.btn_ls,.btn_lightsalmon{background:lightsalmon;}
.btn_black{background: black;color: white;padding: 5px;margin: 2px;}
*/

echo sprintf("<textarea name='wm_content' id='wm_content' cols='30' rows='10' style='width:100%%;line-height:2em;' onkeyup='myFunction()'>%s</textarea>",$view['wm_content']);
echo '<iframe id="output" srcdoc="" style="width:-webkit-fill-available;height:500px"></iframe>';
echo '</th></tr>';	

echo '<td>내용 (영문)</td><td>';
echo sprintf("<textarea name='wm_content_eng' cols='30' rows='10' style='width:100%%;line-height:2em;'>%s</textarea>",$view['wm_content_eng']);
echo '<div id="editor"></div>';
echo '</th></tr>';	

echo '<tr>';
echo '<td>해설</td><td>';
echo sprintf("<textarea name='wm_commentary' cols='30' rows='10' style='width:100%%;line-height:2em'>%s</textarea>",$view['wm_commentary']);
echo '</th></tr>';	

echo '<tr>';
echo '<td>해설 (영문)</td><td>';
echo sprintf("<textarea name='wm_commentary_eng' cols='30' rows='10' style='width:100%%;line-height:2em'>%s</textarea>",$view['wm_commentary_eng']);
echo '</th></tr>';	

echo '<tr>';
echo '<td>관련구절</td><td>';
echo '<input type="button" class="btn btn_pi" value="pi:pink" onclick="javascript:font_color_change2(\'pi\');">';
echo '<input type="button" class="btn btn_gr" value="gr:green" onclick="javascript:font_color_change2(\'gr\');">';
echo '<input type="button" class="btn btn_ga" value="ga:gray" onclick="javascript:font_color_change2(\'ga\');">';
echo '<input type="button" class="btn btn_red" value="red" onclick="javascript:font_color_change2(\'red\');">';
echo '<input type="button" class="btn btn_bl" value="bl:blue" onclick="javascript:font_color_change2(\'bl\');">';
echo '<input type="button" class="btn btn_darkblue" value="darkblue" onclick="javascript:font_color_change2(\'db\');">';
echo '<input type="button" class="btn btn_ye" value="ye:yellow" onclick="javascript:font_color_change2(\'ye\');">';
echo '<input type="button" class="btn btn_yg" value="yg:yellowgreen" onclick="javascript:font_color_change2(\'yg\');">';
echo '<input type="button" class="btn btn_sb" value="sb:skyblue" onclick="javascript:font_color_change2(\'sb\');">';
echo '<input type="button" class="btn btn_or" value="or:orange" onclick="javascript:font_color_change2(\'or\');">';
echo '<input type="button" class="btn btn_bi" value="bi:bisque" onclick="javascript:font_color_change2(\'bi\');">';
echo '<input type="button" class="btn btn_pu" value="pu:purple" onclick="javascript:font_color_change2(\'pu\');">';
echo '<input type="button" class="btn btn_lsg" value="lsg:lightseagreen" onclick="javascript:font_color_change2(\'lsg\');">';
echo '<input type="button" class="btn btn_mediumpurple" value="mediumpurple" onclick="javascript:font_color_change2(\'mediumpurple\');">';
echo '<input type="button" class="btn btn_hp" value="hp:hotpink" onclick="javascript:font_color_change2(\'hp\');">';
echo '<input type="button" class="btn btn_dy" value="dy:darkyellow" onclick="javascript:font_color_change2(\'dy\');">';
echo '<input type="button" class="btn btn_dm" value="dm:darkmagenta" onclick="javascript:font_color_change2(\'dm\');">';
echo '<input type="button" class="btn btn_kk" value="kk:kaki" onclick="javascript:font_color_change2(\'kk\');">';
echo '<input type="button" class="btn btn_lc" value="lc:lightcoral" onclick="javascript:font_color_change2(\'lc\');">';
echo '<input type="button" class="btn btn_ls" value="ls:lightsalmon" onclick="javascript:font_color_change2(\'ls\');">';
echo '<input type="button" class="btn btn_black" value="black" onclick="javascript:font_color_change2(\'black\');">';
echo '<input type="button" class="btn btn_dmo" value="dmo:darkmoderateorange" onclick="javascript:font_color_change2(\'dmo\');">';
echo '<input type="button" class="btn btn_ldy" value="ldy:lightdarkenyellow" onclick="javascript:font_color_change2(\'ldy\');">';

echo sprintf("<textarea name='wm_relparse' id='wm_relparse' cols='30' rows='10' style='width:100%%;line-height:2em' style='width:100%%;line-height:2em;' onkeyup='myFunction2()'>%s</textarea>",$view['wm_relparse']);
echo '<iframe id="output2" srcdoc="" style="width:-webkit-fill-available;height:500px"></iframe>';
echo "</td></tr>";

echo '<tr>';
echo '<td>관련구절 (영문)</td><td>';
echo sprintf("<textarea name='wm_relparse_eng' cols='30' rows='10' style='width:100%%;line-height:2em'>%s</textarea>",$view['wm_relparse_eng']);
echo "</td></tr></table>";

echo "<input type='button' value='수정' onclick='set_modify();'>";

echo "<input type='button' value='리스트' onclick=\"location.href='./list.php'\">";