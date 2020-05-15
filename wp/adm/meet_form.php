<?php
$sub_menu = "400100";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'w');

$sql = " select count(*) as cnt from {$g5['group_table']} ";
$row = sql_fetch($sql);

if($em_no){
    $meet = sql_fetch(" select * from ez_meet where em_no = '$em_no' ");
}
if (!$row['cnt'])
    alert('게시판그룹이 한개 이상 생성되어야 합니다.', './boardgroup_form.php');

$html_title = '강의';

if (!isset($board['bo_device'])) {
    // 게시판 사용 필드 추가
    // both : pc, mobile 둘다 사용
    // pc : pc 전용 사용
    // mobile : mobile 전용 사용
    // none : 사용 안함
    sql_query(" ALTER TABLE  `{$g5['board_table']}` ADD  `bo_device` ENUM(  'both',  'pc',  'mobile' ) NOT NULL DEFAULT  'both' AFTER  `bo_subject` ", false);
}

if (!isset($board['bo_mobile_skin'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_skin` VARCHAR(255) NOT NULL DEFAULT '' AFTER `bo_skin` ", false);
}

if (!isset($board['bo_gallery_width'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_gallery_width` INT NOT NULL AFTER `bo_gallery_cols`,  ADD `bo_gallery_height` INT NOT NULL DEFAULT '0' AFTER `bo_gallery_width`,  ADD `bo_mobile_gallery_width` INT NOT NULL DEFAULT '0' AFTER `bo_gallery_height`,  ADD `bo_mobile_gallery_height` INT NOT NULL DEFAULT '0' AFTER `bo_mobile_gallery_width` ", false);
}

if (!isset($board['bo_mobile_subject_len'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_subject_len` INT(11) NOT NULL DEFAULT '0' AFTER `bo_subject_len` ", false);
}

if (!isset($board['bo_mobile_page_rows'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_page_rows` INT(11) NOT NULL DEFAULT '0' AFTER `bo_page_rows` ", false);
}

if (!isset($board['bo_mobile_content_head'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_content_head` TEXT NOT NULL AFTER `bo_content_head`, ADD `bo_mobile_content_tail` TEXT NOT NULL AFTER `bo_content_tail`", false);
}

if (!isset($board['bo_use_cert'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_use_cert` ENUM('','cert','adult') NOT NULL DEFAULT '' AFTER `bo_use_email` ", false);
}

if (!isset($board['bo_use_sns'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_use_sns` TINYINT NOT NULL DEFAULT '0' AFTER `bo_use_cert` ", false);

    $result = sql_query(" select bo_table from `{$g5['board_table']}` ");
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}`
                    ADD `wr_facebook_user` VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_ip`,
                    ADD `wr_twitter_user` VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_facebook_user` ", false);
    }
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_use_cert' ";
$row = sql_fetch($sql);
if(strpos($row['Type'], 'hp-') === false) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` CHANGE `bo_use_cert` `bo_use_cert` ENUM('','cert','adult','hp-cert','hp-adult') NOT NULL DEFAULT '' ", false);
}

if (!isset($board['bo_use_list_file'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_use_list_file` TINYINT NOT NULL DEFAULT '0' AFTER `bo_use_list_view` ", false);

    $result = sql_query(" select bo_table from `{$g5['board_table']}` ");
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}`
                    ADD `wr_file` TINYINT NOT NULL DEFAULT '0' AFTER `wr_datetime` ", false);
    }
}

if (!isset($board['bo_mobile_subject'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_subject` VARCHAR(255) NOT NULL DEFAULT '' AFTER `bo_subject` ", false);
}

$required = "";
$readonly = "";
if ($w == '') {

    $html_title .= ' 생성';

    $required = 'required';
    $required_valid = 'alnum_';
    $sound_only = '<strong class="sound_only">필수</strong>';

    $board['bo_count_delete'] = 1;
    $board['bo_count_modify'] = 1;
    $board['bo_read_point'] = $config['cf_read_point'];
    $board['bo_write_point'] = $config['cf_write_point'];
    $board['bo_comment_point'] = $config['cf_comment_point'];
    $board['bo_download_point'] = $config['cf_download_point'];

    $board['bo_gallery_cols'] = 4;
    $board['bo_gallery_width'] = 174;
    $board['bo_gallery_height'] = 124;
    $board['bo_mobile_gallery_width'] = 125;
    $board['bo_mobile_gallery_height'] = 100;
    $board['bo_table_width'] = 100;
    $board['bo_page_rows'] = $config['cf_page_rows'];
    $board['bo_mobile_page_rows'] = $config['cf_page_rows'];
    $board['bo_subject_len'] = 60;
    $board['bo_mobile_subject_len'] = 30;
    $board['bo_new'] = 24;
    $board['bo_hot'] = 100;
    $board['bo_image_width'] = 600;
    $board['bo_upload_count'] = 2;
    $board['bo_upload_size'] = 1048576;
    $board['bo_reply_order'] = 1;
    $board['bo_use_search'] = 1;
    $board['bo_skin'] = 'basic';
    $board['bo_mobile_skin'] = 'basic';
    $board['gr_id'] = $gr_id;
    $board['bo_use_secret'] = 0;
    $board['bo_include_head'] = '_head.php';
    $board['bo_include_tail'] = '_tail.php';

} else if ($w == 'u') {

    $html_title .= ' 수정';

    if (!$board['bo_table'])
        alert('존재하지 않은 게시판 입니다.');

    if ($is_admin == 'group') {
        if ($member['mb_id'] != $group['gr_admin'])
            alert('그룹이 틀립니다.');
    }

    $readonly = 'readonly';

}

if ($is_admin != 'super') {
    $group = get_group($board['gr_id']);
    $is_admin = is_admin($member['mb_id']);
}

$g5['title'] = $html_title;
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_bo_basic">기본 설정</a></li>
    <li><a href="#anc_bo_auth">권한 설정</a></li>
    <li><a href="#anc_bo_function">기능 설정</a></li>
    <li><a href="#anc_bo_design">디자인/양식</a></li>
    <li><a href="#anc_bo_point">포인트 설정</a></li>
    <li><a href="#anc_bo_extra">여분필드</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="button" value="확인" class="btn_submit" accesskey="s" onclick="javascript:set_meet();">
    <input type="button" value="초기값" class="btn_info" accesskey="d" onclick="javascript:set_default();">
    <a href="./meet_list.php?'.$qstr.'">목록</a>'.PHP_EOL;
if ($w == 'u') $frm_submit .= '<a href="./board_copy.php?bo_table='.$bo_table.'" id="board_copy" target="win_board_copy">게시판복사</a>
    <a href="'.G5_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'" class="btn_frmline">게시판 바로가기</a>
    <a href="./board_thumbnail_delete.php?bo_table='.$board['bo_table'].'&amp;'.$qstr.'" onclick="return delete_confirm2(\'게시판 썸네일 파일을 삭제하시겠습니까?\');">게시판 썸네일 삭제</a>'.PHP_EOL;
$frm_submit .= '</div>';

$mode=$mode==""?"write":$mode;
//mode=update&em_no=2
?>

  <link rel="stylesheet" href="/wp/css/jquery.ui.min.css">
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="/wp/js/jquery.ui.min.js"></script>
<style>
    label{cursor:pointer;}
</style>
<form name="meet_form" id="meet_form" action="./board_form_update.php" onsubmit="return fboardform_submit(this)" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="mode" value="<?php echo $mode ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="em_no" id="em_no" value="<?php echo $em_no ?>">
<input type="hidden" name="token" value="">

<section id="anc_bo_basic">
    <h2 class="h2_frm">강의 기본 설정</h2>
    <?php echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 기본 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_3">
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="em_lecture_no">회차<?php echo $sound_only ?></label></th>
            <td colspan="2">
                <input type="number" name="em_lecture_no" value="<?php echo $meet['em_lecture_no'] ?>" id="em_lecture_no" <?php echo $required ?> <?php echo $readonly ?> class="frm_input <?php echo $reaonly ?> <?php echo $required ?> <?php echo $required_valid ?>" maxlength="20">
                <?php if ($w == '') { ?>
                   숫자만 가능 (공백없이 20자 이내)
                <?php } else { ?>
                    <a href="<?php echo G5_BBS_URL ?>/board.php?em_lecture_no=<?php echo $meet['em_lecture_no'] ?>" class="btn_frmline">게시판 바로가기</a>
                    <a href="./board_list.php" class="btn_frmline">목록으로</a>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="em_lecture_no">강의구분<?php echo $sound_only ?></label></th>
            <td colspan="2">
                <?php //echo $meet['em_lecture_type'] ?>
                <input type="radio" name="em_lecture_type" id="em_lecture_type_1" value="SEBL" checked="checked"><label for="em_lecture_type_1">&nbsp;&nbsp;성경강좌</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="em_lecture_type" id="em_lecture_type_2" value="EBL_TEACHER"><label for="em_lecture_type_2">&nbsp;&nbsp;교사고시반</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="em_lecture_type" id="em_lecture_type_3" value="CHONGCHIN_EZRA_CIRCLES"><label for="em_lecture_type_3">&nbsp;&nbsp;총신에스라동아리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="em_lecture_type" id="em_lecture_type_4" value="YONSEI_UNIVERSITY_EZRA_CIRCLES"><label for="em_lecture_type_4">&nbsp;&nbsp;연세대학교에스라동아리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="em_lecture_type" id="em_lecture_type_5" value="CONFERENCE"><label for="em_lecture_type_5">&nbsp;&nbsp;학술대회</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="gr_id">신청접수기간<strong class="sound_only">필수</strong></label></th>
            <td colspan="2"><input type="text" name="em_receipt_st" value="<?php echo get_text($meet['em_receipt_st']) ?>" id="em_receipt_st" required class="required frm_input" size="10" maxlength="10" style="width: 90px;" data-date-format="yyyy-mm-dd"> - <input type="text" name="em_receipt_ed" value="<?php echo get_text($meet['em_receipt_ed']) ?>" id="em_receipt_ed" required class="required frm_input" size="10" maxlength="10" style="width: 90px;"  data-date-format="yyyy-mm-dd"> </td>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="gr_id">강좌 기간<strong class="sound_only">필수</strong></label></th>
            <td colspan="2"><input type="text" name="em_lecture_st" value="<?php echo get_text($meet['em_lecture_st']) ?>" id="em_lecture_st" required class="required frm_input" size="10" maxlength="10" style="width: 90px;"  data-date-format="yyyy-mm-dd"> - <input type="text" name="em_lecture_ed" value="<?php echo get_text($meet['em_lecture_ed']) ?>" id="em_lecture_ed" required class="required frm_input" size="10" maxlength="10" data-date-format="yyyy-mm-dd" style="width: 90px;" > </td>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="em_place">집회 장소<strong class="sound_only">필수</strong></label></th>
            <td colspan="2">
                <input type="text" name="em_place" value="<?php echo get_text($meet['em_place']) ?>" id="em_place" required class="required frm_input" size="80" maxlength="120">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="em_lecture_name">강좌 제목</label></th>
            <td colspan="2">
                <?php echo help("모바일에서 보여지는 게시판 제목이 다른 경우에 입력합니다. 입력이 없으면 기본 게시판 제목이 출력됩니다.") ?>
                <input type="text" name="em_lecture_name" value="<?php echo get_text($meet['em_lecture_name']) ?>" id="em_lecture_name" class="frm_input" size="80" maxlength="120">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="em_lecture_contents">강좌 내용</label></th>
            <td colspan="2">
                <?php echo help("강좌 내용을 적어 주세요. 예 신약전체와 신구약 중간사, 신구약 전체.") ?>
                <input type="text" name="em_lecture_contents" value="<?php echo get_text($meet['em_lecture_contents']) ?>" id="em_lecture_contents" class="frm_input" size="80" maxlength="120">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="em_author">강사</label></th>
            <td colspan="2">
                <?php echo help("어떤 강사분이 도와주시는지 적어 주세요.") ?>
                <input type="text" name="em_author" value="<?php echo get_text($meet['em_author']) ?>" id="em_author" class="frm_input" size="80" maxlength="120">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="em_phone">문의 전화</label></th>
            <td colspan="2">
                <?php echo help("강좌에 대해 문의할 전화를 기입합니다..") ?>
                <input type="text" name="em_phone" value="<?php echo get_text($meet['em_phone']) ?>" id="em_phone" class="frm_input" size="80" maxlength="120">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="em_lecture_contents">강좌 상태</label></th>
            <td colspan="2">
                <?php echo help("접수 중인지 강좌중인지 종강 했는지를 기입 합니다. 접수중이 아니면 강좌가 접수 되지 않습니다.");?>
                
                                      <p>
                      <label>
                        <input type="radio" name="em_status" id="em_status_1" value="waiting" <?php echo get_text($meet['em_status'])=="waiting"?"checked":"";?>><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">대기중</span>
                      </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="radio" name="em_status" id="em_status_2" value="receipt" <?php echo get_text($meet['em_status'])=="receipt"?"checked":"";?>><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">접수중</span>
                      </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="radio" name="em_status" id="em_status_3" value="meet" <?php echo get_text($meet['em_status'])=="meet"?"checked":"";?>><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">강좌중</span>
                      </label>
              
                    &nbsp;&nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="radio" name="em_status" id="em_status_4" value="close" <?php echo get_text($meet['em_status'])=="close"?"checked":"";?>><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary">종강</span>
                      </label>
                    </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="em_image_file">강의 제공된 이미지 파일</label></th>
            <td colspan="2">
                <?php echo help("강의 제공된 이미지 파일 등록합니다.");
                print('<div id="image_file_area">');
                if(strlen($meet['em_image_file'])==0)
                {
                    print('<input type="file" name="em_image_file" id="em_image_file" class="frm_input" value="">');
                }else{
                    printf('<img src="/wp/adm/uploads/%s" alt="" width="320px">',get_text($meet['em_image_file']));
                    printf('<input type="button" value="삭제" onclick="javascript:set_image_delete(\''.$meet['em_image_file'].'\');">');
                }

                print('</div>');
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="em_contents">강의 설명 상세 내용</label></th>
            <td colspan="2">
                <?php echo help("강의 설명 상세 내용을 기입합니다.") ?>
                <textarea name="em_contents" id="em_contents" cols="30" rows="10" class="frm_input"><?php echo get_text($meet['em_contents']) ?></textarea>
            </td>
        </tr>
        <?php if ($w == 'u') { ?>
        <tr>
            <th scope="row"><label for="proc_count">카운트 조정</label></th>
            <td colspan="2">
                <?php echo help('현재 원글수 : '.number_format($meet['bo_count_write']).', 현재 댓글수 : '.number_format($meet['bo_count_comment'])."\n".'게시판 목록에서 글의 번호가 맞지 않을 경우에 체크하십시오.') ?>
                <input type="checkbox" name="proc_count" value="1" id="proc_count">
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

</form>

<script>
$(function(){
    $("#board_copy").click(function(){
        window.open(this.href, "win_board_copy", "left=10,top=10,width=500,height=400");
        return false;
    });

    $(".get_theme_galc").on("click", function() {
        if(!confirm("현재 테마의 게시판 이미지 설정을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "./theme_config_load.php",
            cache: false,
            async: false,
            data: { type: "board" },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('bo_gallery_cols', 'bo_gallery_width', 'bo_gallery_height', 'bo_mobile_gallery_width', 'bo_mobile_gallery_height', 'bo_image_width');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("input[name="+key+"]").val(data[key]);
                }
            }
        });
    });


    $('input:radio[name=em_lecture_type]:input[value=<?php echo $meet['em_lecture_type'];?>]').attr("checked", true);
});

function board_copy(bo_table) {
    window.open("./board_copy.php?bo_table="+bo_table, "BoardCopy", "left=10,top=10,width=500,height=200");
}

function set_point(f) {
    if (f.chk_grp_point.checked) {
        f.bo_read_point.value = "<?php echo $config['cf_read_point'] ?>";
        f.bo_write_point.value = "<?php echo $config['cf_write_point'] ?>";
        f.bo_comment_point.value = "<?php echo $config['cf_comment_point'] ?>";
        f.bo_download_point.value = "<?php echo $config['cf_download_point'] ?>";
    } else {
        f.bo_read_point.value     = f.bo_read_point.defaultValue;
        f.bo_write_point.value    = f.bo_write_point.defaultValue;
        f.bo_comment_point.value  = f.bo_comment_point.defaultValue;
        f.bo_download_point.value = f.bo_download_point.defaultValue;
    }
}

function fboardform_submit(f)
{
    <?php echo get_editor_js("bo_content_head"); ?>
    <?php echo get_editor_js("bo_content_tail"); ?>
    <?php echo get_editor_js("bo_mobile_content_head"); ?>
    <?php echo get_editor_js("bo_mobile_content_tail"); ?>

    if (parseInt(f.bo_count_modify.value) < 0) {
        alert("원글 수정 불가 댓글수는 0 이상 입력하셔야 합니다.");
        f.bo_count_modify.focus();
        return false;
    }

    if (parseInt(f.bo_count_delete.value) < 1) {
        alert("원글 삭제 불가 댓글수는 1 이상 입력하셔야 합니다.");
        f.bo_count_delete.focus();
        return false;
    }

    return true;
}

function set_default()
{
//		$.trim();
	$("#em_lecture_name").val("4박 5일 에스라성경강좌");
	$("#em_place").val("서울시 영등포구 양평동4가 31-3번지 설록디아망타워 지하 101호");
	$("#em_phone").val("010-3927-1754");
	$("#em_author").val("남궁현우");
	$("#em_lecture_contents").val("신구약 66권 전체");
    $("#em_contents").val("※ 회비 예약 15만원(현장접수 18만원)입니다.\n(회비계좌: (우체국)014506-02-108953 남궁현우)\n\n※ 정보당일 오후2시에 시작이오니 미리 준비해 주시기 바랍니다.\n\n※ 필수 준비물 : 개인용 물컵(스테인레스), 개인 침구, 개역개정성경\n\n※ 주차는 타워주차로 국내 중소형 승용차만 가능\n(주차시 사이드해제, 기어 N중립, 위반시 배상)\n\n※ 기타 문의사항은 010-3927-1754");
}

/* 강좌 등록하기 */
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
        
        if($.trim($("#em_contents").val())=="")
        {
            alert("강의 등록 내용을 작성해 주세요");
            $("#em_contents").focus();
            return;
        }
		

        var formData = new FormData($("#meet_form")[0]);
        if(typeof($("#em_image_file")[0])!="undefined"){

            formData.append("em_image_file",$("#em_image_file")[0].files[0]);
        }
		$.ajax({
			url:"./ajax/set_meet.php",
			dataType:"json",
			type:"POST",
            data:formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
			enctype: 'multipart/form-data',
            success:function(data){
				if(data.success){
					alert("등록성공");
                    location.href="/wp/adm/meet_list.php";
				}else{
					alert(data.message);
				}
			}
		});
	}

function set_image_delete(v)
{
    //alert(v);
    var param = {'em_image_file':v,'mode':"image_delete",'em_no':$("#em_no").val()};
    $.ajax({
        url:"./ajax/set_meet.php",
        dataType:"json",
        type:"POST",
        data:param,
        success:function(data){
            if(data.success)
            {
                alert("삭제성공");


                $("#image_file_area").html("");

                $("#image_file_area").html('<input type="file" name="em_image_file" id="em_image_file" class="frm_input" value="">');
            }
        }
    });    
}

/* datepicker */
var dateoption={dateFormat: "yy-mm-dd",
dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
dayNames: [ "일", "월", "화", "수", "목", "금", "토" ],
monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
showOn:"both"
};

  $( function() {
    $("#em_receipt_st").datepicker(dateoption);
    $("#em_receipt_ed").datepicker(dateoption);
    $("#em_lecture_st").datepicker(dateoption);
    $("#em_lecture_ed").datepicker(dateoption);
  });
</script>

<?php
include_once ('./admin.tail.php');
?>