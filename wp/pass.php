<?php
include_once('./common.php');
 
$a = 'admin';
$b = 'ezra1754!@';
$c = get_encrypt_string($b);
sql_query("update {$g5['member_table']} set mb_password = '{$c}' where mb_id = '{$a}' ");
?>