
<!doctype html>

<html>
<head>

<title>⌨️ t.js/demo.htm</title>
<meta charset="utf-8"/>
<meta name="author" content="Mntn&reg; c/o Benjamin Lips"/>

<link href="https://fonts.googleapis.com/css?family=VT323" rel="stylesheet"/>

<style type="text/css">
<!--
::selection{background:aquamarine;color:white;}
::-webkit-selection{background:aquamarine;color:white;}
::-moz-selection{background:aquamarine;color:white;}
body{background:black;color:white;}
*{cursor:default;line-height:4vw;font-size:3vw;padding:0;outline:0;margin:0;}
#t{position:absolute;top:20%;left:10%;right:10%;width:70%;margin-left:5px;visibility:hidden;white-space:pre-wrap;}
a{color:mediumslateblue;text-decoration:none;border-bottom:1px solid aquamarine;}
code{background:yellow;}
.g{color:#0f0;}
.p{color:pink;}
/* t.js-related: */
ins,del{text-decoration:none;}
s{display:none;}
kbd{font-family:inherit;}
 
.t-caret{font-size:inherit;color:magenta;}
//@media(max-width:800px){#t{width:400px;margin-left:-200px;}}
-->
</style>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script> <!-- 3.3.1 -->
<script src="https://cdn.jsdelivr.net/gh/mntn-dev/t.js/t.min.js"></script> 
<script type="text/javascript">
var i = 0;

var array_word= [];
function get_westminster()
{
$.ajax({
	url:"/wm/get_westminster.php",
		dataType:"json",
		type:"POST",
		data:[],
		success:function(data){
		array_word = data;

	$('#t').t(
array_word.join(x='<ins>2</ins><del>*</del>')+x,
{speed:80,delay:1,  repeat:true,pause_on_click:true}
);
	}});
}


//<![CDATA[
$(function(){
get_westminster();

	/*
 $('#t').t(array_word,{
  
  delay:2,                   // start delay in seconds [default:0]
  
  speed:250,                  // typing speed (ms) [default:50]
  speed_vary:false,          // 'human like' speed variation [default:false]
  
  beep:true,                 // beep while typing (Web Audio API) [default:false]
  
  mistype:false,                 // mistype rate: 1:N per char [default:false]
  locale:'en',               // keyboard layout (to fit mistype); supported: 'en' (english) or 'de' (german) [default:'en']
  
  caret:'\u2589',            // caret content; can be html too [default:true (\u258e)]
  blink:false,                // blink-interval in ms; if TRUE, speed*3  [default:true]
  blink_perm:false,          // permanent blinking? if FALSE, caret blinks only on delay/pause/finish [default:false]
  repeat:0,                  // repeat typing: if TRUE, infinite or N times [default:0]
  tag:'span',    	            // wrapper tag (.t-container, .t-caret) [default:'span']
  pause_on_click:true,       // pauses/continues typing on click/tap (elm) [default:false]
  pause_on_tab_switch:true,  // pauses typing if window is inactive (Page Visibility API) [default:false]
  
  // init callback (ready-to-type)
  init:function(elm){},        
  // typing callback
  typing:function(elm,chr_or_elm,left,total){},
  // finished callback
  fin:function(elm){

  	set_word(i);
  }          
 
 });
 */
/*
        
Methods
  $(elm).t('add',content);         // adds content; shorthand: $(elm).a(content);
  $(elm).t('queue',content);       // queued type processing; shorthand: $(elm).q(content);
  $(elm).t('pause'[,true/false]);  // pauses typing (toggles if 2nd param omitted); shorthand: $(elm).p([true/false]);
  $(elm).t('beep');                // manual beepin' (initialised/not-typing); shorthand: $(elm).b();
  $(elm).t('speed',ms);            // typing speed change at runtime; shorthand: $(elm).s(ms);
  $(elm).t_off([true]);            // destroys typer's instance; if TRUE, also clears content; shorthand: n/a
Data/properties
  $(elm).data().t;                 // TRUE if initialised
  $(elm).data().is_typing;                 // typing
  $(elm).data().paused;                    // paused
# How to stop caret blinking? (e.g., if finished)
 -> https://github.com/mntn-dev/t.js/issues/5#issuecomment-340739907
# Hint: unset default/unwatend styles via CSS
 ins,del{text-decoration:none;}
 kbd{font-family:inherit;}
 s{display:none;}
 [...]
--------
# "Hypertyping Markup Language" Cheatsheet:
<del>*</del> -> clears everything typed before (still stored in case of repeating [repeat:N])
<del>foo</del> -> deletes 'foo' (by default, t.js delays 0.25s before removing)
<del>foo<ins>2</ins></del> -> custom del-delay: numeric-filled <ins> inside <del>
<del>select me<s>red,white</s></del> -> text selection: <s> inside <del> (comma seperated background/forground color values, or .class name)
(!) Note: except <ins> and <s>, <del> doesn't handle nested html-tags (dropped)
<ins>2.5</ins> -> stops typing for 2.5 seconds (numeric-filled)
<ins>content to <u>insert</u></ins> -> inserts instantly (non-numeric)
<kbd>some <strong>typing text</strong></kbd> -> will apply setting's mistype[=1:N] rate here (will be 10 if unset)
<s>20</s> -> changes typing speed to 20 milliseconds
*/
  
});
//]]>
</script>
</head>
<body>
<div id="t"></div>

<br/>
</body>
</html>
