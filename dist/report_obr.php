<?php
session_start();

header('Content-type: text/html; charset=utf-8'); 
require_once('db.php');
//print_r($_POST);
//print_r($_SESSION);
 
$headreport = htmlspecialchars(trim($_POST["headreport"]));
$textreport = htmlspecialchars(trim($_POST["textreport"]));
$name = htmlspecialchars(trim($_SESSION["name"]));
$date = time();
 
global $mysqli;

if (empty($name) or empty($headreport) or empty($textreport) or empty($date)) {
  exit("Не все поля  заполнены !!!");
 }

$result = $mysqli->query("INSERT INTO `report`(`wall_title`, `date`, `name_report`, `text`) VALUES ('$headreport', '$date', '$name', '$textreport')");

if (!$result) {
  exit("Не удалось добавить пользователя");
}

exit("ok");

?>