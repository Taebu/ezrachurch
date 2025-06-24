<?php
if(!isset($_GET['mb_id'])&&!isset($_GET['ab_class'])){
	header("Location: https://ezrachurch.kr/ac/");
}
$ab_class = isset($_GET['ab_class'])?$_GET['ab_class']:"";
$mb_id = isset($_GET['mb_id'])?$_GET['mb_id']:"";
extract($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Document</title>
<script src="/wp/js/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<style>
select,input{padding:5px 10px 10px 10px;font-size:15px;margin-right:10px;width: 90%;}
textarea{margin: 0px; ;width: 90%; height: 239px;}
.boxsizingBorder {
    -webkit-box-sizing: border-box;
       -moz-box-sizing: border-box;
            box-sizing: border-box;
}
</style>
</head>
<body>
<pre>
인수인계 
이번 분기를 기준으로 인수인계하실 회계 아이디를 서울 에스라 홈페이지(ezrachurch.kr) 가입한 이후에 신청 해 주시면 인수인계 아이디를 검색하여 인수인계를 신청하실 수 있습니다.

서울 에스라 홈페이지 하나의 아이디로 하나의 부서만 관리 가능합니다.

신청 접수 후 관리자 아이디를 접근 할 수 있는 회원 매체팀원에게 고지 해주시면 관리자로 접근하여 회계권한을 신청하신 아래의 하신 정보로 갱신 시켜 드립니다.

주의 !!! 관리자가 승인 후 해당아이디는 회계관리 권한을 잃게 됩니다.
</pre>
<h3>필수 정보</h3>
<form onsubmit="return set_takeover()" id="frm_takeover">
<input type="hidden" name="au_id" id="au_id" value="<?php echo $mb_id;?>">
<input type="hidden" name="at_status" id="at_status" value="reception">
<input type="hidden" name="ab_class" id="ab_class" value="<?php echo $ab_class;?>">
<input type="hidden" name="au_name" id="au_name">

<table class="ibk_info">
<tr>
<td>아이디</td>
<td><input type="text" name="mb_id" id="mb_id">
<p><label for="" id="display_auth_id"></label></p>
</td>
</tr>
<tr>
<td>담당 부서 </td>
<td><label for="" id="display_class"></label></td>
</tr>

</table>
<h3>부가 정보</h3>
* 선택사항
<table class="ibk_info">
<tr>
<td>은행명</td>
<td><input type="text" name="au_bankname" id="au_bankname"></td>
</tr>
<tr>
<td>계좌번호</td>
<td><input type="text" name="au_bankno" id="au_bankno"></td>
</tr>
<tr>
<td>입금자명</td>
<td><input type="text" name="au_holder" id="au_holder"></td>
</tr>
<tr>
<td>사유</td>
<td><input type="text" name="at_content" id="at_content"></td>
</tr>
</table>
<input type="submit" id="btn_takeover" disabled value="인수인계 신청">
</form>
<script>
let is_validate_id = false;


$("#mb_id").on( "keyup", function() {
	check_id();
});

get_member();
function check_id()
{
	var mb_id= $("#mb_id").val();
	var au_id= $("#au_id").val();
	if(au_id==mb_id){
		$("#display_auth_id").html("본인의 아이디로는 인수인계 할 수 없습니다.");
		$("#display_auth_id").addClass("red");
		$("#display_auth_id").removeClass("green");
		is_validate_id = false;
		visible_button(is_validate_id);
		return ;
	}

	if(mb_id.length<2){
		$("#display_auth_id").html("2자 이상 입력해 주세요.");
		$("#display_auth_id").addClass("red");
		$("#display_auth_id").removeClass("green");
		return;	
	}

	$.ajax({
		url:'./ajax/check_id.php',
		data:'mb_id='+mb_id,
		type:'GET',
		dataType:'json',
		success:function(data){
			console.log(data);
			if(data.success){
				$("#display_auth_id").html("가입되어 인수인계 할 수 있는 아이디입니다.");
				$("#au_name").val(data.mb_name);

				$("#display_auth_id").addClass("green");
				$("#display_auth_id").removeClass("red");
				is_validate_id = true;
			}else{
				$("#display_auth_id").html("가입 되어 있지 않은 아이디입니다.");
				$("#display_auth_id").addClass("red");
				$("#display_auth_id").removeClass("green");
				is_validate_id = false;
			}

			visible_button(is_validate_id);
		}
	});

}

function get_member(){
	var mb_id= $("#au_id").val();
	var ab_class= $("#ab_class").val();

	var param = "";
	if(ab_class=="")
	{
		param = 'mb_id='+mb_id;
	}

	
	if(mb_id=="")
	{
		param = 'ab_class='+ab_class;
	}

	$.ajax({
		url:"./ajax/get_member.php",
		dataType:"json",
		data:param,
		type:"GET",
		success:function(data){
			if(data.success){
				$("#ab_class").val(data.member.ab_class);
				$("#au_name").val(data.member.au_name);
				$("#au_bankname").val(data.member.au_bankname);
				$("#au_bankno").val(data.member.au_bankno);
				$("#au_holder").val(data.member.au_holder);
				$("#display_class").html(data.member.class_name+"("+data.member.ab_class+")");
			}
		}
	});	
}

function visible_button(is_validate_id)
{
	$("#btn_takeover").attr("disabled",!is_validate_id);
}

function set_takeover()
{
	var param = $("#frm_takeover").serialize();
	$.ajax({
		url:"./ajax/set_takeover.php",
		dataType:"json",
		data:param,
		type:"POST",
		success:function(data){
			if(data.success)
			{
				alert("인수인계 접수 처리 되어 관리자의 승인을 기다립니다.");
				location.href='/wp/';
			}
		}
	});
	return false;
}
</script>
</body>
</html>