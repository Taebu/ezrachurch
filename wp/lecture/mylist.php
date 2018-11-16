<!-- list.php -->
<?php
include_once('../common.php');

include_once(G5_THEME_PATH.'/head.php');

?>






      <main class="page-content">

        <section class="well well-inset-2">
          <div class="container">


<div class="sub_content">
			<p class="page_guide">Home &gt; 서울에스라성서원 &gt; 집회일정</p>
			<h2 class="subpage_title">연중집회일정</h2>
			<div class="ezra_lecture">
				<p>참다운 은혜와 진리를 사랑하는 모든 분들을 초대합니다. 평생 성경을 읽어도 이해가 되지 않는 분들, 신학(神學)을 했어도 성경에는 모르는 부분이 더 많은 분들, 구약성경이 항상 어렵다고 느끼시는 분들, 에스겔서나 요한 계시록이 어렵다고 생각이 되시는 분들은 꼭 참석하시기 바랍니다. <br>신학을 하고서도 보람과 의미를 느끼지 못하시는 분들, 하나님의 하시는 일을 이해할 수 없다고 생각되시는 분들은<br> 오십시오! 설교(說敎)에 자신이 없고 교육에도 의욕을 상실하신 분들은 반드시 참석하시기 바랍니다.</p>
				<p class="indent">
				■ 교 리--교리를 배워도 성경을 읽어 보면 모르는 것이 훨씬 더 많이 남아 있습니다.<br>
				■ 주 석--성경을 해석한 주석은 너무 방대하여 평생토록 한번도 독파하기 어렵습니다.<br>
				■ 신 학--신학이란 시대에 따라 변천하고 요동하며 좌로나 우로나 치우치고 있습니다.<br>
				■ 설 교--열심히 들어도 설교를 통해서 듣는 내용만으로는 평생을 들어도 미흡합니다.</p>
				<p>그러나 에스라성경강좌에 참석하시면 이 모든 미흡함이 충족 되고도 남습니다. 혼자서 평생을 연구한 것 보다 더 많은 것을 더 바르게 깨닫게 될 줄 믿습니다.</p>
				<div class="page_center_title">2017년도 에스라성경강좌</div>
								
				<!-- 연중집회일정 계획표  -->
				<div class="trainee_list">
				<table class="table table-striped table-mobile mobile-primary">
					<thead>
						<tr class="bg-primary">
							<td class="t_session_2 border-rad_l">회 기</td>
							<td class="t_period_3">집회기간</td>
							<td class="t_place_2">집회장소</td>
							<td class="t_sum_2">강좌내용</td>
							<td class="t_teacher_2">강 사</td>
							<td class="t_period_2">신청기간</td>
							<td class="t_phone_2 border-rad_r">문의전화</td>
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
	echo $sql;
}


$query=sql_query($sql);
while($list=sql_fetch_array($query))
{

	$em_no=$list['em_no'];
	$sql2="select * from ez_meet where em_no={$em_no};";
	$row=sql_fetch_array(sql_query($sql2));
	print_r($row);

	/*
Array
(
    [el_no] => 1
    [mb_id] => erm00
    [el_stdt] => 2017-02-22
    [el_eddt] => 2017-02-24
    [el_name] => 문태부
    [el_email] => mtaebu@gmail.com
    [em_no] => 5
    [em_lecture_no] => 8
    [el_sex] => M
    [el_birth] => 19800405
    [el_tel] => 02-817-7316
    [el_hp] => 010-3037-2004
    [mb_zip1] => 069
    [mb_zip2] => 20
    [mb_addr1] => 서울 동작구 만양로 19
    [mb_addr2] => 703동 1502호
    [mb_addr3] => (노량진동, 신동아리버파크아파트)
    [mb_addr_jibeon] => R
    [el_datetime] => 2017-02-19 01:31:59
    [el_ip] => 123.142.52.90
    [el_comment] => 
    [el_job] => 회사원
    [el_group] => 장로교
    [el_position] => 세례교인
    [el_church] => 서울에스라교회
    [el_marriedyn] => 미혼
    [el_count] => 9
    [el_total] => 1
)

Array
(
    [em_no] => 5
    [em_author] => 남궁현우
    [em_lecture_no] => 8
    [em_lecture_name] => 2박 3일 서울에스라강좌
    [em_place] => 서울에스라성서원
    [em_lecture_contents] => 신구약중간사
    [em_receipt_st] => 2017-02-16
    [em_receipt_ed] => 2017-02-21
    [em_lecture_st] => 2017-02-22
    [em_lecture_ed] => 2017-02-24
    [em_phone] => 010-3927-1754
    [em_datetime] => 2017-02-17
    [em_status] => receipt
)
*/
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
echo $row[em_status];
echo "</td><td>";
echo "연기신청";
echo "</td><td>";
echo "환불신청";

//echo $list[em_lecture_name];

//echo "</td><td>";
//echo "</td><td>";
//echo $list[em_datetime];
echo "</td><td>";
echo $list[em_status];
//echo "</td><td>";
echo "</td></tr>";

}

?>
						<tr class="activate">
							<td>307회</td>
							<td>2017/02/27 - 03/03</td>
							<td>에스라하우스</td>							
							<td>신구약전체</td>
							<td>노우호,(구약)정요한, 엄인영</td>
							<td>2017년01월16일~2017년02월26일</td>
							<td>010-4554-1884</td>							
						</tr>

					</tbody>
				</table>
				
				</div>
				<p class="blue">※ 늦어도 집회 당일 오후 1시까지는 도착하셔서 등록을 하셔야 합니다. 매회 시작은 당일 오후 2시에 시작 됩니다.</p>
				<h4 class="sub_title">강사</h4>
				<div class="teacher">
					<img alt="" src="/wp/images/nghy.png">
					<div>
						<b>남궁현우 목사</b>
						<span>장로회 부산신학교, 장로회 신학대학원에서 공부하였으며 1977년 한국에서 처음으로 성경통독 사경회를 시작하여 지금까지 인도해 오고 있습니다.</span><span>현재 대한예수교 장로회 샤론교회 담임목사입니다.</span>
					</div>
				</div>
				<h4 class="sub_title">준비물</h4>
				<p class="indent">개역성경, 찬송가, 개인 침구류(모포 1매, 슬리핑 백), 세면도구, 스텐레이스 컵 등이 있으면 편리합니다.</p>
				<h4 class="sub_title">참가비</h4>																																						
				<p class="indent">2박3일 참가, 합숙 숙식비임<br><span class="blue">예약접수: 100.000원 참가비는 집회 3일전까지 계좌로 입금하시면 됩니다.</span> <br>정확한 인원파악을 위해 미리 접수하시고 참가비를 입금해 주시기 바랍니다.<br><b>계좌번호 : 우체국(610212-01-001228) 에스라하우스(예금주)</b></p>
				<h4 class="sub_title">장소</h4>
				<p class="indent"><span class="blue">에스라 하우스 집회시</span> -  경상남도 산청군 단성면 석대로365번길 39<br>전화: 055-972-7753</p>
				<h4 class="sub_title">문의전화</h4>
				<p class="indent"><span class="blue">에스라 하우스 : 055-972-7753</span></p>
			</div>	
		</div>
</div><!-- .container -->
</section>









<?php
include_once "../theme/modificate/tail.php";
include_once "../theme/modificate/tail.sub.php";
?>