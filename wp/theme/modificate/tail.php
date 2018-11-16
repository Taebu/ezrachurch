<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}
?>

      <footer class="page-footer footer-centered dark text-center">
        <section class="footer-content">
          <div class="container">
            <div class="navbar-brand"><a href="<?php echo G5_URL ?>/index.php"><img src="<?php echo G5_THEME_URL;?>/images/logo.png" style="width:250px"></a></div>
            <p class="big">서울시 영등포구 선유로 252 설록디아망타워 지하 1층<br><span class=fa-phone></span> <a href=tel:070-4105-3927>070-4105-3927</a> / <a href=tel:010-3927-1754>010-3927-1754</a></p>
           
          </div>
        </section>
        <section class="copyright">
          <div class="container">
            <p>&#169; <span id="copyright-year"></span> All Rights Reserved</a></p>
          </div>
        </section>
      </footer>



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

	$(window).scroll(function(){
		if($("nav").css('backgroundColor')=="rgb(255, 255, 255)"||$("nav").css('backgroundColor')=="rgba(0, 0, 0, 0)"){
    		$(".rd-navbar-nav > li > a ").css("color","#000");
			$(".rd-navbar-brand .brand-name").css("color","#000");
		}
//	console.log(window.pageYOffset);
	});

  $( window ).resize(function() {
    if($("nav").css('backgroundColor')=="rgb(255, 255, 255)"||$("nav").css('backgroundColor')=="rgba(0, 0, 0, 0)"){
    //console.log("black");
      $(".rd-navbar-nav > li > a ").css("color","#000");
      $(".rd-navbar-brand .brand-name").css("color","#000");
  }
  });
	
});


</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>