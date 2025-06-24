<?php
//exit("공동제직회 기간이 아닙니다.");

extract($_GET);
$year=isset($year)?$year:"2023";
$display_year=$year;
$quater=isset($quater)?$quater:"3";
$sign_yn=isset($sign_yn)?$sign_yn:"N";
$page_yn=isset($page_yn)?$page_yn:"N";
$d_day="";
switch($quater){
case 1:
$d_day="2024-03-17";
break;
case 2:
$d_day="2024-06-16";
break;
case 3:
$d_day="2024-09-22";
break;
case 4:
$d_day="2024-12-22";
break;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php printf("%s년도 %s분기 재정 보고",$year,$quater);?></title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="./slick/slick.css">
  <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css">
  
<link rel="stylesheet" type="text/css" href="/ac/css/main.css" media="all" />
  <script src="//code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="./slick/slick.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all">
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all">
  <script type="text/javascript">
    $(document).on('ready', function() {
//		$("iframe").height($(document).height()-121);
get_print();
set_print();


    });
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight+10 + 'px';

  }
var account = [];
  function get_print()
  {
	var parts = {};
	var team = [];
	$.ajax({
		url:'/ac/ajax/get_print.php',
		dataType:'json',
		type:'post',
		data:'q=3',
		success:function(data){
			$.each(data,function(key,val){
				account = val;
			});

		}
	});
  }

  function set_print()
  {
	 var object_in=[];
	 var object_out=[];
	 var object_budget=[];
	 var object_expenditure=[];
	$.each(account,function(key,val)
    {
		if(val.ab_class=="moderator"&&val.ab_type=="In")
		{
			object_in.push("<tr><td>");
			object_in.push(val.ab_amount);
			object_in.push("</td><td>");
			object_in.push(val.ab_contents);
			object_in.push("</td></tr>");

		}

		if(val.ab_class=="moderator"&&val.ab_type=="Out")
		{
			object_out.push("<tr><td>");
			object_out.push(val.ab_amount);
			object_out.push("</td><td>");
			object_out.push(val.ab_contents);
			object_out.push("</td></tr>");
		}

		if(val.ab_class=="moderator"&&val.ab_type=="Budget")
		{
			object_budget.push("<tr><td>");
			object_budget.push(val.ab_amount);
			object_budget.push("</td><td>");
			object_budget.push(val.ab_contents);
			object_budget.push("</td></tr>");
		}

		if(val.ab_class=="moderator"&&val.ab_type=="Expenditure")
		{
			object_expenditure.push("<tr><td>");
			object_expenditure.push(val.ab_amount);
			object_expenditure.push("</td><td>");
			object_expenditure.push(val.ab_contents);
			object_expenditure.push("</td></tr>");

		}
	  });
		  const table_open = ['<table>'];
		  const table_close = ['</table>'];
	 object_in = table_open.concat(object_in);
	 object_in = object_in.concat(table_close);
		$("#moderator .In").html(object_in.join(""));
		$("#moderator .Out").html(object_out.join(""));
		$("#moderator .Budget").html(object_budget.join(""));
		$("#moderator .Expenditure").html(object_expenditure.join(""));
  }
