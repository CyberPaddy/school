<?php
$weight = $_POST["weight"];

// MWAHA my weight is always 5kg lower than yours
$my_weight = $weight - 5;

echo "Your weight in kilograms: $weight<br />My weight is $my_weight kg. You seem to have weight problems.<br />";
?>
<a href="t1.html">Go back</a>