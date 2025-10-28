<?php 
session_start();
include "../includes/databaseConnection.php";

if (!isset($_GET['id_lvl'])) {
    echo "<script>alert('No level ID provided.');</script>";
    exit;
}

$level_id = $_GET['id_lvl'];

// Fetch level details
$sql2 = "SELECT * FROM level WHERE id_lvl = '$level_id'";
$result2 = mysqli_query($link, $sql2);
if (mysqli_num_rows($result2) > 0) {
    $row2 = mysqli_fetch_assoc($result2);
    $_SESSION['level_id'] = $level_id;
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

<!-- Sidebar -->
<!-- <div class="sidebar">
    <h4>Admin Panel</h4>
    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="add_category.php"><i class="fas fa-folder-plus"></i> Add Category</a>
    <a href="add_class.php"><i class="fas fa-chalkboard"></i> Add Class</a>
    <a href="add_quiz.php"><i class="fas fa-plus-circle"></i> Add Quiz</a>
    <a href="add_question.php"><i class="fas fa-question-circle"></i> Add Question</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div> -->
      <!-- Header -->
<header class="main_header">
    <div class="logo_container">
      <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
     <a href="levels.php">الصفوف</a>
      <a href="subjects.php">المواد</a>
      <a href="lessons.php">الدروس</a>
      <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
    <a href="../auth/Logout.php" class="btn register-btn">تسجيل الخروج</a>
   </div>
</header>
<!-- Main Content -->
<div class="content">
    <div class="header">
        <h2>مرحبا , <?= $_SESSION['username'] ?? 'Admin' ?></h2>
    </div>
    <br> 
    <br>
    <div class="cardb">
        <h1>المواد التي تُدرَّس في <?= $_SESSION['level_title'] ?? '' ?></h1>

        <?php
        // Fetch categories related to that level
        $query = "SELECT * FROM subject WHERE id_lvl = ".$level_id ;
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class=\'level-item\'>";
                echo "<a href=\'subjects.php?id_sub=" . $row[\'id_sub\'] . "\'>" . $row[\'name_sub\'] . "</a><br>";
                echo "</div>";
            }
        } else {
            echo "<p>No categories available for this level.</p>";
        }
        ?>
    </div>

   


</div>

</body>
</html>
