<?php
if (!defined('_GNUBOARD_')) exit;

/* 다중게시판 최신글 추출 Latest */
/* 제작 : SIR 내컴퓨터 */
/* 버전 : 1.0.2 */
/* 마스타님께서 if (!G5_USE_CACHE || !file_exists($cache_file)) { 부분 이상 검출 */

function latest($skin_dir='basic', $bo_table=false, $rows=10, $subject_len=40,$bo_title=false)
{
    global $g5;
    static $css = array();
    $bo_table = explode(';' , $bo_table);
    
    /* 모바일 스킨 디렉토리 */
    if(G5_IS_MOBILE) {
        $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
    }
    /* 데스크탑 스킨 디렉토리 */
    else {
        $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }
    
    /* Latest 케시파일 생성 */
    $cache_botable = "";
    $cache_time = date("Ymdhi");
    for($y=0;$y<count($bo_table);$y++){
        $cache_botable .= $bo_table[$y];
    }
    $cache_newfile = G5_DATA_PATH."/cache/latest-{$cache_botable}-{$skin_dir}-{$rows}-{$subject_len}-{$cache_time}.php";

    /* 최근 1분간 새로 등록된 케시가 없을경우 DB에서 데이터 추출후 신규 케시 생성 */
    if (!G5_USE_CACHE || !file_exists($cache_newfile)) {
            
        /* 다중 게시판 게시물 추출 */
        $sql = "select a.* from ";
        for($y=0;$y<count($bo_table);$y++){
            if($y!=0) $sql .= "union all ";
            else $sql .= "( ";
            $tmp_write_table = $g5['write_prefix'] . $bo_table[$y]; // 게시판 테이블 전체이름
            $sql .= "select *,'{$bo_table[$y]}' as `bo_table` from {$tmp_write_table} "; // 
            if($y+1==count($bo_table)) $sql .= ") ";
        }
        $sql .= "a where `wr_is_comment` = 0 order by `wr_datetime` DESC limit ".$rows." ";
        $result = sql_query($sql);
        
        /* 다중 게시판 게시물 리스트 추출 */
        $list = array();
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            /* 추출된 게시물이 등록된 게시판 매칭 */
            for($y=0;$y<count($bo_table);$y++){
                if ($bo_table[$y]==$row['bo_table']){
                    $sql = "select * from `{$g5['board_table']}` where `bo_table` = '{$bo_table[$y]}' "; 
                    $board = sql_fetch($sql);
                }
            }
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
        }
        
        /* 기존에 등록된 케시파일을 삭제 */
        $files = glob(G5_DATA_PATH."/cache/latest-{$cache_botable}-{$skin_dir}-{$rows}-{$subject_len}-*");
        if (is_array($files)) {
            $cnt=0;
            foreach ($files as $cache_oldfile) {
                $cnt++;
                unlink($cache_oldfile);
            }
        }
        
        /* 케시파일 신규 생성 */
        $handle = fopen($cache_newfile, 'w');
        $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject=\"".get_text($board['bo_subject'])."\";\n\$list=".var_export($list, true)."?>";
        fwrite($handle, $cache_content);
        fclose($handle);
    }
    
    /* 케시파일 로드 */
    include_once($cache_newfile);
    
    /* List에서 사용할 Board 데이터 추출 */
    $bo_table = $bo_table[0];
    if($bo_title) $bo_subject = $bo_title;
    
    /* 스킨연결 */
    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();
    
    return $content;
}
?>