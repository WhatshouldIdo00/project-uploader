<?php
session_start();
//change check
include 'connect.php' ;
$error = "";
if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $get_password = mysqli_query($conn,"SELECT * FROM users WHERE password='$password'");
    if ($username == "" || $password == "") {
        $error = "All fields are required!";
    }else if(mysqli_num_rows($get_password)>0){
        $user = mysqli_fetch_assoc($get_password);
        if($password == $user['password'] and $username == $user['username']){
            $_SESSION['username'] = $username;
            echo "<script>window.alert('Login successfully');
            window.location.href='main.php';
            </script>";
            exit();
        }
        else{
            $error = "Password do not match!";
        }
    } 
    else{ $error = "username and assword do not match!";}
}
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login-d.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <div class="text_box"><p style="color:red"><?php echo isset($error) ? $error : ""; ?></p>
       </div>
       <form action="" method="POST">
       <div class="input">
        <input type="text" name="username" placeholder="username" >
       </div>
       <div class="input">
        <input type="password" name="password" placeholder="password">
       </div> 
       <div class="register">
        <p>Don't have an account?<a href="register.php">Register!</a></p>
       </div>
       <button type="submit" class="button" name="login">Login</button>
      </form>
    </div>
</body>
</html>