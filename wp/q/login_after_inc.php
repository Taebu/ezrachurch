<table width='100%' valign='top' cellpadding='0' cellspacing='0' style='margin: 3px 0 0 0' border='0'>
<tr height='26'>
<td width='' valign='top' style='padding : 2px 0 0 0; font-size:12px'><?php echo $member['mb_name']?>님 반갑습니다.
<span style='padding-left:10px'><a href="/wp/bbs/logout.php?url=<?php echo $PHP_SELF?>"><img src='./img/btn_logout.gif' align='absmiddle'></a></span>
<?php if($is_admin == "super") echo "&nbsp; <a href='./admin_index.php'><img src='./img/btn_admin.gif' width='59' height='18' align='absmiddle'></a>";?>
<!--<a href="javascript:void(  window.open('/qpass/index.php', 'qpass', 'width=1000, height=750, scrollbars=1, location=1')  )">Qpass</a>-->
</td>
</tr>
</table>