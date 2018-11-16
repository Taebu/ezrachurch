<?php
/************************************************
* 목적 : 서울 에스라교회 qna 장별 리스트 목록
* file : /wp/theme/modificate/skin/board/qna/list.skin.php

* 작성일 : 2018-11-08 (목) 9:04:11 
* 수정일 : 
*
* @author Moon Taebu
* @Copyright (c) 2018, 태부
************************************************/
header('Access-Control-Allow-Origin: *');

include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


include_once('../head.php');


//print_r($_SERVER);
//print_r($member);
$is_admin=$member['mb_id']=="admin";
//$sca=empty($_GET['sca'])?"total":$_GET['sca'];
?>
 <style type="text/css">
textarea {
  margin:0px 0px;
  padding:5px;
  min-height:16px;
  line-height:16px;
  width:96%;
  display:block;
  margin:0px auto;    
}
/* Source: http://bootsnipp.com/snippets/featured/video-list-thumbnails */

.video-list-thumbs{}
.video-list-thumbs > li{
    margin-bottom:112px
}
.video-container {
position: relative;
padding-bottom: 56.25%;
height: 0; overflow: hidden;
}


.video-container {
margin-bottom:10%;
}

.video-container iframe,
.video-container object,
.video-container embed {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
}
.mw40{
min-width: 40px;
}
#myInput {
    background-image: url('/css/searchicon.png'); /* Add a search icon to input */
    background-position: 10px 12px; /* Position the search icon */
    background-repeat: no-repeat; /* Do not repeat the icon image */
    width: 100%; /* Full-width */
    font-size: 16px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    border: 1px solid #ddd; /* Add a grey border */
    margin-bottom: 12px; /* Add some space below the input */
}


.btn-xxs, .btn-group-xs > .btn {
  padding: 4px 5px;
  font-size: 9px;
  line-height: 12px;
  border-radius: 0px;
}
</style>
<script type="text/javascript">
var sca="<?php echo $sca;?>";
var bible_title=["창세기","출애굽기","레위기","민수기","신명기","여호수아","사사기","룻기","사무엘상","사무엘하","열왕기상","열왕기하","역대상","역대하","에스라","느헤미야","에스더","욥기","시편","잠언","전도서","아가","이사야","예레미야","예레미야애가","에스겔","다니엘","호세아","요엘","아모스","오바댜","요나","미가","나훔","하박국","스바냐","학개","스가랴","말라기","마태복음","마가복음","누가복음","요한복음","사도행전","로마서","고린도전서","고린도후서","갈라디아서","에베소서","빌립보서","골로새서","데살로니가전서","데살로니가후서","디모데전서","디모데후서","디도서","빌레몬서","히브리서","야고보서","베드로전서","베드로후서","요한일서","요한이서","요한삼서","유다서","요한계시록","웨스트민스터"];

 $(function(){
		$("#youtube_list").parent().find('a').removeClass('active');
		var bible_title_index=bible_title.indexOf(sca);
		if(sca=="")
	  {
			$("#book_all").addClass('active');
		}else{
			$("#book_"+bible_title_index).addClass('active');
		}
});
 </script>

 <form action="" id="youtube_form">
 <input type="hidden" name="nextPageToken" id="nextPageToken" />
 <input type="hidden" name="prevPageToken" id="prevPageToken" />
 <input type="hidden" name="mb_id" id="mb_id" value="<?php echo $member['mb_id'];?>"/>
 <input type="hidden" name="db_size" id="db_size" />
 <input type="hidden" name="yt_size" id="yt_size" />
 <input type="hidden" name="pr_list" id="pr_list" value="<?php echo $_GET['pr_list'];?>"/>
 </form>
  <script src="https://apis.google.com/js/platform.js"></script>
<script>

/* myFunction() */
function myFunction() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("youtube_list");
    li = ul.getElementsByTagName('a');
    console.log(li);
    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
      console.log(li[i].innerHTML);

        a = li[i].getElementsByTagName("a")[0];
        if (li[i].innerHTML.indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
    //if(i==0){document.getElementById("youtube_list").innerHTML="<div>"+filter+"검색 결과가 없습니다.";};
}


	function onYtEvent(payload) {
    if (payload.eventType == 'subscribe') {
      // Add code to handle subscribe event.
    } else if (payload.eventType == 'unsubscribe') {
      // Add code to handle unsubscribe event.
    }
    if (window.console) { // for debugging only
      window.console.log('YT event: ', payload);
    }
  }

    function del_youtube(link)
    {
        if(!confirm("정말삭제?"))
        {
            return;
        }

        $.ajax({
            url:"./del_youtube.php",
            data:{"link":link},
            dataType:"json",
            type:"POST",
            success:function(data){
                if(data.success){
//              alert("삭제 성공");
                    swal("Good job!", "삭제 성공", "success");
                }
                set_make();
            }
        });
    }
