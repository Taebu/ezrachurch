<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if ($w == 'u') {
    $wr_1 = get_text(html_purifier($write['wr_1']), 0);
    $wr_2 = get_text(html_purifier($write['wr_2']), 0);
    $wr_3 = get_text(html_purifier($write['wr_3']), 0);
    $wr_4 = get_text(html_purifier($write['wr_4']), 0);
    $wr_5 = get_text(html_purifier($write['wr_5']), 0);
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

	        <main class="page-content">
        <section class="section-border text-center text-md-left">
          <div class="container">
	  
	  
	  
	  <!--
      ========================================================
                              CONTENT
      ========================================================
      -->



<section id="bo_w">
    <h2 id="container_title"><?php echo $g5['title'];?></h2>


    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">




     <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .='<div class="checkbox">';
            $option .='<label for="notice">';
            $option .='<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>';
            $option .='<span class="checkbox-field"></span>';
            $option .='<span class="text-dark-variant-2 font-secondary">공지</span>';
            $option .='</label>';
            $option .='</div>';
        }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= '<div class="checkbox">';
                $option .='<label for="html">';
                $option .='<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>';
                $option .='<span class="checkbox-field"></span>';
                $option .='<span class="text-dark-variant-2 font-secondary">html</span>';
                $option .='</label>';
                $option .='</div>';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
            $option .='<div class="checkbox">';
            $option .='<label for="secret">';
            $option .='<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>';
            $option .='<span class="checkbox-field"></span>';
            $option .='<span class="text-dark-variant-2 font-secondary">비밀글</span>';
            $option .='</label>';
            $option .='</div>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .='<div class="checkbox">';
            $option .='<label for="mail">';
            $option .='<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>';
            $option .='<span class="checkbox-field"></span>';
            $option .='<span class="text-dark-variant-2 font-secondary">답변메일받기</span>';
            $option .='</label>';
            $option .='</div>';
        }
    }

    echo $option_hidden;
    ?>

        <?php if ($option) { ?>
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1" class="text-uppercase font-secondary">옵션</label>
            <?php echo $option ?>
                    </div>
                  </div>
        <?php } ?>




    <div class="tbl_frm01 tbl_wrap">
        <table>
        <tbody>
        <?php if ($is_name) { ?>
        <tr>
            <th scope="row"><label for="wr_name">이름 *<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="form-control round-small required" style="width:100%" maxlength="255">
		
			
			</td>
        </tr>
        <?php } ?>

        <?php if ($is_password) { ?>
        <tr>
            <th scope="row"><label for="wr_password">비밀번호 *<strong class="sound_only">필수</strong></label></th>
            <td><input type="password" name="wr_password" id="wr_password" placeholder="Your password" class="form-control round-small <?php echo $password_required ?>" maxlength="20" style="width:100%">
			
			</td>
        </tr>
        <?php } ?>

        <?php if ($is_email) { ?>
        <tr>
            <th scope="row"><label for="wr_email">이메일</label></th>
            <td><input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email"  placeholder="홈페이지를 입력하세요"  class="form-control round-small" style="width:100%" maxlength="255"></td>
        </tr>
        <?php } ?>

        <?php if ($is_homepage) { ?>
        <tr>
            <th scope="row"><label for="wr_homepage">홈페이지</label></th>
            <td><input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" placeholder="홈페이지를 입력하세요"  class="form-control round-small" style="width:100%" maxlength="255"></td>
        </tr>
        <?php } ?>


        <?php if ($is_category) { ?>
        <tr>
            <th scope="row"><label for="ca_name">분류 *<strong class="sound_only">필수</strong></label></th>
            <td>
                <select name="ca_name" id="ca_name" required class="required" >
                    <option value="">선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </td>
        </tr>
        <?php } ?>

        <tr>
            <th scope="row"  style=width:150px;><label for="wr_subject">제목 *<strong class="sound_only">필수</strong></label>	
			</th>
            <td>
                <div id="autosave_wrapper">

                      <input type="text" name="wr_subject" placeholder="글 제목을 입력하세요" value="<?php echo $subject ?>" id="wr_subject" class="form-control round-small required" style=width:100% maxlength="255">

                    <?php if ($is_member) { // 임시 저장된 글 기능 ?>
                    <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
                    <?php if($editor_content_js) echo $editor_content_js; ?>
                    <button type="button" id="btn_autosave" class="btn_frmline">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
                    <div id="autosave_pop">
                        <strong>임시 저장된 글 목록</strong>
                        <div><button type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
                        <ul></ul>
                        <div><button type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
                    </div>
                    <?php } ?>
                </div>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="wr_content">주보겉표지 *
