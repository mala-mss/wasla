<?php
session_start();
include "../includes/databaseConnection.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../auth/LoginS.php");
    exit;
}

if (!isset($_GET['id_sub'])) {
    echo "<script>alert('No subject ID provided.');</script>";
    exit;
}

$id_sub = $_GET['id_sub'];
$sql = "SELECT * FROM subject WHERE id_sub = '$id_sub'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $subject_title = $row['name_sub'];
} else {
    echo "<script>alert('Subject not found.');</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دروس المادة</title>
    <link rel="stylesheet" href="../wasla_style/css/dashboard.css">
    <link rel="stylesheet" href="../wasla_style/css/lessonstyle.css">
</head>
<body>

<header class="main_header">
    <div class="logo_container">
        <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
        <a href="studentPannel.php">الرئيسية</a>
        <a href="#">المحتوى التعليمي</a>
        <a href="#">الأسئلة الشائعة</a>
        <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
        <a href="../auth/Logout.php" class="btn login-btn">تسجيل الخروج</a>
    </div>
</header>

<div class="content">
    <div class="container-row">
        <div class="a">
            <h1>دروس مادة <?= htmlspecialchars($subject_title) ?></h1>
            
            <?php
            $query = "SELECT * FROM lesson WHERE id_sub = '$id_sub'";
            $result = mysqli_query($link, $query);
            
            if (mysqli_num_rows($result) > 0) {
                echo "<ul>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li>";
                    echo "<a href='lessonView.php?lesson_id=" . $row['id_lsn'] . "'>" . htmlspecialchars($row['title_lsn']) . "</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>لا توجد دروس متاحة لهذه المادة حالياً.</p>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>

