<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="/wp/adm/check/billboard.js"></script>
<link rel="stylesheet" href="/wp/adm/check/billboard.css">

<!-- Markup -->
<div id="flow"></div>

<script>

/* 첫 번째 데이터 */
/*
var chart = bb.generate({
  data: {
    x: "x",
    columns: [
	["x", "2012-12-29", "2012-12-30", "2012-12-31"],
	["data1", 230, 300, 330],
	["data2", 190, 230, 200],
	["data3", 90, 130, 180]
    ]
  },
  axis: {
    x: {
      type: "timeseries",
      tick: {
        format: "%m/%d"
      }
    }
  },
  bindto: "#flow"
});
*/
var bill_data = [["x", "2012-12-29", "2012-12-30", '2013-01-11', '2013-01-21', "2012-12-31",'2013-01-11', '2013-01-21', '2013-03-01', '2013-03-02', '2013-03-21', '2013-04-01'],
["data1", 230, 300, 330, 500, 200,200, 300, 100, 250, 200, 300, 500, 200],
["data2", 190, 230, 200, 100, 300,100, 90,   40, 120, 150, 250, 100, 150],
["data3", 90, 130,  180, 200, 120,100, 100, 300, 500, 100, 100, 200, 400]];

var chart = bb.generate({
  data: {
    x: "x",
    columns: [

		[bill_data[0][0],bill_data[0][1],bill_data[0][2],bill_data[0][3]],
		[bill_data[1][0],bill_data[1][1],bill_data[1][2],bill_data[1][3]],
		[bill_data[2][0],bill_data[2][1],bill_data[2][2],bill_data[2][3]],
		[bill_data[3][0],bill_data[3][1],bill_data[3][2],bill_data[3][3]],
			]
  },
  axis: {
    x: {
      type: "timeseries",
      tick: {
        format: "%m/%d"
      }
    }
  },
  bindto: "#flow"
});
/* 두 번째 데이터 */

setTimeout(function() {
	chart.flow({
		columns: [
		[bill_data[0][0],bill_data[0][4],bill_data[0][5]],
		[bill_data[1][0],bill_data[1][4],bill_data[1][5]],
		[bill_data[2][0],bill_data[2][4],bill_data[2][5]],
		[bill_data[3][0],bill_data[3][4],bill_data[3][5]],
		],
		duration: 1500,
		done: recursive,
	});
}, 1000);





function recursive()
{
		/* 세 번째 데이터 */
		chart.flow({
			columns: [

		[bill_data[0][0],bill_data[0][5],bill_data[0][7],bill_data[0][8],bill_data[0][9]],
		[bill_data[1][0],bill_data[1][5],bill_data[1][7],bill_data[1][8],bill_data[1][9]],
		[bill_data[2][0],bill_data[2][5],bill_data[2][7],bill_data[2][8],bill_data[2][9]],
		[bill_data[3][0],bill_data[3][5],bill_data[3][7],bill_data[3][8],bill_data[3][9]],
			],
			length: 0,
			duration: 1500,
			done: function() {

				/* 네 번째 데이터 */
					chart.flow({
							columns: [
		[bill_data[0][0],bill_data[0][11],bill_data[0][12]],
		[bill_data[1][0],bill_data[1][11],bill_data[1][12]],
		[bill_data[2][0],bill_data[2][11],bill_data[2][12]],
		[bill_data[3][0],bill_data[3][11],bill_data[3][12]],
							],
							length: 2,
							duration: 1500,
							done: function() {

								/* 다섯 번째 데이터 */
								chart.flow({
									columns: [
		[bill_data[0][0],bill_data[0][13],bill_data[0][14]],
		[bill_data[1][0],bill_data[1][13],bill_data[1][14]],
		[bill_data[2][0],bill_data[2][13],bill_data[2][14]],
		[bill_data[3][0],bill_data[3][13],bill_data[3][14]],
									],
									to: '2013-03-01',
									duration: 1500
								});
							}
					});
				}
		});
	
}
</script>