</script>


<main class="page-content">

<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="col-xs-4 col-md-2 col-lg-2" id="left_layout">
<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="검색해 주세요.">
      <div class="list-group" id="youtube_list">

<a id="book_all" href="javascript:list_cnt=0;list_page=1;get_qna('total');" class="list-group-item active" >전체보기</a>
<a id="book_0" href="javascript:get_qna('창세기');" class="list-group-item" >창세기</a>
<a id="book_1" href="javascript:get_qna('출애굽기');" class="list-group-item">출애굽기</a>
<a id="book_2" href="javascript:get_qna('레위기');" class="list-group-item">레위기</a>
<a id="book_3" href="javascript:get_qna('민수기');" class="list-group-item">민수기</a>
<a id="book_4" href="javascript:get_qna('신명기');" class="list-group-item">신명기</a>
<a id="book_5" href="javascript:get_qna('여호수아');" class="list-group-item">여호수아</a>
<a id="book_6" href="javascript:get_qna('사사기');" class="list-group-item">사사기</a>
<a id="book_7" href="javascript:get_qna('룻기');" class="list-group-item">룻기</a>
<a id="book_8" href="javascript:get_qna('사무엘상');" class="list-group-item">사무엘상</a>
<a id="book_9" href="javascript:get_qna('사무엘하');" class="list-group-item">사무엘하</a>
<a id="book_10" href="javascript:get_qna('열왕기상');" class="list-group-item">열왕기상</a>
<a id="book_11" href="javascript:get_qna('열왕기하');" class="list-group-item">열왕기하</a>
<a id="book_12" href="javascript:get_qna('역대상');" class="list-group-item">역대상</a>
<a id="book_13" href="javascript:get_qna('역대하');" class="list-group-item">역대하</a>
<a id="book_14" href="javascript:get_qna('에스라');" class="list-group-item">에스라</a>
<a id="book_15" href="javascript:get_qna('느헤미야');" class="list-group-item">느헤미야</a>
<a id="book_16" href="javascript:get_qna('에스더');" class="list-group-item">에스더</a>
<a id="book_17" href="javascript:get_qna('욥기');" class="list-group-item">욥기</a>
<a id="book_18" href="javascript:get_qna('시편');" class="list-group-item">시편</a>
<a id="book_19" href="javascript:get_qna('잠언');" class="list-group-item">잠언</a>
<a id="book_20" href="javascript:get_qna('전도서');" class="list-group-item">전도서</a>
<a id="book_21" href="javascript:get_qna('아가');" class="list-group-item">아가</a>
<a id="book_22" href="javascript:get_qna('이사야');" class="list-group-item">이사야</a>
<a id="book_23" href="javascript:get_qna('예레미야');" class="list-group-item">예레미야</a>
<a id="book_24" href="javascript:get_qna('예레미야애가');" class="list-group-item">예레미야애가</a>
<a id="book_25" href="javascript:get_qna('에스겔');" class="list-group-item">에스겔</a>
<a id="book_26" href="javascript:get_qna('다니엘');" class="list-group-item">다니엘</a>
<a id="book_27" href="javascript:get_qna('호세아');" class="list-group-item">호세아</a>
<a id="book_28" href="javascript:get_qna('요엘');" class="list-group-item">요엘</a>
<a id="book_29" href="javascript:get_qna('아모스');" class="list-group-item">아모스</a>
<a id="book_30" href="javascript:get_qna('오바댜');" class="list-group-item">오바댜</a>
<a id="book_31" href="javascript:get_qna('요나');" class="list-group-item">요나</a>
<a id="book_32" href="javascript:get_qna('미가');" class="list-group-item">미가</a>
<a id="book_33" href="javascript:get_qna('나훔');" class="list-group-item">나훔</a>
<a id="book_34" href="javascript:get_qna('하박국');" class="list-group-item">하박국</a>
<a id="book_35" href="javascript:get_qna('스바냐');" class="list-group-item">스바냐</a>
<a id="book_36" href="javascript:get_qna('학개');" class="list-group-item">학개</a>
<a id="book_37" href="javascript:get_qna('스가랴');" class="list-group-item">스가랴</a>
<a id="book_38" href="javascript:get_qna('말라기');" class="list-group-item">말라기</a>
<a id="book_39" href="javascript:get_qna('마태복음');" class="list-group-item">마태복음</a>
<a id="book_40" href="javascript:get_qna('마가복음');" class="list-group-item">마가복음</a>
<a id="book_41" href="javascript:get_qna('누가복음');" class="list-group-item">누가복음</a>
<a id="book_42" href="javascript:get_qna('요한');" class="list-group-item">요한복음</a>
<a id="book_43" href="javascript:get_qna('사도행전');" class="list-group-item">사도행전</a>
<a id="book_44" href="javascript:get_qna('로마서');" class="list-group-item">로마서</a>
<a id="book_45" href="javascript:get_qna('고린도전서');" class="list-group-item">고린도전서</a>
<a id="book_46" href="javascript:get_qna('고린도후서');" class="list-group-item">고린도후서</a>
<a id="book_47" href="javascript:get_qna('갈라디아서');" class="list-group-item">갈라디아서</a>
<a id="book_48" href="javascript:get_qna('에베소서');" class="list-group-item">에베소서</a>
<a id="book_49" href="javascript:get_qna('빌립보서');" class="list-group-item">빌립보서</a>
<a id="book_50" href="javascript:get_qna('골로새서');" class="list-group-item">골로새서</a>
<a id="book_51" href="javascript:get_qna('데살로니가전서');" class="list-group-item">데살로니가전서</a>
<a id="book_52" href="javascript:get_qna('데살로니가전서');" class="list-group-item">데살로니가후서</a>
<a id="book_53" href="javascript:get_qna('디모데전서');" class="list-group-item">디모데전서</a>
<a id="book_54" href="javascript:get_qna('디모데후서');" class="list-group-item">디모데후서</a>
<a id="book_55" href="javascript:get_qna('디도서');" class="list-group-item">디도서</a>
<a id="book_56" href="javascript:get_qna('빌레몬서');" class="list-group-item">빌레몬서</a>
<a id="book_57" href="javascript:get_qna('히브리서');" class="list-group-item">히브리서</a>
<a id="book_58" href="javascript:get_qna('야고보서');" class="list-group-item">야고보서</a>
<a id="book_59" href="javascript:get_qna('베드로전서');" class="list-group-item">베드로전서</a>
<a id="book_60" href="javascript:get_qna('베드로후서');" class="list-group-item">베드로후서</a>
<a id="book_61" href="javascript:get_qna('요한일서');" class="list-group-item">요한일서</a>
<a id="book_62" href="javascript:get_qna('요한이서');" class="list-group-item">요한이서</a>
<a id="book_63" href="javascript:get_qna('요한삼서');" class="list-group-item">요한삼서</a>
<a id="book_64" href="javascript:get_qna('유다서');" class="list-group-item">유다서</a>
<a id="book_65" href="javascript:get_qna('요한계시록');" class="list-group-item">요한계시록</a>
<a id="book_65" href="javascript:get_qna('웨스트민스터');" class="list-group-item">웨스트민스터</a>

