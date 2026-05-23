<?php

// connect settings file
require_once("settings.php");

// clean user input
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// stop direct access
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

// connect to database
$conn = mysqli_connect($host, $db_user, $db_pass, $database);

// check connection
if (!$conn) {
    die("Database connection failed");
}

// create eoi table if it does not exist
$table = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    jobRef VARCHAR(5),
    firstName VARCHAR(20),
    lastName VARCHAR(20),
    dob VARCHAR(10),
    gender VARCHAR(10),
    address VARCHAR(40),
    suburb VARCHAR(40),
    state VARCHAR(5),
    postcode VARCHAR(4),
    email VARCHAR(100),
    phone VARCHAR(12),
    skills TEXT,
    otherSkills TEXT,
    status ENUM('New', 'Current', 'Final') DEFAULT 'New'
)";

mysqli_query($conn, $table);

// get and clean form data
$jobRef = clean_input($_POST["jobRef"]);
$firstName = clean_input($_POST["firstName"]);
$lastName = clean_input($_POST["lastName"]);
$dob = clean_input($_POST["dob"]);
$gender = clean_input($_POST["gender"]);
$address = clean_input($_POST["address"]);
$suburb = clean_input($_POST["suburb"]);
$state = clean_input($_POST["state"]);
$postcode = clean_input($_POST["postcode"]);
$email = clean_input($_POST["email"]);
$phone = clean_input($_POST["phone"]);

$otherSkills = "";

if (isset($_POST["otherSkills"])) {
    $otherSkills = clean_input($_POST["otherSkills"]);
}

$skills = "";

if (isset($_POST["skills"])) {
    $skills = implode(", ", $_POST["skills"]);
    $skills = clean_input($skills);
}

// validation
$errors = "";

if (!preg_match("/^[A-Za-z0-9]{5}$/", $jobRef)) {
    $errors .= "<p>Job Reference must be 5 letters or numbers.</p>";
}

if (!preg_match("/^[A-Za-z]{1,20}$/", $firstName)) {
    $errors .= "<p>First Name must only contain letters and max 20 characters.</p>";
}

if (!preg_match("/^[A-Za-z]{1,20}$/", $lastName)) {
    $errors .= "<p>Last Name must only contain letters and max 20 characters.</p>";
}

if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
    $errors .= "<p>Date of Birth must be in dd/mm/yyyy format.</p>";
}

if ($gender == "") {
    $errors .= "<p>Gender is required.</p>";
}

if ($address == "" || strlen($address) > 40) {
    $errors .= "<p>Street Address is required and must be max 40 characters.</p>";
}

if ($suburb == "" || strlen($suburb) > 40) {
    $errors .= "<p>Suburb is required and must be max 40 characters.</p>";
}

if ($state == "") {
    $errors .= "<p>State is required.</p>";
}

if (!preg_match("/^[0-9]{4}$/", $postcode)) {
    $errors .= "<p>Postcode must be 4 numbers.</p>";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors .= "<p>Email is not valid.</p>";
}

if (!preg_match("/^[0-9]{8,12}$/", $phone)) {
    $errors .= "<p>Phone number must be 8 to 12 numbers.</p>";
}

// show errors
if ($errors != "") {

    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='./styles/style.css'>
        <title>Form Error</title>
    </head>
    <body>
        <main>
            <section class='apply-form-section'>
                <h1>Form Error</h1>
                $errors
                <p><a href='apply.php'>Go Back</a></p>
            </section>
        </main>
    </body>
    </html>
    ";
} else {

    // insert data
    $query = "INSERT INTO eoi
    (jobRef, firstName, lastName, dob, gender, address, suburb, state, postcode, email, phone, skills, otherSkills)
    VALUES
    ('$jobRef', '$firstName', '$lastName', '$dob', '$gender', '$address', '$suburb', '$state', '$postcode', '$email', '$phone', '$skills', '$otherSkills')";

    $result = mysqli_query($conn, $query);

    if ($result) {

        $eoiNumber = mysqli_insert_id($conn);

        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='./styles/style.css'>
            <title>Application Success</title>

            <style>
                body {
                    background-color: #EBF4F6;
                }

                .message-box {
                    max-width: 800px;
                    margin: 80px auto;
                    background-color: white;
                    padding: 40px;
                    border-radius: 28px;
                    border: 1px solid #d4e9ec;
                    box-shadow: 0 20px 35px -12px rgba(9, 99, 126, 0.2);
                    text-align: center;
                }

                .message-box h1 {
                    color: #09637E;
                    font-size: 2rem;
                    margin-bottom: 20px;
                }

                .message-box p {
                    color: #1A3A47;
                    font-size: 20px;
                    margin-bottom: 15px;
                }

                .back-button {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 12px 28px;
                    background-color: #09637E;
                    color: white;
                    border-radius: 25px;
                    text-decoration: none;
                    font-weight: bold;
                }

                .back-button:hover {
                    background-color: #088395;
                }
            </style>
        </head>

        <body>
            <div class='message-box'>
                <h1>Application Submitted Successfully</h1>
                <p>Your EOI Number is: $eoiNumber</p>
                <p>Status: New</p>
                <a href='apply.php' class='back-button'>Back to Apply Page</a>
            </div>
        </body>
        </html>
        ";
    } else {
        echo "<p>Error inserting record.</p>";
    }
}

// close database
mysqli_close($conn);
