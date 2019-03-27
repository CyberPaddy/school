<?php

require_once('assets/navbar.php');

$ostos		= isset($_GET['tuote'])	? $_GET['tuote']	: '';

if ($ostos != '') {
  # Testataan onko GET:lla saatu tuote olemassa
  # TODO: Tämä ei vielä ota huomioon käyttäjän omistamia pelejä
  $testaaTuote = $db->prepare("SELECT * FROM products WHERE product_name like '{$ostos}'");
  $testaaTuote->execute();

  # Jos GET:lla saatu tuote on olemassa lisää se ostoskoriin
  if ($testaaTuote->fetch(PDO::FETCH_ASSOC) != NULL) {
    # Jos ostoskoritaulukkoa ei vielä ole, lisätään se
    if (!isset($_SESSION['ostoskori'])) $_SESSION['ostoskori'] = array();
      array_push($_SESSION['ostoskori'], $ostos);
    }

  else echo "<p>Tuotetta <b>$ostos</b> ei ole olemassa</p>";
}


$hakuehto 	= isset($_POST['hakuehto']) 	? $_POST['hakuehto'] : '';
/*
// Oletuksena aina nouseva järjestys.
if (strpos($hakuehto, 'asc') !== false) $hakuehto = str_replace('asc', 'desc', $hakuehto);
*/

$tuoteryhma = isset($_POST['tuoteryhma']) ? $_POST['tuoteryhma'] : '';

#if ($tuoteryhma == '')
$stmt = listaaTuotteet($db, $hakuehto);

#else
#$stmt = listaaTuoteryhma($db, $hakuehto, $tuoteryhma);

sqlResult2Html($stmt);


function listaaTuotteet($db, $hakuehto) {

# Jos ostoskorissa tuotteita, listataan ne string muodossa 'Doom', 'DarkOrbit' jne.
if (isset($_SESSION['ostoskori']) && !empty($_SESSION['ostoskori']))
$ostoskori_string = "'" . implode("', '", $_SESSION['ostoskori']) . "'";
else $ostoskori_string = "''";

# Haetaan käyttäjän uid $got_uid['user_id']
require('assets/get_uid.php');


# Jos hakuehtoa ei ole määritetty
if ($hakuehto == '') {

  # Hae kaikki tuotteet, jotka ei ole käyttäjän kirjastossa
   $sql = <<<SQLEND
   SELECT *
   FROM products
   WHERE product_name NOT IN (SELECT game_name FROM userLibrary WHERE fk_user_id like '{$got_uid['user_id']}')
   AND (product_name NOT IN ({$ostoskori_string})
   OR product_type NOT LIKE 'Peli')
   ORDER BY product_name
SQLEND;
}

# Jos hakuehto on, hae vain tuotteet, joiden nimessä, valmistajassa, genressä tai tyypissä on kyseinen string
else {
$sql = <<<SQLEND
	SELECT *
	FROM products
        WHERE product_name NOT IN (SELECT game_name FROM userLibrary WHERE fk_user_id like '{$got_uid['user_id']}')
   AND (product_name NOT IN ({$ostoskori_string})
   OR product_type NOT LIKE 'Peli')
	AND 	(product_name 	LIKE '%{$hakuehto}%'
	OR	manufacturer 	LIKE '%{$hakuehto}%'
	OR	genre 		LIKE '%{$hakuehto}%'
	OR	product_type 	LIKE '%{$hakuehto}%')
	ORDER BY product_name
SQLEND;
}

   $stmt = $db->prepare($sql);
   $stmt->execute();
   return $stmt;
}

// Jos tuoteryhmäfiltteröinti on käytössä, listaa vain sen tuoteryhmän tuotteet
# Tämä ei ole vielä toiminnassa
function listaaTuoteryhma($db, $hakuehto, $tuoteryhma) {
$sql = <<<SQLEND
	SELECT *
	FROM products
        WHERE product_name NOT IN (SELECT game_name FROM userLibrary WHERE fk_user_id like '{$got_uid['user_id']}')
   AND (product_name NOT IN ({$ostoskori_string})
   OR product_type NOT LIKE 'Peli')
	AND 	(product_name 	LIKE '%{$hakuehto}%'
	OR	manufacturer 	LIKE '%{$hakuehto}%'
	OR	genre 		LIKE '%{$hakuehto}%'
	OR	product_type 	LIKE '%{$hakuehto}%')
	ORDER BY product_name
SQLEND;
	
	$stmt = $db->prepare($sql);
   $stmt->execute();
   return $stmt;
}

// SQL-kyselyn tulosjoukko HTML-taulukkoon.
function sqlResult2Html($stmt) {

$row_count = $stmt->rowCount();
$col_count  = $stmt->columnCount();

echo "<p>Hakutulokset: " . $row_count. " tuotetta</p>\n";
echo "<table id='tuoteTable'>\n";
$output = <<<OUTPUTEND
<tr bgcolor='#ffeedd'>
<td>Tuote</td><td>Tyyppi</td><td>Valmistaja</td>
<td>Hinta</td><td>Rating (0-5)</td><td>Genre</td><td>Päivämäärä</td><td></td>
</tr>
OUTPUTEND;
echo $output;


$ostoskoriText = (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') ? 'Lisää ostoskoriin' : '';

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

	$price = number_format((float)$row['price'], 2, ',', '');
	$rating = round($row['rating'], 2);	

	# if (!in_array(($row['product_name'].' '), $_SESSION['ostoskori'])) $linkkiText = "<a href='tuotteet.php?tuote={$row['product_name']}' id='addLink'>{$ostoskoriText}</a>";

    $output = <<<OUTPUTEND
    <tr>
    <td>{$row['product_name']}</td>
    <td>{$row['product_type']}</td>
    <td>{$row['manufacturer']}</td>
    <td>{$price}€</td>
    <td>{$rating}</td>
    <td>{$row['genre']}</td>
    <td>{$row['date']}</td>
    <td><a href='tuotteet.php?tuote={$row['product_name']}' id='addLink'>{$ostoskoriText}</a></td>
   </tr>
OUTPUTEND;
    echo $output;
}
echo "</table>\n";

# Jos ostoskorissa ei ole tuotteita kerrotaan, että se on tyhjä
if (!isset ($_SESSION['ostoskori']) || $_SESSION['ostoskori'] == NULL) echo "<p><b>Ostoskori on tyhjä</b></p>";
# Jos ostoskorissa on tuotteita, tulostetaan ne ja kehotetaan menemään ostoskoriin
else echo "<p style='max-width=600px;'>Ostoskorissa olevat tuotteet: '" .  implode("', '", $_SESSION['ostoskori']) . "'. <b><a href='ostoskori.php'>Mene
  ostoskoriin!</a></b></p>";

}

?>
