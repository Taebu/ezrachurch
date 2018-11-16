<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);

?>


            <!--
      ========================================================
                              CONTENT
      ========================================================
      -->
      <main class="page-content">

		<!--Start section-->
        <section class="well well-sm section-border">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
<!-- FAQ 시작 { -->
<?php


if ($admin_href)
    echo '<div class="faq_admin"><a href="'.$admin_href.'" class="btn_admin">FAQ 수정</a></div>';

if ($himg_src)
    echo '<div id="faq_himg" class="faq_img"><img src="'.$himg_src.'" alt=""></div>';

// 상단 HTML
echo '<div id="faq_hhtml">'.conv_content($fm['fm_head_html'], 1).'</div>';
?>

<?php
if( count($faq_master_list) ){
?>
<nav id="bo_cate">
    <ul id="bo_cate_ul">
        <?php
        foreach( $faq_master_list as $v ){
            $category_msg = '';
            $category_option = '';
            if($v['fm_id'] == $fm_id){ // 현재 선택된 카테고리라면
                $category_option = ' id="bo_cate_on"';
                $category_msg = '<span class="sound_only">열린 분류 </span>';
            }
        ?>
        <li><a href="<?php echo $category_href;?>?fm_id=<?php echo $v['fm_id'];?>" <?php echo $category_option;?> ><?php echo $category_msg.$v['fm_subject'];?></a></li>
        <?php
        }
        ?>
    </ul>
</nav>
<?php } ?>

<div data-type="accordion" class="responsive-tabs">

                    <?php // FAQ 내용
    if( count($faq_list) ){
    ?>
        <ul class="resp-tabs-list">
            <?php
            foreach($faq_list as $key=>$v){
                if(empty($v))
                    continue;
            ?>
            <li>
                <h4><a href="#none" onclick="return faq_open(this);"><?php echo conv_content($v['fa_subject'], 1); ?></a></h4>
            </li>
            <?php
            }
            ?>
        </ul>
        <div class="resp-tabs-container">
            <?php
            foreach($faq_list as $key=>$v){
                if(empty($v))
                    continue;
            ?>
            <div><?php echo conv_content($v['fa_content'], 1); ?></div>
            <?php
            }
            ?>
        </div>

    <?php

    } else {
        if($stx){
            echo '<p class="empty_list">검색된 게시물이 없습니다.</p>';
        } else {
            echo '<div class="empty_list">등록된 FAQ가 없습니다.';
            if($is_admin)
                echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용하십시오.';
            echo '</div>';
        }
    }
    ?>
               

<div id="faq_wrap" class="faq_<?php echo $fm_id; ?>"></div>

<?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<?php
// 하단 HTML
echo '<div id="faq_thtml">'.conv_content($fm['fm_tail_html'], 1).'</div>';

if ($timg_src)
    echo '<div id="faq_timg" class="faq_img"><img src="'.$timg_src.'" alt=""></div>';
?>

<fieldset id="faq_sch">
    <legend>FAQ 검색</legend>

    <form name="faq_search_form" method="get">
    <input type="hidden" name="fm_id" value="<?php echo $fm_id;?>">
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $stx;?>" required id="stx" class="frm_input required" size="15" maxlength="15">
    <input type="submit" value="검색" class="btn_submit">
    </form>
</fieldset>
<!-- } FAQ 끝 -->

<?php
if ($admin_href)
    echo '<div class="faq_admin"><a href="'.$admin_href.'" class="btn_admin">FAQ 수정</a></div>';
?>


		
 </div> </div> </div> </div>
		
		</section>
        <!--End section-->
</main>







<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
$(function() {
    $(".closer_btn").on("click", function() {
        $(this).closest(".con_inner").slideToggle();
    });
});

function faq_open(el)
{
    var $con = $(el).closest("li").find(".con_inner");

    if($con.is(":visible")) {
        $con.slideUp();
    } else {
        $("#faq_con .con_inner:visible").css("display", "none");

        $con.slideDown(
            function() {
                // 이미지 리사이즈
                $con.viewimageresize2();
            }
        );
    }

    return false;
}
</script>
