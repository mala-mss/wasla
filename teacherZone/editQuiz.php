<?php 
  include "../includes/databaseConnection.php";
  session_start();

  if (!isset($_GET['id_quiz'])) {
    echo "<script>alert('No Quiz ID provided.');</script>";
    exit;
  }

  $quiz_id = $_GET['id_quiz'];

  
  $req = " SELECT q.question,q.id_lsn,o.choice_text,o.is_true,s.id_sub,s.name_sub
  FROM quiz q
  JOIN options o ON o.id_quiz=q.id_quiz
  JOIN lesson l  ON l.id_lsn=q.id_lsn
  JOIN teacher t ON t.id_teach=l.id_teach
  JOIN subject s ON s.id_sub=t.id_sub
  WHERE q.id_quiz='$quiz_id'";
  $res = mysqli_query($link, $req);

  if (mysqli_num_rows($res) > 0) {
    $_SESSION['id_quiz'] = $quiz_id;
    $_SESSION['options'] = [];
    $lesson_id = null;

    while ($row = mysqli_fetch_assoc($res)) {
      $_SESSION['question'] = $row['question']; 
      $lesson_id = $row['id_lsn']; 
      $_SESSION['id_sub'] = $row['id_sub']; 
      $_SESSION['options'][] = [
        'option' => $row['option'],
        'is_true' => $row['is_true']
      ];
    }
    
  } 
  else {
    echo "<script>alert('Quiz not found.');</script>";
    exit;
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit quiz</title>
    <link rel="stylesheet" href="../wasla_style/css/editQuizstyle.css">

</head>
<body>

<header class="main_header">
    <div class="logo_container">
        <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
        <a href="levels.php">الصفوف</a>
        <a href="subjects.php">المواد</a>
        <a href="lessons.php?id_sub=<?= $_SESSION["id_sub"] ?>">الدروس</a>
        <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
        <a href="../auth/Logout.php" class="btn register-btn">تسجيل الخروج</a>
    </div>
</header>

<div class="content">
<div class="container-row">
    <div class="me">
        <h2>تعديل السؤال: <?= htmlspecialchars($_SESSION["question"]) ?></h2>
    </div>
</div>

  <form method="POST" action="">
    <!-- Question input outside the loop, only once -->
    <label>
      Question:<br>
      <input type="text" name="question" required value="<?= htmlspecialchars($_SESSION['question']) ?>">
    </label>
    <br><br>

    <div id="optionsContainer">
      <?php foreach ($_SESSION['options'] as $index => $opt): ?>
        <div class="option">
          <input 
            type="text" 
            name="options[]" 
            required 
            value="<?= htmlspecialchars($opt['option']) ?>" 
            placeholder="Option <?= $index + 1 ?>"
          >
          <label>
            Correct?
            <input 
              type="radio" 
              name="correct" 
              value="<?= $index ?>" 
              <?= $opt['is_true'] ? 'checked' : '' ?>
            >
          </label>
        </div>
        <br>
      <?php endforeach; ?>
    </div>

    <button type="button" onclick="editOption()">Add Option</button>
    <button type="submit">Save Changes</button>
  </form>

  <script>
    let optionCount = <?= count($_SESSION['options']) ?>;

    function editOption() {
      const container = document.getElementById("optionsContainer");
      const dispOption = document.createElement("div");
      dispOption.className = "option";

      dispOption.innerHTML = `
        <input type="text" name="options[]" required placeholder="Option ${optionCount + 1}">
        <label>
          Correct?
          <input type="radio" name="correct" value="${optionCount}">
        </label>
        <br>
      `;
      optionCount++;
      container.appendChild(dispOption);
    }
  </script>

</body>
</html>

<?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['options'], $_POST['correct']) && is_array($_POST['options'])) {
        $question = mysqli_real_escape_string($link, $_POST['question'] ?? '');
        $correctIndex = (int)$_POST['correct'];
        $options = $_POST['options'];

        // Update question
        $updateQuiz = "UPDATE quiz SET question = '$question' WHERE id_quiz = '$quiz_id'";
        mysqli_query($link, $updateQuiz);

        // Delete 
        $deleteOptions = "DELETE FROM options WHERE id_quiz = '$quiz_id'";
        mysqli_query($link, $deleteOptions);

        // Insert 
        foreach ($options as $index => $optText) {
            $opt = mysqli_real_escape_string($link, $optText);
            $isTrue = ($index === $correctIndex) ? 1 : 0;
            $insertOption = "INSERT INTO options (id_quiz, option, is_true) VALUES ('$quiz_id', '$opt', '$isTrue')";
            mysqli_query($link, $insertOption);
        }

        echo "<script>
          alert('Quiz updated successfully.');
          window.location.href = 'addquiz.php?id_lsn=" . urlencode($lesson_id) . "';
        </script>";
        exit;
    } else {
        echo "<script>alert('Please fill all options and select the correct one.');</script>";
    }
  }
?>
