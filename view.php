<?php include("connect2.php"); 
session_start();
/*if(!isset($_SESSION['username'])){
  die("Error: you must login first");
}*/

$username = $_SESSION['username'];

if(isset($_GET['project_name'])){
    $project_name = mysqli_real_escape_string($conn,$_GET['project_name']);
    $sql = "DELETE FROM projects WHERE project_name = '$project_name' AND username = '$username'";
mysqli_query($conn,$sql);
header("Location: view.php");
exit();

}
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Projects</title>
  <style>
    body {
      font-family: sans-serif;
      background: #f9f9f9;
      margin: 20px;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
    }

    .project-card {
      background: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .project-card h3 {
      margin-top: 0;
      color: #333;
    }

    .project-card p {
      color: #555;
    }

    .project-card a {
      display: inline-block;
      margin-top: 10px;
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }

    .project-card a:hover {
      text-decoration: underline;
    }
    .delete-btn {
      position: absolute; /* Position relative to the parent */
      top: 20px;
      right: 20px;
      color: white;
      background: #dc3545;
      padding: 6px 12px;
      border-radius: 5px;
      text-decoration: none;
    }

   .delete-btn:hover {
    background: #c82333;
    }

    .header-links {
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-links a {
      color: white;
      background: #000dff;
      padding: 8px 15px;
      text-decoration: none;
      border-radius: 5px;
    }

    .header-links a:hover {
      background: #218838;
      transition: 0.7s;
      transition-timing-function: ease-in-out;
    }
    @media (max-width: 768px) {

    h2 {
        font-size: 35px;
    }

    .container {
        width: 95%;
        padding: 15px;
    }

    .container button {
        width: 100%;
    }

    .view {
        justify-content: center;
    }
 }

 @media (max-width: 480px) {

    h2 {
        font-size: 28px;
    }

    label {
        font-size: 16px;
    }

    .container input,
    .container textarea {
        font-size: 14px;
    }
  }

  </style>
</head>
<body>
  <div class="container">
    <div class="header-links">
      <h2>Uploaded Projects</h2>
      <a href="main.php">+ Add New Project</a>
    </div>

    <?php
    $result = mysqli_query($conn,"SELECT * FROM projects ");
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo "
        <div class='project-card'>
          <h3><u>{$row['project_name']}</u></h3>
          <img src='{$row['project_logo']}' alt='Image of project'>
          <p><b>Description:</b> {$row['description']}</p>
          <p><b>Participants:</b> {$row['participants']}</p>
          <a href='{$row['project_url']}' target='_blank'>🔗 View Project</a>
          <p><b>Project uploaded by: </b>{$row['username']}</p>
          <a href='view.php?project_name=". ($row['project_name']). "'class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this project?\")'>🗑 Delete</a>
        </div>
        ";
      }
    } else {
      echo "<p>No projects uploaded yet.</p>";
    }
    ?>
  </div>
</body>
</html>