<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<header id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div class="to_content"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
    } ?>
    <nav id="gnb" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <h2>최상단 고정 카테고리</h2>
        <!-- 상단 기본 고정 메뉴 -->
        <ul class="hd_top_nav">
            <?php if ($is_member) { ?>
            <?php if ($is_admin) { ?>
            <li><a href="<?php echo G5_ADMIN_URL ?>" id="snb_adm"><i class="fa fa-cog fa-spin"></i> <b>관리자</b></a></li>
            <?php } ?>
            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" id="snb_modify"><i class="fa fa-pencil-square-o"></i> 정보수정</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php" id="snb_logout"><i class="fa fa-sign-out"></i> 로그아웃</a></li>
            <?php } else { ?>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php" id="snb_join"><i class="fa fa-certificate"></i> 회원가입</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php" id="snb_login"><i class="fa fa-sign-in"></i> 로그인</a></li>
            <?php } ?>
        </ul>
        <!-- 로고 -->
        <div class="logo text-center">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL; ?>/img/logo.png" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>
        <!-- 모바일 메뉴 버튼 -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- 메뉴바 -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="container">
                <ul id="gnb_1dul" class="nav navbar-nav text-center">
                <?php
                $sql = " select *
                            from {$g5['menu_table']}
                            where me_mobile_use = '1'
                              and length(me_code) = '2'
                            order by me_order, me_id ";
                $result = sql_query($sql, false);

                for($i=0; $row=sql_fetch_array($result); $i++) {
                ?>
                    <li class="dropdown gnb_1dli">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
                        <?php
                        $sql2 = " select *
                                    from {$g5['menu_table']}
                                    where me_mobile_use = '1'
                                      and length(me_code) = '4'
                                      and substring(me_code, 1, 2) = '{$row['me_code']}'
                                    order by me_order, me_id ";
                        $result2 = sql_query($sql2);

                        for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                            if($k == 0) {
                                echo '<button class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-angle-down fa-fw"></i> <span class="sound_only">분류보기</span></button>'.PHP_EOL;
                                echo '<ul class="dropdown-menu gnb_2dul">'.PHP_EOL;
                            }
                        ?>
                            <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><span></span><?php echo $row2['me_name'] ?></a></li>
                        <?php
                        }

                        if($k > 0)
                            echo '</ul>'.PHP_EOL;
                        ?>
                    </li>
                <?php
                }
                if ($i == 0) {  ?>
                    <li id="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하세요.<?php } ?></li>
                <?php } ?>
                </ul>
            </div>

            <!-- 디바이스 변동시 바뀌는 메뉴 -->
            <ul id="device_auto" class="nav navbar-nav">
            <?php
            $sql = " select *
                        from {$g5['menu_table']}
                        where me_mobile_use = '1'
                          and length(me_code) = '2'
                        order by me_order, me_id ";
            $result = sql_query($sql, false);

            for($i=0; $row=sql_fetch_array($result); $i++) {
            ?>
                <li class="active dropdown">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
                    <button class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-angle-down fa-fw"></i> <span class="sound_only">분류보기</span></button>
                    <?php
                    $sql2 = " select *
                                from {$g5['menu_table']}
                                where me_mobile_use = '1'
                                  and length(me_code) = '4'
                                  and substring(me_code, 1, 2) = '{$row['me_code']}'
                                order by me_order, me_id ";
                    $result2 = sql_query($sql2);

                    for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                        if($k == 0)
                            echo '<ul class="dropdown-menu" role="menu">'.PHP_EOL;
                    ?>
                        <li class="s_li"><a class="a_hv" href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><span></span><?php echo $row2['me_name'] ?></a></li>
                    <?php
                    }

                    if($k > 0)
                        echo '</ul>'.PHP_EOL;
                    ?>
                </li>
            <?php
            }

            if ($i == 0) {  ?>
                <li id="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하세요.<?php } ?></li>
            <?php } ?>
            </ul>
        </div>
    </nav>


        <!-- <ul id="hd_nb">
            <li><a href="<?php echo G5_BBS_URL ?>/qalist.php" id="snb_new">1:1문의</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/faq.php" id="snb_faq">FAQ</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/current_connect.php" id="snb_cnt">접속자 <?php echo connect('theme/basic'); // 현재 접속자수 ?></a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/new.php" id="snb_new">새글</a></li>
            <?php if ($is_member) { ?>
            <?php if ($is_admin) { ?>
            <li><a href="<?php echo G5_ADMIN_URL ?>" id="snb_adm"><b>관리자</b></a></li>
            <?php } ?>
            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" id="snb_modify">정보수정</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php" id="snb_logout">로그아웃</a></li>
            <?php } else { ?>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php" id="snb_join">회원가입</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php" id="snb_login">로그인</a></li>
            <?php } ?>
        </ul> -->
    </div>
</header>

<div id="wrapper">
    <div id="aside">
        <?php echo outlogin('theme/basic'); // 외부 로그인 ?>
    </div>
    <div id="container">
        <?php if ((!$bo_table || $w == 's' ) && !defined("_INDEX_")) { ?><div id="container_title"><?php echo $g5['title'] ?></div><?php } ?>





        header.php
