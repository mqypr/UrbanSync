<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once './settings.php';
$error = '';

if (isset($_POST['login'])) {
  $email          = trim($_POST['email']);
  $input_password = $_POST['password'];

  if (!empty($email) && !empty($input_password)) {
    $stmt = mysqli_prepare($conn, "SELECT id, password, first_name FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
      $id              = 0;
      $hashed_password = '';
      $first_name      = '';
      mysqli_stmt_bind_result($stmt, $id, $hashed_password, $first_name);
      mysqli_stmt_fetch($stmt);

      if (password_verify($input_password, $hashed_password)) {
        $_SESSION['user_id']    = $id;
        $_SESSION['email']      = $email;
        $_SESSION['first_name'] = $first_name;
        mysqli_stmt_close($stmt);
        header("Location: ./index.php");
        exit;
      } else {
        $error = "Incorrect email or password.";
      }
    } else {
      $error = "Incorrect email or password.";
    }

    mysqli_stmt_close($stmt);
  } else {
    $error = "Please fill in all fields.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/style.css">
  <title>Login - UrbanSync</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.ico">
</head>

<body class='s-body'>

  <?php include "./header.inc" ?>

  <main class="login-main">
    <div class="login-card">
      <img src="./images/logo.png" class="login-logo" alt="UrbanSync logo">
      <h1 class="login-title">Sign In</h1>
      <p class="login-subtitle">Welcome back to UrbanSync</p>

      <form class="login-form" action="" method="post">
        <?php if ($error): ?>
          <p class="login-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <label class="login-label" for="email">Email</label>
        <input class="login-input" type="email" id="email" name="email"
          placeholder="Enter your email"
          value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
          required>

        <label class="login-label" for="password">Password</label>
        <input class="login-input" type="password" id="password" name="password"
          placeholder="Enter your password" required>

        <button class="login-button" type="submit" name="login" value="1">Sign In</button>
      </form>

      <p class="login-register">Not registered?
        <a class="login-register-link" href="./signup.php">Create an account</a>
      </p>
    </div>
  </main>
  <?php include "footer.inc" ?>
</body>

</html>