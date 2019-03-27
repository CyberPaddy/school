<?php session_start(); ?>

<title>Huig verkkokauppa</title>
<link rel="stylesheet" type="text/css" href="style.css">

<div id='wrapper'>
<div id='navbar'>
<?php
require_once('testaaPassut.php');
require_once('testaaKirjautuminen.php');

if ($_POST['kirjauduBtn'] == 'Kirjaudu ulos' && $_SESSION['LoggedIn'] != '') {
$log = 'Kirjaudu ulos';
$_SESSION['LoggedIn'] = '';
$_SESSION['ostoskori'] = array();
$loggedOut = true;
}

$log = (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') ? 'Kirjaudu ulos' : 'Kirjaudu';

$user = (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') ? $_SESSION['LoggedIn'] : '';

$stmt = $db->prepare("SELECT fname, user_id FROM users WHERE username LIKE '${user}';");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$enimi = $row['fname'];
$user_id = $row['user_id'];

echo "<div id='nav_a'>";
echo '<a href="tuotteet.php" id="navLink">Tuotteet</a>';
if($log == 'Kirjaudu ulos') echo"<a href='ostoskori.php' id='navLink'>Ostoskori</a><a href='pelit.php' id='navLink'>Pelikirjastoni</a><a href='lisaa-rahaa.php' id='navLink'>Lisää rahaa</a><a href='vaihda-salasana.php' id='navLink'>Vaihda salasana</a>";
if($log == 'Kirjaudu ulos' && $_SESSION['isAdmin'] == true) echo "<a href='uusi-tuote.php' id='navLink'>Uusi tuote</a><a href='uusi-kayttaja.php' id='navLink'>Uusi käyttäjä</a>";
if($log == 'Kirjaudu ulos' && $_SESSION['manufacturer_uid'] != '' &&
  isset($_SESSION['manufacturer_uid'])) echo "<a href='tuottamani-pelit.php' id='navLink'>Tuottamani pelit</a><a href='tuottaja-lisaa-peli.php' id='navLink'>Lisää peli</a>";

echo "</div>";


$kirjauduBtn = <<<LOGIN
<form action='kirjaudu.php' method='post' id='kirjauduForm'>
<input type='submit' value='{$log}' name='kirjauduBtn' class='bigBtn'>
</form>
LOGIN;
echo $kirjauduBtn;

# End of nav
echo "</div>\n<div id='container'>\n";

echo "<h2 style='padding-top:20px;'>Tervetuloa {$enimi}</h2>";
?>
<form action="tuotteet.php" method="post" style="float:right; margin-top:30px;" class="upperForm">
<input type="text" name="hakuehto" placeholder="Haku">
<input type="submit" name="hakuBtn" value="Hae verkkokaupasta" class='bigBtn' style='width:160px;'>
</form>


<?php if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') {

$smtp = $db->prepare("SELECT balance FROM users WHERE username LIKE '{$_SESSION['LoggedIn']}'");
$smtp->execute();

$row = $smtp->fetch(PDO::FETCH_ASSOC);
$rahamaara = $row['balance'];

if (isset($rahaaPoistettu)) echo $rahaaPoistettu;

if (isset($_POST['lisaaBtn']) && $_POST['lisatty'] != '' && floatval($_POST['lisatty']) >= 0 && (float) $_POST['lisatty'] < 1000000) {

$moar = isset($_POST['lisatty']) ? $_POST['lisatty'] : '';

$stmt = $db->prepare("UPDATE users SET balance=balance+{$moar} WHERE username LIKE '{$_SESSION['LoggedIn']}';");
$stmt->execute();

$rahamaara += $moar;
$moar_str = number_format($moar, 2, ',', '');
echo "<p><b>{$moar_str}€ lisätty tilille!</b></p>";

}

elseif (floatval($_POST['lisatty']) < 0) echo "<p><b>Et voi lisätä miinusmäärää rahaa!</b></p>";
elseif ((float) $_POST['lisatty'] >= 1000000) echo "<p><b>Ei sul oo nui paljoo!</b></p>";

if (isset($_POST['maksaBtn'])) {

$less = isset($_POST['maksettava']) ? $_POST['maksettava'] : '';

# Testataan onko käyttäjällä rahaa
$testBalance = $db->prepare("SELECT balance FROM users WHERE username LIKE '{$_SESSION['LoggedIn']}';");
$testBalance->execute();

$row = $testBalance->fetch(PDO::FETCH_ASSOC);

if($row['balance']-$less >= 0) {

# Vähennä rahamäärä käyttäjältä
$stmt = $db->prepare("UPDATE users SET balance=balance-{$less} WHERE username LIKE '{$_SESSION['LoggedIn']}';");
$stmt->execute();

# Lisää tuotteet käyttäjän kirjastoon
foreach($_SESSION['ostoskori'] as $peli) { 

$stmt = $db->prepare("SELECT * FROM products WHERE product_type like 'Peli' AND product_name like '{$peli}';");
$stmt->execute();

if ($stmt->fetch(PDO::FETCH_ASSOC) != NULL) {
$sql = <<<SQLEND
INSERT INTO userLibrary (game_name, fk_user_id)
VALUES (:peli, :user_id)
SQLEND;

$stmt = $db->prepare($sql);
$stmt->bindValue(":peli", $peli);
$stmt->bindValue(":user_id", $user_id);
$stmt->execute();
}
}

$rahamaara -= $less;

$_SESSION['ostoskori'] = array();

if ($less != 0) {
  $less_str = number_format($less, 2, ',', '');
  $lessEcho = "<p><b>{$less_str}€ vähennetty tililtä!</b></p>";
$maksettu = true;

}

}

else echo "<p><b>LOOL ei oo rahee</b></p>";

}

# Näytetään vain 2 desimaalia rahamäärästä
$rahaEcho = number_format((float)$rahamaara, 2, ',', '');
echo "<p style='margin:15px;'>Rahaa tilillä: <b>{$rahaEcho}€</b></p>";
}
