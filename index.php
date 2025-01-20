<?php
include $_SERVER['DOCUMENT_ROOT'].'/Youdemy/vendor/autoload.php';

use Youcode\youdemy\database;
use Youcode\youdemy\teacher;
use Youcode\youdemy\student;



$ndb = new database;
$pdo=$ndb->getConnection();

if (isset($_POST["submitc"])) {
    $username = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];
 
    if($role == 'student'){
     $acc = new student($pdo);
    }else{
        $acc = new teacher($pdo);
    }

    $acc->registerFunc($username, $email, $password, $role);
   
}

if (isset($_POST['submita'])) {
  
    $email = $_POST["email"];
    $password = $_POST["password"];

    if($role == 'student'){
        $acc = new student($pdo);
       }else{
           $acc = new teacher($pdo);
       }
    $acc->loginFunc($email, $password);  
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./public/css.css">

    <title>Modern Login Page | AsmrProg</title>
</head>

<body>





    <div class="container" id="container">
        <div class="form-container sign-up">

        <form method="POST">
    <h1>Create Account</h1>

    <input type="text" placeholder="Name" name="name">
    <input type="email" placeholder="Email" name="email">
    <input type="password" placeholder="Password" name="password">

    <label>
        <input type="radio" name="role" value="student" required> Student
    </label>
    <label>
        <input type="radio" name="role" value="teacher" required> Teacher
    </label>

    <button type="submit" name="submitc">Sign Up</button>
</form>

        </div>






        <div class="form-container sign-in">
            
            <form method="POST">
                <h1>Sign In</h1>
 
                <input type="email" placeholder="Email" name="email">
                <input type="password" placeholder="Password" name="password">
  
                <button type="submit" name="submita" >Sign In</button>
            </form>






        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>




    <script src="./public/js.js"></script>
</body>

</html>