<!DOCTYPE html>
<?php    

// If submit button is pressed
if(isset($_GET['submitBtn'])) {
    $eur = $_GET['euros'];

    // If provided input is numeric (int or float)
    if (is_numeric($eur)) {
        $mk = $eur * 6;
        $message = "$eur € is equal to $mk mk";
    } else {
        $message = "Please provide numeric amount!";
    }
}

?>
<html>
<head>

</head>
<body>
    <form action="" method="GET">
        <input type="text" name="euros">
        <input type="submit" name="submitBtn" value="Submit">
    </form>

    <?php echo $message?>
</body>
</html>