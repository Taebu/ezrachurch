<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/style.css">', 0);
?>

<article id="ctt" class="ctt_<?php echo $co_id; ?>">
<!-- <header><h1><?php echo $g5['title']; ?></h1></header> -->
<div id="ctt_con"></div>
<?php echo $str; ?>
</article>