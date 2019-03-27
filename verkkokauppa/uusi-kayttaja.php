<?php

require_once('../../db-php/db-init2.php');

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
    <p id='leftmargin' style='text-align:left;'>Luo uusi käyttäjä</p><form method='post' action='lisaa-kayttaja.php'>
<table border='0' cellpadding='5'>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Käyttäjänimi*</td>
  <td bgcolor='#dddddd'><input type='text' name='username' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Etunimi*</td>
  <td bgcolor='#dddddd'><input type='text' name='fname' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Sukunimi*</td>
  <td bgcolor='#dddddd'><input type='text' name='lname' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Salasana*</td>
  <td bgcolor='#dddddd'><input type='password' name='passwd' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Syntymäpäivä*</td>
  <td bgcolor='#dddddd'><input type='text' name='bday' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Kotiosoite</td>
  <td bgcolor='#dddddd'><input type='text' name='address' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Postinumero</td>
  <td bgcolor='#dddddd'><input type='text' name='post' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Maakoodi (FI)</td>
  <td bgcolor='#dddddd'><input type='text' name='country' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Rahamäärä</td>
  <td bgcolor='#dddddd'><input type='text' name='balance' size='30'></td>
</tr>
<tr valign='top'>
  <td align='right' bgcolor='#ffeedd'>Admin? (1/0)</td>
  <td bgcolor='#dddddd'><input type='text' name='isAdmin' size='30'></td>
</tr>
</table>
<input id='leftmargin' type='submit' name='kayttajaBtn' value='Tallenna tiedot' style='float:left'>
<p>Tähdellä (*) merkityt kentät ovat pakollisia</p>
</form>
FORMSEND;
    echo $forms;
}
echo "</table>\n";


?>

