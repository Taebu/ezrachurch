<?php
include_once('../common.php');
include_once "../theme/modificate/head.php";
include_once "../theme/modificate/head.sub.php";
?>
<?php
//extract($_GET);
if(isset($em_no))
{
$sql="select * from ez_meet  where em_no={$em_no};";
$query=sql_query($sql);
$row=sql_fetch_array($query);
}

?>
<link id="bsdp-css" href="/theme/modificate/plugin/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet">
<header class="page-header subpage_header">
		<section>
          <!--Swiper-->
          <div data-autoplay="5000" data-slide-effect="fade" data-loop="false" class="swiper-container swiper-slider" style="color:#fff">
            <div class="jumbotron text-center">
              <h1 style=";color:#fff">집회일정 등록하기<br class="hidden-md hidden-sm hidden-xs"> <br class="hidden-md hidden-sm hidden-xs"><small style=";color:#fff">네가 죽도록 충성하라 그리하면 내가 생명의 관을 네게 주리라 (계2:10)</small></h1>
              <p class="big"></p>
            </div>
            <div class="swiper-wrapper">
              <div data-slide-bg="/theme/modificate/images/wpmqwrjwpls-alberto-restifo.jpg" class="swiper-slide">
                <div class="swiper-slide-caption" style="text-weight:900;color:#fff;font-size:1.2em"></div>
              </div>
            </div>
          </div>
        </section>
      </header>
 <ol class="breadcrumb section-border">
          <li><a href="/">Home</a></li>
          <li><a href="#">서울에스라성서원</a></li>
          <li class="active">집회일정 등록하기</li>
        </ol>
        <!--Start section List Layout-->
        <section class="text-center text-sm-left well well-sm">
          <div class="container">
		  <div id="sandbox-container">
            <div class="row">
				<form id="meet_form">
				<input type="hidden" name="mode" value="update" />
				<input type="hidden" name="em_no" value="<?php echo $em_no;?>" />
				 <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">회기<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="회차 숫자만"  name="em_lecture_no" value="<?php echo $row['em_lecture_no'] ?>" id="em_lecture_no" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20">
                      <span class="frm_info">진행할 회차를 적어 주세요. 숫자만</span>
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group input-daterange">
                      <label class="text-uppercase font-secondary">신청기간 시작 *</label>
					  <input type="text" name="em_receipt_st" id="em_receipt_st"  placeholder="신청 접수 시작기간"  class="form-control" data-date-format="yyyy-mm-dd"   value="<?php  echo $row[em_receipt_st];?>"/>
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <div class="form-group input-daterange">
                      <label class="text-uppercase font-secondary">신청기간 종료 *  </label>
					  <input type="text" name="em_receipt_ed" id="em_receipt_ed"   placeholder="신청 접수 종료기간 "  class="form-control" data-date-format="yyyy-mm-dd" value="<?php  echo $row[em_receipt_ed];?>"/>
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <div class="form-group input-daterange">
                      <label class="text-uppercase font-secondary">집회기간 시작 *</label>
					  <input type="text" name="em_lecture_st" id="em_lecture_st"  placeholder="집회 시작"  class="form-control" data-date-format="yyyy-mm-dd"   value="<?php  echo $row[em_lecture_st];?>"/>  
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <div class="form-group input-daterange">
                      <label class="text-uppercase font-secondary">집회기간 종료 *</label>
					  <input type="text" name="em_lecture_ed" id="em_lecture_ed"   placeholder="집회 종료"  class="form-control col-lg-12" data-date-format="yyyy-mm-dd" value="<?php  echo $row[em_lecture_ed];?>"/>
                    </div>
                  </div>


				 <div class="col-xs-12">
                    <div class="form-group">	
                      <label for="reg_mb_id" class="text-uppercase font-secondary">집회장소<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="서울에스라 성서원"  name="em_place" value="<?php echo $row['em_place'] ?>" id="em_place" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20">
                      <span class="frm_info">집회 장소를 작성해 주세요. </span>
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>

				 <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">강좌제목<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="강좌 내용을 작성해 주세요"  name="em_lecture_name" value="<?php echo $row['em_lecture_name'] ?>" id="em_lecture_name" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>">
                      <span class="frm_info">강좌 제목을 작성해 주세요. *(기본값 : 2박3일 서울에스라강좌). </span>
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>

				 <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">강좌내용<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="강좌 내용을 작성해 주세요"  name="em_lecture_contents" value="<?php echo $row['em_lecture_contents'] ?>" id="em_lecture_contents" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>">
                      <span class="frm_info">강좌 내용을 작성해 주세요. *(기본값 : 신구약 중간사). </span>
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>


				 <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">강사<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="강사"  name="em_author" value="<?php echo $row['em_author'] ?>" id="em_author" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>">
                      <span class="frm_info">강사 *(기본값 : 남궁현우). </span>
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>


				 <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">문의 전화<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="010-3927-1754"  name="em_phone" value="<?php echo $row['em_phone'] ?>" id="em_phone" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>">
                      <span class="frm_info">비상 연락처 *(기본값 : 010-3927-1754). </span>
                      <p><span id="msg_mb_id"></span></p>
                    </div>
                  </div>

				  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">상태<strong class="sound_only">필수</strong> * </label>
					  <p>
					  <div class="radio inline-block">
                      <label>
                        <input type="radio" name="em_status" id="em_status_1" value="waiting" checked><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">대기중</span>
                      </label>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="radio inline-block">
                      <label>
                        <input type="radio" name="em_status" id="em_status_2" value="receipt"><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">접수중</span>
                      </label>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="radio inline-block">
                      <label>
                        <input type="radio" name="em_status" id="em_status_3" value="meet"><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">강좌중</span>
                      </label>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="radio inline-block">
                      <label>
                        <input type="radio" name="em_status" id="em_status_4" value="close"><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">종강</span>
                      </label>
                    </div>
					</p>
                    </div>
                  </div>

				 <div class="col-xs-12">
                <div class="btn_confirm">
                <input type="button" value="강좌수정" id="btn_submit" class="btn btn-primary btn-xs round-small btn_submit" accesskey="s" onclick="javascript:set_meet();">
				<input type="reset" value="초기화" id="btn_submit" class="btn btn-info btn-xs round-small">
				<input type="button" value="기본값 설정" class="btn btn-success btn-xs round-small " onclick="javascript:set_default();">
				<input type="button" value="리스트" class="btn btn-info btn-xs round-small " onclick="javascript:set_list();">
                <!-- <a href="<?php echo G5_URL ?>" class="btn btn-primary btn-xs round-small btn_cancel">취소</a> -->
                </div>
				                  </div>
			</div>
