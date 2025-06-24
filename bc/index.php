<!DOCTYPE html>
<html>

<head>
<style>
	p{font-size: -webkit-xxx-large;}
</style>
<?php include_once "./chapter_info.php";?>
	<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all">
</head>
<body>
<h1>Bible Chapter</h1>
<h2><?php print($array[$c]);?></h2>
<p id="demo"></p>
<p id="comment"></p>
<script>
let text = "";

document.getElementById("demo").innerHTML = text;
 
function myFunction(item, index) {
	}
function test() {
	var sum_j = 3;
	var table_size = 10;
	var table_temp = [];
	for(var k=0;k<Math.ceil(bible_chapter.length/10);k++)
	{
		table_temp.push("<table class='reference'>");
		table_temp.push("<colgroup>");
		table_temp.push("<col width='25%'>");
		table_temp.push("<col width='25%'>");
		table_temp.push("<col width='25%'>");
		table_temp.push("<col width='25%'>");
		table_temp.push("</colgroup>");
		for (var i=0;i<3 ;i++ )
		{
			table_temp.push("<tr>");
			for (var j=k*10;j<11+k*10 ;j=j+3 )
			{
				table_temp.push("<td>");
				if(i+j<10+k*10)
				{
					table_temp.push(bible_chapter[i+j]);
				}
				table_temp.push("</td>");
			}
			table_temp.push("</tr>");
		}
		table_temp.push("</table>");
	}

	document.getElementById("demo").innerHTML = table_temp.join("");
	if(comment){

	document.getElementById("comment").innerHTML = comment.join("<br>");
	}
}

test();
</script>
<?php
if($c=="0")
{
	for($i=1;$i<count($array);$i++)
	{
		printf("<a href='/bc/%s'>%s</a><br>",$i,$array[$i]);
	}
}
?>
</body>
</html>
