<?php

session_start();

require_once("settings.php");

/* stop direct access */
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

/* dark mode */
$darkMode = $_COOKIE['dark_mode'] ?? '0';

/* check connection */
if (!$conn) {
    die("Database connection failed");
}

/* create EOI table automatically if it does not exist */

$create_eoi_table = "
CREATE TABLE IF NOT EXISTS eoi (

    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    jobRef VARCHAR(5) NOT NULL,
    firstName VARCHAR(20) NOT NULL,
    lastName VARCHAR(20) NOT NULL,
    dob VARCHAR(10) NOT NULL,
    gender VARCHAR(20) NOT NULL,
    address VARCHAR(40) NOT NULL,
    suburb VARCHAR(40) NOT NULL,
    state VARCHAR(20) NOT NULL,
    postcode VARCHAR(4) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(12) NOT NULL,
    skills TEXT,
    otherSkills TEXT,
    status VARCHAR(20) NOT NULL DEFAULT 'New'
)
";

mysqli_query($conn, $create_eoi_table);

/* clean input */
function clean_input(string $data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

/* get form data */
$jobRef = clean_input($_POST["jobRef"] ?? "");
$firstName = clean_input($_POST["firstName"] ?? "");
$lastName = clean_input($_POST["lastName"] ?? "");
$dob = clean_input($_POST["dob"] ?? "");
$gender = clean_input($_POST["gender"] ?? "");
$address = clean_input($_POST["address"] ?? "");
$suburb = clean_input($_POST["suburb"] ?? "");
$state = clean_input($_POST["state"] ?? "");
$postcode = clean_input($_POST["postcode"] ?? "");
$email = clean_input($_POST["email"] ?? "");
$phone = clean_input($_POST["phone"] ?? "");

$skills = "";
$otherSkills = "";

if (isset($_POST["skills"])) {
    $skills = implode(", ", $_POST["skills"]);
    $skills = clean_input($skills);
}

if (isset($_POST["otherSkills"])) {
    $otherSkills = clean_input($_POST["otherSkills"]);
}

/* validation */
$errors = [];

if (empty($jobRef)) {
    $errors["jobRef"] = "Please select a Job Reference.";
}

if (!preg_match("/^[A-Za-z]{1,20}$/", $firstName)) {
    $errors["firstName"] = "First Name must only contain letters and max 20 characters.";
}

if (!preg_match("/^[A-Za-z]{1,20}$/", $lastName)) {
    $errors["lastName"] = "Last Name must only contain letters and max 20 characters.";
}

if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
    $errors["dob"] = "Date of Birth must be in dd/mm/yyyy format.";
}

if ($gender == "") {
    $errors["gender"] = "Gender is required.";
}

if ($address == "" || strlen($address) > 40) {
    $errors["address"] = "Street Address is required and max 40 characters.";
}

if ($suburb == "" || strlen($suburb) > 40) {
    $errors["suburb"] = "Suburb is required and max 40 characters.";
}

if ($state == "") {
    $errors["state"] = "State is required.";
}

if (!preg_match("/^[0-9]{4}$/", $postcode)) {
    $errors["postcode"] = "Postcode must be 4 numbers.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Email is not valid.";
}

if (!preg_match("/^[0-9]{8,12}$/", $phone)) {
    $errors["phone"] = "Phone number must be 8 to 12 numbers.";
}

/* if errors redirect back */
if (!empty($errors)) {

    $_SESSION['errors'] = $errors;

    $_SESSION['old'] = [
        'jobRef' => $jobRef,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'dob' => $dob,
        'gender' => $gender,
        'address' => $address,
        'suburb' => $suburb,
        'state' => $state,
        'postcode' => $postcode,
        'email' => $email,
        'phone' => $phone,
        'otherSkills' => $otherSkills
    ];

    header("Location: apply.php");
    exit();
}

$success = false;
$eoiNumber = "";

/* insert if no errors */

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO eoi
    (
        jobRef,
        firstName,
        lastName,
        dob,
        gender,
        address,
        suburb,
        state,
        postcode,
        email,
        phone,
        skills,
        otherSkills
    )
    VALUES
    (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )"
);

mysqli_stmt_bind_param(
    $stmt,
    "sssssssssssss",
    $jobRef,
    $firstName,
    $lastName,
    $dob,
    $gender,
    $address,
    $suburb,
    $state,
    $postcode,
    $email,
    $phone,
    $skills,
    $otherSkills
);

$result = mysqli_stmt_execute($stmt);

if ($result) {

    $success = true;

    $eoiNumber = mysqli_insert_id($conn);
} else {

    die("Error inserting record.");
}

mysqli_stmt_close($stmt);

/* close database */
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Job Application - UrbanSync</title>
    <link rel="icon" type="image/x-icon" href="./images/logo.ico">
    <meta name="description"
        content="UrbanSync, A B2B company specializing in infrastructure analytics and improvement.">
    <meta name="author" content="Reach Peng, Liron Willathgamuwa, Dylan Kelly, MD Areen ">

    <title>Application Submitted</title>

    <style>
        <?php

        if ($darkMode === '1') {
            $backgroundImage = './styles/images/index-bg-dark.jpeg';
            $cardBackground = 'rgba(0, 0, 0, 0.72)';
            $titleColor = 'white';
            $subtitleColor = 'rgba(255,255,255,0.65)';
            $buttonColor = '#088395';
            $buttonHover = '#09637e';
            $shadow = '0 25px 80px rgba(0,0,0,0.45)';
        } else {
            $backgroundImage = './styles/images/index-bg.jpeg';
            $cardBackground = 'rgba(255,255,255,0.92)';
            $titleColor = '#09637e';
            $subtitleColor = '#1a3a47';
            $buttonColor = '#09637e';
            $buttonHover = '#088395';
            $shadow = '0 20px 35px -12px rgba(9,99,126,0.2)';
        }

        ?>body {
            min-height: 100vh;
            background-image: url("<?php echo $backgroundImage; ?>");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 14px 20px 60px;
        }

        .page-card {
            width: 100%;
            max-width: 900px;
            background: <?php echo $cardBackground; ?>;
            border-radius: 28px;
            padding: 55px 50px;
            box-shadow: <?php echo $shadow; ?>;
            text-align: center;
            backdrop-filter: blur(8px);
        }

        .logo {
            width: 86px;
            height: 86px;
            border-radius: 50%;
            border: 2px solid #cfe3e6;
            margin-bottom: 34px;
        }

        h1 {
            color: <?php echo $titleColor; ?>;
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 24px;
            line-height: 1.2;
        }

        .subtitle {
            color: <?php echo $subtitleColor; ?>;
            font-size: 28px;
            margin-bottom: 28px;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 18px 42px;
            background-color: <?php echo $buttonColor; ?>;
            color: white;
            text-decoration: none;
            border-radius: 16px;
            font-size: 20px;
            font-weight: bold;
        }

        .button:hover {
            background-color: <?php echo $buttonHover; ?>;
        }
    </style>

</head>

<body>

    <main class="page-card">

        <img src="./images/logo.png" class="logo" alt="UrbanSync Logo">

        <h1>Application Submitted Successfully</h1>

        <p class="subtitle">
            Your EOI Number is: <?php echo $eoiNumber; ?>
        </p>

        <p class="subtitle">
            Status: New
        </p>

        <a href="apply.php" class="button">
            Back to Apply Page
        </a>

    </main>

</body>

</html>