<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <table>
    <?php
        for ($i = 0; $i < 7; $i++) {
            $bg_color = bgColor($i);
            echo "<tr style='background: $bg_color'><td>Row 1</td></tr>";
        }

        function bgColor($rowNum) {
            if ($rowNum % 2 == 0) {
                return "#AAA";
            } else return "#DDD";
        }
    ?>
    </table>
</body>
</html>