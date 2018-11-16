<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
//    include_once(G5_THEME_MOBILE_PATH.'/head.php');
//    return;
}
global $ezra;
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/total_gallery.lib.php');

include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>
<!DOCTYPE html>
<html lang="en" class="wide wow-animation">
  <head>
    <!--Site Title-->
    <title>Home ????</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!--Stylesheets-->
    <link rel="icon" href="<?php echo G5_THEME_URL;?>/images/favicon.ico" type="image/x-icon">

    <!--Bootstrap-->
    <link rel="stylesheet" href="<?php echo G5_THEME_URL;?>/css/style.css">
		<!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/.."><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script><[endif]-->

  </head>

  <style>
#main
{
	position:absolute;
	width:100%;
	padding-top:130px;
	text-align:center}
#sound_switch{cursor:pointer}
</style>

<?php 
$youtube=array();
$product=array();
$product['url']= "ZwzY1o_hB5Y";  // 유튜브 동영상 주소 ID
$product['words']= "너희는 눈을 높이 들어 누가 이 모든 것을 창조하였나 보라<br>
				주께서는 수효대로 만상을 이끌어 내시고 그들의 모든 이름을 부르시나니<br>
				그의 권세가 크고 그의 능력이 강하므로 하나도 빠짐이 없느니라<br>
				<br>
				<h4 style=color:#ffffff;>[이사야 40:26]<br>
				<span id='sound_switch'  onclick='javascript:toggle_sound();'><i class='material-icons'>&#xe050;</i></span></h4></a>";
$product['time']="43";
array_push($youtube,$product);


$product['url']= "6D-A6CL3Pv8";  // 유튜브 동영상 주소 ID
$product['words']= "너희는 눈을 높이 들어 누가 이 모든 것을 창조하였나 보라<br>
				주께서는 수효대로 만상을 이끌어 내시고 그들의 모든 이름을 부르시나니<br>
				그의 권세가 크고 그의 능력이 강하므로 하나도 빠짐이 없느니라<br><br>
				<h4 style=color:#ffffff;>[이사야 40:26]<br>
				<span id='sound_switch'  onclick='javascript:toggle_sound();'><i class='material-icons'>&#xe050;</i></span></h4></a>";
$product['time']="43";
array_push($youtube,$product);

$product['url']= "ChOhcHD8fBA";  // 유튜브 동영상 주소 ID
$product['words']= "너희는 눈을 높이 들어 누가 이 모든 것을 창조하였나 보라<br>
				주께서는 수효대로 만상을 이끌어 내시고 그들의 모든 이름을 부르시나니<br>
				그의 권세가 크고 그의 능력이 강하므로 하나도 빠짐이 없느니라<br><br>
				<h4 style=color:#ffffff; >[이사야 40:26]<br>
				<span id='sound_switch'  onclick='javascript:toggle_sound();'><i class='material-icons'>&#xe050;</i></span></h4></a>";
$product['time']="43";
array_push($youtube,$product);

$product['url']= "1NCZ9hgjIzI";  // 유튜브 동영상 주소 ID
$product['words']= "지혜 있는 자는 궁창의 빛과 같이 빛날 것이요 <br>
					많은 사람을 옳은 데로 돌아오게 한 자는 별과 같이 영원토록 빛나리라<br><br>
				<h4 style=color:#ffffff;>[다니엘 12:3]<br>
				<span id='sound_switch'  onclick='javascript:toggle_sound();'><i class='material-icons'>&#xe050;</i></span></h4></a>";
$product['time']="170";

array_push($youtube,$product);



//echo $youtube[0]['url'];

$k=mt_rand(0, count($youtube)-1);

//echo count($youtube_url)-1;echo " / ";echo $k;
$ezra['k']=$k;
$ezra['words']=$youtube[$k]['words'];
$ezra['youtube_url']=$youtube[$k]['url'];
$ezra['youtube_time']=$youtube[$k]['time'];
?>

  <body>
    <!--The Main Wrapper-->
      <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
<div style="position:fixed; z-index: -9999; top:-10%; left: -10%; width: 100%; height: 100%">
<!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
<div id="player"></div>
</div>
<!--The Main Wrapper-->
<div class="page">
      <!--
      ========================================================
                              HEADER
      ========================================================
      -->
      <header class="well-inset-3">

            <!--RD Navbar-->
        <div class="rd-navbar-wrap  top-panel-none-items">
          <nav class="rd-navbar" data-layout="rd-navbar-fixed" data-hover-on="false" data-stick-up="false" data-sm-layout="rd-navbar-fullwidth" data-sm-device-layout="rd-navbar-fullwidth" data-md-layout="rd-navbar-static" data-md-device-layout="rd-navbar-static" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static">
            <div class="rd-navbar-inner">

              <!--RD Navbar Panel-->
              <div class="rd-navbar-panel">

                <!--RD Navbar Toggle-->
                <button data-rd-navbar-toggle=".rd-navbar" class="rd-navbar-toggle"><span></span></button>
                <!--END RD Navbar Toggle-->

                <!--RD Navbar Brand-->
                <div class="rd-navbar-brand"><a href="<?php echo G5_URL ?>/index.php"><!-- <img src="<?php echo G5_THEME_URL;?>/images/logo.png" style="width:180px" id="ezra_logo">
				
				<-->
					<div id="ezra_logo"></div></a></div>
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
            <!-- <li style="z-index:<?php echo $gnb_zindex--; ?>"> -->
            <li>
                <!-- <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a> -->
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
                    <!-- <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li> -->
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
            <li></li>
			
			 <?php if ($is_member) {  ?>
            <?php if ($is_admin) {  ?>
            <li><a href="<?php echo G5_ADMIN_URL ?>"><b>관리자모드</b></a></li>
            <?php }  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
            <?php } else {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php"><b>로그인</b></a></li>
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
    <script>

      // 2. This code loads the IFrame Player API code asynchronously.
	 var is_sound=true;
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '120%',
          width: '120%',
          videoId: "<?php echo $ezra['youtube_url'];?>",
					showinfo:"0",
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
		event.target.unMute();
		event.target.hideVideoInfo();
		event.target.seekTo(Number("<?php echo $ezra['youtube_time'];?>"),true);
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
//          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }

	function toggle_sound()
	{
		if(!is_sound){
			player.unMute();
			$("#sound_switch").html("<i class='material-icons'>&#xe050;</i>");
		}else{
			player.mute();
		$("#sound_switch").html("<i class='material-icons'>&#xe04f;</i>");
		}

		is_sound=!is_sound;
	}
    </script>

      </header>
