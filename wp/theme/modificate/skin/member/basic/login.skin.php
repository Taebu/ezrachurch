<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<?php //include_once("./_head.php");?>
<!-- list.php -->
<?php
include_once('../common.php');
include_once "../theme/modificate/head_full.php";
?>


        <section class="text-center">
          <div class="jumbotron text-center offset-large">
            <h1>Login Page</h1>
          </div>
        </section>

        <!--Start section-->
        <section class="well well-sm">
          <div class="container">
            <div class="row flow-offset-1">
              <div class="col-md-6 col-md-offset-3 btn-shadow inset-sm-min img-rounded bg-black">

                <form class="row label-insets" name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
			    <input type="hidden" name="url" value="<?php echo urlencode($_GET['url']); ?>">
<!--                 <h5 class="text-center"><div class="radio inline-block" style=padding-right:30px;>
                      <label>
                        <input type="radio" name="login_type" id="login_type" value="ezra" checked><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary"> 서울에스라교회</span>
                      </label>
                    </div>
                					
                					
                					<div class="radio inline-block">
                      <label>
                        <input type="radio" name="login_type" id="login_type" value="sehb"><span class="radio-field"></span><span class="text-dark-variant-2 font-secondary"> 서울에스라성서원</span>
                      </label>
                    </div></h5> -->
                
                  <div class="form-group col-sm-12">
                    <label for="login_id" class="text-uppercase font-secondary">아이디</label>
                    <input type="text" name="mb_id" placeholder="Username or E-mail" id="login_id" class="form-control round-small">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="exampleInputPass1" class="text-uppercase font-secondary">비밀번호</label>
                    <input type="password"  name="mb_password" placeholder="Your password" id="exampleInputPass1" class="form-control round-small">
                  </div>
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary btn-xs round-small btn-block form-el-offset-1">로그인</button>
                  </div> 
                <div class="col-xs-12 text-center">
                    <p class="small text-uppercase text-light-clr font-secondary max-width separate">or</p>
                    <div class="btn-elements-group-2" style="color:white"> 회원이 아니십니까?<!-- <a href="#" class="btn btn-info btn-xs round-small btn-icon-left btn-min-width"><span class="icon fa-facebook"></span> facebook</a><a href="#" class="btn btn-primary btn-xs round-small btn-icon-left btn-min-width"><span class="icon fa-twitter"></span> Twitter</a> -->
                    <!-- <a href="/wp/bbs/register.php" class="btn btn-warning btn-xs round-small btn-icon-left btn-min-width"><span class="icon fa-google-plus"></span> 회원가입</a> -->
                    <a href="/wp/bbs/register.php" class="btn btn-warning btn-xs round-small btn-icon-left btn-min-width"><span class="icon fa-user"></span> 회원가입</a>

                    </div>
                  </div>
                </form>
                
              </div>
            </div>
          </div>
        </section>
        <!--End section-->

      </header>


<?php include_once("./_tail.php");?>
