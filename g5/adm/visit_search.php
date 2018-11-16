<?php 
$sub_menu = '200810';
include_once('./_common.php');
include_once(G5_PATH.'/lib/visit.lib.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '접속자검색';
include_once('./admin.head.php');

$search_word = escape_trim($_GET['search_word']);
$search_sort = escape_trim($_GET['search_sort']);

$colspan = 5;
$qstr = 'search_word='.$search_word.'&amp;search_sort='.$search_sort; //페이징 처리관련 변수
$listall = '<a href="'.$_SERVER['PHP_SELF'].'">처음</a>'; //페이지 처음으로 (초기화용도)
?>

<div class="local_sch local_sch01">
    <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">
    <?=$listall?>
    <label for="sch_sort" class="sound_only">검색분류</label>
    <select name="search_sort" id="sch_sort" class="search_sort">
        <?php 
        //echo '<option value="vi_ip" '.($search_sort=='vi_ip'?'selected="selected"':'').'>IP</option>'; //selected 추가
        if($search_sort=='vi_ip'){ //select 안의 옵셥값이 vi_ip면
            echo '<option value="vi_ip" selected="selected">IP</option>'; //selected 추가
        }else{
            echo '<option value="vi_ip">IP</option>';
        }
        if($search_sort=='vi_referer'){ //select 안의 옵셥값이 vi_referer면
            echo '<option value="vi_referer" selected="selected">접속경로</option>'; //selected 추가
        }else{
            echo '<option value="vi_referer">접속경로</option>';
        }
        if($search_sort=='vi_date'){ //select 안의 옵셥값이 vi_date면
            echo '<option value="vi_date" selected="selected">날짜</option>'; //selected 추가
        }else{
            echo '<option value="vi_date">날짜</option>';
        }
        ?>
    </select>
    <label for="sch_word" class="sound_only">검색어</label>
    <input type="text" name="search_word" size="20" value="<?php echo $search_word?>" id="sch_word" class="frm_input">
    <input type="submit" value="검색" class="btn_submit">
    </form>
</div>

<div class="tbl_wrap tbl_head01">
    <table>
    <thead>
    <tr>
        <th scope="col">IP</th>
        <th scope="col">접속 경로</th>
        <th scope="col">브라우저</th>
        <th scope="col">OS</th>
        <th scope="col">일시</th>
    </tr>
    </thead>
    <tbody>
    <?php 
    $sql_common = " from {$g5['visit_table']} ";
    if ($search_sort) {
        if($search_sort=='vi_ip' || $search_sort=='vi_date'){
            $sql_search = " where $search_sort like '$search_word%' ";
        }else{
            $sql_search = " where $search_sort like '%$search_word%' ";
        }
    }
    $sql = " select count(*) as cnt
                {$sql_common}
                {$sql_search} ";
    $row = sql_fetch($sql);
    $total_count = $row['cnt'];

    $rows = $config['cf_page_rows'];
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page == "") $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    $sql = " select * 
                {$sql_common}
                {$sql_search}
                order by vi_id desc
                limit {$from_record}, {$rows} ";
    $result = sql_query($sql);

    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $brow = get_brow($row['vi_agent']);
        $os   = get_os($row['vi_agent']);

        $link = "";
        $referer = "";
        $title = "";
        if ($row['vi_referer']) {

            $referer = get_text(cut_str($row[vi_referer], 255, ""));
            $referer = urldecode($referer);

            if (!is_utf8($referer)) {
                $referer = iconv('euc-kr', 'utf-8', $referer);
            }

            $title = str_replace(array("<", ">"), array("&lt;", "&gt;"), $referer);
            $link = "<a href='$row[vi_referer]' target=_blank title='$title '>";
        }

        if ($is_admin == 'super')
            $ip = $row['vi_ip'];
        else
            $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", "\\1.♡.\\3.\\4", $row['vi_ip']);

        if ($brow == '기타') $brow = '<span title="'.$row['vi_agent'].'">'.$brow.'</span>';
        if ($os == '기타') $os = '<span title="'.$row['vi_agent'].'">'.$os.'</span>';

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_id"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_sort=vi_ip&amp;search_word=<?php echo $ip; ?>"><?php echo $ip; ?></a></td>
        <td><?php echo $link.$title; ?></a></td>
        <td class="td_idsmall"><?php echo $brow; ?></td>
        <td class="td_idsmall"><?php echo $os; ?></td>
        <td class="td_datetime"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_sort=vi_date&amp;search_word=<?php echo $row['vi_date']; ?>"><?php echo $row['vi_date']; ?></a> <?php echo $row['vi_time']; ?></td>
    </tr>
    <?php } ?>
    <?php if ($i == 0) echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>'; ?>
    </tbody>
    </table>
</div>

<?php
$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['PHP_SELF'].'?'.$qstr.'&amp;domain='.$domain.'&amp;page=');
if ($pagelist) {
    echo $pagelist;
}
?>

<script>
$(function(){
    $("#sch_sort").change(function(){ // select #sch_sort의 옵션이 바뀔때
        if($(this).val()=="vi_date"){ // 해당 value 값이 vi_date이면
            $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
        }else{ // 아니라면
            $("#sch_word").datepicker("destroy"); // datepicker 미실행
        }
    });
    if($("#sch_sort option:selected").val()=="vi_date"){ // select #sch_sort 의 옵션중 selected 된것의 값이 vi_date라면
        $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
    }
});

function fvisit_submit(f) 
{
    return true;
}
</script>

<?php 
include_once('./admin.tail.php');
?>