</div>
</div><!-- #left_layout .col-lg-2 text-center -->

<div class="col-xs-8 col-md-10 col-lg-9" id="right_layout">
<div id="youtube_area"  class="list-unstyled video-list-thumbs row">
<?php
// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

		 <!--
      ========================================================
                              CONTENT
      ========================================================
      -->


    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

      <main class="page-content">

        <section class="well well-inset-2">
          <div class="container">
				<div class="col-lg-6" style=height:40px;>

		<!-- 게시판 카테고리 시작 { -->
		<?php if ($is_category) { 
//			echo '				  <button class="btn btn-xs dropdown-toggle" type="button" data-toggle="dropdown" style=height:35px>카테고리 선택';
//			echo '	  <span class="caret"></span></button>';
//			echo '		  <ul class="dropdown-menu">';
//			echo $category_option;
//			echo '				  </ul>';
		 } ?>
		<!-- } 게시판 카테고리 끝 -->

				</div>



			<div class="col-lg-6" style=text-align:right><h6>Total <?php echo number_format($total_count) ?>건 / <?php echo $page ?> 페이지</div>
            <!--Table-striped-->
            <table class="table table-striped table-mobile mobile-primary text-center">
              <colgroup>
				<col class="col-lg-1 col-sm-1">
                <?php if ($is_checkbox) { ?>               
				<col class="col-lg-1 col-sm-1">
					<?php } ?>		         
                <col class="col-lg-6 col-sm-6">
                <col class="col-lg-1 col-sm-1">
                <col class="col-lg-2 col-sm-2">
                <col class="col-lg-1 col-sm-1">
              </colgroup>
              <thead>
                <tr class="bg-primary">
                  <th style=text-align:center>번호</th>
                  <?php if ($is_checkbox) { ?>
				  <th>선택</th>
					<?php } ?>		         
                  <th style=text-align:center>제목</th>
                  <th style=text-align:center>글쓴이</th>
                  <th style=text-align:center><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?><font style=color:#fff>날짜</font></a></th>
                  <th style=text-align:center><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?><font style=color:#fff>조회</font></a></th>
                </tr>
              </thead>
              <tbody>


			    <?php
				//print_r($list);
				for ($i=0; $i<count($list); $i++) {
				 ?>


                <tr>
                  <td style="text-align:center" class="hidden-xs">
				  <?php
            if ($list[$i]['is_notice']) // 공지사항
                echo '<strong>공지</strong>';
            else if ($wr_id == $list[$i]['wr_id'])
                echo "<span class=\"bo_current\">열람중</span>";
            else
                echo $list[$i]['wr_id'];
             ?></td>

			<?php if ($is_checkbox) { ?>
            <td class="td_chk hidden-xs">
			<?php //echo $list[$i]['wr_id'] ?>
            <div class="checkbox hidden-xs">
                <label for="chk_wr_id_<?php echo $i ?>">
                    <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                    <span class="checkbox-field"></span>
                    <span class="sound_only"><?php echo $list[$i]['subject'] ?></span>
                </label>
            </div>
            </td>
            <?php } ?>
			


			<td class="td_subject" style=text-align:left>
				 <?php
                echo $list[$i]['icon_reply'];
                if ($is_category && $list[$i]['ca_name']) {
                 ?>
                
								<a  class="btn btn-primary btn-xxs round-small" href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                
								<?php } ?>

                <a href="<?php echo $list[$i]['href'] ?>">
                    <?php echo $list[$i]['subject'] ?>
                    <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?>
                </a>

                <?php
                // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];

                 ?>
			</td>

                  <td style="text-align:center" class="hidden-xs"><?php echo $list[$i]['name'] ?></td>
				  <td style="text-align:center" class="hidden-xs"><?php echo $list[$i]['datetime'] ?></td>
				  <td style="text-align:center" class="hidden-xs"><?php echo $list[$i]['wr_hit'] ?></td>
                </tr>


        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>

              </tbody>
            </table>




    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($is_checkbox) { ?>
        <ul class="col-lg-6">
			<input type="submit" class="btn btn-primary btn-xs round-small btn-icon-left" name="btn_submit" onclick="document.pressed=this.value" value="선택삭제">
			<input type="submit" class="btn btn-primary btn-xs round-small btn-icon-left" name="btn_submit" onclick="document.pressed=this.value" value="선택복사">
			<input type="submit" class="btn btn-primary btn-xs round-small btn-icon-left" name="btn_submit" onclick="document.pressed=this.value" value="선택이동">
        </ul>
        <?php } ?>


        <?php if ($list_href || $write_href) { ?>
        
		<?php if ($admin_href) { ?>
			<ul class="col-lg-6" style=text-align:right>
		<?php } else { ?>
			<ul class="col-lg-12" style=text-align:right>
		<?php } ?>

            <?php if ($admin_href) { ?><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a><?php } ?>
            <?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="btn_b01">목록</a><?php } ?>
            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>





          </div>
		</form>
        </section>

      </main>




<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>




<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch" style=text-align:center>
    <legend>게시물 검색</legend>
    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
<div class="col-xs-10 col-sm-2 col-xs-offset-2 form-group">
    <select name="sfl" id="sfl"  class="form-control round-small" >
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
        <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
        <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
        <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
        <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
    </select>
              </div>
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<div class="col-xs-12 col-sm-4">
                <div class="form-group">
                <label for="reg_mb_zip" class="sound_only">우편번호<strong class="sound_only"> 필수</strong></label>
                <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx"  size="15" maxlength="20" id="stx" required="" class="col-xs-5 form-control round-small frm_input required" size="5"  placeholder="검색"></div>
          </div>
    <div class="col-xs-12 col-sm-2">
                <div class="form-group">
                <button type="submit" class="offset-5 btn-primary btn-xs round-small col-xs-3 btn-block" data-target="#btn_map" id="btn_map">검색</button></div>
          </div>
    
    </form>
</fieldset>
<!-- } 게시판 검색 끝 -->



<!-- 페이지 -->
<?php echo $write_pages;  ?>


<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}

function get_qna(link)
{
    var is_total=link=="total";
    if(is_total){

   location.href='/wp/bbs/board.php?bo_table=qna';
    }else{
   location.href='/wp/bbs/board.php?bo_table=qna&sca='+link;

    }
}


</script>
<!-- } 게시판 목록 끝 -->

</div><!-- #youtube_area -->
</div><!-- #right_layout -->
<div style="text-align:center;clear:both"></div>
</div><!-- .col-md-8 col-md-offset-2 -->
</div><!-- .row -->



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" style="display: none;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title" id="audiobook_title">음성</h4>
      </div>
      <div class="modal-body" id="audiobook_area">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!--// Modal content-->

  </div><!-- // Modal -->
</div><!-- #myModal -->
</main>