<?php
// get_user_pins.php
require_once '../db.php';

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    die("ID пользователя не передан.");
}

$sql = "SELECT id, pin_name, description, cover FROM user_pins WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="pin_block" id="' . htmlspecialchars($row['id']) . '">';
        echo '    <div class="pin_img">';
        echo '        <img src="' . htmlspecialchars($row['cover']) . '" class="pin_img">';
        echo '    </div>';
        echo '    <p class="pin_text">' . htmlspecialchars($row['pin_name']) . '</p>';
        echo '</div>';
    }

    echo '<div class="create_pin">';
    echo '    <a href="create_pin.php"> <img src="../../Image/create_pin.svg" class="pin_img"> </a>';
    echo '</div>';
} else {
    echo '<div class="create_pin">';
    echo '    <a href="create_pin.php"> <img src="../../Image/create_first_pin.svg" class="pin_img"> </a>';
    echo '</div>';
}

$stmt->close();
$conn->close();
?>