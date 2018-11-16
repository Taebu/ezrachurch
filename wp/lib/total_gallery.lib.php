<?php
if (!defined('_GNUBOARD_')) exit;
/*------------------------------------------------------------------------------------------------
  배열을 이용해 특정 게시판에서 최신글 뽑아오기 - 라이브러리
  작성자 : 휴온 박성광
  수정일 : 2008.10.02
  http://www.huon.kr
------------------------------------------------------------------------------------------------*/

// 최신글 추출

function arr_new_gallery($skin_dir="", $board_arr=array(), $rows=10, $subject_len=40, $options="")
{
    global $g5;

    if (!$skin_dir) $skin_dir = 'basic';

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            if(!is_dir($latest_skin_path))
                $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        } else {
            $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        } else {
            $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
        }
    }

    $list = array();
    $board_list = array();

    //검색조건
    if(count($board_arr)>0){
	    $qry_bo_search=" bo_table in(";
	    for($i=0; $i<count($board_arr); $i++) {
		    $bo_table=$board_arr[$i];
		    $qry_bo_search .= "'$bo_table'";
		    if($i<count($board_arr)-1) $qry_bo_search .= ", ";
	    }
		$qry_bo_search .= ")";
	} else {
		$qry_bo_search="(1)";
	}
	//echo $g5[board_new_table];
	//echo $qry_bo_search;

	//new에서 해당되는 게시판의 최신글 뽑아오기
    $sql = "select bo_table, wr_id from $g5[board_new_table]
					where wr_id = wr_parent and $qry_bo_search order by bn_datetime desc LIMIT 0,$rows";

	$result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) {
	    $bo_table=$row[bo_table];
	    $write_table=$g5['write_prefix'].$bo_table;

	    $board_sql = " select * from $g5[board_table] where bo_table = '$bo_table'";
	    $board_list[$i]=sql_fetch($board_sql);
        $list[$i]=sql_fetch("select * from $write_table where wr_id='$row[wr_id]' ");
	    
		//파일 뽑기
        //$img_file_info = "select bf_file from $g5[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' and bf_no = 0";
                
		// 이미지 정보 가져오기
		//$list[$i]['file'] =$img_file_info; 
        $list[$i]['file'] = get_file($board_list[$i][bo_table], $list[$i][wr_id]);
        
        //기타 설정
	    if ($subject_len)
	        $list[$i]['subject'] = conv_subject($list[$i]['wr_subject'], $subject_len, "…");
	    else
	        $list[$i]['subject'] = conv_subject($list[$i]['wr_subject'], $board_list[$i]['bo_subject_len'], "…");

	    $list[$i][href]="$g5[bbs_path]/board.php?bo_table={$board_list[$i][bo_table]}&wr_id={$list[$i][wr_id]}".$qstr;

	    //$list[$i]['is_notice'] = preg_match("/[^0-9]{0,1}{$list[$i]['wr_id']}[\r]{0,1}/", $board_list[$i]['bo_notice']);
	    $list[$i]['is_notice']=false;
	    $arr_notice = split("\n", trim($board_list[$i]['bo_notice']));
	    if(in_array($list[$i]['wr_id'], $arr_notice)) $list[$i]['is_notice']=true;

	    echo "<!--".$board_list[$i]['bo_table']."/".$board_list[$i]['bo_notice']."-->";

	    $list[$i]['icon_new'] = "";
    	if ($list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", $g5['server_time'] - ($board_list[$i]['bo_new'] * 3600)))
        	$list[$i]['icon_new'] = "<img src='$latest_skin_path/img/icon_new.gif' align='absmiddle'>";

        $list[$i]['comment_cnt'] = "";
	    if ($list[$i]['wr_comment'])
	        $list[$i]['comment_cnt'] = "({$list[$i][wr_comment]})";

		if ($board_list[$i]['bo_use_comment'])
	        $list[$i]['comment_href'] = "javascript:win_comment('$g5[bbs_path]/board.php?bo_table=$board_list[$i][bo_table]&wr_id=$list[$i][wr_id]&cwin=1');";
	    else
	        $list[$i]['comment_href'] = $list[$i]['href'];

	    $list[$i]['icon_secret'] = "";
	    if (strstr($list[$i]['wr_option'], "secret"))
	        $list[$i]['icon_secret'] = "<img src='$latest_skin_path/img/icon_secret.gif' align='absmiddle'>";

	    $list[$i]['datetime'] = substr($list[$i]['wr_datetime'],0,10);
	    $list[$i]['datetime2'] = $list[$i]['wr_datetime'];

	    if ($list[$i]['datetime'] == $g5['time_ymd'])
	        $list[$i]['datetime2'] = substr($list[$i]['datetime2'],11,5);
	    else
	        $list[$i]['datetime2'] = substr($list[$i]['datetime2'],5,5);
		// 삭제할 코드 
        //$list[$i]['file'] = get_file($bo_table, $list[$i]['wr_id']);
    }

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>