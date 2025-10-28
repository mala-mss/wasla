<?php
session_start();
include "../includes/databaseConnection.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../auth/LoginS.php");
    exit;
}

if (!isset($_GET['lesson_id'])) {
    echo "<script>alert('No lesson ID provided.');</script>";
    exit;
}

$lesson_id = $_GET['lesson_id'];
$sql = "SELECT lesson.*, subject.name_sub FROM lesson 
        JOIN subject ON lesson.id_sub = subject.id_sub 
        WHERE lesson.id_lsn = '$lesson_id'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $lesson = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('Lesson not found.');</script>";
    exit;
}

// Get attachments
$att_sql = "SELECT * FROM attachment WHERE id_lsn = '$lesson_id'";
$att_result = mysqli_query($link, $att_sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($lesson['title_lsn']) ?></title>
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
        <a href="lessons.php?id_sub=<?= $lesson['id_sub'] ?>">العودة للدروس</a>
        <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
        <a href="../auth/Logout.php" class="btn login-btn">تسجيل الخروج</a>
    </div>
</header>

<div class="content">
    <div class="container-row">
        <div class="a">
            <h1><?= htmlspecialchars($lesson['title_lsn']) ?></h1>
            <p><strong>المادة:</strong> <?= htmlspecialchars($lesson['name_sub']) ?></p>
            
            <?php if (!empty($lesson['desc'])): ?>
                <div class="lesson-description">
                    <h3>وصف الدرس:</h3>
                    <p><?= htmlspecialchars($lesson['desc']) ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($lesson['support'])): ?>
                <div class="lesson-video">
                    <h3>فيديو الدرس:</h3>
                    <?php
                    $video_url = $lesson['support'];
                    if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                        // Convert YouTube URL to embed format
                        if (strpos($video_url, 'youtu.be') !== false) {
                            $video_id = substr($video_url, strrpos($video_url, '/') + 1);
                        } else {
                            parse_str(parse_url($video_url, PHP_URL_QUERY), $params);
                            $video_id = $params['v'] ?? '';
                        }
                        if ($video_id) {
                            echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe>';
                        } else {
                            echo '<a href="' . htmlspecialchars($video_url) . '" target="_blank">مشاهدة الفيديو</a>';
                        }
                    } else {
                        echo '<a href="' . htmlspecialchars($video_url) . '" target="_blank">مشاهدة الفيديو</a>';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php if (mysqli_num_rows($att_result) > 0): ?>
                <div class="lesson-attachments">
                    <h3>المرفقات:</h3>
                    <ul>
                    <?php while ($attachment = mysqli_fetch_assoc($att_result)): ?>
                        <li>
                            <a href="../teacherZone/<?= htmlspecialchars($attachment['file_att']) ?>" target="_blank">
                                تحميل الملف
                            </a>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="lesson-quiz">
                <h3>الاختبارات:</h3>
                <?php
                $quiz_sql = "SELECT * FROM quiz WHERE id_lsn = '$lesson_id'";
                $quiz_result = mysqli_query($link, $quiz_sql);
                
                if (mysqli_num_rows($quiz_result) > 0) {
                    echo '<a href="quiz.php?lesson_id=' . $lesson_id . '" class="btn">بدء الاختبار</a>';
                } else {
                    echo '<p>لا توجد اختبارات متاحة لهذا الدرس.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>

