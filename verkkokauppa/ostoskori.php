<?php
require_once('assets/navbar.php');

$poistettava 	= isset($_GET['poista'])	? $_GET['poista']	 : '';

if ($poistettava != '') {
foreach ($_SESSION['ostoskori'] as $key => $value)
	if ($value == $poistettava)
		unset($_SESSION['ostoskori'][$key]);
}

$ostoskori 	= (isset($_SESSION['ostoskori']) && sizeOf($_SESSION['ostoskori']) != 0) ? $_SESSION['ostoskori'] : ''; 


$stmt = listaaTuotteet($db, $ostoskori);

sqlResult2Html($stmt);


function listaaTuotteet($db, $ostoskori) {

if ($ostoskori != '') {
$sql = '';
$loopNum = 0;

foreach ($ostoskori as $i => $tuote) {

# Union all jotta voidaan listata duplikaattituotteita
$sql .= "SELECT * FROM products WHERE product_name like '{$tuote}'";
if ($loopNum <  count($ostoskori)-1) $sql .=  " UNION ALL ";
else $sql .= " ORDER BY product_name";

#$sql .= 'SELECT * FROM products WHERE product_name ';
#foreach ($ostoskori as $i => $tuote) {
#
#if ($i == 0) {
# $sql .= "LIKE '{$tuote}'";
#}
#else $sql .= " OR product_name LIKE '{$tuote}'";
#}
#
#$sql .= "ORDER BY product_name";
#
$loopNum += 1;
}
}
else $sql = 'SELECT 1 FROM dual WHERE false';
   $stmt = $db->prepare($sql);
   $stmt->execute();
   return $stmt;
}

// SQL-kyselyn tulosjoukko HTML-taulukkoon.
function sqlResult2Html($stmt) {

echo "<table id='tuoteTable'>\n";
$output = <<<OUTPUTEND
<tr bgcolor='#ffeedd'>
<td>Tuote</td><td>Tyyppi</td><td>Valmistaja</td>
<td>Hinta</td><td>Rating (0-5)</td><td>Genre</td><td>Päivämäärä</td><td></td>
</tr>
OUTPUTEND;
echo $output;

$ostosten_hinta = 0;

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

# Näytetään hinnat aina kahden desimaalin tarkkuudella ja pilkulla erotettuna
$price = number_format((float)$row['price'], 2, ',', '');

$output = <<<OUTPUTEND
    <tr>
    <td>{$row['product_name']}</td>
    <td>{$row['product_type']}</td>
    <td>{$row['manufacturer']}</td>
    <td>{$price}€</td>
    <td>{$row['rating']}</td>
    <td>{$row['genre']}</td>
    <td>{$row['date']}</td>
    <td><a href='ostoskori.php?poista={$row['product_name']}' id='delLink'>Poista</a></td>
   </tr>
OUTPUTEND;
    echo $output;

    $ostosten_hinta = lisaaOstoksenHinta($ostosten_hinta, $row['price']);
    $ostosten_hinta_float_pilkulla = number_format($ostosten_hinta, 2, ',', '');
}
echo "</table>\n";

$maksaBtn = <<<OUTPUT
<form action='maksa-ostokset.php' method='post'>
<input type='hidden' value='{$ostosten_hinta}' name='maksettava'>
<input type='submit' value='Lisää kirjastoosi' name='maksaBtn' class='bigBtn'>
</form>
<form action='maksa-ostokset.php' method='post'>
<input type='submit' value='Tyhjennä ostoskori' name='tyhjennaBtn' class='bigBtn'
style='width:160px;'>
</form>
OUTPUT;

if ($ostosten_hinta != 0 && sizeOf($_SESSION['ostoskori']) != 0) 
{
echo $maksaBtn;
}
elseif (sizeOf($_SESSION['ostoskori']) != 0) {
echo $maksaBtn;

}
else echo "<p>Ostoskori on tyhjä! <a href='tuotteet.php'>Lisää tuotteita ostoskoriisi</a></p>";
}

function lisaaOstoksenHinta($ostosten_hinta, $hinta) {
    return $ostosten_hinta + $hinta;
}

?>
