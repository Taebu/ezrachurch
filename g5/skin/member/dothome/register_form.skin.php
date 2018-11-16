<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<?include_once("../d_head.php");?>

<!-- 회원정보 입력/수정 시작 { -->
<!-- <link rel="stylesheet" href="<?php echo $member_skin_url ?>/style.css"> -->
<style>
    .modal-dialog_img{-webkit-transform:translate(0, -25%);-ms-transform:translate(0, -25%);transform:translate(0, -25%);-webkit-transition:-webkit-transform 0.3s ease-out;-moz-transition:-moz-transform 0.3s ease-out;-o-transition:-o-transform 0.3s ease-out;transition:transform 0.3s ease-out;}
    .modal-dialog_img{-webkit-transform:translate(0, 0);-ms-transform:translate(0, 0);transform:translate(0, 0);}
    .modal-dialog_img{margin-left:auto;margin-right:auto;width:auto;padding:10px;z-index:1050;}
    @media screen and (min-width:800px){.modal-dialog_img{left:50%;right:auto;width:1000px;padding-top:30px;padding-bottom:30px;}
</style>

<!-- Body -->
<script src="/jq/plugin/jquery.validate.js"></script>
<script>
$(function() {
	$("#joinForm").validate({
		rules: {
			id: { required:true, minlength:3, remote: "user_id_check.php" }, // 사용자 중복확인을 한다.
			pw: { required:true, minlength:5 },
			pw2: { equalTo:"#pw" },
			name: { required:true },
			birthdate: { required:true, dateISO:true },
			email: { required:true, email:true }
		},
		messages: {
			id: {
				required: "id 를 입력하세요.",
				minlength: jQuery.format("{0} 글자 이상 입력하세요."),
				remote: jQuery.format("사용 중인 ID 입니다.")
			},
			pw: { 
				required: "비밀번호를 입력하세요.",
				minlength: jQuery.format("{0} 글자 이상 입력하세요.")
			},
			pw2: { equalTo: "비밀번호가 일치하지 않습니다." },
			name: {required: "이름을 입력하세요."},
			birthdate: { required: "생년월일을 입력하세요.",
				dateISO: "날짜 형식이 맞지 않습니다.(예 2000-01-10)"
			},
			email: {
				required: "Email을 입력하세요.",
				email: "Email 형식이 맞지 않습니다."
			}
		}
	});
});
</script>
<style type="text/css">
input.error, textarea.error { /* INPUT 박스 */
	border:1px solid red;
}
label.error { /* 에러메시지 */
	display: block;
	color:red;
}
</style>


<div class="jumbotron" style="background-image: url(/files/img/top_bg07.jpg);">
    <div class="container">
        <h1> <span class="font_color"><strong>회원가입</strong></span></h1>
        <p class="font_color">시편 67장 7절 - 하나님이 우리에게 복을 주시리니 땅의 모든 끝이 하나님을 경외하리로다</p>
    </div>
</div>
<div class="container">
	<div class="row mbskin">
		<div class="col-sm-offset-2 col-sm-8">
    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
    <script src="<?php echo G5_JS_URL ?>/certify.js"></script>
    <?php } ?>

    <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" class="form-horizontal" autocomplete="off" >
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 별명수정일이 지나지 않았다면  ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo $member['mb_nick'] ?>">
    <input type="hidden" name="mb_nick" value="<?php echo $member['mb_nick'] ?>">
    <?php }  ?>
	
<div class="row">
<div class="col-sm-offset-2 col-sm-8">

<div class="panel panel-default">
					<div class="panel-heading">
						회원가입 
					</div> <!-- panel heading -->
