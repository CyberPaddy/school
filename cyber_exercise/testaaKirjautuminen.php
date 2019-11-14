<?php 
require_once('../../db-php/vuln-db-init.php');
if(isset($_POST['loginBtn'])) {

  $username      = isset($_POST['user'])     ? stripslashes($_POST['user']) : '';
  $password      = isset($_POST['pass'])     ? stripslashes($_POST['pass']) : '';


if($username != '' && $password != '') {

  $sql = "SELECT username, isAdmin FROM users WHERE username LIKE '" . $username . "' AND passwd LIKE AES_ENCRYPT('{$password}', 'PekkaTopohanta69');";

$stmt = $mysqli->query($sql);
if ($stmt)  $row = $stmt->fetch_assoc();

if($row) {
  $_SESSION['isAdmin'] = $row['isAdmin'];
  $_SESSION['LoggedIn'] = $row['username'];
  $onnistunutKirjautuminen = true;
}
elseif ($_POST['kirjauduBtn'] == "Kirjaudu ulos") {
  $loginError = "{$_SESSION['LoggedIn']} kirjautui ulos!";
}

elseif (isset($_POST['loginBtn'])) {
  # Testataan onko käyttäjä olemassa
  $stmt = $mysqli->query("SELECT username FROM users WHERE username LIKE '" . $username . "';");
  if ($stmt)  $row = $stmt->fetch_assoc();
  
  if ($row) {
    do {
      $loginError .= "Väärä salasana käyttäjälle {$row['username']}!";
    } while ($row = $stmt->fetch_assoc());
  }

  else
    $loginError = "Väärä käyttäjätunnus tai salasana!";
}

}}
