<?php

require_once('assets/navbar.php');

if ($maksettu) {
  if ($less != 0) echo "$lessEcho<p><b>Ostokset maksettu!</p></b>";
  echo "<p>Jos ostit pelejä, löydät ne <a href='pelit.php'>pelikirjastostasi</a></p>";
}

# Jos tyhjennyspainiketta on painettu, tyhjennä ostoskori
elseif (isset($_POST['tyhjennaBtn'])) {

 $_SESSION['ostoskori'] = array();
 echo "<p><b>Ostoskori tyhjennetty!</b> <a href='tuotteet.php'>Lisää tuotteita ostoskoriin</a></p>";

}

elseif (!isset($_POST['maksaBtn'])) echo "<p><b><a href='tuotteet.php'>Lisää tuotteita</a> tai mene <a href='ostoskori.php'>ostoskoriin</a></p></b>";

else echo "<p>Maksu epäonnistui</p>";
