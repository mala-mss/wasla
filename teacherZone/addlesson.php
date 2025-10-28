<?php
session_start();
include "../includes/databaseConnection.php";



$subject_id =$_SESSION['id_sub'];
$sql = "SELECT * FROM subject WHERE id_sub = '$subject_id'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['subject_id'] = $subject_id;
    $_SESSION['subject_title'] = $row['name_sub'];
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
    <link rel="stylesheet" href="../wasla_style/css/dashboard.css">
    <link rel="stylesheet" href="../wasla_style/css/addlessonStyle.css">
    
</head>
<body>

<header class="main_header">
    <div class="logo_container">
        <img src="../wasla_style/img/logo.jpg" alt="logo" class="logo_img">
    </div>
    <nav class="nav-links">
        <a href="levels.php">الصفوف</a>
        <a href="level.php">المواد</a>
        <a href="subject.php">الدروس</a>
        <a href="#">تواصل معنا</a>
    </nav>
    <div class="auth-buttons">
        <a href="../auth/Logout.php" class="btn register-btn">تسجيل الخروج</a>
    </div>
</header>


    <div class="me">
        <h2>إضافة درس جديد</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="subject_id" value="<?= htmlspecialchars($subject_id) ?>">
            <input type="text" name="title" placeholder="عنوان الدرس" required>
            <input type="text" name="description" placeholder="وصف الدرس"/>
            <input type="text" name="video_url" placeholder="رابط الفيديو (YouTube)"/>
            <label for="attachement-file">تحميل الملف:</label>
            <input type="file" name="attachement-file"/>
           
            <input type="submit" name="submit" value="إضافة الدرس">
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
    $lesson_sql = "INSERT INTO lesson (title_lsn, `desc`, support, id_sub ,id_teach)
                   VALUES ('$title', '$description', '$video_url', '$subject_id', '$teacher_id')";

    if (mysqli_query($link, $lesson_sql)) {
        $lesson_id = mysqli_insert_id($link);

        if (!empty($file_path)) {
            $attachment_sql = "INSERT INTO attachment (id_lsn, file_att) VALUES ('$lesson_id', '$file_path')";
            mysqli_query($link, $attachment_sql); // optional: check result
        }

       ?><script>
    alert('تمت إضافة الدرس بنجاح!');
    window.location.href = 'lessons.php?id_sub=<?= $subject_id ?>';
</script>

         <?php
    } else {
        echo "<script>alert('خطأ في إضافة الدرس: " . mysqli_error($link) . "');</script>";
    }
}
?>