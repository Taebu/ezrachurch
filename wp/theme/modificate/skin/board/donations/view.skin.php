<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

      <main class="page-content">

        <section class="well well-inset-2">
          <div class="container">

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->
<div id="bo_v_table"><?php echo $board['bo_subject']; ?></div>

<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h1 id="bo_v_title">
            <?php
            if ($category_name) echo $view['ca_name'].' | '; // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h1>
    </header>

    <section id="bo_v_info">
        <h2>페이지 정보</h2>
        작성자 <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
        <span class="sound_only">작성일</span><strong><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
        조회<strong><?php echo number_format($view['wr_hit']) ?>회</strong>
        댓글<strong><?php echo number_format($view['wr_comment']) ?>건</strong>
    </section>

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

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
         ?>
<table  class="table table-border table-mobile mobile-primary">
              <colgroup>
                <col class="hidden-xs         col-sm-1 col-lg-1 col-md-1">
                <col class="col-xs-6 col-sm-5 col-lg-5 col-md-5">
                <col class="hidden-xs         col-sm-1 col-lg-1 col-md-1">
                <col class="hidden-xs         col-sm-2 col-lg-2 col-md-2">
                <col class="col-xs-6 col-sm-3 col-lg-3 col-md-3">
              </colgroup>
<tr>
	<th class="hidden-xs">비고</th>
	<th>항목</th>
	<th class="hidden-xs">인당</th>
	<th class="hidden-xs">예상인원</th>
	<th>합계</th>
</tr>

<tr>
	<td class="hidden-xs">숙박비</td>
	<td><input type="button" class="btn btn-primary btn-xs round-small" value="소돌펜션" onclick="javascript:set_donation_value(this.value);"></td>
	<td class="hidden-xs"></td>
	<td class="hidden-xs"></td>
	<td>800,000원</td>
</tr>
<tr>
	<td class="hidden-xs">교통비</td>
	<td><input type="button" class="btn btn-primary btn-xs round-small" value="유류비" onclick="javascript:set_donation_value(this.value);"></td>
	<td class="hidden-xs"></td>
	<td class="hidden-xs"></td>
	<td>160,000원</td>
</tr>
<tr>
	<td class="hidden-xs" rowspan=7>식비</td>
	<td>
			<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="장안횟집(물회맛집)" onclick="javascript:set_donation_value(this.value);"></td>
		  </td>
	<td class="hidden-xs">16,000원</td>
	<td class="hidden-xs">15</td>
	<td>240,000원</td>
</tr>
<tr>
	<td>
			<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="삼교리 동치미 막국수(막국수 맛집)" onclick="javascript:set_donation_value(this.value);"></td>
	<td class="hidden-xs">8,000원</td>
	<td class="hidden-xs">15 	 </td>
	<td>120,000원</td>
</tr>
<tr>
	<td>
			<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="대영유통(대게 맛집)" onclick="javascript:set_donation_value(this.value);">
	</td>
	<td class="hidden-xs">30,000원</td>
	<td class="hidden-xs">15</td>
	<td>450,000원</td>
</tr>
<tr>
	<td><input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="돌아오는 수요일 점심" onclick="javascript:set_donation_value(this.value);"></td>
	<td class="hidden-xs">8,000원</td>
	<td class="hidden-xs">15</td>
	<td>120,000원</td>
</tr>
<tr>
	<td>
			<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="박이추 커피" onclick="javascript:set_donation_value(this.value);">
	</td>
	<td class="hidden-xs">5,000원</td>
	<td class="hidden-xs">15</td>
	<td>75,000원</td>
</tr>
<tr>
	<td>
		<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="야식(치킨)" onclick="javascript:set_donation_value(this.value);"></td>
	<td class="hidden-xs"></td>
	<td class="hidden-xs"></td>
	<td>120,000원</td>
</tr>
<tr><td><input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="간식 및 아침(3일) 및 저녁하루" onclick="javascript:set_donation_value(this.value);"></td>
	<td class="hidden-xs"></td>
	<td class="hidden-xs"></td>
	<td> 200,000원</td>
