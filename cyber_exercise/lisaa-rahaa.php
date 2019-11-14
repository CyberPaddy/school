<?php

require_once('assets/navbar.php');


$form = <<<FORMSEND
<form action='lisaa-rahaa.php' method='post'>
<input type='text' name='lisatty' placeholder='Lisättävä rahamäärä' id='addMoney'>
<input type='submit' name='lisaaBtn' value='Lisää rahaa' class='bigBtn' onclick='return isFloat()'>
</form>
FORMSEND;

echo $form;?>
<p id='errorMsg'></p>
<script>
function isFloat() {
	var x, text;

	x = document.getElementById("addMoney").value;

	if (isNaN(x)) {
	text = "Lisättävä rahamäärä pitää olla numero";
	document.getElementById("errorMsg").innerHTML = text;
	return false;
	}
return true;
}
</script>
