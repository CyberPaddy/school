<?php

$testaaArvostelu = $db->prepare("SELECT * from userLibrary where fk_user_id = {$fkUserId} AND game_name = '{$poistettava}';");
$testaaArvostelu->execute();

$onko_arvosteltu = $testaaArvostelu->fetch(PDO::FETCH_ASSOC);

# Jos käyttäjä on arvostellut tuotteen aikaisemmin poistetaan se products taulusta
if ($onko_arvosteltu != NULL && $_GET['rating'] > 0 && $_GET['rating'] <= 5) {
  echo $onko_arvosteltu['rating'];
  $poistaArvostelu = $db->prepare("UPDATE products SET rating = (rating * ratings_amount - {$onko_arvosteltu['rating']}) / (ratings_amount - 1), ratings_amount = ratings_amount - 1 WHERE product_name LIKE '{$onko_arvosteltu['game_name']}';");
  $poistaArvostelu->execute();
}
