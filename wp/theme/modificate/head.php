<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
//    include_once(G5_THEME_MOBILE_PATH.'/head.php');
//    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/total_gallery.lib.php');

include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

$is_mobile=preg_match("/".G5_MOBILE_AGENT."/i", $_SERVER['HTTP_USER_AGENT']);
$rd_navbar_layout=$is_mobile?"rd-navbar-fixed":"rd-navbar-static";
?>
<!DOCTYPE html>
<html lang="en" class="wide wow-animation">
  <head>
    <!--Site Title-->
    <title>Home :: </title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
<!--     <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> -->
<meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Stylesheets-->
    <link rel="icon" href="<?php echo G5_THEME_URL;?>/images/favicon.ico" type="image/x-icon">

    <!--Bootstrap-->
<!--     <link rel="stylesheet" href="<?php echo G5_THEME_URL;?>/css/style.css"> -->
	<script type="text/javascript">
	console.log("admin@ezrachurch.kr:/wp/theme/modificate/head.php");
	</script>
	</head>

  <body>
    <!--The Main Wrapper-->
      <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?><!--The Main Wrapper-->
    <div class="page">
      <!--
      ========================================================
                              HEADER
      ========================================================
      -->
	  	<header class="page-header subpage_header">
        <!--RD Navbar-->
        <div class="rd-navbar-wrap  top-panel-none-items">
          <nav class="rd-navbar" data-layout="<?php echo $rd_navbar_layout;?>" data-hover-on="false" data-stick-up="false" data-sm-layout="rd-navbar-fullwidth" data-sm-device-layout="rd-navbar-fullwidth" data-md-layout="rd-navbar-static" data-md-device-layout="rd-navbar-static" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static">
            <div class="rd-navbar-inner">

              <!--RD Navbar Panel-->
              <div class="rd-navbar-panel">

                <!--RD Navbar Toggle-->
                <button data-rd-navbar-toggle=".rd-navbar" class="rd-navbar-toggle"><span></span></button>
                <!--END RD Navbar Toggle-->

                <!--RD Navbar Brand-->
                <?php
                $is_ezrabible = false;
				$array_ezrabible = array(
                	"/wp/bbs/content.php?co_id=ezrabible",
					"/wp/bbs/lecture_mylist.php",
					"/wp/bbs/board.php?bo_table=bible_01",
					"/wp/bbs/board.php?bo_table=gallery_04",
					"/wp/bbs/lecture_list.php"
                );


                $is_bsc_intro = false;
                $array_bsc_intro = array(
                	"/wp/bbs/content.php?co_id=bsc_intro",
					"/wp/bbs/board.php?bo_table=bsc_notice",
					"/wp/bbs/board.php?bo_table=bsc_edu",
					"/wp/bbs/board.php?bo_table=bsc_gallery",
					"/wp/bbs/board.php?bo_table=bsc_data"
                );
                
                $is_ezrabible = in_array($_SERVER['REQUEST_URI'], $array_ezrabible);
                $is_bsc_intro = in_array($_SERVER['REQUEST_URI'], $array_bsc_intro);
                
                if($is_ezrabible){

                printf('<div class="rd-navbar-brand"><a href="%s/index.php"><img src="%s%s" style="width:180px">',G5_URL,G5_THEME_URL,"/images/ezrabible.png");
                }else if($is_bsc_intro){

                printf('<div class="rd-navbar-brand"><a href="%s/index.php"><img src="%s%s" style="width:180px">',G5_URL,G5_THEME_URL,"/images/bsc_intro.png");
                }else{
                printf('<div class="rd-navbar-brand"><a href="%s/index.php"><img src="%s/images/logo_dark.png" style="width:180px">',G5_URL,G5_THEME_URL,G5_THEME_URL);
                }
                ?>
				
				</a></div>
                <!--END RD Navbar Brand-->
              </div>
              <!--END RD Navbar Panel-->

              <div class="rd-navbar-nav-wrap"><!--<a href="shop-cart.html" class="fa-shopping-cart"></a>-->


				<!--RD Navbar Nav-->
                <ul class="rd-navbar-nav">
                  <!--<li class="active"><a href="/">Home</a></li>-->
            <?php
            $sql = " select *
                        from {$g5['menu_table']}
                        where me_use = '1'
                          and length(me_code) = '2'
                        order by me_order, me_id ";
            $result = sql_query($sql, false);
            $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
            $menu_size=sql_num_rows($result)-1;
            for ($i=0; $row=sql_fetch_array($result); $i++) {
            ?>
            <li>
                <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" ><?php echo $row['me_name'] ?></a>
                <!--RD Navbar Dropdown-->    
                <?php
                $sql2 = " select *
                            from {$g5['menu_table']}
                            where me_use = '1'
                              and length(me_code) = '4'
                              and substring(me_code, 1, 2) = '{$row['me_code']}'
                            order by me_order, me_id ";
                $result2 = sql_query($sql2);

                for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                    if($k == 0)
                        echo '<ul class="rd-navbar-dropdown">'.PHP_EOL;
                ?>
                    <li><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a></li>
                <?php
                }

                if($k > 0){?>
                
            <?php
                    echo '</ul>'.PHP_EOL;
                }

                ?>
            </li>
            <?php if($menu_size==$i){?>
             <?php if ($is_member) {  ?>
			<li><a href="#">마이페이지</a>
			 <?php }else {  ?>
			<li><a href="#">로그인</a>
       		  <?php }  ?>
			<ul class="rd-navbar-dropdown">
             <?php if ($is_member) {  ?>
            <?php if ($is_admin) {  ?>
            <li><a href="<?php echo G5_ADMIN_URL ?>"><b>관리자모드</b></a></li>
            <?php }  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
            <?php } else {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php?url=<?php echo $_SERVER['REQUEST_URI'];?>"><b>로그인</b></a></li>
            <?php } /* ?>
            <li><a href="<?php echo G5_BBS_URL ?>/qalist.php">목사님께 질문</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/current_connect.php">접속자 <?php echo connect('theme/basic'); // 현재 접속자수, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정  ?></a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/new.php">새글</a></li>
            </ul></li>
            <?php */} ?>
            <?php
            }
            if ($i == 0) {  ?>
                <li id="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
            <?php } ?>
                <!--END RD Navbar Nav-->

              </div>
            </div>
          </nav>
        </div>
        <!--END RD Navbar-->
		<!-- 페이지마다 바뀌는 헤더 구성 -->

		<?php 
		
		$h1 ="No Title";
		$h2 = "...";
		$h3 = "bg_03.jpg";
		$nav = "";
		$is_search=false;
		$SCRIPT_NAME=$_SERVER['SCRIPT_NAME'];
		if(strpos($SCRIPT_NAME,"search.php") !== false)
		{
			$k="";
				if(isset($_GET['k'])&&strlen($_GET['k'])>0)
				{
					$k=$_GET['k'];
				}
				$h1 = "검색 결과 ".$k; 
				$h2 = "에스라가 여호와의 율법을 연구하여 준행하며 율례와 규례를 이스라엘에게 가르치기로 결심하였었더라<br>에스라 7:10"; 
				$h3 = "bg_02.jpg";
				$nav = "말씀";		
				$is_search=true;
		}
		
		if($bo_table) {

			$h1 = $board['bo_subject'];
			$h2 = $group['gr_1'];
			$h3 = $group['gr_2'];

		}else { 


			if($co_id == "about")		{ 
				$h1 = "교회 소개"; 
				$h2 = "성경 읽는 교회, 가르치는 교회, 전파하는 교회, 치료하는 교회"; 
				$h3 = "bg_01.jpg";
				$nav = "서울에스라교회";
			}

			if($co_id == "history")	{ 
				$h1 = "교회 연혁"; 
				$h2 = "성경 읽는 교회, 가르치는 교회, 전파하는 교회, 치료하는 교회"; 
				$h3 = "bg_01.jpg";
				$nav = "서울에스라교회";
				} 

			if($co_id == "helper")	{
				$h1 = "섬기는 이";
				$h2 = "성경 읽는 교회, 가르치는 교회, 전파하는 교회, 치료하는 교회"; 
				$h3 = "bg_01.jpg";	
				$nav = "서울에스라교회";
				
				}

			if($co_id == "program")	{ 
				$h1 = "예배시간 안내"; 
				$h2 = "성경 읽는 교회, 가르치는 교회, 전파하는 교회, 치료하는 교회"; 
				$h3 = "bg_01.jpg";
				$nav = "서울에스라교회";

				}

			if($co_id == "location") {
				$h1 = "찾아 오시는 길";
				$h2 = "성경 읽는 교회, 가르치는 교회, 전파하는 교회, 치료하는 교회"; 
				$h3 = "bg_01.jpg";
				$nav = "서울에스라교회";

				}

			if($co_id == "sponser") { 
				$h1 ="후원 안내";
				$h2 = "너는 마음을 다하고 뜻을 다하고 힘을 다하여 네 하나님 여호와를 사랑하라 (신6:5)";
				$h3 = "bg_ezrabible.jpg";
				$nav = "에스라성서원";

				}

			if($co_id == "ezrabible") { 
				$h1 ="에스라성서원";
				$h2 = "에스라성서원은 에스라성경강좌를 통해서 성경 66권을 가르치는 사역원으로,<br>2007년 2월부터 시작하여 지금까지 지속적인 사역중에 있습니다.";
				$h3 = "bg_ezrabible.jpg";
				$nav = "에스라성서원";

			}

			if($co_id == "bsc_intro") { 
				$h1 ="에스라바이블스쿨 소개";
				$h2 = "에스라바이블스쿨은 위탁 교육을 의존하지 않고 성경 66권을 중심으로 부모와 자녀가 교회와 가정에서 함께 경건과 지력와 체력을 훈련하는 교육입니다.";
				$h3 = "bg_bsc.jpg";
				$nav = "에스라바이블스쿨";

			}
			

			$now_page_name = basename($_SERVER['PHP_SELF'],".php");

			if($now_page_name == "faq") {
				$h1 ="자주 묻는 질문";
				$h2 = "모든 성경은 하나님의 감동으로 된 것으로 교훈과 책망과 바르게 함과 의로 교육하기에 유익하니 [디모데후서 3장 16절]";
				$h3 = "bg_03.jpg";
			}

			if($now_page_name == "register" or $now_page_name == "register_form") {
				$h1 ="회원가입";
//				$h2 = "모든 성경은 하나님의 감동으로 된 것으로 교훈과 책망과 바르게 함과 의로 교육하기에 유익하니 [디모데후서 3장 16절]";
				$h3 = "header-6.jpg";
			}


			if($now_page_name == "lecture_list"||$now_page_name == "lecture_write") {
				$h1 ="강좌 참가 신청하기";
				$h2 = "에스라성서원은 에스라성경강좌를 통해서 성경 66권을 가르치는 사역원으로,<br>2007년 2월부터 시작하여 지금까지 지속적인 사역중에 있습니다.";
				$h3 = "bg_ezrabible.jpg";
				$nav = "에스라성서원";

			}


			 if($now_page_name == "lecture_mylist") {
				$h1 ="강좌 접수 확인";
				$h2 = "에스라성서원은 에스라성경강좌를 통해서 성경 66권을 가르치는 사역원으로,<br>2007년 2월부터 시작하여 지금까지 지속적인 사역중에 있습니다.";
				$h3 = "bg_ezrabible.jpg";
				$nav = "에스라성서원";

			 }


			 if($pr_list == "lecture_01") {
				$h1 ="주일 대하 설교";
				$h2 = "주의 말씀은 내 발에 등이요 내 길에 빛이니이다 [시편 119장 105절]";
				$h3 = "bg_02.jpg";
				$nav = "말씀";

			 }


			 if($pr_list == "lecture_02") {
				$h1 ="외부 강사 설교";
				$h2 = "주의 말씀은 내 발에 등이요 내 길에 빛이니이다 [시편 119장 105절]";
				$h3 = "bg_02.jpg";
				$nav = "말씀";

			 }


			 if($pr_list == "edu_01") {
				$h1 ="웨스트민스터 신앙고백서 강해";
				$h2 = "모든 성경은 하나님의 감동으로 된 것으로 교훈과 책망과 바르게 함과 의로 교육하기에 유익하니 [디모데후서 3장 16절]";
				$h3 = "bg_03.jpg";
				$nav = "교육";

			 }


			 if($pr_list == "edu_02") {
				$h1 ="새가족교육 11주차";
				$h2 = "모든 성경은 하나님의 감동으로 된 것으로 교훈과 책망과 바르게 함과 의로 교육하기에 유익하니 [디모데후서 3장 16절]";
				$h3 = "bg_03.jpg";
				$nav = "교육";

			 }


			 if($pr_list == "edu_03") {
				$h1 ="칼빈의 제네바 시편 찬송가 배우기";
				$h2 = "모든 성경은 하나님의 감동으로 된 것으로 교훈과 책망과 바르게 함과 의로 교육하기에 유익하니 [디모데후서 3장 16절]";
				$h3 = "bg_03.jpg";
				$nav = "교육";

			 }

}
		?>

        <section>
          <!--Swiper-->
          <div data-autoplay="5000" data-slide-effect="fade" data-loop="false" class="swiper-container swiper-slider">
            <div class="jumbotron text-center">
              <h1><?php echo $h1; ?><h6><?php echo $h2; ?></h6></h1>
              <p class="big"></p>
            </div>
            <div class="swiper-wrapper"> 
				<div data-slide-bg="<?php echo G5_THEME_URL;?>/images/<?php echo $h3; ?>" class="swiper-slide">
                <div class="swiper-slide-caption"></div>
              </div>
            </div>
          </div>
        </section>
      </header>
<!-- 네비게이션 상태 표시 -->
<?php if($bo_table || $co_id || $pr_list || $now_page_name) { ?>

	     <ol class="breadcrumb section-border" id="navsubject">
          <li class="active">홈페이지</li>
  		  <?php if($group['gr_subject'] or $nav) { ?>
		  <li class="active">
		<?php
		  echo $group['gr_subject']; 
			echo $nav;
			?></li> <?php } ?>
          <li class="active">
		  <?php if($board['bo_subject']) {
		  echo $board['bo_subject'];
			  } else {
				  echo $h1;
			  }
		  ?></li>
        </ol>

		<?php } 

?>