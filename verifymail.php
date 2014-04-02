<?php 
require ("./includes/dbconnect.php");

//$userRow  = verifyUserHash($domain);  // Auto-redirects to login page on failure !
$username = $userRow['username'];
$userid   = $userRow['userid'];

?>

<html>
<head>
	<title>GameAgenda.nl | EK 2012</title>
	
	<script type="text/javascript" src="./gameagenda.js"></script>
</head>
<body background="">

	<?php
//	require ("./includes/menu.php");

	
include 'functies.php';



$key = mysql_real_escape_string($_GET['key']);

if ( $key ) {

	
	$updateQuery = "UPDATE user SET verifiedMail = 1 WHERE verifyMailHash  = '".$key."' ";

	$resultu = mysql_query($updateQuery); 
	
	if ($resultu) {
			// create hash for the cookie
			$randhash = rand_str();
	
			$updateRandHash = "UPDATE user SET randhash = '" . $randhash . "' WHERE verifyMailHash  = '".$key."' ";
			echo $updateRandhash;
			
			$resulth = mysql_query($updateRandHash);
			
			if ( resulth ) {

				echo "<center>";
				echo " <font color='black' size='3'> Je mail adres is geverifieerd. </font>  <br/>";
				echo " <font color='black' size='3'>  <a href=http://" . $domain . "> Klik op de link om terug te keren naar de voorpagina: " . $domain . " Gameagenda  </a> </font> ";
				echo "</center>";

			}
	}

}



?>
					<body>
					
				</html>