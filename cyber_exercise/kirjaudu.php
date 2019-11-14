<?php
require_once('assets/navbar.php');
require_once('../../db-php/vuln-db-init.php');

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_SCHEMA);

$loginForm = <<<LOGINFORM
<form action="kirjaudu.php" method="post" style="margin-top:35px;">
<input type="text" name="user" placeholder="Käyttäjä">
<input type="password" name="pass" placeholder="Salasana">
<input type="submit" name="loginBtn" value="Kirjaudu">
</form>
LOGINFORM;

# Jos käyttäjä  on juuri kirjautunut
if($onnistunutKirjautuminen) echo "<p>Kirjautunut käyttäjä: $username</p>";
elseif(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') echo "<p>Kirjautunut käyttäjä: {$_SESSION['LoggedIn']}</p>";
else {
	echo $loginForm;
	echo "<p>{$loginError}</p>";
}

echo $changeForm;


if (isset($_POST['kirjauduBtn']) && $loggedOut == true) {
echo "Kirjauduit ulos";
}
