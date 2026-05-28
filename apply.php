<?php
session_start();
require_once './settings.php';
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
  </style>
</head>

<body class="s-body <?php echo (($_COOKIE['dark_mode'] ?? '0') === '1') ? 'dark-mode' : ''; ?>">

  <!-- Header & Navbar -->
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
        <input type="text" id="jobRef" name="jobRef" pattern="[A-Za-z0-9]{5}" required>
        <br><br>

        <!-- First Name -->
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" pattern="[A-Za-z]{1,20}" required>
        <br><br>

        <!-- Last Name -->
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" pattern="[A-Za-z]{1,20}" required>
        <br><br>

        <!-- Date of Birth -->
        <label for="dob">Date of Birth (dd/mm/yyyy):</label>
        <input type="text" id="dob" name="dob" pattern="\d{2}/\d{2}/\d{4}" placeholder="dd/mm/yyyy" required>
        <br><br>

        <!-- Gender -->
        <fieldset>
          <legend>Gender:</legend>

          <div class="option-row">
            <input type="radio" id="male" name="gender" value="Male" required>
            <label for="male">Male</label>
          </div>

          <div class="option-row">
            <input type="radio" id="female" name="gender" value="Female" required>
            <label for="female">Female</label>
          </div>

          <div class="option-row">
            <input type="radio" id="other" name="gender" value="Other" required>
            <label for="other">Other</label>
          </div>
        </fieldset>

        <br>

        <!-- Street Address -->
        <label for="address">Street Address:</label>
        <input type="text" id="address" name="address" maxlength="40" required>
        <br><br>

        <!-- Suburb/Town -->
        <label for="suburb">Suburb/Town:</label>
        <input type="text" id="suburb" name="suburb" maxlength="40" required>
        <br><br>

        <!-- State -->
        <label for="state">State:</label>
        <select id="state" name="state" required>
          <option value="">Select</option>
          <option value="VIC">VIC</option>
          <option value="NSW">NSW</option>
          <option value="QLD">QLD</option>
          <option value="NT">NT</option>
          <option value="WA">WA</option>
          <option value="SA">SA</option>
          <option value="TAS">TAS</option>
          <option value="ACT">ACT</option>
        </select>

        <br><br>

        <!-- Postcode -->
        <label for="postcode">Postcode:</label>
        <input type="text" id="postcode" name="postcode" pattern="\d{4}" required>
        <br><br>

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <!-- Phone Number -->
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{8,12}" placeholder="Phone number" required>

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
        <textarea id="otherSkills" name="otherSkills" rows="4" cols="50"></textarea>

        <br><br>

        <!-- Submit Button -->
        <input type="submit" value="Submit Application">

      </form>

    </section>

  </main>

  <!-- FOOTER -->
  <?php include "footer.inc" ?>

</body>

</html>