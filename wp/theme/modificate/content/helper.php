<?php
header('Access-Control-Allow-Origin: *');
include_once('./_common.php');
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('../head.php');

function get_member_code($key)
{
	$array['0']="교역자";
	$array['1']="섬기는이";
	$array['2']="부서장";
	$array['3']="섬김팀장";
	$array['4']="구역장";
	$array['5']="쇼파르, תְּרוּעָה (반주자)";
	$array['6']="헌신한 이들";

	if (array_key_exists($key, $array)) {
		$result=$array[$key];
	}else{
		$result="Anonymouse Member";
	}
	return $result;
}

/* 0. category 배열 초기화 */
$category=array();

/* 0. ez_helper 배열 초기화 */
$ez_helper=array();

/* 0. ez_helpers 배열 초기화  */
$ez_helpers=array();

/* 1. newezra.ez_helper 정보를 조회하는 쿼리 명령어를 선언한다. */
$sql= "SELECT * FROM newezra.ez_helper where ez_enable='Y'  order by ez_category;";

/* 2. sql_query 처리한 정보를 result에 담는다. */
$result = sql_query($sql);

/* 3. newezra.ez_helper 정보만큼 반복한다. */
for ($i=0; $row=sql_fetch_array($result); $i++)
{
	/* 3-1. newezra.ez_helper 정보를 ez_helper 배열에 담는다. */
	array_push($ez_helper,$row);
	/* 3-2. 카테고리(ez_helper)에 담긴 모든 정보(ez_date)를 년도만 추출하여 카테고리 배열(category)에 입력 한다. */
	$category[]=$row['ez_category'];
}
/* 4. 카테고리 정보를 유일(array_unique)한 변수로 처리하고, 재정렬(array_values) 하여 category 배열 변수에 담는다. */
$category = array_values(array_unique($category));

//print_r($category);
/* 5. category 배열 크기 만큼 반복한다. */
for($i=0;$i<count($category);$i++)
{
	/* 5-1. 카테고리을 연도별 $ez_helpers['1']의 형태의 배열로 초기화 */
	$ez_helpers[$category[$i]]=array();
}

//print_r($ez_helpers);
/* 6. ez_helper 배열 크기만큼 반복한다. */
for ($i=0; $i<count($ez_helper);$i++)
{
	/* 6-1.  categoy 변수 에 ez_category 추출하여 입력한다. */
	$categoy=$ez_helper[$i]['ez_category'];
	/* 6-2. $ez_helpers의 연도 별로 배열을 담기  */
	array_push($ez_helpers[$categoy],$ez_helper[$i]);
}
// echo "<pre>";
// print_r($ez_helpers);
// echo "</pre>";
?>
<script src="/wp/theme/modificate/youtube/js/jquery.js"></script>
<!-- This is what you need -->
<script src="/wp/theme/modificate/youtube/js/sweetalert.js"></script>
<script src="/wp/theme/modificate/youtube/js/bootstrap.min.js"></script>
<style>
	.bottom_left{
  font-size: 0.8em;

    text-align: inherit;
    margin-top: 20px;
}

.ez_career{
  min-height:60px;
}
</style>
<main class="page-content">
<section class="well text-center text-md-left">
<div class="row">
<div class="container">
   <div class="row">
      <div class="col-sm-3">

<?php
/* 8. category 별로 배열 출력 */
for($i=0;$i<count($category);$i++)
{
	/* 8-1. 연도별 배열($ez_helpers[$category[$i]])을 $ez_contents 배열에 담기 */
	$ez_contents=$ez_helpers[$category[$i]];
	//echo "<pre>";
	//print_r($ez_contents);
	/* 8-2. 첫 번째의 경우는 in active class를 활성화 한다. */
	print('<div class="container">');
	print('   <h5 class="text-bold text-md-left">&nbsp;</h5>');
	print('   <h5 class="text-bold text-md-left"><span style="font-family:\'굴림\';"></span>');

	print(get_member_code($ez_contents[0]['ez_category']));
//	echo "<pre>";
//	print_r($ez_contents[$i]);
//	echo "</pre>";
//	echo "<$ez_contents[$i]['ez_category']> : ".$ez_contents[$i]['ez_category'];
	print('   </h5>');
	print('   <hr>');
	print('   <div class="row flow-offset-2">');
	print('<div class="container">');
	/* 8-3. $ez_contents 정보만큼 반복한다. */
	for($j=0;$j<count($ez_contents);$j++)
	{
		print('	  <div class="col-xs-6 col-md-3 offset-4">');
		printf('         <div class="thumbnail thumbnail-4"><img title="%s" style="width:181px;height:181px" class="img-circle" src="%s" alt="nghy.png" onerror="this.src=\'/wp/theme/modificate/images/blog-26.jpg\'">',$ez_contents[$j]['ez_name'],addslashes($ez_contents[$j]['ez_image']));
	if($ez_contents[$i]['ez_category']=="0")
	{
		print('            <div class="caption offset-1" style="font-family:\'맑은 고딕\', \'malgun gothic\';font-size:11px;">');
	}else if($ez_contents[0]['ez_category']=="6")
	{
		print('            <div class="last_caption offset-1">');
	}else{
		print('            <div class="caption offset-1">');
	}
		printf('               <h6><span style="font-family:\'돋움\';">%s</span></h6>',$ez_contents[$j]['ez_name']);
	if($ez_contents[0]['ez_category']=="0")
	{
printf('               <p class="small text-light-clr text-uppercase"><span style="font-family:\'돋움\';">%s</span></p>',$ez_contents[$j]['ez_position']);
	}else{
	printf('               <p class="small text-light-clr text-uppercase"><span style="font-family:\'돋움\';">%s</span></p>',$ez_contents[$j]['ez_position']);
	}
	
		if($ez_contents[0]['ez_category']=="6")
	{
	
		printf('               <p class="ez_career">%s</p>',$ez_contents[$j]['ez_career']);
	}else{
		printf('               <p>%s</p>',$ez_contents[$j]['ez_career']);
	}
	if($ez_contents[0]['ez_category']=="6")
	{
		$start_of_time=strtotime($ez_contents[$j]['ez_datetime']);
		$end_of_time=strtotime($ez_contents[$j]['ez_expire_datetime']);

		$new_start_of_time=new Datetime($ez_contents[$j]['ez_datetime']);
		$new_end_of_time=new Datetime($ez_contents[$j]['ez_expire_datetime']);
		
		$interval = date_diff($new_start_of_time, $new_end_of_time);
//		print_r(
		$interval_time=$end_of_time-$start_of_time;
		$start_of_time = date("Y-m-d",$start_of_time);
		$end_of_time = date("Y-m-d",$end_of_time);
		printf("<div class='bottom_left'>%s ~ %s<br>",$start_of_time,$end_of_time);
		if($interval->y>0)
		printf("사역 일수 : %s년 ",$interval->y);
		if($interval->m>0)
		printf("%s개월 ",$interval->m);
		if($interval->d>0)
		printf("%s일",$interval->d);
		printf("<br>총 %s일</div>",number_format($interval->days));
	}
		print('               </div>');
		print('            </div>');
		print('         </div>');
	}
	print('</div>');
	print('</div>');

}
?>
</div><!-- .row -->

</section>
</main>
<?php
include_once(G5_PATH.'/tail.php');
?>