<?php
require __DIR__ . '../../db.php';

if (!isset($user_id)) {
    echo "Ошибка: ID пользователя не передан.";
    exit;
}

// Ваш код для получения постов
$sql = "
    SELECT 
        forum.*, 
        COALESCE(forum_likes_view.like_count, 0) AS like_count,
        COALESCE(forum_views_view.view_count, 0) AS view_count,
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
        users ON forum.user_id = users.ID
    ORDER BY 
        forum.post_date DESC
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Ошибка при получении постов: " . mysqli_error($conn);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $postId = htmlspecialchars($row['ID']);
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
    echo '<div class="stat" id="comment_stat"><img src="../../Image/comment.svg"><span>' . $row['post_comment'] . '</span></div>';
    echo '<div class="stat like_stat" data-post-id="' . $postId . '" data-liked="' . $isLiked . '">';
    echo '<img src="../../Image/like.svg">';
    echo '<span id="like_count_' . $postId . '">' . $row['like_count'] . '</span>';
    echo '</div>';
    echo '<div class="stat" id="repost_stat"><img src="../../Image/repost.svg"><span>' . $row['post_retweet'] . '</span></div>';
    echo '<div class="stat" id="view_stat"><img src="../../Image/view.svg"><span>' . $row['view_count'] . '</span></div>';
    echo '<div class="stat" id="save_stat"><img src="../../Image/save.svg"></div>';
    echo '<div class="stat" id="share_stat"><img src="../../Image/share.svg"></div>';
    echo '</div>'; // .post_stat
    echo '</div>'; // .content_block
}
?>