<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<title>Signup</title>
			<link href="style.css" rel="stylesheet" type="text/css">
		</head>

		<body>
<?php

require ("./includes/dbconnect.php");
include 'functies.php';


$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);
$hpassword = mysql_real_escape_string($_POST['hpassword']);
$email = mysql_real_escape_string($_POST['email']);

if ( $username != "" && $password != "" && $hpassword != "" && $email != "" ) {

	if ( $password == $hpassword ) {
	
		if ( (isEmailKnown ( $email )) == true ) {
			$error = "Er is al een account die gebruikt maakt van dit mail adres.";
		}
		elseif ( (userAvail ( $username )) == false ) {
			$error = "Gebruikersnaam is niet meer beschikbaar.";
		}
	
	
		if ( !$error ) {
			$rstr = rand_str();
			$query = "INSERT INTO user ( username, password, email, verifyMailHash ) VALUES ('" . $username . "', '" . $password . "', '" . $email . "', '" . $rstr . "' )";
			mysql_query($query) or die('Error, insert query failed');
			
			$message = "Klik op de volgende link om je email te verifieren: http://ek2012.gameagenda.nl/verifymail.php?key=" . $rstr;
			mail($email, 'EK 2012 Poule - email verification.', $message, 'From: noreply@gameagenda.nl' . "\r\n");
		}
	
	}
	else {
		$error = "Wachtwoorden komen niet met elkaar overeen.";
	}
}

function isEmailKnown($email) {
	
	$query = "SELECT email FROM user WHERE email = '" . $email . "'";
	$resulte = mysql_query($query);
	if (!resulte) {
		return false;
	}
	else {
		if ($row = mysql_fetch_assoc($resulte)) {
			return true;
		}
		else {
			return false;
		}
		
	}
}

function userAvail($username) {
	$query = "SELECT username FROM user WHERE username = '" . $username . "'";
	$resultu = mysql_query($query); 
	if (!resultu) {
		return false;
	}
	else {
		if ($row = mysql_fetch_assoc($resultu)) {
			return false;
		}
		else {
			return true;
		}		
	}
}

?>


			<center>
			<p>&nbsp;</p>
			<table>
				<tr> 
				
					<td align="right" valign="bottom" bordercolor="#333333" >
						Na aanmelding kijk in je mail voor verificatie link. Daarna kan worden ingelogd.
						<form method='POST' name="signupForm" style='login'> 
						<table>
							<tr> 
								<td align="left"> <h1> Aanmelden </h1> </td>
							</tr>
							
							<tr>
								<td align='left'> <label class='vert'> Gebruiker: 		</label> </td>
								<td> <input type='text' name='username'>  </td>
							</tr>
							
							<tr>
								<td align="left"> <label class='vert'> Wachtwoord: 		</label> </td>
								<td > <input type='password' name='password'>  </td>
							</tr>
							
							<tr>
								<td align="left"> <label class='vert'> Herhaal wachtwoord: 	</label> </td>
								<td > <input type='password' name='hpassword'> </td>
							</tr>
							
							<tr>
								<td align="left"> <label class='vert'> Email: 			</label>	 </td>
								<td > <input type='text' name='email'> </td>
							</tr>
				
							<tr>
								<td></td>	
								<td align="right">
									<input type='submit' name='login' value='ok' style="width:100px" align="right"> <br/>
								</td>
							</tr>
						
							<?php  if ( $error ) {  ?>
								<tr>	
									<td colspan='2'> <label class='red'> <?php echo $error; ?> </label> </td>
								</tr>
							<?php } ?>
						</table>
						</form>	
                      
					</td>
  
				</tr>
	 	 </table>
		</center>
         			 	<br/>
                        <center> <a href="http://ek2012.gameagenda.nl/"> Klik hier om terug te gaan naar het inlog scherm  </a> <br/> </center>
                        <br/>
</body>
</html>