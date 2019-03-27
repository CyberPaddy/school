<?php

require_once('../../db-php/db-init2.php');
$vaihdettava = file_get_contents("passut.txt");
$v = explode(" ", $vaihdettava);

if (isset($_POST['loginBtn']) && (!isset($_SESSION['LoggedIn']) || $_SESSION['LoggedIn'] == '')) {
$kayt = $_POST['user'];
$pass = $_POST['pass'];
$passuHaku = $db->prepare("SELECT username, passwd FROM users WHERE username LIKE '{$kayt}' AND passwd
LIKE AES_ENCRYPT('{$pass}', '*NOT_REAL_KEY*');");
$passuHaku->execute();

$row = $passuHaku->fetch(PDO::FETCH_ASSOC);
# Testataan oliko käyttäjä olemassa ja onko sen passu vaihdettavien listassa
if ($row != NULL)
	if(preg_grep("/^{$row['passwd']}$/i", $v)) $changePassword = true;
}
