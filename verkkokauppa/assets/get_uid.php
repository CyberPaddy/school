<?php
$get_uid = $db->prepare("SELECT user_id FROM users WHERE username like '{$_SESSION['LoggedIn']}';");
$get_uid->execute();
$got_uid = $get_uid->fetch(PDO::FETCH_ASSOC);
