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
	require ("./includes/menu.php");
	?>
	<table class="outer">
		<tr>
			<td width="20%" valign="top">
				<?php require ("./includes/leftside.php"); ?>
			</td>
			
			<td valign="top">
				<br/>
				
				<table class="standard">
					<tr>
						<th class="standard" width="150px"> Username </th>
						<th class="standard"> Payed </th>
					</tr>
					<?php
						$query = "SELECT username, payed FROM user";
						$resultu = mysql_query($query);
						if ( $resultu ) {
						
							while ( $row = mysql_fetch_assoc($resultu) ) {
								$username = $row['username'];
								$payed 	  = $row['payed'];
					?>			
							<tr>
								<td class="standard" width="150px"> <A href="viewotheruser.php?username=<?php echo $username ?>"> <?php echo $username; ?> </A>   </td>
								<td class="centered"> <label> <?php if ( $payed == "10" ) { echo $payed; } else { echo "-"; } ?> </label> </td>
							</tr>					
					<?php
							}
						}
					?>
					
				</table>
				
			</td>
				
			<td width="20%" valign="top"> 	<!-- begin rightside -->
				<?php require ("./includes/rightside.php"); ?>
			</td>
	
		</tr>
	</table>
</body>
</html>