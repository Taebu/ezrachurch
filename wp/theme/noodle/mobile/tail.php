<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
    </div>
</div>

<hr>

<?php echo poll('theme/basic'); // 설문조사 ?>

<hr>

<div id="ft">
    <div id="ft_info">
        <div id="ft_company" class="col-xs-6 col-sm-6 col-md-3 ft_div">
            <h2>회사정보</h2>
            <p class="ft_info">TEL. 00-000-0000 <br>FAX. 00-000-0000 <br>서울 강남구 강남대로 1 <br>
            대표:홍길동 <br>사업자등록번호:000-00-00000 <br> 개인정보관리책임자:홍길동</p>
        </div>
        <div id="ft_link" class="col-xs-6 col-sm-6 col-md-3 ft_div">
            <h2>링크 바로가기</h2>
            <ul>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company">회사소개  <i class="fa fa-angle-right"></i></a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보취급방침  <i class="fa fa-angle-right"></i></a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">서비스이용약관  <i class="fa fa-angle-right"></i></a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=contact">찾아오시는 길 <i class="fa fa-angle-right"></i></a></li>
            </ul>  
        </div>
        <div id="ft_search" class="col-xs-6 col-sm-6 col-md-3 ft_div">
            <h2>사이트 내 전체검색</h2>
            <form name="fsearchbox" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);" method="get">
            <input type="hidden" name="sfl" value="wr_subject||wr_content">
            <input type="hidden" name="sop" value="and">
            <input type="text" name="stx" id="sch_stx" placeholder="검색어(필수)" required class="required" maxlength="20">
            <input type="submit" value="검색" id="sch_submit">
            </form>

            <script>
            function fsearchbox_submit(f)
            {
                if (f.stx.value.length < 2) {
                    alert("검색어는 두글자 이상 입력하십시오.");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                var cnt = 0;
                for (var i=0; i<f.stx.value.length; i++) {
                    if (f.stx.value.charAt(i) == ' ')
                        cnt++;
                }

                if (cnt > 1) {
                    alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                return true;
            }
            </script>
        </div>  
        <div id="ft_customer" class="col-xs-6 col-sm-6 col-md-3 ft_div">
            <h2>고객센터</h2>
            <span>1234-1234</span><br>
            <span>월~금 10:00 ~ 18:00 (토/일/공휴일휴무)</span>
            <ul class="ft_sns">
                <li><a href="https://www.facebook.com/" target="_blank"><i class="fa fa-2x fa-facebook-square"></i></a></li>
                <li><a href="https://twitter.com/" target="_blank"><i class="fa fa-2x fa-twitter-square"></i></a></li>
                <li><a href="https://www.google.co.kr/?gws_rd=ssl" target="_blank"><i class="fa fa-2x fa-google-plus-square"></i></a></li>
                <li><a href="http://instagram.com/" target="_blank"><i class="fa fa-2x fa-instagram"></i></a></li>
            </ul>
        </div>
        
    </div>
    <div id="ft_copy" class="col-lg-12 text-center">
        Copyright &copy; <b>소유하신 도메인.</b> All rights reserved.<button id="top_btn"><span class="sound_only">상단으로</span><i class="fa fa-arrow-up"></i></button>
    </div>
</div>

<script>
$(function() {
    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>


<?php
if(G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
<a href="<?php echo get_device_change_url(); ?>" id="device_change">PC 버전으로 보기</a>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>