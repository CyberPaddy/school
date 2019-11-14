<?php
require('../../db-php/vuln-db-init.php');
$get_uid = $mysqli->query("SELECT user_id FROM users WHERE username like '{$_SESSION['LoggedIn']}';");
$got_uid = $get_uid->fetch_assoc();
