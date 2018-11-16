<!-- list.php -->
<?php
include_once('../common.php');


if($member['mb_id']=="")
{
	alert("회원만 신청이 가능합니다.");
	goto_url("/bbs/login.php");
}

include_once(G5_THEME_PATH.'/head.php');

$sql="select * from ez_meet where em_no={$em_no};";
$query=sql_query($sql);
$row=sql_fetch_array($query);
//print_r($row);
if($row['em_status']!="receipt")
{
	alert("접수중인 강좌가 아닙니다.");
}
?>
<head>
    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <script src="<?php echo G5_JS_URL ?>/certify.js"></script>
    <?php echo G5_POSTCODE_JS;?>
</head>



	     <ol class="breadcrumb section-border">
          <li class="active">홈페이지</li>
		  <li class="active">서울에스라성서원</li>
          <li class="active">참가 확인</li>
        </ol>


      <main class="page-content">

        <section class="well well-inset-2">
          <div class="container">



        <section class="text-center text-sm-left well well-sm">
          <div class="container">
		  <div id="sandbox-container">
				<p class="indent">■ 예약 접수는 집회 3일전까지만 신청하실 수 있습니다.<br>
				■ 현장 접수의 경우에는 할인 혜택을 받을 수가 없습니다.<br>
				■ 취소, 환불, 연기 신청도 집회 3일 전까지만 가능합니다.</p>
<!-- 			<form action="">
							<input type="hidden" name="" /> -->
			<div class="row">
 				<form id="meet_form"  name="meet_form" method="post" enctype="multipart/form-data" autocomplete="off">
<!-- 			    <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off"> -->
				<input type="hidden" name="mode" value="write" />
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>" />
				<input type="hidden" name="em_lecture_no" value="<?php echo $row['em_lecture_no'];?>" />
				<input type="hidden" name="em_no" value="<?php echo $em_no;?>" />
				<input type="hidden" name="el_stdt" value="<?php echo $row['em_lecture_st'];?>" />
				<input type="hidden" name="el_eddt" value="<?php echo $row['em_lecture_ed'];?>" />
				 <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">신청기수<strong class="sound_only">필수</strong> * </label>
                      <p><?php echo $row['em_lecture_no'] ?>회</p>
                    </div>
                  </div>


                  <div class="col-xs-12">
                    <div class="form-group input-daterange">
                      <label class="text-uppercase font-secondary">집회기간 *</label>
					  <p><?php  echo $row[em_lecture_st];?> ~ <?php  echo $row[em_lecture_ed];?></p>
                    </div>
                  </div>


				 <div class="col-xs-12">
                    <div class="form-group">	
                      <label for="reg_mb_id" class="text-uppercase font-secondary">이름<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="이름"  name="el_name" value="<?php echo $member['mb_name'] ?>" id="el_name" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20">
                      <span class="frm_info">신청자 이름으로 꼭 입금하세요 </span>
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>


				  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">성별<strong class="sound_only">필수</strong> * </label>
					  <p>
					  <div class="radio inline-block">
                      <label>
                        <input type="radio" name="el_sex" id="el_sex_1" value="M" <?php echo $member['mb_sex']=="M"?"checked":"";?>><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">남자</span>
                      </label>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="radio inline-block">
                      <label>
                        <input type="radio" name="el_sex" id="el_sex_2" value="F" <?php echo $member['mb_sex']=="F"?"checked":"";?>><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">여자</span>
                      </label>
                    </div>
					</p>
                    </div>
                  </div>

				 <div class="col-xs-12">
                    <div class="form-group">	
                      <label for="reg_mb_id" class="text-uppercase font-secondary">Email<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="Email"  name="el_email" value="<?php echo $member['mb_email'] ?>" id="el_email" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20">
                      <!-- <span class="frm_info">신청자 이름으로 꼭 입금하세요 </span> -->
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>

				 <div class="col-xs-12">
                    <div class="form-group">	
                      <label for="reg_mb_id" class="text-uppercase font-secondary">생년월일<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="생년월일"  name="el_birth" value="<?php echo $member['mb_birth'] ?>" id="el_birth" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20">
                      <!-- <span class="frm_info">신청자 이름으로 꼭 입금하세요 </span> -->
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>

		 <div class="col-xs-5">
                <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                <div class="form-group">
                <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="col-xs-5 form-control round-small frm_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6" placeholder='우편번호 예)12345'></div>
          </div>
         <div class="col-xs-5">
                <div class="form-group">
                <button type="button" class="offset-5 btn-primary btn-xs round-small col-xs-3 btn-block" onclick="win_zip('meet_form', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');"  data-target="#btn_map" id="btn_map">우편번호검색</button></div>
          </div>
         <div class="col-xs-12">
                <div class="form-group">
                <label for="reg_mb_addr1">기본 주소</label>
				<input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="form-control round-small frm_input frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50">
                <label for="reg_mb_addr1"><?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label></div>
          </div>
         <div class="col-xs-12">
                <div class="form-group">
                
                <label for="reg_mb_addr3">참고 항목</label>
				<input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="form-control round-small frm_input frm_address" size="50" readonly="readonly">
                <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>"></div>
          </div>
         <div class="col-xs-12">
                <div class="form-group">
                <label for="reg_mb_addr2">상세 주소</label>
                <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="form-control round-small frm_input frm_address" size="50">
                </div>
          </div>

				 <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">전화번호<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="전화번호"  name="el_tel" value="<?php echo $member['mb_tel'] ?>" id="el_tel" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>">
                      <span class="frm_info">강좌 제목을 작성해 주세요. *(기본값 : 2박3일 서울에스라강좌). </span>
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>

				 <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">핸드폰<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="핸드폰"  name="el_hp" value="<?php echo $member['mb_hp'] ?>" id="em_lecture_contents" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>">
