<!DOCTYPE html>
<html>
<head>

</head>
<body>
<?php
    if (is_numeric($_GET["amount"])) {
        printStars();
    } else {
        echo "No numeric value provided!";
    }

    function printStars() {
        $amount = $_GET["amount"];
        for ($i = 0; $i < $amount; $i++)
        {
           echo "*";
        }
    }
?>

<br /><a href="star_form.html">Give new amount</a>
</body>
</html>