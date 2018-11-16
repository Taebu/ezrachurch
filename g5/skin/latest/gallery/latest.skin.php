<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
?>

<!--<link rel="stylesheet" href="<?php echo $latest_skin_url ?>/style.css">-->
	<div class="body1 clearfix">
		<div class='intro-title'><h2><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject; ?></a></h2>
		    <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>
		</div>
			
		    <?php for ($i=0; $i<count($list); $i++) {  ?>
		<!-- thumbnail -->
					<div class="col-sm-4">
						<a data-toggle="modal" href="#gallery10" class="thumbnail"> 
					<?

$thumb=get_file($list[$i]['bo_table'], $list[$i]['wr_id']);
//$file[$no]['file'] = $row['bf_file'];  return $file;*/
//echo $thumb[0]['file'];

                        $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);

                        if($thumb['src']) {
                            $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
                        } else {
                            $img_content = '<span style="width:'.$board['bo_gallery_width'].'px;height:'.$board['bo_gallery_height'].'px">no image</span>';
                        }

                        echo $img_content;
?>							
<!-- <img src="<?php echo G5_URL ?>/data/file/<?echo $list[$i]['bo_table'];?>/<?echo $thumb[0]['file'];?>" class="img-responsive"> -->
						</a><br><br>
						<?
						
						            echo "<a href=\"".$list[$i]['href']."\">";
						            if ($list[$i]['is_notice'])
						                echo "<strong>".$list[$i]['subject']."</strong>";
						            else
						                echo $list[$i]['subject'];
						
						            if ($list[$i]['comment_cnt'])
						                echo $list[$i]['comment_cnt'];
						
						            echo "</a>";
						 if (isset($list[$i]['icon_new'])) echo " " . $list[$i]['icon_new'];
						 if (isset($list[$i]['icon_hot'])) echo " " . $list[$i]['icon_hot'];
						 if (isset($list[$i]['icon_file'])) echo " " . $list[$i]['icon_file'];
						 if (isset($list[$i]['icon_link'])) echo " " . $list[$i]['icon_link'];
						 if (isset($list[$i]['icon_secret'])) echo " " . $list[$i]['icon_secret'];
						 
						 ?>
					 </div>
					<!-- thumbnail -->

					<!-- Modal -->
					<div class="modal" id="gallery10" tabindex="-1" aria-hidden="true" style="display: none;">
						<div class="text-center modal-dialog_img">
							<div id="carousel-example-generic" class="modal-content">
								<div style="margin:10px;">
									<a class="btn btn-warning btn-sm disabled" href="#gallery10" data-toggle="modal" data-dismiss="modal">Next</a>
									<a class="btn btn-success btn-sm" href="#" data-dismiss="modal">Close</a>
									<a class="btn btn-success btn-sm" href="#gallery9" data-toggle="modal" data-dismiss="modal">Prev</a>
								</div>
								<center><img src="<?php echo G5_URL ?>/data/file/<?echo $list[$i]['bo_table'];?>/<?echo $thumb[0]['file'];?>" class="img-responsive"></center>
								<h3><strong><? echo $list[$i]['subject'];?>...</strong></h3>
								<p></p>
								<p><? echo $list[$i]['subject'];?>...</p>
								<p></p>
							</div>
						</div>
					</div>
					<!-- Modal -->			
    <?php }  ?>
    
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li>게시물이 없습니다.</li>
    <?php }  ?>
</div><!--.body1 .clearfix-->
<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->

<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->