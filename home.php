<?php 
require ("./includes/dbconnect.php");

$userRow  = verifyUserHash($domain);  // Auto-redirects to login page on failure !
$username = $userRow['username'];
$userid   = $userRow['userid'];

?>

<html>
<head>
	<title>GameAgenda.nl | EK 2012</title>
	<link rel="stylesheet" type="text/css" href="./gameagenda.css" media="screen, handheld, print, projection" /> 
	<script type="text/javascript" src="./gameagenda.js"></script>
</head>
<body>

	<?php
	
	?>
	<?php
	require ("./includes/menu.php");
	?>
	<table class="outer">
		<tr>
			<td width="20%" valign="top">
				<?php require ("./includes/leftside.php"); ?>
			</td>
			
			<td valign="top">
				<?php require ("news.php"); ?>

			</td>	<!-- end center -->
			
			<td width="20%" valign="top"> 	<!-- begin rightside -->
			
				<?php require ("./includes/rightside.php"); ?>
			
			</td>



		</tr>
	</table>	
	
	
</body>
</html>
