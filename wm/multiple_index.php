<?php
/*************************************************
* 성경 구절과 웨스터민스터 신앙고백서 강해의 내용을 가져 옵니다.
*
*
*
*
*************************************************/
header("Content-Type:text/html;charset=utf-8");
include_once "./db_con.php";
extract($_GET);
$mode=!empty($_GET['mode'])?$_GET['mode']:"";
$k=!empty($_GET['k'])?$_GET['k']:"";
//echo "<pre>";
//print_r($_SERVER);
//echo "</pre>";

$full_name=array("0","창세기", "출애굽기", "레위기", "민수기", "신명기",
		"여호수아", "사사기", "룻기", "사무엘상", "사무엘하",
		"열왕기상", "열왕기하", "역대상", "역대하", "에스라",
		"느헤미야", "에스더", "욥기", "시편", "잠언",
		"전도서", "아가", "이사야", "예레미야", "예레미야애가",
		"에스겔", "다니엘", "호세아", "요엘", "아모스",
		"오바댜", "요나", "미가", "나훔", "하박국",
		"스바냐", "학개", "스가랴", "말라기", "마태복음",
		"마가복음", "누가복음", "요한복음", "사도행전", "로마서",
		"고린도전서", "고린도후서", "갈라디아서", "에베소서",
		"빌립보서", "골로새서", "데살로니가전서", "데살로니가후서",
		"디모데전서", "디모데후서", "디도서", "빌레몬서",
		"히브리서", "야고보서", "베드로전서", "베드로후서",
		"요한일서", "요한이서", "요한삼서", "유다서", "요한계시록","새교독문","웨스터민스터 신앙고백서");
$chapter=array("0","창", "출", "레", "민", "신", "수", "삿", "룻", "삼상", "삼하", "왕상", "왕하",
			"대상", "대하", "스", "느", "에", "욥", "시", "잠", "전", "아", "사",
			"렘", "애", "겔", "단", "호", "욜", "암", "옵", "욘", "미", "나", "합",
			"습", "학", "슥", "말", "마", "막", "눅", "요", "행", "롬", "고전",
			"고후", "갈", "엡", "빌", "골", "살전", "살후", "딤전", "딤후", "딛", "몬",
			"히", "약", "벧전", "벧후", "요일", "요이", "요삼", "유", "계","교","웨");

function onlyHanAlpha($subject) {

    $pattern = '/([\xEA-\xED][\x80-\xBF]{2})/';
    preg_match_all($pattern, $subject, $match);
    return implode('', $match[0]);
}


function resort_bible($array)
{
	/* 
	1. 변수를 선언합니다.
	":" 로 나눌 데이터를 배열로 선언합니다.
	exp_key는 장제목과 장을 넣습니다.
	exp_key2는 절만 넣습니다.
	*/
	$exp_key=array();
	$exp_key2=array();
	$temp_value=0;

	/* 2. 배열의 갯수 만큼 반복합니다. */
	foreach($array as $key => $value)
	{
		/* 2-1. 값을 ":" 로 나눕니다.  */
		$exp_values=explode(":",$value);
		if(!is_array($exp_values)){
			return;
		}

		/* 2-2.장 제목을 exp_key 배열에 푸시 하여 넣습니다. */
		$exp_key[]=$exp_values[0];

		/* 2-3.절을 exp_key2 배열에 푸시 하여 넣습니다. */
		if(!empty($exp_values[1]))
		$exp_key2[]=$exp_values[1];

		/* 2-4. 이전 절에 1을 더하고 temp_value에 검사 값을 구한다. */
		if(!empty($exp_key2[$key-1]))
		{
			(int)$temp_value=(int)$exp_key2[$key-1]+1;
		}
		/* 2-5. temp_value와 현재 절($exp_key2[key])과 일치 하는 여부를 is_oneplus에 참/거짓을 구한다.*/
		if(!empty($exp_key2[$key]))
		{
			$is_oneplus=$temp_value==$exp_key2[$key];
		}
		/* 2-6. is_keymatch 이전 책제목과 장제목 이 현제 책제목과 장제목이 일치하는 참/거짓을 구한다. */
		if(!empty($exp_key[$key-1]))
		{
		$is_keymatch=$exp_key[$key-1]==$exp_key[$key];
		
		/* 2-7.장제목과 이전 절과 하나 증가한 값으로 절이 일치 한다면 */
		if($is_keymatch&&$is_oneplus)
		{
			/* 2-8. 이전 장제목 절과 이번 절을 합칩니다. */
			$array[$key-1]=$array[$key-1]."-".$exp_key2[$key];
			/* 2-9. 해당키에 있는 배열을 제거 합니다. */
			$array=array_diff_key($array,array($key => ""));
		}
		}
	}
	/* 3. 제거한 배열만큼 재배열한다.*/
	$array=array_values($array);
	
	/* 4. 재정렬된 배열을 반환한다. */
	return $array;

	/* 5. 끝낸다. */
}

