<?php

require_once('../../db-php/vuln-db-init.php');

require_once('assets/navbar.php');
?>

<style type='text/css'>
tr:nth-child(odd) {background: #f1f1f1}
tr:nth-child(even) {background: #ffffff}
tr:nth-child(1) {background: #ffeedd}
</style>
<?php

require('assets/getManufacturer.php');

if ($userRow != NULL) {
  $manufacturerName = $userRow['manufacturer'];
  teeLomake($manufacturerName);
}

function teeLomake($manufacturerName) {
    $forms = <<<FORMSEND
    <p id='leftmargin' style='text-align:left;'>Lisää uusi peli</p><form method='post' action='lisaa-tuote.php'>
<table border='0' cellpadding='5'>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Pelin tekijä*</td>
  <td bgcolor='#dddddd'><input type='text' name='manufacturer' size='30'
  value='{$manufacturerName}' readonly></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Tuotteen tyyppi*</td>
  <td bgcolor='#dddddd'><input type='text' name='product_type' size='30' value='Peli' readonly></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Pelin nimi*</td>
  <td bgcolor='#dddddd'><input type='text' name='product_name' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Hinta*</td>
  <td bgcolor='#dddddd'><input type='text' name='price' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Julkaisupäivämäärä*</td>
  <td bgcolor='#dddddd'><input type='text' name='date' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Genre</td>
  <td bgcolor='#dddddd'><input type='text' name='genre' size='30'></td>
</tr>
</table>
<input id='leftmargin' type='submit' name='tuoteBtn' value='Tallenna tuote' style='float:left'>
<p>Tähdellä (*) merkityt kentät ovat pakollisia</p>
</form>
FORMSEND;
    echo $forms;
}
echo "</table>\n";


?>