<table>
    <tr>
        <td>주보2면</td>
        <td>주보1면</td>
        <td class="highlight">주보겉표지</td>
    </tr>
    <tr>
        <td>주보3면</td>
        <td>주보4면</td>
        <td>주보5면</td>
    </tr>
</table><strong class="sound_only">필수</strong></label></th>
            <td class="wr_content">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="wr_1">주보 1면*
<style>
    .highlight{
    background: firebrick !important;
    color: aliceblue;
}
</style>
<table>
    <tr>
        <td>주보2면</td>
        <td class="highlight">주보1면</td>
        <td>주보겉표지</td>
    </tr>
    <tr>
        <td>주보3면</td>
        <td>주보4면</td>
        <td>주보5면</td>
    </tr>
</table>
                <strong class="sound_only">필수</strong></label></th>
            <td class="wr_1">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>

                <?php echo editor_html("wr_1", $write['wr_1'], $is_dhtml_editor); ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="wr_2">주보2면 
<table>
    <tr>
        <td class="highlight">주보2면</td>
        <td>주보1면</td>
        <td>주보겉표지</td>
    </tr>
    <tr>
        <td>주보3면</td>
        <td>주보4면</td>
        <td>주보5면</td>
    </tr>
</table>*<strong class="sound_only">필수</strong></label></th>
            <td class="wr_2">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>

                <?php echo editor_html("wr_2", $write['wr_2'], $is_dhtml_editor); ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="wr_3">주보3면
<table>
    <tr>
        <td>주보2면</td>
        <td>주보1면</td>
        <td>주보겉표지</td>
    </tr>
    <tr>
        <td class="highlight">주보3면</td>
        <td>주보4면</td>
        <td>주보5면</td>
    </tr>
</table>*<strong class="sound_only">필수</strong></label></th>
            <td class="wr_3">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>

                <?php echo editor_html("wr_3", $write['wr_3'], $is_dhtml_editor); ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="wr_4">주보4면<table>
    <tr>
        <td>주보2면</td>
        <td>주보1면</td>
        <td>주보겉표지</td>
    </tr>
    <tr>
        <td>주보3면</td>
        <td class="highlight">주보4면</td>
        <td>주보5면</td>
    </tr>
</table>*<strong class="sound_only">필수</strong></label></th>
            <td class="wr_4">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>

                <?php echo editor_html("wr_4", $write['wr_4'], $is_dhtml_editor); ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="wr_5">주보5면<table>
    <tr>
        <td>주보2면</td>
        <td>주보1면</td>
        <td>주보겉표지</td>
    </tr>
    <tr>
        <td>주보3면</td>
        <td>주보4면</td>
        <td class="highlight">주보5면</td>
    </tr>
</table>*<strong class="sound_only">필수</strong></label></th>
            <td class="wr_5">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>

                <?php echo editor_html("wr_5", $write['wr_5'], $is_dhtml_editor); ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>




        <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
        <tr>
            <th scope="row"><label for="wr_link<?php echo $i ?>">링크 #<?php echo $i ?></label></th>
            <td><input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" placeholder="<?=$i?>번째 링크를 입력하세요"  class="form-control round-small" style=width:100% maxlength="255"></td>
        </tr>
        <?php } ?>

        <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
        <tr>
            <th scope="row"><label for="wr_bf_file">파일 #<?php echo $i+1 ?></th>
            <td>
                <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="form-control round-small" style=width:100% maxlength="255">
                <?php if ($is_file_content) { ?>
                <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="form-control round-small" style=width:100% maxlength="255">
                <?php } ?>
                <?php if($w == 'u' && $file[$i]['file']) { ?>
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1" class="form-control round-small" style=width:100% maxlength="255"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>

        <?php if ($is_guest) { //자동등록방지  ?>
        <tr>
            <th scope="row">자동등록방지</th>
            <td>
                <?php echo $captcha_html ?>
            </td>
        </tr>
        <?php } ?>

        </tbody>
        </table>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit">
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel">취소</a>
    </div>
    </form>

    <script>
    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?php echo $write_min; ?>); // 최소
    var char_max = parseInt(<?php echo $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");

    $(function() {
        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });

    <?php } ?>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
     
        <?php echo get_editor_js("wr_1"); ?>
        <?php echo chk_editor_js("wr_1"); ?>
        
        <?php echo get_editor_js("wr_2"); ?>
        <?php echo chk_editor_js("wr_2"); ?>
        
        <?php echo get_editor_js("wr_3"); ?>
        <?php echo chk_editor_js("wr_3"); ?>
        
        <?php echo get_editor_js("wr_4"); ?>
        <?php echo chk_editor_js("wr_4"); ?>
        
        <?php echo get_editor_js("wr_5"); ?>
        <?php echo chk_editor_js("wr_5"); ?>
        
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>
</section>
<!-- } 게시물 작성/수정 끝 -->


		</div>
	</section>
</main>