<?php session_start(); ?>

<title>Kodinkone X - Verkkokauppa</title>
<meta charset='UTF-8'>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<div id='wrapper'>
<div id='navbar'>
<?php
require_once('../../db-php/vuln-db-init.php');
require_once('testaaKirjautuminen.php');

if ($_POST['kirjauduBtn'] == 'Kirjaudu ulos' && $_SESSION['LoggedIn'] != '') {
$log = 'Kirjaudu ulos';
$_SESSION['LoggedIn'] = '';
$_SESSION['ostoskori'] = array();
$loggedOut = true;
}

$log = (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') ? 'Kirjaudu ulos' : 'Kirjaudu';

$user = (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') ? $_SESSION['LoggedIn'] : '';

$query = $mysqli->query("SELECT fname, user_id FROM users WHERE username LIKE '${user}';");
if ($query) $row = $query->fetch_assoc();
$enimi = $row['fname'];
$user_id = $row['user_id'];

echo "<div id='nav_a'>";
echo '<a href="tuotteet.php" id="navLink">Tuotteet</a>';
if($log == 'Kirjaudu ulos') echo"<a href='ostoskori.php' id='navLink'>Ostoskori</a><a href='tilaukseni.php' id='navLink'>Tilaukseni</a><a href='lisaa-rahaa.php' id='navLink'>Lisää rahaa</a><a href='vaihda-salasana.php' id='navLink'>Vaihda salasana</a>";
if($log == 'Kirjaudu ulos' && $_SESSION['isAdmin'] == true) echo "<a href='uusi-tuote.php' id='navLink'>Uusi tuote</a><a href='uusi-kayttaja.php' id='navLink'>Uusi käyttäjä</a>";
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

$smtp = $mysqli->query("SELECT balance FROM users WHERE username LIKE '{$_SESSION['LoggedIn']}'");

$row = $smtp->fetch_assoc();
$rahamaara = $row['balance'];

if (isset($rahaaPoistettu)) echo $rahaaPoistettu;

if (isset($_POST['lisaaBtn']) && $_POST['lisatty'] != '' && floatval($_POST['lisatty']) >= 0 && (float) $_POST['lisatty'] < 1000000) {

$moar = isset($_POST['lisatty']) ? $_POST['lisatty'] : '';

$stmt = $mysqli->query("UPDATE users SET balance=balance+{$moar} WHERE username LIKE '{$_SESSION['LoggedIn']}';");

$rahamaara += $moar;
$moar_str = number_format($moar, 2, ',', '');
echo "<p><b>{$moar_str}€ lisätty tilille!</b></p>";

}

elseif (floatval($_POST['lisatty']) < 0) echo "<p><b>Et voi lisätä miinusmäärää rahaa!</b><br/>Rahasta pääsee helposti eroon <a href='tuotteet.php'>kuluttamalla sitä</a>!</p>";
elseif ((float) $_POST['lisatty'] >= 1000000) echo "<p><b>Ei sul oo nui paljoo!</b></p>";

if (isset($_POST['maksaBtn'])) {

$less = isset($_POST['maksettava']) ? $_POST['maksettava'] : '';

# Testataan onko käyttäjällä rahaa
$testBalance = $mysqli->query("SELECT balance FROM users WHERE username LIKE '{$_SESSION['LoggedIn']}';");

if ($testBalance) $row = $testBalance->fetch_assoc();

if($row['balance']-$less >= 0) {

# Vähennä rahamäärä käyttäjältä
  $stmt = $mysqli->query("UPDATE users SET balance=(balance-{$less}) WHERE username LIKE '{$_SESSION['LoggedIn']}';");
  date_default_timezone_set("Europe/Helsinki");
  $date_now = date("Y-m-d");

  # Lisää tuotteet käyttäjän kirjastoon
  foreach($_SESSION['ostoskori'] as $tilaus) {
    $stmt = $mysqli->query("INSERT INTO userLibrary (game_name, add_date, fk_user_id) VALUES ('{$tilaus}', '{$date_now}', '{$user_id}')");
    if (!$stmt) echo "Error: " . $mysqli->error;
  }

$rahamaara -= $less;

$_SESSION['ostoskori'] = array();

if ($less != 0) {
  $less_str = number_format($less, 2, ',', '');
  $lessEcho = "<p><b>{$less_str}€ vähennetty tililtä!</b></p>";
$maksettu = true;
}
else $ilmainen = true;

}

else echo "<p><b>LOOL ei oo rahee</b></p>";

}

# Näytetään vain 2 desimaalia rahamäärästä
$rahaEcho = number_format((float)$rahamaara, 2, ',', '');
echo "<p style='margin:15px;'>Rahaa tilillä: <b>{$rahaEcho}€</b></p>";
}
