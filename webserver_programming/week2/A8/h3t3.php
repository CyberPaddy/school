<?php session_start(); ?>

  <title>One armed bandit</title>
    <style>
      img {
        width: 25%;
        padding: 10px;
      }
    </style>

<?php

if (isset($_REQUEST['user'])) $_SESSION['user'] = $_REQUEST['user'];
elseif (isset($_SESSION['user'])) ;
else $_SESSION['user'] = "Not logged in";

if (!isset($_SESSION['betSize'])) $_SESSION['betSize'] = 100;

$logged_in = ($_SESSION['user'] != "Not logged in" ? true : false);

// Hard coded usernames and passwords
$users = array("Dog", "Cat", "Parrot");
$passwords = array("Parrot", "Dog", "Cat");

// Money amounts for Kaneli, Sokeri and Pulla
if (!isset($_SESSION['moneys'])) $_SESSION['moneys'] = array(500, 500, 500);

// Random numbers from 1 to 3 to randomly display three images
$num1 = rand(1,3);
$num2 = rand(1,3);
$num3 = rand(1,3);

$login_form = <<<LoginForm
<form method = "get" action = "h3t3.php">
  <h3>Login</h3>
  <input type="text" placeholder="Username" name="user">
  <input type="password" name="password" placeholder="******">
  <input type="submit" name="loginBtn" value="Login">
</form>
LoginForm;

$logout_form = <<<LogoutForm
<form method = "get" action = "h3t3.php">
  <input type="submit" name="logoutBtn" value="Logout">
</form>
LogoutForm;

$play_form = <<<PlayForm
<form method = "get" action = "h3t3.php">
  <input type="submit" name="playBtn" value="Play">
</form>
PlayForm;

$add_funds_form = <<<AddFundsForm
<form method = "get" action = "h3t3.php">
  <h3>Add Funds</h3>
  <input type="text" placeholder="Amount" name="fundAmt">
  <input type="submit" name="fundBtn" value="Add funds">
</form>
AddFundsForm;

$change_bet = <<<ChangeBet
<form method = "get" action = "h3t3.php">
  <h3>Change Bet</h3>
  <input type="text" placeholder="Amount" name="betAmt">
  <input type="submit" name="betBtn" value="Change bet amount">
</form>
ChangeBet;

if (isset($_REQUEST['loginBtn'])) {

  // If user name and password provided are correct, log in
  if (in_array($_REQUEST['user'], $users)) {
    $index = array_search($_REQUEST['user'], $users);
    
    $logged_in = ($_REQUEST['password'] == $passwords[$index] ? true : false);

    if (!$logged_in) echo "Wrong username or password!";
  }

  else {
    echo "Wrong username or password!";
    $logged_in = false;
  }
}

// If Play button is pressed, add 6 times bet if user won and take bet if lose
elseif (isset($_REQUEST['playBtn'])) {
  $index = array_search($_SESSION['user'], $users);

  if ($num1 == $num2 && $num2 == $num3) $_SESSION['moneys'][$index] += $_SESSION['betSize'] * 6;
  else $_SESSION['moneys'][$index] -= $_SESSION['betSize'];

  $logged_in = true;
}

// If Add funds button is pressed add user given amount to users money account (if numeric value is provided)
elseif (isset($_REQUEST['fundBtn'])) {
  $index = array_search($_SESSION['user'], $users);

  if (is_numeric($_REQUEST['fundAmt'])) $_SESSION['moneys'][$index] += $_REQUEST['fundAmt'];
  else echo "Not numeric value";
  $logged_in = true;
}

elseif (isset($_REQUEST['betBtn'])) {
  $index = array_search($_SESSION['user'], $users);

  if (is_numeric($_REQUEST['betAmt'])) $_SESSION['betSize'] = $_REQUEST['betAmt'];
  else echo "Not numeric value";
  $logged_in = true;
}

elseif (isset($_REQUEST['logoutBtn'])) {
  $logged_in = false;

  echo "Logged out!";
}

if (!$logged_in) {
  echo $login_form;
}

// If user logged in
else {
  // Echo how much money user has
  echo "<h2>User: " . $_SESSION['user'];
  echo "<p>" . $_SESSION['user'] . " has " . $_SESSION['moneys'][array_search($_SESSION['user'], $users)] . "$</p>";

  // If play button is pressed
  if (isset($_REQUEST['playBtn'])) {
    echo "<img src='$num1.jpg'>";
    echo "<img src='$num2.jpg'>";
    echo "<img src='$num3.jpg'>";
  }

  // Echo forms
  echo $play_form;
  echo $add_funds_form;
  echo $change_bet;
  echo $logout_form;
}
?>