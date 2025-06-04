<?php
// login.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../db.php';
require '../../vendor/autoload.php';

use Firebase\JWT\JWT;

header('Content-Type: application/json');

$username = $_POST['fname'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Заполните все поля"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE login = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $payload = [
            "user_id" => $user['ID'],
            "username" => $username,
            "name" => $user['name'],
            "email" => $user['email'],
            "avatar" => $user['avatar'],
            "posts" => $user['posts'],
            "followers" => $user['followers'],
            "following" => $user['following'],
            "pin" => $user['pin'],
            "achivments" => $user['achivments'],
            "exp" => time() + 3600
        ];
        $jwt = JWT::encode($payload, "my_secret_key", 'HS256');
        echo json_encode(["status" => "success", "token" => $jwt]);
    } else {
        echo json_encode(["status" => "error", "message" => "Неверный пароль"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Пользователь не найден"]);
}

$stmt->close();
$conn->close();
?>