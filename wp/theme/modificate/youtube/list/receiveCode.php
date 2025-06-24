
<!DOCTYPE html>
<html>
<head>
    <script src="https://www.gstatic.com/external_hosted/jquery2.min.js"></script>
    <style>
      input{
        width:100%;
      }
    </style>
	<script>
	function get_token()
	{
		$.ajax({
		url:"get_curl.php",
		data:$("#oauth_form").serialize(),
		dataType:"json",
		type:"POST",
		success:function(data){
			console.log(data.access_token);
			$("#access_token").val(data.access_token);
			$("#id_token").val(data.id_token);
			console.log(data.scope);
			console.log(data.expires_in);
			console.log(data.token_type);
			console.log(data.id_token);
			}
		});
	}

		function get_list()
		{
				$.ajax({
		url:"get_list.php",
		data:$("#get_form").serialize(),
		dataType:"json",
		type:"POST",
		success:function(data){
			console.log(data);
			}
		});
		}

		function get_lists()
		{
			$("#get_form").submit();
		}
	</script>
</head>
  <body>

      <a href="login.html">login</a>
      <form method="post" id="oauth_form">
        code : <input type="text" name="code" value="<?php echo $_GET['code']?>"><br>
        client_id : <input type="text" name="client_id" value="753250705258-nhf4q46qm8p4j3k5bnalg91ogm0lume6.apps.googleusercontent.com"><br>
        client_secret : <input type="text" name="client_secret" value="29-g6-J5ME3Vmj4OF0IDhs9q"><br>
        redirect_uri : <input type="text" name="redirect_uri" value="https://ezrachurch.kr/wp/theme/modificate/youtube/list/receiveCode.php"><br>
        grant_type : <input type="text" name="grant_type" value="authorization_code"><br>
        <input type="button" value="get_token" onclick="javascript:get_token();">
      </form>
      <form method="get" id="get_form" action="https://content.googleapis.com/youtube/v3/playlistItems">
        part : <input type="text" name="part" value="id,snippet,contentDetails,status"><br>
        playlistId : <input type="text" name="playlistId" value="PLJTXCswf-ZIGU9-4pkIUl8SNEMXDetly7"><br>
        key : <input type="text" name="key" value="AIzaSyAa8yy0GdcGPHdtD083HiGGx_S0vMPScDM"><br>
access_token : <input type="text" id="access_token" name="access_token" value=""><br>
id_token : <input type="text" id="id_token" name="id_token" value=""><br>

        <input type="button" value="get_token" onclick="javascript:get_list();">
      </form>

	  <input type="button" value="get_lists" onclick="javascript:get_lists();">
	  <a href=" https://content.googleapis.com/youtube/v3/playlistItems?part=id%2Csnippet%2C%20contentDetails%2C%20status&playlistId=PLJTXCswf-ZIGU9-4pkIUl8SNEMXDetly7&key=AIzaSyAa8yy0GdcGPHdtD083HiGGx_S0vMPScDM&access_token=ya29.a0AfH6SMBy5oLsrcDdGZb5lkX5bDY_ayCfpJ3w_ftRXR7Il8-ZEbpUMEHI1in2Y3yC0j8AXlFIFrraMvhCxFOdnKC5j1KtYKXdeVVy-Jwq0PBIV_FJjMax1UyLeLtyO9qUuxuCis-rBMrL2QWuGTJ6VZ5X7yDKZktBMSc&key=AIzaSyD59Pyv9qro1GqD7vtwkvusDqzARcqxfig">get</a>
	  <br>
	  <a href="https://content.googleapis.com/youtube/v3/playlistItems?part=id%2Csnippet%2C%20contentDetails%2C%20status&playlistId=PLJTXCswf-ZIGU9-4pkIUl8SNEMXDetly7&key=AIzaSyAa8yy0GdcGPHdtD083HiGGx_S0vMPScDM">Request URL: </a>
  </body>
