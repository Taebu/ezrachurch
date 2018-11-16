<?php
include_once('../common.php');
include_once(G5_THEME_PATH.'/head.php');

?>


 <ol class="breadcrumb section-border">
          <li><a href="/">Home</a></li>
          <li><a href="#">서울에스라성서원</a></li>
          <li class="active">연중집회일정</li>
        </ol>
        <!--Start section List Layout-->
        <section class="text-center text-sm-left well well-sm">
          <div class="container">
<div class="sub_content">
			<p class="page_guide">Home &gt; 서울에스라성서원 &gt; 집회일정</p>
			<h2 class="subpage_title">연중집회일정</h2>
			<div class="ezra_lecture">
				<p>참다운 은혜와 진리를 사랑하는 모든 분들을 초대합니다. 평생 성경을 읽어도 이해가 되지 않는 분들, 신학(神學)을 했어도 성경에는 모르는 부분이 더 많은 분들, 구약성경이 항상 어렵다고 느끼시는 분들, 에스겔서나 요한 계시록이 어렵다고 생각이 되시는 분들은 꼭 참석하시기 바랍니다. <br>신학을 하고서도 보람과 의미를 느끼지 못하시는 분들, 하나님의 하시는 일을 이해할 수 없다고 생각되시는 분들은<br> 오십시오! 설교(說敎)에 자신이 없고 교육에도 의욕을 상실하신 분들은 반드시 참석하시기 바랍니다.</p>
				<p class="indent">■ 교 리--교리를 배워도 성경을 읽어 보면 모르는 것이 훨씬 더 많이 남아 있습니다.<br>■ 주 석--성경을 해석한 주석은 너무 방대하여 평생토록 한번도 독파하기 어렵습니다.<br>■ 신 학--신학이란 시대에 따라 변천하고 요동하며 좌로나 우로나 치우치고 있습니다.<br>■ 설 교--열심히 들어도 설교를 통해서 듣는 내용만으로는 평생을 들어도 미흡합니다.</p>
				<p>그러나 에스라성경강좌에 참석하시면 이 모든 미흡함이 충족 되고도 남습니다. 혼자서 평생을 연구한 것 보다 더 많은 것을 더 바르게 깨닫게 될 줄 믿습니다.</p>
				<div class="page_center_title">2017년도 에스라성경강좌</div>
								
				<!-- 연중집회일정 계획표  -->
				<div class="trainee_list">
<?php			if($member['mb_id']=="admin")
{?>
				<div class="col-xs-1 col-xs-offset-11 col-md-1 col-md-offset-11">
				<input type="button" value="강좌등록" id="btn_submit" class="btn btn-primary btn-xs round-small btn_submit" accesskey="s" onclick="location.href='/wp/meet/write.php';">
				</div>
<?php }?>
				<table class="table table-striped table-mobile mobile-primary">
					<thead>
						<tr class="bg-primary">
						<?php
							if($member['mb_id']=="admin")
	{

		?>
							<td class="t_session_2 border-rad_l">
							<div class="checkbox">
              <label>
                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon"><span class="checkbox-field"></span>
              </label>
            </div><!-- .checkbox --></td>
			<?php } ?>
							<td class="t_session_2 border-rad_l">회 기</td>
							<td class="t_period_3">집회기간</td>
							<td class="t_place_2">집회장소</td>
							<td class="t_sum_2">강좌제목</td>
							<td class="t_sum_2">강좌내용</td>
							<td class="t_teacher_2">강 사</td>
<!-- 							<td class="t_period_2">신청기간</td> -->
							<td class="t_phone_2 border-rad_r">문의전화</td>
<?php
	if($member['mb_id']=="admin")
	{
		?>
							<td class="t_phone_2 border-rad_r">수정</td>
							<td class="t_phone_2 border-rad_r">삭제</td>
							<?php }?>
						</tr>
					</thead>
					<tbody>
					
					<!-- 데이터 유무에 따라서 빈박스 처리  -->
					
					
