<?php 
session_start();
include "../includes/databaseConnection.php";

// --- Validate id_lvl ---
if (!isset($_GET['id_lvl']) || empty($_GET['id_lvl'])) {
    echo "<script>alert('No level ID provided.');</script>";
    exit;
}

$id_lvl = $_GET['id_lvl'];
$username = $_SESSION['username'] ?? 'Admin';

// --- Fetch level details ---
$sql2 = "SELECT * FROM level WHERE id_lvl = '$id_lvl'";
$result2 = mysqli_query($link, $sql2);
if ($row2 = mysqli_fetch_assoc($result2)) {
    $_SESSION['id_lvl'] = $id_lvl;
    $_SESSION['level_title'] = $row2['name_lvl'];
} else {
    echo "<script>alert('No level found with the given ID.');</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../wasla_style/css/dashboard.css">


</head>
<body>
<header class="main_header">
    <div class="logo_container">
      <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
      <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">

    <a href="Logout.php" class="btn register-btn">تسجيل الخروج</a>
   </div>
</header>

<div class="content">
    <div class="header">
        <h2>مرحبا , <?= htmlspecialchars($username) ?></h2>
    </div>

    <br><br>

    <div class="cardb">
        <h1> المواد التي تُدرَّس في الصف <?= htmlspecialchars($_SESSION['level_title']) ?></h1>

        <?php
        // Fetch all subjects in this level
        $query = "SELECT * from subject WHERE id_sub = '$id_lvl '";
                 
                  
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
            
            while ($row = mysqli_fetch_assoc($result)) {

                
                $id_sub = $row['id_sub'];
                $subject_title = $row['name_sub'];
                $id_sub=$row['id_sub'];

                echo "<div class='level-item'>";
                echo "<details>";
                echo "<summary><a href='lessons.php?id_sub=" . urlencode($id_sub) . "'>" . htmlspecialchars($subject_title) . "</a></summary>";
                echo "<ul style='margin:1em 0 0 1em;'>";

                // Fetch sub subjects for each subject
                $query3 = "SELECT * FROM subsubject WHERE id_sub = ?";
                $stmt3 = mysqli_prepare($link, $query3);
                mysqli_stmt_bind_param($stmt3, 'i', $id_sub);
                mysqli_stmt_execute($stmt3);
                $result3 = mysqli_stmt_get_result($stmt3);
                if (mysqli_num_rows($result3) > 0) {
                    while ($row3 = mysqli_fetch_assoc($result3)) {
                echo "<li><a href='lessons.php?id_sub=" . urlencode($id_sub) . "'>" . htmlspecialchars($row3['name_subsub']) . "</a></li>";
                    }
                } else {
                    
                }

                echo "</ul>";
                echo "</details>";
                echo "</div>";
            }
        } else {
            echo "<p>لا توجد مواد متوفرة لهذا المستوى.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
