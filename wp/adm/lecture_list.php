<?php
$sub_menu = "400300";
include_once('./_common.php');

//auth_check($auth[$sub_menu], 'r');

$sql_common = " from ez_lecture a ";
$sql_search = " where (1) ";

if ($is_admin != "super") {
    $sql_common .= " , {$g5['group_table']} b ";
    $sql_search .= " and (a.gr_id = b.gr_id and b.gr_admin = '{$member['mb_id']}') ";
}

$lec_stat=$_GET['lec_stat'];
if($lec_stat=="success")
{
    $sql_search2 .= " and el_status in ('pc') ";
}else if($lec_stat=="waiting"){
    $sql_search2 .= " and el_status not in ('pc') ";
}else if($lec_stat=="ap"){
    $sql_search2 .= " and el_status in ('ap') ";
}else if($lec_stat=="co"){
    $sql_search2 .= " and el_status in ('co') ";
}else if($lec_stat=="pc"){
    $sql_search2 .= " and el_status in ('pc') ";
}else if($lec_stat=="cp"){
    $sql_search2 .= " and el_status in ('cp') ";
}else if($lec_stat=="rf"){
    $sql_search2 .= " and el_status in ('rf') ";
}else if($lec_stat=="rc"){
    $sql_search2 .= " and el_status in ('rc') ";
}else if($lec_stat=="etc"){
    $sql_search2 .= " and el_status in ('etc') ";
}
 
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "mb_id" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "em_no" :
            $sql_search .= " ($sfl like '$stx') ";
            break;
        case "el_name" :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";   
}

