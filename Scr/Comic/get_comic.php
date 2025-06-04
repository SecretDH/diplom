<?php
// get_comic.php
require __DIR__ . '../../db.php';

$sql = "
    SELECT 
        id, 
        image, 
        title
    FROM 
        comics
    ORDER BY 
        create_at DESC
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Ошибка при получении данных: " . mysqli_error($conn);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $comicId = htmlspecialchars($row['id']);
    $comicImage = htmlspecialchars($row['image']);
    $comicTitle = htmlspecialchars($row['title']);

    echo '<div class="comic-item" id="comic_item_' . $comicId . '" data-comic-id="' . $comicId . '">';
    echo '  <img src="../../Comic/' . $comicImage . '" alt="' . $comicTitle . '">';
    echo '</div>';
}
?>
