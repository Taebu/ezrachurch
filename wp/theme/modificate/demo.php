<?php
//define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
 //   include_once(G5_THEME_MOBILE_PATH.'/index.php');
 //   return;
}

include_once(G5_THEME_PATH.'/head_demo.php');

//echo $ezra['k'];
//G5_THEME_PATH : /host/home4/socialart/html/theme/modificate 
?>


<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<div id="main">
			<h3 style=color:#ffffff;>
				<?php echo $ezra['words'];?>
			</h3>



			    <div style=margin-top:80px;text-align:left>
        <?php
        // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
        // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
        // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
        echo latest('theme/basic', notice, 2, 100);
        ?>
    </div>


		</div>









 </body>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<!-- <a href="<?php echo get_device_change_url(); ?>" id="device_change">모바일 버전으로 보기</a> -->
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}

//echo $config['cf_visit'];
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    
	font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
	/*
	$(window).scroll(function(){
		if(window.pageYOffset>=100){
			$(".rd-navbar-nav > li > a ").css("color","#000");
			$(".rd-navbar-brand .brand-name").css("color","#000");
		}else{
			$(".rd-navbar-nav > li > a ").css("color","#fff");
			$(".rd-navbar-brand .brand-name").css("color","#fff");
		}
	console.log(window.pageYOffset);
	});
	*/
});


</script>

    </div>
    <!--Core Scripts-->
    <script src="<?php echo G5_THEME_JS_URL; ?>/core.min.js"></script>
    <!--jQuery (necessary for Bootstrap's JavaScript plugins)-->
    <!--Include all compiled plugins (below), or include individual files as needed-->
    <script src="<?php echo G5_THEME_JS_URL; ?>/bootstrap.min.js"></script>
    <!--Additional Functionality Scripts-->
    <script src="<?php echo G5_THEME_JS_URL; ?>/script.js"></script>

	<script src="<?php echo G5_THEME_URL; ?>/plugin/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    
	<script src="<?php echo G5_THEME_URL; ?>/plugin/bootstrap-datepicker/locales/bootstrap-datepicker.kr.min.js" charset="UTF-8"></script>
 <!-- Google Tag Manager --><noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-N7VWVN" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push( {'gtm.start': new Date().getTime(),event:'gtm.js'} );var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-N7VWVN');</script> <!-- End Google Tag Manager -->
</html>
<?php
//include_once(G5_THEME_PATH."/tail.sub.php");
?>