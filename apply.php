<?php
session_start();
require_once './settings.php';

/* errors array */
$errors = $_SESSION['errors'] ?? [];

/* old values */
$old = $_SESSION['old'] ?? [];

/* clear session data after loading */
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Apply - UrbanSync</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.ico">

  <meta name="description" content="UrbanSync, A B2B company specializing in infrastructure analytics and improvement.">
  <meta name="author" content="Reach Peng, Liron Willathgamuwa, Dylan Kelly, MD Areen ">

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

    .error-text {
      color: #ff4d4d;
      font-size: 14px;
      margin-top: 5px;
      margin-bottom: 10px;
    }

  </style>
</head>

<body class="s-body <?php echo (($_COOKIE['dark_mode'] ?? '0') === '1') ? 'dark-mode' : ''; ?>">

  <?php include "header.inc" ?>

  <main class="account-main">

    <section class="apply-form-section apply-card">

      <img src="./images/logo.png" class="logo" alt="UrbanSync logo">

      <h1 class="account-title">Job Application Form</h1>

      <p class="account-subtitle">
        Apply for a position at UrbanSync
      </p>

      <form class="account-form" action="process_eoi.php" method="POST" novalidate>

        <!-- Job Reference Number -->
        <label for="jobRef">Job Reference Number:</label>

        <select id="jobRef" name="jobRef" required>

          <option value="">Select Job Reference</option>

          <?php
          $jobQuery = "SELECT reference_number FROM opened_jobs ORDER BY reference_number ASC";
          $jobResult = mysqli_query($conn, $jobQuery);

          while ($jobRow = mysqli_fetch_assoc($jobResult)) {

            $selected = "";

            if (($old['jobRef'] ?? '') == $jobRow['reference_number']) {
              $selected = "selected";
            }

            echo "<option value='" . htmlspecialchars($jobRow['reference_number']) . "' $selected>";
            echo htmlspecialchars($jobRow['reference_number']);
            echo "</option>";
          }
          ?>

        </select>

        <?php
        if (isset($errors["jobRef"])) {
          echo "<p class='error-text'>" . $errors["jobRef"] . "</p>";
        }
        ?>

        <br><br>

        <!-- First Name -->
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName"
          value="<?php echo htmlspecialchars($old['firstName'] ?? ''); ?>"
          pattern="[A-Za-z]{1,20}" required>

        <?php
        if (isset($errors["firstName"])) {
          echo "<p class='error-text'>" . $errors["firstName"] . "</p>";
        }
        ?>

        <br><br>

        <!-- Last Name -->
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName"
          value="<?php echo htmlspecialchars($old['lastName'] ?? ''); ?>"
          pattern="[A-Za-z]{1,20}" required>

        <?php
        if (isset($errors["lastName"])) {
          echo "<p class='error-text'>" . $errors["lastName"] . "</p>";
        }
        ?>

        <br><br>

        <!-- Date of Birth -->
        <label for="dob">Date of Birth (dd/mm/yyyy):</label>
        <input type="text" id="dob" name="dob"
          value="<?php echo htmlspecialchars($old['dob'] ?? ''); ?>"
          pattern="\d{2}/\d{2}/\d{4}"
          placeholder="dd/mm/yyyy"
          required>

        <?php
        if (isset($errors["dob"])) {
          echo "<p class='error-text'>" . $errors["dob"] . "</p>";
        }
        ?>

        <br><br>

        <!-- Gender -->
        <fieldset>

          <legend>Gender:</legend>

          <div class="option-row">
            <input type="radio" id="male" name="gender" value="Male"
              <?php if (($old['gender'] ?? '') == 'Male') echo 'checked'; ?>>
            <label for="male">Male</label>
          </div>

          <div class="option-row">
            <input type="radio" id="female" name="gender" value="Female"
              <?php if (($old['gender'] ?? '') == 'Female') echo 'checked'; ?>>
            <label for="female">Female</label>
          </div>

          <div class="option-row">
            <input type="radio" id="other" name="gender" value="Other"
              <?php if (($old['gender'] ?? '') == 'Other') echo 'checked'; ?>>
            <label for="other">Other</label>
          </div>

          <?php
          if (isset($errors["gender"])) {
            echo "<p class='error-text'>" . $errors["gender"] . "</p>";
          }
          ?>

        </fieldset>

        <br>

        <!-- Street Address -->
        <label for="address">Street Address:</label>
        <input type="text" id="address" name="address"
          value="<?php echo htmlspecialchars($old['address'] ?? ''); ?>"
          maxlength="40" required>

        <?php
        if (isset($errors["address"])) {
          echo "<p class='error-text'>" . $errors["address"] . "</p>";
        }
        ?>

        <br><br>

        <!-- Suburb/Town -->
        <label for="suburb">Suburb/Town:</label>
        <input type="text" id="suburb" name="suburb"
          value="<?php echo htmlspecialchars($old['suburb'] ?? ''); ?>"
          maxlength="40" required>

        <?php
        if (isset($errors["suburb"])) {
          echo "<p class='error-text'>" . $errors["suburb"] . "</p>";
        }
        ?>

        <br><br>

        <!-- State -->
        <label for="state">State:</label>

        <select id="state" name="state" required>

          <option value="">Select</option>

          <option value="VIC" <?php if (($old['state'] ?? '') == 'VIC') echo 'selected'; ?>>VIC</option>
          <option value="NSW" <?php if (($old['state'] ?? '') == 'NSW') echo 'selected'; ?>>NSW</option>
          <option value="QLD" <?php if (($old['state'] ?? '') == 'QLD') echo 'selected'; ?>>QLD</option>
          <option value="NT" <?php if (($old['state'] ?? '') == 'NT') echo 'selected'; ?>>NT</option>
          <option value="WA" <?php if (($old['state'] ?? '') == 'WA') echo 'selected'; ?>>WA</option>
          <option value="SA" <?php if (($old['state'] ?? '') == 'SA') echo 'selected'; ?>>SA</option>
          <option value="TAS" <?php if (($old['state'] ?? '') == 'TAS') echo 'selected'; ?>>TAS</option>
          <option value="ACT" <?php if (($old['state'] ?? '') == 'ACT') echo 'selected'; ?>>ACT</option>

        </select>

        <?php
        if (isset($errors["state"])) {
          echo "<p class='error-text'>" . $errors["state"] . "</p>";
        }
        ?>

        <br><br>

        <!-- Postcode -->
        <label for="postcode">Postcode:</label>
        <input type="text" id="postcode" name="postcode"
          value="<?php echo htmlspecialchars($old['postcode'] ?? ''); ?>"
          pattern="\d{4}" required>

        <?php
        if (isset($errors["postcode"])) {
          echo "<p class='error-text'>" . $errors["postcode"] . "</p>";
        }
        ?>

        <br><br>

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
          value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
          required>

        <?php
        if (isset($errors["email"])) {
          echo "<p class='error-text'>" . $errors["email"] . "</p>";
        }
        ?>

        <br><br>

        <!-- Phone Number -->
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone"
          value="<?php echo htmlspecialchars($old['phone'] ?? ''); ?>"
          pattern="[0-9]{8,12}"
          placeholder="Phone number"
          required>

        <?php
        if (isset($errors["phone"])) {
          echo "<p class='error-text'>" . $errors["phone"] . "</p>";
        }
        ?>

        <br><br>

        <!-- Skill List -->
        <fieldset>

          <legend>Skills:</legend>

          <div class="option-row">
            <input type="checkbox" id="skill1" name="skills[]" value="Programming">
            <label for="skill1">Programming</label>
          </div>

          <div class="option-row">
            <input type="checkbox" id="skill2" name="skills[]" value="Networking">
            <label for="skill2">Networking</label>
          </div>

          <div class="option-row">
            <input type="checkbox" id="skill3" name="skills[]" value="Data Analysis">
            <label for="skill3">Data Analysis</label>
          </div>

          <div class="option-row">
            <input type="checkbox" id="skill4" name="skills[]" value="Project Management">
            <label for="skill4">Project Management</label>
          </div>

        </fieldset>

        <br>

        <!-- Other Skills -->
        <label for="otherSkills">Other Skills:</label>

        <textarea id="otherSkills" name="otherSkills" rows="4" cols="50"><?php echo htmlspecialchars($old['otherSkills'] ?? ''); ?></textarea>

        <br><br>

        <!-- Submit Button -->
        <input type="submit" value="Submit Application">

      </form>

    </section>

  </main>

  <?php include "footer.inc" ?>

</body>

</html>
