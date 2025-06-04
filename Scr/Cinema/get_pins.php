<?php
//get_pins.php
require __DIR__ . '../../db.php';

$user_id = $_GET['user_id'] ?? null;
$pin_type = $_GET['pin_type'] ?? null;
$related_id = $_GET['related_id'] ?? null;

if (!$user_id) {
    die("<p>Некорректные данные: ID пользователя не передан.</p>");
}

if (!$pin_type || !in_array($pin_type, ['movie', 'series'])) {
    die("<p>Некорректный тип пина.</p>");
}

if (!$related_id) {
    die("<p>Некорректные данные: related_id не передан.</p>");
}

$tableName = $pin_type === 'movie' ? 'pin_movie' : 'pin_series';
$relatedField = $pin_type === 'movie' ? 'movie_id' : 'series_id';

$query = "
    SELECT 
        id AS pin_id, 
        cover AS photo, 
        pin_name AS name, 
        description, 
        created_at, 
        private 
    FROM 
        user_pins 
    WHERE 
        user_id = ?
";

$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$pins = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($pins as $row) {
    $pinId = htmlspecialchars($row['pin_id']);
    $photo = htmlspecialchars($row['photo']);
    $name = htmlspecialchars($row['name']);

    $isAttachedQuery = "
        SELECT COUNT(*) 
        FROM $tableName 
        WHERE pin_id = ? AND $relatedField = ?
    ";
    $isAttachedStmt = $pdo->prepare($isAttachedQuery);
    $isAttachedStmt->execute([$pinId, $related_id]);
    $isAttached = $isAttachedStmt->fetchColumn() > 0;

    $buttonText = $isAttached ? 'UnPin' : 'Pin';

    echo "
    <div class='user_pin' data-pin-id='$pinId'>
        <img src='$photo' alt='$name' class='pin_photo'>
        <p class='pin_name'>$name</p>
        <button class='pin_attach_button' data-pin-id='$pinId' data-pin-type='$pin_type' data-related-id='$related_id'>$buttonText</button>
    </div>";
}
?>