</tr>
<tr>
	<td  class="hidden-xs" rowspan=5>입장료</td>
	<td><input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="주문진 유람선" onclick="javascript:set_donation_value(this.value);"></td>
	<td class="hidden-xs">18,000원</td>
	<td class="hidden-xs">15</td>
	<td>270,000원</td>
</tr>
<tr>
	<td>
	<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="부채길 투어" onclick="javascript:set_donation_value(this.value);">
	</td>
	<td class="hidden-xs">3,000원</td>
	<td class="hidden-xs">15</td>
	<td>45,000원</td>
</tr>
<tr>
	<td>
	<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="설악산 국립공원" onclick="javascript:set_donation_value(this.value);">
	</td>
	<td class="hidden-xs">-</td>
	<td class="hidden-xs">-</td>
	<td>200,000원</td>
</tr>
<tr>
	<td>
	<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="내린천 래프팅" onclick="javascript:set_donation_value(this.value);"></td>
	<td class="hidden-xs">20,000원</td>
	<td class="hidden-xs">15</td>
	<td>300,000원</td>
</tr>
<tr>
	<td>
	<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="카트" onclick="javascript:set_donation_value(this.value);"></td></td>
	<td class="hidden-xs"></td>
	<td class="hidden-xs"></td>
	<td class="hidden-xs"></td>
	<td>?</td>
</tr>
</table>
</pre>
<input type="hidden" name="wr_id" id="wr_id" value="<?php echo  $view['wr_id'];?>">
<input type="hidden" name="wr_1" id="wr_1" value="<?php echo $view['wr_1'];?>">

<input type="hidden" name="bo_table" id="bo_table" value="<?php echo $board['bo_table'];?>">
<input type="hidden" name="mb_name" id="mb_name" value="<?php echo $member['mb_name'];?>">
<?php

function days_diff($d1, $d2) {
    $x1 = days($d1);
    $x2 = days($d2);
    
    if ($x1 && $x2) {
        return abs($x1 - $x2);
    }
}

function days($x) {
    if (get_class($x) != 'DateTime') {
        return false;
    }
    
    $y = $x->format('Y') - 1;
    $days = $y * 365;
    $z = (int)($y / 4);
    $days += $z;
    $z = (int)($y / 100);
    $days -= $z;
    $z = (int)($y / 400);
    $days += $z;
    $days += $x->format('z');

    return $days;
}


$view['wr_3']=intval($view['wr_3']);
$view['wr_1']=intval($view['wr_1']);
$percent=round($view['wr_3']/$view['wr_1']*100);
$diff_day= (strtotime($view['wr_2'])-strtotime(date("Y-m-d")))/86400;
echo "D-".$diff_day;
?>
					<p class="font-secondary big text-uppercase">교회지원 목표금액 <?php echo number_format($view['wr_1']);?>원 현재 달성률 
                        <span ><?php echo $percent;?></span>%</p>

    <div class="progress">
      <div role="progressbar" aria-valuenow="<?php echo $percent;?>" aria-valuemin="0" aria-valuemax="100" class="progress-bar" ></div><span class="small text-light-clr"></span>
    </div>

              <!-- <div class="progress">
                <div role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" class="progress-bar"></div><span class="small text-light-clr"></span>
              </div> -->
<!-- 
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> -->


					<span id="donations_total"></span>

					<table id="dontions_list">

					<tr><td>기부한 내역이 없습니다.</td></tr>
					</table>
					<div class="col-xs-12 col-md-6">
					<input type="text" name="do_content" id="do_content" class="form-control round-small required" placeholder="후원할 목록을 선택해 주세요.">
					</div>
					<div class="col-xs-12 col-md-4">
					<input type="number" name="do_price" id="do_price" class="form-control round-small required" 

					min="10000" step="10000"  placeholder="금액을 기제하거나 커서로 선택해 주세요.">
										</div>
															<div class="col-xs-12 col-md-2">
