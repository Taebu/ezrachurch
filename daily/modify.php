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
  <title> <?php echo $view['ed_subject'];?> |  <?php echo $view['ed_author'];?></title>
  <link rel="stylesheet" href="/wp/css/jquery.ui.min.css">  
  <script src="/wp/js/jquery-1.12.4.min.js"></script>
  <script src="/wp/js/jquery.ui.min.js"></script>

  <style>
	input,textarea{
	width:-webkit-fill-available;
	padding: 10px;
	margin: 5px;
	font-size: 20pt;
	}
  </style>
  <script>
	/* datepicker */
var dateoption={dateFormat: "yy-mm-dd",
dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
dayNames: [ "일", "월", "화", "수", "목", "금", "토" ],
monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
showOn:"both",
buttonImageOnly: true, //이미지표시
buttonImage: '/wp/img/btn_calendar.gif', //이미지주소
};

  $( function() {
    $("#ed_date").datepicker(dateoption);
	
	//$("#ed_date").datepicker('setDate', new Date());
  });


	function set_daily()
	{
		
		$.ajax({
			url:"./ajax/set_daily.php",
			method:"POST",
			success:function(data){
				console.log(data);
			}
		});
		
		return true;
	}

</script>
</head>
<body class="westminster_blacktheme" >
<form action="./ajax/set_daily.php" onsubmit="return set_daily()" method="POST">
<input type="hidden" name="mode" value="modify">
<input type="hidden" name="ed_no" value="<?php echo $_GET['ed_no'];?>">
<div>ed_subject : <input type="text" placeholder="ed_subject" name="ed_subject" required value="<?php echo $view['ed_subject'];?>"></div>
<div>ed_date : <input type="text" placeholder="ed_date" name="ed_date" id="ed_date" required value="<?php echo $view['ed_date'];?>"></div>
<div>ed_author : <input type="text" placeholder="ed_author" name="ed_author" value="<?php echo $view['ed_author'];?>" required></div>
<div>ed_youtube_url : <input type="text" placeholder="ed_youtube_url" name="ed_youtube_url" required value="<?php echo $view['ed_youtube_url']?>"></div>
<div>ed_content : <textarea name="ed_content" id="ed_content" cols="30" rows="4" placeholder="ed_content" required><?php echo $view['ed_content'];?></textarea></div>
<input type="submit">
</form>
</body>
</html>