function chg_bible_verse($bible_verse)
{
	$bible_verse=str_replace(" ","",$bible_verse);
	$exp_verse=explode(",",$bible_verse);
	

	
	$array_hangle=array();
	$j=0;
	for($i=0;$i<count($exp_verse);$i++)
	{
		$pattern = '/([\xEA-\xED][\x80-\xBF]{2})/';
		$is_hangle=preg_match($pattern, $exp_verse[$i]);
		$is_colon=preg_match("/:/", $exp_verse[$i]);
		
		if($is_hangle){
			$array_hangle[]="1";

		}else if($is_hangle&&$is_colon) 
		{
		}
		else if($is_colon)
		{
		 $exp_verse[$i]=onlyHanAlpha($exp_verse[$i-1]).$exp_verse[$i];
		 /*
		 print_r($exp_verse);
		 echo "onlyHanAlpha : ".onlyHanAlpha($exp_verse[$i-1]);
		 echo "<br>";
		 */
		}else if(!$is_hangle&&!$is_colon){

			$aj=$i-1;
		if(isset($exp_verse[$aj]))
		 $end_position=strpos($exp_verse[$aj],":");
		if(isset($exp_verse[$aj]))
		 $exp_verse[$i]=substr($exp_verse[$aj], 0, $end_position).":".$exp_verse[$i]; 
		 $array_hangle[]="3";
		}
	}

	$exp_verse=resort_bible($exp_verse);
	return $exp_verse;
}

function get_bible($k,$version="")
{
	$object=array();
	$kkk=chg_bible_verse($k);
	foreach($kkk as $keyword)
	{
	exec("java -cp 'sqlite-jdbc-3.16.1.jar' Program ".$version.$keyword.$option, $output); 
	
		while(list($key, $val) = each($output)) { 
		//    echo $key . "=". $val."<br>"; 
		$val=nl2br($val);
				$object[]=$val; 
		}
	}
	return join("",$object);
}
$is_bigverse=false;
/*
{
  "q" : "쥐",
  "rq" : "쥐",
  "items" : [ "kuke|쥐|", "kuke|쥐다|", "kuke|쥘대|", "kuke|쥐덫|", "kuke|쥐치|", "kuke|쥐약|", "kuke|쥐뿔|", "kuke|쥐색|", "kuke|쥐꼬리|", "kuke|쥐구멍|", "kuke|쥐라기|", "kuke|쥐새끼|", "kuke|쥐잡듯|", "kuke|쥐정신|", "kuke|쥘부채|", "kuke|쥐어주다|", "kuke|쥐어짜다|", "kuke|쥐죽은듯|", "kuke|쥐어뜯다|", "kuke|쥐 나다|" ],
  "r_items" : [ ]
}
*/

if($mode=="json")
{

function my_json_encode($arr)
{
//convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). So such characters are being "hidden" from normal json_encoding
array_walk_recursive($arr, function (&$item, $key) { if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); });
return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');

}

