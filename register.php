<?php
 
 if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);

    if ($username == "" || $password == "" || $confirm == "" || $email == "") {
        $error = "All fields are required!";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        $check_user = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'");
        $email_check = mysqli_query($conn,"SELECT email FROM users WHERE email='$email' ");
        if (mysqli_num_rows($check_user) > 0) {
            $error = "Username already taken!";
        }else if(mysqli_num_rows($email_check) > 0){
            $error = "This email address already taken!";
        } 
        else {
            $sql = "INSERT INTO users(username, password , email) VALUES ('$username', '$password','$email')";
            if (mysqli_query($conn, $sql)) {
                $success = "Registration successful! You can login now.";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="reg-d.css">
</head>
<body>
    <div class="container">
        <h1>Registration</h1>
        <div class="text_box"><p style="color:red"><?php echo isset($error) ? $error : ""; ?></p>
          <p style="color:green;"><?php echo isset($success) ? $success : ""; ?></p>
       </div>
        <form action="" method="POST">
            <div class="input">
                <input type="text" name="username" id="name"placeholder="username">
            </div>
            <div class="input">
                <input type="email" name="email" id="email"placeholder="email">
            </div>
            <div class="input">
                <input type="password" name="password" id="password"placeholder="password">
            </div>
            <div class="input">
                <input type="password" name="confirm_password" id="confirm"placeholder="confirm password">
            </div>
            <div class="login">
            <p class="login">Already have an account?<a href="login.php">Click here</a></p>
            </div>           
             <button type="submit" class="button" name="register" onsubmit="">Register</button>
        </form>
        <script src="check.js"></script>
    </div>  
</body>
</html>