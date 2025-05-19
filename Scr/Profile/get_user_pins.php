<?php
// Подключение к базе данных
require_once '../db.php'; // Убедитесь, что путь к файлу подключения к БД корректен

// Получаем ID пользователя
$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    die("ID пользователя не передан.");
}

// Запрос к таблице user_pins
$sql = "SELECT id, pin_name, description, cover FROM user_pins WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Проверяем, есть ли пины
if ($result->num_rows > 0) {
    // Если пины есть, выводим их
    while ($row = $result->fetch_assoc()) {
        echo '<div class="pin_block" id="' . htmlspecialchars($row['id']) . '">';
        echo '    <div class="pin_img">';
        echo '        <img src="' . htmlspecialchars($row['cover']) . '" class="pin_img">';
        echo '    </div>';
        echo '    <p class="pin_text">' . htmlspecialchars($row['pin_name']) . '</p>';
        echo '</div>';
    }

    // Добавляем контейнер с create_pin.svg
    echo '<div class="create_pin">';
    echo '    <a href="create_pin.php"> <img src="../../Image/create_pin.svg" class="pin_img"> </a>';
    echo '</div>';
} else {
    // Если пинов нет, добавляем контейнер с create_first_pin.svg
    echo '<div class="create_pin">';
    echo '    <a href="create_pin.php"> <img src="../../Image/create_first_pin.svg" class="pin_img"> </a>';
    echo '</div>';
}

// Закрываем соединение с базой данных
$stmt->close();
$conn->close();
?>