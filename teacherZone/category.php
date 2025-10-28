<?php 
session_start();
include "databaseConnection.php";

// --- Variable Assignments ---
$subject_id = $_GET['subject_id'] ?? null;
$subject_title = '';
$level_title = '';
$id_subsub = '';
$name_subsub = '';
$username = $_SESSION['username'] ?? 'Admin';

if (empty($subject_id)) {
    echo "<script>alert('No subject ID provided.');</script>";
    exit;
}

// Get category and level info
$sql1 = "SELECT s.*, ss.name_subsub , ss.id_subsub
        FROM subject s 
        JOIN subsubject ss ON s.id_sub = ss.id_subsub
        WHERE s.id_sub = '$subject_id'";

$result1 = mysqli_query($link, $sql1);
if (mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $subject_title = $row1['name_sub'];
    $level_title = $row1['level_title'] ?? '';
    $id_subsub = $row1['id_subsub'];
    $name_subsub = $row1['name_subsub'];
    $_SESSION['subject_id'] = $subject_id;
    $_SESSION['subject_title'] = $subject_title;
    $_SESSION['id_subsub'] = $id_subsub;
    $_SESSION['name_subsub'] = $name_subsub;
} else {
    echo "<script>alert('subject not found.');</script>";
    exit;
}
?>

<!-- ... HTML above unchanged ... -->

<div class="cardb">
    <?php
    // Details tag for subject info
    echo "<details>";
    echo "<summary>المادة: " . htmlspecialchars($subject_title) . "</summary>";
    echo "<ul style='margin:1em 0 0 1em;'>";
    echo "<li>المستوى: " . htmlspecialchars($level_title) . "</li>";
    echo "<li>المعرف الفرعي: " . htmlspecialchars($id_subsub) . "</li>";
    echo "<li>اسم الفرع: " . htmlspecialchars($name_subsub) . "</li>";
    echo "</ul>";
    echo "</details>";

    // Classes listing
    $query3 = "SELECT * FROM lesson WHERE subject_id = '$subject_id' ";
    $result3 = mysqli_query($link, $query3);

    if (mysqli_num_rows($result3) > 0) {
        while ($row3 = mysqli_fetch_assoc($result)) {
            echo "<details style='margin-top:1em;'>";
            echo "<summary>الحصة: " . htmlspecialchars($row3['Title']) . "</summary>";
            echo "<ul style='margin:1em 0 0 1em;'>";
            echo "<li>الوصف: " . htmlspecialchars($row3['Description']) . "</li>";
            echo "<li><a href='edit_class.php?class_id=" . $row3['classId'] . "'>تعديل</a></li>";
            echo "</ul>";
            echo "</details>";
        }
    } else {
        echo "<p>No classes found for this subject</p>";
    }
    ?>
</div>
