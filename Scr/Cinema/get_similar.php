<?php
require __DIR__ . '/../db.php';
$similar_sql = "
    SELECT 
        movies.id, 
        movies.title, 
        movies.poster, 
        movies.year
    FROM 
        movies
    WHERE 
        movies.id != ?
    ORDER BY 
        RAND()
    LIMIT 6
";
$similar_stmt = mysqli_prepare($conn, $similar_sql);
mysqli_stmt_bind_param($similar_stmt, "i", $id);
mysqli_stmt_execute($similar_stmt);
$similar_result = mysqli_stmt_get_result($similar_stmt);
while ($row = mysqli_fetch_assoc($similar_result)) {
    echo '<a href="movie_series_page.php?movie_id=' . htmlspecialchars($row['id']) . '" class="movie_series_page_link">';
    echo '<div class="similar_item">';
    echo '<img src="../../Image/pin.svg" class="series_pin">';
    echo '<img src="../../Image/eye.svg" class="series_eye">';
    echo '<img src="' . htmlspecialchars($row['poster']) . '" alt="' . htmlspecialchars($row['title']) . '" class="similar_image">';
    echo '<div class="similar_year">' . htmlspecialchars($row['year']) . '</div>';
    echo '<div class="similar_duration">' . htmlspecialchars($data['duration']) . ' minutes</div>';
    echo '</div>';
    echo '</a>';
}
mysqli_stmt_close($similar_stmt);
mysqli_close($conn);
?>