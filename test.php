<?php
/*
Brief:
Crypto exchange that secures it's users data by only storing the
hash of both the username and password
Thereby having no plain text data about the user themselves

Users register, set their username and password and then we save
the hashes of that information
*/
//Bank Transfer.php
session_start()
if(!isset($_SESSION['isAuth']))
    {
    header("location: /")
    }
//Imports a sql object $conn
include("config/sqlsetup.php");
//Let's get the variables
$currentUser = $_POST['curUser'];
$transferUser = $_POST['transferUser'];

$amount = $_POST['amount'];

if($currentUser === $transferUser)
{
header("location: /")
}
$tUHash = sha1($transferUser);
$cUHash = sha1($currentUser);
$stmt = $mysqli->prepare("SELECT balance FROM accounts WHERE username =
?");

$stmt->bind_param("s", $cUHash);
$result = $stmt->execute();
$stmt->close();
//Check user exists
if(count($result) > 1)
{
header("location: /");
}
//Check user has enough money
$cUAmount = $result[0]['balance']
if($cUAmount < $amount)
{
header("location: /");
}
$cUAmount -= $amount;
$stmt = $mysqli->prepare("SELECT balance FROM accounts WHERE username =
?");

$stmt->bind_param("s", $tUHash);
$result = $stmt->execute();

//Check user exists
if(count($result) > 1)
{
header("location: /");
}

$tUAmount = $result[0]['balance'];

$stmt = $mysqli->prepare("UPDATE accounts set balance=? FROM accounts
WHERE username = ?");
$stmt->bind_param("is", $cUAmount, $cUHash);
$stmt->execute();

$stmt = $mysqli->prepare("UPDATE accounts set balance=? FROM accounts
WHERE username = ?");
$stmt->bind_param("is", $tUAmount, $tUHash);
$stmt->execute();

?>