//출처: http://ekfqkqhd.tistory.com/entry/PHP-jsonencode-한글깨짐 [시우아빠님의 블로그]
header('Content-Type: application/json'); 
	$json=array();
	$json['q']=$k;
	
	$json['items']=array();
	$json['items'][]="kuke|".$k."|개역한글";
	$json['items'][]="kuke|kh".$k."|현대어";
	$json['items'][]="kuke|kn".$k."|새번역";
	$json['items'][]="kuke|ke".$k."|쉬운성경";
	$json['items'][]="kuke|ko".$k."|개역한글국한문";
	$json['items'][]="kuke|kk".$k."|킹제임스흠정역";
	$json['items'][]="kuke|ek".$k."|킹제임스영문";
	$json['items'][]="kuke|en".$k."|뉴킹제임스영문";
	$json['items'][]="kuke|hb".$k."|히브리어";
	$json['items'][]="kuke|gr".$k."|그리스어";

	$json['r_items']=array();

	echo json_encode($json);

//echo json_encode(iconv("CP949","UTF-8",$json));

//출처: http://ekfqkqhd.tistory.com/entry/PHP-jsonencode-한글깨짐 [시우아빠님의 블로그]

}else{
header("Content-Type: text/html; charset=UTF-8");
$k=urldecode($k);




?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
<style type="text/css">
/*
body{padding:15px;margin:5px;line-height:2;
background-color: #000;color:wheat;
}
.section{
border-radius:15px;
background-color: #000;
color: #fff;
padding:20px;
}
*/
</style>
<?php
if(isset($k)){
?>
  <title>"<?php echo $k;?>" 검색결과</title>
<?php
}else{
?>
  <title>개역개정 | 교독문 | 성경찾기</title>
<?php
}

$is_concat_hebrew="";
$checkbox_hebrew="";
if(isset($_GET['hebrew']))
{
$is_concat_hebrew=$_GET['hebrew']=="on";
$checkbox_hebrew=$is_concat_hebrew?"checked":"";

}

?>
 </head>
 <body>

<form action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="checkbox" name="hebrew" id="hebrew" <?php echo $checkbox_hebrew;?>>
<label for="hebrew">히브리어 병행</label>
<br>
<textarea name="k" id="k" cols="30" rows="10"><?php echo $k;?></textarea>
<input type="submit" value="검색" />
</form>

<?php
	if(empty($k)){
	echo "검색할 구절을 기입해 주세요.";
	return;
}
$subject = $k;

$is_bigverse=preg_match("/\./", $k);

if($is_bigverse)
{
	$big_array=explode(".",$k);
	$trim_big_array=array_map('trim',$big_array);
	//	echo "<pre>";
	foreach($trim_big_array as $tba)
	{

		preg_match('/(?<digit>\d+)\)(.+)/', $tba, $matches);;
		echo "<h5>".$matches[1].")".$matches[2].".</h5>";
		echo "<p>";
		$kkk=chg_bible_verse($matches[2]);
	//print_r($kkk);
		foreach($kkk as $keywords)
		{
			///////////////////////
			$subject=$keywords;
//			echo "subject : ".$subject;
			preg_match_all('/([가-힣]+)([0-9]+)\:?([0-9]+)?\-?([0-9]+)?/', $subject, $match_01);
			$match_01 = array_filter($match_01);
			$book_key=array_search($match_01[1][0],$chapter);
			$is_verse=false;
			$is_interval=false;
			$chater_key=$match_01[2][0];
			$first_verse_key=$match_01[3][0];
			$second_verse_key=$match_01[4][0];

			$is_verse=!empty($match_01[3][0]);
			$is_interval=!empty($match_01[4][0]);

			$book=$chapter[$book_key];
			$book=$chapter[$book_key];

			$concat_chapter=$match_01[1][0]=="시"?"편":"장";
			if($is_interval){
				$where=sprintf(" book=%s and chapter=%s and verse>=%s and verse<=%s ",
					$book_key,$chater_key,$first_verse_key,$second_verse_key);
				$keyword=sprintf("%s%s %s절-%s절",$chater_key,$concat_chapter,$first_verse_key,$second_verse_key);
			}else if($is_verse){
				$where=sprintf(" book=%s and chapter=%s and verse=%s",$book_key,$chater_key,$first_verse_key);
				$keyword=sprintf("%s%s %s절",$chater_key,$concat_chapter,$first_verse_key);
			}else{
				$where=sprintf(" book=%s and chapter=%s ",$book_key,$chater_key);
				$keyword=sprintf("%s%s",$chater_key,$concat_chapter);
			}
			//echo $where;
			//echo "<pre>";
			//print_r($match_01);
			//echo "</pre>";
			$version_name="[개역개정]";
			
			$sql="select * from kornkrv where ".$where;
			
			$query=$mysqli->query($sql);
				echo $full_name[$book_key];
				echo "&nbsp;";
				echo $keyword;
				echo $version_name;
				echo "<br>";
			$bible = array();
			$bible['kornkrv']=array();
			while($list=$query->fetch_assoc()){

				
			array_push($bible['kornkrv'],$list);
			}

			///////////////////////
		}
	echo "<br>";
	}

	echo "<pre>";
	print_r($bible);
	echo "</pre>";
}




$exp_keyword=explode(",",$k);

			$bible = array();
			$bible['kornkrv']=array();


$count_verse = 0;
// 첫 번째와 세 번째 문자가 영문 소문자이고, 두 번째 문자가 띄어쓰기인 경우를 검색함.
foreach($exp_keyword as $ek)
{
if(!$is_bigverse){
			$subject=$k;
//			echo "subject : ".$subject;
			preg_match_all('/([가-힣]+)([0-9]+)\:?([0-9]+)?\-?([0-9]+)?/', $subject, $match_01);
			$match_01 = array_filter($match_01);
			$book_key=array_search($match_01[1][0],$chapter);
			$is_verse=false;
			$is_interval=false;
			$chater_key=$match_01[2][0];
			$first_verse_key=$match_01[3][0];
			$second_verse_key=$match_01[4][0];

			$is_verse=!empty($match_01[3][0]);
			$is_interval=!empty($match_01[4][0]);

			$book=$chapter[$book_key];
			$book=$chapter[$book_key];

			$concat_chapter=$match_01[1][0]=="시"?"편":"장";
			if($is_interval){
				$where=sprintf(" book=%s and chapter=%s and verse>=%s and verse<=%s ",
					$book_key,$chater_key,$first_verse_key,$second_verse_key);
				$keyword=sprintf("%s%s %s절-%s절",$chater_key,$concat_chapter,$first_verse_key,$second_verse_key);
			}else if($is_verse){
				$where=sprintf(" book=%s and chapter=%s and verse=%s",$book_key,$chater_key,$first_verse_key);
				$keyword=sprintf("%s%s %s절",$chater_key,$concat_chapter,$first_verse_key);
			}else{
				$where=sprintf(" book=%s and chapter=%s ",$book_key,$chater_key);
				$keyword=sprintf("%s%s",$chater_key,$concat_chapter);
			}
			//echo $where;
			//echo "<pre>";
			//print_r($match_01);
			//echo "</pre>";
			$version_name="[개역개정]";
			$sql="select * from kornkrv where ".$where;
			//echo $sql;
			/* 68 은 웨스터 민스터 신앙고백서 강해 */
			if($book_key=="68")
			{
				$version_name="";
				$sql="select wm_chapter as verse,wm_content as content,wm_relparse,wm_commentary from bible.westminster_confession ";
				$keyword=sprintf("%s%s %s항",$chater_key,$concat_chapter,$first_verse_key);
				$sql.=sprintf(" where wm_chapter='%s' and wm_clause='%s' ",$chater_key,$first_verse_key);

			}
			$query=$mysqli->query($sql);
			echo $full_name[$book_key];
			echo "&nbsp;";
			echo $keyword;
			echo $version_name;
			echo "<br>";

			while($list=$query->fetch_assoc()){


				if($book_key=="68")
				{
					echo $first_verse_key;
					echo "항 ";
					echo $list['content'];
					echo "<br>";
					echo nl2br($list['wm_relparse']);
					echo "<br>";
					echo "<br>";
					if(isset($list['wm_commentary']))
					{
					echo nl2br($list['wm_commentary']);
					}
				}else{
					echo $list['verse'];
					echo " ";
					echo $list['content'];
					echo "<br>";
					$count_verse++;
					array_push($bible['kornkrv'],$list);	

				}
			}

			///////////////////////
		}
	echo "<br>";

			$sql="select * from bible_kjv where ".$where;
			

			$query=$mysqli->query($sql);
			$bible['bible_kjv']=array();
			while($list=$query->fetch_assoc()){ 

					$count_verse++;
					array_push($bible['bible_kjv'],$list);

			}

$is_hebrew=$is_concat_hebrew;
if($is_hebrew)
{
			if($is_interval){
				$where=sprintf(" c4book_no=%s and c5chapter_no=%s and c6verse_no>=%s and c6verse_no<=%s ",
					$book_key,$chater_key,$first_verse_key,$second_verse_key);
				$keyword=sprintf("%s%s %s절-%s절",$chater_key,$concat_chapter,$first_verse_key,$second_verse_key);
			}else if($is_verse){
				$where=sprintf(" c4book_no=%s and c5chapter_no=%s and c6verse_no=%s",$book_key,$chater_key,$first_verse_key);
				$keyword=sprintf("%s%s %s절",$chater_key,$concat_chapter,$first_verse_key);
			}else{
				$where=sprintf(" c4book_no=%s and c5chapter_no=%s ",$book_key,$chater_key);
				$keyword=sprintf("%s%s",$chater_key,$concat_chapter);
			}
			
			echo "<br>";
			$sql="select * from bible_hebrew where ".$where;
			

			$query=$mysqli->query($sql);
			$bible['bible_hebrew']=array();
			while($list=$query->fetch_assoc()){ 

                    $list['book'] = $list['c4book_no'];
                    $list['chapter'] = $list['c5chapter_no'];
                    $list['verse'] = $list['c6verse_no'];
                    $list['content'] = $list['c1content'];

					$count_verse++;
					array_push($bible['bible_hebrew'],$list);

			}

			/* search if hebrew bible */
$mod_value=3;
$init_version_count=0;
$print_bible_array=array();
$i=0;
//echo "count_verse is ".$count_verse;;
$cross_calc_verse=$count_verse-1;
foreach ($bible as $key => $value) {
    echo "키: ".$key." 값: ".$value."<br />\n";
    $bible_version=$value;

    foreach($bible_version as $keys => $values)
    {
    //echo "키2: ".$keys." 값3: ".$values."<br />\n";
	if($key=="kornkrv")
	{
		$k=$i*$mod_value;
    	
    	$print_bible_array[$k]=$values['verse']." ".$values['content'];
    }

    if($key=="bible_kjv"){
    	$k=$i+($i-$cross_calc_verse);
    	$print_bible_array[$k]=$values['verse']." ".$values['content'];
    }


    if($key=="bible_hebrew"){
    //	$k=$i+($i-$cross_calc_verse);
    //	$print_bible_array[$k]=$values['verse']." ".$values['content'];
    }
    
	$i++;
    }
}
ksort($print_bible_array);
$count_array_size=count($print_bible_array);
$init_cross_value = $count_array_size/2-1;

$version_name="[개역개정, 히브리어 성경]";
			echo $full_name[$book_key];
			echo "&nbsp;";
			echo $keyword;
			echo $version_name;
			echo "<br>";
	foreach($print_bible_array as $pba){
		echo $pba;
		echo "<br>";
	}


}/* if($is_hebrew) */

}
?>
 </body>
</html>
<?php } ?>