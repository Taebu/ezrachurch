<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<link rel="stylesheet" href="<?php echo $latest_skin_url ?>/style.css">
	<div class="body2 clearfix">
		<div class='intro-title'><h2>News</h2><div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div></div>
<?php for ($i=0; $i<count($list); $i++) {  ?>
				<div class="col-sm-4">
					<p><strong>
					<?            //echo $list[$i]['icon_reply']." ";
					            
					            if ($list[$i]['is_notice'])
					                echo "<strong>".$list[$i]['subject']."</strong>";
					            else
					                echo $list[$i]['subject'];
					
					            if ($list[$i]['comment_cnt'])
					                echo "&nbsp;&nbsp;&nbsp;".$list[$i]['comment_cnt'];
					
					            echo "</a>";?></strong></p>
					<p><?echo $list[$i]['content'];?></p>
					<?echo "<a href=\"".$list[$i]['href']." class=\"btn btn-default\">Read More...</a><br><br>";?>
				</div>	
			<?php }  ?>	
</div>