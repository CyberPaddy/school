<?php

# Haetaan kirjautuneen käyttäjän UID
$getUserId = $db->prepare("SELECT user_id FROM users WHERE username like '{$_SESSION['LoggedIn']}';");
$getUserId->execute();
$gotUserId = $getUserId->fetch(PDO::FETCH_ASSOC);

if ($gotUserId != NULL)  $fkUserId = $gotUserId['user_id'];

$game_name_db = $db->prepare("SELECT DISTINCT game_name FROM userLibrary WHERE fk_user_id like '{$fkUserId}' ORDER BY game_name;");
$game_name_db->execute();
