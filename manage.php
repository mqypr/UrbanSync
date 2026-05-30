<?php
session_start();

if (!isset($_SESSION["manager"])) {
    header("Location: login.php");
    exit();
}

require_once("settings.php");

$message = "";
$results = [];

/* delete by job reference */
if (isset($_POST["delete_by_job"])) {
    $deleteJobRef = trim($_POST["deleteJobRef"] ?? "");

    if ($deleteJobRef != "") {
        $query = "DELETE FROM eoi WHERE jobRef = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $deleteJobRef);

        if (mysqli_stmt_execute($stmt)) {
            $message = "EOIs deleted successfully.";
        } else {
            $message = "Delete failed.";
        }

        mysqli_stmt_close($stmt);
    }
}

/* update status */
if (isset($_POST["update_status"])) {
    $eoiId = $_POST["eoiId"] ?? "";
    $newStatus = $_POST["newStatus"] ?? "";

    if ($eoiId != "" && $newStatus != "") {
        $query = "UPDATE eoi SET status = ? WHERE EOInumber = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $newStatus, $eoiId);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Status updated.";
        } else {
            $message = "Update failed.";
        }

        mysqli_stmt_close($stmt);
    }
}

/* sorting */
$sort = $_GET["sort"] ?? "EOInumber";

$allowedSorts = [
    "EOInumber",
    "jobRef",
    "firstName",
    "lastName",
    "status"
];

if (!in_array($sort, $allowedSorts)) {
    $sort = "EOInumber";
}

/* searching */
$where = "";
$params = [];
$types = "";

if (isset($_GET["search"])) {
    $jobRef = trim($_GET["jobRef"] ?? "");
    $firstName = trim($_GET["firstName"] ?? "");
    $lastName = trim($_GET["lastName"] ?? "");

    $conditions = [];

    if ($jobRef != "") {
        $conditions[] = "jobRef = ?";
        $params[] = $jobRef;
        $types .= "s";
    }

    if ($firstName != "") {
        $conditions[] = "firstName LIKE ?";
        $params[] = "%" . $firstName . "%";
        $types .= "s";
    }

    if ($lastName != "") {
        $conditions[] = "lastName LIKE ?";
        $params[] = "%" . $lastName . "%";
        $types .= "s";
    }

    if (!empty($conditions)) {
        $where = " WHERE " . implode(" AND ", $conditions);
    }
}

