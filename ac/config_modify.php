<?php
include_once "./db_con.php";
include_once "./subject.php";
include_once($_SERVER['DOCUMENT_ROOT'].'/wp/common.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/ac/commons.php');
$year= isset($_GET['year'])?$_GET['year']:date("Y");
?>
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<script src="/wp/js/jquery-1.8.3.min.js"></script>
  <link rel="stylesheet" href="/wp/css/jquery.ui.min.css">  
  <script src="/wp/js/jquery.ui.min.js"></script>

<script>	
function set_modify()
     var formData = $("#westminster").serialize();

		$.ajax({
			url:"./set_configmodify.php",
			dataType:"json",
			type:"POST",
            data:formData,
            success:function(data){
				if(data.success){
				alert("수정되었습니다.");
				location.href='/ac/config_modify.php';
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
    $("[id^=ac_1],[id^=ac_2],[id^=ac_3],[id^=ac_4]").datepicker(dateoption);
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
    var param = {'table':'account_config','mode':'quarter_config','ac_year':'2024'};
    $.ajax({
        url:"./set_modify.php",
        dataType:"json",
        type:"POST",
        data:param,
        success:function(data){
            if(data.success)
            {
                alert("삭제성공");
            }
        }
    });    
}
</script>
<style>
textarea{margin: 0px; width: 337px; height: 239px;padding: 15px;line-height: 1.5em;
    border-radius: 25px;}
	input{width: 45%;}
</style>
<?php
function get_numeric($str)
{
	return  preg_replace("/[^0-9]*/s", "", $str); ;
}


echo "<form id='westminster' enctype='multipart/form-data'>";
echo sprintf("<input type='hidden' name='ac_year' id='ac_year' value='%s'>",$ac_config['ac_year']);
echo "<input type='hidden' name='table' value='account_config'>";
echo "<input type='hidden' name='mode' value='modify'>";
echo '<table class="ibk_info">';
echo '<tr>';
echo '<td>년도</td><td>';
echo $ac_config['ac_year'];
echo '</td></tr>';	
echo '<tr>';
echo '<td>1quarter</td><td>';
printf("<input type='text' name='ac_1quarter_start' id='ac_1quarter_start' value='%s'>",$ac_config['ac_1quarter_start']);
print(" ~ ");
printf("<input type='text' name='ac_1quarter_end' id='ac_1quarter_end' value='%s'>",$ac_config['ac_1quarter_end']);
echo '</th></tr>';	
echo '<tr>';
echo '<td>2quarter</td><td>';
printf("<input type='text' name='ac_2quarter_start' id='ac_2quarter_start' value='%s'>",$ac_config['ac_2quarter_start']);
print(" ~ ");
printf("<input type='text' name='ac_2quarter_end' id='ac_2quarter_end' value='%s'>",$ac_config['ac_2quarter_end']);
echo '</th></tr>';	
echo '<tr>';
echo '<td>3quarter</td><td>';
printf("<input type='text' name='ac_3quarter_start' id='ac_3quarter_start' value='%s'>",$ac_config['ac_3quarter_start']);
print(" ~ ");
printf("<input type='text' name='ac_3quarter_end' id='ac_3quarter_end' value='%s'>",$ac_config['ac_3quarter_end']);
echo '</th></tr>';	
echo '<tr>';
echo '<td>4quarter</td><td>';
printf("<input type='text' name='ac_4quarter_start' id='ac_4quarter_start' value='%s'>",$ac_config['ac_4quarter_start']);
print(" ~ ");
printf("<input type='text' name='ac_4quarter_end' id='ac_4quarter_end' value='%s'>",$ac_config['ac_4quarter_end']);
echo '</th></tr>';	

echo "</table>";

echo "<input type='button' value='수정' onclick='set_modify();'>";

echo "<input type='button' value='리스트' onclick=\"location.href='./list.php'\">";