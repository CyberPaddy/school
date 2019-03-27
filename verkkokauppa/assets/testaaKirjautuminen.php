<?php 

if(isset($_POST['loginBtn'])) {

$username      = isset($_POST['user'])     ? $_POST['user'] : '';
$password      = isset($_POST['pass'])     ? $_POST['pass'] : '';

if($username != '' && $password != '' && $changePassword !== true) {
$sql = <<<SQLEND
SELECT username, passwd, isAdmin FROM users
WHERE username LIKE '{$username}' AND passwd LIKE AES_ENCRYPT('{$password}', '*NOT_REAL_KEY*')
LIMIT 1;
SQLEND;


echo $password $username;

$stmt = $db->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($stmt->rowCount() == 1) {

        $_SESSION['isAdmin'] = $row['isAdmin'];
        $_SESSION['LoggedIn'] = $username;
	$onnistunutKirjautuminen = true;
}
else $loginError = "Väärä käyttäjätunnus tahi salasana!";
}
elseif ($changePassword) {
        $changeForm = <<<CHANGEPASSWORD
<p><b>Vaihda salasana aktivoidaksesi tunnukset!</b></p>
<form action='vaihda-salasana.php' method='post'>
<input type='text' value='{$username}' name='user' readonly="readonly">
<input type='password' name='pass' placeholder='Uusi salasana'>
<input type='submit' name='passwdBtn' value='Vaihda salasana'>
</form>
CHANGEPASSWORD;
}
elseif ($_POST['kirjauduBtn'] == "Kirjaudu ulos") $loginError = "{$_SESSION['LoggedIn']} kirjautui ulos!";

elseif (isset($_POST['loginBtn'])) $loginError = "Väärä käyttäjätunnus taiii salasana!";
}
