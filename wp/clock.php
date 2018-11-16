<!DOCTYPE html>

<html style="display:block; height:100%; margin:0; padding:0">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Clock</title>
		<style type="text/css">
			/* Customizable font and colors */
			html {
				background: #000000;
			}
			#clocktext {
				font-family: sans-serif;
				font-weight: bold;
				color: #FFFFFF;
			}
		</style>
	</head>
	
	<body style="display:table; width:100%; height:100%; margin:0; padding:0">
		<div style="display:table-cell; width:100%; height:100%; text-align:center; vertical-align:middle">
			<span id="clocktext" style="font-size:24pt; font-kerning:none"></span>
		</div>
		
		<script type="text/javascript">
			"use strict";
			
			var textElem = document.getElementById("clocktext");
			var textNode = document.createTextNode("");
			textElem.appendChild(textNode);
			var curFontSize = 24;  // Do not change
			
			function updateClock() {
				var d = new Date();
				var s = "";
				s += (10 > d.getHours  () ? "0" : "") + d.getHours  () + ":";
				s += (10 > d.getMinutes() ? "0" : "") + d.getMinutes() + ":";
				s += (10 > d.getSeconds() ? "0" : "") + d.getSeconds();
				textNode.data = s;
				setTimeout(updateClock, 1000 - d.getTime() % 1000 + 20);
			}
			
			function updateTextSize() {
				var targetWidth = 0.9;  // Proportion of full screen width
				for (var i = 0; 3 > i; i++) {  // Iterate for better better convergence
					var newFontSize = textElem.parentNode.offsetWidth * targetWidth / textElem.offsetWidth * curFontSize;
					textElem.style.fontSize = newFontSize.toFixed(3) + "pt";
					curFontSize = newFontSize;
				}
			}
			
			updateClock();
			updateTextSize();
			window.addEventListener("resize", updateTextSize);
		</script>
	</body>
</html>
