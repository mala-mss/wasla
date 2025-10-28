<?php
session_start();
include "../includes/databaseConnection.php";



$id_quiz=$_GET['id_quiz'];


    mysqli_query($link, "DELETE FROM options WHERE id_quiz ='$id_quiz'");

mysqli_query($link, "DELETE FROM quiz WHERE id_quiz ='$id_quiz'");

?>
<script type="text/javascript">
window.location.href = 'addquiz.php?id_lsn=<?php echo $_SESSION['id_lsn']; ?>';
</script>