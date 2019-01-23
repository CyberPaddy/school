<?php
/// VALMIS

$taustavarit['Keltainen'] = '#ff0';
$taustavarit['Punainen'] = '#f00';
$taustavarit['Sininen'] = '#00f';
$taustavarit['Harmaa'] = '#888';

$tekstivarit['Valkoinen'] = '#fff';
$tekstivarit['Vihreä'] = '#0f0';
$tekstivarit['Musta'] = '#000';

$taustavari = '#fed';
$tekstivari = '#123';

if (isset($_POST['tvari'])) {
    $taustavari = $_POST['tvari'];
}

if (isset($_POST['textvari'])) {
    $tekstivari = $_POST['textvari'];
}

$tyylit = <<<EOTyyli
<style type="text/css">
body  {
    background-color: $taustavari;
    color: $tekstivari;
}

</style>
EOTyyli;

$tausta_optiot = '';

foreach ($taustavarit as $varinimi => $varikoodi) {
    $valittu = '';
    if ($taustavari == $varikoodi) $valittu = 'checked';
    $tausta_optiot .= "<input type='radio' name='tvari' value='$varikoodi' $valittu>$varinimi<br />\n";
}

$teksti_optiot = '';

foreach ($tekstivarit as $varinimi => $varikoodi) {
    $valittu = '';
    if ($tekstivari == $varikoodi) $valittu = 'checked';
    $teksti_optiot .= "<input type='radio' name='textvari' value='$varikoodi' $valittu>$varinimi<br />\n";
}

$lomake = <<<EOLomake
<form method="POST" action="h2t2.php">
<p>Taustaväri:</p>
$tausta_optiot

<p>Tekstiväri:</p>
$teksti_optiot

<input type="submit">
</form>
EOLomake;

echo $tyylit;
echo $lomake;
?>