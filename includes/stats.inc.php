<?php

	function getUserScore ($userid) {
		$totalpoints = 0;
			//
						// FINALS , matchnumber groter dan 48
						//		49 t/m 56  = round of 16				vervallen
						//		57 t/m 60  = kwartfinale				
						// 		61 en 62   = halve finale
						//			63 = derde plaats
						//		64 		   = finale
						
		// GROUP FASE 
		$query = "SELECT matchNumber, teamA, teamB, matchDate, matchTime, location, actualTeamA, actualTeamB, goalsTeamA, goalsTeamB, resultTeamA, resultTeamB FROM groupmatch " . 
				 "RIGHT JOIN usermatchresults ON groupmatch.matchNumber = usermatchresults.matchId  WHERE matchNumber < 25 and userID = " . $userid . " ORDER BY matchNumber";
				
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
				
				$matchpoints = 0;		
						
				if ( $predTeamA > $predTeamB && $goalsTeamA > $goalsTeamB) {	// look who's winner and if prediction is the same
					$matchpoints = $matchpoints + 101;							// teamA  winner
				}
				else if ( $predTeamA < $predTeamB && $goalsTeamA < $goalsTeamB ) {
					$matchpoints = $matchpoints + 101;							// teamB winner
				}
				else if ( $predTeamA == $predTeamB && $goalsTeamA == $goalsTeamB && $goalsTeamA > -1 && $goalsTeamB > -1) {
					$matchpoints = $matchpoints + 101;							// gelijkspel
				}
				
				
				if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL) {		// scoring is voorspelt
					$matchpoints = $matchpoints + 202;
				}
				$totalpoints = $totalpoints + $matchpoints;
	
			}
		}
		// GROUP WINNER POINTS , and 2nd of group points
						
			
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
			
					if ( $finalCountryA == $teamA and $teamA <> "" ) {
						$matchpoints = $matchpoints + 303;	
					}
					
					if ( $finalCountryB == $teamB and $teamB <> "") {
						$matchpoints = $matchpoints + 144;
					}
					$totalpoints = $totalpoints + $matchpoints;
				}
			}
					
		
		// FINALE
		$query = "SELECT matchNumber, teamA, teamB, matchDate, matchTime, location, goalsTeamA, goalsTeamB, actualTeamA, actualTeamB, resultTeamA, resultTeamB, finalCountryA, finalCountryB  FROM groupmatch " . 
			     "RIGHT JOIN usermatchresults ON groupmatch.matchNumber = usermatchresults.matchId WHERE matchNumber > 24 and userID = " . $userid . " GROUP BY matchNumber ORDER BY matchNumber";
				
		$resulty = mysql_query($query);
		if ( $resulty ) {
				
			while ( $row2 = mysql_fetch_assoc($resulty) ) {
				$matchpoints = 0;
				$matchnumber = $row2['matchNumber'];
				
				$teamA = $row2['actualTeamA'];
				$teamB = $row2['actualTeamB'];	
						
				$goalsTeamA = $row2['goalsTeamA'];
				$goalsTeamB = $row2['goalsTeamB'];
						
				$matchDate = $row2['matchDate'];
				$matchTime = $row2['matchTime'];
				$location = $row2['location'];
						
				$predTeamA = $row2['resultTeamA'];
				$predTeamB = $row2['resultTeamB'];
						
				$finalCountryA = $row2['finalCountryA'];
				$finalCountryB = $row2['finalCountryB'];
				
				
			/*	if ( $matchnumber > 48 && $matchnumber < 57 ) {				// round 16
								
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

				}	// end round 16
				
				*/
				if ( $matchnumber > 24 && $matchnumber < 29 )  {			// kwarfinale
					
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
					
				} // end kwart finale
							
							
							
				if ( $matchnumber == 29 or $matchnumber == 30 ) {			// halve finale
					
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
					
				} // end halve finale
							
		
				if ( $matchnumber == 32 ) {									// finale
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
						$matchpoints = $matchpoints + 808;
						
						// Als de winner goed is  , kunnen we de score gaan matchen.
						if ( $predTeamA == $goalsTeamA && $predTeamB == $goalsTeamB && $predTeamB <> NULL && $predTeamA <> NULL ) {
							if ($teamA == $finalCountryA && $teamB == $finalCountryB ) { 
								$matchpoints = $matchpoints + 1234;
							}
						}	
					}
					$totalpoints = $totalpoints + $matchpoints;
				} // finale
}
}
	
			return $totalpoints;
	} // end function
?>