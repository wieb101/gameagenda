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
				
				<div id="groups">
				<table class="standard" width="100%">
					<tr>
						<th class="standard" rowspan="2"> Match<br/>Number </th>
						<th class="standard" colspan="4"> Actual result </th>
						<th class="standard" colspan="2"> Your prediction </th>
						<th class="standard" rowspan="2"> Awarded <br/> Points </th>
					</tr>
					<tr>
						<th class="row2"> Team A </th>
						<th class="row2"> Team B </th>
						<th class="row2"> Goals A</th>
						<th class="row2"> Goals B</th>
						<th class="row2"> Goals A</th>
						<th class="row2"> Goals B</th> 		
						<!-- <th> Match Date </th> -->
						<!-- <th> Match Time </th> -->
						<!-- <th> Location </th>-->
					</tr>
					
					
					<?php
					
						$totalpoints = 0;
					
					
						//
						// GROUP FASE 
						//
						$query = "SELECT matchNumber, teamA, teamB, matchDate, matchTime, location, actualTeamA, actualTeamB, goalsTeamA, goalsTeamB, resultTeamA, resultTeamB FROM groupmatch " . 
								 "RIGHT JOIN usermatchresults ON groupmatch.matchNumber = usermatchresults.matchId  WHERE matchNumber < 25 and userID = " . $userid . " ORDER BY matchNumber";
						
						//echo $query;
						
						$resultu = mysql_query($query);
						if ( $resultu ) {
						
							while ( $row = mysql_fetch_assoc($resultu) ) {
								$matchnumber = $row['matchNumber'];
								$teamA = $row['teamA'];
								$teamB = $row['teamB'];
								$goalsTeamA = $row['goalsTeamA'];
								$goalsTeamB = $row['goalsTeamB'];
								
								$predTeamA = $row['resultTeamA'];
								$predTeamB = $row['resultTeamB'];
								
								//$matchDate = $row['matchDate'];
								//$matchTime = $row['matchTime'];
								//$location = $row['location'];
								
								/*
									group stage
										Correct winner :   		+101 points
										Correct score  :		+202 points
										Correct Group winner : 	+303 points
										Correct 2nd of group : 	+144 points
										
									Round 16
										Correct winner :	+202 points
										Correct score  :	+404 points
									
									Quarter finals
										Correct winner :	+404 points
										Correct score  : 	+606 points
										
									Half finals
										Correct winner : 	+606 points
										Correct score  : 	+808 points
										
									Finals
										Correct winner :	+808 points
										Correct score  :	+1234 points
								
								*/
			
					?>			
							<tr>
								<td class="centered"> <?php echo $matchnumber; ?> </td>
								<td class="aMatchItem"> <?php echo $teamA; ?> </td>
								<td class="aMatchItem"> <?php echo $teamB; ?> </td>
								<td class="centered"> <?php echo $goalsTeamA; ?> </td>
								<td class="centered"> <?php echo $goalsTeamB; ?> </td>
								<td class="centered"> <?php echo $predTeamA; ?> </td>
								
								<td class="centered"> <?php echo $predTeamB; ?> </td>
									<?php
									
									$matchpoints = 0;
									
									// look who's winner and if prediction is the same
									if ( $predTeamA > $predTeamB && $goalsTeamA > $goalsTeamB) {
										// teamA  winner
										$matchpoints = $matchpoints + 101;
									}
									else if ( $predTeamA < $predTeamB && $goalsTeamA < $goalsTeamB ) {
										// teamB winner
										$matchpoints = $matchpoints + 101;
									}
									else if ( $predTeamA == $predTeamB && $goalsTeamA == $goalsTeamB && $goalsTeamA > -1 && $goalsTeamB > -1) {
										// gelijkspel
										$matchpoints = $matchpoints + 101;
									}
									
									// scoring is voorspelt
									if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL) {
										$matchpoints = $matchpoints + 202;
									}
									$totalpoints = $totalpoints + $matchpoints;
									
									
									?>
								<td class="centered"> <?php echo $matchpoints; ?> </td>
								
							<!--	<td class="aMatchItem"> <?php echo $matchDate; ?> </td> -->
							<!--	<td class="aMatchItem"> <?php echo $matchTime; ?> </td> -->
							<!--	<td class="aMatchItem"> <?php echo $location; ?> </td> -->
							</tr>					
					<?php
							}
						}
					?>
					</table>
					</div>
				
					<div class="finals">
					<table class="standard" width="100%">
						<tr>
							<th class="standard" rowspan="2"> Match<br/>Number </th>
							<th class="standard" colspan="4"> Actual result </th>
							<th class="standard" colspan="4"> Your prediction </th>
							<th class="standard" rowspan="2"> Awarded <br/> Points </th>
						</tr>
						<tr>
							<th class="row2"> Team A </th>
							<th class="row2"> Team B </th>
							<th class="row2"> Goals A</th>
							<th class="row2"> Goals B</th>
							<th class="row2"> Team A </th>
							<th class="row2"> Team B </th>
							<th class="row2"> Goals A</th>
							<th class="row2"> Goals B</th> 				
							<!-- <th> Match Date </th> -->
							<!-- <th> Match Time </th> -->
							<!-- <th> Location </th>-->
						</tr>		
					<?php
					
						//
						// FINALS , matchnumber groter dan 48
						//		49 t/m 56  = round of 16
						//		57 t/m 60  = kwartfinale
						// 		61 en 62   = halve finale
						//			63 = derde plaats
						//		64 		   = finale
						
						
						$query = "SELECT matchNumber, teamA, teamB, matchDate, matchTime, location, goalsTeamA, goalsTeamB, actualTeamA, actualTeamB, resultTeamA, resultTeamB, finalCountryA, finalCountryB  FROM groupmatch " . 
						"RIGHT JOIN usermatchresults ON groupmatch.matchNumber = usermatchresults.matchId WHERE matchNumber > 24 and userID = " . $userid . " GROUP BY matchNumber ORDER BY matchNumber";
						
					//	echo $query;
						
						$resulty = mysql_query($query);
						if ( $resulty ) {
						
							while ( $row2 = mysql_fetch_assoc($resulty) ) {
								$matchpoints = 0;
							
								$matchnumber = $row2['matchNumber'];
								
								$teamA = $row2['actualTeamA'];
								//if ( $teamA = '' ) 	$teamA = $row['teamA'];
								
								$teamB = $row2['actualTeamB'];	
								//if ($teamB = '' ) $teamB = $row['teamB'];
								
								
								$goalsTeamA = $row2['goalsTeamA'];
								$goalsTeamB = $row2['goalsTeamB'];
								
								$matchDate = $row2['matchDate'];
								$matchTime = $row2['matchTime'];
								$location = $row2['location'];
								
								$predTeamA = $row2['resultTeamA'];
								$predTeamB = $row2['resultTeamB'];
								
								$finalCountryA = $row2['finalCountryA'];
								$finalCountryB = $row2['finalCountryB'];
			
					?>			
							<tr>
								<td class="centered"> 	<?php echo $matchnumber ?> 		</td>
								
								<td class="aMatchItem"> 	<?php echo $teamA ?> 			</td>
								<td class="aMatchItem"> 	<?php echo $teamB ?> 			</td>
								<td class="centered"> 		<?php echo $goalsTeamA ?> 		</td>
								<td class="centered"> 		<?php echo $goalsTeamB ?> 		</td>
								
								<td class="aMatchItem"> 	<?php echo $finalCountryA ?> 	</td>
								<td class="aMatchItem"> 	<?php echo $finalCountryB ?> 	</td>
								<td class="centered"> 		<?php echo $predTeamA; ?> 		</td>
								<td class="centered"> 		<?php echo $predTeamB; ?> 		</td>
						
								<?php 
									/*if ( $matchnumber > 48 && $matchnumber < 57 ) {				// round 16
										
										// Serbia vs Greece  , is hetzelfde als Greece vs Serbia,   we moetne dus mogelijk de land even omwisselen
										// voordat we de scores en winaar gaan evauleren.
										if ( $teamA == $finalCountryB || $teamB == $finalCountryA ) {
											$temp = $teamB;					// swap team namen
											$teamB = $teamA;
											$teamA = $temp;
											
											$temp2 = $goalsTeamB;			// swap prediction scores
											$goalsTeamB = $goalsTeamA;
											$goalsTeamA = $temp2;
										}									
										
										// look who's winner and if prediction is the same
										if ( $predTeamA > $predTeamB && $goalsTeamA > $goalsTeamB && ($teamA == $finalCountryA ) ) {		// country A moet ook matchen
											// teamA  winner
											$matchpoints = $matchpoints + 202;
		
											// Als de winner goed is  , kunnen we de score gaan matchen.
											if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL ) {
												if ($teamA == $finalCountryA && $teamB == $finalCountryB ) {
													$matchpoints = $matchpoints + 404;
												}
											}	
										}
										else if ( $predTeamA < $predTeamB && $goalsTeamA < $goalsTeamB && ($teamB == $finalCountryB  )  ) {	// country B moet ook matchen
											// teamB winner
											$matchpoints = $matchpoints + 202;
											
											// Als de winner goed is  , kunnen we de score gaan matchen.
											if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL ) {
												if ($teamA == $finalCountryA && $teamB == $finalCountryB ) {
													$matchpoints = $matchpoints + 404;
												}
											}	
										}
										$totalpoints = $totalpoints + $matchpoints;
		
									}*/
									if ( $matchnumber > 24 && $matchnumber < 29 )  {			// kwarfinale			ek 25 t/m 28
										
										// Serbia vs Greece  , is hetzelfde als Greece vs Serbia,   we moetne dus mogelijk de land even omwisselen
										// voordat we de scores en winaar gaan evauleren.
										if ( $teamA == $finalCountryB || $teamB == $finalCountryA ) {
											$temp = $teamB;					// swap team namen
											$teamB = $teamA;
											$teamA = $temp;
											
											$temp2 = $goalsTeamB;			// swap prediction scores
											$goalsTeamB = $goalsTeamA;
											$goalsTeamA = $temp2;
										}									
										
										// look who's winner and if prediction is the same
										if ( $predTeamA > $predTeamB && $goalsTeamA > $goalsTeamB && ($teamA == $finalCountryA ) ) {		// country A moet ook matchen
											// teamA  winner
											$matchpoints = $matchpoints + 404;
		
											// Als de winner goed is  , kunnen we de score gaan matchen.
											if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL ) {
												if ($teamA == $finalCountryA && $teamB == $finalCountryB ) {
													$matchpoints = $matchpoints + 606;
												}
											}	
										}
										else if ( $predTeamA < $predTeamB && $goalsTeamA < $goalsTeamB && ($teamB == $finalCountryB  )  ) {	// country B moet ook matchen
											// teamB winner
											$matchpoints = $matchpoints + 404;
											
											// Als de winner goed is  , kunnen we de score gaan matchen.
											if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL ) {
												if ($teamA == $finalCountryA && $teamB == $finalCountryB ) {
													$matchpoints = $matchpoints + 606;
												}
											}	
										}
										$totalpoints = $totalpoints + $matchpoints;
										
									}
									if ( $matchnumber == 29 or $matchnumber == 30 ) {			// halve finale			29 en 30
										
										// Serbia vs Greece  , is hetzelfde als Greece vs Serbia,   we moetne dus mogelijk de land even omwisselen
										// voordat we de scores en winaar gaan evauleren.
										if ( $teamA == $finalCountryB || $teamB == $finalCountryA ) {
											$temp = $teamB;					// swap team namen
											$teamB = $teamA;
											$teamA = $temp;
											
											$temp2 = $goalsTeamB;			// swap prediction scores
											$goalsTeamB = $goalsTeamA;
											$goalsTeamA = $temp2;
										}									
										
										// look who's winner and if prediction is the same
										if ( $predTeamA > $predTeamB && $goalsTeamA > $goalsTeamB && ($teamA == $finalCountryA ) ) {		// country A moet ook matchen
											// teamA  winner
											$matchpoints = $matchpoints + 606;
										
											// Als de winner goed is  , kunnen we de score gaan matchen.
											if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL ) {
												if ($teamA == $finalCountryA && $teamB == $finalCountryB ) {
													$matchpoints = $matchpoints + 808;
												}
											}	
										}
										else if ( $predTeamA < $predTeamB && $goalsTeamA < $goalsTeamB && ($teamB == $finalCountryB  )  ) {	// country B moet ook matchen
											// teamB winner
											$matchpoints = $matchpoints + 606;
											
											// Als de winner goed is  , kunnen we de score gaan matchen.
											if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL ) {
												if ($teamA == $finalCountryA && $teamB == $finalCountryB ) {
													$matchpoints = $matchpoints + 808;
												}
											}	
										}
										$totalpoints = $totalpoints + $matchpoints;
										
									}
									if ( $matchnumber == 32 ) {									// finale			// 32
																	// Serbia vs Greece  , is hetzelfde als Greece vs Serbia,   we moetne dus mogelijk de land even omwisselen
										// voordat we de scores en winaar gaan evauleren.
										if ( $teamA == $finalCountryB || $teamB == $finalCountryA ) {
											$temp = $teamB;					// swap team namen
											$teamB = $teamA;
											$teamA = $temp;
											
											$temp2 = $goalsTeamB;			// swap prediction scores
											$goalsTeamB = $goalsTeamA;
											$goalsTeamA = $temp2;
										}									
										
										// look who's winner and if prediction is the same
										if ( $predTeamA > $predTeamB && $goalsTeamA > $goalsTeamB && ($teamA == $finalCountryA ) ) {		// country A moet ook matchen
											// teamA  winner
											$matchpoints = $matchpoints + 808;
		
											// Als de winner goed is  , kunnen we de score gaan matchen.
											if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL ) {
												if ($teamA == $finalCountryA && $teamB == $finalCountryB ) { 
													$matchpoints = $matchpoints + 1234;
												}
											}	
										}
										else if ( $predTeamA < $predTeamB && $goalsTeamA < $goalsTeamB && ($teamB == $finalCountryB  )  ) {	// country B moet ook matchen
											// teamB winner
											$matchpoints = $matchpoints + 808;
											
											// Als de winner goed is  , kunnen we de score gaan matchen.
											if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL ) {
												if ($teamA == $finalCountryA && $teamB == $finalCountryB ) {
													$matchpoints = $matchpoints + 1234;
												}
											}	
										}
										$totalpoints = $totalpoints + $matchpoints;
									}
								?>
									<td class="aMatchItem"> <?php echo $matchpoints; ?> </td>
								
							<!--	<td class="aMatchItem"> <?php echo $matchDate; ?> </td> -->
							<!--	<td class="aMatchItem"> <?php echo $matchTime; ?> </td> -->
							<!--	<td class="aMatchItem"> <?php echo $location; ?> </td> -->
							</tr>					
					<?php
							}
						}
					?>
		
					
				</table>	
				</div>
				
				
				<div id="extra">
				<table class="standard" width="100%">
					<tr>
						<th class="standard"> Actual result </th>
						<th class="standard"> Your prediction </th>
						<th class="standard"> Awarded points </th>
					</tr>
					<?php	
					//
						// FINALS , matchnumber groter dan 48
						//		49 t/m 56  = round of 16
						//		57 t/m 60  = kwartfinale
						// 		61 en 62   = halve finale
						//			63 = derde plaats
						//		64 		   = finale
						
						$query = "SELECT matchNumber, teamA, teamB, matchDate, matchTime, location, goalsTeamA, goalsTeamB, actualTeamA, actualTeamB, resultTeamA, resultTeamB, finalCountryA, finalCountryB  FROM groupmatch " . 						"RIGHT JOIN usermatchresults ON groupmatch.matchNumber = usermatchresults.matchId WHERE matchNumber > 24 and matchNumber < 29 and userID = " . $userid . " GROUP BY matchNumber ORDER BY matchNumber";
						
						$resulty = mysql_query($query);
						if ( $resulty ) {
						
							while ( $row2 = mysql_fetch_assoc($resulty) ) {
								$matchpoints = 0;
							
								$matchnumber = $row2['matchNumber'];
								
								$teamA = $row2['actualTeamA'];
								$teamB = $row2['actualTeamB'];	
								
								$finalCountryA = $row2['finalCountryA'];
								$finalCountryB = $row2['finalCountryB'];
		
		
								?>
								<tr>
									<td class="aMatchItem" > <?php echo $teamA; ?> </td>
									<?php
									if ( $finalCountryA == $teamA and $teamA <> "") {
										echo  "<td class='aMatchItem'> " . $finalCountryA . " </td> <td class='aMatchItem'> 303 </td>";	
										$matchpoints = $matchpoints + 303;	
									}
									else {
										echo "<td colspan='2'></td>";
									}
									?>
								</tr>
								
								<tr>
									<td class="aMatchItem" > <?php echo $teamB; ?> </td>									
									<?php
									if ( $finalCountryB == $teamB and $teamB <> "") {
										echo "<td class='aMatchItem'> " . $finalCountryB . "</td> <td class='aMatchItem'> 144 </td>";
										$matchpoints = $matchpoints + 144;
									}
									else {
										echo "<td colspan='2'></td>";
									}
									?>
								</tr>
								<?php
								$totalpoints = $totalpoints + $matchpoints;
							}
						}
					?>
				</table>
				</div>
				
				
				<table class="standard" width="100%">
					<tr>
						<td>
								<h1> Total points: </h1>
						</td>
						<td>
								<h1> <?php echo $totalpoints; ?> </h1>
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