<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" class="form-horizontal">
<div class="panel-body">
	<div class="form-group">
		<label for="reg_mb_id" class="col-sm-3 control-label"></span>아이디</label>
		<div class="col-sm-6">
                <span class="frm_info"></span>
                <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?>  maxlength="20" placeholder="영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요." class="form-control frm_input minlength_3 <?php echo $required ?> <?php echo $readonly ?>">
                <span id="msg_mb_id"></span>
		</div>
	</div>
		
	<div class="form-group">
		<label for="reg_mb_password" class="col-sm-3 control-label">패스워드<strong class="sound_only">필수</strong></label>
		<div class="col-sm-6">
		<input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="form-control <?php echo $required ?>" maxlength="20">
	
		</div>
	</div>
	
	<div class="form-group">
		<label for="reg_mb_password" class="col-sm-3 control-label">패스워드 확인<strong class="sound_only">필수</strong></label>
		<div class="col-sm-6">
	
		<input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="form-control <?php echo $required ?>" maxlength="20">
		</div>
	</div>
		
	
	<div class="panel-heading">
		개인정보 입력
	</div> <!-- panel heading -->

	<div class="form-group">
		<label for="reg_mb_password" class="col-sm-3 control-label">이름<strong class="sound_only">필수</strong></label>
		<div class="col-sm-6">
		        <?php if ($w=="u" && $config['cf_cert_use']) { ?>
                <span class="frm_info">아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
                <?php } ?>
                <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo $member['mb_name'] ?>" <?php echo $required ?> <?php if ($w=='u') echo 'readonly'; ?> class="frm_input nospace <?php echo $required ?> <?php echo $readonly ?>" size="10">
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
	<div class="form-group">
		<label for="name" class="col-sm-3 control-label"><label for="reg_mb_nick">별명<strong class="sound_only">필수</strong></label></label>
		<div class="col-sm-6">
			 <span class="frm_info">
                공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)<br>
                별명을 바꾸시면 앞으로 <?php echo (int)$config['cf_nick_modify'] ?>일 이내에는 변경 할 수 없습니다.
            </span>
            <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?$member['mb_nick']:''; ?>">
            <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?$member['mb_nick']:''; ?>" id="reg_mb_nick" required class="frm_input required nospace" size="10" maxlength="20">
            <span id="msg_mb_nick"></span>
		</div>
	</div>
    <?php }  ?>
	<div class="form-group">
		<label for="reg_mb_email" class="col-sm-3 control-label">E-mail<strong class="sound_only">필수</strong></label>
		<div class="col-sm-6">
                <?php if ($config['cf_use_email_certify']) {  ?>
                <span class="frm_info">
                    <?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
                    <?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
                </span>
                <?php }  ?>
                <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="frm_input email required" size="50" maxlength="100">
		</div>
	</div>
	<?php if ($config['cf_use_homepage']) {  ?>
	<div class="form-group">
		<label for="reg_mb_homepage" class="col-sm-3 control-label">홈페이지<?php if ($config['cf_req_homepage']){ ?><strong class="sound_only">필수</strong><?php } ?></label>
		<div class="col-sm-6"><input type="text" name="mb_homepage" value="<?php echo $member['mb_homepage'] ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="frm_input <?php echo $config['cf_req_homepage']?"required":""; ?>" size="50" maxlength="255">
		</div>
	</div>	
    <?php }  ?>

        <?php if ($config['cf_use_tel']) {  ?>
	<div class="form-group">
		<label for="reg_mb_tel" class="col-sm-3 control-label">전화번호<?php if ($config['cf_req_tel']) { ?><strong class="sound_only">필수</strong><?php } ?></label>
         <div class="col-sm-6"><input type="text" name="mb_tel" value="<?php echo $member['mb_tel'] ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="frm_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20"></td>
        		</div>
	</div>
        <?php }  ?>

        <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
        <div class="form-group"><label for="reg_mb_hp" class="col-sm-3 control-label">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong class="sound_only">필수</strong><?php } ?></label>
            <div class="col-sm-6">
                <input type="text" name="mb_hp" value="<?php echo $member['mb_hp'] ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20">
                <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
                <input type="hidden" name="old_mb_hp" value="<?php echo $member['mb_hp'] ?>">
                <?php } ?>
            </div>
        </div>
        <?php }  ?>

        <?php if ($config['cf_use_addr']) { ?>
        <div class="form-group">        주소
                <?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
         <div class="col-sm-6">
                <label for="reg_mb_zip1" class="sound_only">우편번호 앞자리<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                <input type="text" name="mb_zip1" value="<?php echo $member['mb_zip1'] ?>" id="reg_mb_zip1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="2" maxlength="3">
                -
                <label for="reg_mb_zip2" class="sound_only">우편번호 뒷자리<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                <input type="text" name="mb_zip2" value="<?php echo $member['mb_zip2'] ?>" id="reg_mb_zip2" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="2" maxlength="3">
                <span id="reg_win_zip" style="display:block"></span>
                <label for="reg_mb_addr1" class="sound_only">주소<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                <input type="text" name="mb_addr1" value="<?php echo $member['mb_addr1'] ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50">
                <label for="reg_mb_addr2" class="sound_only">상세주소<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                <input type="text" name="mb_addr2" value="<?php echo $member['mb_addr2'] ?>" id="reg_mb_addr2" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50">
                <script>
                // 우편번호 자바스크립트 비활성화 대응을 위한 코드
                $('<a href="<?php echo G5_BBS_URL ?>/zip.php?frm_name=fregisterform&amp;frm_zip1=mb_zip1&amp;frm_zip2=mb_zip2&amp;frm_addr1=mb_addr1&amp;frm_addr2=mb_addr2" id="reg_zip_find" class="btn_frmline win_zip_find" target="_blank">우편번호 검색</a><br>').appendTo('#reg_win_zip');
                $("#reg_win_zip").css("display", "inline");
                $("#reg_mb_zip1, #reg_mb_zip2, #reg_mb_addr1").attr('readonly', 'readonly');
                </script>
           </div>
        </div>
        <?php }  ?>
        
	<div class="panel-heading">
		기타 개인 정보 입력 
	</div> <!-- panel heading -->
        <?php if ($config['cf_use_signature']) {  ?>
        <div class="form-group">
        	<label for="reg_mb_signature" class="col-sm-3 control-label">서명<?php if ($config['cf_req_signature']){ ?><strong class="sound_only">필수</strong><?php } ?></label>
            <div class="col-sm-6"><textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="<?php echo $config['cf_req_signature']?"required":""; ?>"><?php echo $member['mb_signature'] ?></textarea></div>
        </div>
        <?php }  ?>

        <?php if ($config['cf_use_profile']) {  ?>
        <div class="form-group"><label for="reg_mb_profile" class="col-sm-3 control-label">자기소개</label>
            <div class="col-sm-6"><textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="<?php echo $config['cf_req_profile']?"required":""; ?>"><?php echo $member['mb_profile'] ?></textarea></div>
        </div>
        <?php }  ?>

        <?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {  ?>
        <div class="form-group"><label for="reg_mb_icon" class="col-sm-3 control-label">회원아이콘</label>
            <div class="col-sm-6">
                <span class="frm_info">
                    이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>
                    gif만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.
                </span>
                <input type="file" name="mb_icon" id="reg_mb_icon" class="frm_input">
                <?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
                <img src="<?php echo $mb_icon_url ?>" alt="회원아이콘">
                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
                <label for="del_mb_icon">삭제</label>
                <?php }  ?>
            </div>
        </div>
        <?php }  ?>

        <div class="form-group"><label for="reg_mb_mailling" class="col-sm-3 control-label">메일링서비스</label>
            <div class="col-sm-6">
                <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?>>
                정보 메일을 받겠습니다.
            </div>
        </div>

        <?php if ($config['cf_use_hp']) {  ?>
        <div class="form-group"> 
            <label for="reg_mb_sms" class="col-sm-3 control-label">SMS 수신여부</label>
            <div class="col-sm-6">
                <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?>>
                휴대폰 문자메세지를 받겠습니다.
            </div>
        </div>
        <?php }  ?>

        <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능  ?>
        <div class="form-group"><label for="reg_mb_open" class="col-sm-3 control-label">정보공개</label>
            <div class="col-sm-6">
                <span class="frm_info">
                    정보공개를 바꾸시면 앞으로 <?php echo (int)$config['cf_open_modify'] ?>일 이내에는 변경이 안됩니다.
                </span>
                <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>">
                <input type="checkbox" name="mb_open" value="1" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?> id="reg_mb_open">
                다른분들이 나의 정보를 볼 수 있도록 합니다.
            </div>
        </div>
        <?php } else {  ?>
        <div class="form-group"> 정보공개
        	<div class="col-sm-6">                <span class="frm_info">
                    정보공개는 수정후 <?php echo (int)$config['cf_open_modify'] ?>일 이내, <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?> 까지는 변경이 안됩니다.<br>
                    이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
                </span>
                <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
            </div>
        </div>
        <?php }  ?>

        <?php if ($w == "" && $config['cf_use_recommend']) {  ?>
        <div class="form-group"><label for="reg_mb_recommend" class="col-sm-3 control-label">추천인아이디</label>
            <div class="col-sm-6"><input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input"></div>
        </div>
        <?php }  ?>
        
      	
