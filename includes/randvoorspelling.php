<?php 

$result = mysql_query("SELECT u.username, ums.resultTeamA, ums.resultTeamB, gp.teamA, gp.teamB FROM usermatchresults AS ums LEFT JOIN user AS u ON u.userId = ums.userId LEFT JOIN groupmatch AS gp ON gp.matchNumber = ums.matchId WHERE ums.resultTeamA IS NOT NULL AND ums.resultTeamB IS NOT NULL ORDER BY (RAND() * (SELECT MAX(userMatchID) FROM usermatchresults)) LIMIT 1");
if ($result && $row = mysql_fetch_assoc($result))
{
	$teamA         = $row["teamA"];
	$teamB         = $row["teamB"];
	$resultTeamA   = $row["resultTeamA"];
	$resultTeamB   = $row["resultTeamB"];
	$otherUserName = $row["username"];

	?>
	
		<table width="100%" cellpadding="2" cellspacing="0" class="standard">
		<tr>
			<th colspan="3" align="center" class="standard"><h2><?php echo $otherUserName ?> predicts:</h2></th>
		</tr>
		<tr>
			<td width="45%" align="right" ><b><?php echo $teamA ?></b></td>
			<td width="10%" align="center"> vs </td>
			<td width="45%" align="left"  ><b><?php echo $teamB ?></b></td>
		</tr>
		<tr>
			<td width="45%" align="right" ><b><?php echo $resultTeamA ?></b></td>
			<td width="10%" align="center"> - </td>
			<td width="45%" align="left"  ><b><?php echo $resultTeamB ?></b></td>
		</tr>
		</table>
	
	<?php
}
else die(mysql_error());
?>