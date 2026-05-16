<?php
session_start();
require_once 'settings.php';
$errors = [];
$success = false;
$code_sent = false;
$code_error = '';

/* ── Send verification code ── */
if (isset($_POST['send_code'])) {
  $email = filter_var(trim($_POST['email_for_code']), FILTER_SANITIZE_EMAIL);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $code_error = "Please enter a valid email address before sending a code.";
  } else {
    $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $_SESSION['verify_code']  = $code;
    $_SESSION['verify_email'] = $email;
    $_SESSION['code_expiry']  = time() + 600;
    $code_sent = true;
  }
}

/* ── Handle signup submission ── */
if (isset($_POST['signup'])) {
  $first          = trim(ucfirst(strtolower($_POST['first_name'])));
  $last           = trim(ucfirst(strtolower($_POST['last_name'])));
  $dob            = $_POST['dob'];
  $gender         = $_POST['gender'];
  $email          = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $phone_code     = $_POST['phone_code'] ?? '+61';
  $phone          = trim($_POST['phone']);
  $code           = trim($_POST['verify_code']);
  $input_password = $_POST['password'];
  $confirm        = $_POST['confirm_password'];

  /* Basic field checks */
  if (empty($first))  $errors[] = "First name is required.";
  if (empty($last))   $errors[] = "Last name is required.";
  if (empty($dob))    $errors[] = "Date of birth is required.";
  if (empty($gender)) $errors[] = "Please select a gender.";
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email address.";
  if (empty($phone))  $errors[] = "Phone number is required.";

  /* Verification code */
  if (empty($code)) {
    $errors[] = "Please enter the verification code.";
  } elseif (!isset($_SESSION['verify_code'])) {
    $errors[] = "No verification code was sent. Please request one.";
  } elseif (time() > $_SESSION['code_expiry']) {
    $errors[] = "Verification code has expired. Please request a new one.";
  } elseif ($code !== $_SESSION['verify_code']) {
    $errors[] = "Incorrect verification code.";
  } elseif ($_SESSION['verify_email'] !== $email) {
    $errors[] = "Verification code was sent to a different email address.";
  }

  /* Password rules */
  if (strlen($input_password) < 8)             $errors[] = "Password must be at least 8 characters.";
  if (!preg_match('/[A-Z]/', $input_password))  $errors[] = "Password must contain an uppercase letter.";
  if (!preg_match('/[a-z]/', $input_password))  $errors[] = "Password must contain a lowercase letter.";
  if (!preg_match('/[0-9]/', $input_password))  $errors[] = "Password must contain a number.";
  if (!preg_match('/[\W_]/', $input_password))  $errors[] = "Password must contain a symbol.";
  if ($input_password !== $confirm)             $errors[] = "Passwords do not match.";

  if (empty($errors)) {
    $hashed = password_hash($input_password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (first_name, last_name, dob, gender, email, phone_code, phone, password, dark_mode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
    mysqli_stmt_bind_param($stmt, "ssssssss", $first, $last, $dob, $gender, $email, $phone_code, $phone, $hashed);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    unset($_SESSION['verify_code'], $_SESSION['verify_email'], $_SESSION['code_expiry']);
    $success = true;
  }
}

/* ── Helper: returns green/red class based on a boolean test ── */
$attempted = isset($_POST['signup']);
$pw        = $_POST['password'] ?? '';
$confirm   = $_POST['confirm_password'] ?? '';

function pw_class($test)
{
  return $test ? 'pw-rule-pass' : 'pw-rule-fail';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/style.css">
  <title>Sign Up - UrbanSync</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.ico">
</head>

<body>
  <!--HEADER-->
  <?php include "./header.inc" ?>

  <main class="signup-main">
    <div class="signup-card">
      <img src="./images/logo.png" class="signup-logo" alt="UrbanSync logo">
      <h1 class="signup-title">Create Account</h1>
      <p class="signup-subtitle">Join UrbanSync today</p>

      <?php if ($success): ?>

        <div class="signup-success">
          Account created successfully! <a class="signup-success-link" href="./login.php">Sign in</a>
        </div>

      <?php else: ?>

        <?php if (!empty($errors)): ?>
          <ul class="signup-errors">
            <?php foreach ($errors as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <form class="signup-form" action="" method="post">

          <!-- Name row -->
          <div class="signup-row">
            <div class="signup-field">
              <label class="signup-label" for="first_name">First Name</label>
              <input class="signup-input" type="text" id="first_name" name="first_name"
                placeholder="John"
                value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>"
                required>
            </div>
            <div class="signup-field">
              <label class="signup-label" for="last_name">Last Name</label>
              <input class="signup-input" type="text" id="last_name" name="last_name"
                placeholder="Doe"
                value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>"
                required>
            </div>
          </div>

          <!-- DOB + Gender row -->
          <div class="signup-row">
            <div class="signup-field">
              <label class="signup-label" for="dob">Date of Birth</label>
              <input class="signup-input" type="date" id="dob" name="dob"
                value="<?= htmlspecialchars($_POST['dob'] ?? '') ?>"
                required>
            </div>
            <div class="signup-field">
              <label class="signup-label" for="gender">Gender</label>
              <select class="signup-input signup-select" id="gender" name="gender" required>
                <option value="" disabled <?= empty($_POST['gender']) ? 'selected' : '' ?>>Select</option>
                <option value="male" <?= ($_POST['gender'] ?? '') === 'male'       ? 'selected' : '' ?>>Male</option>
                <option value="female" <?= ($_POST['gender'] ?? '') === 'female'     ? 'selected' : '' ?>>Female</option>
                <option value="other" <?= ($_POST['gender'] ?? '') === 'other'      ? 'selected' : '' ?>>Other</option>
                <option value="prefer_not" <?= ($_POST['gender'] ?? '') === 'prefer_not' ? 'selected' : '' ?>>Prefer not to say</option>
              </select>
            </div>
          </div>

          <!-- Email + Send code -->
          <label class="signup-label" for="email">Email</label>
          <div class="signup-email-row">
            <input class="signup-input signup-email-input" type="email" id="email" name="email"
              placeholder="you@email.com"
              value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
              required>
            <!-- formnovalidate skips full form validation, only sends email -->
            <button class="signup-code-btn" type="submit" name="send_code" value="1" formnovalidate>
              Send Code
            </button>
          </div>
          <!-- carries the email value across when send_code is clicked -->
          <input type="hidden" name="email_for_code"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

          <?php if ($code_sent): ?>
            <p class="signup-code-sent">Your code is: <strong><?= $_SESSION['verify_code'] ?></strong> — expires in 10 minutes.</p>
          <?php endif; ?>
          <?php if ($code_error): ?>
            <p class="signup-code-error"><?= htmlspecialchars($code_error) ?></p>
          <?php endif; ?>

          <!-- Verification code -->
          <label class="signup-label" for="verify_code">Verification Code</label>
          <input class="signup-input" type="text" id="verify_code" name="verify_code"
            placeholder="6-digit code" maxlength="6" required>

          <!-- Phone -->
          <label class="signup-label" for="phone">Phone Number</label>
          <div class="signup-phone-row">
            <input class="signup-input signup-phone-prefix" type="text" name="phone_code"
              placeholder="+61"
              value="<?= htmlspecialchars($_POST['phone_code'] ?? '+61') ?>"
              maxlength="5">
            <input class="signup-input signup-phone-input" type="tel" id="phone" name="phone"
              placeholder="4XXXXXXXX"
              value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
              required>
          </div>

          <!-- Password -->
          <label class="signup-label" for="password">Password</label>
          <input class="signup-input" type="password" id="password" name="password"
            placeholder="Create a password" required>

          <!-- Password rules: neutral on first load, green/red after a submit attempt -->
          <ul class="signup-pw-rules">
            <li class="pw-rule <?= $attempted ? pw_class(strlen($pw) >= 8)            : '' ?>">At least 8 characters</li>
            <li class="pw-rule <?= $attempted ? pw_class(preg_match('/[A-Z]/', $pw))  : '' ?>">Uppercase letter (A–Z)</li>
            <li class="pw-rule <?= $attempted ? pw_class(preg_match('/[a-z]/', $pw))  : '' ?>">Lowercase letter (a–z)</li>
            <li class="pw-rule <?= $attempted ? pw_class(preg_match('/[0-9]/', $pw))  : '' ?>">Number (0–9)</li>
            <li class="pw-rule <?= $attempted ? pw_class(preg_match('/[\W_]/', $pw))  : '' ?>">Symbol (!@#$...)</li>
          </ul>

          <!-- Confirm password -->
          <label class="signup-label" for="confirm_password">Confirm Password</label>
          <input class="signup-input" type="password" id="confirm_password" name="confirm_password"
            placeholder="Repeat your password" required>

          <!-- Match message: only shown after a submit attempt -->
          <?php if ($attempted): ?>
            <p class="signup-match-msg <?= ($pw === $confirm) ? 'match-ok' : 'match-fail' ?>">
              <?= ($pw === $confirm) ? '✓ Passwords match' : '✗ Passwords do not match' ?>
            </p>
          <?php endif; ?>

          <button class="signup-btn" type="submit" name="signup" value="1">Create Account</button>
        </form>

        <p class="signup-login">Already have an account?
          <a class="signup-login-link" href="./login.php">Sign in</a>
        </p>

      <?php endif; ?>
    </div>
  </main>

  <!--FOOTER-->
  <?php include "footer.inc" ?>
</body>

</html>