<!-- list.php -->
<?php
include_once('../common.php');

include_once(G5_THEME_PATH.'/head.php');

?>



	     <ol class="breadcrumb section-border">
          <li class="active">홈페이지</li>
		  <li class="active">서울에스라성서원</li>
          <li class="active">참가 확인</li>
        </ol>


      <main class="page-content">

        <section class="well well-inset-2">
          <div class="container">


<div class="sub_content">

				<!-- 연중집회일정 계획표  -->
				<div class="trainee_list">
				<table class="table table-striped table-mobile mobile-primary">
					<thead>
						<tr class="bg-primary">
							<td class="t_session_2 border-rad_l">회차</td>
							<td class="t_period_3">집회기간</td>
							<td class="t_place_2">집회장소</td>
							<td class="t_sum_2">강좌내용</td>
							<td class="t_teacher_2">강사</td>
							<td class="t_period_2">신청기간</td>
							<td class="t_phone_2 border-rad_r">접수상태</td>
						</tr>
					</thead>
					<tbody>
					<!-- 데이터 유무에 따라서 빈박스 처리  -->
<?php
if($member['mb_id']=="admin")
{
	$sql="select * from ez_lecture where mb_order by el_no desc;";
}else if($member['mb_id']!="admin")
{
	$sql="select * from ez_lecture where mb_id='{$member[mb_id]}' order by el_no desc;";
	//echo $sql;
}

$query=sql_query($sql);
while($list=sql_fetch_array($query))
{
	$em_no=$list['em_no'];
	$sql2="select * from ez_meet where em_no={$em_no};";
	$row=sql_fetch_array(sql_query($sql2));
    echo "<tr><td>";
    echo '<input type="checkbox" name="chk_seq[]" >';
    echo $list[em_lecture_no]."회";
    echo "</td><td>";
    echo $list[el_stdt]." ~ ". $list[el_eddt];
    echo "</td><td>";
    echo $row[em_place];
    echo "</td><td>";
    echo "100,000";
    echo "</td><td>";
    echo $row[em_author];
    echo "</td><td>";
    echo $list[em_status];
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