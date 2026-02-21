<?php 
    include ("connect2.php"); 
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit();
    }
?>
 
<!DOCTYPE html>
<html>
<head>
  <title>Upload Project</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2><b>ShowCase Your Project</b></h2>
  
  <div class="view">
  <a href="view.php">View All Projects</a>
  </div>
  <div class="container">
  <form action="" method="POST">
    <label>Project_Name:</label>
    <div class="input">
       <input type="text" name="project_name" class="input" required><br><br>
    </div>
    <label>Description:</label>
    <div class="input">
       <textarea name="description" class="input"  rows="5" cols="30" required></textarea><br><br>
    </div>
    <label>Participants:</label>
    <div class="input">
       <input type="text" name="participants" class="input" required><br><br>
    </div>
    <label>Project_URL (GitHub / Website):</label>
    <div class="input">
       <input type="url" name="project_url" class="input" required><br><br>
    </div>
    <label for="">Upload Logo of Your Team</label>
    <div class="input">
       <input type="file" name="project_logo" class="input" required><br><br>
    </div>
    <div class="button-container">
    <button type="submit" name="submit">Upload Project</button>
    </div>   
  </form>
  </div>
</body>
</html>

<?php if(isset($_POST['submit'])) {
   $username = $_SESSION['username']; 
   $project_name = $_POST['project_name'];
   $description = $_POST['description'];
   $participants = $_POST['participants'];
   $project_url = $_POST['project_url'];
   $project_logo = $_POST['project_logo'];

if(!empty($project_name) && !empty($description) && !empty($participants) && !empty($project_url) && !empty($project_logo)) {
      $sql = "INSERT INTO projects(username,project_name, description, participants, project_url , project_logo)
              VALUES('$username', '$project_name', '$description', '$participants', '$project_url' , '$project_logo')";
      if (mysqli_query($conn,$sql)) {
          echo "<p style='color:green;'>Project uploaded successfully!</p>";
      } 
      else {
          echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
      }
  }
else {
          echo "<p style='color:red;'>Please fill all fields!</p>";
  }
}
?>


