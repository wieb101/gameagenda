<?php

include 'dbconnect.php';

$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);

if ($username && $password) {

$result = mysql_query("SELECT username, password, randhash FROM user WHERE username = '" . $username . "' AND password = '" . $password . "' ");

if (!$result) {
	echo "login failed!.";
}
else {
	if ($row = mysql_fetch_assoc($result)) {

		$randhash = $row['randhash'];
		if ( $randhash ) {
			setcookie("hash", $randhash);
			header( "Location: http://localhost/menu.php" );
		}
		
	

	}
	else {
		echo "login failed.!";
	}

}
}


?>


<html>
	<head>

	    <link href="style.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
a:link {
	color: #0000FF;
}
a:visited {
	color: #0000FF;
}
a:hover {
	color: #0000FF;
}
a:active {
	color: #0000FF;
}
body {
	background-color: #000000;
}
-->
</style>

	
</head>

	<body>

		<table width="100%" border="0">

          <tr>
            <td><div align="center"><img src="world-cup-2010-red_small.jpg" width="1080" height="675"></div></td>
          </tr>
		  
          <tr>
            <td align='center'>
				<form method='POST' name="loginForm">
					<table>
						<tr>
							<td> <label class='horz'> Gebruiker: </label> </td> 
							<td>  <input type='text' name='username'> </td>
							<td>  <label class='horz'>Wachtwoord:</label> </td>
							<td> <input type='password' name='password'> </td>
							<td><input type='submit' name='login' value='ok'> </td>
						</tr>
					</table>
            	</form>			</td>
          </tr>
		  
		  <tr>
		  	<td align="center"> <label class="horz"> Nog geen gebruiker? Klik op de link om aan te melden: </label> <label class="horz"> <a href="signup.php"> Aanmelden </a> </label> </td>
		  </tr>
        </table>

</body>


</html>