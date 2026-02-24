<?php 
include("connect.php"); 
session_start();

// Check if user is logged in
if(!isset($_SESSION['username'])){
    die("Error: You must login first.");
}

$username = $_SESSION['username'];

// --- DELETE LOGIC ---
if(isset($_GET['project_name'])){
    // Using mysqli_real_escape_string for security as in your original code
    $project_name = mysqli_real_escape_string($conn, $_GET['project_name']);
    
    // SQL to delete only if the project belongs to the logged-in user
    $sql = "DELETE FROM projects WHERE project_name = '$project_name' AND username = '$username'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: view.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Projects</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f6;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header-links {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .header-links h2 {
            margin: 0;
            color: #333;
        }

        .header-links a.add-btn {
            color: white;
            background: #000dff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .header-links a.add-btn:hover {
            background: #000568;
        }

        /* --- PROJECT CARD STYLES --- */
        .project-card {
            background: #fff;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: relative; /* REQUIRED: Anchors the absolute delete button */
            transition: transform 0.2s;
        }

        .project-card:hover {
            transform: translateY(-2px);
        }

        .project-card h3 {
            margin-top: 0;
            color: #007bff;
            font-size: 1.5rem;
        }

        /* Project Logo Styling */
        .project-logo {
            max-width: 200px;
            height: auto;
            border-radius: 8px;
            display: block;
            margin: 15px 0;
            border: 1px solid #eee;
        }

        .project-card p {
            color: #444;
            line-height: 1.6;
            margin: 8px 0;
        }

        .view-link {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        /* --- DELETE BUTTON STYLES --- */
        .delete-btn {
            position: absolute; 
            top: 20px;
            right: 20px;
            color: white;
            background: #dc3545;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .delete-btn:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-links {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            .delete-btn {
                position: static; /* Stack on mobile for better accessibility */
                display: inline-block;
                margin-top: 15px;
                width: fit-content;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-links">
        <h2>Projects</h2>
        <a href="main.php" class="add-btn">+ Add New Project</a>
    </div>

    <?php
    // Fetch only projects for the logged-in user (Secure approach)
    $sql_fetch = "SELECT * FROM projects ";
    $result = mysqli_query($conn, $sql_fetch);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Sanitize variables for display
            $name = htmlspecialchars($row['project_name']);
            $desc = htmlspecialchars($row['description']);
            $parts = htmlspecialchars($row['participants']);
            $url = htmlspecialchars($row['project_url']);
            $logo = $row['project_logo'];
            
            echo "
            <div class='project-card'>
                <!-- Delete Button -->";
            
                 if($_SESSION['username'] == $row['username']){
                  echo" <a href='view.php?project_name=" . urlencode($row['project_name']) . "' 
                    class='delete-btn' 
                    onclick='return confirm(\"Permanently delete this project?\")'>
                    🗑 Delete
                  </a>";
                }
                
                echo "
                <h3><u>$name</u></h3>
                
                <!-- Project Logo -->
                <img src='uploads/$logo' alt='Logo for $name' class='project-logo' 
                     onerror=\"this.style.display='none';\"> 

                <p><b>Description:</b> $desc</p>
                <p><b>Participants:</b> $parts</p>
                
                <a href='$url' target='_blank' class='view-link'>🔗 View Project</a>
                
                <p style='font-size: 0.85rem; color: #777; margin-top: 15px;'>
                    <b>Uploaded by:</b> " . htmlspecialchars($row['username']) . "
                </p>
            </div>
            ";
        }
    } else {
        echo "<div style='text-align:center; padding: 50px; background:white; border-radius:10px;'>
                <p>No projects found. Start by adding one!</p>
              </div>";
    }
    ?>
</div>

</body>
</html>