$query = "SELECT * FROM eoi" . $where . " ORDER BY " . $sort;
$stmt = mysqli_prepare($conn, $query);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage EOIs - UrbanSync</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="/images/logo.ico">

    <style>
        .navbar {
            background: none;
        }

        .navbar-link-item,
        label.navbar-link-vert-item {
            color: white;
        }

        .menu-toggle-input:checked~.navbar-link-item,
        .menu-toggle-input:checked~label.navbar-link-item,
        .navbar-settings-dropdown,
        .navbar-link-item:hover,
        .navbar-settings:hover .navbar-link-item {
            background: rgba(220, 239, 241, 0.2);
            border: none;
            box-shadow: 0 8px 24px var(--shadow);
        }

        .manage-dashboard {
            width: 100%;
        }

        .manage-message {
            background-color: rgba(52, 199, 89, 0.1);
            border: 1px solid rgba(52, 199, 89, 0.3);
            color: #34c759;
            padding: 1rem;
            border-radius: 14px;
            margin-bottom: 1.5rem;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .manage-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .manage-box {
            background-color: rgba(9, 99, 126, 0.04);
            border: 1.5px solid rgba(9, 99, 126, 0.3);
            border-radius: 18px;
            padding: 1.5rem;
            text-align: left;
        }

        .manage-box h2 {
            font-size: 1.1rem;
            color: var(--accent);
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 1px solid var(--bg-tertiary);
        }

        .manage-table-wrapper {
            width: 100%;
            overflow-x: auto;
            margin-top: 1.5rem;
            border-radius: 18px;
            box-shadow: 0 8px 32px var(--shadow);
        }

        .manage-table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--bg-main);
            min-width: 900px;
        }

        .manage-table th,
        .manage-table td {
            border: 1px solid var(--bg-tertiary);
            padding: 12px;
            font-size: 14px;
            color: var(--text-main);
            text-align: left;
        }

        .manage-table th {
            background-color: var(--accent);
            color: white;
            font-weight: bold;
        }

        .manage-table tr:hover {
            background-color: var(--bg-secondary);
        }

        .manage-small-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .manage-small-form select {
            min-width: 110px;
            padding: 0.6rem;
        }

        .manage-small-form button {
            padding: 0.7rem 1rem;
            border-radius: 12px;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .manage-grid {
                grid-template-columns: 1fr;
            }

            .manage-small-form {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>

<body class="s-body <?php echo (($_COOKIE['dark_mode'] ?? '0') === '1') ? 'dark-mode' : ''; ?>">

    <?php include "header.inc"; ?>

    <main class="account-main">

        <section class="apply-form-section apply-card">

            <img src="./images/logo.png" class="logo" alt="UrbanSync logo">

            <h1 class="account-title">Manage EOIs</h1>

            <p class="account-subtitle">
                HR Manager Panel
            </p>

            <?php
            if ($message != "") {
                echo "<p class='manage-message'>" . htmlspecialchars($message) . "</p>";
            }
            ?>

            <div class="manage-dashboard">

                <div class="manage-grid">

                    <div class="manage-box">

                        <h2>Search EOIs</h2>

                        <form class="account-form" method="get" action="manage.php">

                            <label for="jobRef">Job Reference</label>
                            <input type="text" id="jobRef" name="jobRef"
                                value="<?php echo htmlspecialchars($_GET["jobRef"] ?? ""); ?>">

                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstName"
                                value="<?php echo htmlspecialchars($_GET["firstName"] ?? ""); ?>">

                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastName"
                                value="<?php echo htmlspecialchars($_GET["lastName"] ?? ""); ?>">

                            <label for="sort">Sort By</label>
                            <select id="sort" name="sort">
                                <option value="EOInumber" <?php if ($sort == "EOInumber") echo "selected"; ?>>EOI Number</option>
                                <option value="jobRef" <?php if ($sort == "jobRef") echo "selected"; ?>>Job Reference</option>
                                <option value="firstName" <?php if ($sort == "firstName") echo "selected"; ?>>First Name</option>
                                <option value="lastName" <?php if ($sort == "lastName") echo "selected"; ?>>Last Name</option>
                                <option value="status" <?php if ($sort == "status") echo "selected"; ?>>Status</option>
                            </select>

                            <input type="submit" name="search" value="Search / List EOIs">

                        </form>

                    </div>

                    <div class="manage-box">

                        <h2>Delete EOIs by Job Reference</h2>

                        <form class="account-form" method="post" action="manage.php">

                            <label for="deleteJobRef">Job Reference</label>
                            <input type="text" id="deleteJobRef" name="deleteJobRef" required>

                            <input type="submit" name="delete_by_job" value="Delete EOIs">

                        </form>

                    </div>

                </div>

                <div class="manage-table-wrapper">

                    <table class="manage-table">

                        <tr>
                            <th>EOI Number</th>
                            <th>Job Ref</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Change Status</th>
                        </tr>

                        <?php
                        if (empty($results)) {
                            echo "<tr><td colspan='7'>No EOIs found.</td></tr>";
                        }

                        foreach ($results as $row) {
                        ?>

                            <tr>
                                <td><?php echo htmlspecialchars($row["EOInumber"]); ?></td>
                                <td><?php echo htmlspecialchars($row["jobRef"]); ?></td>
                                <td><?php echo htmlspecialchars($row["firstName"]); ?></td>
                                <td><?php echo htmlspecialchars($row["lastName"]); ?></td>
                                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                <td><?php echo htmlspecialchars($row["status"]); ?></td>

                                <td>
                                    <form class="manage-small-form" method="post" action="manage.php">

                                        <input type="hidden" name="eoiId"
                                            value="<?php echo htmlspecialchars($row["EOInumber"]); ?>">

                                        <select name="newStatus">
                                            <option value="New" <?php if ($row["status"] == "New") echo "selected"; ?>>New</option>
                                            <option value="Current" <?php if ($row["status"] == "Current") echo "selected"; ?>>Current</option>
                                            <option value="Final" <?php if ($row["status"] == "Final") echo "selected"; ?>>Final</option>
                                        </select>

                                        <button type="submit" name="update_status" value="1">
                                            Update
                                        </button>

                                    </form>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>

                    </table>

                </div>

            </div>

        </section>

    </main>

    <?php include "footer.inc"; ?>

</body>

</html>