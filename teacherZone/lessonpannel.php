<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wasla";
// Create connection
$link = new mysqli($servername, $username, $password, $dbname);
// Check connection
$lessons_result = mysqli_query($link, "SELECT id_lsn, title_lsn, desc, support FROM lesson");
$lessons = [];
if ($lessons_result) {
    while ($row = mysqli_fetch_assoc($lessons_result)) {
        $lessons[] = $row;
    }
}

// Get selected lesson id
$selected = isset($_GET['id']) ? intval($_GET['id']) : null;

$lesson = null;
$att = [];

if ($selected) {
    // Fetch selected lesson details
    $lesson_result = mysqli_query($link, "SELECT title_lsn, description, support FROM lesson WHERE id_lsn = $selected");
    if ($lesson_result && mysqli_num_rows($lesson_result) > 0) {
        $lesson = mysqli_fetch_assoc($lesson_result);
    }
    // Fetch attachments
    $att_result = mysqli_query($link, "SELECT file_att FROM attachment WHERE id_lsn = $selected");
    if ($att_result) {
        while ($row = mysqli_fetch_assoc($att_result)) {
            $att[] = $row['file_att'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Lesson List</title>
<style>
/* Your styles here */
</style>
</head>
<body>

<h1>Lessons</h1>

<div>
<?php foreach ($lessons as $lessonItem): ?>
    <div class="lesson">
        <a href="?id=<?= $lessonItem['id_lsn'] ?>"><?= htmlspecialchars($lessonItem['title_lsn']) ?></a>
    </div>
<?php endforeach; ?>
</div>

<?php if ($lesson): ?>
<div style="margin-top:20px; border:1px solid #ccc; padding:10px;">
    <h2><?= htmlspecialchars($lesson['title_lsn']) ?></h2>
    <p><?= htmlspecialchars($lesson['description']) ?></p>
    <iframe width="560" height="315" src="<?= htmlspecialchars($lesson['support']) ?>" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
    
    <h3>Attachments</h3>
    <?php if ($att): ?>
        <ul>
            <?php foreach ($att as $file): ?>
                <li><?= htmlspecialchars($file) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No attachments</p>
    <?php endif; ?>
</div>
<?php endif; ?>

</body>
</html>