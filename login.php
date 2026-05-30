<?php
session_start();
require_once './settings.php';
$error = '';

if (isset($_POST['login'])) {
  $email          = trim($_POST['email']);
  $input_password = $_POST['password'];

  if (empty($email) || empty($input_password)) {
    $error = "Please fill in all fields.";
  } else {

    /* ── Manager login ── */
    $stmt = mysqli_prepare($conn, "SELECT id, password FROM manager_users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      if (password_verify($input_password, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['manager']    = true;
        $_SESSION['manager_id'] = $row['id'];
        mysqli_stmt_close($stmt);
        header("Location: ./manage.php");
        exit;
      }
    }
    mysqli_stmt_close($stmt);

    /* ── Normal user login ── */
    $stmt = mysqli_prepare($conn, "SELECT id, password, first_name FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      if (password_verify($input_password, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']    = $row['id'];
        $_SESSION['email']      = $email;
        $_SESSION['first_name'] = $row['first_name'];
        mysqli_stmt_close($stmt);
        header("Location: ./index.php");
        exit;
      }
    }
    mysqli_stmt_close($stmt);

    /* ── Both failed ── */
    $error = "Incorrect email or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="./styles/style.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <title>Login - UrbanSync</title>

  <link rel="icon" type="image/x-icon" href="/images/logo.ico">

</head>

<style>
  .navbar {
    background: none;
  }

  .navbar-link-item,
  label.navbar-link-vert-item {
    color: white;
  }

  .menu-toggle-input:checked~.navbar-link-item,
  .menu-toggle-input:checked~label.navbar-link-item,
  .navbar-settings-dropdown,
  .navbar-link-item:hover,
  .navbar-settings:hover .navbar-link-item {
    background: rgba(220, 239, 241, 0.2);
    border: none;
    box-shadow: 0 8px 24px var(--shadow);
  }
</style>

<body class='s-body'>

  <?php include "./header.inc" ?>

  <main class="login-main">

    <div class="login-card">

      <img src="./images/logo.png" class="logo" alt="UrbanSync logo">

      <h1 class="login-title">Sign In</h1>

      <p class="login-subtitle">Welcome back to UrbanSync</p>

      <form class="login-form" action="" method="post">

        <?php if ($error): ?>
          <p class="login-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <label class="login-label" for="email">Email / Username</label>

        <input
          class="login-input"
          type="text"
          id="email"
          name="email"
          placeholder="Enter your email or username"
          value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
          required>

        <label class="login-label" for="password">Password</label>

        <input
          class="login-input"
          type="password"
          id="password"
          name="password"
          placeholder="Enter your password"
          required>

        <button class="login-button" type="submit" name="login" value="1">
          Sign In
        </button>

      </form>

      <p class="login-register">

        Not registered?

        <a class="login-register-link" href="./signup.php">
          Create an account
        </a>

      </p>

    </div>

  </main>

  <?php include "footer.inc" ?>

</body>

</html>