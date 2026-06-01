<?php
session_start();
require_once './settings.php';


// Search bar data
$search = "";

// If the user has searched for something, get the search value
if (isset($_GET["search"])) {

    // We trim the search so empty spaces at the start and end are removed
    $search = trim($_GET["search"]);
}


// Search SQL data
$search_sql = "";

// If the search bar is not empty, filter the jobs table
if ($search !== "") {

    // We escape the search so special characters do not break the SQL query
    $safe_search = mysqli_real_escape_string($conn, $search);

    // We search through the main job columns for anything matching the search
    $search_sql = " WHERE title LIKE '%$safe_search%'
                    OR short_description LIKE '%$safe_search%'
                    OR salary LIKE '%$safe_search%'
                    OR reporting_line LIKE '%$safe_search%'
                    OR responsobilities LIKE '%$safe_search%'
                    OR requirements LIKE '%$safe_search%'
                    OR CAST(reference_number AS CHAR) LIKE '%$safe_search%'";
}


// job content data
if (isset($_GET["ref"])) {

    // Get the superglobal variable "ref" and convert it into an int
    $selected_ref = intval($_GET["ref"]);

    // We select the job that matches the reference number clicked by the user
    $content_sql = "SELECT * FROM opened_jobs
                    WHERE reference_number = $selected_ref
                    LIMIT 1";
} else {

    // If no job has been clicked, we load the first job from the search results
    $content_sql = "SELECT * FROM opened_jobs
                    $search_sql
                    LIMIT 1";
}

// store the table data to $content_result
$content_result = mysqli_query($conn, $content_sql);


// aside bar data
// We use the search SQL here so the sidebar only shows jobs matching the search
$side_sql = "SELECT * FROM opened_jobs
             $search_sql";

// store the sidebar table data to $side_result
$side_result = mysqli_query($conn, $side_sql);

// If either query fails, we stop the page and print the SQL error
if (!$side_result || !$content_result) {
    die("Query Failed: " . mysqli_error($conn));
}

// We fetch the selected job content from the database
$job_content = mysqli_fetch_assoc($content_result);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Job Application - UrbanSync</title>
    <link rel="icon" type="image/x-icon" href="./images/logo.ico">
    <meta name="description" content="UrbanSync, A B2B company specializing in infrastructure analytics and improvement.">
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


            <!-- Job Search Bar -->
            <form class="JobSearchForm" method="get" action="jobs.php">

                <!-- Search bar label -->
                <label for="JobSearch" class="JobSearchLabel">Search jobs</label>

                <div class="JobSearchBar">

                    <!-- Search input -->
                    <input type="text" id="JobSearch" name="search" class="JobSearchInput" placeholder="Search by title, salary, reference..." value="<?php echo htmlspecialchars($search); ?>">

                    <!-- Search submit button -->
                    <button type="submit" class="JobSearchButton">
                        <i class="fa fa-search"></i>
                    </button>

                </div>

                <!-- If the user has searched for something, show a clear search link -->
                <?php if ($search !== "") { ?>

                    <a class="JobClearSearch" href="jobs.php">Clear search</a>

                <?php } ?>

            </form>


            <div class="JobContainer">

                <!-- Loop through every row of the table and create sections -->
                <?php while ($jobrow = mysqli_fetch_assoc($side_result)) { ?>


                    <?php

                    // We create the link for each job using its reference number
                    $job_link = "jobs.php?ref=" . urlencode($jobrow["reference_number"]);

                    // If the user has searched for something, keep the search in the URL
                    if ($search !== "") {
                        $job_link .= "&search=" . urlencode($search);
                    }

                    ?>

                    <!-- Set ref for loading correct content when clicked -->
                    <a href="<?php echo htmlspecialchars($job_link); ?>">

                        <section class="JobSection">

                            <!-- Title -->
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

                                // We echo the short description of the job
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

            <?php if ($job_content) { ?>

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


            <?php } else { ?>

                <article id="JobArticle">
                    <section id="JobTitle">
                        <h2>No jobs found</h2>
                        <p>Try searching for another job title, reference number, or keyword.</p>
                    </section>
                </article>

            <?php } ?>

        </main>

    </div>

    <!--FOOTER-->
    <?php include "footer.inc" ?>

</body>

</html>