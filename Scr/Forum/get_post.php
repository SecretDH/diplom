<?php
require __DIR__ . '../../db.php';

$sql = "SELECT * FROM forum ORDER BY post_date DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Ошибка при получении постов: " . mysqli_error($conn);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $images = json_decode($row['post_image'], true);
    $main_image = !empty($images) ? $images[0] : '';

    echo '<div class="content_block">';
    echo '<img src="' . htmlspecialchars($row['user_avatar']) . '" class="avatar_img">';
    
    echo '<div class="user_info">';
    echo '<h1 class="user_name">' . htmlspecialchars($row['user_name']) . '</h1>';
    if ($row['user_login']) {
        echo '<h2 class="user_login">@' . htmlspecialchars($row['user_login']) . '</h2>';
    } else {
        echo '<h2 class="user_login">@' . htmlspecialchars($row['user_name']) . '</h2>';
    }
    
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
    echo '<div class="stat" id="like_stat"><img src="../../Image/like.svg"><span>' . $row['post_like'] . '</span></div>';
    echo '<div class="stat" id="repost_stat"><img src="../../Image/repost.svg"><span>' . $row['post_retweet'] . '</span></div>';
    echo '<div class="stat" id="view_stat"><img src="../../Image/view.svg"><span>' . $row['post_view'] . '</span></div>';
    echo '<div class="stat" id="save_stat"><img src="../../Image/save.svg"></div>';
    echo '<div class="stat" id="share_stat"><img src="../../Image/share.svg"></div>';
    echo '</div>';

    echo '</div>'; // .content_block
}
?>