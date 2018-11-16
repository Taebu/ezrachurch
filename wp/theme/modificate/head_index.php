<?php
/*
file location : admin@ezrachurch.kr:/wp/theme/modificate/head_index.php
http url :  ezrachurch.kr/wp/theme/modificate/head_index.php
*/

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
$is_mobile=preg_match("/".G5_MOBILE_AGENT."/i", $_SERVER['HTTP_USER_AGENT']);
$rd_navbar_layout=$is_mobile?"rd-navbar-fixed":"rd-navbar-static";
?>
<!DOCTYPE html>
<html lang="en" class="wide wow-animation">
  <head>
    <!--Site Title-->
    <title>Home ????</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
<!--     <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="https://jquery-ui-bootstrap.github.io/jquery-ui-bootstrap/assets/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>

    <!--Stylesheets-->
    <link rel="icon" href="<?php echo G5_THEME_URL;?>/images/favicon.ico" type="image/x-icon">
<script type="text/javascript">
var is_snow=false;
 		$(document).ready(function(){
			/* 눈내리기 
			2018-01-11 (목) 20:51:27 
			*/
			if(is_snow)
			$('#youtube_player').snowfall({image:'/wp/images/flake.png',round : true, minSize: 5, maxSize:32});
		  $("#sound_switch").hover(function() {console.log("hover");},function() {console.log("leave");});

		});

</script>
    <!--Bootstrap-->
    <link rel="stylesheet" href="<?php echo G5_THEME_URL;?>/css/style.css">
		<!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/.."><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script><[endif]-->

</head>
<style>
#main{position:absolute;left:1%;width:98%;padding-top:130px;text-align:center;}

#sound_switch{cursor:pointer;font-size: initial;}

.video-ads{display: none;}	

@media (min-width: 768px) {
  #slider-range{width:15%}
}

@media (max-width: 769px) {
  #slider-range{width:80%}
}

#youtube_player{position:fixed;z-index:-9999;top:-10%;left:-10%;width:100%;height:110%;}

</style>
  <body>
    <!--The Main Wrapper-->
      <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>



    





<?php if($status=="obituary"){ ?>
  <div id="youtube_player" style="filter: blur(25px);">
<?php }else{ ?>
  <div id="youtube_player">
<?php } ?>

			<!-- <iframe id="myVideo" frameborder="0" width="120%" height="120%" src="https://www.youtube.com/embed/<?php echo $youtube[$k]['url'];?>?autoplay=1&controls=0&loop=1&rel=0&showinfo=0&autohide=1&wmode=transparent&start=<?php echo $youtube[$k]['time'];?>"></iframe> -->
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
          <nav class="rd-navbar" data-layout="<?php echo $rd_navbar_layout;?>" data-hover-on="false" data-stick-up="false" data-sm-layout="rd-navbar-fullwidth" data-sm-device-layout="rd-navbar-fullwidth" data-md-layout="rd-navbar-static" data-md-device-layout="rd-navbar-static" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static">
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
<script type="text/javascript">
var rangeSlider;
var rangeSliderValueElement;

var youtube_uri=[];
var key=0;

function get_youtube_url()
{
	$.ajax({
		url:"/ajax/get_youtubemain.php",
		dataType:'json',
		success:function(data){

			$.each(data.posts,function(key,val){
				console.log(val);
				var youtube_urls={};
				youtube_urls.url=val.ym_link;
				youtube_urls.words=val.ym_content.replace(/\n/g, "<br />");
				youtube_urls.time=val.ym_time;
				youtube_uri.push(youtube_urls);

			});
			
			key = Math.floor((Math.random() * youtube_uri.length));
		}
	});
}
get_youtube_url();

var btn_switch="<span id='sound_switch'  onclick='javascript:toggle_sound();'><font style=color:#fff><i class='material-icons'>&#xe050;</i></font></span><br><span id='volume'></span></h4></a>";
btn_switch+="<div class='row'><div id=\"slider-range\" class=\"col-md-2 col-md-offset-5 col-xs-10 col-xs-offset-2 col-lg-2 col-lg-offset-5 col-sm-2 col-sm-offset-5\"></div></div>";        


  

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
          videoId: youtube_uri[key].url,
					showInfo:"1",
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange,
						'onError':onPlayerError
          }
        });


      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        var is_mobile=detectmob();
				console.log(event);
				console.log(event.target);
					event.target.playVideo();
							event.target.hideVideoInfo();
				if(!is_mobile){
				//	event.target.playVideo();
				}else{
//					player.stopVideo();
				}
				
//		event.target.unMute();
		event.target.setVolume(getCookie("volume"));
		event.target.seekTo(Number(youtube_uri[key].time),true);
		vs=getCookie("volume");
  $("#h3_words").html(youtube_uri[key].words+btn_switch);

  if(vs>49){
		$(".material-icons").html("&#xe050;");
	}else if (vs>30){
		$(".material-icons").html("&#xe04d;");
	}else if (vs>0){
		$(".material-icons").html("&#xe04e;");
	}else if (vs<=0){
		$(".material-icons").html("&#xe04f;");
	}


rangeSlider = document.getElementById('slider-range');
noUiSlider.create(rangeSlider, {
	start: [getCookie("volume")],
	connect:[true,false],
	range: {
		'min': [ 0 ],
		'max': [ 100 ]
	}
});

rangeSliderValueElement = document.getElementById('slider-range-value');

