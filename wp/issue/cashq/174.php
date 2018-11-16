<?php
$host_name="localhost";
$db_name="cashq";
$user_name="root";
$db_password="apmsetup";
$connect=mysql_connect($host_name, $user_name, $db_password);
$db_selected = mysql_select_db($db_name, $connect);
extract($_GET);
extract($_SERVER);
$sql=array();
$sql[]="select mb_hp,count(*) cnt from 0507_point ";
$sql[]="where date(st_dt)=date('".$st_dt."') and status>0 ";
$sql[]="group by mb_hp having cnt>1;";
$str_sql=join("",$sql);
echo $str_sql;
$query=mysql_query($str_sql);
echo "<br>";
echo "<br>";

/**

Array
(
    [seq] => 1086718
    [SVC_ID] => 99
    [START_DT] => 2015-04-22 13:58:36
    [END_DT] => 2015-04-22 13:58:46
    [CALLED_HANGUP_DT] => 2015-04-22 13:58:36
    [CALLER_NUM] => 01039111315
    [CALLED_NUM] => 0325659833
    [VIRTUAL_NUM] => 05085123408
    [REASON_CD] => 
    [REG_DT] => 2015-04-22 13:59:02
    [userfield] => audio:OUT-20150422-135836-1429678716.503.wav
    [biz_code] => 
    [po_status] => 1
)

*/


echo "<table border=1>";
echo "<tr><td>mb_hp</td><td>cnt</td><td>query</td></tr>";
while($list=mysql_fetch_assoc($query)){
//print_r($list);
echo "<tr><td>";
echo $list['mb_hp'];
echo "</td><td>";
echo $list['cnt'];
echo "</td><td>";
$sql_2=array();
$sql_2[]="select seq,status from 0507_point ";
$sql_2[]="where date(st_dt)=date('".$st_dt."') ";
$sql_2[]="and mb_hp='".$list['mb_hp']."'  and status>0 order by seq desc limit 1;";
$str_sql2=join("",$sql_2);
$query2=mysql_query($str_sql2);
$row=mysql_fetch_assoc($query2);


$sql_3=array();
$sql_3[]="update 0507_point set ";
$sql_3[]="status='0' ";
$sql_3[]="where date(st_dt)=date('".$st_dt."') ";
$sql_3[]="and seq='".$row['seq']."';";
$str_sql3=join("",$sql_3);
$query3=mysql_query($str_sql3);
echo $row['seq'];
echo "</td></tr>";
}
echo "</table>";
?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
<input type="text" name="st_dt" id="st_dt" value="<?php echo $st_dt;?>"/>
<input type="submit" value="fix it" />
</form>
