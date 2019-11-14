<?php
require_once('assets/navbar.php');

# Testataan onko käyttäjä poistamassa tuotteen verkkokaupasta
$poistettava    = isset($_GET['poista'])        ? $_GET['poista']        : '';

if ($poistettava != '') {
	str_replace('%20', ' ', $poistettava);
	$stmt = $db->prepare("DELETE FROM products WHERE product_name like '{$poistettava}';");
	$stmt->execute();
	
        if ($stmt->rowCount() == 1)
	  echo "<p><b>{$poistettava}</b> poistettu verkkokaupasta!</p>";
        elseif ($stmt->rowCount() > 1)
          echo "<p><b>Tuotteita poistettu verkkokaupasta</b></p>";
        else echo "<p><b>Et ole tuottanut peliä nimeltä '$poistettava'</b></p>";
}

if (isset($_SESSION['manufacturer_uid']) && $_SESSION['manufacturer_uid'] != '') {

# Haetaan tuottajan nimi
# $userRow['manufacturer']
require('assets/getManufacturer.php');

if ($userRow['manufacturer'] != NULL)	 $manufacturerName =
  $userRow['manufacturer'];


$get_game_name = $db->prepare("SELECT product_name FROM products WHERE manufacturer like '{$manufacturerName}';");
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
$haePeli = $db->prepare("SELECT product_name, manufacturer, genre, date FROM products WHERE product_name LIKE '{$got_game_name['product_name']}';");

$haePeli->execute();
$peliHaku = $haePeli->fetch(PDO::FETCH_ASSOC);

	 $output = <<<OUTPUTEND
    <tr>
    <td>{$peliHaku['product_name']}</td>
    <td>{$manufacturerName}</td>
    <td>{$peliHaku['genre']}</td>
    <td>{$peliHaku['date']}</td>
    <td><a href='tuottamani-pelit.php?poista={$got_game_name['product_name']}' id='delLink'    onclick='return   uSure("{$got_game_name['product_name']}")'>Poista verkkokaupasta</a></td>
    </tr>
OUTPUTEND;
echo $output;
} while ($got_game_name = $get_game_name->fetch(PDO::FETCH_ASSOC));

echo "</table>\n";
}


else echo "<p>Et ole vielä tuottanut pelejä. <a href='tuottaja-lisaa-peli.php'>Lisää pelejä täältä!</a></p>";


}


?>

<script>
function uSure(peli) {
if (confirm("Poistetaanko " + peli + " verkkokaupasta?")) return true
else return false
}
</script>
