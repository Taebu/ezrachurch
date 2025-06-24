<?php
$dir = "./torrent/";
$target = $dir;
$f=$_POST['name'];


$file = file_get_contents($target.$f, true);

$new_text = preg_replace('/\r\n\r\n/', '<br>', $file);
$new_text= rtrim(nl2br($new_text),'<br>');
echo $new_text;
