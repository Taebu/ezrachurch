<script type="text/javascript">
function get_masonry()
{
  $.ajax({
    url:"/wp/theme/modificate/skin/board/gallery/get_list.php",
    data:"",
    dataType:"json",
    type:"get",
     success:function(data){
      var object=[];
      $.each(data.posts,function(key,val) {
        object.push('<li class="gall_li" class="posts">'+val.wr_subject+'</li>');
      });
      $("#posts").append(object.join(""));
    }
  });
}

get_masonry();
</script>

<?php 

for ($i=0; $i<count($list); $i++) 
{
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
