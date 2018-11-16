<?php
/*
admin@ezrachurch.kr:/web/wp/theme/modificate/skin/board/gallery/get_list.php?bo_table=gallery_01
http://ezrachurch.kr/wp/theme/modificate/skin/board/gallery/get_list.php?bo_table=gallery_01
*/

include_once("/volume1/web/wp/common.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$sql=sprintf("SELECT * FROM newezra.g5_write_%s order by wr_id desc limit 10;",$board['bo_table']);
$result=sql_query($sql);
$json['posts']=array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
  //echo $row['wr_id'];
  $thumb = get_list_thumbnail($board['bo_table'], $row['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);
  $row['src']=$thumb['src'];
  
  $row['img_cotent']=sprintf('<img src="%s" alt="%s" width="%s" height="%s">',
    $thumb['src'],
    $thumb['alt'],
    $board['bo_gallery_width'],
    $board['bo_gallery_height']);

  array_push($json['posts'],$row);

}
echo json_encode($json);