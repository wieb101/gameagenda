<?php

// Handle login POST when necessary
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	require ("./includes/dbconnect.php");
	verifyLogin($domain);
}

// For GET request just display the HTML
?>

<html>
<head>
	<title>GameAgenda.nl | EK 2012</title>
	<link rel="stylesheet" type="text/css" href="./gameagenda.css" media="screen, handheld, print, projection" /> 
	<script type="text/javascript" src="./gameagenda.js"></script>
</head>
<body>

	<div id="loginContainer" align="center">
		<div id="countdown"></div>
		<h1>EK 2012 - Poland / Ukraine</h1>

		<form id="loginForm" action="./index.php" method="POST">
			<table cellpadding="2" cellspacing="0">
				<tr>
					<td>Gebruiker:</td> 
					<td><input name="username" type="text"></td>
				</tr>
				<tr>
					<td>Wachtwoord:</td>
					<td><input name="password" type="password"></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input name="login" value=" Login " type="submit"></td>
				</tr>
			</table>
		</form>

		<br/><br/>
		Nog geen gebruiker? Klik op de link om aan te melden: <a href="signup.php">Aanmelden</a>
	</div>
	
	<script>
		countdown(new Date("Jun 11 2010 16:00:00"));
		document.forms[0].username.focus();
	</script>
	
	</body>
</html>