rangeSlider.noUiSlider.on('update', function( values, handle ) {
	//	rangeSliderValueElement.innerHTML = values[handle];
	var vol=Math.floor(values[handle]);
	console.log(vol);
	$("#volume").html(vol);  
	player.setVolume(vol);
	setCookie("volume", vol,365);

  if(vol>49){
    $(".material-icons").html("&#xe050;");
  }else if (vol>30){
    $(".material-icons").html("&#xe04d;");
  }else if (vol>0){
    $(".material-icons").html("&#xe04e;");
  }else if (vol<=0){
    $(".material-icons").html("&#xe04f;");
  }


});

      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
		  console.log(event);
		  console.log(event.data);
							event.target.hideVideoInfo();
        if (event.data == YT.PlayerState.ENDED) {
//          setTimeout(stopVideo, 6000);
//                     endSeconds:,
	  key = Math.floor((Math.random() * youtube_uri.length));
			player.loadVideoById({videoId:youtube_uri[key].url,
                     startSeconds:Number(youtube_uri[key].time),

                     suggesteQduality:"default"});
			/**/

				$(".close-padding").click();
				document.querySelector(".close-padding").click();
				document.getElementsByClassName("ytp-iv-video-content")[0].innerHTML="";
 			
		        $("#h3_words").html(youtube_uri[key].words+btn_switch);
          //done = true;

        }
      
	  
	  }
      function stopVideo() {
        player.stopVideo();
      }

	function toggle_sound()
	{
		if(!is_sound){
			vs=temp_vs;
      player.unMute();
			$("#sound_switch").html("<font style=color:#fff>배경음악 끄기<br><i class='material-icons'>&#xe050;</i></font>");
			$("#volume").html(temp_vs);
			//rangeSlider.noUiSlider.set(temp_vs);
			rangeSlider.removeAttribute('disabled');
    }else{
			temp_vs=player.getVolume();
      player.mute();
			$("#sound_switch").html("<font style=color:#fff>배경음악 켜기<br><i class='material-icons'>&#xe04f;</i></font>");
			vs=0;
			$("#volume").html("0");
			//rangeSlider.noUiSlider.set(0);
			rangeSlider.setAttribute('disabled', true);
		}
	
		
		is_sound=!is_sound;
	}
	var main_index=0;
  function toggle_hidemain()
  {
    if(main_index%3==0)
    {
      $("#main").hide();
    }else if(main_index%3==1){
			$(".rd-navbar-wrap").hide();
		}else if(main_index%3==2){
      $("#main").show();
			$(".rd-navbar-wrap").show();
    }
		main_index++;
  }
	
	function onPlayerError(event)
	{
		console.log(event);
	}
document.onkeydown = checkKey;
var vs=0;
var temp_vs=0;
var is_cheatkey=false;
var array_key=[];
var pos_index=1;
function checkKey(e) 
{
	/*
	jejudo
	J = 74
	E = 69
	J = 74
	U = 85
	D = 68
	O = 79
	*/
	
  e = e || window.event;
  console.log(e.keyCode);
	
	if(e.keyCode=="77"){
		toggle_sound();
		return;
	}
	
	/* esc 키 눌렀을때 */
	if(e.keyCode=="27"){
			/* 눈그치기*/
			if(is_snow){
				$('#youtube_player').snowfall('clear');
				is_snow=false;
			}else{
				$('#youtube_player').snowfall({image:'/wp/images/flake.png',round : true, minSize: 5, maxSize:32});
				is_snow=true;

			}
			
			return;
	}
	if(!is_sound){
		$("#volume").html("음소거중 입니다.'m'키나 '음소거 아이콘'을 눌러 주세요.");
		return;
	}

  if(e.keyCode==72){
    toggle_hidemain();
  }else if(pos_index==1&&e.keyCode=='74'){
		pos_index++;
		console.log("j");
	}else if(pos_index==2&&e.keyCode=='69'){
		pos_index++;
		console.log("e");
	}else if(pos_index==3&&e.keyCode=='74'){
		pos_index++;
		console.log("j");
	}else if(pos_index==4&&e.keyCode=='85'){
		pos_index++;
		console.log("u");
	}else if(pos_index==5&&e.keyCode=='68'){
		pos_index++;
		console.log("d");
	}else if(pos_index==6&&e.keyCode=='79'){
		pos_index=1;
		is_cheatkey=true;
		console.log("o");
	}else{
		pos_index=1;
		console.log("fail");
	}
	
	if(is_cheatkey)
	{
		player.stopVideo();
		player.loadVideoById({videoId:"PSPiH2bapEk",
		startSeconds:0,
		suggesteQduality:"default"});
		$("#h3_words").html("제주도 3박 4일<br> 2017-08-13 16");
		is_cheatkey=false;
		
	}
	if(e.keyCode=='38'){
		console.log(e.keyCode);
		vs=player.getVolume();
		vs++;
		player.setVolume(vs);

	}else if(e.keyCode=='40'){
		console.log(e.keyCode);
		vs=player.getVolume();
		vs--;
		player.setVolume(vs);
	}else{
    $("#volume").html(player.getVolume());  
  }

	
	if(vs>49){
		$(".material-icons").html("&#xe050;");
	}else if (vs>30){
		$(".material-icons").html("&#xe04d;");
	}else if (vs>0){
		$(".material-icons").html("&#xe04e;");
	}else if (vs<=0){
		$(".material-icons").html("&#xe04f;");
	}


	//setTimeout('$("#volume").html("")', 3000); 
	setCookie("volume", vs,365);
	rangeSlider.noUiSlider.set(vs);
	$("#volume").html(player.getVolume());
  

}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}
/* var is_mobile =detectmob();*/
function detectmob() { 
 if( navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPad/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i)
 ){
    return true;
  }
 else {
    return false;
  }
}

		</script>

      </header>