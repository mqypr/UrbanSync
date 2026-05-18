<?php

// getting the database settings
require_once("settings.php");

// cleaning the user input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// stopping users from opening the page directly
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

// connecting to the database
$conn = mysqli_connect($host, $db_user, $db_pass, $database);

// checking if database connection worked
if (!$conn) {
    die("Database connection failed");
}

// creating the eoi table if it does not exist
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

// running the table query
mysqli_query($conn, $table);

// getting and cleaning form data
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

// setting other skills empty first
$otherSkills = "";

// checking if other skills exists
if (isset($_POST["otherSkills"])) {

    $otherSkills = clean_input($_POST["otherSkills"]);

}

// setting skills empty first
$skills = "";

// checking if skills were selected
if (isset($_POST["skills"])) {

    // joining the skills together
    $skills = implode(", ", $_POST["skills"]);

}

// variable for storing errors
$errors = "";

// checking if job reference is empty
if ($jobRef == "") {

    $errors .= "<p>Job Reference is required</p>";

}

// checking if first name is empty
if ($firstName == "") {

    $errors .= "<p>First Name is required</p>";

}

// checking if last name is empty
if ($lastName == "") {

    $errors .= "<p>Last Name is required</p>";

}

// checking if email is empty
if ($email == "") {

    $errors .= "<p>Email is required</p>";

}

// if there are errors
if ($errors != "") {

    echo "

<!DOCTYPE html>

<html lang='en'>

<head>

    <meta charset='UTF-8'>

    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <link rel='stylesheet' href='./styles/style.css'>

    <title>Form Error</title>

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
            margin-bottom: 20px;
        }

        .message-box p {
            color: #1A3A47;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #09637E;
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
        }

    </style>

</head>

<body>

    <div class='message-box'>

        <h1>Form Error</h1>

        $errors

        <a href='apply.php' class='back-button'>Go Back</a>

    </div>

</body>

</html>

";

} else {

    // sql query for inserting data
    $query = "INSERT INTO eoi

    (jobRef, firstName, lastName, dob, gender, address, suburb, state, postcode, email, phone, skills, otherSkills)

    VALUES

    ('$jobRef', '$firstName', '$lastName', '$dob', '$gender', '$address', '$suburb', '$state', '$postcode', '$email', '$phone', '$skills', '$otherSkills')";

    // running the insert query
    $result = mysqli_query($conn, $query);

    // checking if insert worked
    if ($result) {

        // getting the eoi number
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

        .eoi-number {
            color: #09637E;
            font-weight: bold;
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

    </style>

</head>

<body>

    <div class='message-box'>

        <h1>Application Submitted Successfully</h1>

        <p>Your EOI Number is:
            <span class='eoi-number'>$eoiNumber</span>
        </p>

        <p>Status: New</p>

        <a href='apply.php' class='back-button'>Back to Apply Page</a>

    </div>

</body>

</html>

";

    } else {

        // if insert fails
        echo "<p>Error inserting record</p>";

    }

}

// closing the database connection
mysqli_close($conn);

?>