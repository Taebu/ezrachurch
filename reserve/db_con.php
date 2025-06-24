<?php
$conf = array();
$conf['dbhost'] = 'localhost';
$conf['dbuser'] = 'root';
$conf['dbpass'] = '';
$conf['dbname'] = 'newezra';

date_default_timezone_set('Asia/Seoul');
//출처: https://it77.tistory.com/281 [시원한물냉의 사람사는 이야기:티스토리]
$db = new mysqli($conf['dbhost'], $conf['dbuser'], $conf['dbpass'],$conf['dbname']);
$db->query("set names utf8;");


function dbquery($sql) {
global $db;
$res = $db->query($sql);
return $res;
}

function dbfetch($res) {
$row = mysql_fetch_array($res);
return $row;
}

function dbqueryfetch($sql) {
$res = mysql_query($sql);
$row = mysql_fetch_array($res);
return $row;
}