<?php
require __DIR__ . '../../db.php';

if (!isset($user_id)) {
    echo "Ошибка: ID пользователя не передан.";
    exit;
}

$sql = "
    SELECT 
        forum.ID AS post_id,
        forum.user_id AS post_user_id,
        NULL AS repost_user_id, -- Для постов репосты не применимы
        forum.post_text,
        forum.post_image,
        forum.post_date,
        'post' AS type, -- Указываем тип записи (пост)
        COALESCE(forum_likes_view.like_count, 0) AS like_count,
        COALESCE(forum_views_view.view_count, 0) AS view_count,
        COALESCE(forum_comments_view.comment_count, 0) AS comment_count,
        COALESCE(forum_reposts_view.repost_count, 0) AS repost_count,
        users.name AS user_name,
        users.login AS user_login,
        users.avatar AS user_avatar,
        NULL AS repost_user_name, -- Для постов репосты не применимы
        NULL AS repost_user_login,
        NULL AS repost_user_avatar
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
    WHERE 
        forum.user_id = ?

    UNION ALL

    SELECT 
        forum.ID AS post_id,
        reposts.post_user_id AS post_user_id, -- ID автора оригинального поста
        reposts.user_id AS repost_user_id, -- ID пользователя, который сделал репост
        forum.post_text,
        forum.post_image,
        reposts.created_at AS post_date,
        'repost' AS type, -- Указываем тип записи (репост)
        COALESCE(forum_likes_view.like_count, 0) AS like_count,
        COALESCE(forum_views_view.view_count, 0) AS view_count,
        COALESCE(forum_comments_view.comment_count, 0) AS comment_count,
        COALESCE(forum_reposts_view.repost_count, 0) AS repost_count,
        original_user.name AS user_name, -- Данные об авторе оригинального поста
        original_user.login AS user_login,
        original_user.avatar AS user_avatar,
        repost_user.name AS repost_user_name, -- Данные о пользователе, который сделал репост
        repost_user.login AS repost_user_login,
        repost_user.avatar AS repost_user_avatar
    FROM 
        reposts
    LEFT JOIN 
        forum ON reposts.post_id = forum.ID
    LEFT JOIN 
        forum_likes_view ON forum.ID = forum_likes_view.post_id
    LEFT JOIN 
        forum_views_view ON forum.ID = forum_views_view.post_id
    LEFT JOIN 
        forum_comments_view ON forum.ID = forum_comments_view.post_id
    LEFT JOIN 
        forum_reposts_view ON forum.ID = forum_reposts_view.post_id
    LEFT JOIN 
        users AS original_user ON reposts.post_user_id = original_user.ID -- Автор оригинального поста
    LEFT JOIN 
        users AS repost_user ON reposts.user_id = repost_user.ID -- Пользователь, сделавший репост
    WHERE 
        reposts.user_id = ?

    ORDER BY 
        post_date DESC;
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $user_id, $user_id); // Передаем $user_id дважды: для постов и репостов
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo "Ошибка при получении постов: " . mysqli_error($conn);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $type = $row['type']; // Тип записи: 'post' или 'repost'
    $postId = htmlspecialchars($row['post_id']);
    $userId = htmlspecialchars($row['post_user_id']); // ID автора оригинального поста
    $userName = htmlspecialchars($row['user_name']); // Имя автора оригинального поста
    $userLogin = htmlspecialchars($row['user_login']); // Логин автора оригинального поста
    $userName = !empty($userName) ? $userName : $userLogin;
    $userAvatar = htmlspecialchars($row['user_avatar']); // Аватар автора оригинального поста
    $postDate = htmlspecialchars($row['post_date']);
    $postText = htmlspecialchars($row['post_text']);
    $images = json_decode($row['post_image'], true);
    $main_image = !empty($images) ? $images[0] : '';

    // Если это репост, добавляем данные о пользователе, который сделал репост
    if ($type === 'repost') {
        $repostUserId = htmlspecialchars($row['repost_user_id']);
        $repostUserName = htmlspecialchars($row['repost_user_name']);
        $repostUserLogin = htmlspecialchars($row['repost_user_login']);
        $repostUserName = !empty($repostUserName) ? $repostUserName : $repostUserLogin;
        $repostUserAvatar = htmlspecialchars($row['repost_user_avatar']);
    }

    // Проверяем, поставлен ли лайк текущим пользователем
    $likeQuery = "SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?";
    $stmt = $pdo->prepare($likeQuery);
    $stmt->execute([$user_id, $postId]);
    $isLiked = $stmt->fetch() ? 'true' : 'false';

    // Проверяем, сделан ли репост текущим пользователем
    $repostQuery = "SELECT 1 FROM reposts WHERE user_id = ? AND post_id = ?";
    $stmt = $pdo->prepare($repostQuery);
    $stmt->execute([$user_id, $postId]);
    $isReposted = $stmt->fetch() ? 'true' : 'false';

    // Выводим HTML
    echo '<div class="content_block" data-post-id="' . $postId . '" data-type="' . $type . '" data-user-id="' . $userId . '">';
    echo '<img src="' . $userAvatar . '" class="post_avatar_img">';
    echo '<div class="user_info">';
    echo '<h1 class="user_name">' . $userName . '</h1>';
    echo '<h2 class="user_login">@' . $userLogin . '</h2>';
    echo '<span class="dot"></span>';
    echo '<h3 class="upload_data">' . date('M d', strtotime($postDate)) . '</h3>';
    echo '</div>';
    echo '<span class="post_text_invisible">' . nl2br($postText) . '</span>';
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
    echo '<div class="stat repost_stat" data-post-id="' . $postId . '" data-post-user-id="' . $userId . '" data-reposted="' . $isReposted . '">';
    echo '<img src="../../Image/repost.svg">';
    echo '<span id="repost_count_' . $postId . '">' . $row['repost_count'] . '</span>';
    echo '</div>';
    echo '<div class="stat" id="view_stat"><img src="../../Image/view.svg"><span>' . $row['view_count'] . '</span></div>';
    echo '<div class="stat" id="save_stat"><img src="../../Image/save.svg"></div>';
    echo '<div class="stat" id="share_stat"><img src="../../Image/share.svg"></div>';
    echo '</div>'; // .post_stat
    echo '</div>'; // .content_block
}
?>