<!doctype html>
<html xmlns:ng="http://angularjs.org" ng-app>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>Signup</title>
      <link href="style.css" rel="stylesheet" type="text/css">

      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
      <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular.min.js"></script>

      <style type="text/css">
        .css-form input.ng-invalid.ng-dirty {
          background-color: #FA787E;
        }
        .css-form input.ng-valid.ng-dirty {
          background-color: #78FA89;
        }
      </style>  

    </head>

<body>

<?php

require ("./includes/dbconnect.php");
require ("./includes/config.php");
require ("./language/nl.php");            
include 'functies.php';

$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);
$hpassword = mysql_real_escape_string($_POST['hpassword']);
$email = mysql_real_escape_string($_POST['email']);

if ( $username && $password && $hpassword && $email ) {

  if ( $password == $hpassword ) {
    
    if ( (isEmailKnown ( $email )) == true ) {
      $error = TEXT_ERROR_EMAIL_USED;
    }
    elseif ( (userAvail ( $username )) == false ) {
      $error = TEXT_ERROR_USERNAME_UNAVAIL;
    }
    
    if ( !$error ) {
      $rstr = rand_str();
      $query = "INSERT INTO user ( username, password, email, verifyMailHash ) VALUES ('" . $username . "', '" . $password . "', '" . $email . "', '" . $rstr . "' )";
      mysql_query($query) or die('Error, insert query failed');
            
      $message = "" . TEXT_EMAIL_VERIFYLINK . " http://". $domain ."/verifymail.php?key=" . $rstr;
       mail($email, TEXT_EMAIL_TITLE, $message, 'From: ' . FROM_EMAILADDRES . ' ' . "\r\n");
    }
    
  }
  else {
    $error = TEXT_ERROR_REPEAT_PASSWORD;
  }
}

?>

<div ng-controller="Controller"> 
  <?php echo TEXT_EXPLAIN_SIGNUP; ?>
  <form method='POST' name="signupForm" novalidate class="css-form">
    <h1> <?php echo TEXT_SIGNUP_TITLE; ?> </h1>
    <div>
      <input type='text' name='username' ng-model="user.name" placeholder=<?php echo TEXT_USER; ?> required>
    </div>
    <div>
      <input type='password' name='password' ng-model="user.password" placeholder=<?php echo TEXT_PASSWORD; ?> required> 
    </div>
    <div>
      <input type='password' name='hpassword' ng-model="user.repeatpassword" placeholder=<?php echo TEXT_REPEAT_PASSWORD; ?> required>
    </div>
    <div>
      <input type='email' name='email' ng-model="user.email" placeholder=<?php echo TEXT_EMAIL; ?> required>
    </div>
    <input type='submit' name='login' value='ok'>
  </form>
</div>

<script>
  function Controller($scope) {
    $scope.master = {};
 
    $scope.update = function(user) {
      $scope.master = angular.copy(user);
    };
 
    $scope.reset = function() {
      $scope.user = angular.copy($scope.master);
    };
 
    $scope.reset();
  }
</script>

  <?php  if ( $error ) {  ?>
    <label class='red'> <?php echo $error; ?> </label>
  <?php } ?>

  <center> <a href="<?php echo "http://" . $domain . "/" ; ?> "> Klik hier om terug te gaan naar het inlog scherm  </a> <br/> </center>
  <br/>
</body>
</html>