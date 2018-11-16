<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<!-- <?php echo G5_THEME_URL;?>/images/header-1.jpg -->

<!--=================================================
                           Content
    ==================================================-->
    <main class="page-content">
        <section>
            <div class="container">


<!-- 회원가입약관 동의 시작 { -->
<div class="mbskin" style=padding:50px;>
    <form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">


    <section id="fregister_term">
        <h5>회원가입약관</h5>
    <small>회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</small>

        <textarea readonly class="form-control round-small "><?php echo get_text($config['cf_stipulation']) ?></textarea>
        <fieldset class="fregister_agree">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="agree" value="1" id="agree11"><span class="checkbox-field"></span><span class="text-dark-variant-2 font-secondary">회원가입약관의 내용에 동의합니다.</span>
              </label>
            </div>
        </fieldset>
    </section>

	<p></p><p></p>

    <section id="fregister_private">
        <h5>개인정보처리방침안내</h5>
        <div class="tbl_head01 tbl_wrap">
            <table>
                <caption>개인정보처리방침안내</caption>
                <thead>
                <tr>
                    <th>목적</th>
                    <th>항목</th>
                    <th>보유기간</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>이용자 식별 및 본인여부 확인</td>
                    <td>아이디, 이름, 비밀번호</td>
                    <td>회원 탈퇴 시까지</td>
                </tr>
                <tr>
                    <td>고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</td>
                    <td>연락처 (이메일, 휴대전화번호)</td>
                    <td>회원 탈퇴 시까지</td>
                </tr>
                </tbody>
            </table>
        </div>
        <fieldset class="fregister_agree">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="agree2" value="1" id="agree21"><span class="checkbox-field"></span><span class="text-dark-variant-2 font-secondary">개인정보처리방침안내의 내용에 동의합니다.</span>
              </label>
            </div><!-- .checkbox -->
        </fieldset>
    </section>

    <div class="btn_confirm">
        <input type="submit" class="offset-5 btn btn-primary btn-xs round-small btn_submit" value="회원가입">
    </div>

    </form>

    <script>
    function fregister_submit(f)
    {
        if (!f.agree.checked) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree2.focus();
            return false;
        }

        return true;
    }
    </script>
</div>
<!-- } 회원가입 약관 동의 끝 -->


</div></section></main>