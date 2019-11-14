<?php

$testaaArvostelu = $mysqli->query("SELECT * from userLibrary where fk_user_id = {$fkUserId} AND game_name = '{$arvosteltava}';");

$onko_arvosteltu = $testaaArvostelu->fetch_assoc();

# Jos käyttäjä ei ole arvostellut tuotetta aiemmin, lisätään ratings_amount numeroa ja lasketaan yhteisrating
if ($onko_arvosteltu != NULL && $onko_arvosteltu['rating'] == 0) {
  $lisaaArvostelu = $mysqli->query("UPDATE products SET rating = (rating * ratings_amount + {$user_rating}) / (ratings_amount + 1),ratings_amount = ratings_amount + 1 WHERE product_name LIKE '{$onko_arvosteltu['game_name']}';");
}

# Jos käyttäjä on arvostellut tuotteen aikaisemmin, muokataan vain yhteisratingia
else {
  $lisaaArvostelu = $mysqli->query("UPDATE products SET rating = (rating * ratings_amount + {$user_rating} - {$onko_arvosteltu['rating']}) / (ratings_amount) WHERE product_name LIKE '{$onko_arvosteltu['game_name']}';");
}
