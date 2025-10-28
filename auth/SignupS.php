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
            <input type="password" name="password" placeholder="كلمة السر" dir="rtl" id="password" required class="h">
            <small id="passwordHelp" style="color: red;"></small>

            <select name="level" class="form-select mt-2" required>
                <option value="" disabled selected>اختر المستوى</option>
                <?php
                $req = "SELECT * FROM level";
                $res = mysqli_query($link, $req);
                while ($row = mysqli_fetch_assoc($res)) {
                    echo '<option value="' . htmlspecialchars($row['id_lvl']) . '">' . htmlspecialchars($row['name_lvl']) . '</option>';
                }
                ?>
            </select>

            <input type="submit" name="submit" value="انضمام" id="submit" class="submit-button mt-3">
            <div class="alert alert-warning mt-2" id="warning" style="display:none;">
                <strong>تنبيه!</strong> اسم المستخدم مستخدم بالفعل. الرجاء اختيار اسم آخر.
            </div>
        </form>
        <p class="note">هل أنت منضم إلينا في الأصل؟ <a href="LoginS.php">تسجيل الدخول</a></p>
    </div>
</div>

<script>
    document.getElementById("password").addEventListener("input", function() {
        const password = this.value;
        const help = document.getElementById("passwordHelp");
        const submit = document.getElementById("submit");

        const valid = {
            length: password.length >= 8,
            lower: /[a-z]/.test(password),
            upper: /[A-Z]/.test(password),
            number: /\d/.test(password),
            special: /[!@#$%^&*()_\-+=\[\]{};:'",.<>/?\\|]/.test(password)
        };

        const messages = [];
        if (!valid.length) messages.push("8 أحرف على الأقل");
        if (!valid.lower) messages.push("حرف صغير");
        if (!valid.upper) messages.push("حرف كبير");
        if (!valid.number) messages.push("رقم");
        if (!valid.special) messages.push("رمز خاص");

        if (messages.length === 0) {
            help.textContent = "كلمة المرور قوية ✅";
            help.style.color = "green";
            submit.disabled = false;
            submit.style.background = "#6f42c1";
        } else {
            help.textContent = "كلمة المرور يجب أن تحتوي على: " + messages.join("، ");
            help.style.color = "red";
            submit.disabled = true;
            submit.style.background = "grey";
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $level = trim($_POST['level']);

    // Check if username exists
    $check_sql = "SELECT username_ppl FROM pupil WHERE username_ppl = ?";
    $check_stmt = mysqli_prepare($link, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    $username_exists = mysqli_stmt_num_rows($check_stmt);
    mysqli_stmt_close($check_stmt);

    if ($username_exists > 0) {
        echo "<script>document.getElementById('warning').style.display='block';</script>";
    } else {
        $insert_sql = "INSERT INTO pupil (username_ppl, name_ppl, fname_ppl, pass_ppl, id_lvl) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($link, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "sssss", $username, $firstname, $lastname, $password, $level);
        $executed = mysqli_stmt_execute($insert_stmt);
        mysqli_stmt_close($insert_stmt);

        if ($executed) {
            echo "<script>window.location.href = 'LoginS.php';</script>";
            exit;
        } else {
            echo '<div class="alert alert-danger mt-3" role="alert">فشل تسجيل المستخدم. حاول مرة أخرى.</div>';
        }
    }
}
?>
