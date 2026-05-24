<?php
$host     = "localhost";
$db_user  = "root";
$db_pass  = "";
$database = "urbansync_db";

$conn = mysqli_connect($host, $db_user, $db_pass, $database);
$current_user = null;
if (isset($_SESSION['user_id'])) {
  $s = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
  mysqli_stmt_bind_param($s, "i", $_SESSION['user_id']);
  mysqli_stmt_execute($s);
  $r = mysqli_stmt_get_result($s);
  $current_user = mysqli_fetch_assoc($r);
  mysqli_stmt_close($s);
}