<!--                       <span class="frm_info">강좌 내용을 작성해 주세요. *(기본값 : 신구약 중간사). </span> -->
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>


				 <div class="col-xs-12">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">출석교회<strong class="sound_only">필수</strong> * </label>
                    <div class="form-group">
					  <input type="text" placeholder="출석교회"  name="el_church" value="<?php echo $member['mb_4'] ?>" id="el_church" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>">
<!-- 					  <span class="frm_info">출석교회 *(예 : 서울에스라교회). </span> -->
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>



                  <div class="col-xs-6">
                    <div class="form-group">
                      <label class="text-uppercase font-secondary select">소속교단 *
                        <select class="form-control round-small" name="el_group" id="el_group">
                          <option value="" selected="selected">선택</option>
                          <option value="감리교">감리교</option>
                          <option value="구세군">구세군</option>
                          <option value="성결교">성결교</option>
                          <option value="순복음">순복음</option>
                          <option value="장로교">장로교</option>
                          <option value="침례교">침례교</option>
                          <option value="기타">기타</option>
                        </select>
                      </label>
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <div class="form-group">
                      <label class="text-uppercase font-secondary select">직분 *
                        <select class="form-control round-small" name="el_position" id="el_position">
                          <option value="" selected="selected">선택</option>
                          <option value="목사">목사</option>
                          <option value="전도사">전도사</option>
                          <option value="강도사">강도사</option>
                          <option value="신학생">신학생</option>
                          <option value="장로">장로</option>
                          <option value="집사">집사</option>
                          <option value="권사">권사</option>
                          <option value="교사">교사</option>
                          <option value="순장">순장</option>
                          <option value="찬양리더">찬양리더</option>
                          <option value="세례교인">세례교인</option>
                          <option value="초신자">초신자</option>
                          <option value="기타">기타</option>
                        </select>
                      </label>
                    </div>
                  </div>



                  <div class="col-xs-6">
                    <div class="form-group">
                      <label class="text-uppercase font-secondary select">직업 *
								<select name="el_job" class="form-control round-small" title="직업" id="el_job">
						   			<option value="">직업선택</option>
						   			<option value="목사">목사</option>
						   			<option value="전도사">전도사</option>
						   			<option value="강도사">강도사</option>
						   			<option value="신학생">신학생</option>
						   			<option value="회사원">회사원</option>
						   			<option value="공무원">공무원</option>
						   			<option value="교육계">교육계</option>
						   			<option value="의료계">의료계</option>
						   			<option value="예술인">예술인</option>
						   			<option value="학생">학생</option>
						   			<option value="작가">작가</option>
						   			<option value="자영업">자영업</option>
						   			<option value="농수산">농수산</option>
						   			<option value="프리랜서">프리랜서</option>
						   			<option value="엔지니어">엔지니어</option>
						   			<option value="가사">가사</option>
						   			<option value="기타">기타</option>
								</select>
                      </label>
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <div class="form-group">
                      <label class="text-uppercase font-secondary select">결혼여부 *
                        <select class="form-control round-small" name="el_marriedyn">
                          <option value="" selected="selected">결혼여부</option>
                          <option value="기혼">기혼</option>
                          <option value="미혼">미혼</option>
                        </select>
                      </label>
                    </div>
                  </div>

				 <div class="col-xs-12">
                    <div class="form-group">
					<div class="col-xs-12">
					  <label for="reg_mb_id" class="text-uppercase font-secondary">참가횟수<strong class="sound_only">필수</strong> * </label>
					</div>
					<div class="col-xs-4 col-sm-4  col-md-2">
					  <input type="text" placeholder="참가횟수"  name="el_count" id="el_count" value="<?php echo $row['el_count'] ?>" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input col-xs-1 <?php echo $required ?> <?php echo $readonly ?>">
					</div>

					<div class="col-xs-2 col-sm-2  col-md-2"><h4>번</h4></div>
					
					
					<div class="col-xs-12">
					  <span class="frm_info"> (이번이 몇 번째인가 기록하여 주세요.</span>
                      <p><span id="msg_mb_id"></span></p>
					  </div>
					</div>
                  </div>

				 <div class="col-xs-12">
                    <div class="form-group">
					<div class="col-xs-12">
					  <label for="reg_mb_id" class="text-uppercase font-secondary">참가 총인원<strong class="sound_only">필수</strong> * </label>
					</div>

					<div class="col-xs-4 col-sm-4  col-md-2">
					  <input type="text" placeholder="참가인원"  name="el_total" id="el_total" value="<?php echo $lecture['el_total'] ?>" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>">
					  </div>
					  <div class="col-xs-2 col-sm-2  col-md-2"><h4>명</h4></div>
					
					
					<div class="col-xs-12">
					  <p><span class="frm_info"> (단체로 접수시는 참가 총인원을 적어주세요.)</span></p>
					  <p><span id="msg_mb_id"></span></p>
					  </div>
                    </div>
                  </div>



		<div class="col-xs-12">
            <div scope="form-group"><label for="el_comment">하고 싶은 말</label>
            <textarea name="el_comment" id="el_comment" class="form-control round-small"><?php echo $lecture['el_comment'] ?></textarea>
			</div>
        </div>
				<div class="col-xs-12">
					<p>
						<span>꼭! 기억하세요.</span>
						<span>금요일 오후 12시부터 당일 현장 접수시 12만원으로 적용됩니다.</span>
					</p>
					<p>
						<span>유익 정보</span>
						<span>당일 오후1시 까지 현장에 도착하시면 점심식사 제공합니다.</span>
					</p>
					<p>
						<span>필수 준비물</span>
						<span>개인용 물컵(스테인레스), 개인 침구, 개역 한글성경</span>
					</p>
					<p class="red">
						<span>성경강좌 입금계좌</span>
						<span>우체국 610212-01-001228     예금주)에스라 하우스<br>&lt;&lt;신청자 이름으로 꼭 입금하세요.&gt;&gt;</span>

					</p>				
				</div>
				<div class="col-xs-12">
				<p class="bottom_notice2">
               	[신청하기] 버튼을 누르시기 전에 잠깐!!<br>[신청하기] 버튼을 누르시기 전에 맨 위에 유의 사항을 다시 읽어 보시고 신청해 주시기 바랍니다.<br>규정대로 하지 않으시면 취소, 환불, 연기 신청을 하실 수가 없습니다.<br>참가 신청서에도 빈칸을 남겨 두시거나 정확한 주소를 기록하지 않으시면 불성실한 사람들로 간주하여<br>접수가 되지 않을 수도 있습니다. 
             
               </p>
				</div>
				 <div class="col-xs-12">
                <div class="btn_confirm">
                <input type="button" value="신청하기" id="btn_submit" class="btn btn-primary btn-xs round-small btn_submit" accesskey="s" onclick="javascript:set_lecture();">
				<input type="reset" value="초기화" id="btn_submit" class="btn btn-info btn-xs round-small">
				<input type="button" value="기본값 설정" class="btn btn-success btn-xs round-small " onclick="javascript:set_default();">
                <!-- <a href="<?php echo G5_URL ?>" class="btn btn-primary btn-xs round-small btn_cancel">취소</a> -->
                </div>
				                  </div>
			</div>
