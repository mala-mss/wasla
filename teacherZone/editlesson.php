<?php
session_start();
include "../includes/databaseConnection.php";


$lesson_id = $_GET['lesson_id'];
$sql = "SELECT * FROM lesson, teacher WHERE lesson.id_teach = teacher.id_teach && id_lsn = '$lesson_id'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
   $row = mysqli_fetch_assoc($result);
    $_SESSION['id_lsn'] = $lesson_id;
    $_SESSION['lesson_title'] = $row['title_lsn'];
    $_SESSION['lesson_desc'] = $row['description'];
    $_SESSION['lesson_support'] = $row['support'];
    $subject_id = $row['id_sub'];
} else {
    echo "<script>alert('subject not found.');</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Classes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../wasla_style/css/addlessonStyle.css">
    <link rel="stylesheet" href="../wasla_style/css/dashboard.css">
    <link rel="stylesheet" href="../wasla_style/css/editQuizStyle.css">
</head>
<body>

<header class="main_header">
    <div class="logo_container">
        <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
        <a href="levels.php">الصفوف</a>
        <a href="subjects.php">المواد</a>
        <a href="lessons.php?id_sub=<?= $subject_id ?>">الدروس</a>
        <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
        <a href="../auth/Logout.php" class="btn register-btn">تسجيل الخروج</a>
    </div>
</header>

<div class="content">
<div class="container-row">
    

    <div class="me">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="subject_id" value="<?= htmlspecialchars($subject_id) ?>">
            <input type="text" name="title" placeholder="عنوان الدرس" value="<?php echo $_SESSION['lesson_title']; ?>" required>
            <input type="text" name="description" placeholder="وصف الدرس" value="<?php echo $_SESSION['lesson_desc']; ?>" />
            <input type="text" name="video_url" placeholder="رابط الفيديو (YouTube)" value="<?php echo $_SESSION['lesson_support']; ?>"/>
            <label for="attachement-file">تحميل الملف :</label>
            <input type="file" name="attachement-file"/>
             <a href="addquiz.php?id_lsn=<?= $lesson_id ?>">add quiz to this lesson</a>
            <input type="submit" name="submit" value="تعديل الدرس">
        </form>
        </form>
    </div>
</div>
</div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $subject_id = mysqli_real_escape_string($link, $_POST['subject_id']);
    $title = mysqli_real_escape_string($link, trim($_POST['title']));
    $description = mysqli_real_escape_string($link, trim($_POST['description']));
    $video_url = mysqli_real_escape_string($link, trim($_POST['video_url']));
    $file_path = '';

    if ( empty($title)) {
        echo "<script>alert('يجب إدخال عنوان الدرس'); window.history.back();</script>";
        exit;
    }

    if (isset($_FILES['attachement-file']) && $_FILES['attachement-file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/files/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_tmp = $_FILES['attachement-file']['tmp_name'];
        $file_name = basename($_FILES['attachement-file']['name']);
        $target_file = $upload_dir . time() . '_' . $file_name;

        if (move_uploaded_file($file_tmp, $target_file)) {
            $file_path = mysqli_real_escape_string($link, $target_file);
        } else {
            echo "<script>alert('فشل تحميل الصورة.');</script>";
        }
    }
     $qu = "SELECT id_teach FROM teacher WHERE username_teach = ?";
$stmt = mysqli_prepare($link, $qu);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($row = mysqli_fetch_assoc($result)) {
    $teacher_id = $row['id_teach'];
} else {
    echo "<script>alert('لم يتم العثور على المعلم.'); window.history.back();</script>";
    exit;
}

    // Insert lesson
   $lesson_sql = "UPDATE lesson 
               SET title_lsn = '$title',
                   `desc` = '$description',
                   support = '$video_url',
                
                   id_teach = '$teacher_id'
               WHERE id_lsn = '$lesson_id'";


    if (mysqli_query($link, $lesson_sql)) {
        $lesson_id = mysqli_insert_id($link);

        if (!empty($file_path)) {
            $attachment_sql = "UPDATE attachment 
                   SET file_att = '$file_path' 
                   WHERE id_lsn = '$lesson_id'";

            mysqli_query($link, $attachment_sql); // optional: check result
        }

        echo "<script>alert('تم تعديل الدرس بنجاح!');
         window.location.href='addlesson.php?subject_id=$subject_id';</script>";
    } else {
        echo "<script>alert('خطأ في تعديل الدرس: " . mysqli_error($link) . "');</script>";
    }
}
?>
