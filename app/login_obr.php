<?php
session_start();

header('Content-type: text/html; charset=utf-8'); 
require_once('db.php');
 
$mail1 = trim($_POST["mail"]);
$pass1 = trim($_POST["pass"]);
 
$mail1 = htmlspecialchars($mail1);
$pass1 = htmlspecialchars($pass1);

if (empty($mail1) or empty($pass1)) {
  exit("Не все поля заполнены !!!");
}

$result = $mysqli->query("SELECT * FROM `the_wall` WHERE `mail`='$mail1'")->fetch_assoc();

if (!isset($result) or ($pass1 !== $result['pass'])) {
  exit("Вход в систему с указанными данными невозможен");
}

$_SESSION['id'] = $result['id'];
$_SESSION['mail'] = $result['mail'];
$_SESSION['name'] = $result['name'];
$_SESSION['pass'] = $result['pass'];

exit("ok");

?>
