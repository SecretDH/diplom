<?php
require __DIR__ . '/../db.php'; // Убедитесь, что путь к db.php корректный

// Получаем ID пользователя из URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id <= 0) {
    die("Некорректный ID пользователя.");
}

// Получаем ID пина из URL
$pin_id = isset($_GET['pin_id']) ? intval($_GET['pin_id']) : 0;

if ($pin_id <= 0) {
    die("Некорректный ID пина.");
}

// Добавляем запись в таблицу pin_view
$viewQuery = "
    INSERT INTO pin_view (user_id, pin_id) 
    VALUES (?, ?)
    ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP
";
$viewStmt = mysqli_prepare($conn, $viewQuery);
mysqli_stmt_bind_param($viewStmt, "ii", $user_id, $pin_id);
if (!mysqli_stmt_execute($viewStmt)) {
    die("Ошибка при записи просмотра: " . mysqli_error($conn));
}

// Выполнение SQL-запроса для получения данных из user_pins
$sql = "
    SELECT 
        user_pins.id AS pin_id,
        user_pins.pin_name,
        user_pins.description,
        user_pins.cover AS pin_cover,
        user_pins.created_at,
        user_pins.private,
        COALESCE(pin_views_count.view_count, 0) AS view_count,
        COALESCE(pin_likes_count.like_count, 0) AS like_count
    FROM 
        user_pins
    LEFT JOIN 
        pin_views_count ON user_pins.id = pin_views_count.pin_id
    LEFT JOIN 
        pin_likes_count ON user_pins.id = pin_likes_count.pin_id
    WHERE 
        user_pins.id = ?
";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $pin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Пост с указанным ID не найден.");
}

// Проверяем, поставлен ли лайк текущим пользователем
$likeQuery = "SELECT 1 FROM pin_like WHERE user_id = ? AND pin_id = ?";
$stmt = $pdo->prepare($likeQuery);
$stmt->execute([$user_id, $pin_id]);
$isLiked = $stmt->fetch() ? 'true' : 'false';

$row = mysqli_fetch_assoc($result);

// Вычисляем, сколько времени прошло с момента создания пина
$created_at = new DateTime($row['created_at']);
$now = new DateTime();
$interval = $created_at->diff($now);

if ($interval->y > 0) {
    $timeAgo = $interval->y . ' ' . ($interval->y === 1 ? 'year' : 'years');
} elseif ($interval->m > 0) {
    $timeAgo = $interval->m . ' ' . ($interval->m === 1 ? 'month' : 'months');
} elseif ($interval->d > 0) {
    $timeAgo = $interval->d . ' ' . ($interval->d === 1 ? 'day' : 'days');
} elseif ($interval->h > 0) {
    $timeAgo = $interval->h . ' ' . ($interval->h === 1 ? 'hour' : 'hours');
} elseif ($interval->i > 0) {
    $timeAgo = $interval->i . ' ' . ($interval->i === 1 ? 'minute' : 'minutes');
} else {
    $timeAgo = $interval->s . ' ' . ($interval->s === 1 ? 'second' : 'seconds');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="pin_page.css">
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="pin">
        <div class="pin_info">
            <h1> <?php echo htmlspecialchars($row['pin_name']); ?> </h1>
            <div class="pin_stat">
                <div class="stat like_stat" data-pin-id="<?php echo htmlspecialchars($row['pin_id']); ?>" data-liked="<?php echo $isLiked; ?>">
                    <img src="../../Image/like.svg" alt="Лайк">
                    <span id="like_count_<?php echo htmlspecialchars($row['pin_id']); ?>">
                        <?php echo htmlspecialchars($row['like_count']); ?> 
                    </span>
                </div>
                <div class="stat view_stat" data-pin-id="<?php echo htmlspecialchars($row['pin_id']); ?>">
                    <img src="../../Image/view.svg" alt="Лайк">
                    <span id="like_count_<?php echo htmlspecialchars($row['pin_id']); ?>">
                        <?php echo htmlspecialchars($row['view_count']); ?> 
                    </span>
                </div>
            </div>
            <div class="pin_description">
                <p> <?php echo htmlspecialchars($row['description']); ?> </p>
            </div>
            <div class="pin_created_at">
                <p><?php echo htmlspecialchars($timeAgo); ?> ago</p>
            </div>
        </div>
        <div class="pin_cover">
            <img src="<?php echo htmlspecialchars($row['pin_cover']); ?>" alt="Обложка пина">
        </div>
    </div>
    <?php include 'get_pinned_movie_series.php' ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.like_stat').forEach(div => {
                if (div.getAttribute('data-liked') === 'true') {
                    div.classList.add('liked');
                }

                div.addEventListener('click', function () {
                    console.log("Клик по элементу:", div);
                    const token = localStorage.getItem('token');
                    if (!token) {
                        alert("Пользователь не авторизован.");
                        return;
                    }

                    let user_id;
                    try {
                        const payload = JSON.parse(atob(token.split('.')[1]));
                        user_id = payload.user_id;
                    } catch (e) {
                        console.error("Ошибка декодирования токена:", e);
                        alert("Недействительный токен.");
                        return;
                    }

                    const pin_id = div.getAttribute('data-pin-id');
                    if (!pin_id) {
                        console.error("ID пина не найден.");
                        return;
                    }

                    fetch('pin_like_toggle.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'user_id': user_id,
                            'pin_id': pin_id
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(jsonData => {
                        if (jsonData.status === 'success') {
                            console.log(`Действие: ${jsonData.action}, Новое количество лайков: ${jsonData.new_like_count}`);
                            const likeCountElement = div.querySelector('#like_count_' + pin_id);
                            if (likeCountElement) {
                                likeCountElement.textContent = jsonData.new_like_count;
                            }

                            if (jsonData.action === 'liked') {
                                div.classList.add('liked');
                                div.setAttribute('data-liked', 'true');
                            } else if (jsonData.action === 'unliked') {
                                div.classList.remove('liked');
                                div.setAttribute('data-liked', 'false');
                            }
                        } else {
                            console.error('Ошибка:', jsonData.error);
                        }
                    })
                    .catch(error => console.error('Ошибка:', error));
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.pinned_pin').forEach(pin => {
                pin.addEventListener('click', function () {
                    const pinnedItem = pin.closest('.pinned_item');
                    const relatedId = pinnedItem.getAttribute('data-related-id');
                    const pinType = pinnedItem.getAttribute('data-type');

                    if (!relatedId || !pinType) {
                        console.error("Не удалось определить ID или тип пина.");
                        return;
                    }

                    // Показываем подтверждающее окно
                    const confirmDelete = confirm("Вы уверены, что хотите открепить этот элемент?");
                    if (!confirmDelete) {
                        return; // Если пользователь нажал "Нет", ничего не делаем
                    }

                    // Отправляем запрос на сервер для удаления пина
                    fetch('delete_pinned_item.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'related_id': relatedId,
                            'pin_type': pinType
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Ошибка HTTP: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(jsonData => {
                        if (jsonData.status === 'success') {
                            // Удаляем элемент из DOM
                            pinnedItem.remove();
                            alert("Элемент успешно откреплен.");
                        } else {
                            console.error("Ошибка при удалении:", jsonData.error);
                            alert("Не удалось открепить элемент.");
                        }
                    })
                    .catch(error => {
                        console.error("Ошибка:", error);
                        alert("Произошла ошибка при удалении элемента.");
                    });
                });
            });
        });
    </script>
</body>
</html>