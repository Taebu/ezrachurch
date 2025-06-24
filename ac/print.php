<?php
//exit("공동제직회 기간이 아닙니다.");
$year=isset($year)?$year:"2023";
include_once "./db_con.php";
include_once("./subject.php");
extract($_GET);
$display_year=$year;
$quater=isset($quater)?$quater:"3";
$sign_yn=isset($sign_yn)?$sign_yn:"N";
$page_yn=isset($page_yn)?$page_yn:"N";
$d_day="";
switch($quater){
case 1:
$d_day=$ac_config['ac_1'];
break;
case 2:
$d_day=$ac_config['ac_2'];
break;
case 3:
$d_day=$ac_config['ac_3'];
break;
case 4:
$d_day=$ac_config['ac_4'];
break;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php printf("%s년도 %s분기 재정 보고",$year,$quater);?></title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="./slick/slick.css">
  <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css">
  
<link rel="stylesheet" type="text/css" href="/ac/css/main.css" media="all" />
  <script src="//code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="./slick/slick.js" type="text/javascript" charset="utf-8"></script>


<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
				

  <script type="text/javascript">
    $(document).on('ready', function() {
//		$("iframe").height($(document).height()-121);
    });
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight+10 + 'px';
  }
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
	.virtual_box{position: relative;width: 100%;height: max-content;min-height: 600px;}
	.h1{font-size: xxx-large;position: absolute;top:40%;height:600px;text-align: center;width: inherit;font-family: 'Godo';}
	.h3{font-size: large;position: absolute;top: 80%;height: 600px;text-align: center;width: inherit;font-family: 'Godo';}
	iframe{width:100%;min-height:600px;height: max-content;}
	iframe html{margin-top: 10px;}


      @media print {
        table {
          page-break-inside: avoid !important;
        }
        tr {
          break-inside: avoid !important;
        }
        tbody {
          display: block;
        }
        tbody tr:nth-child(5n + 1) {
          page-break-before: always;
        }
      }

  </style>
</head>
<?php 
$dp_quater=$quater;
?>
<body>
  <section>
	<div class="virtual_box">
		<div class="h1"><?php echo $year;?>년 <?php echo $quater;?>분기 결산<br><?php echo $quater=="4"?++$year:$year;?>년 <?php echo $quater=="4"?"1":++$quater;?>분기 예산
		<?php
if($dp_quater=="4"){
	?><br>
<?php echo $year;?>년 총 예산안
<?php }		?>
		</div>

		<div class="h3">서울에스라교회<br>공동제직회<br><?php echo $d_day;?>(주일)</div>

		<!-- 		<div class="h3">서울에스라교회<br>공동제직회<br>2023-12-17(주일)</div> -->
    </div>

	<?php
	$team_array = array();
	$team_array[] = array("kor_name"=>"당회","eng_name"=>"moderator");
	$team_array[] = array("kor_name"=>"EzraTV","eng_name"=>"ezratv");
	$team_array[] = array("kor_name"=>"건축헌금","eng_name"=>"building");
