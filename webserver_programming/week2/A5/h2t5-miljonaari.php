<?php

// Jos nappia on painettu, lasketaan tehtävistä saatavat pisteet yhteen
if(isset($_REQUEST['nappi'])) {
    $summa = 0;
    $summa +=  $_REQUEST['kysymys1'] + $_REQUEST['kysymys3'];

    if(is_array($_REQUEST['kysymys2'])) {
        foreach ($_REQUEST['kysymys2']  as $pisteet) {
            $summa += $pisteet;
        }
    }

    echo "<p>Onneksi olkoon, sait $summa pistettä!</p>";
}


$lomake = <<<EOLomake
<form method="post" action"{$_SERVER['PHP_SELF']}">
    <input type='radio' name='kysymys1' value='1'>Hauki on kala<br />\n
    <input type='radio' name='kysymys1' value='0'>Hauki on lintu<br />\n
    <input type='radio' name='kysymys1' value='0'>Hauki on kissa<br />\n

    <br><br>
    <input type='checkbox' name='kysymys2[]' value='3'>Mega on miljoona<br />\n
    <input type='checkbox' name='kysymys2[]' value='-3'>Giga on miljoona<br />\n
    <input type='checkbox' name='kysymys2[]' value='-3'>Tera on miljoona<br />\n
    <br><br>

    <p>Mitä kirjainlyhenne PHP tarkoittaa puhuttaessa Web-ohjelmoinnista?</p>
    <select name='kysymys3'>
        <option value='0'>Pappa hankkii poran\n
        <option value='7'>PHP: Hypertext preprocessor\n
        <option value='0'>Poika hävisi piikalle\n
    </select>

    <input type="submit" name="nappi" value="submit">
</form>
EOLomake;

echo $lomake;
?>