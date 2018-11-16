<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

        <section>
          <!--Swiper-->
          <div data-autoplay="5000" data-slide-effect="fade" data-loop="false" class="swiper-container swiper-slider">
            <div class="jumbotron text-center">
              <h1><small>Blog</small><?php echo $board['bo_subject']; ?></h1>
              <p class="big"></p>
            </div>
            <div class="swiper-wrapper">
              <div data-slide-bg="/images/header-1.jpg" class="swiper-slide">
                <div class="swiper-slide-caption"></div>
              </div>
              <div data-slide-bg="/images/header-3.jpg" class="swiper-slide">
                <div class="swiper-slide-caption"></div>
              </div>
              <div data-slide-bg="/images/header-4.jpg" class="swiper-slide">
                <div class="swiper-slide-caption"></div>
              </div>
            </div>
          </div>
        </section>
      </header>
    <!--
      ========================================================
                              CONTENT
      ========================================================
      -->
      <main class="page-content">
        <section class="section-border text-center text-md-left">
          <div class="container">
            <ol class="breadcrumb">
              <li><a href="index.html">Home</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">Timeline</a></li>
              <li class="active"><a href="#"><?php echo $board['bo_subject']; ?></a></li>
            </ol>
          </div>
        </section>

        <!--Start section-->
        <section class="text-center text-md-left offset-1">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 section-border">
                <article class="well">
