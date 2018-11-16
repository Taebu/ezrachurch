<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>


      <!--
      ========================================================
                              CONTENT
      ========================================================
      -->

    <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value=""><!-- 
    <?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?> -->
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
    <?php }  ?>
        <!--Start section-->
        <section class="well">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <h4>에스라성경강좌 참가 신청 정보 입력</h4>

                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_id" class="text-uppercase font-secondary">아이디<strong class="sound_only">필수</strong> * </label>
                      <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" placeholder="영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요" onkeyup="javascript:chk_validate(this.value);" 
					  onkeydown="javascript:chk_validate(this.value);"
					  onkeypress="javascript:chk_validate(this.value);">
					<span id="id_check_info"></span>
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="reg_mb_password"  class="text-uppercase font-secondary">비밀번호<strong class="sound_only">필수</strong> * </label>
                      <input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?>  placeholder="비밀번호 확인" class="form-control round-small frm_input <?php echo $required ?>" minlength="3" maxlength="20">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="reg_mb_password_re"  class="text-uppercase font-secondary">비밀번호 확인<strong class="sound_only">필수</strong> * </label>
                      <input type="password" name="mb_password_re"  placeholder="비밀번호 확인" class="form-control round-small" id="reg_mb_password_re" <?php echo $required ?> class="frm_input <?php echo $required ?>" minlength="3" maxlength="20">
                    </div>
                  </div>

                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_3" class="text-uppercase font-secondary">강의 총 참가횟수<strong class="sound_only">필수</strong> * </label>
                      <input type="text" placeholder="강의 총 참가횟수"  name="mb_3" value="<?php echo $member['mb_3'] ?>" id="reg_mb_3" <?php echo $required ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="1" maxlength="20">
                      <p><span id="msg_mb_3"></span></p>
                    </div>
                  </div>

                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_4" class="text-uppercase font-secondary">출석교회
                      <input type="text" placeholder="출석교회"  name="mb_4" value="<?php echo $member['mb_4'] ?>" id="reg_mb_4" class="form-control round-small frm_input" minlength="3" maxlength="20">
                      <p><span id="msg_mb_4"></span></p>
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <div class="form-group">
                      <label class="text-uppercase font-secondary select">소속교단
                        <select class="form-control round-small" name="mb_5">
                          <option value="" selected="selected">선택</option>
                          <option value="장로교">장로교</option>
                          <option value="감리교">감리교</option>
                          <option value="구세군">구세군</option>
                          <option value="성결교">성결교</option>
                          <option value="순복음">순복음</option>
                          <option value="침례교">침례교</option>
                          <option value="기타">기타</option>
                        </select>
                      </label>
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <div class="form-group">
                      <label class="text-uppercase font-secondary select">직분
                        <select class="form-control round-small" name="mb_6">
                          <option value="" selected="selected">선택</option>
                          <option value="목사">목사</option>
                          <option value="전도사">전도사</option>
                          <option value="강도사">강도사</option>
                          <option value="신학생">신학생</option>
                          <option value="장로">장로</option>
                          <option value="집사">집사</option>
                          <option value="권사">권사</option>
                          <option value="교사">교사</option>
                          <option value="간사">간사</option>
                          <option value="순장">순장</option>
                          <option value="찬양리더">찬양리더</option>
                          <option value="세례교인">세례교인</option>
                          <option value="초신자">초신자</option>
                          <option value="기타">기타</option>
                        </select>
                      </label>
                    </div>
                  </div>

              <div class="col-xs-12">
                <div class="form-group">
                  <label for="reg_mb_id" class="text-uppercase font-secondary">성별<strong class="sound_only">필수</strong> * </label>
                  <div class="radio inline-block">
                  <label>
                    <input type="radio" name="mb_sex" id="mb_sex_1" value="M" checked><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">남자</span>
                  </label>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <div class="radio inline-block">
                  <label>
                    <input type="radio" name="mb_sex" id="mb_sex_2" value="F"><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">여</span>
                  </label>
                </div>
              </div>
              </div>

              <div class="col-xs-12">
                <h4>개인정보 입력</h4>
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label class="text-uppercase font-secondary" for="reg_mb_name">이름<strong class="sound_only">필수</strong> * </label>
                <?php if ($config['cf_cert_use']) { ?>
                <span class="frm_info">아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
                <?php } ?>
                <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="form-control round-small frm_input <?php echo $required ?> <?php echo $readonly ?>" size="10" placeholder="이름">
                <?php
                if($config['cf_cert_use']) {
                    if($config['cf_cert_ipin'])
                        echo '<button type="button" id="win_ipin_cert" class="btn_frmline">아이핀 본인확인</button>'.PHP_EOL;
                    if($config['cf_cert_hp'])
                        echo '<button type="button" id="win_hp_cert" class="btn_frmline">휴대폰 본인확인</button>'.PHP_EOL;

                    echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
                }
                ?>
                <?php
                if ($config['cf_cert_use'] && $member['mb_certify']) {
                    if($member['mb_certify'] == 'ipin')
                        $mb_cert = '아이핀';
                    else
                        $mb_cert = '휴대폰';
                ?>
                <div id="msg_certify">
                    <strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
                </div>
                <?php } ?>
                    </div>
                  </div>
        <?php if ($req_nick) {  ?>
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="reg_mb_nick" class="text-uppercase font-secondary">닉네임<strong class="sound_only">필수</strong> * </label>
                <span class="frm_info">
                </span>
                <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" class="form-control round-small frm_input nospace" size="10" maxlength="20"  placeholder="공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상) 닉네임을 바꾸시면 앞으로 <?php echo (int)$config['cf_nick_modify'] ?>일 이내에는 변경 할 수 없습니다."
				onkeyup="javascript:chk_validate_nick(this.value);" 
					  onkeydown="javascript:chk_validate_nick(this.value);"
					  onkeypress="javascript:chk_validate_nick(this.value);">

                <span id="msg_mb_nick"></span>
            </div>
          </div>
        <?php }  ?>


         <div class="col-xs-12">
                <div class="form-group"><label for="reg_mb_birth">생년월일<strong class="sound_only">필수</strong> * </label>
                <?php if ($config['cf_use_email_certify']) {  ?>
                <span class="frm_info">
                    <?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
                    <?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
                </span>
                <?php }  ?>
                <input type="text" name="mb_birth" value="<?php echo isset($member['mb_birth'])?$member['mb_birth']:''; ?>" id="reg_mb_birth" class="form-control round-small  frm_input" size="70" maxlength="100" placeholder="예) 1999-11-22">
            </div>
          </div>


         <div class="col-xs-12">
                <div class="form-group"><label for="reg_mb_email">E-mail<strong class="sound_only">필수</strong> * </label>
                <?php if ($config['cf_use_email_certify']) {  ?>
                <span class="frm_info">
                    <?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
                    <?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
                </span>
                <?php }  ?>
                <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" class="form-control round-small  frm_input email required" size="70" maxlength="100" placeholder="예) aaaaaa@bbbb.com">
            </div>
          </div>

        <?php if ($config['cf_use_homepage']) {  ?>
                  <div class="col-xs-12">
                    <div class="form-group"><label for="reg_mb_homepage">홈페이지<?php if ($config['cf_req_homepage']){ ?><strong class="sound_only">필수</strong><?php } ?></label>
            <input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="form-control round-small frm_input <?php echo $config['cf_req_homepage']?"required":""; ?>" size="70" maxlength="255">
            </div>
          </div>        <?php }  ?>

        <?php if ($config['cf_use_tel']) {  ?>
          <div class="col-xs-6">
                    <div class="form-group"><label for="reg_mb_tel">전화번호<?php if ($config['cf_req_tel']) { ?><strong class="sound_only">필수</strong><?php } ?></label>
            <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="form-control round-small frm_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20"></div>
          </div>
        <?php }  ?>

        <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
        <div class="col-xs-6">
                    <div class="form-group"><label for="reg_mb_hp">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong class="sound_only">필수</strong><?php } ?></label>
                <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" class="form-control round-small frm_input <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="예) 010-0000-1111">
                <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
                <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
                <?php } ?></div>
          </div>
        <?php }  ?>

        <?php if ($config['cf_use_addr']) { ?>
                <?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
         <div class="col-xs-5">
                <div class="form-group">
                <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="col-xs-5 form-control round-small frm_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6" placeholder='우편번호 예)12345'></div>
          </div>
         <div class="col-xs-5">
                <div class="form-group">
                <button type="button" class="offset-5 btn-primary btn-xs round-small col-xs-3 btn-block" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');"  data-target="#btn_map" id="btn_map">주소</button></div>
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
        <?php }  ?>
              </div>
              <div class="col-xs-12">
                <!-- <h4>기타 개인 설정</h4> -->
        <?php if ($config['cf_use_signature']) {  ?>
        <div class="col-xs-12">
            <th scope="row"><label for="reg_mb_signature">서명<?php if ($config['cf_req_signature']){ ?><strong class="sound_only">필수</strong><?php } ?></label></th>
            <td><textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="form-control round-small <?php echo $config['cf_req_signature']?"required":""; ?>"><?php echo $member['mb_signature'] ?></textarea></td>
        </div>
        <?php }  ?>

        <?php if ($config['cf_use_profile']) {  ?>
        <div class="col-xs-12">
            <th scope="row"><label for="reg_mb_profile">자기소개</label></th>
            <td><textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="form-control round-small <?php echo $config['cf_req_profile']?"required":""; ?>"><?php echo $member['mb_profile'] ?></textarea></td>
        </div>
        <?php }  ?>

        <?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {  ?>
        <div class="col-xs-12">
            <th scope="row"><label for="reg_mb_icon">회원아이콘</label></th>
            <td>
                <span class="frm_info">
                    이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>
                    gif만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.
                </span>
                <input type="file" name="mb_icon" id="reg_mb_icon" class="form-control round-small frm_input">
                <?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
                <img src="<?php echo $mb_icon_url ?>" alt="회원아이콘">

            <div class="checkbox">
              <label>
                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon"><span class="checkbox-field"></span><span class="text-dark-variant-2 font-secondary">삭제</span>
              </label>
            </div><!-- .checkbox -->
                <?php }  ?>
            </td>
        </div>
        <?php }  ?>

        <div class="col-xs-12">
            <label for="reg_mb_mailling">메일링서비스</label>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?>><span class="checkbox-field"></span><span class="text-dark-variant-2 font-secondary">정보 메일을 받겠습니다.</span>
              </label>
            </div><!-- .checkbox -->
            </td>
        </div>

        <?php if ($config['cf_use_hp']) {  ?>
        <div class="col-xs-12">
            <th scope="row"><label for="reg_mb_sms">SMS 수신여부</label></th>
            <td>
                
                
            <div class="checkbox">
              <label>
                <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?>><span class="checkbox-field"></span><span class="text-dark-variant-2 font-secondary">휴대폰 문자메세지를 받겠습니다.</span>
              </label>
            </div><!-- .checkbox -->
            </td>
        </div>
        <?php }  ?>

        <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능  ?>
        <div class="col-xs-12">
            <th scope="row"><label for="reg_mb_open">정보공개</label></th>
            <td>
                <span class="frm_info">
                    정보공개를 바꾸시면 앞으로 <?php echo (int)$config['cf_open_modify'] ?>일 이내에는 변경이 안됩니다.
                </span>
                <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="mb_open" value="1" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?> id="reg_mb_open">
                <span class="checkbox-field"></span><span class="text-dark-variant-2 font-secondary">다른분들이 나의 정보를 볼 수 있도록 합니다.</span>
              </label>
            </div><!-- .checkbox -->

                
                
            </td>
        </div>
        <?php } else {  ?>
        <div class="col-xs-12">
            <th scope="row">정보공개</th>
            <td>
                <span class="frm_info">
                    정보공개는 수정후 <?php echo (int)$config['cf_open_modify'] ?>일 이내, <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?> 까지는 변경이 안됩니다.<br>
                    이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
                </span>
                <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
            </td>
        </div>
        <?php }  ?>

        <?php if ($w == "" && $config['cf_use_recommend']) {  ?>
        <div class="col-xs-12">
            <th scope="row"><label for="reg_mb_recommend">추천인아이디</label></th>
            <td><input type="text" name="mb_recommend" id="reg_mb_recommend" class="form-control round-small frm_input"></td>
        </div>
        <?php }  ?>

        <div class="col-xs-12">
            <th scope="row">자동등록방지</th>
            <td><?php echo captcha_html(); ?></td>
        </div>

                <div class="btn_confirm">
                <input type="submit" value="<?php echo $w==''?'회원가입':'정보수정'; ?>" id="btn_submit" class="offset-5 btn btn-primary btn-xs round-small btn_submit" accesskey="s">
                <a href="<?php echo G5_URL ?>" class="btn btn-primary btn-xs round-small btn_cancel">취소</a>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
