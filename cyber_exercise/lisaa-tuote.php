<?php

require_once('assets/navbar.php');
require_once('../../db-php/vuln-db-init.php');


$product_name   = isset($_POST['product_name'])  ? $_POST['product_name'] : '';
$product_type    = isset($_POST['product_type'])   ? $_POST['product_type'] : '';
$manufacturer     = isset($_POST['manufacturer'])    ? $_POST['manufacturer'] : '';
$price     = isset($_POST['price'])    ? $_POST['price'] : '';
$rating      = isset($_POST['rating'])     ? $_POST['rating'] : '0';
$date      = isset($_POST['date'])     ? $_POST['date'] : '';
$ratings_amount = 0;

if($product_name != '' && $product_type != '' && $manufacturer != '' && $price != '' && $date != '' && $_SESSION['LoggedIn'] != '' && $_SESSION['isAdmin'] == true) {
  $sql = "INSERT INTO products (product_name, product_type, manufacturer, price, rating, date, ratings_amount) VALUES ('$product_name', '$product_type', '$manufacturer', $price, $rating, '$date', $ratings_amount);";

  $stmt = $mysqli->query($sql);

  if ($stmt)  echo "$product_name lisättiin onnistuneesti";
  else echo "Tuotteen lisääminen epäonnistui" . $mysqli->error;
}

else if ($_SESSION['isAdmin'] == false) echo "Sinulla ei ole oikeuksia tuotteen lisäämiseen!";
else echo "Tuotteen lisääminen epäonnistui";
?>
