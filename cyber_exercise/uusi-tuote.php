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

teeLomake($stmt);

function teeLomake($stmt) {
    $forms = <<<FORMSEND
    <p id='leftmargin' style='text-align:left;'>Luo uusi tuote</p><form method='post' action='lisaa-tuote.php'>
<table border='0' cellpadding='5'>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Tuotteen nimi*</td>
  <td bgcolor='#dddddd'><input type='text' name='product_name' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Tuotteen tyyppi*</td>
  <td bgcolor='#dddddd'><input type='text' name='product_type' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Valmistuspäivämäärä*<br>(YYYY-MM-DD)</td>
  <td bgcolor='#dddddd'><input type='text' name='date' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Valmistaja*</td>
  <td bgcolor='#dddddd'><input type='text' name='manufacturer' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Hinta*</td>
  <td bgcolor='#dddddd'><input type='text' name='price' size='30'></td>
</tr>
<input type='hidden' name='rating' value='0'></td>
</table>
<input id='leftmargin' type='submit' name='tuoteBtn' value='Tallenna tuote' style='float:left'>
<p>Tähdellä (*) merkityt kentät ovat pakollisia</p>
</form>
FORMSEND;
    echo $forms;
}
echo "</table>\n";
?>

