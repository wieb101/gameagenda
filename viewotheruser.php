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
	$username = $_GET["username"]; //"test";

	$query = "SELECT userid FROM user WHERE username = '" . $username . "'";
	//echo $query  . "<br/>";
	$resulte = mysql_query($query);
	
	if ( $resulte ) {	
		if ($row = mysql_fetch_assoc($resulte)) {
			$userid = $row['userid'];
	
		///	echo $userid .  "<br/>";
	
		}
		
	}
		
	function showGroup($group, $userid, $titleText) {  

			echo "<table class='standard'> <tr> <th colspan='10' class='standard'>  ". $titleText . "</th> </tr>";
	
			$result = mysql_query("SELECT teamA, teamB, matchNumber FROM groupmatch WHERE stage1group = '".$group."' ORDER BY matchNumber; ");
			
			if (!$result) {
					die('Invalid query: ' . mysql_error());
			}
			else {
				
		
			
				while ($row = mysql_fetch_assoc($result)) {
					$teamA = $row['teamA'];
					$teamB = $row['teamB'];
					
					$id = $row['matchNumber'];
				
					$selectMatchQuery = "SELECT resultTeamA, resultTeamB FROM usermatchresults WHERE matchId = '" . $id . "' AND userId = '" . $userid . "'";
					$result2 = mysql_query($selectMatchQuery);
					
					
					if ( $result2 ) {
							$row2 = mysql_fetch_assoc($result2);
						
							$teamAresult = $row2['resultTeamA'];
							$teamBresult = $row2['resultTeamB'];
							?>
							<tr>
								<td class="standard" width="100px">  <?php echo $teamA ?> </td>
								<td class="standard" width="100px">  <?php echo $teamB ?> </td>
								<td class="standard">  <?php echo $teamAresult ?> - </td>
								<td class="standard">  <?php echo $teamBresult ?> </td>
							</tr>
							
						<?php	
					}
				}
			}
			
			echo "</table>";
	}



	function showMatch($userid, $matchNumber) {
	
		$query = "SELECT resultTeamA, resultTeamB, finalCountryA, finalCountryB FROM usermatchresults WHERE userid = '" . $userid . "' && matchId = '" . $matchNumber . "'";
		$resultmatch = mysql_query($query);
		
		if ( $resultmatch )  {
		
			if ($row = mysql_fetch_assoc($resultmatch)) {
				$resultTeamA = $row['resultTeamA'];
				$resultTeamB = $row['resultTeamB'];
				$finalCountryA = $row['finalCountryA'];
				$finalCountryB = $row['finalCountryB'];
				
				echo '<table class="standard" width="150px">';
				echo '<tr>	<td class="centered"> <img src="images/flags/' . strtolower($finalCountryA) . '.gif"></img> ' . $finalCountryA . '</td><td>  </td>		</tr>';
				echo '<tr>	<td class="centered"> '  .$resultTeamA . '  -  ' .$resultTeamB .' </td>		</tr>';
				echo '<tr>	<td class="centered"> <img src="images/flags/' . strtolower($finalCountryB) . '.gif"></img> ' . $finalCountryB . ' </td><td> </td>		</tr>';
				echo '</table>';

			}
		}
	

	}	

?>
	<table class="outer">
		<tr>
			<td width="20%" valign="top">
				<?php require ("./includes/leftside.php"); ?>
			</td>
			
			
			<td valign="top" align="center" >
				
				<table class="standard" width="100%">
					<tr>
						<th align="center">
							<h2> EK 2012 - prediction of <br/> <?php echo $username ?></h2>
						</th>
					</tr>
				</table>
							
				<br/>
			
			
				<table class="standard">
				
					<tr>
						<td><?php showGroup("A", $userid, "Group A") ?></td>
						<td><?php showGroup("B", $userid, "Group B") ?></td>
						<td><?php showGroup("C", $userid, "Group C") ?></td>
						<td><?php showGroup("D", $userid, "Group D") ?></td>
					</tr>				
					<br/>x
					<tr>
						<td><?php //showGroup("E", $userid, "Group E") // WK ?></td>
						<td><?php //showGroup("F", $userid, "Group F") ?></td>
						<td><?php //showGroup("G", $userid, "Group G") ?></td>
						<td><?php //showGroup("H", $userid, "Group H") ?></td>
					</tr>
				
				</table>
				<br/>
				<table class="standard">

					
					
					
					<tr>
						<!-- <th class="standard"> Round of 16 </th> -->
						<th class="standard"> Quarter-finals</th>
						<th class="standard"> Semi-finals </th>
						<th class="standard"> Finals </th>
						<th class="standard"> Semi-finals </th>
						<th class="standard"> Quarter-finals</th>
						<!-- <th class="standard"> Round of 16 </th> -->
					</tr>
				
				
				
					<tr>
					
		
					
						<!--<td class="match"> -->
								
							<!-- Round 16 left side -->
							
							<!-- match 49 -->
							<?php //showMatch($userid, 49); ?>
							
							<!-- <table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							-->
							<!-- match 50 -->
							<?php //showMatch($userid, 50); ?>
					
			
							<!--<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							-->
							<!-- match 53 -->
							<?php //showMatch($userid, 53); ?>
							
							<!--<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							-->
							<!-- match 54 -->
							<?php //showMatch($userid, 54); ?>
										
						<!-- </td> -->
				
						<td>
							<!-- Quarter finals left side -->
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							
							<!-- match 58 -->
							<?php showMatch($userid, 25); ?>
							
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							
							
			
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							
							<!-- match 57 -->
							<?php showMatch($userid, 27); ?>
							
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>			
						</td>
						
						
						
						<!-- semi final -->
						<td>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>			
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							
							<!-- match 61 -->
							<?php showMatch($userid, 29); ?>
							
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
						</td>
						
						<!-- Final -->
						<td>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
						
				
							<!-- match 64 -->
							<?php showMatch($userid,  32); ?>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>			
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>		
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>			
						</td>
						<!-- semi final right side -->
						<td>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>			
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							
							<!-- match 62 -->
							<?php showMatch($userid, 30); ?>
									
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>			
						</td>
						
						
						<td>
							<!-- Quarter finals right side -->
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							
							<!-- match 59 -->
							<?php showMatch($userid, 26); ?>
									
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>
							
							<!-- match 60 -->
							<?php showMatch($userid, 28); ?>
									
							<table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table>			
						</td>
						
					<!-- <td class="match">		-->
							
							<!-- Round 16 left side -->
							
							<!-- match 52 -->
							<?php //showMatch($userid, 52); ?>
							<!-- <table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table> -->
							
								<!-- match 51 -->
							<?php //showMatch($userid, 51); ?>
							<!-- <table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table> -->
			
							<!-- match 55 -->
							<?php //showMatch($userid, 55); ?>
							
							<!-- <table>
								<tr> <td class="matchcountry">&nbsp;  	</td> 	</tr>
								<tr> <td class="matchinfo">&nbsp;  		</td> 	</tr>
								<tr> <td class="matchcountry">&nbsp;  	</td>	</tr>
							</table> -->
							
							<!-- match 56 -->
							<?php //showMatch($userid, 56); ?>		
						<!-- </td>				-->
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
