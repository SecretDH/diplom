<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marvel_studio";

$conn = mysqli_connect($servername, $username, $password, $dbname);

try {
    // Создаем подключение к базе данных с использованием PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Устанавливаем режим обработки ошибок
} catch (PDOException $e) {
    // Если подключение не удалось, выводим сообщение об ошибке
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>