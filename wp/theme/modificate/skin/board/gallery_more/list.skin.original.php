<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$data_url=sprintf("bo_table=%s&page=%s&sop=%s&stx=%s&sca=%s&sfl=%s",$bo_table,$page,$sop,$stx,$sca,$sfl);

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>


<!-- 게시판 목록 시작 { -->
<div id="bo_gall" style="width:<?php echo $width; ?>">

    <div class="bo_fx">
<!--        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>
-->
        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01">RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>

    <form name="fboardlist"  id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <?php if ($is_checkbox) { ?>
    <div id="gall_allchk">
        <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
        <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
    </div>
    <?php } ?>

            <div data-isotope-layout="masonry" data-isotope-group="gallery" data-lightbox="gallery" class="isotope offset-1 isotope-no-gutter" id="masonry-grid">
<!-- masonry.ul -->
<ul id="posts">
        <?php for ($i=0; $i<count($list); $i++) {
            if($i>0 && ($i % $bo_gallery_cols == 0))
                $style = 'clear:both;';
            else
                $style = '';
            if ($i == 0) $k = 0;
            $k += 1;
            if ($k % $bo_gallery_cols == 0) $style .= "margin:0 !important;";
         ?>
        <li class="gall_li <?php if ($wr_id == $list[$i]['wr_id']) { ?>gall_now<?php } ?>" style="<?php echo $style ?>width:<?php echo $board['bo_gallery_width'] ?>px" class="posts">
            <?php if ($is_checkbox) { ?>
            <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
            <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            <?php } ?>
            <span class="sound_only">
                <?php
                if ($wr_id == $list[$i]['wr_id'])
                    echo "<span class=\"bo_current\">열람중</span>";
                else
                    echo $list[$i]['num'];
                 ?>
            </span>


			<div data-filter="type-1" class="thumbnail-variant-2 thumbnail-4_col10 width_20 text-center isotope-item">

                    
                    <?php
                    if ($list[$i]['is_notice']) { // 공지사항  ?>
                        <strong style="width:<?php echo $board['bo_gallery_width'] ?>px;height:<?php echo $board['bo_gallery_height'] ?>px">공지</strong>
                    <?php } else {
                        $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);
						$is_youtube_uri=false;
						$is_youtube_uri=preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $list[$i]['link'][1], $match);

                        if($is_youtube_uri){
                           /*
						   $img_content = '<iframe frameborder=\"0\"   width=\"853\" height=\"480\"  ';
                           $img_content.= ' src=\"https://www.youtube.com/embed/'.$match[1];
                           $img_content.= 'autoplay=0&controls=1&loop=1&rel=1';
                           $img_content.= '&showinfo=1&autohide=1&start=5\" allowfullscreen></iframe>';
							*/

                           //$img_content = '<iframe src="'.$list[$i]['link'][1].'" width="560" height="315" frameborder="0" allowfullscreen></iframe> ';

							$img_content = '<img src="https://i.ytimg.com/vi/'.$match[1].'/maxresdefault.jpg" alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
						}else if($thumb['src']) {
                            $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
                        } else {
                            $img_content = '<span style="width:'.$board['bo_gallery_width'].'px;height:'.$board['bo_gallery_height'].'px">no image</span>';
                        }

                        echo $img_content;
                    }
                     ?>
                    </a>
					
					<?php

						if($is_youtube_uri){
							//$golink = $list[$i]['link'][1]; 
                            $golink = $list[$i]['href'];
						}else if($list[$i]['link'][1]) {
							$golink = $list[$i]['link'][1]; 
						} else { 
							$golink = $list[$i]['href'];
						} 

					?>

				<a href="<?php echo $golink; ?>" <?php if($list[$i]['link'][1]) { ?>target="_blank"<? } ?>><div class="caption">
                    <h4 class="text-white"><?php echo $list[$i]['subject'] ?><small><?php echo $list[$i]['datetime'] ?></small></h4>
                  </div></a><?php if($is_admin) { ?><a href="<?php echo $list[$i]['href']; ?>" class="icon icon-sm text-white fa-chain"></a><? } ?>
        <?php } ?>
        <?php if (count($list) == 0) { echo "<li class=\"empty_list\">게시물이 없습니다.</li>"; } ?>
		</ul><!--/ masonry.ul -->
    </div>  </section>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class=col-xs-12>
        <!--<?php if ($is_checkbox) { ?>
        <ul class="btn_bo_adm">
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>
        </ul>
        <?php } ?>
-->
        <?php if ($list_href || $write_href) { ?>
        <ul class="col-xs-12" style=text-align:right>
			<?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="btn_b01">목록</a><?php } ?>
            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<div class="col-xs-12">
<?php echo $write_pages;  ?>

</div><!-- .col-xs-12 -->

<!-- 게시물 검색 시작 { -->
<div class="col-xs-12">
<fieldset id="bo_sch">
    <legend>게시물 검색</legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
        <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
        <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
        <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
        <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
    </select>
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="frm_input required" size="15" maxlength="20">
    <input type="submit" value="검색" class="btn_submit">
    </form>
</fieldset>
<!-- } 게시물 검색 끝 -->
</div><!-- .col-xs-12 -->
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

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}

var data_url="<?php echo $data_url;?>";
var board_skin_url="<?php echo $board_skin_url;?>";

$(document).ready(function(){
	listAjax(1);
});

function listAjax(no)
{
	if(no)
	{
		$('#posts').html('<li><img src="'+board_skin_url+'/img/pageloading01.gif" width=60px /></tr>');
		
		$.ajax({
			type: "POST",
			url: board_skin_url+"/list.ajax.php",
			data: data_url, 
			cache: false,
			success: function(html)
			{
				var listHtml = html.split('▤'); 
			
				if(html.indexOf("td_num") == -1)
				{
					$('#posts').html(listHtml[0]);
					$('#listPaging').html(listHtml[1]);
				}else{	
					$('#posts').html(listHtml[0]);
					$('#listPaging').html(listHtml[1]);
				}
			}
		});
	}
	else{
		alert('end');
	}
}	


</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->


</div></section></main>
<?php 
//echo G5_URL;
//$data_url=sprintf("bo_table=%s&page=%s&sop=%s&stx=%s&sca=%s&sfl=%s",$bo_table,$page,$sop,$stx,$sca,$sfl);

//echo $data_url;

?>