if (!$sst) {
   $sst  = "el_no desc, em_no";
   $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$count_sql="select el_status,sum(el_total) cnt from ez_lecture  {$sql_search}  group by el_status;";

$total_cnt=$el_cnt=$ap_cnt=$pc_cnt=$co_cnt=$cp_cnt=$rf_cnt=$rc_cnt=$etc_cnt=0;
$result = sql_query($count_sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
${$row['el_status']."_cnt"}=$row['cnt'];
$total_cnt=(int)($total_cnt+$row['cnt']);
}
//$rows = $page_rows?$page_rows:$config['cf_page_rows'];
$rows = 1000;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

//$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$sql="select * from ez_lecture  {$sql_search} {$sql_search2} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '강의 신청 인원';
include_once('./admin.head.php');

$colspan = 15;

function get_status_name($key)
{
    # code...
    $array['ap']="신청완료";
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
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    강좌신청 <?php echo number_format($total_cnt) ?>개
	<select name="page_rows" id="page_rows" onchange="javascript:this.onsubmit;">
		<option value="" <?php echo $page_rows=="20"?"selected":"";?>>20</option>
		<option value="" <?php echo $page_rows=="30"?"selected":"";?>>30</option>
		<option value="" <?php echo $page_rows=="50"?"selected":"";?>>50</option>
		<option value="" <?php echo $page_rows=="100"?"selected":"";?>>100</option>
		<option value="" <?php echo $page_rows=="1000"?"selected":"";?>>1000</option>
	</select>
</div>

<style>
    

.badge {
  display: inline-block;
  min-width: 10px;
  font-size: 12px;
  color: #ff4f91;
  vertical-align: middle;
  white-space: nowrap;
  letter-spacing: 0.08em;
  font-family: NanumSquare, sans-serif;
  line-height: 24px;
//  border-radius: 12px;
  text-align: center;
  margin-left: auto;
  margin-right: auto;

}

.badge:before {
  font-family: NanumSquare, sans-serif;
  color: #a7b0b4;
  padding-right:5px;
  font-size: 16px;
  left: 0px;
  top: 0px;
}

.btn .badge {
  position: relative;
  top: -1px;
}

</style>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="em_no"<?php echo get_selected($_GET['sfl'], "em_no", true); ?>>강좌번호</option>
    <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>아이디</option>
    <option value="el_name"<?php echo get_selected($_GET['sfl'], "el_name"); ?>>이름</option>
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

<form name="fboardlist" id="fboardlist" action="./lecture_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">
<div class="local_ov01 local_ov" style="background:#383a3f;padding:0;margin:0;">
    
<ul id="gnb_1dul" style="list-style:none">
    <li class="gnb_1dli<?php echo $lec_stat==""?" gnb_1dli_air":"";?>"><a href="./lecture_list.php?sfl=em_no&amp;stx=<?php echo $stx ?>" class="gnb_1da">총 신청인원  <span class='badge'><?php echo $total_cnt;?></span>명</a></li>
    <li class="gnb_1dli<?php echo $lec_stat=="ap"?" gnb_1dli_air":"";?>"><a href="./lecture_list.php?sfl=em_no&amp;stx=<?php echo $stx ?>&amp;lec_stat=ap" class="gnb_1da">신청완료 <span class='badge'><?php echo $ap_cnt;?></span>명</a></li>
    <li class="gnb_1dli<?php echo $lec_stat=="pc"?" gnb_1dli_air":"";?>"><a href="./lecture_list.php?sfl=em_no&amp;stx=<?php echo $stx ?>&amp;lec_stat=pc" class="gnb_1da">입금완료  <span class='badge'><?php echo $pc_cnt;?></span>명</a></li>
    <li class="gnb_1dli<?php echo $lec_stat=="co"?" gnb_1dli_air":"";?>"><a href="./lecture_list.php?sfl=em_no&amp;stx=<?php echo $stx ?>&amp;lec_stat=co" class="gnb_1da">신청취소  <span class='badge'><?php echo $co_cnt;?></span>명</a></li>
    <li class="gnb_1dli<?php echo $lec_stat=="rf"?" gnb_1dli_air":"";?>"><a href="./lecture_list.php?sfl=em_no&amp;stx=<?php echo $stx ?>&amp;lec_stat=rf" class="gnb_1da">환불신청  <span class='badge'><?php echo $rf_cnt;?></span>명</a></li>
    <li class="gnb_1dli<?php echo $lec_stat=="rc"?" gnb_1dli_air":"";?>"><a href="./lecture_list.php?sfl=em_no&amp;stx=<?php echo $stx ?>&amp;lec_stat=rc" class="gnb_1da">환불완료  <span class='badge'><?php echo $rc_cnt;?></span>명</a></li>
    <li class="gnb_1dli<?php echo $lec_stat=="etc"?" gnb_1dli_air":"";?>"><a href="./lecture_list.php?sfl=em_no&amp;stx=<?php echo $stx ?>&amp;lec_stat=etc" class="gnb_1da">기타  <span class='badge'><?php echo $etc_cnt;?></span>명</a></li>
</ul>
</div>
<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">게시판 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
<!--         <th scope="col"><?php echo subject_sort_link('a.gr_id') ?>그룹</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_table') ?>TABLE</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_skin', '', 'desc') ?>스킨</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_mobile_skin', '', 'desc') ?>모바일<br>스킨</span></a></th>
        <th scope="col"><?php echo subject_sort_link('bo_subject') ?>제목</a></th>
        <th scope="col">읽기P<span class="sound_only">포인트</span></th>
        <th scope="col">쓰기P<span class="sound_only">포인트</span></th>
        <th scope="col">댓글P<span class="sound_only">포인트</span></th>
        <th scope="col">다운P<span class="sound_only">포인트</span></th>
        <th scope="col"><?php echo subject_sort_link('bo_use_sns') ?>SNS<br>사용</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_use_search') ?>검색<br>사용</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_order') ?>출력<br>순서</a></th>
        <th scope="col">접속기기</th>
        <th scope="col">관리</th>

		-->
       <th scope="col"><?php echo subject_sort_link('el_no') ?>번호</th>
       <th scope="col"><?php echo subject_sort_link('em_no') ?>강좌번호</th>
       <th scope="col">강좌구분</th>
       <th scope="col"><?php echo subject_sort_link('mb_id') ?>아이디</th>
       <th scope="col"><?php echo subject_sort_link('el_name') ?>이름</th>
       <th scope="col">직분</th>
       <th scope="col">성별</th>
       <th scope="col">휴대폰번호</th>
       <!-- <th scope="col">전화번호</th> -->
	   <th scope="col">출석교회</th>
       <th scope="col"><?php echo subject_sort_link('el_count') ?>기존참가횟수</th>
       <th scope="col"><?php echo subject_sort_link('el_total') ?>총참가인원</th>
       <th scope="col">상태변경</th>
       <th scope="col"><?php echo subject_sort_link('el_datetime') ?>등록시간</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $one_update = '<a href="./board_form.php?w=u&amp;bo_table='.$row['bo_table'].'&amp;'.$qstr.'">수정</a>';
        $one_copy = '<a href="./board_copy.php?bo_table='.$row['bo_table'].'" class="board_copy" target="win_board_copy">복사</a>';
        $bg = 'bg'.($i%2);
		 $birth_index=strlen($row['el_birth'])==6?0:2;
	?>


    <tr class="<?php echo $bg; ?>" style=text-align:center>
        <td class="td_chk">
            <label for="chk_<?php echo $row['el_no']; ?>" class="sound_only"><?php echo get_text($row['bo_subject']) ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $row['el_no'];?>" id="chk_<?php echo $row['el_no'];?>">
        </td>
<!--         <td>
            <?php if ($is_admin == 'super'){ ?>
                <?php //echo get_group_select("gr_id[$i]", $row['gr_id']) ?>
            <?php }else{ ?>
                <input type="hidden" name="gr_id[<?php echo $i ?>]" value="<?php echo $row['em_no'] ?>"><?php echo $row['gr_subject'] ?>
            <?php } ?>
        </td> -->

