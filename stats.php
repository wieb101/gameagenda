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
		require ("./includes/stats.inc.php");
		require ("./includes/menu.php");
	?>
	
	<table class="outer">
		<tr>
			<td width="20%" valign="top">
				<?php require ("./includes/leftside.php"); ?>
			</td>
			
			<td valign="top">
	
				<table>
					<tr>
						<th class="standard"> <h2> All Users Score list </h2> </th>
						<th class="standard"> <h2> Payed Users Score list </h2> </th>
					</tr>
					
					<tr>
						<td valign="top" >
							
							<table class="standard">
								<tr>
									<th class="standard" width="40px"> Rank </th>
									<th class="standard" width="175px"> Username </th>
									<th class="standard" width="100px"> Points </th>
								</tr>
								<?php
									$allUsers = array();
									$query = "SELECT username, payed, userid FROM user";
									$resultu = mysql_query($query);
									if ( $resultu ) {
										while ( $row = mysql_fetch_assoc($resultu) ) {
											$points = 0;
											$username2 = $row['username'];
											$payed 	  = $row['payed'];
											$curuserid = $row['userid'];
											$points = getUserScore($curuserid);
											$allUsers[$username2] = $points;
										}
									}
									
									asort($allUsers);
									$allUsers = array_reverse($allUsers, true);
									$i = 0;
									$lastvalue = 0;
									foreach ( $allUsers as $key => $value) {
										if ( $lastvalue != $value ) {
											$i++;
											$lastvalue = $value;
										}		
										if ( $username == $key ) {
											echo "<tr> <td class='centered' style='font-weight: bold;'> " . $i . "</td> <td style='font-weight: bold;'> " . $key . "</td> <td class='centered' style='font-weight: bold;'>  " . $value . "</td> </tr>";									}
										else {
											echo "<tr> <td class='centered'> " . $i . "</td> <td> " . $key . "</td> <td class='centered'>  " . $value . "</td> </tr>";
										}
									}
								?>
								
							</table>
						
						</td>
						
			
						<td valign="top">
							
							<table class="standard">
								<tr>
									<th class="standard" widht="40px"> Rank </th>
									<th class="standard" width="175px"> Username </th>					
									<th class="standard" width="100px"> Points </th>
								</tr>
								<?php
									$payedUsers = array();
									$query = "SELECT username, payed, userid FROM user WHERE payed = '10'";
									$resultu = mysql_query($query);
									if ( $resultu ) {
									
										while ( $row = mysql_fetch_assoc($resultu) ) {
											$points = 0;
											$username2 = $row['username'];
											$payed 	  = $row['payed'];
											$curuserid = $row['userid'];
											$points = getUserScore($curuserid);
											$payedUsers[$username2] = $points;
										}
									}
									asort($payedUsers);
									$payedUsers = array_reverse($payedUsers, true);
									$i = 0;
									$lastvalue = 0;
									foreach ( $payedUsers as $key => $value) {
										if ( $lastvalue != $value ) {
											$i++;
											$lastvalue = $value;
										}											
										if ( $username == $key ) {
											echo "<tr> <td class='centered' style='font-weight: bold;'> " . $i . "</td> <td style='font-weight: bold;'> " . $key . "</td> <td class='centered' style='font-weight: bold;'>  " . $value . "</td> </tr>";									}
										else {
											echo "<tr> <td class='centered'> " . $i . "</td> <td> " . $key . "</td> <td class='centered'>  " . $value . "</td> </tr>";
										}
									}
			
								?>
								
							</table>
			
						</td>
					</tr>
				</table>
		

			</td>	<!-- end center -->
			
			<td width="20%" valign="top"> 	<!-- begin rightside -->
			
				<?php require ("./includes/rightside.php"); ?>
			
			</td>



		</tr>
	</table>
		
		


</body>

</html>