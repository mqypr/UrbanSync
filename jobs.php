<?php
session_start();
require_once './settings.php';


// job content data
if (isset($_GET["ref"])) {

    // Get the superglobal variable "ref" and convert it into a int
    $selected_ref = intval($_GET["ref"]);

    $content_sql = "SELECT * FROM opened_jobs
                    WHERE reference_number = $selected_ref
                    LIMIT 1";
} else {
    $content_sql = "SELECT * FROM opened_jobs LIMIT 1";
}

// store the table data to $content_result
$content_result = mysqli_query($conn, $content_sql);


// aside bar data
$side_sql = "SELECT * FROM opened_jobs";
$side_result = mysqli_query($conn, $side_sql);

if (!$side_result || !$content_result) {
    die("Query Failed: " . mysqli_error($conn));
}

$job_content = mysqli_fetch_assoc($content_result);

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="UrbanSync, A B2B company specializing in infrastructure analytics and improvement.">
    <meta name="author" content="Reach Peng, Liron Willathgamuwa, Dylan Kelly, MD Areen ">

</head>




<body id="JobsPage">

    <?php include "header.inc"; ?>


    <div class="jobs-layout">

        <!-- Aside bar Collapse Button Input -->
        <input type="checkbox" id="JobNavToggle" class="JobNavToggle">


        <!-- Job Aside Navigation Box -->
        <aside id="JobNav">
            
            <div id="JobNavHeader">

                <h1 style="color:white;">Jobs</h1>

                <!-- Aside bar collapse button -->
                <label for="JobNavToggle" class="JobNavToggleButton">☰</label>
                
            </div>


            <div class="JobContainer">

                <!-- Loop through every row of the table and create sections  -->
                <?php while ($jobrow = mysqli_fetch_assoc($side_result)) { ?>


                    <!-- Set ref for loading correct content when clicked -->
                    <a href="jobs.php?ref=<?php echo htmlspecialchars($jobrow["reference_number"]); ?>">

                        <section class="JobSection">

                            <!-- Title  -->
                            <h2>

                                <?php
                                // We echo the title of the job
                                echo htmlspecialchars($jobrow["title"])
                                ?>

                            </h2>

                            <!-- Salary -->
                            <p>

                                <?php

                                // Because the varchar stored in salary is seperated by a ^, we split the salary into an array and remove ^
                                $salary = explode("^", $jobrow["salary"]);

                                // We echo the first element in $salary array
                                echo ("$" . htmlspecialchars($salary[0]));

                                // If there is a second element within the array, echo this also
                                if (isset($salary[1])) {
                                    echo ("  - $" . htmlspecialchars($salary[1]));
                                }

                                // If there is only 1 element, we will echo 1 number; example $60,000
                                // If there are 2 elements however, we will echo both; example $60,000 - $70,000

                                ?>

                            </p>

                            <!-- Short Description -->
                            <p>

                                <?php

                                echo htmlspecialchars($jobrow["short_description"]);

                                ?>


                            </p>

                        </section>


                    </a>

                <?php } ?>

            </div>
        </aside>


        <!-- Job Content -->
        <main id="JobContent">

            <article id="JobArticle">

                <section id="JobTitle">

                    <!-- Title of the opened job -->
                    <h2>

                        <?php
                        // We echo the title of the job
                        echo htmlspecialchars($job_content["title"])
                        ?>

                    </h2>

                    <!-- Reference number for the opened job -->
                    <h3>

                        <?php

                        // We echo the reference number of the job
                        echo htmlspecialchars($job_content["reference_number"])
                        ?>

                    </h3>

                    <!-- Listed salary for job title -->
                    <p>

                        <?php

                        // Because the varchar stored in salary is seperated by a ^, we split the salary into an array and remove ^
                        $salary = explode("^", $job_content["salary"]);

                        // We echo the first element in $salary array
                        echo ("$" . htmlspecialchars($salary[0]));

                        // If there is a second element within the array, echo this also
                        if (isset($salary[1])) {
                            echo ("  - $" . htmlspecialchars($salary[1]));
                        }

                        // If there is only 1 element, we will echo 1 number; example $60,000
                        // If there are 2 elements however, we will echo both; example $60,000 - $70,000

                        ?>

                    </p>

                </section>

                <section id="JobInfo">

                    <!-- Job Title -->
                    <h2>

                        <?php

                        // We echo job into the information content 
                        echo htmlspecialchars($job_content["title"]);

                        ?>

                    </h2>

                    <!-- Key Reporting Line -->
                    <h2>Key Reporting Line</h2>
                    <ol id="JobReportingLine">

                        <?php

                        // Because the varchar stored in reporting_line is seperated by a ^, we split the salary into an array and remove ^
                        $reporting_line = explode("^", $job_content["reporting_line"]);

                        // For every item inside of $reporting_line we print it's corresponding element within a list tag
                        foreach ($reporting_line as $rep) {

                            //echo the item within $reporting_line within html list tags
                            echo ("<li>" . htmlspecialchars($rep) . "</li>");
                        }

                        ?>

                    </ol>

                    <h2>Key Responsibilities</h2>
                    <ol id="JobResponsobilities">

                        <?php

                        // Because the varchar stored in responsobilities is seperated by a ^, we split the salary into an array and remove ^
                        $responsobilities = explode("^", $job_content["responsobilities"]);

                        // For every item inside of $responsobilities we print it's corresponding element within a list tag
                        foreach ($responsobilities as $res) {

                            //echo the item within $responsobilities within html list tags
                            echo ("<li>" . htmlspecialchars($res) . "</li>");
                        }

                        ?>

                    </ol>

                    <h2>Personal Requirements</h2>
                    <ul id="JobPersonalRequirements">

                        <?php

                        // Because the varchar stored in requirements is seperated by a ^, we split the salary into an array and remove ^
                        $requirements = explode("^", $job_content["requirements"]);

                        // For every item inside of $requirements we print it's corresponding element within a list tag
                        foreach ($requirements as $req) {

                            //echo the item within $requirements within html list tags
                            echo ("<li>" . htmlspecialchars($req) . "</li>");
                        }

                        ?>

                    </ul>

                </section>
            </article>


        </main>

    </div>

    <!--FOOTER-->
    <?php include "footer.inc" ?>

</body>

</html>