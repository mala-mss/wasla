<?php
session_start();
include "../includes/databaseConnection.php";

$id_lsn = (int) $_GET['lesson_id'];


$result = mysqli_query($link, "SELECT id_sub FROM lesson WHERE id_lsn = $id_lsn");
$row = mysqli_fetch_assoc($result);
$id_subject = $row['id_sub'];

$quiz_ids = [];
$q_result = mysqli_query($link, "SELECT id_quiz FROM quiz WHERE id_lsn = $id_lsn");
while ($q_row = mysqli_fetch_assoc($q_result)) {
    $quiz_ids[] = $q_row['id_quiz'];
}

if (!empty($quiz_ids)) {
    $quiz_ids_str = implode(',', array_map('intval', $quiz_ids));
    mysqli_query($link, "DELETE FROM options WHERE id_quiz IN ($quiz_ids_str)");
}

mysqli_query($link, "DELETE FROM quiz WHERE id_lsn = $id_lsn");

mysqli_query($link, "DELETE FROM attachment WHERE id_lsn = $id_lsn");

mysqli_query($link, "DELETE FROM lesson WHERE id_lsn = $id_lsn");
?>
<script type="text/javascript">
window.location.href = 'lessons.php?id_sub=<?php echo $id_subject; ?>';
</script>