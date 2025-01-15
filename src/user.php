<?php
namespace Youcode\youdemy;

include $_SERVER['DOCUMENT_ROOT'].'/Youdemy/vendor/autoload.php';
use Youcode\youdemy\database;


 
class user
{

protected $user_id;
protected $username;
protected $email;
protected $password;
protected $role;

protected $pdo;
protected $activety;

public function __construct($pdo) {
    $this->pdo = $pdo;
}



public function registerFunc($username, $email, $password, $role) {

    $ndb = new database;
    $pdo = $ndb->getConnection();
    

    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $myuser = $stmt->fetch();


    if ($myuser) {
         
        echo '<script>alert("the user is already registreed")</script>';

    }else{

        $hashedpassord = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username,email,password_hash,role)VALUES(?,?,?,?)");
        $stmt->execute([$username, $email, $hashedpassord, $role]);

    }
}




public function loginFunc($email,$password){

    session_start();
  
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $myuser = $stmt->fetch();

 
    if(!$myuser || !password_verify($password,$myuser["password_hash"])){
        echo '<script>alert("the email or password is not correct")</script>';
        return;
    }else{
    
        $_SESSION["user_id"]=$myuser["user_id"];
        $_SESSION["email"]=$myuser["email"];
        $_SESSION["role"]=$myuser["role"];
        
        
        
        
        
        if ($myuser["status"]=="suspended") {
            echo '<script>alert("Your Account is Not Active Anymore")</script>';
            return;
        }else if($myuser["status"]=="panding"){
            echo '<script>alert("Your Account is on progres")</script>';
        }else{


        if ($myuser["role"]=="admin") {
            header("location:./pages/adminstats.php");
        }else if($myuser["role"]=="teacher"){
            header("location:./pages/.php");
        }else{
            header("location:./pages/.php");
        }
        }
    }


}


}