<?php
//print_r($member);
$sql="select * from ez_meet ";
$query=sql_query($sql);
while($list=sql_fetch_array($query))
{
if($list[em_status]=="receipt")
{
echo '<tr onclick="javascript:set_lecture('.$list[em_no].');">';
}else{
echo '<tr onclick="javascript:alert(\'접수중이 아닙니다.\');">';
}

	if($member['mb_id']=="admin")
	{
echo '<td>';
echo '<div class="checkbox">
              <label>
                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon"><span class="checkbox-field"></span>
              </label>
            </div><!-- .checkbox -->';
echo "</td>";
	}
echo "<td>";
echo $list[em_lecture_no];
echo "</td><td>";
echo $list[em_lecture_st]." ~ ". $list[em_lecture_ed];
echo "</td><td>";
echo $list[em_place];
echo "</td><td>";
echo $list[em_lecture_name];
echo "</td><td>";
echo $list[em_lecture_contents];
echo "</td><td>";
echo $list[em_author];
//echo "</td><td>";
//echo $list[em_receipt_st]." ~ ".$list[em_receipt_ed];
echo "</td><td>";
echo $list[em_phone];
//echo "</td><td>";
//echo $list[em_datetime];
//echo "</td><td>";
//echo $list[em_status];
//echo "</td><td>";
echo "</td>";
	if($member['mb_id']=="admin")
	{
		echo "<td>";
		echo "<a href='javascript:set_meet({$list[em_no]})'>수정</a>";
		echo "</td><td>";
		echo "<a href='javascript:del_meet({$list[em_no]})'>삭제</a>";
		echo "</td>";
	}
echo "</tr>";
}
?>
					</tbody>
				</table>
				
				</div>
				<p class="blue">※ 늦어도 집회 당일 오후 1시까지는 도착하셔서 등록을 하셔야 합니다. 매회 시작은 당일 오후 2시에 시작 됩니다.</p>
				<h4 class="sub_title">강사</h4>
				<div class="teacher">
					<img alt="" src="/wp/img/rowooho_photo2.png">
					<div>
						<b>노우호 목사</b>
						<span>장로회 부산신학교, 장로회 신학대학원에서 공부하였으며 1977년 한국에서 처음으로 성경통독 사경회를 시작하여 지금까지 인도해 오고 있습니다.</span><span>현재 대한예수교 장로회 샤론교회 담임목사입니다.</span>
					</div>
				</div>
				<h4 class="sub_title">준비물</h4>
				<p class="indent">개역성경, 찬송가, 개인 침구류(모포 1매, 슬리핑 백), 세면도구, 스텐레이스 컵 등이 있으면 편리합니다.</p>
				<h4 class="sub_title">참가비</h4>																																						
				<p class="indent">4박5일 참가, 합숙 숙식비임<br><span class="blue">예약접수: 100.000원 참가비는 집회 3일전까지 계좌로 입금하시면 됩니다.</span> <br>정확한 인원파악을 위해 미리 접수하시고 참가비를 입금해 주시기 바랍니다.<br><b>계좌번호 : 우체국(610212-01-001228) 에스라하우스(예금주)</b></p>
				<h4 class="sub_title">장소</h4>
				<p class="indent"><span class="blue">에스라 하우스 집회시</span> -  경상남도 산청군 단성면 석대로365번길 39<br>전화: 055-972-7753</p>
				<h4 class="sub_title">문의전화</h4>
				<p class="indent"><span class="blue">에스라 하우스 : 055-972-7753</span></p>
			</div>	
		</div>
</div><!-- .container -->
</section>
<script type="text/javascript">
function set_meet(v)
{
	location.href="/wp/meet/modify.php?em_no="+v;
}

function del_meet(v)
{
	var is_del=confirm("삭제하면 강좌를 복구 할 수 없습니다. 정말삭제 하시겠습니까?");
	if(!is_del){
	return;
	}
	$.ajax({
		url:"/wp/meet/ajax/set_meet.php",
		data:"mode=delete&em_no="+v,
		dataType:"json",
		type:"POST",
		success:function(data){
			if(data.success){
				alert("삭제성공");
			}else{
				alert("삭제실패");
			}
		}
	});
}

function set_lecture(v)
{
	location.href="/wp/lecture/write.php?em_no="+v;
}
</script>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>