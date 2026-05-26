<?php
session_start();
require_once './settings.php';

$sql = "SELECT * FROM opened_jobs LIMIT 1";
$result = mysqli_query($conn, $sql);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

$job = mysqli_fetch_assoc($result);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
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

        <!-- Job Aside Navigation Box -->
        <aside id="JobNav">
            <h1 style="color:white;">Jobs</h1>

            <div class="JobContainer">
                
                <a href="" target=""> <!--bm1-->
                    <section class="JobSection">

                        <!-- Title  -->
                        <h2>

                            <?php 
                                // We echo the title of the job
                                echo htmlspecialchars($job["title"]) 
                            ?>

                        </h2>

                        <!-- Salary -->
                        <p>

                            <?php 

                                // Because the varchar stored in salary is seperated by a ^, we split the salary into an array and remove ^
                                $salary = explode("^" , $job["salary"]);

                                // We echo the first element in $salary array
                                echo ("$" . htmlspecialchars($salary[0]));

                                // If there is a second element within the array, echo this also
                                if(isset($salary[1]))
                                {
                                    echo("  - $" . htmlspecialchars($salary[1]));
                                }

                                // If there is only 1 element, we will echo 1 number; example $60,000
                                // If there are 2 elements however, we will echo both; example $60,000 - $70,000

                            ?>

                        </p>

                        <!-- Short Description -->
                        <p>
                            
                            <?php 
                            
                                echo htmlspecialchars($job["short_description"]);

                            ?>


                        </p>

                    </section>
                    
                </a>

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
                            echo htmlspecialchars($job["title"]) 
                        ?>
                        
                    </h2>
                    
                    <!-- Reference number for the opened job -->
                    <h3> 

                        <?php 

                            // We echo the reference number of the job
                            echo htmlspecialchars($job["reference_number"]) 
                        ?>   

                    </h3>

                    <!-- Listed salary for job title -->
                    <p> 

                        <?php 

                            // Because the varchar stored in salary is seperated by a ^, we split the salary into an array and remove ^
                            $salary = explode("^" , $job["salary"]);

                            // We echo the first element in $salary array
                            echo ("$" . htmlspecialchars($salary[0]));

                            // If there is a second element within the array, echo this also
                            if(isset($salary[1]))
                            {
                                echo("  - $" . htmlspecialchars($salary[1]));
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
                            echo htmlspecialchars($job["title"]);

                        ?>

                    </h2>

                    <!-- Key Reporting Line -->
                    <h2>Key Reporting Line</h2>

                    <ol id="JobReportingLine">

                        <?php 

                            // Because the varchar stored in reporting_line is seperated by a ^, we split the salary into an array and remove ^
                            $reporting_line = explode("^" , $job["reporting_line"]);

                            // For every item inside of $reporting_line we print it's corresponding element within a list tag
                            foreach ($reporting_line as $rep)
                                {

                                    //echo the item within $reporting_line within html list tags
                                    echo("<li>$rep</li>");

                                }
                        
                        ?>

                    </ol>

                    <!-- Key Responsobilities -->
                    <h2>Key Responsibilities</h2>

                    <ol id="JobResponsobilities">
                        
                        <?php 

                                // Because the varchar stored in responsobilities is seperated by a ^, we split the salary into an array and remove ^
                                $responsobilities = explode("^" , $job["responsobilities"]);

                                // For every item inside of $responsobilities we print it's corresponding element within a list tag
                                foreach ($responsobilities as $res)
                                    {

                                        //echo the item within $responsobilities within html list tags
                                        echo("<li>$res</li>");

                                    }
                            
                            ?>

                    </ol>
                    
                    <!-- Personal Requirements -->
                    <h2>Personal Requirements</h2>
                    <ul id="JobPersonalRequirements">
                        
                        <?php 

                                // Because the varchar stored in requirements is seperated by a ^, we split the salary into an array and remove ^
                                $requirements = explode("^" , $job["requirements"]);

                                // For every item inside of $requirements we print it's corresponding element within a list tag
                                foreach ($requirements as $req)
                                    {

                                        //echo the item within $requirements within html list tags
                                        echo("<li>$req</li>");

                                    }
                            
                            ?>
                    
                    
                        <!-- <li>Effective communication for team collaboration</li>
                        <li>High adaptability to new technologies</li>
                        <li>A methodical approach to debugging and creating responsive, accessible websites</li> -->
                    </ul>

                </section>

            </article>

        </main>

    </div>

    <!--FOOTER-->
    <?php include "footer.inc" ?>

</body>

</html>