<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "test";

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$mysqli->set_charset("utf-8");

if ($mysqli->connect_error) {
 die("Не удалось подключиться к БД ".$mysqli->connect_error);
}