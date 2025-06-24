<?php

header("Content-Type:text/html;charset=utf-8");
exec("dir ", $output); 
$object=array();
while(list($key, $val) = each($output)) { 
//    echo $key . "=". $val."<br>"; 
$val=nl2br($val)."<br>";
		$object[]=$val; 
}

echo join("",$object);

exec("java -version", $output); 
$object=array();
while(list($key, $val) = each($output)) { 
//    echo $key . "=". $val."<br>"; 
$val=nl2br($val);
		$object[]=$val; 
}

echo join("",$object);