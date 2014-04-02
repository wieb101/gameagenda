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
				<?php //require ("./includes/leftside.php"); ?>
			</td>
			
			<td valign="top">
			
				<table class="standard">
					<tr>
						<td>
							<p><strong>Punten</strong></p>
							<table class="standard">
								<tr> 
									<th class="standard" colspan="2"> <b> Group Stage Points </b> </th>
									
								</tr>
								
								<tr>
									<td width="250px"> Correct winner </td>
									<Td> +101 points </Td>
								</tr>
								
								<tr>
									<Td> Correct score </Td>
									<td> +202 points </td>
								</tr>
								
								<tr>
									<td> Correct group  winner </td>
									<Td> +303 points </Td>
								</tr>
								
								<tr>
									<td> Correct 2nd of group </td>
									<td> +144 points </td>
								</tr>
								
								<tr>
									<th class="standard" colspan="2"> <b> Quarter final Points </b> </th>			
								</tr>
								<tr>
									<td> Correct winner </td>
									<Td> +404 points </Td>
								</tr>
								
								<tr>
									<Td> Correct score </Td>
									<td> +606 points </td>
								</tr>	
								
								<tr>
									<th class="standard" colspan="2">  <b> Half finals  Points </b> </th>			
								</tr>
								<tr>
									<td> Correct winner </td>
									<Td> +606 points </Td>
								</tr>
								
								<tr>
									<Td> Correct score </Td>
									<td> +808 points </td>
								</tr>	
								
								<tr>
									<th class="standard" colspan="2"> <b> Finals  Points </b> </th>			
								</tr>
								<tr>
									<td> Correct winner </td>
									<Td> +808 points </Td>
								</tr>
								
								<tr>
									<Td> Correct score </Td>
									<td> +1234 points </td>
								</tr>	
								
							</table>
						</td>
					</tr>
				</table>
				<table class="standard">
					<tr>
						<td>
			
							<p><strong>Penalties</strong>:</p>
							<p>Het kan in de finales voorkomen dat het na de verlengingen er nog steeds een gelijke stand is. Er worden vervolgens 1 of meerdere penalty reeksen geschoten. De uiteindelijke score zal incl. de penalty reeks zijn.</p>
							<p>Bijvoorbeeld: Er wordt 1-1 gelijk gespeeld na verlengingen. Vervolgens wordt er 5-4 in de penalty reeks gescored, de uiteindelijk juiste uitslag voor deze poule zal dan 6-5 zijn. </p>
							<p>&nbsp;</p>
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
