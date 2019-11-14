<?php
require_once('assets/navbar.php');

# Testataan onko käyttäjä poistamassa tuotteen omistamistaan tuotteista
$poistettava    = isset($_GET['poista'])        ? $_GET['poista']        : '';

if ($poistettava != '') {
	str_replace('%20', ' ', $poistettava);

        # Haetaan käyttäjän user_id
        require("assets/get_uid.php");
        if (!empty($got_uid))  $fkUserId = $got_uid['user_id'];
        
        $hae_poistettavan_tiedot = $mysqli->query("SELECT * FROM userLibrary WHERE fk_user_id = {$fkUserId} AND game_name like '{$poistettava}';");
        $poistettavan_tiedot = $hae_poistettavan_tiedot->fetch_assoc();

        if ($poistettavan_tiedot != NULL) {
        
  # Poistetaan mahdollinen arvostelu myös products taulusta
  require("assets/poistaArvostelu.php");

        # Poistetaan tilaus
	$stmt = $mysqli->query("DELETE FROM userLibrary WHERE game_name like '{$poistettava}' AND fk_user_id LIKE '{$user_id}';");
	
        if ($stmt)
	  echo "<p><b>{$poistettava}</b> poistettu kirjastostasi!</p>";
        else echo "<p><b>Et ole tilannut tuotetta nimeltä '$poistettava'</b></p>";
        }
}

# Testataan onko käyttäjä arvostellut jonkun tuotteen
$arvosteltava = isset($_GET['arvostele']) ? $_GET['arvostele'] : '';
$user_rating  = isset($_GET['rating'])    ? $_GET['rating']    : ''; 
if ($arvosteltava != '' && $user_rating != '' && floatval($user_rating) >= 0 && floatval($user_rating) <= 5) {
  require("assets/get_uid.php");
  if (!empty($got_uid))  $fkUserId = $got_uid['user_id'];

# Päivitetään products taulun arvostelut ja lisätään sen arvostelucounttia, jos käyttäjä ei ole sitä vielä arvostellut
require("assets/onkoArvosteltu.php");

  str_replace('%20', ' ', $arvosteltava);
  $stmt = $mysqli->query("UPDATE userLibrary SET rating={$user_rating} WHERE fk_user_id = {$fkUserId} AND game_name = '{$arvosteltava}';");
  
        if ($stmt)
	  echo "<p>Annoit <b>{$arvosteltava}</b> tuotteelle arvosanan <b>{$user_rating}</b></p>";
        else echo "<p><b>Et ole tilannut tuotetta nimeltä '$arvosteltava'</b></p>";

}
elseif (floatval($user_rating) < 0 || floatval($user_rating) > 5)
  echo "<p><b>Virheellinen arvosana!</b><br> Arvosanan tulee olla välillä <b>0-5</b></p>";

if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') {

# Haetaan kirjautuneen käyttäjän UID
# $got_uid['user_id']
require('assets/get_uid.php');

if (!empty($got_uid))	 $fkUserId = $got_uid['user_id'];

$get_order_name = $mysqli->query("SELECT game_name, rating, add_date FROM userLibrary WHERE fk_user_id like '{$fkUserId}' ORDER BY add_date DESC, game_name ASC;");
if ($get_order_name)  $got_order_name = $get_order_name->fetch_assoc();

if ( !empty($got_order_name)) {

echo "<table id='tuoteTable'>\n";
$output = <<<OUTPUTEND
<tr bgcolor='#ffeedd'>
<td>Tuote</td><td>Valmistaja</td><td>Ostopäivä</td><td>Arvostele</td>
</tr>
OUTPUTEND;
echo $output;
$index = 0;

do {
$haeTilaus = $mysqli->query("SELECT product_name, manufacturer FROM products WHERE product_name LIKE '{$got_order_name['game_name']}';");
$tilausHaku = $haeTilaus->fetch_assoc();

	 $output = <<<OUTPUTEND
    <tr>
    <td>{$tilausHaku['product_name']}</td>
    <td>{$tilausHaku['manufacturer']}</td>
    <td>{$got_order_name['add_date']}</td>
    <td><div class="stars-outer" onmouseout="resetStars({$index})"><a href="tilaukseni.php?arvostele={$tilausHaku['product_name']}&rating=1" onmouseover="updateStars(this.id, {$index})" id="firstA" class="far fa-star"></a><a href="tilaukseni.php?arvostele={$tilausHaku['product_name']}&rating=2" id="secondA" onmouseover="updateStars(this.id, {$index})" class="far fa-star"></a><a href="tilaukseni.php?arvostele={$tilausHaku['product_name']}&rating=3" id="thirdA" onmouseover="updateStars(this.id, {$index})" class="far fa-star"></a><a href="tilaukseni.php?arvostele={$tilausHaku['product_name']}&rating=4" id="fourthA" onmouseover="updateStars(this.id, {$index})" class="far fa-star"></a><a href="tilaukseni.php?arvostele={$tilausHaku['product_name']}&rating=5" id="fifthA" onmouseover="updateStars(this.id, {$index})" class="far fa-star"></a>
    <div class="stars-inner"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>{$got_order_name['rating']}</div>
    </div>
    </td>
    </tr>
OUTPUTEND;
echo $output;

$index += 1;
} while ( $got_order_name = mysqli_fetch_array($get_order_name));

echo "</table>\n";
}

else echo "<p>Sinulla ei ole vielä tilauksia. <a href='tuotteet.php'>Osta tuotteita täältä!</a></p>";
}

echo "<script>";
require("assets/drawStars.js");
echo "</script>";
?>

<script>

// Kun käyttäjä vie hiiren arvostelutähtien päälle, näytetään niitä sen tähden mukaan, jonka yllä käyttäjän hiiri on
function updateStars(x, no) {
  
  console.log(document.getElementsByClassName('stars-inner'));
  switch(x) {
    case 'firstA':
      document.getElementsByClassName('stars-inner')[no].style.width = 18;
      break;
    case 'secondA':
      document.getElementsByClassName('stars-inner')[no].style.width = 36;
      break;
    case 'thirdA':
      document.getElementsByClassName('stars-inner')[no].style.width = 54;
      break;
    case 'fourthA':
      document.getElementsByClassName('stars-inner')[no].style.width = 72;
      break;
    case 'fifthA':
      document.getElementsByClassName('stars-inner')[no].style.width = 90;
      break;
  }
}
</script>

<script>

// Kun käyttäjä ottaa hiiren pois arvostelutähtien päältä, laitetaan siihen alkuperäinen määrä tähtiä
function resetStars(no) {
  var ratings = document.getElementsByClassName("stars-inner");
  const maxStars = 5;

  var rating = ratings[no].textContent;

  var starPercentage = (rating / maxStars) * 90;
  ratings[no].style.width = starPercentage;
}
</script>
<script>
function uSure() {
if (confirm("Rahoja ei palauteta!")) return true
else return false
}
</script>
