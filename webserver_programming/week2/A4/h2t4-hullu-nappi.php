<?php
session_start();
?>

<title>Mad button</title>

<?php

// Initialize session variable 'sum'
if(!isset ($_SESSION['sum'])) $_SESSION['sum'] = 0;

// Modify session variable 'sum' every time btn is pressed
if(isset($_REQUEST['btn'])) {
    if ($_SESSION['sum'] < 3) $_SESSION['sum'] += 1;
    else $_SESSION['sum'] = 0;
}

// Modify message shown in text box
switch($_SESSION['sum']) {
    case 1:
        $message = 'Once is enough!';
        break;
    case 2:
        $message = 'Twice is enough!';
        break;
    case 3:
        $message = 'Thrice is enough!';
        break;
    default:
        $message = '';
}

$form = <<<EOform
<form method="get" action="{$_SERVER['PHP_SELF']}">
    <input type="submit" name="btn" value="Push me">
    <input type="text" name="msg" value='$message'>
</form>
EOform;

echo $form;
?>