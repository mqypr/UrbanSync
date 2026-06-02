# UrbanSync

## UrbanSync Development Website:

- **index.html:** Reach Peng
        Project 2:
        Updated index page for Project 2. Built the DB-driven projects carousel on the home page, loading project data dynamically from MySQL\nImplemented the project search feature on the home page using prepared statements to prevent SQL injection. Designed and implemented the dark/light mode toggle system persisted via cookies across all pages\nBuilt the user authentication system including login.php, signup.php, and account.php with password hashing. Implemented the sticky search bar UI with result cards showing category, date, location, and description. Managed and maintained the overall CSS design system including CSS variables, dark/light theming, responsive layout, and component styles. Set up and structured the MySQL database including the projects table and users table. Wrote and maintained settings.php for centralised database connection handling. Handled security across the site including htmlspecialchars output escaping and prepared statements throughout index.php
- **apply.html:** Liron Willathgamuwa
        Project 2:
        Worked on the Project 2 database integration by creating and structuring the `eoi` MySQL table with all application form fields and status tracking using `New`, `Current`, and `Final` values. Developed `process_eoi.php` to securely handle form submissions, automatically create the table if it did not exist, validate and sanitise all user input on the server side, and insert validated records into the database while displaying the generated `EOInumber` on success. Updated the application form to submit using `POST` and added protection against direct URL access to `process_eoi.php`. Contributed to the manager system in `manage.php` by implementing features to list, search, sort, update, and delete Expression of Interest records. Assisted with maintaining the shared CSS design and responsive layout across the project while also improving site security through prepared statements, session handling, and `htmlspecialchars` escaping throughout the database-driven features.
- **job.html/job01.html/job02.html:** Dylan Kelly
        Projet 2:
        Removed deprecated method for rendering job information resulting in removing Job1 and Job2. Added opened_jobs table in urbansync_db, allowing for dynamic rendering of job information. Added a search bar to jobs.php, allowing for users to search for jobs easily. Added a collapsing function to the Jobs.php aside bar, allowing for the user to reduce the amount of screen realestate the aside bar takes up when needed. Adjusted the CSS of jobs.php to increase accessability for other devices, to address feedback from project 1 and to increase cohesiveness amongst the other web pages of the urbansync website. Split requirements up into 2 pieces- Required Requirements and Recommended Requirements-as adviced from project 1 feedback.
- **about.html:** MD Areen
        Project 2:
        Converted about.html to about.php and loaded member contributions from the database
- **style.css:** Reach Peng/Liron Willathgamuwa/Dylan Kelly/MD Areen