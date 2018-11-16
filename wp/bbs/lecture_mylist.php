<!-- list.php -->
<?php
include_once('../common.php');

include_once(G5_THEME_PATH.'/head.php');

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
    $array['receipt']="접수완료";
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



      <main class="page-content">

        <section class="well well-inset-2">
          <div class="container">


<div class="sub_content">

				<!-- 연중집회일정 계획표  -->
				<div class="trainee_list">
				<table class="table table-striped table-mobile mobile-primary">
					<thead>
						<tr class="bg-primary" style=text-align:center>
							<td class="t_session_2 border-rad_l">회차</td>
							<td class="t_period_3">이름</td>
							<td class="t_period_3">집회기간</td>
							<td class="t_place_2">집회장소</td>
<!-- 							<td class="t_sum_2">강좌내용</td> -->
							<td class="t_teacher_2">강사</td>
							<td class="t_phone_2 border-rad_r">접수상태</td>
						</tr>
					</thead>
					<tbody>
					<!-- 데이터 유무에 따라서 빈박스 처리  -->
<?php
if($member['mb_id']=="admin")
{
	$sql="select * from ez_lecture order by el_no desc;";
}else if($member['mb_id']!="admin"){
	$sql="select * from ez_lecture where mb_id='{$member[mb_id]}' order by el_no desc;";
	//echo $sql;
}

$query=sql_query($sql);

if(sql_num_rows($query)==0){
echo '<tr><td colspan="6" style="text-align:center;font-weight:900">접수한 강좌가 없습니다. <br> 올해는 성경강좌를 들어보시는게 어떨까요?</td></tr>';
}
while($list=sql_fetch_array($query))
{
    $em_no=$list['em_no'];
		$sql2="select * from ez_meet where em_no={$em_no};";
		$row=sql_fetch_array(sql_query($sql2));
    echo "<tr  style=text-align:center><td>";
    echo '<input type="checkbox" name="chk_seq[]" >';
    echo $list[em_lecture_no]."회";
    echo "</td><td>";
    echo sprintf("%s ( %s )",$list['el_name'],$list['el_birth']);
    echo "</td><td>";
    echo $list[el_stdt]." ~ ". $list[el_eddt];
    echo "</td><td>";
    echo $row[em_place];
    echo "</td><td>";
    //echo $row[em_lecture_name];
    //echo "</td><td>";
    echo $row[em_author];
    echo "</td><td>";
    echo get_status_name($list[el_status]);
    echo "</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div><!-- .container -->
</section>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>