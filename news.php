<?php 

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
	
	$title = $_POST['title'];
	$videolink = $_POST['videolink'];
	$kindofvid = "";
	if ( $videolink != "" ) {
	
		//youtube link parsing
		$posyoutube = strpos($videolink, "youtube.com");		//?v=9rXwBmGyMRo
		if ( $posyoutube > -1 ) {
			$idStart = strpos($videolink, "v=");
			if ( $idStart > -1 ) {
				$idEnd = strpos($videolink, "&", $idStart);
				if ( $idEnd === false ) $idEnd = strlen($videolink);
				$vidid = substr($videolink, $idStart+2, ($idEnd- ($idStart+2)) );
				$kindofvid = "youtube";
			}
		
		}
	
		// myspace link parsing
		$posmyspace = strpos($videolink, "myspace");
		if ( $posmyspace != "" ) {
			$idStart = strpos($videolink, "videoid=");
			if ( $idStart > -1 ) {
				$idEnd = strpos($videolink, "#", $idStart);
				if ( $idEnd === false ) $idEnd = strlen($videolink);
				$vidid = substr($videolink, $idStart+8, ($idEnd- ($idStart+8)) );
				$kindofvid = "myspace";
			}
		}
	
	}

	if ( $vidid != "" ) {
		if ( $kindofvid == "myspace" ) {
			$query = "INSERT INTO news ( title, myspace_link, posted_by ) VALUES ('" . $title . "', '" . $vidid . "', '" . $username . "' )";
			mysql_query($query) or die('Error, insert query failed');
		}
		else if ( $kindofvid = "youtube" ) {
			$query = "INSERT INTO news ( title, youtube_link, posted_by ) VALUES ('" . $title . "', '" . $vidid . "', '" . $username . "' )";
			mysql_query($query) or die('Error, insert query failed');
		}
			
	}
?>
<table>
	<tr>
		<td colspan="6">
			<form method="post"> 
				<table class="standard">
					<tr> 
						<td> Title: </td>
						<td> <input type="textfield" size="50" name="title" /> </td>
					</tr>
					<tr>
						<td> video link: </td>
						<td> <input type="textfield" size="50" name="videolink" /> </td>
						<td> (youtube or myspace) </td>						
					</tr>
					<tr>
						<td colspan="2" align="right"> <input type="submit" name="submit" value="submit" />
					</td>
				</table>
			</form>
		</td>
	</tr>
	
<?php
	$query = "SELECT * FROM news ORDER BY news_id DESC LIMIT 2";
	$result = mysql_query($query);
	
	if ( $result ) {
		while ( $row = mysql_fetch_assoc($result) ) {
			
			$news_id = $row['news_id'];
			$title 	  = $row['title'];
			$news_item = $row['news_item'];
			$youtube_link = $row['youtube_link'];		// GV_pB2U509Q
			$myspace_link = $row['myspace_link'];		// 105413635
		?>
			<?php if ( $i % 2 ) echo '<tr>'; ?>
				<td>
					<table class="standard">
						<tr>
							<th class="standard"> <h3> <?php echo $title ?> </h3> </th>
						</tr>
						<tr>			
							<td>
								<?php if ( $youtube_link != '' ) { ?>
									<object width="480" height="385">
										<param name="movie" value="http://www.youtube.com/v/<?php echo $youtube_link; ?>&hl=en_US&fs=1&rel=0"></param>
										<param name="allowFullScreen" value="true"></param>
										<param name="allowscriptaccess" value="always"></param>
										<embed src="http://www.youtube.com/v/<?php echo $youtube_link; ?>&hl=en_US&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed>
									</object>
								<?php } ?>
			
			
								<?php if ( $myspace_link != '' ) { ?>			
									<object width="480px" height="385px" >
										<param name="allowFullScreen" value="true"/>
										<param name="wmode" value="transparent"/>
										<param name="movie" value="http://mediaservices.myspace.com/services/media/embed.aspx/m=<?php echo $myspace_link; ?>,t=1,mt=video"/>
										<embed src="http://mediaservices.myspace.com/services/media/embed.aspx/m=<?php echo $myspace_link; ?>,t=1,mt=video" width="480" height="385" allowFullScreen="true" type="application/x-shockwave-flash" wmode="transparent"></embed>
									</object>
								<?php } ?>
											
							</td>
					</tr>
					<tr>
						<td class="standard">
							<?php 
								if ( $news_item == '' ) {
									echo "<Br/>";
								}
								else {
									echo $news_item;
								}
							?>
						</td>
					</tr>	
			
				</table>
			<td>
		<?php if ( $i % 2 ) echo '</tr>'; ?>
	<?php
		}
	}

?>

</table>

<table>
	<tr>	
<?php

	$query = "SELECT * FROM news ORDER BY news_id DESC LIMIT 2, 4";
	$result = mysql_query($query);
	
	if ( $result ) {
		while ( $row = mysql_fetch_assoc($result) ) {
			
			$news_id = $row['news_id'];
			$title 	  = $row['title'];
			$news_item = $row['news_item'];
			$youtube_link = $row['youtube_link'];		// GV_pB2U509Q
			$myspace_link = $row['myspace_link'];		// 105413635
		?>
			
				<td>
					<table class="standard">
						<tr>
							<th class="standard"> <h3> <?php echo $title ?> </h3> </th>
						</tr>
						<tr>			
							<td>
								<?php if ( $youtube_link != '' ) { ?>
									<object width="240" height="192">
										<param name="movie" value="http://www.youtube.com/v/<?php echo $youtube_link; ?>&hl=en_US&fs=1&rel=0"></param>
										<param name="allowFullScreen" value="true"></param>
										<param name="allowscriptaccess" value="always"></param>
										<embed src="http://www.youtube.com/v/<?php echo $youtube_link; ?>&hl=en_US&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="240" height="192"></embed>
									</object>
								<?php } ?>
			
			
								<?php if ( $myspace_link != '' ) { ?>			
									<object width="240" height="192" >
										<param name="allowFullScreen" value="true"/>
										<param name="wmode" value="transparent"/>
										<param name="movie" value="http://mediaservices.myspace.com/services/media/embed.aspx/m=<?php echo $myspace_link; ?>,t=1,mt=video"/>
										<embed src="http://mediaservices.myspace.com/services/media/embed.aspx/m=<?php echo $myspace_link; ?>,t=1,mt=video" width="240" height="192" allowFullScreen="true" type="application/x-shockwave-flash" wmode="transparent"></embed>
									</object>
								<?php } ?>
											
							</td>
					</tr>
					
			
				</table>
			<td>
		
	<?php
		}
	}
?>
	</tr>
</table>


</body>


</html>