<!-- 게시물 읽기 시작 { -->
<h1><?php
            if ($category_name) echo $view['ca_name'].' | '; // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
</h1>
                  <div class="blog-info">
                    <!--<div class="pull-md-left">
                      <time datetime="2015" class="meta fa-calendar">Feb 10, 2014</time><a class="badge fa-user text-uppercase font-secondary">Admin</a><span class="tags"><a class="badge fa-tags"></a><a class="post-tag round-xl small">General</a><a class="post-tag round-xl small">Media</a></span><a class="badge fa-comments text-uppercase font-secondary">13 comments</a>
					</div><!-- .pull-md-left -->
					
   <!--<section id="bo_v_info">-->
				<div class="pull-md-left">
                      <time datetime="<?php echo date("Y", strtotime($view['wr_datetime'])) ?>" class="meta fa-calendar"><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?><a class="badge fa-user text-uppercase font-secondary"><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></a><span class="tags"><a class="badge fa-tags"></a><a class="post-tag round-xl small">General</a><a class="post-tag round-xl small">Media</a><a class="post-tag round-xl small"><?php echo number_format($view['wr_hit']) ?>회</a></span>
					  
					  <a class="badge fa-comments text-uppercase font-secondary"><?php echo number_format($view['wr_comment']) ?> comments</a>
					</div><!-- .pull-md-left -->

    <!--</section>-->
	</div>
<article id="bo_v" style="width:<?php echo $width; ?>">


    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
    if ($view['link']) {
    ?>
     <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="관련링크">
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>

    <!-- 게시물 상단 버튼 시작 { -->
    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
        <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01">이전글</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01">다음글</a></li><?php } ?>
        </ul>
        <?php } ?>

        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b01">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b01" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">복사</a></li><?php } ?>
            <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">이동</a></li><?php } ?>
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn_b01">검색</a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li>
            <?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01">답변</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

                  </div><!-- .blog-info -->

 <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\" class=\"offset-5\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
         ?>
        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->
                  
    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>

       

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <!-- 스크랩 추천 비추천 시작 { -->
        <?php if ($scrap_href || $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn_b01" onclick="win_scrap(this.href); return false;">스크랩</a><?php } ?>
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="btn_b01">추천 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good"></b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn_b01">비추천  <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span>추천 <strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span>비추천 <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <!-- } 스크랩 추천 비추천 끝 -->
    </section>

    <?php
    include_once(G5_SNS_PATH."/view.sns.skin.php");
    ?>

    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
     ?>
                </article>
              </div>
              <div class="col-xs-12 section-border">
                <div class="blog-info blog-info-inset text-center text-lg-left">
                  <div class="pull-lg-left"><span class="tags wrap-normal"><a class="badge fa-tags"></a><a class="post-tag round-xl small">General</a><a class="post-tag round-xl small">Information</a><a class="post-tag round-xl small">Media</a><a class="post-tag round-xl small">Press</a><a class="post-tag round-xl small">Gallery</a><a class="post-tag round-xl small">Illustration</a></span></div>
                  <div class="pull-lg-right inline-block"><span class="small font-secondary text-uppercase text-light-clr">Share this</span>
                    <ul class="list-inline list-inline-4 pull-md-right">
                      <li><a href="#" class="fa-facebook text-info"></a></li>
                      <li><a href="#" class="fa-pinterest-p text-danger"></a></li>
                      <li><a href="#" class="fa-twitter text-primary"></a></li>
                      <li><a href="#" class="fa-google-plus text-danger"></a></li>
                      <li><a href="#" class="fa-instagram text-info"></a></li>
                      <li><a href="#" class="fa-rss"></a></li>
                      <li><a href="#" class="fa-envelope text-info"></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 text-center text-md-left post-links offset-5"><a href="#" class="btn-link pull-md-left fa-angle-left">This is a Standard post with a Slider Gallery</a><br class="hidden-lg hidden-md"><a href="#" class="btn-link pull-md-right fa-angle-right">This is an Embedded Video Post</a></div>
              <div class="col-xs-12 text-center text-md-left offset-2 section-border">
                <div class="post-autor col-inset-2">
                  <h6>Posted by <span class="text-primary">John Doe</span></h6>
                  <div class="box-md offset-5">
                    <div class="box__left"><img src="/images/blog-21.jpg" alt="" class="img-circle"></div>
                    <div class="box__body box__middle">
                      <p class="big">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores, eveniet, eligendi et nobis neque minus mollitia sit repudiandae ad repellendus recusandae blanditiis praesentium vitae ab sint earum voluptate velit beatae alias fugit accusantium laboriosam nisi reiciendis deleniti tenetur molestiae maxime id quaerat consequatur fugiat aliquam laborum nam aliquid. Consectetur, perferendis?
                        
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 text-center text-md-left well">
                <h5>Related Posts:</h5>
                <div class="row no-offset">
                  <div class="col-sm-6 col-md-4">
                    <article class="thumbnail thumbnail-4 section-border well"><img src="/images/blog-3.jpg" alt="">
                      <div class="caption">
                        <h4><a href="blog_post.html">This is a Standard Post with a Preview Image</a></h4>
                        <p class="text-dark-variant-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in.</p>
                        <div class="blog-info">
                          <div class="pull-md-left">
                            <time datetime="2015" class="meta fa-calendar">Feb 10, 2014</time><a href="#" class="badge fa-comments font-secondary">13</a>
                          </div><a href="blog_post.html" class="btn-link">Read More</a>
                        </div>
                      </div>
                    </article>
                  </div>
                  <div class="col-sm-6 col-md-4">
                    <article class="thumbnail thumbnail-4 section-border well"><img src="/images/blog-4.jpg" alt="">
                      <div class="caption">
                        <h4><a href="blog_post.html">This is a Standard Post with a Preview Image</a></h4>
                        <p class="text-dark-variant-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in.</p>
                        <div class="blog-info">
                          <div class="pull-md-left">
                            <time datetime="2015" class="meta fa-calendar">Feb 10, 2014</time><a href="#" class="badge fa-comments font-secondary">13</a>
                          </div><a href="blog_post.html" class="btn-link">Read More</a>
                        </div>
                      </div>
                    </article>
                  </div>
                  <div class="col-sm-6 col-md-4">
                    <article class="thumbnail thumbnail-4 section-border well"><img src="/images/blog-5.jpg" alt="">
                      <div class="caption">
                        <h4><a href="blog_post.html">This is a Standard Post with a Preview Image</a></h4>
                        <p class="text-dark-variant-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in.</p>
                        <div class="blog-info">
                          <div class="pull-md-left">
                            <time datetime="2015" class="meta fa-calendar">Feb 10, 2014</time><a href="#" class="badge fa-comments font-secondary">13</a>
                          </div><a href="blog_post.html" class="btn-link">Read More</a>
                        </div>
                      </div>
                    </article>
                  </div>
                  <div class="col-sm-6 col-md-4">
                    <article class="thumbnail thumbnail-4 section-border well"><img src="/images/blog-6.jpg" alt="">
                      <div class="caption">
                        <h4><a href="blog_post.html">This is a Standard Post with a Preview Image</a></h4>
                        <p class="text-dark-variant-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in.</p>
                        <div class="blog-info">
                          <div class="pull-md-left">
                            <time datetime="2015" class="meta fa-calendar">Feb 10, 2014</time><a href="#" class="badge fa-comments font-secondary">13</a>
                          </div><a href="blog_post.html" class="btn-link">Read More</a>
                        </div>
                      </div>
                    </article>
                  </div>
                  <div class="col-sm-6 col-md-4">
                    <article class="thumbnail thumbnail-4 section-border well"><img src="/images/blog-7.jpg" alt="">
                      <div class="caption">
                        <h4><a href="blog_post.html">This is a Standard Post with a Preview Image</a></h4>
                        <p class="text-dark-variant-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in.</p>
                        <div class="blog-info">
                          <div class="pull-md-left">
                            <time datetime="2015" class="meta fa-calendar">Feb 10, 2014</time><a href="#" class="badge fa-comments font-secondary">13</a>
                          </div><a href="blog_post.html" class="btn-link">Read More</a>
                        </div>
                      </div>
                    </article>
                  </div>
                  <div class="col-sm-6 col-md-4">
                    <article class="thumbnail thumbnail-4 section-border well"><img src="/images/blog-8.jpg" alt="">
                      <div class="caption">
                        <h4><a href="blog_post.html">This is a Standard Post with a Preview Image</a></h4>
                        <p class="text-dark-variant-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in.</p>
                        <div class="blog-info">
                          <div class="pull-md-left">
                            <time datetime="2015" class="meta fa-calendar">Feb 10, 2014</time><a href="#" class="badge fa-comments font-secondary">13</a>
                          </div><a href="blog_post.html" class="btn-link">Read More</a>
                        </div>
                      </div>
                    </article>
                  </div>
                </div>
              </div>

      </main>
   
<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>


    <!-- 링크 버튼 시작 { -->
    <div id="bo_v_bot">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->