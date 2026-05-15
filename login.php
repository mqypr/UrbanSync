<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/style.css">
  <title>Login - UrbanSync</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.ico">
</head>

<body>
  <!--HEADER-->
  <?php include "./header.inc" ?>

  <main class="login-main">
    <div class="login-card">
      <img src="./images/logo.png" class="login-logo" alt="UrbanSync logo">
      <h1 class="login-title">Sign In</h1>
      <p class="login-subtitle">Welcome back to UrbanSync</p>

      <form class="login-form" action="" method="post">
        <label class="login-label" for="username">Username</label>
        <input class="login-input" type="text" id="username" name="username"
          placeholder="Enter your username" required>

        <label class="login-label" for="password">Password</label>
        <input class="login-input" type="password" id="password" name="password"
          placeholder="Enter your password" required>

        <button class="login-btn" type="submit">Sign In</button>
      </form>

      <p class="login-register">Not registered?
        <a class="login-register-link" href="./signup.php">Create an account</a>
      </p>
    </div>
  </main>

  <!--FOOTER-->
  <?php include "footer.inc" ?>
</body>

</html>