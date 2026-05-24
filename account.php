<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once './settings.php';
$error = '';

/* ── Auth guard ── */
if (!isset($_SESSION['user_id'])) {
  header('Location: ./login.php');
  exit;
}

$user_id  = $_SESSION['user_id'];
$errors   = [];
$success  = false;
$code_sent  = false;
$code_error = '';

$success = false;
if (!empty($_SESSION['changed'])) {
  $success = true;
  unset($_SESSION['changed']);
}

/* ── Helper: fetch latest user row ── */
function fetch_user($conn, $id)
{
  $s = mysqli_prepare($conn, "SELECT first_name, last_name, dob, gender, email, phone_code, phone FROM users WHERE id = ?");
  mysqli_stmt_bind_param($s, "i", $id);
  mysqli_stmt_execute($s);
  $r = mysqli_stmt_get_result($s);
  $row = mysqli_fetch_assoc($r);
  mysqli_stmt_close($s);
  return $row;
}

$user = fetch_user($conn, $user_id);

/* ── Send verification code for email change ── */
if (isset($_POST['send_code'])) {
  $email_for_code = filter_var(trim($_POST['email_for_code']), FILTER_SANITIZE_EMAIL);

  if (!filter_var($email_for_code, FILTER_VALIDATE_EMAIL)) {
    $code_error = "Please enter a valid email address before sending a code.";
  } else {
    $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $_SESSION['verify_code']  = $code;
    $_SESSION['verify_email'] = $email_for_code;
    $_SESSION['code_expiry']  = time() + 600;
    $code_sent = true;
  }
}

/* ── Save all changes ── */
if (isset($_POST['save_all'])) {
  $first      = trim(ucfirst(strtolower($_POST['first_name'])));
  $last       = trim(ucfirst(strtolower($_POST['last_name'])));
  $dob        = $_POST['dob'];
  $gender     = $_POST['gender'];
  $new_email  = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $phone_code = trim($_POST['phone_code'] ?? '+61');
  $phone      = trim($_POST['phone']);
  $cur_pw     = $_POST['current_password']    ?? '';
  $new_pw     = $_POST['new_password']        ?? '';
  $conf_pw    = $_POST['confirm_new_password'] ?? '';

  /* Basic field checks */
  if (empty($first))  $errors[] = "First name is required.";
  if (empty($last))   $errors[] = "Last name is required.";
  if (empty($dob))    $errors[] = "Date of birth is required.";
  if (empty($gender)) $errors[] = "Please select a gender.";
  if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email address.";
  if (empty($phone))  $errors[] = "Phone number is required.";

  /* Email change: require verification code */
  $email_changed = ($new_email !== $user['email']);
  if ($email_changed) {
    $entered_code = trim($_POST['verify_code'] ?? '');
    if (empty($entered_code)) {
      $errors[] = "Please enter the verification code sent to your new email.";
    } elseif (!isset($_SESSION['verify_code'])) {
      $errors[] = "No verification code was sent. Please request one.";
    } elseif (time() > $_SESSION['code_expiry']) {
      $errors[] = "Verification code has expired. Please request a new one.";
    } elseif ($entered_code !== $_SESSION['verify_code']) {
      $errors[] = "Incorrect verification code.";
    } elseif ($_SESSION['verify_email'] !== $new_email) {
      $errors[] = "Verification code was sent to a different email address.";
    }
  }

  /* Password change: only if current_password is filled */
  $change_pw = !empty($cur_pw) || !empty($new_pw);
  if ($change_pw) {
    $ps = mysqli_prepare($conn, "SELECT password FROM users WHERE id = ?");
    mysqli_stmt_bind_param($ps, "i", $user_id);
    mysqli_stmt_execute($ps);
    $pr = mysqli_stmt_get_result($ps);
    $pw_row = mysqli_fetch_assoc($pr);
    mysqli_stmt_close($ps);

    if (!password_verify($cur_pw, $pw_row['password'])) {
      $errors[] = "Current password is incorrect.";
    } else {
      if (strlen($new_pw) < 8)            $errors[] = "New password must be at least 8 characters.";
      if (!preg_match('/[A-Z]/', $new_pw)) $errors[] = "New password must contain an uppercase letter.";
      if (!preg_match('/[a-z]/', $new_pw)) $errors[] = "New password must contain a lowercase letter.";
      if (!preg_match('/[0-9]/', $new_pw)) $errors[] = "New password must contain a number.";
      if (!preg_match('/[\W_]/', $new_pw)) $errors[] = "New password must contain a symbol.";
      if ($new_pw !== $conf_pw)            $errors[] = "New passwords do not match.";
    }
  }

  /* Commit if no errors */
  /* Commit if no errors */
  if (empty($errors)) {
    if ($change_pw) {
      $hashed = password_hash($new_pw, PASSWORD_DEFAULT);
      $upd = mysqli_prepare($conn, "UPDATE users SET first_name=?, last_name=?, dob=?, gender=?, email=?, phone_code=?, phone=?, password=? WHERE id=?");
      mysqli_stmt_bind_param($upd, "ssssssssi", $first, $last, $dob, $gender, $new_email, $phone_code, $phone, $hashed, $user_id);
    } else {
      $upd = mysqli_prepare($conn, "UPDATE users SET first_name=?, last_name=?, dob=?, gender=?, email=?, phone_code=?, phone=? WHERE id=?");
      mysqli_stmt_bind_param($upd, "sssssssi", $first, $last, $dob, $gender, $new_email, $phone_code, $phone, $user_id);
    }
    mysqli_stmt_execute($upd);
    mysqli_stmt_close($upd);

    if ($email_changed) {
      unset($_SESSION['verify_code'], $_SESSION['verify_email'], $_SESSION['code_expiry']);
    }

    $_SESSION['changed'] = true;
    header("Location: ./account.php");
    exit;
  }
}

