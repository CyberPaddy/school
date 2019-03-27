<?php

require_once('assets/navbar.php');
require_once('../../db-php/db-init2.php');


$username   = isset($_POST['username'])  ? $_POST['username'] : '';
$fname    = isset($_POST['fname'])   ? $_POST['fname'] : '';
$lname     = isset($_POST['lname'])    ? $_POST['lname'] : '';
$passwd     = isset($_POST['passwd'])    ? $_POST['passwd'] : '';
$bday      = isset($_POST['bday'])     ? $_POST['bday'] : '';
$address      = isset($_POST['address'])     ? $_POST['address'] : '';
$post      = isset($_POST['post'])     ? $_POST['post'] : '';
$country      = isset($_POST['country'])     ? $_POST['country'] : 'FI';
$balance      = isset($_POST['balance'])     ? $_POST['balance'] : '0';
$isAdmin      = isset($_POST['isAdmin'])     ? $_POST['isAdmin'] : '0';

$stmt = $db->prepare("SELECT username FROM users where username like '{$username}';");
$stmt->execute();
$existingUser = $stmt->fetch(PDO::FETCH_ASSOC);


if($username != '' && $existingUser['username'] != $username &&  $fname != '' && $lname != '' && $passwd != '' && $bday != '' && $_SESSION['LoggedIn'] != '' && $_SESSION['isAdmin'] == true) {
$sql = <<<SQLEND
INSERT INTO users (username, fname, lname, passwd, bday, address, post, country, balance, isAdmin)
VALUES (:username, :fname, :lname, AES_ENCRYPT(:passwd, 'PekkaTopohanta69'), :bday, :address, :post, :country, :balance, :isAdmin)
SQLEND;


$stmt = $db->prepare($sql);
   $stmt->bindValue(":username", $username, PDO::PARAM_STR);
   $stmt->bindValue(":fname", $fname, PDO::PARAM_STR);
   $stmt->bindValue(":lname", $lname, PDO::PARAM_STR);
   $stmt->bindValue(":passwd", $passwd, PDO::PARAM_STR);
   $stmt->bindValue(":bday", $bday, PDO::PARAM_STR);
   $stmt->bindValue(":address", $address, PDO::PARAM_STR);
   $stmt->bindValue(":post", $post, PDO::PARAM_INT);
   $stmt->bindValue(":country", $country, PDO::PARAM_STR);
   $stmt->bindValue(":balance", $balance, PDO::PARAM_STR);
   $stmt->bindValue(":isAdmin", $isAdmin, PDO::PARAM_BOOL);
   $stmt->execute();

echo "$username lisättiin onnistuneesti";
}
else if ($_SESSION['isAdmin'] == false) echo "<p><b>Sinulla ei ole oikeuksia tuotteen lisäämiseen!</b></p>";
elseif ($existingUser['username'] == $username) echo "<p><b>Käyttäjätunnus $username on jo käytössä!</b></p>";
else echo "<p>Tuotteen lisääminen epäonnistui</p>";
?>
