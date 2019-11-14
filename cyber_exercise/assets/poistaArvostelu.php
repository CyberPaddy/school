<?php

$testaaArvostelu = $mysqli->query("SELECT * from userLibrary where fk_user_id = {$fkUserId} AND game_name = '{$poistettava}';");

$onko_arvosteltu = $testaaArvostelu->fetch_assoc();

# Jos käyttäjä on arvostellut tuotteen aikaisemmin poistetaan se products taulusta
if ($onko_arvosteltu != NULL && $onko_arvosteltu['rating'] != 0) {
  $poistaArvostelu = $mysqli->query("UPDATE products SET rating = (rating * ratings_amount - {$onko_arvosteltu['rating']}) / (ratings_amount - 1), ratings_amount = ratings_amount - 1 WHERE product_name LIKE '{$onko_arvosteltu['game_name']}';");
}
