<?php
$target = "./torrent/";
$files=json_decode($_POST['files'],true);

echo "<table>";
echo "<tr><td>제목</td><td>작업</td></tr>";
foreach ($files as $f) { // 파일명 출력
	$file = file_get_contents($target.$f['name'], true);
	$title=$f['name'];
	$title = str_replace(".txt", "", $title);
//	$new_text = preg_replace('/\r\n\r\n/', '<br>', $file);
//	$new_text= rtrim(nl2br($new_text),'<br>');
	$array_contents = explode("\n",$file);

	foreach($array_contents  as $key => $value)
	{
		if($key%2==0)
		{
			echo "<tr><td>";
			echo $title;
			echo "</td>";
			echo "<td>";
			echo $value;
			echo "";
		}else{
			echo $value;
			echo "</td>";
			echo "</tr>";
		}
		
	}
//	printf("update newezra.new_hymn set nh_contents='%s' where nh_number='%s';",$new_text,intval(str_replace(".txt", "", $f)));
//    echo "<br />";
}
echo "</table>";
