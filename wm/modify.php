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
				alert("수정되었습니다.");
				location.href='./view.php?wm_no='+$("#wm_no").val();
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
echo sprintf("<textarea name='wm_content' cols='30' rows='10' style='width:100%%;line-height:2em;'>%s</textarea>",$view['wm_content']);
echo '</th></tr>';	

echo '<tr>';
echo '<td>해설</td><td>';
echo sprintf("<textarea name='wm_commentary' cols='30' rows='10' style='width:100%%;line-height:2em'>%s</textarea>",$view['wm_commentary']);
echo '</th></tr>';	

echo '<tr>';
echo '<td>관련구절</td><td>';
echo sprintf("<textarea name='wm_relparse' cols='30' rows='10' style='width:100%%;line-height:2em'>%s</textarea>",$view['wm_relparse']);
echo "</td></tr></table>";

echo "<input type='button' value='수정' onclick='set_modify();'>";

echo "<input type='button' value='리스트' onclick=\"location.href='./list.php'\">";