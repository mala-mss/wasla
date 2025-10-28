<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="wasla_style/css/HomeStyle.css" />
  </head>
  <body>
    <!-- Header -->
    <header class="main_header">
      <div class="logo_container">
        <img src="wasla_style/img/logo.jpg" alt="logo" class="logo_img" />
      </div>
      <nav class="nav-links">
        <a href="#">الرئيسية</a>
        <a href="#">المحتوى التعليمي</a>
        <a href="#">الأسئلة الشائعة</a>
        <a href="#">تواصل معنا</a>
      </nav>
      <div class="auth-buttons">
        <a href="auth/LoginT.php" class="btn login-btn">تسجيل الدخول</a>
        <a href="auth/SignupT.php" class="btn register-btn">إنشاء حساب</a>
      </div>
    </header>

    <!-- Main content -->
    <main class="main_content">
      <section class="hero">
        <div class="hero_image">
          <img src="wasla_style/img/home.png" alt="صورة ترحيبية" />
        </div>
        <div class="welcome">
          <h2>مرحباً بكم في منصة وصلة</h2>
          <p>
            نعتني بالأنشطة التفاعلية والعلمية المُصاحبة للبرامج العلمية، والتي
            نطمح من خلالها إلى تقوية علاقة الطلاب ببرامجهم العلميَّة وزيادة
            انتفاعهم بها.
          </p>
        </div>
      </section>

      <section class="role_selection">
        <h3>هل أنت معلم أم طالب؟</h3>
        <div class="role_box">
          <a href="auth/LoginT.php" class="role_card">معلم</a>
          
          <a href="auth/LoginS.php" class="role_card">طالب</a>
        </div>
      </section>

      <!-- About Section -->
      <section class="info_section" id="about">
        <h2>من نحن</h2>
        <p>
          منصة الأنشطة العامة تهدف إلى تقديم محتوى تعليمي متميز يعزز من تجربة
          التعلم لدى الطلاب والمعلمين على حد سواء.
        </p>
      </section>

      <!-- Contact Section -->
      <section class="info_section" id="contact">
        <h2>تواصل معنا</h2>
        <p>
          للاستفسارات والدعم، يرجى التواصل عبر البريد الإلكتروني:
          <a href="mailto:contact@anshitah1.com">contact@anshitah1.com</a>.
        </p>
      </section>
    </main>

    <!-- Footer -->
    <footer class="main_footer">
      <p>&copy; 2025 جميع الحقوق محفوظة لمنصة الأنشطة العامة.</p>
    </footer>
  </body>
</html>
