<?php
session_start();

header('Content-type: text/html; charset=utf-8'); 
require_once('db.php');

$mail = trim($_POST["mail"]);
$name = trim($_POST["name"]);
$pass = trim($_POST["pass"]);
$passrepeat = trim($_POST["passrepeat"]);
 
$mail = htmlspecialchars($mail);
$name = htmlspecialchars($name);
$pass = htmlspecialchars($pass);
$passrepeat = htmlspecialchars($passrepeat);

if (empty($mail)) {
  exit("Не заполнен адрес !!!");
}
if (empty($name)) {
  exit("Не заполнено имя пользователя !!!");
}
if (empty($pass)) {
  exit("Вы забыли пароль ???");
}
if (empty($passrepeat)) {
  exit("Пароль повторите, если вспомнили !!!");
}


if ((mb_strlen($name) < 3 or mb_strlen($name) > 32)
    or (mb_strlen($pass) < 2 or mb_strlen($pass) > 16)) {
    exit("Слишком длинные/короткие логин или пароль");
  }

if ($pass != $passrepeat) {
    exit ("!!! Пароли не совпадают !!!");
}

global $mysqli;

$result = $mysqli->query("INSERT INTO `the_wall`(`mail`, `name`, `pass`) VALUES ('$mail', '$name', '$pass')");

if (!$result) {
  exit("Не удалось добавить пользователя");
}
exit("ok");

?>