/* -- Signout -- */
if (isset($_POST['signout'])) {
  session_destroy();
  header("location:./index.php");
  exit;
}

/* ── Delete account ── */
if (isset($_POST['delete_account'])) {
  $del_pw = $_POST['delete_password'] ?? '';

  $ps = mysqli_prepare($conn, "SELECT password FROM users WHERE id = ?");
  mysqli_stmt_bind_param($ps, "i", $user_id);
  mysqli_stmt_execute($ps);
  $pr = mysqli_stmt_get_result($ps);
  $pw_row = mysqli_fetch_assoc($pr);
  mysqli_stmt_close($ps);

  if (!password_verify($del_pw, $pw_row['password'])) {
    $errors[] = "Incorrect password. Account was not deleted.";
  } else {
    $del = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($del, "i", $user_id);
    mysqli_stmt_execute($del);
    mysqli_stmt_close($del);
    session_destroy();
    header('Location: ./index.php?deleted=1'); /*flag*/
    exit;
  }
}

/* ── Password rule helper ── */
$attempted = isset($_POST['save_all']);
$new_pw_display  = $_POST['new_password']         ?? '';
$conf_pw_display = $_POST['confirm_new_password']  ?? '';

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
  <title>Account - UrbanSync</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.ico">
</head>

<body class='s-body'>
  <?php include "./header.inc" ?>

  <main class="account-main">
    <div class="account-card">

      <img src="./images/logo.png" class="account-logo" alt="UrbanSync logo">
      <h1 class="account-title">Account Settings</h1>
      <p class="account-subtitle">Manage your UrbanSync profile</p>

      <?php if ($success): ?>
        <div class="account-success">Changes saved successfully!</div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <ul class="account-errors">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <!-- ════ MAIN SETTINGS FORM ════ -->
      <form class="account-form" action="" method="post">

        <!-- ── Personal Info ── -->
        <div class="account-section">
          <h2 class="account-section-title">Personal Information</h2>

          <div class="account-row">
            <div class="account-field">
              <label class="account-label" for="first_name">First Name</label>
              <input class="account-input" type="text" id="first_name" name="first_name"
                placeholder="John"
                value="<?= htmlspecialchars($_POST['first_name'] ?? $user['first_name']) ?>"
                required>
            </div>
            <div class="account-field">
              <label class="account-label" for="last_name">Last Name</label>
              <input class="account-input" type="text" id="last_name" name="last_name"
                placeholder="Doe"
                value="<?= htmlspecialchars($_POST['last_name'] ?? $user['last_name']) ?>"
                required>
            </div>
          </div>

          <div class="account-row">
            <div class="account-field">
              <label class="account-label" for="dob">Date of Birth</label>
              <input class="account-input" type="date" id="dob" name="dob"
                value="<?= htmlspecialchars($_POST['dob'] ?? $user['dob']) ?>"
                required>
            </div>
            <div class="account-field">
              <label class="account-label" for="gender">Gender</label>
              <select class="account-input account-select" id="gender" name="gender" required>
                <option value="" disabled <?= empty($_POST['gender'] ?? $user['gender']) ? 'selected' : '' ?>>Select</option>
                <option value="male" <?= (($_POST['gender'] ?? $user['gender']) === 'male')       ? 'selected' : '' ?>>Male</option>
                <option value="female" <?= (($_POST['gender'] ?? $user['gender']) === 'female')     ? 'selected' : '' ?>>Female</option>
                <option value="other" <?= (($_POST['gender'] ?? $user['gender']) === 'other')      ? 'selected' : '' ?>>Other</option>
                <option value="prefer_not" <?= (($_POST['gender'] ?? $user['gender']) === 'prefer_not') ? 'selected' : '' ?>>Prefer not to say</option>
              </select>
            </div>
          </div>
        </div>

        <!-- ── Contact ── -->
        <div class="account-section">
          <h2 class="account-section-title">Contact Details</h2>

          <!-- Email + Send code -->
          <label class="account-label" for="email">Email Address</label>
          <div class="account-email-row">
            <input class="account-input account-email-input" type="email" id="email" name="email"
              placeholder="you@email.com"
              value="<?= htmlspecialchars($_POST['email'] ?? $user['email']) ?>"
              required>
            <button class="code-btn" type="submit" name="send_code" value="1" formnovalidate>
              Send Code
            </button>
          </div>
          <input type="hidden" name="email_for_code"
            value="<?= htmlspecialchars($_POST['email'] ?? $user['email']) ?>">

          <?php if ($code_sent): ?>
            <p class="code-sent">Your code is: <strong><?= $_SESSION['verify_code'] ?></strong> — expires in 10 minutes.</p>
          <?php endif; ?>
          <?php if ($code_error): ?>
            <p class="code-error"><?= htmlspecialchars($code_error) ?></p>
          <?php endif; ?>

          <p class="account-hint">Only required if you are changing your email address.</p>

          <label class="account-label" for="verify_code">Verification Code</label>
          <input class="account-input" type="text" id="verify_code" name="verify_code"
            placeholder="6-digit code" maxlength="6">

          <!-- Phone -->
          <label class="account-label" for="phone">Phone Number</label>
          <div class="account-phone-row">
            <input class="account-input account-phone-prefix" type="text" name="phone_code"
              placeholder="+61"
              value="<?= htmlspecialchars($_POST['phone_code'] ?? $user['phone_code']) ?>"
              maxlength="5">
            <input class="account-input account-phone-input" type="tel" id="phone" name="phone"
              placeholder="4XXXXXXXX"
              value="<?= htmlspecialchars($_POST['phone'] ?? $user['phone']) ?>"
              required>
          </div>
        </div>

        <!-- ── Password ── -->
        <div class="account-section">
          <h2 class="account-section-title">Change Password</h2>
          <p class="account-hint">Leave these blank to keep your current password.</p>

          <label class="account-label" for="current_password">Current Password</label>
          <input class="account-input" type="password" id="current_password" name="current_password"
            placeholder="Your current password">

          <label class="account-label" for="new_password">New Password</label>
          <input class="account-input" type="password" id="new_password" name="new_password"
            placeholder="Create a new password">

          <ul class="account-pw-rules">
            <li class="pw-rule <?= ($attempted && !empty($new_pw_display)) ? pw_class(strlen($new_pw_display) >= 8)               : '' ?>">At least 8 characters</li>
            <li class="pw-rule <?= ($attempted && !empty($new_pw_display)) ? pw_class(preg_match('/[A-Z]/', $new_pw_display))     : '' ?>">Uppercase letter (A–Z)</li>
            <li class="pw-rule <?= ($attempted && !empty($new_pw_display)) ? pw_class(preg_match('/[a-z]/', $new_pw_display))     : '' ?>">Lowercase letter (a–z)</li>
            <li class="pw-rule <?= ($attempted && !empty($new_pw_display)) ? pw_class(preg_match('/[0-9]/', $new_pw_display))     : '' ?>">Number (0–9)</li>
            <li class="pw-rule <?= ($attempted && !empty($new_pw_display)) ? pw_class(preg_match('/[\W_]/', $new_pw_display))     : '' ?>">Symbol (!@#$...)</li>
          </ul>

          <label class="account-label" for="confirm_new_password">Confirm New Password</label>
          <input class="account-input" type="password" id="confirm_new_password" name="confirm_new_password"
            placeholder="Repeat your new password">

          <?php if ($attempted && !empty($new_pw_display)): ?>
            <p class="account-match-msg <?= ($new_pw_display === $conf_pw_display) ? 'match-ok' : 'match-fail' ?>">
              <?= ($new_pw_display === $conf_pw_display) ? '✓ Passwords match' : '✗ Passwords do not match' ?>
            </p>
          <?php endif; ?>
        </div>

        <button class="account-save-btn" type="submit" name="save_all" value="1">Save Changes</button>
        <button class="account-signout-btn" name="signout" value="1">Signout</button>

      </form>

      <!-- ════ DANGER ZONE ════ -->
      <div class="account-danger-zone">
        <h2 class="account-danger-title">Danger Zone</h2>
        <p class="account-danger-desc">
          Permanently deletes your account and all associated data.
          This action <strong>cannot be undone.</strong>
        </p>

        <details class="account-danger-details">
          <summary class="account-danger-summary">Delete my account</summary>

          <form class="account-danger-form" action="" method="post">
            <label class="account-label" for="delete_password">Confirm your password to continue</label>
            <input class="account-input account-danger-input" type="password" id="delete_password"
              name="delete_password" placeholder="Enter your password" required>
            <button class="account-danger-btn" type="submit" name="delete_account" value="1">
              Yes, permanently delete my account
            </button>
          </form>
        </details>
      </div>

    </div><!-- /account-card -->
  </main>

  <?php include "footer.inc" ?>
</body>

</html>