</div><!-- .row -->
</form>
		</section>
<?php
//print_r($member);
/*
echo $row[em_lecture_no];
echo $row[em_lecture_st]." ~ ". $row[em_lecture_ed];
echo $row[em_place];
echo $row[em_lecture_name];
echo $row[em_lecture_contents];
echo $row[em_author];
echo $row[em_receipt_st]." ~ ".$row[em_receipt_ed];
echo $row[em_phone];
echo $row[em_datetime];
echo $row[em_status];
		echo "<a href='javascript:set_meet({$row[em_no]})'>수정</a>";
		echo "<a href='javascript:del_meet({$row[em_no]})'>삭제</a>";
*/
?>
				</div>

			</div>	
		</div>
</div><!-- .container -->
</section>
<script type="text/javascript">
$(function(){
	/* 결혼여부 선택*/
	$("select[name=el_marriedyn]").val("<?php echo $lecture[el_marriedyn];?>").attr("selected", "selected");

	$("select[name=el_position]").val("<?php echo $member[mb_6];?>").attr("selected", "selected");
	$("select[name=el_group]").val("<?php echo $member[mb_5];?>").attr("selected", "selected");
	$('input:radio[name=el_sex]:input[value=<?php echo $member[mb_sex];?>]').attr("checked", true);
});

