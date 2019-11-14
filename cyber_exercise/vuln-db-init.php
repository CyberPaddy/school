
<?php

$DB_HOST    = '192.168.200.50';
$DB_USER    = 'root';
$DB_PASS    = '*password*';
$DB_SCHEMA  = 'K9100_1';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_SCHEMA) or die ("Could not connect: " . mysql_error());

?>
