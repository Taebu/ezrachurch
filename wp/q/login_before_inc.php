

<form name='login_form' method='post' action="/wp/bbs/login_check.php" style='margin:0'>
<input type='hidden' name='url' value="<?php echo $PHP_SELF?>">

<table width='100%' valign='top' cellpadding='0' cellspacing='0' style='margin: 3px 0 0 0' border='0'>


<tr height='26'>

<td width='100' valign='top' style='padding : 0 0 0 0;'>

<div id='id_copy' style="margin: 0; position:absolute; z-index:1; visibility:visible">
<input type='text' size='20' style='width:94px; height:19px; font-size:13px; padding: 2 0 0 4; border: solid 1px #E3E3E3; color:#CACACA; ' value='아이디' readonly onclick="id_insert()">
</div>


<input type='text' name='mb_id'  tabindex='1' style='width:94px; height:19px; font-size:13px; padding: 0 0 0 4; border: solid 1px #E3E3E3; color:#222; ime-mode:inactive;' value=''>
</td>

<td width='100' valign='top' style='padding : 0 0 0 0;'>   


<div id='password_copy' style="margin: 0 0 0 0; position:absolute; z-index:1;; visibility:visible">
<input type='text' size='20' style='width:94px; height:19px; font-size:13px; padding: 2 0 0 4; border: solid 1px #E3E3E3; color:#CACACA; ' value='비밀번호' readonly  onclick="password_insert()">
</div>


<input type='password' name='mb_password' tabindex='2' style='width:94px; height:19px; font-size:13px; padding: 0 0 0 4px; border: solid 1px #E3E3E3;' onfocus="password_insert()" value=''></td>


<td valign='top' style='padding-top:2px'><input type='image' src='./img/btn_login.gif'></td>

</tr>
</table>	   
 
</form>





<script type='text/javascript'>

function id_insert() {

   var id_copy = document.getElementById('id_copy');
   var password_copy = document.getElementById('password_copy');
  
   var f = document.login_form;

   id_copy.style.visibility = 'hidden';
   f.mb_id.focus();

   if(f.mb_password.value == '') password_copy.style.visibility = 'visible';

}


function password_insert() {

   var id_copy = document.getElementById('id_copy');
   var password_copy = document.getElementById('password_copy');
   
   var f = document.login_form;

   password_copy.style.visibility = 'hidden';
   f.mb_password.focus();
   
   if(f.mb_id.value == '') id_copy.style.visibility = 'visible';

}

document.login_form.mb_id.focus();
</script>

