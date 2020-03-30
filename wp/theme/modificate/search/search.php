<?php
/************************************************
* 목적 : 서울 에스라교회 전체 게시물 조회
* file : /wp/theme/modificate/search/search.php
* 작성일 : 2020-01-22 16:58:38 (수요일)
* 수정일 : 
*
* @author Moon Taebu
* @Copyright (c) 2020, 태부
************************************************/
header('Access-Control-Allow-Origin: *');


include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


include_once('../head.php');
$k="";
$keyword_count=0;
$pagesize=10;
$listsize=15;
$is_keyword=false;
if($page == "") $page = 1;  
$firstNum = ($page-1)*$listsize;

if(isset($_GET['k'])&&strlen($_GET['k'])>0)
{
	$k =$_GET['k'];
	$is_keyword=true;
}
//echo "<pre>";
//print_r($_SERVER);
//echo "</pre>";
//echo $_SERVER['SCRIPT_NAME']
//print_r($member);
$is_admin=$member['mb_id']=="admin";
if($is_keyword)
{
$sql="SELECT * FROM newezra.ez_youtubelink ";
$where = sprintf("where ey_title like '%%%s%%' ",$k);
$where.= sprintf(" or ey_author like '%%%s%%'",$k);

$order=" order by ey_datetime desc ";
$limit=sprintf(" limit %s, %s ",$firstNum,$listsize);
$query=$sql.$where.$order.$limit;
$youtube=sql_query($sql.$where.$order.$limit);
$sql="SELECT count(DISTINCT ey_videoid) cnt FROM newezra.ez_youtubelink ";
$youtube_count=sql_fetch_array(sql_query($sql.$where));
$keyword_count=$youtube_count['cnt'];
$cnt=$youtube_count['cnt'];
//$page = 1;





$lnum2 = ceil($cnt/$listsize);
$fnum = ((int)(($page-1)/$pagesize)*$pagesize)+1;
$lnum = ((int)(($page-1)/$pagesize)*$pagesize)+$pagesize;
if( $lnum2 < $lnum){
$lnum= $lnum2;
}

}
function get_eygroup($key)
{
	$code=array();
	$code['edu_01']="웨스트민스터 신앙고백서 강해";
	$code['edu_02']="새가족교육 11주차";
	$code['edu_03']="칼빈의 제네바 시편 찬송가 배우기";
	$code['lecture_01']="주일예배";
	$code['lecture_02']="외부 강사 설교";

	if (array_key_exists($key, $code)) {
		$result=$code[$key];
	}else{
		$result="알수 없는 코드";
	}
	return $result;
}
?>
<script src="/wp/theme/modificate/youtube/js/jquery.js"></script>

<!-- This is what you need -->
<script src="/wp/theme/modificate/youtube/js/sweetalert.js"></script>
<script>
	
function show_modify_author(t)
{
var id=$(t).data('id');
$("#modify_author_"+id).show();
$("#button_modify_author_"+id).hide();
}

function modify_author(t)
{
var id=$(t).data('id');
$("#modify_author_"+id).hide();
var author=$("#ey_author_"+id).val();
$("#display_author_"+id).html(author);
$("#button_modify_author_"+id).show();
		$.ajax({
			url:"./modify_author.php",
			data:{"ey_author":author,"ey_videoid":id},
			dataType:"json",
			type:"POST",
			success:function(data){
				if(data.success){
//				alert("삭제 성공");
					swal("Good job!", "수정 성공", "success");
				}
				set_make();
			}
		});
}	