<!-- 회원정보 입력/수정 시작 { -->
<div class="mbskin">
    <div class="tbl_frm01 tbl_wrap">
    </div>

    </form>

    <script>
	var is_du_id=true;
	var is_nick_id=true;
	$(function(){
	

	if($("[name=w]").val()=="u"){
		$("#btn_submit").attr("disabled",false);
	}else{
		$("#btn_submit").attr("disabled",true);
	}
	$("select[name=mb_6]").val("<?php echo $member[mb_6];?>").attr("selected", "selected");
	$("select[name=mb_5]").val("<?php echo $member[mb_5];?>").attr("selected", "selected");
	$('input:radio[name=el_sex]:input[value=<?php echo $member[mb_sex];?>]').attr("checked", true);
});
    $(function() {

	$("select[name=mb_6]").val("<?php echo $member[mb_6];?>").attr("selected", "selected");
	$("select[name=mb_5]").val("<?php echo $member[mb_5];?>").attr("selected", "selected");
	$('input:radio[name=el_sex]:input[value=<?php echo $member[mb_sex];?>]').attr("checked", true);

        $("#reg_zip_find").css("display", "inline-block");

        <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
        // 아이핀인증
        $("#win_ipin_cert").click(function() {
            if(!cert_confirm())
                return false;

            var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
            certify_win_open('kcb-ipin', url);
            return;
        });

        <?php } ?>
        <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        $("#win_hp_cert").click(function() {
            if(!cert_confirm())
                return false;

            <?php
            switch($config['cf_cert_hp']) {
                case 'kcb':
                    $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                    echo 'return false;';
                    break;
            }
            ?>

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
            return;
        });
        <?php } ?>
    });
	
	/* 
		회원가입이 가능한 경우 
		버튼을 활성화 합니다. 
	
	*/
	function is_join()
	{
		if(!is_du_id&&!is_nick_id)
		{
			$("#btn_submit").attr("disabled",false);
		}else{
			$("#btn_submit").attr("disabled",true);
		}

	}
    // submit 최종 폼체크
    function fregisterform_submit(f)
    {
		

		if(is_du_id)
			{
			if($("[name=w]").val()!="u")
			{
				alert("아이디 중복 여부가 통과 되어야 합니다. 아이디를 기재해주세요.");
                f.mb_id.select();
                return false;
			}
		}
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                alert(msg);
                f.mb_id.select();
                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert("비밀번호가 같지 않습니다.");
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password_re.focus();
                return false;
            }
        }

        // 이름 검사
        if (f.w.value=="") {
            if (f.mb_name.value.length < 1) {
                alert("이름을 입력하십시오.");
                f.mb_name.focus();
                return false;
            }

            /*
            var pattern = /([^가-힣\x20])/i;
            if (pattern.test(f.mb_name.value)) {
                alert("이름은 한글로 입력하십시오.");
                f.mb_name.select();
                return false;
            }
            */
        }

        <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
        // 본인확인 체크
        if(f.cert_no.value=="") {
            alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
            return false;
        }
        <?php } ?>

        // 닉네임 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
            var msg = reg_mb_nick_check();
            if (msg) {
                alert(msg);
                f.reg_mb_nick.select();
                return false;
            }
        }

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof f.mb_icon != "undefined") {
            if (f.mb_icon.value) {
                if (!f.mb_icon.value.toLowerCase().match(/.(gif)$/i)) {
                    alert("회원아이콘이 gif 파일이 아닙니다.");
                    f.mb_icon.focus();
                    return false;
                }
            }
        }

        if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
            if (f.mb_id.value == f.mb_recommend.value) {
                alert("본인을 추천할 수 없습니다.");
                f.mb_recommend.focus();
                return false;
            }

            var msg = reg_mb_recommend_check();
            if (msg) {
                alert(msg);
                f.mb_recommend.select();
                return false;
            }
        }

        <?php echo chk_captcha_js();  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

	/* 아이디 중복체크 */
	function chk_validate(v)
	{
		console.log(v);
		var vali_length=false;
		var object=[];
		if(v.length>4)
		{
			vali_length=true;
			$("#id_check_info").html(v.length+" : "+v);
		}else{
			object.push('<div class="alert alert-success" role="alert">');
			object.push('<strong>Well done!</strong> You successfully read this important alert message.</div>');
			object.push('<div class="alert alert-info" role="alert">');
			object.push('  <strong>Heads up!</strong>');
			object.push('</div>');
			object.push('<div class="alert alert-warning" role="alert">');
			object.push('  <strong>Warning!</strong>');
			object.push('</div>');
				object=[];
				object.push('<div class="alert alert-danger" role="alert">');
				object.push('  4글자 이상 적어 주세요.');
				object.push('</div>');
				is_du_id=true;
			$("#id_check_info").html(object.join(''));
		}

		if(vali_length)
		{
			var param="mb_id="+v;
			console.log(param);
			$.ajax({
			url:"./ajax/chk_id.php",
			type: "POST",
			dataType: "json",
			data:param,
			cache: false,
			async: false,
			success: function(data) {
			console.log(data);
			if(data.count>0){
				object=[];
				object.push('<div class="alert alert-danger" role="alert">');
				object.push('  <strong>'+v+'</strong>는 이미 사용중입니다.');
				object.push('</div>');
				is_du_id=true;
				$("#id_check_info").html(object.join(''));
			}else{
				object=[];
			object.push('<div class="alert alert-success" role="alert">');
				object.push('  <strong>'+v+'</strong>는 사용가능 합니다.');
				object.push('</div>');
				is_du_id=false;
				$("#id_check_info").html(object.join(''));
			}
			}
			});		
		
		}
		is_join();
		//$("#id_check_info").html(v.length+" : "+v);
	};

	function chk_validate_nick(v)
	{
		console.log(v);
		var vali_length=false;
		var object=[];
		if(v.length>1)
		{
			vali_length=true;
			$("#msg_mb_nick").html(v.length+" : "+v);
		}else{
			object.push('<div class="alert alert-success" role="alert">');
			object.push('<strong>Well done!</strong> You successfully read this important alert message.</div>');
			object.push('<div class="alert alert-info" role="alert">');
			object.push('  <strong>Heads up!</strong>');
			object.push('</div>');
			object.push('<div class="alert alert-warning" role="alert">');
			object.push('  <strong>Warning!</strong>');
			object.push('</div>');
				object=[];
				object.push('<div class="alert alert-danger" role="alert">');
				object.push('  2글자 이상 적어 주세요.');
				object.push('</div>');
				is_nick_id=true;
			$("#msg_mb_nick").html(object.join(''));
		}

		if(vali_length)
		{
			var param="mb_nick="+v;
			console.log(param);
			$.ajax({
			url:"./ajax/chk_nick.php",
			type: "POST",
			dataType: "json",
			data:param,
			cache: false,
			async: false,
			success: function(data) {
			console.log(data);
			if(data.count>0){
				object=[];
				object.push('<div class="alert alert-danger" role="alert">');
				object.push('  <strong>'+v+'</strong>는 이미 사용중입니다.');
				object.push('</div>');
				is_nick_id=true;
				$("#msg_mb_nick").html(object.join(''));
			}else{
				object=[];
			object.push('<div class="alert alert-success" role="alert">');
				object.push('  <strong>'+v+'</strong>는 사용가능 합니다.');
				object.push('</div>');
				is_nick_id=false;
				$("#msg_mb_nick").html(object.join(''));
			}
			}
			});		
		
		}

		is_join();
		//$("#id_check_info").html(v.length+" : "+v);
	};
	
    </script>

</div>
<!-- } 회원정보 입력/수정 끝 -->