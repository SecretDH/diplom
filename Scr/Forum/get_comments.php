<?php
require __DIR__ . '../../db.php';

if (!isset($user_id)) {
    echo "Ошибка: ID пользователя не передан.";
    exit;
}

// Ваш код для получения комментариев
$sql = "
    SELECT 
        comments.*, 
        COALESCE(comments_likes_view.like_count, 0) AS like_count,
        users.name AS user_name,
        users.login AS user_login,
        users.avatar AS user_avatar
    FROM 
        comments
    LEFT JOIN 
        users ON comments.user_id = users.ID
    LEFT JOIN 
        comments_likes_view ON comments.ID = comments_likes_view.comment_id
    WHERE 
        comments.post_id = ?
    ORDER BY 
        comments.ID DESC
";

$post_id = $_GET['post_id'] ?? null;

if (!$post_id) {
    echo "Ошибка: ID поста не передан.";
    exit;
}

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo "Ошибка при получении комментариев: " . mysqli_error($conn);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $commentId = htmlspecialchars($row['ID']);
    $userName = htmlspecialchars($row['user_name']);
    $userLogin = htmlspecialchars($row['user_login']);
    $userAvatar = htmlspecialchars($row['user_avatar']);
    $images = json_decode($row['comment_image'], true);
    $main_image = !empty($images) ? $images[0] : '';

    // Проверяем, поставлен ли лайк текущим пользователем
    $likeQuery = "SELECT 1 FROM comments_likes WHERE user_id = ? AND comment_id = ?";
    $stmt = $pdo->prepare($likeQuery);
    $stmt->execute([$user_id, $commentId]);
    $isLiked = $stmt->fetch() ? 'true' : 'false';

    echo '<div class="comment_feed_block" data-comment-id="' . $commentId . '" data-liked="' . $isLiked . '">';
    echo '<div class="comment_feed_user_info">';
    echo '<img src="' . $userAvatar . '" class="comment_feed_avatar_img">';
    echo '<h1 class="comment_feed_user_name">' . ($userName ?: $userLogin) . '</h1>';
    echo '<h2 class="comment_feed_user_login">@' . $userLogin . '</h2>';
    echo '<span class="comment_feed_dot"></span>';
    echo '<h3 class="comment_feed_upload_data">' . date('M d', strtotime($row['comment_date'])) . '</h3>';
    echo '<img src="../../Image/union.svg" class="comment_feed_union">';
    echo '</div>';
    echo '<span class="comment_feed_text">' . nl2br(htmlspecialchars($row['comment_text'])) . '</span>';

    if ($main_image) {
        echo '<img src="' . htmlspecialchars($main_image) . '" class="comment_feed_content_image">';
    }

    echo '<div class="comment_feed_stat">';
    echo '<div class="comment_stat comment_like_stat" id="comment_like_stat" data-comment-id="' . $commentId . '" data-liked="' . $isLiked . '">';
    echo '<img src="../../Image/like.svg">';
    echo '<span id="comment_feed_like_count_' . $commentId . '">' . $row['like_count'] . '</span>';
    echo '</div>';
    echo '<div class="comment_stat" id="comment_repost_stat"><img src="../../Image/repost.svg"><span>' /*. $row['comment_retweet'] .*/ . 0 . '</span></div>';
    echo '<div class="comment_stat" id="comment_save_stat"><img src="../../Image/save.svg"></div>';
    echo '<div class="comment_stat" id="comment_share_stat"><img src="../../Image/share.svg"></div>';
    echo '</div>'; // .comment_feed_stat
    echo '</div>'; // .comment_feed_block
}
?>