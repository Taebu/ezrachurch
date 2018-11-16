<?php
function read_all_files($root = '.'){ 
  $files  = array('files'=>array(), 'dirs'=>array()); 
  $directories  = array(); 
  $last_letter  = $root[strlen($root)-1]; 
  $root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR; 

  $directories[]  = $root; 
  
		$files['dirs'][]=$root[1];
		$files['dirs'][]=$dir;
  while (sizeof($directories)) { 
    $dir  = array_pop($directories); 
    if ($handle = opendir($dir)) { 
      while (false !== ($file = readdir($handle))) { 
        if ($file == '.' || $file == '..') { 
          continue; 
        } 
        $file  = $dir.$file; 
        if (is_dir($file)) { 
          $directory_path = $file.DIRECTORY_SEPARATOR; 
          array_push($directories, $directory_path); 
          $files['dirs'][]  = $directory_path; 
        } elseif (is_file($file)) {
        $pos = strrpos($file, ".mp3");

		if ($pos === false) { // note: three equal signs
		    // not found...
		}else{
//		$file=preg_replace('/\.\//','',$file); 	
		    $files['files'][]  = $file; 
		}
          
        } 
      } 
      closedir($handle); 
    } 
  } 
  
  return $files; 
} 

extract($_REQUEST);
if($dirs==""){
echo "<a href='?dirs=lecture_01'>lecture_01 갱신</a>";
echo "<br>";
echo "<a href='?dirs=lecture_02'>lecture_02 갱신</a>";
echo "<br>";
echo "<a href='?dirs=edu_02'>edu_02 갱신</a>";
return;
}


//$dirs="lecture_01";
//mount --bind /volume1/ezra/02.\ 주일\ 설교/2.\ [음성]\ 담임목회자\ \(남궁현우\ 목사\)/ /volume1/web/wp/youtube/pastor_mp3
shell_exec("mount --bind /volume1/ezra/02.\ 주일\ 설교/2.\ [음성]\ 담임목회자\ \(남궁현우\ 목사\)/ /volume1/web/wp/theme/modificate/youtube/lecture_01");
shell_exec("mount --bind /volume1/ezra/02.\ 주일\ 설교/4.\ [음성]\ 외부강사/ /volume1/web/wp/theme/modificate/youtube/lecture_02");
shell_exec("un_lec02.sh");
//mount --bind /volume1/ezra/02.\ 주일\ 설교/4.\ [음성]\ 외부강사/ /volume1/web/wp/theme/modificate/youtube/lecture_02

shell_exec("[ezra@.156]$ mount --bind /volume1/ezra/03.\ 새가족\ 교육/2.\ \[음성\]\ 새가족\ 교육/  /volume1/web/wp/theme/modificate/youtube/edu_02");
shell_exec("mount --bind /volume1/ezra/02.\ 주일\ 설교/4.\ [음성]\ 외부강사/ /volume1/web/wp/theme/modificate/youtube/edu_03");
echo $dirs;
///volume1/ezra/02. 주일 설교/2. [음성] 담임목회자 (남궁현우 목사)/170403(주일오전) - 환상(VISION)을 간직하라(남궁현우 목사) 다니엘 8장 1~4절, 26~27절.mp3
//echo "/volume1/ezra/02. 주일 설교/2. [음성] 담임목회자 (남궁현우 목사)/";
$mp3=read_all_files($dirs);
/*

ezrachurch.kr/:281 
2017년 4월 16일 주일 오전 - 인봉을 개봉할 자 (마태복음 27장 66절)
ezrachurch.kr/:281 2017년 4월 9일 주일 오후 - 그리스도의 수난 (요한복음 19장 15절)
ezrachurch.kr/:281 2017년 4월 9일 주일 오전 - 왕의 입성 (요한복음 12장 12~13절)
ezrachurch.kr/:281 2017년 4월 2일 주일 오전 - 환상(VISION)을 간직하라 (다니엘 8장 1~4절, 26~27절)
2017년 4월 2일 주일 오전 - 환상(VISION)을 간직하라 (다니엘 8장 1~4절, 26~27절)
170403(주일오전) - 환상(VISION)을 간직하라(남궁현우 목사) 다니엘 8장 1~4절, 26~27절 

*/

$json=array();
foreach($mp3['files'] as $k =>$v)
{
	//echo "{$k} => {$v} ";
	echo "<br>filename : ";
	echo basename($v, ".mp3").PHP_EOL;
	//	echo "<a href='{$v}' target='_blank'>{$v}</a>";
	$json[]=basename($v, ".mp3");
	//	echo '<audio src="'.$v.'" controls loop></audio>';
	//	echo "<br>";
}

unlink($dirs.".js");
$myfile=fopen($dirs.".js","w") or die("Unable to open file!");
$json_str="var ".$dirs."=['".join("','",$json)."'];";
fwrite($myfile,$json_str);
fclose($myfile);

?>