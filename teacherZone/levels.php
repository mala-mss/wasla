<?php 
session_start();
include "../includes/databaseConnection.php";
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - المعلم</title>
    <link rel="stylesheet" href="../wasla_style/css/dashboard.css">
    <link rel="stylesheet" href="../wasla_style/css/levelstyle.css">
</head>
<body>

      <!-- Header -->
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

    <div class="header">
        <h2>مرحباً، <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></h2>
    </div>

    <main class="main-content">
        <section class="levels-section">
            <h3>اختر المستوى المراد التعديل عليه:</h3>

            <?php
                $query = "SELECT DISTINCT * FROM level";
                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='levels-list'>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='level-item'>";
                        echo "<a href='subjects.php?id_lvl=" . urlencode($row['id_lvl']) . "'>" . htmlspecialchars($row['name_lvl']) . "</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>لا توجد مستويات متاحة حالياً.</p>";
                }
            ?>
        </section>
    </main>

</body>
</html>
