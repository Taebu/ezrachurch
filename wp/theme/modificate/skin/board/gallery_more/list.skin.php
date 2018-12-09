<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$data_url=sprintf("bo_table=%s&page=%s&sop=%s&stx=%s&sca=%s&sfl=%s",$bo_table,$page,$sop,$stx,$sca,$sfl);

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet(sprintf('<link rel="stylesheet" href="%s/style.css">',$board_skin_url), 0);
add_stylesheet(sprintf('<link rel="stylesheet" href="%s/css/sweetalert.css">',$board_skin_url), 0);
add_stylesheet(sprintf('<script src="%s/js/sweetalert.js"></script>',$board_skin_url), 0);

?>
<script>
</script>
<style>
#posts{margin-bottom:15px ;}
.se-pre-con {position: fixed;left: 0;top: 0;width: 100%;height: 100%;z-index: 9999;background: url(https://smallenvelop.com/wp-content/uploads/2014/08/Preloader_3.gif) center no-repeat #fff;display:none}
</style>
<!-- 게시판 목록 시작 { -->
<!-- 게시물 검색 시작 { -->
<div class="col-xs-12">
<fieldset id="bo_sch">
    <legend>게시물 검색</legend>
<?php if($is_mobile) {
	echo "mobile";
}else{
	echo "pc";
}
?>
    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>

		<div class="row">
                <h1 class="text-bold"><?php echo empty($stx)?"검색해주세요":sprintf("“%s”검색 결과 입니다.",$stx);?> </h1>
                <p class="lead"></p>
							<div class="col-md-2 col-md-offset-1">
						<select name="sfl" id="sfl"  class="form-control round-small">
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
        <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
        <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
        <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
        <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
    </select>
</div>
							<div class="col-md-8">

                <form class="form-width-1 offset-1">

                  <div class="form-group">
				    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
										<label for="stx" class="text-uppercase font-secondary"></label>
								    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="width-1 form-control frm_input" size="15" maxlength="20" >
                    <button type="submit" class="btn btn-primary btn-xs round-xl">검색</button>
                  </div>
                </form>
              </div>
            </div>
<!--     <input type="submit" value="검색" class="btn_submit"> -->
    </form>
</fieldset>

<!-- } 게시물 검색 끝 -->
</div><!-- .col-xs-12 -->


<div id="bo_gall" style="width:<?php echo $width; ?>"   onscroll="javascript:scrolled(this)">

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
<ul id="posts"></ul><!--/ masonry.ul -->

    </div>  </section>
<div class="col-xs-12">
<div class="se-pre-con"></div>
            </div>
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
<?php } 	?>

<!-- 페이지 -->
<div class="col-xs-12">
<?php //echo $write_pages;  ?>

</div><!-- .col-xs-12 -->

<?php 
	//if ($is_checkbox) { 
		?>
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

var board_skin_url="<?php echo $board_skin_url;?>";
var random_loading=[
board_skin_url+"/img/Preloader_1.gif",
board_skin_url+"/img/Preloader_2.gif",
board_skin_url+"/img/Preloader_3.gif",
board_skin_url+"/img/Preloader_4.gif",
board_skin_url+"/img/Preloader_5.gif",
board_skin_url+"/img/Preloader_6.gif",
board_skin_url+"/img/Preloader_7.gif",
board_skin_url+"/img/Preloader_21.gif",
board_skin_url+"/img/Preloader_31.gif",
board_skin_url+"/img/Preloader_41.gif",
board_skin_url+"/img/Preloader_51.gif",
board_skin_url+"/img/Preloader_61.gif",
board_skin_url+"/img/Preloader_71.gif",
board_skin_url+"/img/Preloader_8.gif",
board_skin_url+"/img/Preloader_9.gif",
board_skin_url+"/img/Preloader_10.gif"];



var page=0;
var list_size=true;
var is_nomore=false;
var is_search=false;



function listAjax(mode)
{

	var data_url=$("[name=fboardlist]").serialize();
	var random_index=Math.floor((Math.random() * random_loading.length));
$(".se-pre-con").css("background-image",'url('+random_loading[random_index]+')');

	if(mode=="search"){
		is_search=true;
		$('#posts').html("");
		page=0;
	}
	
	page++;
console.log(page);
	$("[name=page]").val(page);
	var no=$("[name=page]").val();

	if(is_search)
	{
		data_url=$("[name=fsearch]").serialize();
		data_url=data_url+"&page="+page;
	}else{
		data_url=$("[name=fboardlist]").serialize();
	}



	console.log(data_url);
	console.log(list_size);

	if(list_size)
	{
			$(".se-pre-con").show();
		$.ajax({
			type: "POST",
			url: board_skin_url+"/list.ajax.php",
			data: data_url, 
			cache: false,
			success: function(html)
			{
				var listHtml = html.split('▤'); 
				list_size=listHtml[2]>0?true:false;
				console.log(list_size);
				if(list_size){
					$('#posts').append(listHtml[0]);
					$(".se-pre-con").hide();
					get_isot();
				}else{
//					alert("더 없어");
						is_nomore=true;
						$(".se-pre-con").remove();
				}
				if(is_nomore)
				{
//					swal("내용이 더 이상 없습니다.","?","info");
					is_nomore=false;
					$(".se-pre-con").remove();
				}
			},complete:function(){
				get_isot();
			}
		});
	}
	else{
//		alert('end');
	}
	
}	


function get_isot()
{
    var o = $(".isotope");
    if (o.length) {

        $(document).ready(function () {
            o.each(function () {
                var _this = this
                    , iso = new Isotope(_this, {
                        itemSelector: '[class*="col-"], .isotope-item',
                        layoutMode: _this.getAttribute('data-layout') ? _this.getAttribute('data-layout') : 'masonry'
                    });

                $(window).on("resize", function () {
                    iso.layout();
                });

                $(window).load(function () {
                    iso.layout();
                    setTimeout(function () {
                        _this.className += " isotope--loaded";
                        iso.layout();
                    }, 600);
                });
            });

            $(".isotope-filters-trigger").on("click", function () {
                $(this).parents(".isotope-filters").toggleClass("active");
            });

            $('.isotope').magnificPopup({
                delegate: ' > :visible .mfp-image',
                type: "image",
                gallery: {
                    enabled: true
                },
            });

            $("[data-isotope-filter]").on("click", function () {
                $('[data-isotope-filter][data-isotope-group="' + this.getAttribute("data-isotope-group") + '"]').removeClass("active");
                $(this).addClass("active");
                $(this).parents(".isotope-filters").removeClass("active");
                $('.isotope[data-isotope-group="' + this.getAttribute("data-isotope-group") + '"]')
                    .isotope({filter: this.getAttribute("data-isotope-filter") == '*' ? '*' : '[data-filter="' + this.getAttribute("data-isotope-filter") + '"]'});
            })
        });
    }
		console.log("call : get_isot()");

}

window.onload = function() {
	$(".se-pre-con").hide();
	if($("#stx").val().length>2)
	{
		listAjax("search");
		console.log("search");
	}else{

        listAjax();
        console.log("board");
    }

    var timer;
    $(window).bind('scroll',function () {
				var is_near=$(window).scrollTop() + $(window).height() > $(document).height() - 100;
				console.log(is_near);
				clearTimeout(timer);
        if(is_near){
				timer = setTimeout( refresh , 250 );
				}
    });

    var refresh = function () { 
        // do stuff
        console.log('Stopped Scrolling'); 
				listAjax();
    };

};

</script>
<?php 
//} 

?>
<!-- } 게시판 목록 끝 -->


</div></section></main>
<?php 
//echo G5_URL;
//$data_url=sprintf("bo_table=%s&page=%s&sop=%s&stx=%s&sca=%s&sfl=%s",$bo_table,$page,$sop,$stx,$sca,$sfl);

//echo $data_url;

?>