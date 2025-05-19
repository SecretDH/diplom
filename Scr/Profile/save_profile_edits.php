<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../db.php';

header('Content-Type: application/json');

try {
    // Получаем данные из POST (JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        throw new Exception('Нет данных');
    }

    $user_id = $data['user_id'] ?? null;
    $name = $data['name'] ?? '';
    $login = $data['login'] ?? '';
    $email = $data['email'] ?? '';
    $description = $data['description'] ?? '';
    $avatar = $data['avatar'] ?? '';
    $background_image = $data['background_image'] ?? '';
    $password = $data['password'] ?? '';
    $new_password = $data['new_password'] ?? '';
    $repeat_password = $data['repeat_password'] ?? '';

    if (!$user_id) {
        throw new Exception('user_id не передан');
    }

    // --- Сохраняем аватар, если это base64 ---
    if (strpos($avatar, 'data:image/') === 0) {
        $avatar_folder = __DIR__ . '/../../Avatars/';
        if (!is_dir($avatar_folder)) {
            mkdir($avatar_folder, 0777, true);
        }
        $avatar_name = 'user_' . $user_id . '_' . time() . '.png';
        $avatar_path = $avatar_folder . $avatar_name;
        $avatar_url = '../../Avatars/' . $avatar_name;

        $avatar_data = explode(',', $avatar);
        $decoded_data = base64_decode($avatar_data[1]);
        file_put_contents($avatar_path, $decoded_data);

        $avatar = $avatar_url; // относительный путь для БД
    }

    // --- Сохраняем фон, если это base64 ---
    if (strpos($background_image, 'data:image/') === 0) {
        $bg_folder = __DIR__ . '/../../Backgrounds/';
        if (!is_dir($bg_folder)) {
            mkdir($bg_folder, 0777, true);
        }
        $bg_name = 'bg_' . $user_id . '_' . time() . '.png';
        $bg_path = $bg_folder . $bg_name;
        $bg_url = '../../Backgrounds/' . $bg_name;

        $bg_data = explode(',', $background_image);
        $bg_decoded = base64_decode($bg_data[1]);
        file_put_contents($bg_path, $bg_decoded);

        $background_image = $bg_url; // относительный путь для БД
    }

    // Обновляем основные поля
    $stmt = $conn->prepare("UPDATE users SET name=?, login=?, email=?, description=?, avatar=?, background_image=? WHERE ID=?");
    if (!$stmt) {
        throw new Exception('Ошибка подготовки запроса: ' . $conn->error);
    }
    $stmt->bind_param("ssssssi", $name, $login, $email, $description, $avatar, $background_image, $user_id);
    if (!$stmt->execute()) {
        throw new Exception('Ошибка выполнения запроса: ' . $stmt->error);
    }
    $stmt->close();

    // Если нужно сменить пароль
    if (!empty($new_password) && !empty($repeat_password)) {
        if ($new_password !== $repeat_password) {
            echo json_encode(['success' => false, 'message' => 'Пароли не совпадают']);
            exit;
        }
        // Получаем текущий хэш пароля
        $stmt = $conn->prepare("SELECT password FROM users WHERE ID=?");
        if (!$stmt) {
            throw new Exception('Ошибка подготовки запроса (select password): ' . $conn->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        if (!$hashed_password) {
            throw new Exception('Пользователь не найден');
        }

        if (!password_verify($password, $hashed_password)) {
            echo json_encode(['success' => false, 'message' => 'Текущий пароль неверный']);
            exit;
        }

        // Обновляем пароль
        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE ID=?");
        if (!$stmt) {
            throw new Exception('Ошибка подготовки запроса (update password): ' . $conn->error);
        }
        $stmt->bind_param("si", $new_hashed, $user_id);
        if (!$stmt->execute()) {
            throw new Exception('Ошибка выполнения запроса (update password): ' . $stmt->error);
        }
        $stmt->close();
    }

    echo json_encode(['success' => true, 'avatar_path' => $avatar, 'background_path' => $background_image]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>