<td><?php echo $row['el_no'];?></td>
<td><?php printf("%s회 (%s)",$row['em_lecture_no'],$row['em_no']);?></td>
<td><?php printf("%s",$row['em_lecture_type']);?></td>
<td><?php echo $row['mb_id'];?></td>
<!-- <td><?php echo $row['el_stdt'];?></td>
<td><?php echo $row['el_eddt'];?></td> -->
<td><?php printf("%s (%s)",$row['el_name'],substr($row['el_birth'],$birth_index,2));?></td>
<!-- <td><?php echo $row['el_email'];?></td> -->
<!-- <td><?php echo $row['em_no'];?></td> -->
<!-- <td><?php echo $row['em_lecture_no'];?></td> -->
<td><?php echo $row['el_position'];?></td>
<td><?php echo $row['el_sex'];?></td>
<!-- <td><?php echo $row['el_birth'];?></td> -->
<td><?php echo $row['el_hp'];?></td>
<!-- <td><?php echo $row['el_tel'];?></td> -->
<!-- <td><?php echo $row['mb_zip1'];?></td>
<td><?php echo $row['mb_zip2'];?></td>
<td><?php echo $row['mb_addr1'];?></td>
<td><?php echo $row['mb_addr2'];?></td>
<td><?php echo $row['mb_addr3'];?></td>
<td><?php echo $row['mb_addr_jibeon'];?></td> -->
<!--<td><?php echo $row['el_ip'];?></td>-->
<!--<td><?php echo $row['el_comment'];?></td>-->
<!-- <td><?php echo $row['el_job'];?></td> -->
<!-- <td><?php echo $row['el_group'];?></td> -->
<td><?php echo $row['el_church'];?></td>
<!-- <td><?php echo $row['el_marriedyn'];?></td> -->
<td><?php echo $row['el_count'];?>번</td>
<td><?php echo $row['el_total'];?>명</td>
<td><span id="el_<?php echo $row['el_no'];?>"><?php echo get_status_name($row['el_status']);?></span></td>
<td><?php echo $row['el_datetime'];?></td>
    </tr>
    <?php
    
    if($row['el_total']>1&&$row['el_addperson']!="")
    {
    	$arr_person=explode("&",$row['el_addperson']);
    	foreach($arr_person as $ap){
    		$arr_items=explode("|",$ap);
    		//print_r($arr_items);
    		printf("<tr class=\"%s\" style=text-align:center><td></td><td>%s</td><td>%s회(%s)</td><td>%s</td>",$bg,$row['el_no'],$row['em_lecture_no'],$row['em_no'],$row['mb_id']);	
    			foreach($arr_items as $ai)
    			{
    				
    				$arr_keys=explode("=",$ai);
    				
	    			if($arr_keys[0]=="add_name")
	    			{
							printf("<td>-</td><td>%s",$arr_keys[1]);	
	    			}
    				if($arr_keys[0]=="add_birth")
	    			{
	    					printf("(%s)</td><td>동반참석</td>",$arr_keys[1]);	
	    			}

	    			if($arr_keys[0]=="add_sex")
	    			{
	    					printf("<td>%s</td><td colspan=6></td>",$arr_keys[1]);	
	    			}
    				
    			}
    			echo "</tr>";
    	}
    }
    
    }/* for array*/
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>
<!-- <div class="local_ov01 local_ov">
&lt;-- 상태는 셀렉트 박스로 나오게 해주세요. Value 는 신청완료/입금확인/신청취소
</div>
<div class="local_ov01 local_ov">
※ 단체 신청이 있으니 총 참가 인원을 합산해서 총 신청인원을 잡습니다.
</div> -->

<div class="btn_list01 btn_list">
    <!-- <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"> -->
    <?php if ($is_admin == 'super') { ?>
    <!-- <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"> -->
    <select name="el_status" id="el_status" onchange="javascript:document.pressed=this.value;set_status(this.value);">
    <option value=''>선택해 주세요.</option>
    <option value='ap'>신청완료</option>
    <option value='pc'>입금완료</option>
    <option value='co'>신청취소</option>
    <option value='cp'>신청완료</option>
    <option value='rf'>환불요청</option>
    <option value='rc'>환불완료</option>
    <option value='etc'>기타</option>
    </select>
    <?php } ?>
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page_rows='.$page_rows.'&amp;page='); ?>

<script>
function fboardlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

function set_status(v) {
    // body...
   if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    var param=$("#fboardlist").serialize();
    var arr_seq="";
    console.log(param);
    $.ajax({
    url:"./ajax/set_lecture.php",
    data:param,
    dataType:"json",
    type:"POST",
    success:function(data){
        if(data.success){
            alert("변경되었습니다.");
            arr_seq=data.join_chk.split(",");
            for(var i in arr_seq){
                $("#el_"+arr_seq[i]).html($("#el_status  option:selected").text());
            }
        }
        $("#el_status").prop("selectedIndex", 0); // Select 
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
