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
$dirs="/volume1/web/wp/youtube/pastor_mp3";
//mount --bind /volume1/ezra/02.\ 주일\ 설교/2.\ [음성]\ 담임목회자\ \(남궁현우\ 목사\)/ /volume1/web/wp/youtube/pastor_mp3
//exec("mount --rbind /volume2/SeoulEzraDATA/서울에스라교회주일촬영원본데이터/ /volume1/web/wp/youtube/pastor_mp3");
// umount -l /volume1/web/wp/youtube/pastor_mp3
echo $dirs;
///volume1/ezra/02. 주일 설교/2. [음성] 담임목회자 (남궁현우 목사)/170403(주일오전) - 환상(VISION)을 간직하라(남궁현우 목사) 다니엘 8장 1~4절, 26~27절.mp3
//echo "/volume1/ezra/02. 주일 설교/2. [음성] 담임목회자 (남궁현우 목사)/";
$mp3=read_all_files($dirs);
/*
/volume1/web/wp/youtube/pastor_mp3/170827/20170827151800.mp3
ezrachurch.kr/:281 
admin@ezrachurch.kr:mp42mp3.sh
2017년 4월 16일 주일 오전 - 인봉을 개봉할 자 (마태복음 27장 66절)
ezrachurch.kr/:281 2017년 4월 9일 주일 오후 - 그리스도의 수난 (요한복음 19장 15절)
ezrachurch.kr/:281 2017년 4월 9일 주일 오전 - 왕의 입성 (요한복음 12장 12~13절)
ezrachurch.kr/:281 2017년 4월 2일 주일 오전 - 환상(VISION)을 간직하라 (다니엘 8장 1~4절, 26~27절)
2017년 4월 2일 주일 오전 - 환상(VISION)을 간직하라 (다니엘 8장 1~4절, 26~27절)
170403(주일오전) - 환상(VISION)을 간직하라(남궁현우 목사) 다니엘 8장 1~4절, 26~27절 
mount --bind /volume2/(남궁현우\ 목사\)/ /volume1/web/wp/youtube/pastor_mp3
*/

$json=array();
foreach($mp3['files'] as $k =>$v)
{
	//echo "{$k} => {$v} ";
	echo "<br>filename : ";
	echo basename($v, ".mp3").PHP_EOL;
//	echo "<a href='{$v}' target='_blank'>{$v}</a>";
	$json[]=basename($v, ".mp3");
//echo '<audio src="'.$v.'" controls loop></audio>';
	echo "<br>";
}

$myfile=fopen("pastor.js","w") or die("Unable to open file!");
$json_str="var pastor=['".join("','",$json)."'];";
fwrite($myfile,$json_str);
fclose($myfile);

?>



