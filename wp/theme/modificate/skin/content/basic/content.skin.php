<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/style.css">', 0);
?>
      <header class="page-header subpage_header">
		<section>
          <!--Swiper-->
          <div data-autoplay="5000" data-slide-effect="fade" data-loop="false" class="swiper-container swiper-slider">
            <div class="jumbotron text-center">
              <h1><small>Tables</small>With a nice modern and <br class='hidden-md hidden-sm hidden-xs'> intuitive interface</h1>
              <p class="big"></p>
            </div>
            <div class="swiper-wrapper">
              <div data-slide-bg="<?php echo G5_THEME_URL;?>/images/header-1.jpg" class="swiper-slide">
                <div class="swiper-slide-caption">1</div>
              </div>
              <div data-slide-bg="<?php echo G5_THEME_URL;?>/images/header-2.jpg" class="swiper-slide">
                <div class="swiper-slide-caption">2</div>
              </div>
              <div data-slide-bg="<?php echo G5_THEME_URL;?>/images/header-3.jpg" class="swiper-slide">
                <div class="swiper-slide-caption">3</div>
              </div>
              <div data-slide-bg="<?php echo G5_THEME_URL;?>/images/header-4.jpg" class="swiper-slide">
                <div class="swiper-slide-caption">4</div>
              </div>
              <div data-slide-bg="<?php echo G5_THEME_URL;?>/images/header-5.jpg" class="swiper-slide">
                <div class="swiper-slide-caption">5</div>
              </div>
              <div data-slide-bg="<?php echo G5_THEME_URL;?>/images/header-6.jpg" class="swiper-slide">
                <div class="swiper-slide-caption">6</div>
              </div>
            </div>
          </div>
        </section>
      </header>
<!--=================================================
                           Content
    ==================================================-->
    <main class="page-content">
        <section>
            <div class="container">
<article id="ctt" class="ctt_<?php echo $co_id; ?>">
    <header>
        <h1><?php echo $g5['title']; ?></h1>
    </header>

    <div id="ctt_con">
        <?php echo $str; ?>
    </div>

</article>