var order = [];
order['moderator'] = [];
order['moderator']['In']=[];
order['moderator']['Out']=[];
order['moderator']['Budget']=[];
order['moderator']['Expenditure']=[];
order['ezratv'] = [];
order['ezratv']['In']=[];
order['ezratv']['Out']=[];
order['ezratv']['Budget']=[];
order['ezratv']['Expenditure']=[];
order['building'] = [];
order['building']['In']=[];
order['building']['Out']=[];
order['building']['Budget']=[];
order['building']['Expenditure']=[];
order['assistant_pastor'] = [];
order['assistant_pastor']['In']=[];
order['assistant_pastor']['Out']=[];
order['assistant_pastor']['Budget']=[];
order['assistant_pastor']['Expenditure']=[];
order['mans'] = [];
order['mans']['In']=[];
order['mans']['Out']=[];
order['mans']['Budget']=[];
order['mans']['Expenditure']=[];
order['hymn'] = [];
order['hymn']['In']=[];
order['hymn']['Out']=[];
order['hymn']['Budget']=[];
order['hymn']['Expenditure']=[];
order['media'] = [];
order['media']['In']=[];
order['media']['Out']=[];
order['media']['Budget']=[];
order['media']['Expenditure']=[];
order['facilities'] = [];
order['facilities']['In']=[];
order['facilities']['Out']=[];
order['facilities']['Budget']=[];
order['facilities']['Expenditure']=[];
order['welfare_mission'] = [];
order['welfare_mission']['In']=[];
order['welfare_mission']['Out']=[];
order['welfare_mission']['Budget']=[];
order['welfare_mission']['Expenditure']=[];
order['new_family'] = [];
order['new_family']['In']=[];
order['new_family']['Out']=[];
order['new_family']['Budget']=[];
order['new_family']['Expenditure']=[];
order['womans'] = [];
order['womans']['In']=[];
order['womans']['Out']=[];
order['womans']['Budget']=[];
order['womans']['Expenditure']=[];
order['kitchen'] = [];
order['kitchen']['In']=[];
order['kitchen']['Out']=[];
order['kitchen']['Budget']=[];
order['kitchen']['Expenditure']=[];
order['kids'] = [];
order['kids']['In']=[];
order['kids']['Out']=[];
order['kids']['Budget']=[];
order['kids']['Expenditure']=[];
order['sunday_school'] = [];
order['sunday_school']['In']=[];
order['sunday_school']['Out']=[];
order['sunday_school']['Budget']=[];
order['sunday_school']['Expenditure']=[];
order['youth'] = [];
order['youth']['In']=[];
order['youth']['Out']=[];
order['youth']['Budget']=[];
order['youth']['Expenditure']=[];
order['student'] = [];
order['student']['In']=[];
order['student']['Out']=[];
order['student']['Budget']=[];
order['student']['Expenditure']=[];


</script>
  <style type="text/css">
    html, body {
      margin: 0;
      padding: 0;
    }

    * {
      box-sizing: border-box;
    }

    .slider {
        width: 90%;
		height: 800px;
        margin: 100px auto;
    }

    .slick-slide {
      margin: 0px 20px;
    }

    .slick-slide img {
      width: 100%;
    }

    .slick-prev:before,
    .slick-next:before {
      color: black;
    }


    .slick-slide {
      transition: all ease-in-out .3s;
      opacity: .2;
    }
    
    .slick-active {
      opacity: .5;
    }

    .slick-current {
      opacity: 1;
    }
	.virtual_box{position: relative;width: 100%;height: max-content;min-height: 600px;}
	.h1{font-size: xxx-large;position: absolute;top:40%;height:600px;text-align: center;width: inherit;font-family: 'Godo';}
	.h3{font-size: large;position: absolute;top: 80%;height: 600px;text-align: center;width: inherit;font-family: 'Godo';}
	iframe{width:100%;min-height:600px;height: max-content;}
	iframe html{margin-top: 10px;}


      @media print {
        table {
          page-break-inside: avoid !important;
        }
        tr {
          break-inside: avoid !important;
        }
        tbody {
          display: block;
        }
        tbody tr:nth-child(5n + 1) {
          page-break-before: always;
        }
      }
.In,.Out{float: left;width: 48%;}
.Budget,.Expenditure{float: left;width: 48%;}
  </style>
</head>
<?php 
$dp_quater=$quater;
?>
<body>
  <section>
	<div class="virtual_box">
		<div class="h1"><?php echo $year;?>년 <?php echo $quater;?>분기 결산<br><?php echo $quater=="4"?++$year:$year;?>년 <?php echo $quater=="4"?"1":++$quater;?>분기 예산
		<?php
if($dp_quater=="4"){
	?><br>
<?php echo $year;?>년 총 예산안
<?php }		?>
		</div>
		<div class="h3">서울에스라교회<br>공동제직회<br><?php echo $d_day;?>(주일)</div>
    </div>
<div id="result">#result</div>
<div id="moderator">
<div class="virtual_box">
<div class="h1">당회<br>재정보고</div>
</div>
<div class="virtual_box">
<h1>2024년 당회 3분기 항목별 명세서</h1>
	<div class="In"></div>
	<div class="Out"></div>
	<div class="InOutTotal"></div>
</div>
<div style="clear:both"></div>
<div class="virtual_box">
<h1>2024년 당회 3분기 재정보고서</h1>
	<div class="Budget"></div>
	<div class="Expenditure"></div>
	<div class="BudgetExpenditureTotal"></div>
</div>
</div>