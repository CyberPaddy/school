<?php

require_once('assets/navbar.php');
require_once('../../db-php/vuln-db-init.php');


$username   = isset($_POST['username'])  ? $_POST['username'] : '';
$fname    = isset($_POST['fname'])   ? $_POST['fname'] : '';
$lname     = isset($_POST['lname'])    ? $_POST['lname'] : '';
$passwd     = isset($_POST['passwd'])    ? $_POST['passwd'] : '';
$bday      = isset($_POST['bday'])     ? $_POST['bday'] : '';
$address      = isset($_POST['address'])     ? $_POST['address'] : '';
$post      = isset($_POST['post'])     ? $_POST['post'] : '';
$country      = isset($_POST['country'])     ? $_POST['country'] : 'FI';
$balance      = isset($_POST['balance'])     ? $_POST['balance'] : '0';
$isManufacturer  = isset($_POST['isManufacturer']) ? $_POST['isManufacturer'] : false;
$isAdmin      = isset($_POST['isAdmin'])     ? $_POST['isAdmin'] : '0';

$stmt = $mysqli->query("SELECT username FROM users where username = '{$username}';");
if ($stmt)  $existingUser = $stmt->fetch_assoc();

if($username != '' && $existingUser['username'] != $username &&  $fname != '' && $lname != '' && $passwd != '' && $bday != '' && $_SESSION['LoggedIn'] != '' && $_SESSION['isAdmin'] == true) {
$sql = "INSERT INTO users (username, fname, lname, passwd, bday, address, post, country, balance, isAdmin) VALUES ('$username', '$fname', '$lname', AES_ENCRYPT('$passwd', 'PekkaTopohanta69'), '$bday', '$address', '$post', '$country', '$balance', '$isAdmin')";


$user_added = $mysqli->query($sql);

if ($user_added)  echo "$username lisättiin onnistuneesti";
else              echo "Käyttäjän lisääminen epäonnistui: " . $mysqli->error;
}

else if ($_SESSION['isAdmin'] == false) echo "<p><b>Sinulla ei ole oikeuksia käyttäjän lisäämiseen!</b></p>";
elseif ($existingUser['username'] == $username) echo "<p><b>Käyttäjätunnus $username on jo käytössä!</b></p>";
else echo "<p>Käyttäjän lisääminen epäonnistui</p>";
?>