</div><!-- .row -->
</form>
		</section>


	<script type="text/javascript">
$(function(){
	$('input:radio[name=em_status]:input[value=<?php echo $row[em_status]?>]').attr("checked", true);
});

	/* 강좌 일정을 수정합니다. */
	function set_meet()
	{
		if($.trim($("#em_lecture_no").val())=="")
		{
			alert("강좌 회차를 작성해 주세요");
			$("#em_lecture_no").focus();
			return;
		}

		if($.trim($("#em_receipt_st").val())=="")
		{
			alert("강좌 신청기간을 선택해 주세요");
			$("#em_receipt_st").focus();
			return;
		}
		
		if($.trim($("#em_receipt_ed").val())=="")
		{
			alert("강좌 신청기간을 선택해 주세요");
			$("#em_receipt_ed").focus();
			return;
		}
		
		if($.trim($("#em_lecture_st").val())=="")
		{
			alert("강좌 기간을 선택해 주세요");
			$("#em_lecture_st").focus();
			return;
		}
		
		if($.trim($("#em_lecture_ed").val())=="")
		{
			alert("강좌 기간을 선택해 주세요");
			$("#em_lecture_ed").focus();
			return;
		}
		
		if($.trim($("#em_lecture_name").val())=="")
		{
			alert("강좌 제목을 작성해 주세요");
			$("#em_lecture_name").focus();
			return;
		}
		
		if($.trim($("#em_lecture_contents").val())=="")
		{
			alert("강좌 내용을 작성해 주세요");
			$("#em_lecture_contents").focus();
			return;
		}
		
		if($.trim($("#em_place").val())=="")
		{
			alert("집회 장소를 작성해 주세요");
			$("#em_place").focus();
			return;
		}
		
		if($.trim($("#em_lecture_name").val())=="")
		{
			alert("강좌 제목을 작성해 주세요");
			$("#em_lecture_name").focus();
			return;
		}
		
		if($.trim($("#em_lecture_contents").val())=="")
		{
			alert("강좌 내용를 작성해 주세요");
			$("#em_lecture_contents").focus();
			return;
		}
		
		if($.trim($("#em_author").val())=="")
		{
			alert("강사를 작성해 주세요");
			$("#em_author").focus();
			return;
		}
		
		if($.trim($("#em_phone").val())=="")
		{
			alert("문의전화를 작성해 주세요");
			$("#em_phone").focus();
			return;
		}
		
		var param=$("#meet_form").serialize();

		$.ajax({
			url:"./ajax/set_meet.php",
			data:param,
			dataType:"json",
			type:"POST",
			success:function(data){
				if(data.success){
					alert("수정성공");
				}else{
					alert("수정실패");
				}
			}
		});
	}
	
	/* 초기값으로 설정합니다. */
	function set_default()
	{
		$("#em_lecture_name").val("2박 3일 서울에스라강좌");
		$("#em_place").val("서울에스라성서원");
		$("#em_phone").val("010-3927-1754");
		$("#em_author").val("남궁현우");
		$("#em_lecture_contents").val("신구약중간사");
	}

	function set_list()
	{
		location.href="/lecture/list.php";
	}

$( document ).ready(function() {

		$('#sandbox-container .datepicker').datepicker({
			format: "yyyy-mm-dd",
			weekStart: 1,
			clearBtn: true,
			language: "kr",
			forceParse: false,
			autoclose: true,
			todayHighlight: true
		});


		$('.input-daterange').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			language: "kr",
			forceParse: false,
			autoclose: true,
			todayHighlight: true,
			calendarWeeks: true
		});
	});
	</script>
<?php
include_once('../common.php');
include_once "../theme/modificate/tail.php";
include_once "../theme/modificate/head.sub.php";
?>