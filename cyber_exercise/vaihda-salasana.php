<?php

require_once('assets/navbar.php');

# Jos käyttäjä aktivoi tunnareitaan
if (isset($_POST['passwdBtn'])) {

$user =		isset($_POST['user']) ? $_POST['user'] : '';
$pass =		isset($_POST['pass']) ? $_POST['pass'] : '';

# Testaus onko molemmat annettu
if ($user != '' && $pass != '') {

$stmt = $mysqli->query("UPDATE users SET passwd=AES_ENCRYPT('{$pass}', 'PekkaTopohanta69') WHERE username LIKE '{$user}';");
if ($stmt)  echo "<p><b>Salasanasi on vaihdettu!</b></p>";
else        echo "<p>Salasanan vaihto epäonnistui</p>";
}

else echo "Käyttäjätunnus tai salasana on määrittämätön.";

}

else if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') {

  $user =		isset($_SESSION['LoggedIn']) ? $_SESSION['LoggedIn'] : '';

  $changeForm = <<<CHANGEPASSWORD
<p><b>Vaihda salasanasi</b></p>
<form action='vaihda-salasana.php' method='post'>
<input type='password' name='oldPass' placeholder='Vanha salasana'>
<input type='password' name='newPass' placeholder='Uusi salasana'>
<input type='password' name='newPassAgain' placeholder='Uusi salasana uudestaan'>
<input type='submit' name='loggedPasswdBtn' value='Vaihda salasana' class='bigBtn'>
</form>
CHANGEPASSWORD;

  echo $changeForm;
}

if(isset($_POST['loggedPasswdBtn'])) {
  $user =		isset($_SESSION['LoggedIn']) ? $_SESSION['LoggedIn'] : '';
  $oldPass =		isset($_POST['oldPass']) ? $_POST['oldPass'] : '';
  $newPass =		isset($_POST['newPass']) ? $_POST['newPass'] : '';
  $newPass2 =		isset($_POST['newPassAgain']) ? $_POST['newPassAgain'] : '';

# Testaus onko molemmat annettu
if ($user != '' && $oldPass != '' && $newPass != '' && $newPass2 != '') {

$testPass = $mysqli->query("SELECT username, passwd FROM users WHERE username LIKE '{$user}' AND passwd
= AES_ENCRYPT('{$oldPass}', 'PekkaTopohanta69');");

if ($testPass)  $realPass = $testPass->fetch_assoc();

# Jos käyttäjän vanha passu oli väärin
if (!$realPass) {
  echo "<p><b>Väärä vanha salasana!</b></p>";
}

elseif ($newPass == $newPass2) {
$stmt = $mysqli->query("UPDATE users SET passwd=AES_ENCRYPT('{$newPass}', 'PekkaTopohanta69') WHERE username LIKE '{$user}';");
if ($stmt)  echo "<p><b>$user käyttäjän salasana vaihdettu!</b></p>";
else        echo "<p><b>Salasanan vaihto epäonnistui: " . $mysqli->error . "</b></p>";
}
else echo "<p><b>Uudet salasanat eivät mätsää!</b></p>";
}
else echo "<p><b>Täytä kaikki kentät!</b></p>";
}