function set_lecture()
{

	if($.trim($("[name=el_name]").val())=="")
	{
		alert("이름을 작성해 주세요");
		$("[name=el_name]").focus();
		return;
	}


	if($.trim($("[name=el_sex]").val())=="")
	{
		alert("성을 선택해 주세요");
		$("[name=el_sex]").focus();
		return;
	}

	if($.trim($("[name=el_email]").val())=="")
	{
		alert("이메일을 작성해 주세요");
		$("[name=el_email]").focus();
		return;
	}

	if($.trim($("[name=el_birth]").val())=="")
	{
		alert("생년월일을 작성해 주세요 예)19800101");
		$("[name=el_birth]").focus();
		return;
	}

	if($.trim($("[name=mb_zip]").val())=="")
	{
		alert("우편번호를 작성해 주세요");
		$("[name=mb_zip]").focus();
		return;
	}


	if($.trim($("[name=mb_addr1]").val())=="")
	{
		alert("주소를 작성해 주세요");
		$("[name=mb_addr1]").focus();
		return;
	}
/*
	if($.trim($("[name=mb_addr2]").val())=="")
	{
		alert("mb_addr2을 작성해 주세요");
		$("[name=mb_addr2]").focus();
		return;
	}

	if($.trim($("[name=mb_addr3]").val())=="")
	{
		alert("mb_addr3을 작성해 주세요");
		$("[name=mb_addr3]").focus();
		return;
	}

	if($.trim($("[name=mb_addr_jibeon]").val())=="")
	{
		alert("mb_addr_jibeon을 작성해 주세요");
		$("[name=mb_addr_jibeon]").focus();
		return;
	}

	if($.trim($("[name=el_tel]").val())=="")
	{
		alert("전화번호을 작성해 주세요");
		$("[name=el_tel]").focus();
		return;
	}
*/ 

	if($.trim($("[name=el_hp]").val())=="")
	{
		alert("핸드폰을 작성해 주세요");
		$("[name=el_hp]").focus();
		return;
	}

	if($.trim($("[name=el_church]").val())=="")
	{
		alert("출석교회를 작성해 주세요");
		$("[name=el_church]").focus();
		return;
	}

	if($.trim($("[name=el_group]").val())=="")
	{
		alert("소속교단을 선택해 주세요");
		$("[name=el_group]").focus();
		return;
	}

	if($.trim($("[name=el_position]").val())=="")
	{
		alert("직분을 선택해 주세요");
		$("[name=el_position]").focus();
		return;
	}

	if($.trim($("[name=el_job]").val())=="")
	{
		alert("직업을 선택해 주세요");
		$("[name=el_job]").focus();
		return;
	}

	if($.trim($("[name=el_marriedyn]").val())=="")
	{
		alert("결혼여부를 선택해 주세요");
		$("[name=el_marriedyn]").focus();
		return;
	}

	if($.trim($("[name=el_count]").val())=="")
	{
		alert("참가횟수를 작성해 주세요");
		$("[name=el_count]").focus();
		return;
	}

	if($.trim($("[name=el_total]").val())=="")
	{
		alert("참가인원을 작성해 주세요");
		$("[name=el_total]").focus();
		return;
	}

	var param=$("#meet_form").serialize();
	console.log(param);


	$.ajax({
		url:"./ajax/set_lecture.php",
		type:"POST",
		dataType:"json",
		data:param,
		success:function(data){
			if(data){
				alert("신청 접수에 완료 하였습니다.");
			}else{
				alert("이미 접수 신청 하였습니다.");
			}
		}
	});
	//alert(param);
}

function set_meet(v)
{
	location.href="/meet/modify.php?em_no="+v;
}

function del_meet(v)
{
	var is_del=confirm("삭제하면 강좌를 복구 할 수 없습니다. 정말삭제 하시겠습니까?");
	if(!is_del){
	return;
	}
	$.ajax({
		url:"/meet/ajax/set_meet.php",
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
</script>
<?php
include_once('../common.php');
include_once "../theme/modificate/tail.php";
include_once "../theme/modificate/head.sub.php";
?>