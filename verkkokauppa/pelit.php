<?php
require_once('assets/navbar.php');

# Testataan onko käyttäjä poistamassa tuotteen omistamistaan peleistä
$poistettava    = isset($_GET['poista'])        ? $_GET['poista']        : '';

if ($poistettava != '') {
	str_replace('%20', ' ', $poistettava);

        # Haetaan käyttäjän user_id
        require("assets/get_uid.php");
        if (!empty($got_uid))  $fkUserId = $got_uid['user_id'];
        
        $hae_poistettavan_tiedot = $db->prepare("SELECT * FROM userLibrary WHERE fk_user_id = {$fkUserId} AND game_name like '{$poistettava}';");
        $hae_poistettavan_tiedot->execute();
        $poistettavan_tiedot = $hae_poistettavan_tiedot->fetch(PDO::FETCH_ASSOC);

        if ($poistettavan_tiedot != NULL) {
        
  # Poistetaan mahdollinen arvostelu myös products taulusta
  require("assets/poistaArvostelu.php");

        # Poistetaan peli
	$stmt = $db->prepare("DELETE FROM userLibrary WHERE game_name like '{$poistettava}' AND fk_user_id LIKE '{$user_id}';");
	$stmt->execute();
	
        if ($stmt->rowCount() == 1)
	  echo "<p><b>{$poistettava}</b> poistettu kirjastostasi!</p>";
        elseif ($stmt->rowCount() > 1)
          echo "<p><b>Tuotteita poistettu kirjastosta</b></p>";
        else echo "<p><b>Pelikirjastossasi ei ole tuotetta nimeltä '$poistettava'</b></p>";
        


        }
}

# Testataan onko käyttäjä arvostellut jonkun pelin
$arvosteltava = isset($_GET['arvostele']) ? $_GET['arvostele'] : '';
$user_rating  = isset($_GET['rating'])    ? $_GET['rating']    : ''; 
if ($arvosteltava != '' && $user_rating != '') {
  require("assets/get_uid.php");
  if (!empty($got_uid))  $fkUserId = $got_uid['user_id'];
require("assets/onkoArvosteltu.php");
  str_replace('%20', ' ', $arvosteltava);
  $stmt = $db->prepare("UPDATE userLibrary SET rating={$user_rating} WHERE fk_user_id = {$fkUserId} AND game_name like '{$arvosteltava}';");
  $stmt->execute();
  
        if ($stmt->rowCount() == 1)
	  echo "<p>Annoit <b>{$arvosteltava}</b> pelille arvosanan
          <b>{$user_rating}</b></p>";
        elseif ($stmt->rowCount() > 1)
          echo "<p><b>Arvostelit pelejä</b></p>";
        else echo "<p><b>Pelikirjastossasi ei ole tuotetta nimeltä '$arvosteltava'</b></p>";

}

if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] != '') {

# Haetaan kirjautuneen käyttäjän UID
# $got_uid['user_id']
require('assets/get_uid.php');

if (!empty($got_uid))	 $fkUserId = $got_uid['user_id'];

$get_game_name = $db->prepare("SELECT game_name, rating FROM userLibrary WHERE fk_user_id like '{$fkUserId}' ORDER BY game_name;");
$get_game_name->execute();
$got_game_name = $get_game_name->fetch(PDO::FETCH_ASSOC);

if ( !empty($got_game_name)) {

echo "<table id='tuoteTable'>\n";
$output = <<<OUTPUTEND
<tr bgcolor='#ffeedd'>
<td>Peli</td><td>Valmistaja</td><td>Genre</td><td>Päivämäärä</td><td>Arvostele</td><td></td>
</tr>
OUTPUTEND;
echo $output;
$index = 0;

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
    <td><div class="stars-outer" onmouseout="resetStars({$index})"><a href="pelit.php?arvostele={$peliHaku['product_name']}&rating=1" onmouseover="updateStars(this.id, {$index})" id="firstA" class="far fa-star"></a><a href="pelit.php?arvostele={$peliHaku['product_name']}&rating=2" id="secondA" onmouseover="updateStars(this.id, {$index})" class="far fa-star"></a><a href="pelit.php?arvostele={$peliHaku['product_name']}&rating=3" id="thirdA" onmouseover="updateStars(this.id, {$index})" class="far fa-star"></a><a href="pelit.php?arvostele={$peliHaku['product_name']}&rating=4" id="fourthA" onmouseover="updateStars(this.id, {$index})" class="far fa-star"></a><a href="pelit.php?arvostele={$peliHaku['product_name']}&rating=5" id="fifthA" onmouseover="updateStars(this.id, {$index})" class="far fa-star"></a>
    <div class="stars-inner"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>{$got_game_name['rating']}</div>
    </div>
    </td>
    <td><a href='pelit.php?poista={$got_game_name['game_name']}' id='delLink' onclick='return uSure()'>Poista</a></td>
    </tr>
OUTPUTEND;
echo $output;

$index += 1;
} while ($got_game_name = $get_game_name->fetch(PDO::FETCH_ASSOC));

echo "</table>\n";
}

else echo "<p>Sinulla ei ole vielä pelejä. <a href='tuotteet.php'>Osta pelejä täältä!</a></p>";
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
