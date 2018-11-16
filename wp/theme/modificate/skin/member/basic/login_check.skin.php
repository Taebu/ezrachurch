<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 자신만의 코드를 넣어주세요.

// 문자열 암호화
function get_encrypt_string_sehb($str)
{
//    if(defined('G5_STRING_ENCRYPT_FUNCTION') && G5_STRING_ENCRYPT_FUNCTION) {
//        $encrypt = call_user_func(G5_STRING_ENCRYPT_FUNCTION, $str);
//    } else {
        $encrypt = sehb_sql_password($str);
//    }

    return $encrypt;
}

// 비밀번호 비교
function sehb_check_password($pass, $hash)
{
    $password = get_encrypt_string_sehb($pass);

    return ($password === $hash);
}

function sehb_sql_password($value)
{
    // mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
    // mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
    $row = sql_fetch(" select old_password('$value') as pass ");

    return $row['pass'];
}

// 회원 정보를 얻는다.
function sehb_get_member($mb_id, $fields='*')
{
    //global $g5;

    return sql_fetch(" select user_id mb_id,password mb_password from `zetyx_member_table` where user_id = TRIM('$mb_id') ");
}





if($login_type=="sehb")
{

	$mb = sehb_get_member($mb_id);
	echo sehb_sql_password($mb_password);
	echo " : ";
	echo $mb['mb_password'];
	if (!sehb_check_password($mb_password, $mb['mb_password'])) {
		//print_r($mb);
		alert('가입된 회원아이디가 아니거나 비밀번호가 틀립니다.\\n비밀번호는 대소문자를 구분합니다.');
	}

}

?>
