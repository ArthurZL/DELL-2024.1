<?php

$host = "localhost";
$dbname = "dell";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno){
    die("Erro de conexão: " . $mysqli->connect_errno);
}

return $mysqli;

?>