//	$team_array[] = array("kor_name"=>"남전도회","eng_name"=>"assistant_pastor");
	$team_array[] = array("kor_name"=>"남전도회","eng_name"=>"mans");
	$team_array[] = array("kor_name"=>"찬양팀","eng_name"=>"hymn");
	$team_array[] = array("kor_name"=>"워십밴드팀","eng_name"=>"worship_band");
	$team_array[] = array("kor_name"=>"매체팀","eng_name"=>"media");
	$team_array[] = array("kor_name"=>"시설,미화팀","eng_name"=>"facilities");
	$team_array[] = array("kor_name"=>"복지선교팀","eng_name"=>"welfare_mission");
	$team_array[] = array("kor_name"=>"새가족안내팀","eng_name"=>"new_family");
	$team_array[] = array("kor_name"=>"여전도회","eng_name"=>"womans");
	$team_array[] = array("kor_name"=>"주방팀","eng_name"=>"kitchen");
	$team_array[] = array("kor_name"=>"영유아부","eng_name"=>"kids");
	$team_array[] = array("kor_name"=>"초등부","eng_name"=>"sunday_school");
	$team_array[] = array("kor_name"=>"청년부","eng_name"=>"youth");
	$team_array[] = array("kor_name"=>"학생부","eng_name"=>"student");

	for($i=0;$i<count($team_array);$i++)
	{
		$report=sprintf("/ac/report.php?ab_class=%s&year=%s&quater=%s&sign_yn=%s&page_yn=%s",$team_array[$i]['eng_name'],$display_year,$dp_quater,$sign_yn,$page_yn);
		$next=sprintf("/ac/next_quater.php?ab_class=%s&year=%s&quater=%s&sign_yn=%s&page_yn=%s",$team_array[$i]['eng_name'],$display_year,$dp_quater,$sign_yn,$page_yn);
		$budget_plan=sprintf("/ac/budget_plan.php?ab_class=%s&year=%s&quater=%s&sign_yn=%s&page_yn=%s",$team_array[$i]['eng_name'],$display_year,$dp_quater,$sign_yn,$page_yn);
		$settlement=sprintf("/ac/settlement.php?ab_class=%s&year=%s",$team_array[$i]['eng_name'],$display_year);
	?>
	<div class="virtual_box">
		<div class=" h1"><?php echo $team_array[$i]['kor_name'];?><br>재정보고</div>
    </div>
	<div class="virtual_box">
	<?php if($page_yn=="N"){ ?>
		<iframe src="<?php echo $report;?>"  frameborder="0" scrolling="no" onload="resizeIframe(this)" ></iframe>
	<?php }else{ ?>
		<iframe src="<?php echo $report;?>"  scrolling ="No" frameborder="0"></iframe>

	<?php }?>
		<br>
		<br>
		<br>
		<br>
		<br>
    </div>

    <div class="virtual_box">
	<?php if($page_yn=="N"){ 
		if($team_array[$i]['eng_name']!="ezratv"){ ?>
		<iframe src="<?php echo $next;?>"  frameborder="0" scrolling="no" onload="resizeIframe(this)" ></iframe>
	<?php 
		}	
		}else{ 
		if($team_array[$i]['eng_name']!="ezratv"){ ?>
		<iframe src="<?php echo $next;?>"  scrolling ="No" frameborder="0"></iframe>
	<?php 
		}
		}?>
		<br>
		<br>
		<br>
		<br>
		<br>
	</div>
<?php if($dp_quater=="4"){?>
	<div class="virtual_box">
	<?php if($page_yn=="N"){ ?>
		<iframe src="<?php echo $budget_plan;?>"  frameborder="0" scrolling="no" onload="resizeIframe(this)" ></iframe>
	<?php }else{ ?>
		<iframe src="<?php echo $budget_plan;?>"  scrolling ="No" frameborder="0"></iframe>
	<?php }?>
    </div>


	<div class="virtual_box">
	<?php if($page_yn=="N"){ ?>
		<iframe src="<?php echo $settlement;?>"  frameborder="0" scrolling="no" onload="resizeIframe(this)" ></iframe>
	<?php }else{ ?>
		<iframe src="<?php echo $settlement;?>"  scrolling ="No" frameborder="0"></iframe>
	<?php }?>
    </div>
<?php } ?>
<?php } ?>
<?php if($dp_quater=="4"){

if(file_exists($_SERVER['DOCUMENT_ROOT']."/ac/summary/".$display_year.".html"))
{
?>
    <div class="virtual_box" id="<?php echo $display_year;?>">
		<iframe src="/ac/summary/<?php echo $display_year;?>.html"  scrolling ="Yes" frameborder="0" onload="resizeIframe(this)" ></iframe>
    </div>
<?php 
}else{
?>    <div class="virtual_box" id="<?php echo $display_year;?>">/ac/summary/<?php echo $display_year;?>.html 에 <?php echo $display_year;?>년 총 회계 항목별 명세서를 만들어 주세요.</div>
<?php
}?>


<?php
}?>

	<div class="virtual_box">
		<iframe src="/ac/total.php?quater=<?php echo $dp_quater;?>"  scrolling ="Yes" frameborder="0" onload="resizeIframe(this)" ></iframe>
    </div>

<?php if($dp_quater=="4"){?>
    <div class="virtual_box">
		<iframe src="/ac/year_total.php?quater=<?php echo $dp_quater;?>"  scrolling ="Yes" frameborder="0" onload="resizeIframe(this)" ></iframe>
    </div>
<?php } ?>
  </section>




</body>
</html>
