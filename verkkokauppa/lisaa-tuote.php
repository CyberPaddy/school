<?php

require_once('assets/navbar.php');
require_once('../../db-php/db-init2.php');


$product_name   = isset($_POST['product_name'])  ? $_POST['product_name'] : '';
$product_type    = isset($_POST['product_type'])   ? $_POST['product_type'] : '';
$manufacturer     = isset($_POST['manufacturer'])    ? $_POST['manufacturer'] : '';
$price     = isset($_POST['price'])    ? $_POST['price'] : '';
$rating      = isset($_POST['rating'])     ? $_POST['rating'] : '0';
$genre      = isset($_POST['genre'])     ? $_POST['genre'] : '';
$date      = isset($_POST['date'])     ? $_POST['date'] : '';
$ratings_amount = 0;

if($product_name != '' && $product_type != '' && $manufacturer != '' && $price != '' && $date !=  '' && $_SESSION['LoggedIn'] != '' && ($_SESSION['isAdmin'] == true || $_SESSION['manufacturer_uid'] != '')) {
$sql = <<<SQLEND
INSERT INTO products (product_name, product_type, manufacturer, price, rating, genre, date, ratings_amount)
VALUES (:product_name, :product_type, :manufacturer, :price, :rating, :genre, :date, :ratings_amount)
SQLEND;


$stmt = $db->prepare($sql);
   $stmt->bindValue(":product_name", $product_name, PDO::PARAM_STR);
   $stmt->bindValue(":product_type", $product_type, PDO::PARAM_STR);
   $stmt->bindValue(":manufacturer", $manufacturer, PDO::PARAM_STR);
   $stmt->bindValue(":price", $price, PDO::PARAM_STR);
   $stmt->bindValue(":rating", $rating, PDO::PARAM_STR);
   $stmt->bindValue(":genre", $genre, PDO::PARAM_STR);
   $stmt->bindValue(":date", $date, PDO::PARAM_STR);
   $stmt->bindValue(":ratings_amount", $ratings_amount, PDO::PARAM_INT);
   $stmt->execute();

echo "$product_name lisättiin onnistuneesti";
}

else if ($_SESSION['isAdmin'] == false) echo "Sinulla ei ole oikeuksia tuotteen lisäämiseen!";
else echo "Tuotteen lisääminen epäonnistui";
?>
