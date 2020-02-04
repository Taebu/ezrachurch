<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

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
		<?php if ($is_category) { ?>
				
				  <button class="btn btn-xs dropdown-toggle" type="button" data-toggle="dropdown" style=height:35px>카테고리 선택
				  <span class="caret"></span></button>
				  <ul class="dropdown-menu">
				   <?php echo $category_option ?>
				  </ul>
				


		<?php } ?>
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
                <col class="col-lg-5 col-sm-5">
                <col class="col-lg-2 col-sm-2">
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
                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
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


<?php if ($is_checkbox) { ?>
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
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
