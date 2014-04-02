<?php
function rand_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
{
    // Length of character list
    $chars_length = (strlen($chars) - 1);

    // Start our string
    $string = $chars{rand(0, $chars_length)};
   
    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string))
    {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
       
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
    }
   
    // Return the string
    return $string;
}

// used in signup.php

// Checks if the Email Address is already known
function isEmailKnown($email) {
  $query = "SELECT email FROM user WHERE email = '" . $email . "'";
  $resulte = mysql_query($query);
  if (!resulte) return false;
  if ($row = mysql_fetch_assoc($resulte)) return true;
  return false;      
}

// Check if the Username is available
function userAvail($username) {
  $query = "SELECT username FROM user WHERE username = '" . $username . "'";
  $resultu = mysql_query($query); 
  if (!resultu) return false;
  if ($row = mysql_fetch_assoc($resultu)) return false;
  return true;
}

?>