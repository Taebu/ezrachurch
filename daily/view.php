<?php
include_once "../db_con.php";
$sql=sprintf("select * from ez_daily where ed_no='%s';",$ed_no);
$query=$db->query($sql);
$view=$query->fetch_assoc();
include_once './functions.php';
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link rel="stylesheet" type="text/css" href="/wm/lib/css/westminster_main.css?new=2" media="all" />
  <title> <?php echo $view['ed_subject'];?> |  <?php echo $view['ed_author'];?></title>

 </head>
 <body class="westminster_blacktheme" >
 <?php echo $view['ed_subject'];?><br>
 <?php echo $view['ed_date'];echo "&nbsp";
 $day_of_number=date('N', strtotime($view['ed_date']));
echo get_weekly($day_of_number);?><br>
 <?php echo $view['ed_author'];?><br>
 <?php echo isset($view['ed_youtube_url'])?get_youtube($view['ed_youtube_url']):"";?><br>
 <?php echo $view['ed_content'];?>
 </body>
</html>
