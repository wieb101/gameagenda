<?php

$domain = "domein";

$dbhost = 'dbdomein';
$dbuser = 'user';
$dbpass = 'pass';
$dbname = 'databasename';

$conn   = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());


function verifyLogin($domain)
{
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);

	// Verify login
	if ($username && $password) 
	{
		$result = mysql_query("SELECT username, password, randhash FROM user WHERE username = '".$username."' AND password = '".$password."'");
		if ($result && $row = mysql_fetch_assoc($result))
		{
			// Retrieve secret user-cookie
			$randhash = $row['randhash'];
			if ($randhash) 
			{
				// Set cookie and redirect client.
				setcookie("hash", $randhash);
				echo "<script>top.location.href = 'http://" . $domain . "/home.php';</script>";
				die();
			}
		}
	}

	// When this code is reached, login POST request failed !
	echo "<script>alert('Login failed, please try again ...'); history.back(); </script>";
	die();
}

// Verifies user-cookie and returns the userid and username as associate row
function verifyUserHash($domain)
{
	$hash   = mysql_real_escape_string($_COOKIE["hash"]);
	$result = mysql_query("SELECT userid, username FROM user WHERE randhash = '".$hash."'");
	if (result && $row = mysql_fetch_assoc($result))
		return $row;
		
	// When this code is reached, login verification failed, so we redirect to the login page.
	echo "<script>alert('fail');top.location.href = 'http://' . $domain . '/index.php';</script>";
	die();
}

?>