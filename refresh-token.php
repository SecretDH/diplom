<?php
header('Content-Type: application/json');
require 'db.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;

// Получаем токен из GET-параметра
$token = $_GET['token'] ?? '';

if (empty($token)) {
    die(json_encode(["status" => "error", "message" => "Токен не передан"]));
}

try {
    // Декодируем токен (без проверки подписи для упрощения)
    $decoded = json_decode(base64_decode(explode('.', $token)[1]));
    
    // Получаем СВЕЖИЕ данные из БД
    $stmt = $conn->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->bind_param("s", $decoded->username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        die(json_encode(["status" => "error", "message" => "Пользователь не найден"]));
    }

    // Формируем новый токен с АКТУАЛЬНЫМИ данными из БД
    $payload = [
        "user_id" => $user['ID'],
        "username" => $user['login'],
        "name" => $user['name'],
        "email" => $user['email'],
        "avatar" => $user['avatar'],
        "posts" => $user['posts'],
        "followers" => $user['followers'],
        "following" => $user['following'],
        "pin" => $user['pin'],
        "achivments" => $user['achivments'],
        "exp" => time() + 3600 // Обновляем срок действия
    ];
    
    $newToken = JWT::encode($payload, "my_secret_key", 'HS256');

    // Возвращаем новый токен
    echo json_encode([
        'status' => 'success',
        'token' => $newToken,
        'updated_data' => $payload // Для отладки
    ]);

} catch (Exception $e) {
    die(json_encode(["status" => "error", "message" => $e->getMessage()]));
}
?>