</div><!-- panel body -->

<div class="panel-footer">
	<div class="form-group" style="padding-top: 10px">
		<div class="col-sm-offset-3 col-sm-6">
			<button class="btn btn-lg btn-primary btn-block" type="submit" id="btn_submit" class="btn_submit" accesskey="s"><?php echo $w==''?'회원가입':'정보수정'; ?></button>
			<input type="hidden" name="do" value="user_add">
		</div>
	</div>						
</div>
</div>
</div>
</div>
<!-- Body End -->
</div>
        </tbody>
        </table>
    </div>



    <!-- <div class="btn_confirm">
        <input type="submit" value="<?php echo $w==''?'회원가입':'정보수정'; ?>" id="btn_submit" class="btn_submit" accesskey="s">
        <a href="<?php echo G5_URL ?>" class="btn_cancel">취소</a>
    </div> -->
    </form>

    <script>
    $(function() {
        $("#reg_zip_find").css("display", "inline-block");
        $("#reg_mb_zip1, #reg_mb_zip2, #reg_mb_addr1").attr("readonly", true);

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

    // submit 최종 폼체크
    function fregisterform_submit(f)
    {
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
                alert("패스워드를 3글자 이상 입력하십시오.");
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert("패스워드가 같지 않습니다.");
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert("패스워드를 3글자 이상 입력하십시오.");
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

        // 별명 검사
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
$("#alert_zone").html=$("#fregisterform").serialize();
        //return true;
    }
    </script>

</div>
<div id="alert_zone">alert_zone</div>
<!-- } 회원정보 입력/수정 끝 -->
<?include_once("../d_footer.php");?>