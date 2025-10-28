<?php
include "../includes/databaseConnection.php";
session_start();

if (!isset($_GET['id_lsn'])) {
    echo "<script>alert('لم يتم توفير معرف الدرس.');</script>";
    exit;
}

$lesson_id = $_GET['id_lsn'];

$sql = "SELECT * FROM lesson WHERE id_lsn = '$lesson_id'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['id_lsn'] = $lesson_id;
    $_SESSION['title_lsn'] = $row['title_lsn'];
} else {
    echo "<script>alert('الدرس غير موجود.');</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    if (isset($_POST['question'], $_POST['options'], $_POST['correctOption']) &&
        is_array($_POST['options']) && count($_POST['options']) > 0) {
        
        $q = mysqli_real_escape_string($link, $_POST['question']);
        $lessonId = $lesson_id;
        $correctIndex = (int)$_POST['correctOption'] - 1;
        $options = $_POST['options'];

        $insertQuiz = "INSERT INTO quiz (question, id_lsn) VALUES ('$q', $lessonId)";
        if (mysqli_query($link, $insertQuiz)) {
            $quizId = mysqli_insert_id($link);

            foreach ($options as $index => $option) {
                $opt = mysqli_real_escape_string($link, $option);
                $isCorrect = ($index === $correctIndex) ? 1 : 0;
                $insertOption = "INSERT INTO options (id_quiz, choice_text, is_true) VALUES ($quizId, '$opt', $isCorrect)";
                mysqli_query($link, $insertOption);
            }

            echo "<script>
                    alert('تمت إضافة السؤال والخيارات بنجاح.');
                    window.location.href='addquiz.php?id_lsn=$lesson_id';
                  </script>";
            exit;
        } else {
            echo "<p>فشل إدخال السؤال. تحقق من الاتصال بقاعدة البيانات.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../wasla_style/css/dashboard.css">
  <link rel="stylesheet" href="../wasla_style/css/addQuiz.css">
  <title>إنشاء سؤال</title>

  <style>
    
  </style>
</head>
<body>
<header class="main_header">
    <div class="logo_container">
        <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
        <a href="levels.php">الصفوف</a>
        <a href="subjects.php">المواد</a>
        <a href="lessons.php?id_sub=<?= $_SESSION['id_sub'] ?>">الدروس</a>
        <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
        <a href="../auth/Logout.php" class="btn register-btn">تسجيل الخروج</a>
    </div>
</header>

<div class="content">
<div class="container-row">
    <div class="me">
        <h2>إضافة سؤال جديد - <?= htmlspecialchars($_SESSION['title_lsn']) ?></h2>
    </div>
</div>
</div>



    <?php
    $quizSql = "SELECT q.id_quiz, q.question FROM quiz q 
                WHERE q.id_lsn = '$lesson_id' 
                ORDER BY q.id_quiz DESC";
    $quizResult = mysqli_query($link, $quizSql);

    if ($quizResult && mysqli_num_rows($quizResult) > 0): ?>
      <div class="quizdisplay">
        <h3>الأسئلة الحالية:</h3>
        <ul>
        <?php while ($quizRow = mysqli_fetch_assoc($quizResult)): ?>
          <li>
            <a href="editQuiz.php?id_quiz=<?= $quizRow["id_quiz"]; ?>">
              <strong><?= htmlspecialchars($quizRow["question"]); ?></strong>
            </a>
            <a href="deletequiz.php?id_quiz=<?= $quizRow["id_quiz"]; ?>">
              <img src="./trashcan.svg" alt="delete" style='height:20px ; width:20px'>
            </a>
            <ul>
              <?php
              $optSql = "SELECT choice_text, is_true FROM options WHERE id_quiz = " . $quizRow["id_quiz"];
              $optResult = mysqli_query($link, $optSql);
              $optNum = 1;
              while ($optRow = mysqli_fetch_assoc($optResult)): ?>
                <li>
                  <?= $optNum++ . ". " . htmlspecialchars($optRow["choice_text"]); ?>
                  <?php if ($optRow["is_true"]): ?>
                    <span style="color:green;">(إجابة صحيحة)</span>
                  <?php endif; ?>
                </li>
              <?php endwhile; ?>
            </ul>
          </li>
        <?php endwhile; ?>
        </ul>
      </div>
    <?php else: ?>
      <div class="quizdisplay">
        <em>لا توجد أسئلة مضافة لهذا الدرس بعد.</em>
      </div>
    <?php endif; ?>

    <form method="POST" class="quiz-form">
      <label for="question">السؤال</label>
      <input type="text" name="question" required>

      <label>الخيارات</label>
      <div id="optionsContainer">
        <div class="option">
          <input type="text" name="options[]" required placeholder="أدخل خياراً">
        </div>
      </div>

      <label for="correctOption">رقم الخيار الصحيح (1, 2, 3, ...)</label>
      <input class="correctOptionInput" type="number" name="correctOption" id="correctOption" min="1" required>

      <div class="button">
        <button type="button" onclick="addOption()">إضافة خيار</button>
        <input class="submit" type="submit" name="submit" value="إرسال">
      </div>
    </form>
  </div>

  <script>
    function addOption() {
      const container = document.getElementById("optionsContainer");
      const newOption = document.createElement("div");
      newOption.className = "option";
      newOption.innerHTML = `<input type="text" name="options[]" required placeholder="أدخل خياراً">`;
      container.appendChild(newOption);
    }
  </script>
</body>
</html>
