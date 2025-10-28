<?php
  session_start();
  include "../includes/databaseConnection.php";

  $query = "SELECT name_teach, fname_teach, Email 
  FROM teacher t, `subject` s 
  WHERE s.id_sub = t.id_sub ";

  $res = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact our teachers!</title>
  <style>
      body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4efff;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .container {
      max-width: 700px;
      margin: 50px auto;
      padding: 30px;
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(128, 90, 213, 0.2); /* light purple shadow */
    }

    h2 {
      text-align: center;
      color: #7c3aed; /* medium purple */
      margin-bottom: 30px;
    }

    .card {
      background-color: #ede9fe; /* very light purple */
      padding: 15px 20px;
      border-radius: 10px;
      margin-bottom: 20px;
      border-left: 6px solid #a78bfa; /* lavender border */
    }

    .teacher-card p {
      margin: 6px 0;
      font-weight: bold;
      font-size: 1.1rem;
      color: #6b21a8;
    }


  </style>
</head>
<body>
  <h2>Our Teachers!</h2>
  <div class="container">
  <?php while($row = mysqli_fetch_assoc($res)): ?>
    <div class="card">
      <p name="teach"><?= htmlspecialchars($row['name_teach']); ?><p/>
      <p name="fname" class="teach"><?= htmlspecialchars($row['fname_teach']); ?><p/>
      <p name="email" class="teach"><?= htmlspecialchars($row['Email']); ?></p>
  
    </div>
    <?php endwhile;?>
  </div>
  
</body>
</html>