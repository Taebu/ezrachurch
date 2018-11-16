<?php
$sub_menu = "400100";
include_once('./_common.php');

//auth_check($auth[$sub_menu], 'r');

$sql_common = " from ez_meet a ";
$sql_search = " where (1) ";

if ($is_admin != "super") {
    $sql_common .= " , {$g5['group_table']} b ";
    $sql_search .= " and (a.gr_id = b.gr_id and b.gr_admin = '{$member['mb_id']}') ";
}

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "em_no";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
//echo $sql;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

//$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$sql="select * from ez_meet order by em_no desc";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '강의 관리 페이지';
include_once('./admin.head.php');

$colspan = 15;

function get_status_name($key)
{
    # code...
    $array['ap']="신청완";
    $array['pc']="입금완료";
    $array['co']="신청취소";
    $array['cp']="신청완료";
    $array['rf']="환불요청";
    $array['rc']="환불완료";
    $array['etc']="기타";
    $array['waiting']="대기중";
    $array['receipt']="접수중";
    $array['meet']="강좌중";
    $array['close']="종강";

	if (array_key_exists($key, $array)) {
        $result=$array[$key];
    }else{
        $result="신청";
    }
    return $result;
}
function get_lecture_stat($lec_no)
{
    $result=array();
    $result['success']=0;
    $result['waiting']=0;
    $sql=array();
    $sql[]="select el_status,sum(el_total) el_total ";
    $sql[]="from ez_lecture ";
    $sql[]="where em_lecture_no={$lec_no} ";
    $sql[]="group by el_status;";
    $query=sql_query(join("",$sql));
    for ($i=0; $list=sql_fetch_array($query); $i++) 
    {
        if($list['el_status']=="pc"){
            $result['success']+=$list['el_total'];
        }else{
            $result['waiting']+=$list['el_total'];
        }
    }

    return $result;
}
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    생성된 강의수 <?php echo number_format($total_count) ?>개
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="bo_table"<?php echo get_selected($_GET['sfl'], "bo_subject", true); ?>>TABLE</option>
    <option value="bo_subject"<?php echo get_selected($_GET['sfl'], "bo_subject"); ?>>제목</option>
    <option value="a.gr_id"<?php echo get_selected($_GET['sfl'], "a.gr_id"); ?>>그룹ID</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>

<?php if ($is_admin == 'super') { ?>
<div class="btn_add01 btn_add">
    <a href="./meet_form.php" id="bo_add">강의 추가</a>
</div>
<?php } ?>

<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">
<!-- 사용자 정의 -->
<input type="hidden" name="mode" value="<?php echo $mode ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">게시판 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">강좌번호</th>
        <th scope="col">강의명</th>
        <th scope="col">신청기간</th>
        <th scope="col">강의날짜</th>
        <th scope="col">총 신청 인원</th>
        <th scope="col">신청 완료</th>
        <th scope="col">입금 완료</th>
        <th scope="col">강의상태</th>
        <th scope="col">관리</th>
        <th scope="col">강좌등록일</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $one_update = '<a href="./board_form.php?w=u&amp;bo_table='.$row['bo_table'].'&amp;'.$qstr.'">수정</a>';
        $one_copy = '<a href="./board_copy.php?bo_table='.$row['bo_table'].'" class="board_copy" target="win_board_copy">복사</a>';
        $bg = 'bg'.($i%2);
        $lec_stat=get_lecture_stat($row['em_lecture_no']);
		$lec_sum = $lec_stat['waiting'] + $lec_stat['success']; // 신청한 사람과 입금사람의 최종 합계 수정 2017-03-27 홍슬기

    ?>

    <tr class="<?php echo $bg; ?>" style=text-align:center>
        <td class="td_chk">
            <label for="chk_<?php echo $row['em_no'];?>" class="sound_only"><?php echo get_text($row['bo_subject']) ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $row['em_no'];?>" id="chk_<?php echo $row['em_no'];?>">
        </td>
        <td>
            <?php if ($is_admin == 'super'){ ?>
                <?php //echo get_group_select("gr_id[$i]", $row['gr_id']) ?>
				<?php echo $row['em_lecture_no'];?>회
            <?php }else{ ?>
                <input type="hidden" name="gr_id[<?php echo $i ?>]" value="<?php echo $row['em_no'] ?>"><?php echo $row['gr_subject'] ?>
            <?php } ?>
        </td>
	

<!-- <td><?php echo $row['em_no'];?></td> -->
<td><?php echo $row['em_lecture_name'];?> (<?php echo $row['em_lecture_contents'];?>)</td>
<td><?php echo $row['em_receipt_st'];?> ~ <?php echo $row['em_receipt_ed'];?></td>
<td><?php echo $row['em_lecture_st'];?> ~ <?php echo $row['em_lecture_ed'];?></td>
<!-- <td><?php echo $row['em_author'];?></td> -->
<td><a href="./lecture_list.php?sfl=em_no&stx=<?php echo $row['em_no'] ?>"><?php echo $lec_sum;?>명</a></td>
<td><a href="./lecture_list.php?sfl=em_no&stx=<?php echo $row['em_no'] ?>&lec_stat=waiting"><?php echo $lec_stat['waiting'];?>명</a></a></td>
<td><a href="./lecture_list.php?sfl=em_no&stx=<?php echo $row['em_no'] ?>&lec_stat=success"><?php echo $lec_stat['success'];?>명</a></td>
<!-- <td><?php echo $row['em_lecture_no'];?></td>
<td><?php echo $row['em_place'];?></td>
<td><?php echo $row['em_lecture_contents'];?></td>
<td><?php echo $row['em_phone'];?></td> -->
<td><?php echo get_status_name($row['em_status']);?></td>
<td><a href="./meet_form.php?mode=update&em_no=<?php echo $row['em_no'];?>">수정</a></td>
<td><?php echo $row['em_datetime'];?></td>


    </tr>
    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
   <!--  <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"> -->
    <?php if ($is_admin == 'super') { ?>
    <input type="button"  onclick="javascript:document.pressed=this.value;del_meet();" name="act_button" value="선택삭제">
    <?php } ?>
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<script>
function fboardlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 강의를 정말 삭제하시겠습니까?\n주의!!! 삭제하시면 접수된 내역도 모두 삭제 됩니다.")) {
            return false;
        }
    }

    return true;
}


function del_meet(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 강의를 정말 삭제하시겠습니까?\n주의!!! 삭제하시면 관련 강의 접수된 내역도 모두 삭제 됩니다.")) {
            return false;
        }

    del_meet_update();
    }

}


function del_meet_update()
{

    $("[name=mode]").val("del_array");
    var param=$("#fboardlist").serialize();
    console.log(param);

    $.ajax({
        url:"./ajax/set_meet.php",
        data:param,
        dataType:"json",
        type:"POST",
        success:function(data){
            if(data.success){
                alert("삭제성공");
                location.href="/wp/adm/meet_list.php";
            }else{
                alert("삭실패");
                location.href="/wp/adm/meet_list.php";
            }
        }
    });

}
$(function(){
    $(".board_copy").click(function(){
        window.open(this.href, "win_board_copy", "left=100,top=100,width=550,height=450");
        return false;
    });
});
</script>

<?php
include_once('./admin.tail.php');
?>
