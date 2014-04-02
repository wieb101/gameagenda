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
					<th colspan="4" class="standard"> Teams <th>
					<?php
						$query = "SELECT name FROM teams";
						$resultu = mysql_query($query);
						if ( $resultu ) {
							$i;
							while ( $row = mysql_fetch_assoc($resultu) ) {
								
								$name = $row['name'];
								if ( ($i % 2) == 0 ) {
									echo "<tr>";
								}
								$flagname = strtolower($name . ".gif");
					
					?>			
					
								<td class="standard"> <img src="<?php echo "images/flags/" . $flagname; ?>" /> </td> <td class="standard" width="150px"> <?php echo $name; ?>   </td>
									
					<?php
								if ( ($i % 2) == 1 ) {
									echo "</tr>";
								}
								$i=$i+1;
							}
						}
					?>
					
			
				</table>
				

			</td>	<!-- end center -->
			
			<td width="20%" valign="top"> 	<!-- begin rightside -->
			
				<?php require ("./includes/rightside.php"); ?>
			
			</td>



		</tr>
	</table>
			


</body>
</html>
