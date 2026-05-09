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
    <?php include "header.inc" ?>
    <div class="jobs-layout">

        <!-- Job Aside Navigation Box -->
        <aside id="JobNav">
            <h1 style="color:white;">Jobs</h1>

            <div class="JobContainer">

                <!-- Job 1 -->
                <a href="./jobs/job01.php" target="contentMain"> <!--bm1-->
                    <section class="JobSection">
                        <h2>Frontend Web Developer</h2>
                        <p>$70,000 - $85,000</p>
                        <p>Build and maintain clean, responsive interfaces for company websites.</p>
                    </section>
                </a>

                <!-- Job 2 -->
                <a href="jobs/job02.php" target="contentMain">
                    <section class="JobSection">
                        <h2>IT Support Officer</h2>
                        <p>$55,000 - $68,000</p>
                        <p>Provide technical support and help staff resolve hardware and software issues.</p>
                    </section>
                </a>
            </div>
        </aside>


        <!-- Inline Frame for job details and information -->
        <main id="JobContent">
            <iframe id="JobsContentMain" name="contentMain" src="jobs/job01.php" title="Job Information"></iframe>
        </main>
    </div>

    <footer>
        <nav>
            <div class="footer-container">
                <div class="footer-column">
                    <h2 class="footer-column-title">Pages</h2>
                    <ul class="footer-column-list">
                        <li class="footer-column-item">
                            <a href="/index.html">Home</a>
                        </li>
                        <li class="footer-column-item">
                            <a href="/jobs.html">Job Description</a>
                        </li>
                        <li class="footer-column-item">
                            <a href="/apply.html">Apply</a>
                        </li>
                        <li class="footer-column-item">
                            <a href="/about.html">About</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h2 class="footer-column-title">Resources</h2>
                    <ul class="footer-column-list">
                        <li class="footer-column-item">
                            <a href="https://github.com/mqypr/UrbanSync">Github Repository</a>
                        </li>
                        <li class="footer-column-item">
                            <a class="footer-column-item"
                                href="https://pengreach123.atlassian.net/?continue=https%3A%2F%2Fpengreach123.atlassian.net%2Fwelcome%2Fsoftware%3FprojectId%3D10033&atlOrigin=eyJpIjoiOGMzNTY2NzRmYTE2NGY5MzkxNmFkNDQ3ZmFmNWVmYmYiLCJwIjoiamlyYS1zb2Z0d2FyZSJ9">Jira
                            </a>
                        </li>
                        <li class="footer-column-item">
                            <a class="footer-column-item" href="https://mqypr.github.io/UrbanSync/">Live Link</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h2 class="footer-column-title">Contact Us</h2>
                    <ul class="footer-column-list">
                        <li class="footer-column-item">
                            <a href="mailto:blank" class="footer-column-item">Email</a>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
    </footer>

</body>

</html>