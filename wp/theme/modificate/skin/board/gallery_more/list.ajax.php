<?php
include_once($_SERVER['CONTEXT_DOCUMENT_ROOT'].'/wp/common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
//echo "<pre>";
//print_r($_SERVER);
//echo "</pre>";
if (!$board['bo_table']) {
   alert('존재하지 않는 게시판입니다.', G5_URL);
}

check_device($board['bo_device']);

if (isset($write['wr_is_comment']) && $write['wr_is_comment']) {
    goto_url('./board.php?bo_table='.$bo_table.'&amp;wr_id='.$write['wr_parent'].'#c_'.$wr_id);
}

if (!$bo_table) {
    $msg = "bo_table 값이 넘어오지 않았습니다.\\n\\nboard.php?bo_table=code 와 같은 방식으로 넘겨 주세요.";
    alert($msg);
}

// wr_id 값이 있으면 글읽기
if (isset($wr_id) && $wr_id) {
    // 글이 없을 경우 해당 게시판 목록으로 이동
    if (!$write['wr_id']) {
        $msg = '글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동된 경우입니다.';
        alert($msg, './board.php?bo_table='.$bo_table);
    }

    // 그룹접근 사용
    if (isset($group['gr_use_access']) && $group['gr_use_access']) {
        if ($is_guest) {
            $msg = "비회원은 이 게시판에 접근할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.";
            alert($msg, './login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr));
        }

        // 그룹관리자 이상이라면 통과
        if ($is_admin == "super" || $is_admin == "group") {
            ;
        } else {
            // 그룹접근
            $sql = " select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$board['gr_id']}' and mb_id = '{$member['mb_id']}' ";
            $row = sql_fetch($sql);
            if (!$row['cnt']) {
                alert("접근 권한이 없으므로 글읽기가 불가합니다.\\n\\n궁금하신 사항은 관리자에게 문의 바랍니다.", G5_URL);
            }
        }
    }

    // 로그인된 회원의 권한이 설정된 읽기 권한보다 작다면
    if ($member['mb_level'] < $board['bo_read_level']) {
        if ($is_member)
            alert('글을 읽을 권한이 없습니다.', G5_URL);
        else
            alert('글을 읽을 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', './login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr));
    }

    // 본인확인을 사용한다면
    if ($config['cf_cert_use'] && !$is_admin) {
        // 인증된 회원만 가능
        if ($board['bo_use_cert'] != '' && $is_guest) {
            alert('이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', './login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr));
        }

        if ($board['bo_use_cert'] == 'cert' && !$member['mb_certify']) {
            alert('이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 본인확인을 해주시기 바랍니다.', G5_URL);
        }

        if ($board['bo_use_cert'] == 'adult' && !$member['mb_adult']) {
            alert('이 게시판은 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 본인확인을 다시 해주시기 바랍니다.', G5_URL);
        }

        if ($board['bo_use_cert'] == 'hp-cert' && $member['mb_certify'] != 'hp') {
            alert('이 게시판은 휴대폰 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 휴대폰 본인확인을 해주시기 바랍니다.', G5_URL);
        }

        if ($board['bo_use_cert'] == 'hp-adult' && (!$member['mb_adult'] || $member['mb_certify'] != 'hp')) {
            alert('이 게시판은 휴대폰 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 휴대폰 본인확인을 다시 해주시기 바랍니다.', G5_URL);
        }
    }

    // 자신의 글이거나 관리자라면 통과
    if (($write['mb_id'] && $write['mb_id'] == $member['mb_id']) || $is_admin) {
        ;
    } else {
        // 비밀글이라면
        if (strstr($write['wr_option'], "secret"))
        {
            // 회원이 비밀글을 올리고 관리자가 답변글을 올렸을 경우
            // 회원이 관리자가 올린 답변글을 바로 볼 수 없던 오류를 수정
            $is_owner = false;
            if ($write['wr_reply'] && $member['mb_id'])
            {
                $sql = " select mb_id from {$write_table}
                            where wr_num = '{$write['wr_num']}'
                            and wr_reply = ''
                            and wr_is_comment = 0 ";
                $row = sql_fetch($sql);
                if ($row['mb_id'] == $member['mb_id'])
                    $is_owner = true;
            }

            $ss_name = 'ss_secret_'.$bo_table.'_'.$write['wr_num'];

            if (!$is_owner)
            {
                //$ss_name = "ss_secret_{$bo_table}_{$wr_id}";
                // 한번 읽은 게시물의 번호는 세션에 저장되어 있고 같은 게시물을 읽을 경우는 다시 비밀번호를 묻지 않습니다.
                // 이 게시물이 저장된 게시물이 아니면서 관리자가 아니라면
                //if ("$bo_table|$write['wr_num']" != get_session("ss_secret"))
                if (!get_session($ss_name))
                    goto_url('./password.php?w=s&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr);
            }

            set_session($ss_name, TRUE);
        }
    }

    // 한번 읽은글은 브라우저를 닫기전까지는 카운트를 증가시키지 않음
    $ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
    if (!get_session($ss_name))
    {
        sql_query(" update {$write_table} set wr_hit = wr_hit + 1 where wr_id = '{$wr_id}' ");

        // 자신의 글이면 통과
        if ($write['mb_id'] && $write['mb_id'] == $member['mb_id']) {
            ;
        } else if ($is_guest && $board['bo_read_level'] == 1 && $write['wr_ip'] == $_SERVER['REMOTE_ADDR']) {
            // 비회원이면서 읽기레벨이 1이고 등록된 아이피가 같다면 자신의 글이므로 통과
            ;
        } else {
            // 글읽기 포인트가 설정되어 있다면
            if ($config['cf_use_point'] && $board['bo_read_point'] && $member['mb_point'] + $board['bo_read_point'] < 0)
                alert('보유하신 포인트('.number_format($member['mb_point']).')가 없거나 모자라서 글읽기('.number_format($board['bo_read_point']).')가 불가합니다.\\n\\n포인트를 모으신 후 다시 글읽기 해 주십시오.');

            insert_point($member['mb_id'], $board['bo_read_point'], ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']).' '.$wr_id.' 글읽기', $bo_table, $wr_id, '읽기');
        }

        set_session($ss_name, TRUE);
    }

    $g5['title'] = strip_tags(conv_subject($write['wr_subject'], 255))." > ".((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']);
} else {
    if ($member['mb_level'] < $board['bo_list_level']) {
        if ($member['mb_id'])
            alert('목록을 볼 권한이 없습니다.', G5_URL);
        else
            alert('목록을 볼 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', './login.php?'.$qstr.'&url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.($qstr?'&amp;':'')));
    }

    // 본인확인을 사용한다면
    if ($config['cf_cert_use'] && !$is_admin) {
        // 인증된 회원만 가능
        if ($board['bo_use_cert'] != '' && $is_guest) {
            alert('이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', './login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr));
        }

        if ($board['bo_use_cert'] == 'cert' && !$member['mb_certify']) {
            alert('이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 본인확인을 해주시기 바랍니다.', G5_URL);
        }

        if ($board['bo_use_cert'] == 'adult' && !$member['mb_adult']) {
            alert('이 게시판은 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 본인확인을 다시 해주시기 바랍니다.', G5_URL);
        }

        if ($board['bo_use_cert'] == 'hp-cert' && $member['mb_certify'] != 'hp') {
            alert('이 게시판은 휴대폰 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 휴대폰 본인확인을 해주시기 바랍니다.', G5_URL);
        }

        if ($board['bo_use_cert'] == 'hp-adult' && (!$member['mb_adult'] || $member['mb_certify'] != 'hp')) {
            alert('이 게시판은 휴대폰 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 휴대폰 본인확인을 다시 해주시기 바랍니다.', G5_URL);
        }
    }

    if (!isset($page) || (isset($page) && $page == 0)) $page = 1;

    $g5['title'] = ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']).' '.$page.' 페이지';
}

$width = $board['bo_table_width'];
if ($width <= 100)
    $width .= '%';
else
    $width .='px';

// IP보이기 사용 여부
$ip = "";
$is_ip_view = $board['bo_use_ip_view'];
if ($is_admin) {
    $is_ip_view = true;
    if (array_key_exists('wr_ip', $write)) {
        $ip = $write['wr_ip'];
    }
} else {
    // 관리자가 아니라면 IP 주소를 감춘후 보여줍니다.
    if (isset($write['wr_ip'])) {
        $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $write['wr_ip']);
    }
}

// 분류 사용
$is_category = false;
$category_name = '';
if ($board['bo_use_category']) {
    $is_category = true;
    if (array_key_exists('ca_name', $write)) {
        $category_name = $write['ca_name']; // 분류명
    }
}

// 추천 사용
$is_good = false;
if ($board['bo_use_good'])
    $is_good = true;

// 비추천 사용
$is_nogood = false;
if ($board['bo_use_nogood'])
    $is_nogood = true;

// 분류 사용 여부
$is_category = false;
$category_option = '';
if ($board['bo_use_category']) {
    $is_category = true;
    $category_href = G5_BBS_URL.'/board.php?bo_table='.$bo_table;

    $category_option .= '<li><a href="'.$category_href.'"';
    if ($sca=='')
        $category_option .= ' id="bo_cate_on"';
    $category_option .= '>전체</a></li>';

    $categories = explode('|', $board['bo_category_list']); // 구분자가 , 로 되어 있음
    for ($i=0; $i<count($categories); $i++) {
        $category = trim($categories[$i]);
        if ($category=='') continue;
        $category_option .= '<li><a href="'.($category_href."&amp;sca=".urlencode($category)).'"';
        $category_msg = '';
        if ($category==$sca) { // 현재 선택된 카테고리라면
            $category_option .= ' id="bo_cate_on"';
            $category_msg = '<span class="sound_only">열린 분류 </span>';
        }
        $category_option .= '>'.$category_msg.$category.'</a></li>';
    }
}

$sop = strtolower($sop);
if ($sop != 'and' && $sop != 'or')
    $sop = 'and';

// 분류 선택 또는 검색어가 있다면
$stx = trim($stx);
if ($sca || $stx) {
    $sql_search = get_sql_search($sca, $sfl, $stx, $sop);

    // 가장 작은 번호를 얻어서 변수에 저장 (하단의 페이징에서 사용)
    $sql = " select MIN(wr_num) as min_wr_num from {$write_table} ";
    $row = sql_fetch($sql);
    $min_spt = (int)$row['min_wr_num'];

    if (!$spt) $spt = $min_spt;

    $sql_search .= " and (wr_num between {$spt} and ({$spt} + {$config['cf_search_part']})) ";

    // 원글만 얻는다. (코멘트의 내용도 검색하기 위함)
    // 라엘님 제안 코드로 대체 http://sir.kr/g5_bug/2922
    $sql = " SELECT COUNT(DISTINCT `wr_parent`) AS `cnt` FROM {$write_table} WHERE {$sql_search} ";
    $row = sql_fetch($sql);
    $total_count = $row['cnt'];
    /*
    $sql = " select distinct wr_parent from {$write_table} where {$sql_search} ";
    $result = sql_query($sql);
    $total_count = sql_num_rows($result);
    */
} else {
    $sql_search = "";

    $total_count = $board['bo_count_write'];
}

if(G5_IS_MOBILE) {
    $page_rows = $board['bo_mobile_page_rows'];
    $list_page_rows = $board['bo_mobile_page_rows'];
} else {
    $page_rows = $board['bo_page_rows'];
    $list_page_rows = $board['bo_page_rows'];
}

if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)

// 년도 2자리
$today2 = G5_TIME_YMD;

$list = array();
$i = 0;
$notice_count = 0;
$notice_array = array();

// 공지 처리
if (!$sca && !$stx) {
    $arr_notice = explode(',', trim($board['bo_notice']));
    $from_notice_idx = ($page - 1) * $page_rows;
    if($from_notice_idx < 0)
        $from_notice_idx = 0;
    $board_notice_count = count($arr_notice);

    for ($k=0; $k<$board_notice_count; $k++) {
        if (trim($arr_notice[$k]) == '') continue;

        $row = sql_fetch(" select * from {$write_table} where wr_id = '{$arr_notice[$k]}' ");

        if (!$row['wr_id']) continue;

        $notice_array[] = $row['wr_id'];

        if($k < $from_notice_idx) continue;

        $list[$i] = get_list($row, $board, $board_skin_url, G5_IS_MOBILE ? $board['bo_mobile_subject_len'] : $board['bo_subject_len']);
        $list[$i]['is_notice'] = true;

        $i++;
        $notice_count++;

        if($notice_count >= $list_page_rows)
            break;
    }
}

$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

// 공지글이 있으면 변수에 반영
if(!empty($notice_array)) {
    $from_record -= count($notice_array);

    if($from_record < 0)
        $from_record = 0;

    if($notice_count > 0)
        $page_rows -= $notice_count;

    if($page_rows < 0)
        $page_rows = $list_page_rows;
}

// 관리자라면 CheckBox 보임
$is_checkbox = false;
if ($is_member && ($is_admin == 'super' || $group['gr_admin'] == $member['mb_id'] || $board['bo_admin'] == $member['mb_id']))
    $is_checkbox = true;

// 정렬에 사용하는 QUERY_STRING
$qstr2 = 'bo_table='.$bo_table.'&amp;sop='.$sop;

// 0 으로 나눌시 오류를 방지하기 위하여 값이 없으면 1 로 설정
$bo_gallery_cols = $board['bo_gallery_cols'] ? $board['bo_gallery_cols'] : 1;
$td_width = (int)(100 / $bo_gallery_cols);

// 정렬
// 인덱스 필드가 아니면 정렬에 사용하지 않음
//if (!$sst || ($sst && !(strstr($sst, 'wr_id') || strstr($sst, "wr_datetime")))) {
if (!$sst) {
    if ($board['bo_sort_field']) {
        $sst = $board['bo_sort_field'];
    } else {
        $sst  = "wr_num, wr_reply";
        $sod = "";
    }
} else {
    // 게시물 리스트의 정렬 대상 필드가 아니라면 공백으로 (nasca 님 09.06.16)
    // 리스트에서 다른 필드로 정렬을 하려면 아래의 코드에 해당 필드를 추가하세요.
    // $sst = preg_match("/^(wr_subject|wr_datetime|wr_hit|wr_good|wr_nogood)$/i", $sst) ? $sst : "";
    $sst = preg_match("/^(wr_datetime|wr_hit|wr_good|wr_nogood)$/i", $sst) ? $sst : "";
}

if(!$sst)
    $sst  = "wr_num, wr_reply";

if ($sst) {
    $sql_order = " order by {$sst} {$sod} ";
}

if ($sca || $stx) {
    $sql = " select distinct wr_parent from {$write_table} where {$sql_search} {$sql_order} limit {$from_record}, $page_rows ";
} else {
    $sql = " select * from {$write_table} where wr_is_comment = 0 ";
    if(!empty($notice_array))
        $sql .= " and wr_id not in (".implode(', ', $notice_array).") ";
    $sql .= " {$sql_order} limit {$from_record}, $page_rows ";
}

// 페이지의 공지개수가 목록수 보다 작을 때만 실행
if($page_rows > 0) {
    $result = sql_query($sql);

    $k = 0;

    while ($row = sql_fetch_array($result))
    {
        // 검색일 경우 wr_id만 얻었으므로 다시 한행을 얻는다
        if ($sca || $stx)
            $row = sql_fetch(" select * from {$write_table} where wr_id = '{$row['wr_parent']}' ");

        $list[$i] = get_list($row, $board, $board_skin_url, G5_IS_MOBILE ? $board['bo_mobile_subject_len'] : $board['bo_subject_len']);
        if (strstr($sfl, 'subject')) {
            $list[$i]['subject'] = search_font($stx, $list[$i]['subject']);
        }
        $list[$i]['is_notice'] = false;
        $list_num = $total_count - ($page - 1) * $list_page_rows - $notice_count;
        $list[$i]['num'] = $list_num - $k;

        $i++;
        $k++;
    }
}


function get_paging_ajax($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
        $str .= '<a onclick="listAjax(1)" class="pg_page pg_start">처음</a>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<a onclick="listAjax('.($start_page-1).')" class="pg_page pg_prev">이전</a>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<a onclick="listAjax('.$k.')" class="pg_page">'.$k.'<span class="sound_only">페이지</span></a>'.PHP_EOL;
            else
                $str .= '<span class="sound_only">열린</span><strong class="pg_current">'.$k.'</strong><span class="sound_only">페이지</span>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<a onclick="listAjax('.($end_page-1).')" class="pg_page pg_next">다음</a>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<a onclick="listAjax('.$total_page.')" class="pg_page pg_end">맨끝</a>'.PHP_EOL;
    }

    if ($str)
        return "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
    else
        return "";
}


$write_pages = get_paging_ajax(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr.'&amp;page=');

$list_href = '';
$prev_part_href = '';
$next_part_href = '';
if ($sca || $stx) {
    $list_href = './board.php?bo_table='.$bo_table;

    $patterns = array('#&amp;page=[0-9]*#', '#&amp;spt=[0-9\-]*#');

    //if ($prev_spt >= $min_spt)
    $prev_spt = $spt - $config['cf_search_part'];
    if (isset($min_spt) && $prev_spt >= $min_spt) {
        $qstr1 = preg_replace($patterns, '', $qstr);
        $prev_part_href = './board.php?bo_table='.$bo_table.$qstr1.'&amp;spt='.$prev_spt.'&amp;page=1';
        $write_pages = page_insertbefore($write_pages, '<a href="'.$prev_part_href.'" class="pg_page pg_prev">이전검색</a>');
    }

    $next_spt = $spt + $config['cf_search_part'];
    if ($next_spt < 0) {
        $qstr1 = preg_replace($patterns, '', $qstr);
        $next_part_href = './board.php?bo_table='.$bo_table.$qstr1.'&amp;spt='.$next_spt.'&amp;page=1';
        $write_pages = page_insertafter($write_pages, '<a href="'.$next_part_href.'" class="pg_page pg_end">다음검색</a>');
    }
}


$write_href = '';
if ($member['mb_level'] >= $board['bo_write_level']) {
    $write_href = './write.php?bo_table='.$bo_table;
}

$nobr_begin = $nobr_end = "";
if (preg_match("/gecko|firefox/i", $_SERVER['HTTP_USER_AGENT'])) {
    $nobr_begin = '<nobr>';
    $nobr_end   = '</nobr>';
}

// RSS 보기 사용에 체크가 되어 있어야 RSS 보기 가능 061106
$rss_href = '';
if ($board['bo_use_rss_view']) {
    $rss_href = './rss.php?bo_table='.$bo_table;
}

$stx = get_text(stripslashes($stx));



// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;


         for ($i=0; $i<count($list); $i++) {
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
                           /*
						   $img_content = '<iframe frameborder=\"0\"   width=\"853\" height=\"480\"  ';
                           $img_content.= ' src=\"https://www.youtube.com/embed/'.$match[1];
                           $img_content.= 'autoplay=0&controls=1&loop=1&rel=1';
                           $img_content.= '&showinfo=1&autohide=1&start=5\" allowfullscreen></iframe>';
							*/

                           //$img_content = '<iframe src="'.$list[$i]['link'][1].'" width="560" height="315" frameborder="0" allowfullscreen></iframe> ';

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
							//$golink = $list[$i]['link'][1]; 
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


<?php
        
        
        sleep(1);
        ?>▤<?=$write_pages?>▤<?php echo count($list);?>