<?php

# Haetaan tuottajan nimi tuottamani-pelit.php ja tuottaja-lisaa-peli.php varten
$getManufacturerInfo = $db->prepare("SELECT m.manufacturer from manufacturers m INNER JOIN users u ON m.user_id = u.user_id WHERE m.user_id = {$_SESSION['manufacturer_uid']}");
$getManufacturerInfo->execute();
$userRow = $getManufacturerInfo->fetch(PDO::FETCH_ASSOC);
