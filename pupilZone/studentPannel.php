<?php
session_start();
include "../includes/databaseConnection.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../auth/LoginS.php");
    exit;
}

$username = $_SESSION['username'];
$id_ppl = $_SESSION['id_ppl'];

// Get student level
$sql = "SELECT pupil.*, level.name_lvl FROM pupil 
        JOIN level ON pupil.id_lvl = level.id_lvl 
        WHERE pupil.id_ppl = '$id_ppl'";
$result = mysqli_query($link, $sql);
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الطالب</title>
    <link rel="stylesheet" href="../wasla_style/css/dashboard.css">
    <link rel="stylesheet" href="../wasla_style/css/studentPannel.css">
</head>
<body>

<header class="main_header">
    <div class="logo_container">
        <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
        <a href="#">الرئيسية</a>
        <a href="#">المحتوى التعليمي</a>
        <a href="#">الأسئلة الشائعة</a>
        <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
        <a href="../auth/Logout.php" class="btn login-btn">تسجيل الخروج</a>
    </div>
</header>

<div class="content">
    <div class="header">
        <h2>مرحباً، <?= htmlspecialchars($student['name_ppl'] . ' ' . $student['fname_ppl']) ?></h2>
        <p>المستوى: <?= htmlspecialchars($student['name_lvl']) ?></p>
    </div>

    <main class="main-content">
        <section class="subjects-section">
            <h3>المواد الدراسية المتاحة:</h3>

            <?php
            $query = "SELECT * FROM subject WHERE id_lvl = " . $student['id_lvl'];
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "<div class='subjects-list'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='subject-item'>";
                    echo "<a href='lessons.php?id_sub=" . urlencode($row['id_sub']) . "'>" . htmlspecialchars($row['name_sub']) . "</a>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>لا توجد مواد متاحة لمستواك حالياً.</p>";
            }
            ?>
        </section>
    </main>
</div>

</body>
</html>

