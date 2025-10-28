<?php
include "../includes/databaseConnection.php";
session_start();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الانضمام إلى المنصة</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../wasla_style/css/Signup.css">
</head>
<body>
<div align="center" class="container">
    <div class="login-box">
        <h1>الانضمام إلى المنصة</h1>
        <form action="" method="post">
            <input type="text" name="firstname" placeholder="الاسم" dir="rtl" required class="h">
            <input type="text" name="lastname" placeholder="اللقب" dir="rtl" required class="h">
            <input type="text" name="username" placeholder="اسم المستخدم" dir="rtl" required class="h">
            <input type="text" name="email" placeholder="البريد الإلكتروني" dir="rtl" required class="h">
            <input type="password" name="password" placeholder="كلمة السر" dir="rtl" id="password" required class="h">
              <small id="passwordHelp" style="color: red;"></small>
            <input type="submit" name="submit" value="انضمام" id="submit" class="submit-button">
            <br><br>
            <div class="alert alert-warning" id="warning" style="display:none;">
            <strong>تنبيه!</strong> البريد الإلكتروني مستخدم بالفعل. الرجاء استخدام بريد إلكتروني آخ
        </div>
        </form>
        <p class="note">هل أنت منضم إلينا في الأصل؟ <a href="LoginT.php">تسجيل الدخول</a></p>



       
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $password = trim($_POST['password']);
    // DEBUGGING OUTPUT
    echo "<script>console.log('Trying to register: $email');</script>";

    // Check if email exists
    $check_sql = "SELECT Email FROM teacher WHERE Email = ?";
    $check_stmt = mysqli_prepare($link, $check_sql);

    if (!$check_stmt) {
        echo "<script>alert('DB ERROR: Check stmt prepare failed');</script>";
        exit;
    }

    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    $email_exists = mysqli_stmt_num_rows($check_stmt);
    mysqli_stmt_close($check_stmt);

    if ($email_exists > 0) {
        ?>
        <script> 
        document.getElementById("warning").style.display="block";
        
        </script>";
        <?php

        
    }
    else{

    $insert_sql = "INSERT INTO teacher (Email, username_teach, name_teach, fname_teach, pass_teach) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($link, $insert_sql);

    if (!$insert_stmt) {
        echo "<script>alert('DB ERROR: Insert stmt prepare failed');</script>";
        exit;
    }

    mysqli_stmt_bind_param($insert_stmt, "sssss", $email, $username, $firstname, $lastname, $password);
    $executed = mysqli_stmt_execute($insert_stmt);
    mysqli_stmt_close($insert_stmt);

    if ($executed) {
        echo "<script>window.location.href = 'LoginT.php';</script>";
        exit;
    } else {
    
        echo '<div class="alert alert-danger mt-3" role="alert">فشل تسجيل المستخدم. حاول مرة أخرى.</div>';
    }

    }

}
?>
