<?php
Session_start();
include "../includes/databaseConnection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../wasla_style/css/Loginstyle.css"/>
  
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-box">
      <h2>!تسجيل الدخول كمعلم</h2>
      <form action="LoginT.php" method="post">
            <input type="text" placeholder="اسم المستخدم" name="username"/>
            <input type="password" placeholder="كلمة السر" name="password" />
        <input type="submit" id="submit" value="تسجيل الدخول" name="submit"/><br><br>
        <div class="alert alert-warning" id="warning" style="display:none;">
            <strong>تنبيه!</strong> يرجى إدخال اسم المستخدم وكلمة المرور.
        </div>
        <div class="alert alert-danger" id="danger" style="display:none;">
            <strong>خطأ!</strong> اسم المستخدم أو كلمة المرور غير صحيحين، يرجى المحاولة مرة أخرى.
        </div>
        <div class="alert alert-danger" id="notexisting" style="display:none;">
            <strong>تنبيه!</strong> يرجى التسجيل أولاً قبل تسجيل الدخول.
        </div>

      </form>
      <p class="note">لست منضما بعد؟ <a href="SignupT.php">انشئ حسابا</a></p>
    </div>
  </div>
  <!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

</body>
</html>

<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password']; // Do NOT hash here, verify against hash

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id_teach, pass_teach FROM teacher WHERE username_teach = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $data = mysqli_fetch_assoc($result);
            $hashed_password = $data['pass_teach'];

         

            if ($password==$hashed_password) {
                $_SESSION['username'] = $username;
                header("Location: ../teacherZone/levels.php");
                exit;
            } else {
                    ?>
        <script>
            document.getElementById('danger').style.display='block';
            document.getElementById('warning').style.display='none';
            document.getElementById('notexisting').style.display='none';

        </script>";
        <?php
            }
        } else {
            ?>
            <script>
                document.getElementById('danger').style.display='none';
                document.getElementById('warning').style.display='none';
                document.getElementById('notexisting').style.display='block';
            </script>";
            <?php
        }
    } else {
        ?>
        <script>
            document.getElementById('danger').style.display='none';
            document.getElementById('warning').style.display='block';
            document.getElementById('notexisting').style.display='none';

        </script>";
        <?php
    }
}
?>
