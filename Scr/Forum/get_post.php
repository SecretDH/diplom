<?php
require __DIR__ . '../../db.php';

// Получаем user_id и поисковый запрос
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : (isset($_GET['user_id']) ? $_GET['user_id'] : null);
$search = isset($_POST['search']) ? trim($_POST['search']) : '';

if (!$user_id) {
    echo '<p class="error-message">Ошибка: ID пользователя не передан. Убедитесь, что user_id передан через URL или AJAX.</p>';
    exit;
}

// Отладочный вывод (скрыт)
echo '<p style="display: none;">Debug: User ID = ' . htmlspecialchars($user_id) . ', Search = ' . htmlspecialchars($search) . '</p>';

// Формируем SQL-запрос
$sql = "
    SELECT 
        forum.*, 
        COALESCE(forum_likes_view.like_count, 0) AS like_count,
        COALESCE(forum_views_view.view_count, 0) AS view_count,
        COALESCE(forum_comments_view.comment_count, 0) AS comment_count,
        COALESCE(forum_reposts_view.repost_count, 0) AS repost_count,
        users.ID AS post_user_id,
        users.name AS user_name,
        users.login AS user_login,
        users.avatar AS user_avatar
    FROM 
        forum
    LEFT JOIN 
        forum_likes_view ON forum.ID = forum_likes_view.post_id
    LEFT JOIN 
        forum_views_view ON forum.ID = forum_views_view.post_id
    LEFT JOIN 
        forum_comments_view ON forum.ID = forum_comments_view.post_id
    LEFT JOIN 
        forum_reposts_view ON forum.ID = forum_reposts_view.post_id
    LEFT JOIN 
        users ON forum.user_id = users.ID
";

// Добавляем условие поиска, если есть
if (!empty($search)) {
    $sql .= " WHERE forum.post_text LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

$sql .= " ORDER BY forum.post_date DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo '<p class="error-message">Ошибка при получении постов: ' . htmlspecialchars(mysqli_error($conn)) . '</p>';
    exit;
}

// Проверяем, есть ли результаты
if (mysqli_num_rows($result) === 0 && !empty($search)) {
    echo '<p class="error-message">Nothing found.</p>';
    mysqli_free_result($result);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $postId = htmlspecialchars($row['ID']);
    $postUserId = htmlspecialchars($row['post_user_id']);
    $userName = htmlspecialchars($row['user_name']);
    $userLogin = htmlspecialchars($row['user_login']);
    $userAvatar = htmlspecialchars($row['user_avatar']);
    $images = json_decode($row['post_image'], true);
    $main_image = !empty($images) ? $images[0] : '';

    // Проверяем, поставлен ли лайк текущим пользователем
    $likeQuery = "SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?";
    $stmt = $pdo->prepare($likeQuery);
    $stmt->execute([$user_id, $postId]);
    $isLiked = $stmt->fetch() ? 'true' : 'false';
    
    $repostQuery = "SELECT 1 FROM reposts WHERE user_id = ? AND post_id = ?";
    $stmt = $pdo->prepare($repostQuery);
    $stmt->execute([$user_id, $postId]);
    $isReposted = $stmt->fetch() ? 'true' : 'false';

    echo '<div class="content_block" data-post-id="' . $postId . '" data-liked="' . $isLiked . '">';
    echo '<img src="' . $userAvatar . '" class="avatar_img">';
    echo '<div class="user_info">';
    echo '<h1 class="user_name">' . ($userName ?: $userLogin) . '</h1>';
    echo '<h2 class="user_login">@' . $userLogin . '</h2>';
    echo '<span class="dot"></span>';
    echo '<h3 class="upload_data">' . date('M d', strtotime($row['post_date'])) . '</h3>';
    echo '<img src="../../Image/union.svg">';
    echo '</div>';
    echo '<span class="post_text_invisible">' . nl2br(htmlspecialchars($row['post_text'])) . '</span>';
    echo '<div class="post_text"></div>';
    echo '<span class="read-more" style="display: none;">Show more</span>';

    if ($main_image) {
        echo '<img src="' . htmlspecialchars($main_image) . '" class="content_image">';
    }

    echo '<div class="post_stat">';
    echo '<div class="stat" id="comment_stat"><img src="../../Image/comment.svg"><span>' . $row['comment_count'] . '</span></div>';
    echo '<div class="stat like_stat" data-post-id="' . $postId . '" data-liked="' . $isLiked . '">';
    echo '<img src="../../Image/like.svg">';
    echo '<span id="like_count_' . $postId . '">' . $row['like_count'] . '</span>';
    echo '</div>';
    echo '<div class="stat repost_stat" data-post-id="' . $postId . '" data-post-user-id="' . $postUserId . '" data-reposted="' . $isReposted . '">';
    echo '<img src="../../Image/repost.svg">';
    echo '<span id="repost_count_' . $postId . '">' . $row['repost_count'] . '</span>';
    echo '</div>';
    echo '<div class="stat" id="view_stat"><img src="../../Image/view.svg"><span>' . $row['view_count'] . '</span></div>';
    echo '<div class="stat" id="save_stat"><img src="../../Image/save.svg"></div>';
    echo '<div class="stat" id="share_stat"><img src="../../Image/share.svg"></div>';
    echo '</div>'; // .post_stat
    echo '</div>'; // .content_block
}

mysqli_free_result($result);
?>