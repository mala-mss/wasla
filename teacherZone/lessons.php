

<?php
session_start();
include "../includes/databaseConnection.php";

if (!isset($_GET['id_sub'])) {
    echo "<script>alert('No subject ID provided.');</script>";
    exit;
}

$id_sub = $_GET['id_sub'];
$sql = "SELECT * FROM subject WHERE id_sub = '$id_sub'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['id_sub'] = $id_sub;
    $_SESSION['subject_title'] = $row['name_sub'];
} else {
    echo "<script>alert('subject not found.');</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons</title>
    <link rel="stylesheet" href="../wasla_style/css/dashboard.css">
    <link rel="stylesheet" href="../wasla_style/css/lessonstyle.css">
</head>
<body>
    <header class="main_header">
    <div class="logo_container">
        <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
        <a href="levels.php">الصفوف</a>
        <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
        <a href="../auth/Logout.php" class="btn register-btn">تسجيل الخروج</a>
    </div>
</header>

<div class="content">
<div class="container-row">
    <div class="a">
        <h1>دروس مادة <?= $_SESSION['subject_title'] ?? '' ?> </h1>
        <?php
         $query = "SELECT * FROM lesson WHERE id_lsn = '$id_sub'";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "قم بالضغط على العنوان لتعديل الدرس!";
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li> - <a href='editlesson.php?lesson_id=" . $row['id_lsn'] . "'>" . htmlspecialchars($row['title_lsn']) . "</a> - 
                <a href='deletelesson.php?lesson_id=" . $row['id_lsn'] . "'> <img src='./trashcan.svg' alt='delete' style='height:20px ; width:20px'> </a>
                </li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No classes found for this subject</p>";
        }
        ?>
  
<br>
  <a href="addlesson.php">
    <img src="../wasla_style/img/add.svg" alt="add" class="corner-image">
  </a>



    </div>

   

</body>
</html>