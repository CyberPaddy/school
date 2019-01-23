<?php
// Muokattu versio autolaskuri-v1.php:sta --> VALMIS

// Pääohjelma

session_start();

$vw_lkm    = isset($_SESSION['vw_lkm']) ? $_SESSION['vw_lkm'] : 0;
$opel_lkm  = isset($_SESSION['opel_lkm']) ? $_SESSION['opel_lkm'] : 0;
$painike   = isset($_POST['painike']) ? $_POST['painike'] : '';

laske_lkm($vw_lkm, $opel_lkm, $painike);
tee_lomake();
nayta_tulokset($vw_lkm, $opel_lkm);

// Alustetaan tai päivitetään autojen lukumääriä:
// Muodolliset parametrit ovat viittauksia, joten
// muutetut arvot välittyvät "takaisin" kutsuvaan
// ohjelmalohkooon
function laske_lkm(&$vw_lkm, &$opel_lkm, $nappi) {
   // Jotakin autonappia painettu, lisätään kertymää
   if ($nappi == "VW") {
      $_SESSION['vw_lkm'] += 1;
      $vw_lkm += 1;
   }
   elseif ($nappi == "Opel") {
      $_SESSION['opel_lkm'] += 1;
      $opel_lkm += 1;
   }
   // Painettiin Nollaa-painiketta tai pyydetään sivua ekaa kertaa
   elseif ($nappi == "Nollaa") {
      $_SESSION['vw_lkm'] = 0;
      $_SESSION['opel_lkm'] = 0;
      $vw_lkm = 0;
      $opel_lkm = 0;
   }
}

function nayta_tulokset($vw_lkm, $opel_lkm) {
   echo "<pre>\n";
   echo "Volkswagenit ... : $vw_lkm kpl.\n";
   echo "Opelit ......... : $opel_lkm kpl.\n";
   echo "</pre>\n";
}

// Tehdään lomake piilokenttineen
function tee_lomake() {
?>
  <title>Autolaskuri</title>
  <h3 style=background-color:#fed;color:#000>Autolaskuri</h3>
   <!--
     Oleellista on pitää yllä _samassa_ lomakkeessa
     kaikkien autojen kertymiä
   -->
   <form method="post" action="<?php echo $_SERVER{'PHP_SELF'}?>">

   <input type="submit" value="VW" name="painike">
   <input type="submit" value="Opel" name="painike">
   <input type="submit" value="Nollaa" name="painike">
   </form>
<?php
}

?>