<input type="button" class="btn btn-primary btn-xs round-small btn_submit" value="후원합니다." id="btn_more" onclick="javascript:set_donations();" >
							
                            			</div>
         <div style="clear:both;"></div>
        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->

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
   // $("#bo_v_atc").viewimageresize();
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


function set_donations()
{
var param="";


param={"wr_id":$("#wr_id").val(),"bo_table":$("#bo_table").val(),"do_content":$("#do_content").val(),"do_price":$("#do_price").val()};
console.log(param);
if($("#do_content").val()=="")
{
	alert("후원하실 내역을 선택해 주세요.");
	return;
}

if($("#do_price").val()=="")
{
	alert("후원하실 금액을 기재해 주세요.");
	return;
}
$.ajax({
url:"/wp/bbs/ajax/set_donations.php",
data:param,
dataType:"json",
type:"POST",
success:function(data){
	alert("후원에 감사드립니다.");
	window.location.reload();
}
});

}

function set_donation_value(v)
{
	var mb_name=$("#mb_name").val();
	if(mb_name.length>0){
	v="\""+mb_name+"\"님이 \""+v+"\"을(를) 후원 합니다.";
    //플라워님  3,000원 후원
	}else{
	v="\"숨은 천사\"님이 \""+v+"\"을(를) 후원 합니다.";
	}
    $("#do_content").val(v);
    $("#do_price").focus();
}

function get_donations()
{
var param="";
var price=0;
var percent=0;
var donation_price=parseInt($("#wr_1").val());
$.ajax({
url:"/wp/bbs/ajax/get_donations.php",
data:param,
dataType:"json",
type:"POST",
success:function(data){
	var object=[];
              object.push('<colgroup>');
              object.push('<col class="col-xs-9">');
              object.push('<col class="col-xs-3">');
              object.push('</colgroup>');
	$.each(data.donations,function(key,val){
              object.push('<tr>');
              object.push('<td>');
							object.push(val.do_content);
              object.push('</td>');
                object.push("</tr>");

              object.push('<tr>');
              object.push('<td class="tar"><strong class="txt_highlight">');
	object.push(number_format(val.do_price)+"원");
	              object.push('</strong></td>');
	object.push("</tr>");
	price=price+parseInt(val.do_price);
	});	
	$("#dontions_list").html(object.join(""));
	percent=(price/donation_price)*100;
    console.log("percent : "+percent);
    console.log("price : "+price);
    console.log("donation_price : "+donation_price);
	$("#donations_total").html("총 모금액 : "+number_format(price)+"원<br> 후원에 감사드립니다.");

//document.addEventListener('DOMContentLoaded', function() {
    percent=percent.toFixed(0);
	      //$('#progress-bar').css("width",percent+"%");
    //$(".text-light-clr").html(percent);
	
//});
}
});
}
get_donations();

/**
 * PHP 함수 number_format 같이 천자리마다 ,를 자동으로 찍어줌
 * @param num number|string : 숫자
 * @param decimals int default 0 : 보여질 소숫점 자리숫
 * @param dec_point char default . : 소수점을 대체 표시할 문자
 * @param thousands_sep char default , : 천자리 ,를 대체 표시할 문자
 * @returns {string}
 */
function number_format(num, decimals, dec_point, thousands_sep) {
    num = parseFloat(num);
    if(isNaN(num)) return '0';
 
    if(typeof(decimals) == 'undefined') decimals = 0;
    if(typeof(dec_point) == 'undefined') dec_point = '.';
    if(typeof(thousands_sep) == 'undefined') thousands_sep = ',';
    decimals = Math.pow(10, decimals);
 
    num = num * decimals;
    num = Math.round(num);
    num = num / decimals;
 
    num = String(num);
    var reg = /(^[+-]?\d+)(\d{3})/;
    var tmp = num.split('.');
    var n = tmp[0];
    var d = tmp[1] ? dec_point + tmp[1] : '';
 
    while(reg.test(n)) n = n.replace(reg, "$1"+thousands_sep+"$2");
 
    return n + d;
}

</script>
<!-- } 게시글 읽기 끝 -->