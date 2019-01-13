<!DOCTYPE html>
<html>
<head>
    <style>
        img {
            width: 25%;
            padding: 10px;
        }
    </style>
</head>
<body>
<?php
$num1 = rand(1,3);
$num2 = rand(1,3);
$num3 = rand(1,3);

echo "<img src='$num1.jpg'>";
echo "<img src='$num2.jpg'>";
echo "<img src='$num3.jpg'>";
?>
</body>
</html>