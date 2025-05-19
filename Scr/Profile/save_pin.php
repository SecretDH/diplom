<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к базе данных
require_once '../db.php'; // Убедитесь, что путь к файлу подключения к БД корректен
if (!$conn) {
    throw new Exception('Failed to connect to the database.');
}

header('Content-Type: application/json'); // Устанавливаем заголовок JSON

try {
    // Получаем данные из AJAX-запроса
    $data = json_decode(file_get_contents('php://input'), true);

    $pinName = $data['title'] ?? '';
    $description = $data['description'] ?? ''; // Если описание отсутствует, используем пустую строку
    $isPrivate = $data['isPrivate'] ?? 0;
    $image = $data['image'] ?? '';
    $userId = $data['user_id'] ?? null;

    // Проверяем, что все данные заполнены
    if (empty($pinName)) {
        throw new Exception('Title is required.');
    }
    if (empty($description)) {
        throw new Exception('Description is required.');
    }
    if (empty($image)) {
        throw new Exception('Image is required.');
    }
    if (empty($userId)) {
        throw new Exception('User ID is required.');
    }

    // Проверяем, является ли $image путем к изображению по умолчанию
    if ($image === '../../Covers/default_cover.svg') {
        $imagePath = $image; // Используем путь по умолчанию
    } else {
        // Сохраняем изображение на сервере
        $imagePath = '../../Covers/' . uniqid() . '.png';
        $imageData = explode(',', $image)[1];
        if (!file_put_contents($imagePath, base64_decode($imageData))) {
            throw new Exception('Failed to save image.');
        }
    }

    // Вставляем данные в таблицу user_pins
    $stmt = $conn->prepare("INSERT INTO user_pins (user_id, pin_name, description, cover, private, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param('isssi', $userId, $pinName, $description, $imagePath, $isPrivate);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Database error: ' . $stmt->error);
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>