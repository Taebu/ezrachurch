<?php
header('Access-Control-Allow-Origin: *');
include_once('./_common.php');
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('../head.php');
?>
<script src="/wp/theme/modificate/youtube/js/jquery.js"></script>
<!-- This is what you need -->
<script src="/wp/theme/modificate/youtube/js/sweetalert.js"></script>
<script src="/wp/theme/modificate/youtube/js/bootstrap.min.js"></script>
<main class="page-content">
<section class="well text-center text-md-left">
<div class="row">
<div class="container">
   <div class="row">
      <div class="col-sm-12">
<div class="table-custom-responsive">
<?php
$sql= "SELECT * FROM newezra.car_info where car_status='stay';";

/* 2. sql_query 처리한 정보를 result에 담는다. */
$result = sql_query($sql);
print '<table class="table table-striped table-mobile mobile-primary">';
print "<thead>";
	print "<tr>";
	print "<th>";
	print "차량주인";
	print "</th>";
	print "<th>";
	print "차량명";
	print "</th>";
	print "<th>";
	print "차량번호";
	print "</th>";
	if($is_admin)
	{
	print "<th>";
	print "핸드폰번호";
	print "</th>";
	}
	print "</tr>";
print "</thead>";
/* 3. newezra.ez_helper 정보만큼 반복한다. */
print "<tbody>";
for ($i=0; $list=sql_fetch_array($result); $i++)
{
	print "<tr>";
	print "<td>";
	print $list['car_owner'];
	print "</td>";	
	print "<td>";
	print $list['car_name'];
	print "</td>";	
	print "<td>";
	print $list['car_number'];
	print "</td>";	
	if($is_admin)
	{
	print "<td>";
	print $list['car_phone'];
	print "</td>";	
	}
	print "</tr>";
}
print "</tbody>";
print "</table>";
	?>
	</div>
	</div><!-- .row -->
	</div><!-- .row -->

</section>
</main>

<?php
include_once(G5_PATH.'/tail.php');
?>