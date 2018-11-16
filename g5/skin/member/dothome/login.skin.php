<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<?include_once("../d_head.php");?>
<style type="text/css">

    .modal-dialog_img{-webkit-transform:translate(0, -25%);-ms-transform:translate(0, -25%);transform:translate(0, -25%);-webkit-transition:-webkit-transform 0.3s ease-out;-moz-transition:-moz-transform 0.3s ease-out;-o-transition:-o-transform 0.3s ease-out;transition:transform 0.3s ease-out;}
    .modal-dialog_img{-webkit-transform:translate(0, 0);-ms-transform:translate(0, 0);transform:translate(0, 0);}
    .modal-dialog_img{margin-left:auto;margin-right:auto;width:auto;padding:10px;z-index:1050;}
    @media screen and (min-width:800px){.modal-dialog_img{left:50%;right:auto;width:1000px;padding-top:30px;padding-bottom:30px;}

</style>
<div class="container login">

	<!-- HEADING -->
	<div>
	</div>
	<!-- HEADING -->

	<!-- BODY -->
	<div class="row">
		<div class="col-sm-offset-3 col-sm-6">
<!-- 			<form class="form-horizontal" role="form" method="post" action="login_check.php" > -->
		    <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post" class="form-horizontal" role="form" >
		    <input type="hidden" name="url" value='<?php echo $login_url ?>'>
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Login</strong></div>
					<div class="panel-body">
						<div class="form-group">
							<label for="id" class="control-label col-sm-3">User ID: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" placeholder="User ID" autofocus name="mb_id" id="login_id" required required" size="20" maxLength="20">
								 
							</div>
						</div>
						<br />
						<div class="form-group">
							<label for="pw" class="control-label col-sm-3">Password: </label>
							<div class="col-sm-6">
								<input type="password" class="form-control" placeholder="Password" name="mb_password" id="login_pw" required class="frm_input required" size="20" maxLength="20">
							</div>
							        <input type="checkbox" name="auto_login" id="login_auto_login">
        <label for="login_auto_login">자동로그인</label>
						</div>
						<!--
						<label class="checkbox">
							<input type="checkbox" value="remember-me"> Remember me
						</label>
						-->					
					</div>
					<div class="panel-footer">
						<div class="form-group">
							<label for="pw" class="control-label col-sm-3"></label>
							<div class="col-sm-6">
								<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
								<input type="hidden" name="rq_url" value="/files/page/ministry_mission.html">
							</div>

						</div>
        <h2>회원로그인 안내</h2>
        <p>
            회원아이디 및 패스워드가 기억 안나실 때는 아이디/패스워드 찾기를 이용하십시오.<br>
            아직 회원이 아니시라면 회원으로 가입 후 이용해 주십시오.
        </p>
        <div>
            <a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost" class="btn02">아이디 패스워드 찾기</a>
            <a href="./register.php" class="btn01">회원 가입</a>
        </div>


    <div class="btn_confirm">
        <a href="<?php echo G5_URL ?>/">메인으로 돌아가기</a>
    </div>

					</div>

				</div>
			</form>
		</div>
	</div>
	<!-- BODY -->
</div>

<!-- Body End -->

<!-- 로그인 시작 { -->
<!--link rel="stylesheet" href="<?php echo $member_skin_url ?>/style.css"-->

<!-- <div id="mb_login" class="mbskin">
    <h1><?php echo $g5['title'] ?></h1>

    <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
    <input type="hidden" name="url" value='<?php echo $login_url ?>'>

    <fieldset id="login_fs">
        <legend>회원로그인</legend>
        <label for="login_id" class="login_id">회원아이디<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="mb_id" id="login_id" required class="frm_input required" size="20" maxLength="20">
        <label for="login_pw" class="login_pw">패스워드<strong class="sound_only"> 필수</strong></label>
        <input type="password" name="mb_password" id="login_pw" required class="frm_input required" size="20" maxLength="20">
        <input type="submit" value="로그인" class="btn_submit">
        <input type="checkbox" name="auto_login" id="login_auto_login">
        <label for="login_auto_login">자동로그인</label>
    </fieldset>

    <aside id="login_info">
        <h2>회원로그인 안내</h2>
        <p>
            회원아이디 및 패스워드가 기억 안나실 때는 아이디/패스워드 찾기를 이용하십시오.<br>
            아직 회원이 아니시라면 회원으로 가입 후 이용해 주십시오.
        </p>
        <div>
            <a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost" class="btn02">아이디 패스워드 찾기</a>
            <a href="./register.php" class="btn01">회원 가입</a>
        </div>
    </aside>

    <div class="btn_confirm">
        <a href="<?php echo G5_URL ?>/">메인으로 돌아가기</a>
    </div>

    </form>

</div>
 -->
<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 패스워드를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 끝 -->
<?include_once("../d_footer.php");?>