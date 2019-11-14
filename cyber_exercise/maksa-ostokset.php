<?php

require_once('assets/navbar.php');

# Jos ostokset maksoivat jotain
if ($maksettu) {
  if ($less != 0) echo "$lessEcho<p><b>Ostokset maksettu!</b></p>";
}

# Jos ostokset olivat ilmaisia
elseif ($ilmainen) echo "<p>Tuotteet lähetetään sinulle!</p>";

# Jos tyhjennyspainiketta on painettu, tyhjennä ostoskori
elseif (isset($_POST['tyhjennaBtn'])) {

 $_SESSION['ostoskori'] = array();
 echo "<p><b>Ostoskori tyhjennetty!</b> <a href='tuotteet.php'>Lisää tuotteita ostoskoriin</a></p>";

}

# Jos sivulle tultiin muuta kautta kuin ostoskorista
elseif (!isset($_POST['maksaBtn'])) echo "<p><b><a href='tuotteet.php'>Lisää tuotteita</a> tai mene <a href='ostoskori.php'>ostoskoriin</a></p></b>";

else echo "<p>Maksu epäonnistui</p>";
