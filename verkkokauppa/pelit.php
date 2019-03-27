<?php
require_once('assets/navbar.php');

# Testataan onko käyttäjä poistamassa tuotteen omistamistaan peleistä
$poistettava    = isset($_GET['poista'])        ? $_GET['poista']        : '';

if ($poistettava != '') {
	str_replace('%20', ' ', $poistettava);
	$stmt = $db->prepare("DELETE FROM userLibrary WHERE game_name like '{$poistettava}' AND fk_user_id LIKE '{$user_id}';");
	$stmt->execute();
	
        if ($stmt->rowCount() == 1)
	  echo "<p><b>{$poistettava}</b> poistettu kirjastostasi!</p>";
        elseif ($stmt->rowCount() > 1)
          echo "<p><b>Tuotteita poistettu kirjastosta</b></p>";
        else echo "<p><b>Pelikirjastossasi ei ole tuotetta nimeltä '$poistettava'</b></p>";
}

if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') {

# Haetaan kirjautuneen käyttäjän UID
# $got_uid['user_id']
require('assets/get_uid.php');

if (!empty($got_uid))	 $fkUserId = $got_uid['user_id'];

$get_game_name = $db->prepare("SELECT game_name FROM userLibrary WHERE fk_user_id like '{$fkUserId}';");
$get_game_name->execute();
$got_game_name = $get_game_name->fetch(PDO::FETCH_ASSOC);

if ( !empty($got_game_name)) {

echo "<table id='tuoteTable'>\n";
$output = <<<OUTPUTEND
<tr bgcolor='#ffeedd'>
<td>Peli</td><td>Valmistaja</td><td>Genre</td><td>Päivämäärä</td><td></td>
</tr>
OUTPUTEND;
echo $output;



do {
$haePeli = $db->prepare("SELECT product_name, manufacturer, genre, date FROM products WHERE
product_name LIKE '{$got_game_name['game_name']}';");
$haePeli->execute();
$peliHaku = $haePeli->fetch(PDO::FETCH_ASSOC);

	 $output = <<<OUTPUTEND
    <tr>
    <td>{$peliHaku['product_name']}</td>
    <td>{$peliHaku['manufacturer']}</td>
    <td>{$peliHaku['genre']}</td>
    <td>{$peliHaku['date']}</td>
    <td><a href='pelit.php?poista={$got_game_name['game_name']}' id='delLink' onclick='return uSure()'>Poista</a></td>
    </tr>
OUTPUTEND;
echo $output;
} while ($got_game_name = $get_game_name->fetch(PDO::FETCH_ASSOC));

echo "</table>\n";
}


else echo "<p>Sinulla ei ole vielä pelejä. <a href='tuotteet.php'>Osta pelejä täältä!</a></p>";


}


?>

<script>
function uSure() {
if (confirm("Rahoja ei palauteta!")) return true
else return false
}
</script>
