<?php
include_once('../common.php');
include_once(G5_THEME_PATH.'/head.php');

?>


      <main class="page-content">

        <section class="well well-inset-2">
          <div class="container">


								
				<!-- 연중집회일정 계획표  -->
				<div class="trainee_list">
<?php			if($member['mb_id']=="admin")
{?>
				<div class="col-xs-1 col-xs-offset-11 col-md-1 col-md-offset-11">
				<input type="button" value="강좌등록" id="btn_submit" class="btn btn-primary btn-xs round-small btn_submit" accesskey="s" onclick="location.href='/wp/adm/meet_list.php';">
				</div>
<?php }?>
				<table class="table table-striped table-mobile mobile-primary">
					<thead>
						<tr class="bg-primary" style=text-align:center>
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
							<td class="t_session_2 border-rad_l">회차</td>
							<td class="t_period_3">집회기간</td>
							<td class="t_place_2">집회장소</td>				
							<td class="t_sum_2">강좌내용</td>
							<td class="t_teacher_2">강사</td>
<!-- 							<td class="t_period_2">신청기간</td> -->
<!--							<td class="t_phone_2 border-rad_r">문의전화</td>-->
							<?php
								if($member['mb_id']=="admin")
								{
									?>
							<td class="t_phone_2 border-rad_r">수정</td>
							<?php } else { ?>
							<td class="t_phone_2 border-rad_r">참가 신청</td>
							<?php } ?>
						</tr>
					</thead>
					<tbody>

					<!-- 데이터 유무에 따라서 빈박스 처리  -->
					
<?php
//print_r($member);
$sql="select * from ez_meet where em_status='receipt';";
$query=sql_query($sql);
if(sql_num_rows($query)==0){
echo '<tr><td colspan="9" style="text-align:center;font-weight:900">등록된 강좌가 없습니다.</td></tr>';
}
while($list=sql_fetch_array($query))
{
/* 2018-03-25 오후 1:47 
종료된 강좌는 안보이게 하기 
while continue 아래걸 무시하고 다음 list로 처리
*/
if($list['em_status']=="close"){
	continue;
}
if($list[em_status]=="receipt")
{
	$click = "javascript:set_lecture('$list[em_no]');";
	$order = "접수중(신청하기)";
}else if($list[em_status]=="close")
{
	$click = "javascript:alert('종료된 강좌 입니다.');";
	$order = "종강";
}else{
	$click = "javascript:alert('현재 접수중이 아닙니다.')";
	$order = "대기중";
}

	echo "<tr style='text-align:center;cursor:pointer' onclick=\"".$click."\">";

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
/*echo "</td><td>";
echo $list[em_lecture_name];*/
echo "</td><td>";
echo $list[em_lecture_contents];
echo "</td><td>";
echo $list[em_author];
//echo "</td><td>";
//echo $list[em_receipt_st]." ~ ".$list[em_receipt_ed];
//echo "</td><td>";
//echo $list[em_phone];
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
		echo "</td>";
	}

	else {
		echo "<td>";
		echo '<a href="'.$click.'" class="btn btn-warning btn-xs round-large">'.$order.'</a>';
		echo "</td>";
}

echo "</tr>";
}
?>
					</tbody>
				</table>
				
				</div>
					<h6>
<!--
※ 회비 예약 15만원(현장접수 18만원)입니다. <br>
(회비계좌: (우체국)014506-02-108953 남궁현우) <br> <br>

※ 정보당일 오후2시에 시작이오니 미리 준비해 주시기 바랍니다. <br> <br>

※ 필수 준비물 : 개인용 물컵(스테인레스), 개인 침구, 개역개정성경 <br> <br>

※ 주차는 타워주차로 국내 중소형 승용차만 가능 <br>
(주차시 사이드해제, 기어 N중립, 위반시 배상) <br> <br>

※ 기타 문의사항은 010-3927-1754</h6>
-->
			</div>	
		</div>
</div><!-- .container -->
</section>
<script type="text/javascript">
function set_meet(v)
{
	location.href="/wp/meet/modify.php?em_no="+v;
}
/*
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
}*/

function set_lecture(v)
{
	location.href="/wp/bbs/lecture_write.php?em_no="+v;
}
</script>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>