<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/head.php');
    return;
}

// 상단 파일 경로 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($config['cf_include_head']) {
    if (!@include_once($config['cf_include_head'])) {
        die('기본환경 설정에서 상단 파일 경로가 잘못 설정되어 있습니다.');
    }
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}
?>

<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/logo.jpg" alt="처음으로"></a>
        </div>

        <fieldset id="sch_all">
            <legend>사이트 내 전체검색</legend>
            <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
            <input type="hidden" name="sfl" value="wr_subject||wr_content">
            <input type="hidden" name="sop" value="and">
            <label for="sch_all_stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="stx" id="sch_all_stx" maxlength="20">
            <input type="submit" id="sch_all_submit" value="검색">
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
        </fieldset>

        <ul id="tnb">
            <?php if ($is_member) {  ?>
            <?php if ($is_admin) {  ?>
            <li>
                <a href="<?php echo G5_ADMIN_URL ?>">
                    <img src="<?php echo G5_IMG_URL ?>/tnb_admin.jpg" alt="">
                    관리자
                </a>
            </li>
            <?php }  ?>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">
                    <img src="<?php echo G5_IMG_URL ?>/tnb_modify.jpg" alt="">
                    내 정보
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/logout.php">
                    <img src="<?php echo G5_IMG_URL ?>/tnb_logout.jpg" alt="">
                    로그아웃
                </a>
            </li>
            <?php } else {  ?>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/register.php">
                    <img src="<?php echo G5_IMG_URL ?>/tnb_join.jpg" alt="">
                    회원가입
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/login.php">
                    <img src="<?php echo G5_IMG_URL ?>/tnb_login.jpg" alt="">
                    로그인
                </a>
            </li>
            <?php }  ?>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/qalist.php">
                    <img src="<?php echo G5_IMG_URL ?>/tnb_cnt.jpg" alt="">
                    1:1문의
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/current_connect.php">
                    <img src="<?php echo G5_IMG_URL ?>/tnb_cnt.jpg" alt="">
                    접속자 <?php echo connect(); // 현재 접속자수  ?>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/new.php">
                    <img src="<?php echo G5_IMG_URL ?>/tnb_new.jpg" alt="">
                    새글
                </a>
            </li>
        </ul>

    </div>

    <hr>

    <nav id="gnb">
        <script>$('#gnb').addClass('gnb_js');</script>
        <h2>메인메뉴</h2>
        <ul id="gnb_1dul">
            <?php
            $sql = " select * from {$g5['group_table']} where gr_show_menu = '1' and gr_device <> 'mobile' order by gr_order ";
            $result = sql_query($sql);
            for ($gi=0; $row=sql_fetch_array($result); $gi++) { // gi 는 group index
             ?>
            <li class="gnb_1dli">
                <a href="<?php echo G5_BBS_URL ?>/group.php?gr_id=<?php echo $row['gr_id'] ?>" class="gnb_1da"><?php echo $row['gr_subject'] ?></a>
                <ul class="gnb_2dul">
                    <?php
                    $sql2 = " select * from {$g5['board_table']} where gr_id = '{$row['gr_id']}' and bo_show_menu = '1' and bo_device <> 'mobile' order by bo_order ";
                    $result2 = sql_query($sql2);
                    for ($bi=0; $row2=sql_fetch_array($result2); $bi++) { // bi 는 board index
                     ?>
                    <li class="gnb_2dli"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row2['bo_table'] ?>" class="gnb_2da"><?php echo $row2['bo_subject'] ?></a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($gi == 0) {  ?><li class="gnb_empty">생성된 메뉴가 없습니다.</li><?php }  ?>
        </ul>
    </nav>

</div>
<!-- } 상단 끝 -->

<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <div id="aside">
        <?php echo outlogin('basic'); // 외부 로그인  ?>
        <?php echo poll('basic'); // 설문조사  ?>
    </div>
    <div id="container">
        <?php if ((!$bo_table || $w == 's' ) && !defined("_INDEX_")) { ?><div id="container_title"><?php echo $g5['title'] ?></div><?php } ?>
        <div id="text_size">
            <!-- font_resize('엘리먼트id', '제거할 class', '추가할 class'); -->
            <button id="text_size_down" onclick="font_resize('container', 'ts_up ts_up2', '');"><img src="<?php echo G5_URL; ?>/img/ts01.gif" alt="기본"></button>
            <button id="text_size_def" onclick="font_resize('container', 'ts_up ts_up2', 'ts_up');"><img src="<?php echo G5_URL; ?>/img/ts02.gif" alt="크게"></button>
            <button id="text_size_up" onclick="font_resize('container', 'ts_up ts_up2', 'ts_up2');"><img src="<?php echo G5_URL; ?>/img/ts03.gif" alt="더크게"></button>
        </div>