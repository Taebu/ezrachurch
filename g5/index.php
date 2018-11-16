<base href="/g5/">
<?include_once("_common.php");?>
<?include_once("d_head.php");?>
<!-- Body -->
<link href="http://m1.daumcdn.net/cfs.tistory/blog/style/mobile/skin/skin_01/_/style_h.css?v=36020" media="screen" rel="stylesheet" type="text/css">
<link href="http://m1.daumcdn.net/cfs.tistory/blog/style/mobile/_/common_h.css?v=36020" media="screen" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://s1.daumcdn.net/svc/attach/U0301/cssjs/ucc-view-service/1390183726/static/css/widget_m.css">
<style>
	.fill {
		width:100%;height:100%;background-position:center;background-size:cover;
	}
	.carousel {
		margin-bottom: 0px;
	}
	.carousel-inner > .item {
		-webkit-transition: 0.3s ease-in-out left;
		-moz-transition: 0.3s ease-in-out left;
		-o-transition: 0.3s ease-in-out left;
		transition: 0.3s ease-in-out left;
	}

	/* keep full widget on smaller screens */
	@media (max-width: 767px) { 
		body {
			padding-left: 0;
			padding-right: 0;
		}
		.tn-danger{color: #ccc}
	}
	
	.body-news {
		margin-bottom: 30px;
	}
	.body-news h1, .body-product h1 {
		border-bottom: 1px solid #ddd;
	}
	.body1, .body2, .body3 {
		margin-bottom: 20px;
	}
</style>


<!-- Slide Image -->
<div class="fill">
	<div id="myCarousel" class="carousel slide">
		<div class="carousel-inner">
			<!-- 1st Image -->
			<div class="item active">
			  <div class="fill" style="background-image:url('/files/img/slide/img1.jpg');">
				<div class="carousel-caption">
					<h1><span style="background-color: #000000; filter:alpha(opacity=60); opacity:0.6; -moz-opacity:0.6;padding: 0 10px; text-shadow: 1px 1px 3px black;">성경 읽는 교회</span></h1>
					<p><span style="background-color: #000000; filter:alpha(opacity=60); opacity:0.6; -moz-opacity:0.6;padding: 0 10px 3px 10px; text-shadow: 1px 1px 3px black;">내가 이를 때까지 읽는 것과 권하는 것과 가르치는 것에 착념하라 [딤전4:13]</span></p>
				</div>
			  </div>
			</div>
			<!-- 1st Image -->

			<!-- 2nd Image -->
			<div class="item">
			  <div class="fill" style="background-image:url('/files/img/slide/img2.jpg');">
				<div class="carousel-caption">
					<h1><span style="background-color: #000000; filter:alpha(opacity=60); opacity:0.6; -moz-opacity:0.6;padding: 0 10px; text-shadow: 1px 1px 3px black;">가르치는 교회</span></h1>
					<p><span style="background-color: #000000; filter:alpha(opacity=60); opacity:0.6; -moz-opacity:0.6;padding: 0 10px 3px 10px; text-shadow: 1px 1px 3px black;">예수께서 온 갈릴리에 두루 다니사 저희 회당에서 가르치시며 천국 복음을 전파하시며 백성 중에 모든 병과 모든 약한 것을 고치시니 [마4:34]</span></p>
				</div>
			  </div>
			</div>
			<!-- 2nd Image -->

			<!-- 3rd Image -->
			<div class="item">
			  <div class="fill" style="background-image:url('/files/img/slide/img3.jpg');">
				<div class="carousel-caption">
					<h1><span style="background-color: #000000; filter:alpha(opacity=60); opacity:0.6; -moz-opacity:0.6;padding: 0 10px; text-shadow: 1px 1px 3px black;">전파하는 교회</span></h1>
					<p><span style="background-color: #000000; filter:alpha(opacity=60); opacity:0.6; -moz-opacity:0.6;padding: 0 10px 3px 10px; text-shadow: 1px 1px 3px black;">예수께서 모든 성과 촌에 두루 다니사 저희 회당에서 가르치시며 천국 복음을 전파하시며 모든 병과 모든 약한 것을 고치시니라 [마9:35]</span></p>
				</div>
			  </div>
			</div>
			<!-- 3rd Image -->


			<!-- 4th Image -->
			<div class="item">
			  <div class="fill" style="background-image:url('/files/img/slide/img3.jpg');">
				<div class="carousel-caption">
					<h1><span style="background-color: #000000; filter:alpha(opacity=60); opacity:0.6; -moz-opacity:0.6;padding: 0 10px; text-shadow: 1px 1px 3px black;">치료하는 교회</span></h1>
					<p><span style="background-color: #000000; filter:alpha(opacity=60); opacity:0.6; -moz-opacity:0.6;padding: 0 10px 3px 10px; text-shadow: 1px 1px 3px black;">예수께서 온 갈릴리에 두루 다니사 저희 회당에서 가르치시며 천국 복음을 전파하시며 백성 중에 모든 병과 모든 약한 것을 고치시니 [마4:34]</span></p>
				</div>
			  </div>
			</div>
			<!-- 4th Image -->


		</div>
		
		<div class="pull-center">
		  <a class="carousel-control left" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		  <a class="carousel-control right" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
		</div>
	</div>
</div>
<!-- Slide Image -->




<div class="container">

<div id="gallery">
<?
include_once("lib/latest.lib.php");
$board_arr = array(bbs_5_1,bbs_5_2,bbs_5_3);
$board_arr[0];
/*통합갤러리 최신글 출력(25는 추출이미지수, 20은 제목글자수)*/
//echo arr_new_gallery("total_gallery", $board_arr, 3, 20); 
echo latest('gallery','bbs_5_1;bbs_5_2;bbs_5_3', 3, 20,false);
?></div><!-- #gallery-->

<?echo latest('notice','bbs_6_1', 3, 62,false);?>

<!--	
	<div class="body2 clearfix">
		<div class='intro-title'><h2>News</h2></div>				<div class="col-sm-4">
					<p><strong>성경말씀 중심의 교회로서 하나님을 섬...</strong></p>
					<p>성경말씀 중심의 교회로서 하나님을 섬기며, 성령의 역사를 통하여 주님의 명령 을 수행하고자 오늘도...</p>
					<a href="/bbs/bbs/view.php?bbs_no=1&data_no=13" class="btn btn-default">Read More...</a><br><br>
				</div>				<div class="col-sm-4">
					<p><strong>베드로 전서 "신앙 중심 잡기" 시리...</strong></p>
					<p>기도가 막히지 않게 하라
Let Nothing Hinder Your Prayer
베드로 전서 3:7...</p>
					<a href="/bbs/bbs/view.php?bbs_no=1&data_no=12" class="btn btn-default">Read More...</a><br><br>
				</div>				<div class="col-sm-4">
					<p><strong>양육활동 안내...</strong></p>
					<p>하나님이 임재하셔서 치요와 감동과 축복이 넘치는 살아있는 예배를 드립니다....</p>
					<a href="/bbs/bbs/view.php?bbs_no=1&data_no=1" class="btn btn-default">Read More...</a><br><br>
				</div>	</div>-->

<!--실시간 이슈 -->
<!--#hottrendsContainer-->
<div class="body3 clearfix"></div>
</div>
<div class="container"></div>
<link rel="stylesheet" href="/bs/dist/css/carousel.css">
<script>
	$(document).ready(function(){
        $('#myModal').modal('show');

		$(".carousel").carousel({ 
			interval: 3500
		})
		;
	});
</script>

<!-- Body End -->
<?include_once("d_footer.php");?>