<?
if (!defined('_GNUBOARD_')) exit;

// 최근 코멘트 추출
function newcomment($title="New Comment", $skin_dir="basic", $rows=10, $subject_len=40, $options="")
{
    global $g4, $g4_board, $g4_board, $g4_table_in, $member, $is_admin;

    if ($skin_dir)
        $comment_skin_path = "$g4[path]/skin/newcomment/$skin_dir";
    else
        $comment_skin_path = "$g4[path]/skin/newcomment/basic";

    $list = array();
	
	// fixing.lib.php 파일에서 사용된 $g4_table_in 을 그대로 사용한다.
    $sql = " select bo_table, wr_id from $g4[board_new_table] where wr_id <> wr_parent $g4_table_in order by bn_datetime desc limit 0, $rows ";
    $result = sql_query($sql);
	$b = 0;
    for ($i=0; $row = sql_fetch_array($result); $i++) {
	   $id = $row[wr_id];
	   $bot = $row[bo_table];
	   $new[$bot][$id] = $i;
	   // 중복배열제거 하면서 테이블별 wr_id 값을 정리
	   if($new_in[$bot]){
			$new_in[$bot] .= ", '{$id}'";
	   }else{
			$new_bo[$b] = $bot;
			$new_in[$bot] = "'{$id}'";
			$b++;
	   }
    }
	$bo_new[count] = $i;
	for($i=0; $i<count($new_bo); $i++){
		//배열에서 이름 찾기
		$board = $g4_board[$g4_board['num'][$new_bo[$i]]];
		$tmp_write_table = $g4['write_prefix'] . $new_bo[$i];
		$sql = " select * from $tmp_write_table where wr_id in ( {$new_in[$new_bo[$i]]} ) ";
		$result = sql_query($sql);
		for ($q=0; $row = sql_fetch_array($result); $q++) {
			$num = $new[$new_bo[$i]][$row['wr_id']];						
			$comment[$num][content1] = "비밀글 입니다.";
			// 최고관리자이거나 작성자이거나 비밀코멘트가 아닐때 코멘트를 보여줍니다.
    		if (!strstr($row[wr_option], "secret") || $is_admin || ($row[mb_id]==$member[mb_id] && $member[mb_id])) {
    		    $comment[$num][content1] = cut_str($row[wr_content], $subject_len);
    		}
			$comment[$num]['icon_new'] = "";
   			if ($row['wr_datetime'] >= date("Y-m-d H:i:s", $g4['server_time'] - ($board['bo_new'] * 3600)))
        	$comment[$num]['icon_new'] = "<img src='$comment_skin_path/img/icon_new.gif' align='absmiddle'>";
			$comment[$num][href] = "{$g4[bbs_path]}/board.php?bo_table={$new_bo[$i]}&wr_id={$row['wr_id']}#{$row['wr_parent']}";
		}
	}

    ob_start();
    include "$comment_skin_path/newcomment.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
} 

?>