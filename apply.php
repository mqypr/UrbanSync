<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/style.css">
  <title>Apply - UrbanSync</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="UrbanSync, A B2B company specializing in infrastructure analytics and improvement.">
  <meta name="author" content="Reach Peng, Liron Willathgamuwa, Dylan Kelly, MD Areen ">

  <style>
    main {
      max-width: 1200px;
      margin: 3rem auto;
      padding-left: 1.5rem;
      padding-right: 1.5rem;
    }

    @media (max-width: 768px) {
      main {
        margin: 2rem auto;
        padding-left: 1rem;
        padding-right: 1rem;
      }

      .apply-form-section {
        padding: 1.5rem;
      }

      .apply-form-section h1 {
        font-size: 1.6rem;
      }

      .dob-wrapper {
        flex-direction: column;
        gap: 8px;
      }
    }
  </style>
</head>

<body>
  <!-- Header & Navbar -->
  <?php include "header.inc" ?>

  <main>
    <section class="apply-form-section">
      <h1 style="color: #09637e;">Job Application Form</h1>
      <form action="https://mercury.swin.edu.au/it000000/formtest.php" method="POST">

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

  <!--FOOTER-->
  <?php include "footer.inc" ?>
</body>

</html>