</script>
<link rel="stylesheet" href="/wp/theme/modificate/youtube/css/sweetalert.css">

	  <!--
      ========================================================
                              CONTENT
      ========================================================
      -->
      <main class="page-content">
        <section class="section-border text-center text-md-left">
          <div class="container">
            <ol class="breadcrumb pull-md-right">
              <li><a href="/wp/">Home</a></li>
              <li><a href="#">말씀</a></li>
              <li class="active"><a href="#">검색 결과</a></li>
            </ol>
            <h5 class="text-uppercase letter-spacing-1 pull-md-left inset-4"><?php echo $keyword_count;?>개의 검색 결과: <?php echo $k;?></h5>
          </div>
        </section>

        <!--Start section-->
        <section class="text-center text-md-left well well-sm section-border">
          <div class="container">
            <div class="row">
              <div class="col-md-8">
                <div class="row">
                  <div style="padding-bottom: 40px;" class="col-xs-12 section-border">
                    <h1 class="text-bold">New Search</h1>
                    <p class="lead">If you are not happy with the results below please do another search</p>
                    <form class="offset-1" method="GET">
						<input type="text" name="page" id="page" value="<?php $page;?>">
                      <div class="form-group">
                        <label for="exampleInputSearch" class="text-uppercase font-secondary"></label>
                        <input type="text" placeholder="Search" id="exampleInputSearch" class="round-small width-1 form-control" name="k" value="<?php echo $k;?>">
                        <button type="submit" class="btn btn-primary btn-xs round-small">Search</button>
                      </div>
                    </form>
                  </div>
                </div>
                <ul class="search-results-list text-left row">
        <?php
		if($is_keyword)
		{
		$keys=array();
		while($list=sql_fetch_array($youtube))
		{

			if (in_array($list['ey_videoid'], $keys)) {
				continue;
			}
			$keys[]=$list['ey_videoid'];
			?>

				  <li class="col-xs-12 section-border">
                    <h3 class="text-bold text-dark-variant-3"><a  href="https://www.youtube.com/watch?v=<?php echo $list['ey_videoid'];?>">youtube : <?php echo get_eygroup($list['ey_group']);?>
					<small class="text-uppercase"  id="display_author_<?php echo $list['ey_videoid'];?>"> <?php echo $list['ey_author'];?></small></a></h3>
                    <p class="lead"><a href="https://www.youtube.com/watch?v=<?php echo $list['ey_videoid'];?>"> <?php echo $list['ey_title'];?> </a>
					<iframe frameborder="0" width="640" height="360" title="test" src="https://www.youtube.com/embed/<?php echo $list['ey_videoid'];?>?autoplay=0&amp;controls=1&amp;loop=1&amp;rel=1&amp;showinfo=1&amp;autohide=1&amp;start=5" allowfullscreen=""></iframe>
				  <div class="col-xs-4 col-sm-4 col-lg-2">
<?php if(!$is_admin||$is_admin){ ?>
<div class="form-group">
<button type="button" id="button_modify_author_<?php echo $list['ey_videoid'];?>" class="btn btn-primary btn-xs round-small btn-block" onclick="javascript:show_modify_author(this);" data-id="<?php echo $list['ey_videoid'];?>"><span></span>수정</button>
  </div>
</div>
					<div id="modify_author_<?php echo $list['ey_videoid'];?>" style="display:none">
					<div class="col-xs-8 col-sm-4 col-lg-10">
                    <div class="form-group">
                      <label for="reg_mb_3" class="text-uppercase font-secondary">설교자 수정</label>
                      <input type="text" placeholder="설교자" name="mb_3" value="<?php echo $list['ey_author'];?>"  id="ey_author_<?php echo $list[ey_videoid];?>" class="form-control round-small frm_input required " minlength="1" maxlength="34">
                      <p><span id="msg_mb_3"></span></p>
                    </div>
                  </div>
				  <div class="col-xs-4 col-sm-4 col-lg-2">
  <div class="form-group">
<button type="button" id="captcha_reload" class="btn btn-primary btn-xs round-small btn-block"  onclick="javascript:modify_author(this);"  data-id="<?php echo $list[ey_videoid];?>"><span></span>수정</button>
  </div>
</div>
<?php } /* if($is_admin){...} */?>

					</div>
					</p>
                  </li>
				  <?php
		}
		}else{?>
                   <li class="col-xs-12 section-border">
                    <h3 class="text-bold text-dark-variant-3"><a href="#"> Home: Agency<small class="text-uppercase">Page</small></a></h3>
                    <p class="lead">검색결과가 없습니다.</p>
                  </li>

				  <?php } ?>

                </ul>
                <div aria-label="First group" role="group" class="col-inset-2 text-center btn-group">
<!-- 				<a href="#" class="btn btn-default round-small active">1</a>
				<a href="#" class="btn btn-default round-small">2</a>
				<a href="#" class="btn btn-default round-small">3</a>
				<span class="text-light-clr font-secondary">...</span>
				<a href="#" class="btn btn-default round-small">8</a> -->
