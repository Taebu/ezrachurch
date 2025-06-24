<?php
//header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);

//exit("공동제직회 기간이 아닙니다.");
extract($_GET);
$year=isset($year)?$year:"2023";
$quater=isset($quater)?$quater:"3";
$sign_yn=isset($sign_yn)?$sign_yn:"N";
$page_yn=isset($page_yn)?$page_yn:"N";
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php printf("%s년도 %s분기 재정 보고",$year,$quater);?></title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="./slick/slick.css">
  <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css">
  <script src="//code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="./slick/slick.js" type="text/javascript" charset="utf-8"></script>


<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
				

  <script type="text/javascript">
    $(document).on('ready', function() {
      $(".vertical-center-4").slick({
        dots: false,
        vertical: false,
        centerMode: false,
        draggable: true,
        slidesToShow: 1,
        slidesToScroll: 1,
		swipeToSlide:true,
		infinite: false
      });

		$(".slick-next").focus();
		$("iframe").height($(document).height()-121);
    });
</script>
  <style type="text/css">
    html, body {
      margin: 0;
      padding: 0;
    }

    * {
      box-sizing: border-box;
    }

    .slider {
        width: 90%;
		height: 800px;
        margin: 100px auto;
    }

    .slick-slide {
      margin: 0px 20px;
    }

    .slick-slide img {
      width: 100%;
    }

    .slick-prev:before,
    .slick-next:before {
      color: black;
    }


    .slick-slide {
      transition: all ease-in-out .3s;
      opacity: .2;
    }
    
    .slick-active {
      opacity: .5;
    }

    .slick-current {
      opacity: 1;
    }

	.h1{font-size: xxx-large;position: absolute;top:40%;height:800px;text-align: center;width: inherit;}
	.h3{font-size: large;position: absolute;top: 80%;height: 800px;text-align: center;width: inherit;}
	iframe{width:100%;height:800px;overflow-y:hidden;}
	iframe html{margin-top: 10px;}

  </style>
</head>
<?php 
echo date('Y-m-d', strtotime('second saturday of december 2025'));
echo date('Y-m-d', strtotime('두번째 토요일 12월 2025'));

?>
<body>
  <section class="vertical-center-4 slider">
	<div>
		<div class="h1">2023년 4분기 결산<br>2024년 1분기 예산<br> 2024년도 총예산</div>

		<div class="h3">서울에스라교회<br>공동제직회<br>2023-12-17(주일)</div>
    </div>

	<?php
	$team_array = array();
	$team_array[] = array("kor_name"=>"당회","eng_name"=>"moderator");
	$team_array[] = array("kor_name"=>"EzraTV","eng_name"=>"ezratv");
	$team_array[] = array("kor_name"=>"부교역자","eng_name"=>"assistant_pastor");
	$team_array[] = array("kor_name"=>"찬양팀","eng_name"=>"hymn");
	$team_array[] = array("kor_name"=>"매체팀","eng_name"=>"media");
	$team_array[] = array("kor_name"=>"시설,미화팀","eng_name"=>"facilities");
	$team_array[] = array("kor_name"=>"복지선교팀","eng_name"=>"welfare_mission");
	$team_array[] = array("kor_name"=>"새가족안내팀","eng_name"=>"new_family");
	$team_array[] = array("kor_name"=>"여전도회","eng_name"=>"womans");
	$team_array[] = array("kor_name"=>"주방팀","eng_name"=>"kitchen");
	$team_array[] = array("kor_name"=>"영유아부","eng_name"=>"kids");
	$team_array[] = array("kor_name"=>"주일학교","eng_name"=>"sunday_school");
	$team_array[] = array("kor_name"=>"청년부","eng_name"=>"youth");
	$team_array[] = array("kor_name"=>"학생부","eng_name"=>"student");

	for($i=0;$i<count($team_array);$i++)
	{
		$report=sprintf("/ac/report.php?ab_class=%s&year=%s&quater=%s&sign_yn=%s&page_yn=%s",$team_array[$i]['eng_name'],$year,$quater,$sign_yn,$page_yn);
		$next=sprintf("/ac/next_quater.php?ab_class=%s&year=%s&quater=%s&sign_yn=%s&page_yn=%s",$team_array[$i]['eng_name'],$year,$quater,$sign_yn,$page_yn);
		$budget_plan=sprintf("/ac/budget_plan.php?ab_class=%s&year=%s&quater=%s&sign_yn=%s&page_yn=%s",$team_array[$i]['eng_name'],$year,$quater,$sign_yn,$page_yn);
	?>
	<div>
		<div class="h1"><?php echo $team_array[$i]['kor_name'];?><br>재정보고</div>
    </div>
	<div>
	<?php if($page_yn=="N"){ ?>
		<iframe src="<?php echo $report;?>"  scrolling ="Yes" frameborder="0"></iframe>
	<?php }else{ ?>
		<iframe src="<?php echo $report;?>"  scrolling ="No" frameborder="0"></iframe>
	<?php }?>
    </div>
    <div>
	<?php if($page_yn=="N"){ 	
		if($team_array[$i]['eng_name']!="ezratv"){ ?>
		<iframe src="<?php echo $next;?>"  scrolling ="Yes" frameborder="0"></iframe>
	<?php 
		} }else{ 
	
		if($team_array[$i]['eng_name']!="ezratv"){ ?>
		<iframe src="<?php echo $next;?>"  scrolling ="No" frameborder="0"></iframe>
	<?php 
		}
	 }?>

    </div>
	<div>
		<iframe src="<?php echo $budget_plan;?>"  scrolling ="Yes" frameborder="0"></iframe>
	</div>
	<?php } ?>
    <div class="virtual_box">
		<iframe src="/ac/total.php?quater=4"  scrolling ="No" frameborder="0"></iframe>
    </div>
    <div class="virtual_box">
		<iframe src="/ac/year_total.php?quater=4"  scrolling ="No" frameborder="0"></iframe>
    </div>
	<div>
		<div class="h1">수고하셨습니다.</div>
    </div>
  </section>




</body>
</html>
