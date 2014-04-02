
<?php 
require ("./includes/dbconnect.php");

$userRow  = verifyUserHash($domain);  // Auto-redirects to login page on failure !
$username = $userRow['username'];
$userid   = $userRow['userid'];

	$maxRandNumber  = 1;
	$query = "SELECT max(userMatchId) as highnum FROM usermatchresults ";
	$resultu = mysql_query($query);
	if ( $resultu ) {
		if ( $row = mysql_fetch_assoc($resultu) ) {
			$maxRandNumber = $row['highnum'];
			
		}
	}
	//echo $maxRandNumber;
						
	$userMatchId = rand(1, $maxRandNumber );
	$matchid = "";
	$useridother = "";
	$query2 = "SELECT * from usermatchresults WHERE userMatchId = " . $userMatchId . "";
	$resultv = mysql_query($query2);
	if ( $resultv ) {
			$row2 = mysql_fetch_assoc($resultv);
			$useridother = $row2['userId'];
			$matchid = $row2['matchId'];
			$resultTeamA = $row2['resultTeamA'];
			$resultTeamB = $row2['resultTeamB'];
	}
	$usernameother = "";
	$query3 = "SELECT * FROM user WHERE userId = " . $useridother . "";
	//echo $query3;
	$resultw = mysql_query($query3);
	if ( $resultw ) {
		
		$row3 = mysql_fetch_assoc($resultw);
		$usernameother = $row3['username'];
	}
	
	$query4 = "SELECT * FROM groupmatch WHERE matchNumber = " . $matchid . "";
	
	$resultx = mysql_query($query4);
	if ( $resultx ) {
	//echo $query4;
		$row4 = mysql_fetch_assoc($resultx);
		$teamA = $row4['teamA'];
		$teamB = $row4['teamB'];
		//echo $teamA;
	}
	
	
	
?>
<html>
<head>
<style>
		td.col {
			border: 1px solid #808080;
			background-color:#FFCC00;
			font-family: Verdana, Arial, Helvetica, sans-serif; 
			color: black;
			text-align: center;
		}

		td.aUser {
			width: 200px;
			text-align: center;
			border: 1px solid #808080;
			
			
			font-weight: bold;
			font-family: Verdana, Arial, Helvetica, sans-serif; 
		}
</style>
</head>
<body>
<?php if ( strlen($teamA) > 3 and strlen($teamB) > 3  and $resultTeamA != null and $resultTeamB != null and $usernameother != "") { ?>
<table width="300">
	<tr> <Td class="col"> <b><?php echo $usernameother; ?></b> <br/>
	 predicts  <br/><br/>
	<b><?php echo $teamA ?> </b>
	 vs 
	<b> <?php echo $teamB ?> </b><br/><br/>
	<b> <?php echo $resultTeamA . "-" . $resultTeamB ?> </b><br/><br/></Td></tr>
	</table>
<?php } ?>
</body>
</html>
