<?php
  function initmatches () {
    
  }
    
  function checkpoints( $countryIn ) {
    //echo "checkpoints <br/>";
    $firstplaceCountry;
    $i = 0;
        
    foreach ( $countryIn as $key => $value) {
      if ( $i == 0 ) {
        $firstplaceCountry = $key;
      }
      else if ($countryIn[$firstplaceCountry] < $value ) {
        unset($countryIn[$firstplaceCountry]);      
        $firstplaceCountry = $key;                  
      }
      else if ($countryIn[$firstplaceCountry] > $value ) {
        unset($countryIn[$key]);
      }
      $i++;
    }
    return $countryIn;  
  }   

  function checkGoalDifference ( $countryIn , $numberOfGoals , $goalAgainst ) {
        //echo "checkgoaldiff <br/>";
    $firstplaceCountry; 
    $i = 0;
        
    foreach ( $countryIn as $key => $value ) {
            
      if ( $i == 0 ) {
        $firstplaceCountry = $key;
      }
      else {
        $goaldifferenceFirst = ($numberOfGoals[$firstplaceCountry] - $goalAgainst[$firstplaceCountry]);
        $goaldifferenceOther = $numberOfGoals[$key] - $goalAgainst[$key];   
                
                //echo "g: " . $goaldifferenceFirst . " f: " . $goaldifferenceOther;
                
        if ($goaldifferenceFirst < $goaldifferenceOther) {
          unset($countryIn[$firstplaceCountry]);
          $firstplaceCountry = $key;
        }   
        else if ( $goaldifferenceFirst > $goaldifferenceOther) {
          unset($countryIn[$key]);
        }
                    
      }       
      $i++;
    }
    return $countryIn;
    
  }   
    
  function checkTotalGoals ( $countryIn, $numberOfGoals ) {           
    //echo "checkTotalGoals <br/>";
    $firstplaceCountry;
    $i = 0;
    foreach ( $countryIn as $key => $value ) {
            
      if ( $i == 0 ) {
        $firstplaceCountry = $key;
      }
      else {  
        $t1 = $numberOfGoals[$firstplaceCountry];
        $t2 = $numberOfGoals[$key];
        if ( $t1 > $t2 ) {
          unset($countryIn[$key]);
        }
        else if ( $t1 < $t2 ) {
          unset($countryIn[$firstplaceCountry]);
          $firstplaceCountry = $key;
        }
      }
      $i++;   
    }
        
    return $countryIn;
  }   
    
  function checkHead2Head ( $countryIn, $userid ) {
    //echo "checkhead2head <br/>" ;
    $countryOut = array();      // winners get returned.    not sure for possible deadlock
        
    $count_total = count($countryIn);
    for ($counter=0; $counter<$count_total; $counter++) {  // +@ , twee keer each?
            
            //echo $count_total;
      $keyval1 = each ($countryIn);
      $keyval2 = each ($countryIn);
      prev($countryIn);       // 1 terug 
            
      $countryA  = $keyval1[key];
      $countryB  = $keyval2[key];
            
            
      $matchNumber = 0;
      $matchnumQ1 = "SELECT matchNumber FROM groupmatch WHERE (teamA = '" . $countryA . "' AND teamB = '" . $countryB . "') OR ( teamA = '" . $countryB . "' AND teamB = '" . $countryA . "' ) ";
      //echo $matchnumQ1;
      $resultQ1 = mysql_query($matchnumQ1);
      if ($resultQ1) {
        $rowQ1 = mysql_fetch_assoc($resultQ1);
        $matchNumber = $rowQ1['matchNumber'];
                
      }
      //echo $matchNumber;
      if ( $matchNumber > 0 ) {
            
        $head2headQuery = "SELECT resultTeamA, resultTeamB, finalCountryA, finalCountryB From usermatchresults WHERE  matchId = " . $matchNumber . " AND userid = '" . $userid . "'";
                //echo "<br/>" . $head2headQuery . "<br/>";
        $head2headResult = mysql_query($head2headQuery);
        if ( $head2headResult ) {
                
          $head2headRow = mysql_fetch_assoc($head2headResult);
          $teamAresultH2 = $head2headRow['resultTeamA'];
          $teamBresultH2 = $head2headRow['resultTeamB'];
          $finalCountryA = $countryA; //$head2headRow['finalCountryA'];
          $finalCountryB = $countryB; //$head2headRow['finalCountryB'];   
                    
          if ($teamAresultH2 > $teamBresultH2 ) {     // A wint van B , dus A mag terug de array in.
            $countryOut[$finalCountryA] = $countryIn[$finalCountryA];
                        
            //echo $countryOut[$finalCountryA];
            //echo $finalCountryA;
          }   
          else if ($teamBresultH2 > $teamAresultH2 ) {    // B wint van A , dus B mag terug de array in
            $countryOut[$finalCountryB] = $countryIn[$finalCountryB];
            //echo $countryOut[$finalCountryB];
          }
          else {                                              // A speelt gelijk tegen B , beide terug
            $countryOut[$finalCountryA] = $countryIn[$finalCountryA];
            $countryOut[$finalCountryB] = $countryIn[$finalCountryB];
            //echo "gelijk. <br/>";
            //echo "out: " . count($countryOut) . "<br/>";
          }
        }               
            
      }
                   
    }
    
    return $countryOut;
  
  }


    
  function showGroup($group, $userid, $titleText) {  
    
    $currentGroup = Array();
            
    $goalAgainst = Array(); // Todo
            
    $numberOfGoals = Array();
    
    echo "<table class='standard'> <tr> <th colspan='10' class='standard'>  ". $titleText . "</th> </tr>";
    
    $result = mysql_query("SELECT teamA, teamB, matchNumber FROM groupmatch WHERE stage1group = '".$group."' ORDER BY matchNumber; ");
    if (!$result) {
      die('Invalid query: ' . mysql_error());
    }
    else {
      while ($row = mysql_fetch_assoc($result)) {
                
        $id = $row['matchNumber'];
        $idA = "" . $id . "A";
        $idB = "" . $id . "B";
                    
                    
        $selectMatchQuery = "SELECT resultTeamA, resultTeamB FROM usermatchresults WHERE matchId = '" . $id . "' AND userId = '" . $userid . "'";
        $result2 = mysql_query($selectMatchQuery);
                    
                    
        if ( $result2 ) {
          //echo $selectMatchQuery;
          $row2 = mysql_fetch_assoc($result2);
                        
          $teamAresult = $row2['resultTeamA'];
          $teamBresult = $row2['resultTeamB'];
                        
        }
        else {
          echo $selectMatchQuery;
          die('Invalid query: ' . mysql_error());
        }
                    
        $teamA = $row['teamA'];
        $teamB = $row['teamB'];
    
      ?>
        <tr>  
          <td> <img src="<?php echo strtolower("images/flags/" . $row['teamA'] . ".gif"); ?>"> </img> </td><td> <label> <?php echo $row['teamA'] ?> </label>  </td> <td>-</td>
            <td align="right" class="teamb"> <label class="teamb"> <?php echo $row['teamB'] ?> </label>  </td> <td> <img src="<?php echo strtolower("images/flags/" . $row['teamB'] . ".gif"); ?>"> </img> </td>
          <td> 
          <?php
              if ( $teamAresult > $teamBresult && ($teamAresult != "" || $teamBresult != "") ) { 
                  $currentGroup[$teamA] = $currentGroup[$teamA] + 3;      // A wint van B 3 punten
          ?>
                <input type='text' size='3' style='background-color: lightgreen;' name='<?php echo $idA  ?>' value='<?php echo $teamAresult ?>' > 
                <input type='text' size='3' name='<?php echo $idB ?>'  value='<?php echo $teamBresult ?>'> 
          
          <?php 
              }
              else if ( $teamAresult < $teamBresult && ($teamAresult != "" || $teamBresult != "") ) { 
                  $currentGroup[$teamB] = $currentGroup[$teamB] + 3;      // B wint van A 3 punten
                  
          ?>
                <input type='text' size='3' name='<?php echo $idA  ?>' value='<?php echo $teamAresult ?>' > 
                <input type='text' size='3' style='background-color: lightgreen;' name='<?php echo $idB ?>'  value='<?php echo $teamBresult ?>'> 
          
          <?php 
              }
              else if ( $teamAresult == $teamBresult && ($teamAresult != "" || $teamBresult != "") ) {
                  $currentGroup[$teamA] = $currentGroup[$teamA] + 1;      // gelijkspel , ieder 1 punt
                  $currentGroup[$teamB] = $currentGroup[$teamB] + 1;      // 
          ?>
                <input type='text' size='3' style='background-color: yellow;' name='<?php echo $idA  ?>' value='<?php echo $teamAresult ?>' > 
                <input type='text' size='3' style='background-color: yellow;' name='<?php echo $idB ?>'  value='<?php echo $teamBresult ?>'> 

          <?php 
              }
              else { 
          ?>
                <input type='text' size='3' name='<?php echo $idA  ?>' value='<?php echo $teamAresult ?>' > 
                <input type='text' size='3' name='<?php echo $idB ?>'  value='<?php echo $teamBresult ?>'> 
          <?php 
              } 
              
              //$data[] = array('volume' => 67, 'edition' => 2);
              
              $goalAgainst[$teamA] = $goalAgainst[$teamA] + $teamBresult;             // for calculating the goals difference.
              $goalAgainst[$teamB] = $goalAgainst[$teamB] + $teamAresult;
              
              $numberOfGoals[$teamA] = $numberOfGoals[$teamA] + $teamAresult;
              $numberOfGoals[$teamB] = $numberOfGoals[$teamB] + $teamBresult;

          ?>

  </td> 
</tr>
                            
            <?php
          }
  }
    
            $ndPlace = array();         // 2nd place array
            $country = "";
            $country2 ="";
            
            
            // checks first place
            $out = checkpoints( $currentGroup );
            if ( count($out) > 1 )  $out = checkGoalDifference( $out, $numberOfGoals, $goalAgainst );
            if ( count($out) > 1 )  $out = checkTotalGoals ( $out, $numberOfGoals );
            if ( count($out) > 1 )  $out = checkHead2Head ( $out, $userid );
            
            
            if ( count($out) == 1 ) {
              $keyval1 = each( $out );
              $country = $keyval1[key];
              echo "<tr> <td colspan='3'> Group Winner: </td> <td> " . $country . "</td>";
            }
            else {
            
                $firstMatchID = -1;
                $result1 = mysql_query("SELECT matchNumber FROM groupmatch WHERE teamA = '". ("1" . $group) ."'; ");    // seek final match number
        
                if ( $result1 ) {
                  if ($row = mysql_fetch_assoc($result1)) {
                    $firstMatchID = $row['matchNumber'];    
                    $selResultF = mysql_query("SELECT finalCountryA FROM usermatchresults WHERE userid = '" . $userid . "' AND matchid = '" . $firstMatchID . "' ");
                    if ( mysql_num_rows($selResultF) > 0 ) {
                      if ($rowF = mysql_fetch_assoc($selResultF)) {
                        $country = $rowF['finalCountryA'];      
                      }
                    }
                  }
                }   
                
                
                // query-en van huidige winnaar uit database, en matchen of deze veranderd is.
                if ( $country <> $_POST["win" . $group ] && $_POST["win" . $group ] <> "") {
                  $country =  $_POST["win" . $group ];
                }
                echo "<tr> <td colspan='3'> Group Winner: </td> <td>";
                echo "<select name='win" . $group . "'>";
                echo "<option value=''></option>";
                foreach ( $out as $key => $value ) {
                  echo "<option value='" . $key ."' ";
                  if ( $key == $country ) echo "selected";
                    echo "> " . $key . "</option>";
                }       
                echo "</select>";
                echo "</td>";
    
            }           
                
                $firstCountry = $country;
                $ndPlace = $currentGroup;
                unset ( $ndPlace[$country] );       // haal eerste plaats country uit de lijst.
                
                
                // begin 2nd place checks
                $ndPlace = checkpoints( $ndPlace );
                if ( count($ndPlace) > 1 )  $ndPlace = checkGoalDifference( $ndPlace, $numberOfGoals, $goalAgainst );
                if ( count($ndPlace) > 1 )  $ndPlace = checkTotalGoals ( $ndPlace, $numberOfGoals );
                if ( count($ndPlace) > 1 )  $ndPlace = checkHead2Head ( $ndPlace, $userid );
                
                if ( count($ndPlace) == 1 ) {
                  $keyval1 = each($ndPlace );
                  $country2 = $keyval1[key];
                  echo "<tr> <td colspan='3'> 2nd of group: </td> <td> " . $country2 . "</td>";
                }
                else {
                
                $secondMatchID = -1;
                $result2 = mysql_query("SELECT matchNumber FROM groupmatch WHERE teamB = '". ("2" . $group) ."'; ");    // seek final match number
            
                if ( $result2 ) {
                  if ($row = mysql_fetch_assoc($result2)) {
                    $secondMatchID = $row['matchNumber'];
    
                    $selResultF2 = mysql_query("SELECT finalCountryB FROM usermatchresults WHERE userid = '" . $userid . "' AND matchid = '" . $secondMatchID . "' ");
                    if ( mysql_num_rows($selResultF2) > 0 ) {
                      if ( mysql_num_rows($selResultF2) > 0 ) {
                        if ($rowF2 = mysql_fetch_assoc($selResultF2)) {
                          $country2 = $rowF2['finalCountryB'];        
                        }
                      }   
                    }
                  }
                }           
                
                    // query-en van huidige winnaar uit database, en matchen of deze veranderd is.
                
                if ( $country2 <> $_POST["nd" . $group ] && $_POST["nd" . $group ] <> "") {
                  $country2 =  $_POST["nd" . $group ];
                }
                
                echo "<tr> <td colspan='3'> 2nd of group: </td><td>";
                echo "<select  name='nd" . $group . "'>";
                echo "<option value=''></option>";
                foreach ( $ndPlace as $key => $value ) {
                  echo "<option value='" . $key ."' ";
                  if ( $key == $country2 ) echo "selected";
                    echo "> " . $key . "</option>";
                  }       
                  echo "</select>";
                  echo "</td>";
                }
                $secondCountry = $country2;
                
            $firstMatchID = -1;
            $result1 = mysql_query("SELECT matchNumber FROM groupmatch WHERE teamA = '". ("1" . $group) ."'; ");    // seek final match number
        
            if ( $result1 ) {
              if ($row = mysql_fetch_assoc($result1)) {
                $firstMatchID = $row['matchNumber'];    
    
                  $selResultF = mysql_query("SELECT * FROM usermatchresults WHERE userid = '" . $userid . "' AND matchid = '" . $firstMatchID . "' ");
        
                  if ( mysql_num_rows($selResultF) == 0 ) {   // match bestaat nog niet
                    mysql_query("INSERT INTO usermatchresults ( userid, matchid, finalCountryA ) VALUES ( '" . $userid . "', '" .$firstMatchID . "', '" . mysql_real_escape_string($firstCountry) . "') ");
                  }
                  else {          // als het land veranderd is updaten
    
                        // update alleen als het land veranderd is, scores verwijderen resultTeamA, resultTeamB
    
                    $updateQueryF = "UPDATE usermatchresults SET finalCountryA = '" . mysql_real_escape_string($firstCountry) . "', resultTeamA = NULL, resultTeamB = NULL WHERE userid = '" . $userid . "' AND matchid = '" . $firstMatchID . "' AND (finalCountryA <> '" . mysql_real_escape_string($firstCountry) . "' or finalCountryA IS NULL)";
                        
                    $updateResultF = mysql_query($updateQueryF); 
                  }
              }
            }
    
            $secondMatchID = -1;
            $result2 = mysql_query("SELECT matchNumber FROM groupmatch WHERE teamB = '". ("2" . $group) ."'; ");    // seek final match number
            
            if ( $result2 ) {
              if ($row = mysql_fetch_assoc($result2)) {
                $secondMatchID = $row['matchNumber'];
    
                $selResultF2 = mysql_query("SELECT * FROM usermatchresults WHERE userid = '" . $userid . "' AND matchid = '" . $secondMatchID . "' ");
    
                if ( mysql_num_rows($selResultF2) == 0 ) {  // match bestaat nog niet
                  $insertQueryF2 = "INSERT INTO usermatchresults ( userid, matchid, finalCountryB ) VALUES ( '" . $userid . "', '" .$firstMatchID . "', '" . mysql_real_escape_string($secondCountry) . "') ";
                        //echo $insertQueryF2;
                  mysql_query($insertQueryF2);
                }
                else {          // als het land veranderd is updaten
                        
                  $updateQueryF2 = "UPDATE usermatchresults SET finalCountryB = '" . mysql_real_escape_string($secondCountry) . "', resultTeamA = NULL, resultTeamB = NULL WHERE userid = " . $userid . " AND matchid = " . $secondMatchID . " AND (finalCountryB <> '" . mysql_real_escape_string($secondCountry) . "' or finalCountryB IS NULL)";
                        //echo $updateQueryF2;
                  $updateResultF2 = mysql_query($updateQueryF2); 
                }
    
              }
            }   
    
    
            echo "</table>";
    
        }   

        function showFinal($group, $userid, $titleText) {  
    
            echo "<table class='standard'> <tr> <th colspan='10' class='standard'>  ". $titleText . "</th> </tr>";
    
            $result = mysql_query("SELECT teamA, teamB, matchNumber FROM groupmatch WHERE stage1group = '".$group."' ORDER BY matchNumber; ");
            if (!$result) {
                    die('Invalid query: ' . mysql_error());
            }
            else {
                while ($row = mysql_fetch_assoc($result)) {
        
                    $firstCountry = "";
                    $loseCountry = "";
                
                    $id = $row['matchNumber'];
                    $idA = "" . $id . "A";
                    $idB = "" . $id . "B";
                    
                    
                    $selectMatchQuery = "SELECT resultTeamA, resultTeamB, finalCountryA, finalCountryB FROM usermatchresults WHERE matchId = '" . $id . "' AND userId = '" . $userid . "'";
                    $result2 = mysql_query($selectMatchQuery);
                    
                    
                    if ( $result2 ) {
                      //echo $selectMatchQuery;
                      $row2 = mysql_fetch_assoc($result2);
                        
                      $teamAresult = $row2['resultTeamA'];
                      $teamBresult = $row2['resultTeamB'];
                        
                    }
                    else {
                      echo $selectMatchQuery;
                      die('Invalid query: ' . mysql_error());
                    }
                    
    
                    $teamA = $row2['finalCountryA'];
                    if ($teamA == "") $teamA = $row['teamA'];
                    $teamB = $row2['finalCountryB'];
                    if ($teamB == "") $teamB = $row['teamB'];
                        
                    ?>
                        <tr>  
                          <td> 
                            <img src="<?php echo strtolower("images/flags/" . $teamA . ".gif"); ?>"> </img> </td><td> <label> <?php echo $teamA ?> </label>  </td> <td>-</td>
                              <td align="right" class="teamb"> <label class="teamb"> <?php echo $teamB ?> </label>  </td> <td> <img src="<?php echo strtolower("images/flags/" . $teamB . ".gif"); ?>"> </img> </td>
                              <td> 
                                <?php 
                                  if ( $teamAresult > $teamBresult && ($teamAresult != "" || $teamBresult != "") ) { 
                                    $firstCountry = $teamA; 
                                    $loseCountry = $teamB;                                  
                                ?>
                                    <input type='text' size='3' style='background-color: lightgreen;' name='<?php echo $idA  ?>' value='<?php echo $teamAresult ?>' > 
                                    <input type='text' size='3' name='<?php echo $idB ?>'  value='<?php echo $teamBresult ?>'> 
                                    
                                <?php 
                                  }
                                  else if ( $teamAresult < $teamBresult && ($teamAresult != "" || $teamBresult != "") ) { 
                                    $firstCountry = $teamB;
                                    $loseCountry = $teamA;
                                ?>
                                    <input type='text' size='3' name='<?php echo $idA  ?>' value='<?php echo $teamAresult ?>' > 
                                    <input type='text' size='3' style='background-color: lightgreen;' name='<?php echo $idB ?>'  value='<?php echo $teamBresult ?>'> 
                                    
                                <?php 
                                  }
                                  else {
                                    // ERROR final kan niet gelijk spelen.
                                ?>
                                    <input type='text' size='3' style='background-color: yellow;' name='<?php echo $idA  ?>' value='<?php echo $teamAresult ?>' > 
                                    <input type='text' size='3' style='background-color: yellow;' name='<?php echo $idB ?>'  value='<?php echo $teamBresult ?>'> 
                                <?php 
                                  }
                                        //else { 
                                ?>
                            </td> 
                        </tr>
                            
                    <?php
    
                    // TEAM-A
                    $seekquery1 = "SELECT matchNumber FROM groupmatch WHERE teamA = '". ("W" . $id) . "'";
                    $result1 = mysql_query($seekquery1);    // seek final match number
                    //echo $seekquery1 . "<br/>";
                    if ( $result1 ) {
                      if ($row = mysql_fetch_assoc($result1)) {
                        $matchID = $row['matchNumber'];
                        //echo $matchID;
    
                        $selResultF = mysql_query("SELECT * FROM usermatchresults WHERE userid = '" . $userid . "' AND matchid = '" . $matchID . "' ");
    
                        if ( mysql_num_rows($selResultF) == 0 ) {   // match bestaat nog niet
                          $insertQueryF2 = "INSERT INTO usermatchresults ( userid, matchid, finalCountryA ) VALUES ( '" . $userid . "', '" .$matchID . "', '" . mysql_real_escape_string($firstCountry) . "') ";
                          //  echo $insertQueryF2;
                          mysql_query($insertQueryF2);
                        }
                        else {          // als het land veranderd is updaten 
                          $updateQueryF2 = "UPDATE usermatchresults SET finalCountryA = '" . mysql_real_escape_string($firstCountry) . "', resultTeamA = NULL, resultTeamB = NULL WHERE userid = " . $userid . " AND matchid = " . $matchID . " AND (finalCountryA <> '" . mysql_real_escape_string($firstCountry) . "' OR finalCountryA IS NULL)";
                          //echo $updateQueryF2 . "<br/>";
                          $updateResultF2 = mysql_query($updateQueryF2); 
                        }       
                      }
                    }
                    
                    // TEAM-B
                    $seekquery2 = "SELECT matchNumber FROM groupmatch WHERE teamB = '". ("W" . $id) . "'";
                    $result2 = mysql_query($seekquery2);    // seek final match number
                    //echo $seekquery2 . "<br/>";
                    if ( $result2 ) {
                      if ($row2 = mysql_fetch_assoc($result2)) {
                        $matchID2 = $row2['matchNumber'];
                        //echo $matchID2;
    
                        $selResultF2 = mysql_query("SELECT * FROM usermatchresults WHERE userid = '" . $userid . "' AND matchid = '" . $matchID2 . "' ");
    
                        if ( mysql_num_rows($selResultF2) == 0 ) {  // match bestaat nog niet
                          $insertQueryF3 = "INSERT INTO usermatchresults ( userid, matchid, finalCountryB ) VALUES ( '" . $userid . "', '" .$matchID2 . "', '" . mysql_real_escape_string($firstCountry) . "') ";
                          //echo $insertQueryF2;
                          mysql_query($insertQueryF3);
                        }
                        else {          // als het land veranderd is updaten
                          $updateQueryF3 = "UPDATE usermatchresults SET finalCountryB = '" . mysql_real_escape_string($firstCountry) . "', resultTeamA = NULL, resultTeamB = NULL WHERE userid = " . $userid . " AND matchid = " . $matchID2 . " AND (finalCountryB <> '" . mysql_real_escape_string($firstCountry) . "' OR finalCountryB IS NULL)";
                        //      echo $updateQueryF3 . "<br/>";
                          $updateResultF3 = mysql_query($updateQueryF3); 
                        }       
                      }
                    }
                    
                    //
                    // Tirth Place, lusers of half finals
                    //
                    
                    // TEAM-A luser
                    $seekquery1 = "SELECT matchNumber FROM groupmatch WHERE teamA = '". ("L" . $id) . "'";
                    $result1 = mysql_query($seekquery1);    // seek final match number
                    if ( $result1 ) {
                      if ($row = mysql_fetch_assoc($result1)) {
                        $matchID = $row['matchNumber'];
                        $selResultF = mysql_query("SELECT * FROM usermatchresults WHERE userid = '" . $userid . "' AND matchid = '" . $matchID . "' ");
    
                        if ( mysql_num_rows($selResultF) == 0 ) {   // match bestaat nog niet
                          $insertQueryF2 = "INSERT INTO usermatchresults ( userid, matchid, finalCountryA ) VALUES ( '" . $userid . "', '" .$matchID . "', '" . mysql_real_escape_string($loseCountry) . "') ";
                          mysql_query($insertQueryF2);
                        }
                        else {          // als het land veranderd is updaten
                          $updateQueryF2 = "UPDATE usermatchresults SET finalCountryA = '" . mysql_real_escape_string($loseCountry) . "', resultTeamA = NULL, resultTeamB = NULL WHERE userid = " . $userid . " AND matchid = " . $matchID . " AND (finalCountryA <> '" . mysql_real_escape_string($loseCountry) . "' OR finalCountryA IS NULL)";
                          $updateResultF2 = mysql_query($updateQueryF2); 
                        }       
                      }
    
                    }
                    
                    
                    // TEAM-B
                    $seekquery2 = "SELECT matchNumber FROM groupmatch WHERE teamB = '". ("L" . $id) . "'";
                    $result2 = mysql_query($seekquery2);    // seek final match number
                    
                    if ( $result2 ) {
                      if ($row2 = mysql_fetch_assoc($result2)) {
                        $matchID2 = $row2['matchNumber'];
                        $selResultF2 = mysql_query("SELECT * FROM usermatchresults WHERE userid = '" . $userid . "' AND matchid = '" . $matchID2 . "' ");
    
                        if ( mysql_num_rows($selResultF2) == 0 ) {  // match bestaat nog niet
                          $insertQueryF3 = "INSERT INTO usermatchresults ( userid, matchid, finalCountryB ) VALUES ( '" . $userid . "', '" .$matchID2 . "', '" . mysql_real_escape_string($loseCountry) . "') ";
                          mysql_query($insertQueryF3);
                        }
                        else {          // als het land veranderd is updaten
                          $updateQueryF3 = "UPDATE usermatchresults SET finalCountryB = '" . mysql_real_escape_string($loseCountry) . "', resultTeamA = NULL, resultTeamB = NULL WHERE userid = " . $userid . " AND matchid = " . $matchID2 . " AND (finalCountryB <> '" . mysql_real_escape_string($loseCountry) . "' OR finalCountryB IS NULL)";
                          $updateResultF3 = mysql_query($updateQueryF3); 
                        }       
    
                      }
    
                    }
                    
    
                }
            }
    
            echo "</table>";
    
        }       
    
?>