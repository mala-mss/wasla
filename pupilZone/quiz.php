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

// Get lesson info
$lesson_sql = "SELECT lesson.*, subject.name_sub FROM lesson 
               JOIN subject ON lesson.id_sub = subject.id_sub 
               WHERE lesson.id_lsn = '$lesson_id'";
$lesson_result = mysqli_query($link, $lesson_sql);
$lesson = mysqli_fetch_assoc($lesson_result);

// Get quiz questions
$quiz_sql = "SELECT * FROM quiz WHERE id_lsn = '$lesson_id'";
$quiz_result = mysqli_query($link, $quiz_sql);

if (mysqli_num_rows($quiz_result) == 0) {
    echo "<script>alert('No quiz available for this lesson.'); window.history.back();</script>";
    exit;
}

// Handle quiz submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    $score = 0;
    $total_questions = 0;
    
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question_') === 0) {
            $quiz_id = str_replace('question_', '', $key);
            $selected_option = $value;
            
            // Check if answer is correct
            $check_sql = "SELECT is_true FROM options WHERE id_quiz = '$quiz_id' AND id_opt = '$selected_option'";
            $check_result = mysqli_query($link, $check_sql);
            $option = mysqli_fetch_assoc($check_result);
            
            if ($option && $option['is_true'] == 1) {
                $score++;
            }
            $total_questions++;
        }
    }
    
    $percentage = ($total_questions > 0) ? round(($score / $total_questions) * 100, 2) : 0;
    
    echo "<script>alert('نتيجة الاختبار: $score من $total_questions ($percentage%)');</script>";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار - <?= htmlspecialchars($lesson['title_lsn']) ?></title>
    <link rel="stylesheet" href="../wasla_style/css/dashboard.css">
    <link rel="stylesheet" href="../wasla_style/css/quiz.css">
</head>
<body>

<header class="main_header">
    <div class="logo_container">
        <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
        <a href="studentPannel.php">الرئيسية</a>
        <a href="lessonView.php?lesson_id=<?= $lesson_id ?>">العودة للدرس</a>
        <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
        <a href="../auth/Logout.php" class="btn login-btn">تسجيل الخروج</a>
    </div>
</header>

<div class="content">
    <div class="container-row">
        <div class="a">
            <h1>اختبار درس: <?= htmlspecialchars($lesson['title_lsn']) ?></h1>
            <p><strong>المادة:</strong> <?= htmlspecialchars($lesson['name_sub']) ?></p>
            
            <form method="POST" action="">
                <?php
                $question_number = 1;
                mysqli_data_seek($quiz_result, 0); // Reset result pointer
                
                while ($quiz = mysqli_fetch_assoc($quiz_result)) {
                    echo "<div class='question-block'>";
                    echo "<h3>السؤال $question_number: " . htmlspecialchars($quiz['question']) . "</h3>";
                    
                    // Get options for this question
                    $options_sql = "SELECT * FROM options WHERE id_quiz = " . $quiz['id_quiz'];
                    $options_result = mysqli_query($link, $options_sql);
                    
                    while ($option = mysqli_fetch_assoc($options_result)) {
                        echo "<label class='option-label'>";
                        echo "<input type='radio' name='question_" . $quiz['id_quiz'] . "' value='" . $option['id_opt'] . "' required>";
                        echo htmlspecialchars($option['option']);
                        echo "</label><br>";
                    }
                    
                    echo "</div>";
                    $question_number++;
                }
                ?>
                
                <div class="submit-section">
                    <input type="submit" name="submit_quiz" value="إرسال الإجابات" class="btn">
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

