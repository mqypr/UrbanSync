<?php
// about.php
// This page connects to the database and displays group member contributions.

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once("settings.php");

// Check connection
if (!$conn) {
  die("<p>Database connection failed. Please check settings.php.</p>");
}

// Select all records from the about_contributions table
$query = "SELECT * FROM about_contributions ORDER BY id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="About page for UrbanSync group project">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>About - UrbanSync</title>

  <!-- Embedded CSS example -->
  <style>
    .about-container {
      background: white;
      border: 1px solid #d4e9ec;
      border-radius: 20px;
      padding: 2rem;
    }

    .about-section {
      margin-bottom: 2rem;
    }

    .about-section h2 {
      border-bottom: 3px solid #088395;
      padding-bottom: 5px;
      margin-bottom: 10px;
    }

    .about-section ul {
      list-style-type: disc;
      margin-left: 20px;
    }

    .member-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    .member-table th,
    .member-table td {
      border: 1px solid #cfe3e6;
      padding: 10px;
      font-size: 14px;
      text-align: left;
    }

    .member-table th {
      background-color: #09637E;
      color: white;
    }

    .member-table tr:hover {
      background-color: #dceff1;
    }

    .student-id {
      background-color: #EBF4F6;
      border: 1px solid #088395;
      padding: 4px 6px;
      border-radius: 8px;
      display: inline-block;
    }

    dt {
      font-weight: bold;
      margin-top: 10px;
      color: #09637E;
    }

    dd {
      margin-left: 20px;
      margin-bottom: 5px;
      font-size: 14px;
    }

    caption {
      font-weight: bold;
      margin-bottom: 10px;
    }

    figure {
      border: 2px solid #088395;
      border-radius: 12px;
      padding: 10px;
      text-align: center;
    }

    a:focus {
      outline: 2px solid black;
    }
  </style>
</head>

<body>
  <!--HEADER-->
  <?php include "./header.inc" ?>

  <main>
    <div class="about-container">

      <section class="about-section">
        <!-- Inline CSS example -->
        <h1 style="letter-spacing: 1px;">UrbanSync</h1>
        <p>This page introduces our group and loads member contributions from the database.</p>
      </section>

      <section class="about-section">
        <h2>Group Information</h2>
        <ul>
          <li><strong>Group Name:</strong> UrbanSync</li>
          <li>
            <strong>Class Day and Time:</strong>
            <ul>
              <li>Thursday</li>
              <li>4:30 PM - 6:30 PM</li>
            </ul>
          </li>
        </ul>
      </section>

      <section class="about-section">
        <h2>Member Contributions from Database</h2>

        <table class="member-table">
          <caption>UrbanSync Member Contributions</caption>
          <tr>
            <th>Name</th>
            <th>Student ID</th>
            <th>Project 1 Contribution</th>
            <th>Project 2 Contribution</th>
          </tr>

          <?php
          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
              echo "<td><span class='student-id'>" . htmlspecialchars($row["student_id"]) . "</span></td>";
              echo "<td>" . htmlspecialchars($row["first_project"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["second_project"]) . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr>";
            echo "<td colspan='4'>No contribution data found in the database.</td>";
            echo "</tr>";
          }
          ?>
        </table>
      </section>

      <section class="about-section">
        <h2>Member Contributions and Quotes</h2>

        <dl>
          <dt>MD Areen Chowdhury</dt>
          <dd>Developed about.html in Project 1 and converted it to about.php in Project 2.</dd>
          <dd>"কি অবস্থা" — "What's up"</dd>

          <dt>Reach Peng</dt>
          <dd>Developed index.html in Project 1 and updated the home page in Project 2.</dd>
          <dd>"ជីវិតគឺល្អ" — "Life is good"</dd>

          <dt>Liron Roshain Joanic Willathgamuwa</dt>
          <dd>Developed apply.html in Project 1 and updated the apply page in Project 2.</dd>
          <dd>"ජීවිතය ලස්සනයි" — "Life is beautiful"</dd>

          <dt>Dylan Kelly</dt>
          <dd>Developed jobs.html in Project 1 and updated the jobs page in Project 2.</dd>
          <dd>"No worries mate" — "Everything is fine"</dd>
        </dl>
      </section>

      <section class="about-section">
        <h2>Fun Facts</h2>

        <table class="member-table">
          <caption>Group Member Fun Facts</caption>
          <tr>
            <th>Name</th>
            <th>Hometown</th>
            <th>Job</th>
            <th>Favourite Snack</th>
          </tr>

          <tr>
            <td>MD Areen Chowdhury</td>
            <td>Dhaka, Bangladesh</td>
            <td>BOH, Hospitality</td>
            <td>Pizza slice</td>
          </tr>

          <tr>
            <td>Reach Peng</td>
            <td>Phnom Penh, Cambodia</td>
            <td>Casual Worker, Hungry Jack's</td>
            <td>Popcorn</td>
          </tr>

          <tr>
            <td>Liron Roshain Joanic Willathgamuwa</td>
            <td>Wattala, Sri Lanka</td>
            <td>Cyber Security Specialist</td>
            <td>Lasagna</td>
          </tr>

          <tr>
            <td>Dylan Kelly</td>
            <td>Watchupga, VIC, Australia</td>
            <td>Farm Hand</td>
            <td>Scones</td>
          </tr>
        </table>
      </section>

      <section class="about-section">
        <h2>Group Photo</h2>

        <figure>
          <img src="group-photo.jpg" alt="UrbanSync group photo" width="300">
          <figcaption>UrbanSync Group</figcaption>
        </figure>
      </section>

    </div>
  </main>

  <footer>
    <?php include "./footer.inc" ?>
  </footer>

</body>

</html>

<?php
mysqli_close($conn);
?>