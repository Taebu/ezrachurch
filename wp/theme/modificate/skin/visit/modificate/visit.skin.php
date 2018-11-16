<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$visit_skin_url.'/style.css">', 0);
?>

<!-- 접속자집계 시작 { -->
<!-- <section id="visit">
    <div>
        <h2>접속자집계  modificate</h2>
        <dl>
            <dt>오늘</dt>
            <dd><?php echo number_format($visit[1]) ?></dd>
            <dt>어제</dt>
            <dd><?php echo number_format($visit[2]) ?></dd>
            <dt>최대</dt>
            <dd><?php echo number_format($visit[3]) ?></dd>
            <dt>전체</dt>
            <dd><?php echo number_format($visit[4]) ?></dd>
        </dl>
        <?php if ($is_admin == "super") {  ?><a href="<?php echo G5_ADMIN_URL ?>/visit_list.php">상세보기</a><?php } ?>
    </div>
</section> -->
		<section class="bg-dark-var1 text-center">
          <div class="container counter-panel">
          <!-- 오늘1어제11최대11전체15 -->
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-3">
                <div data-from="0" data-to="<?php echo $visit[1]; ?>" class="counter"></div>
                <p class="text-opacity font-secondary text-uppercase">오늘</p>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3">
                <div data-from="0" data-to="<?php echo $visit[2]; ?>" class="counter"></div>
                <p class="text-opacity font-secondary text-uppercase">어제</p>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3">
                <div data-from="0" data-to="<?php echo $visit[3]; ?>" class="counter"></div>
                <p class="text-opacity font-secondary text-uppercase">최대</p>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3">
                <div data-from="0" data-to="<?php echo $visit[4]; ?>" class="counter"></div>
                <p class="text-opacity font-secondary text-uppercase">전체</p>
              </div>
			  <?php if ($is_admin == "super") {  ?><a href="<?php echo G5_ADMIN_URL ?>/visit_list.php">상세보기</a><?php } ?>
            </div>
          </div>
        </section>

<!-- } 접속자집계 끝 -->