</html>
<?php
 /*
 https://ezrachurch.kr/wp/theme/modificate/youtube/list/receiveCode.php?state=state_parameter_passthrough_value&code=4/2wGQfzZoR_l7lKvEnlClcA7GjVadLmcC9L6Tgkp-35cvo9z4y9sdZAzQnHSpzVWJ0BBOcPTYCxvVK-a-cql03p4&scope=https://www.googleapis.com/auth/youtube%20https://www.googleapis.com/auth/youtube.force-ssl%20https://www.googleapis.com/auth/youtube.readonly%20https://www.googleapis.com/auth/youtubepartner

 return result
 {
  "access_token": "ya29.a0AfH6SMCjs9BXUQ3Ab9dDPEV1xgAjBKtDGOrwiBDdi7Nom-7bsE30N0FAhXPyuNANbLgUMNQGMsjbxfIJZaRK2_rOMH7pSXnyGAKa-bdeHBrsiM6THzyx89ORlBT3nudLiRk_iUuwdkM6H6dCb3agxlRVoBDV0QIbbWg",
  "expires_in": 3599,
  "refresh_token": "1//0etpUNQ8hD_heCgYIARAAGA4SNwF-L9IrUKDdHf1d8v7kSPwxBddyz9zaKMcM-i079f6TPgLUuMB-sZcpOye1M5T_LpzZK_tB-JQ",
  "scope": "https://www.googleapis.com/auth/youtube.readonly https://www.googleapis.com/auth/youtubepartner https://www.googleapis.com/auth/youtube https://www.googleapis.com/auth/youtube.force-ssl",
  "token_type": "Bearer"
}
{
  "access_token": "ya29.a0AfH6SMCPNCyi1thVtXGjx9LsGOO5qNneqED366MXOCkx5iogSz8w3Q3t2WCatBSECtiZoWio__jGnc-X3ukMrpcvqIP0_j2w0TnRNrTVFojy2Qe934keBHLFoLK2txq9K6KM3PxpUqOhh7dl3RVo6sbpCYUU",
  "expires_in": 3599,
  "refresh_token": "1//0egIJi0TXZmrhCgYIARAAGA4SNwF-L9IrokJheBIE8MYuL6A2moamOojn6gi3NmDezrUW_CyMcvyi2LLTmzgGwzWaDNWJ2QT83zU",
  "scope": "https://www.googleapis.com/auth/youtube https://www.googleapis.com/auth/youtube.readonly https://www.googleapis.com/auth/youtube.force-ssl https://www.googleapis.com/auth/youtubepartner openid",
  "token_type": "Bearer",
  "id_token": "eyJhbGciOiJSUzI1NiIsImtpZCI6IjY5ZWQ1N2Y0MjQ0OTEyODJhMTgwMjBmZDU4NTk1NGI3MGJiNDVhZTAiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJhenAiOiI3NTMyNTA3MDUyNTgtbmhmNHE0NnFtOHA0ajNrNWJuYWxnOTFvZ20wbHVtZTYuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiI3NTMyNTA3MDUyNTgtbmhmNHE0NnFtOHA0ajNrNWJuYWxnOTFvZ20wbHVtZTYuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMDAxNjE4MjYyODYwNDg4ODY0NTAiLCJhdF9oYXNoIjoiWXZyWDR3QkRrZVJFa0hVSWlGR0N0QSIsImlhdCI6MTYyMDIzNzg5NiwiZXhwIjoxNjIwMjQxNDk2fQ.cIAs_uXYVuKgbiN3kuCvLTXNI9nCkbEF27M06gBQ_iAg0bJC0_iJjHZGV-iQPaH3YZAHFLw3AwbLivxOl1ISuFll3LhyxO9HDDfZ4QJM2LsY-D4JBS0Qwpaab0HoMPtcYw8nQl1eH2zz9DPzKPBjAjejDk3X3dsB6eY6w_Blz3YHSSGnYjDnZK7hWm6YGKivomBKP75r_gDPNV_YJXwzQxIgENGMThSFyFexgCLFiFdFkUphgQVR33ZznasDPtGHpw8u6eKHWLJksoM4VQwOiBoz20M7f71voW2-xjOb5eWHLc700smoSeq_2BGgt7cyEEr2cMy8lLmlC1yjqlevvA"
}
 */

?>