<?php	echo paging($page,$cnt,$listsize);?>
				</div>

              </div>
              <div class="col-md-3 col-md-offset-1 inset-sm sidebar">
                <h5>Sed Diam Nonumy</h5>
                <p class="text-justify">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea.</p>
                <h5>Latest Project</h5>
                <div class="img-box"><a href="#"><img src="images/sidebar-2.jpg" alt=""></a><a href="#"><img src="images/sidebar-3.jpg" alt=""></a><a href="#"><img src="images/sidebar-4.jpg" alt=""></a><a href="#"><img src="images/sidebar-5.jpg" alt=""></a><a href="#"><img src="images/sidebar-6.jpg" alt=""></a><a href="#"><img src="images/sidebar-7.jpg" alt=""></a></div>
                <h5>Latest News</h5>
                <ul class="list-unstyled-2">
                  <li><a href="#" class="text-primary">Trends in UX Design</a></li>
                  <li><a href="#" class="text-primary">The little Person inside</a></li>
                  <li><a href="#" class="text-primary">Inspirational Quote</a></li>
                  <li><a href="#" class="text-primary">The Exploration</a></li>
                  <li><a href="#" class="text-primary">Places to get lost</a></li>
                </ul>
                <h5>Sponsor Widget</h5>
  <?php
  /*
* paging
@param
$page 현재 선택된 페이지
$cnt 총 리스트 갯수
*/
function paging($page,$cnt,$listsize=10,$id="list"){
$pagesize=10;
global $k;
$lnum2 = ceil($cnt/$listsize);
$fnum = ((int)(($page-1)/$pagesize)*$pagesize)+1;
$lnum = ((int)(($page-1)/$pagesize)*$pagesize)+$pagesize;
$lnum= ( $lnum2 < $lnum)?$lnum2:$lnum;
echo "<div class=\"paginate\">";
//echo '				<div class="img-box">';
if($fnum != "1"){
//echo "<a class=\"pre\" href=\"#$id\" onclick='page_move(1);'><img width=\"56\" height=\"27\" alt=\"처음\" src=\"/common/paginate/btn_page_first.gif\"></a>";
//echo "<a class=\"pre\" href=\"#$id\" onclick='page_move(".(((int)(($page-1)/$pagesize)*$pagesize)).");'><img alt=\"이전\" src=\"/common/paginate/btn_page_prev.gif\" width=\"56\" height=\"27\">";
//echo "</a>";
$pre_page=(((int)(($page-1)/$pagesize)*$pagesize));
	printf('<a href="/wp/theme/modificate/search/search.php?page=%s&k=%s" class="btn btn-default round-small">&lt;</a>',$pre_page,$k);
}
for($i=$fnum; $i<=$lnum; $i++){
if($page == $i){
	printf('<a href="#" class="btn btn-default round-small active">%s</a>',$i);
}else{
//	printf("<a href=\"#$id\"  onclick='page_move($i);'><span>$i</span></a>");
	printf('<a href="/wp/theme/modificate/search/search.php?page=%s&k=%s" class="btn btn-default round-small">%s</a>',$i,$k,$i);
}
}
if($lnum2 != $lnum){
//echo "<a class=\"next\" href=\"#$id\"  onclick='page_move($fnum+$pagesize);'>";
//echo "<img alt=\"다음\"  src=\"/common/paginate/btn_page_next.gif\" width=\"57\" height=\"27\" >";
//echo "</a>";
$next_page=$fnum+$pagesize;
	printf('<a href="/wp/theme/modificate/search/search.php?page=%s&k=%s" class="btn btn-default round-small">&gt;</a>',$next_page,$k);
//echo "<a class=\"next\" href=\"#$id\">";
//echo "<img width=\"57\" height=\"27\" alt=\"끝\" src=\"/common/paginate/btn_page_end.gif\" onclick='page_move($lnum2);'>";
//echo"</a>";
}
echo "</div>";
}

  //;
  ?>
<!-- 				<div class="img-box"> --><!-- 
				<a href="#"><img src="images/sidebar-8.jpg" alt=""></a>
				<a href="#"><img src="images/sidebar-8.jpg" alt=""></a>
				<a href="#"><img src="images/sidebar-8.jpg" alt=""></a>
				<a href="#"><img src="images/sidebar-8.jpg" alt=""></a> --></div>
              </div>
            </div>
          </div>
        </section>
        <!--End section-->
        
        
      </main>
      <!--
      ========================================================
                              FOOTER
      ========================================================
      -->
<?php
include_once(G5_PATH.'/tail.php');
?>