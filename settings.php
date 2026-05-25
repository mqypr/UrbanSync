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

/* project carousel */
$result = mysqli_query($conn, "SELECT * FROM projects ORDER BY completed DESC");
$projects = [];
while ($row = mysqli_fetch_assoc($result)) {
  $projects[] = $row;
}

/* code for details of project
$id = $_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM projects WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$current_project = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
*/
