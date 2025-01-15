
<?php 
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/youdemy/vendor/autoload.php';

use Youcode\youdemy\database;
use Youcode\youdemy\admin;

$ndb = new database;
$pdo = $ndb->getConnection();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"]!=="admin") {

header("location:../index.php");
exit();
} 


if(isset($_GET['user_id']) && isset($_GET['activety'])){
  $ndb = new database;
  $pdo = $ndb->getConnection();
  $descative = new admin($pdo);
  $descative->updateactivety($_GET['user_id'],$_GET['activety']);
  header('location:http://localhost/youdemy/pages/adminpage.php');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/cssadmine.css">
    <link rel="stylesheet" href="../public/activation.css">


</head>
<body>
    
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>





    <div class="sidebar">
      <div class="logo-details">
        <i class="bx bxl-c-plus-plus"></i>
        <span class="logo_name">D-CLIC</span>
      </div>
      <ul class="nav-links">
        
        <li>
          <a href="adminstats.php">
            <i class="bx bx-list-ul"></i>
            <span class="links_name">statistics</span>
          </a>
        </li>


        <li>
          <a href="admintag.php" >
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">tag</span>
          </a>
        </li>
 



        <li>
          <a href="adminpage.php"class="active">
            <i class="bx bx-user"></i>
            <span class="links_name">Utilisateur</span>
          </a>
        </li>


        <li class="log_out">
          <a href="http://localhost/youdemy/">
            <i class="bx bx-log-out"></i>
            <span class="links_name">Déconnexion</span>
          </a>
        </li>
      </ul>
    </div>
    <section class="home-section">
      <nav>
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard">Dashboard</span>
        </div>
    

      </nav>

      <div class="home-content">
        
        <div class="sales-boxes" style="justify-content: center;">
             <div class="recent-sales box">
         
             <table class="table table-striped table-bordered">


                        <thead>
                            <tr class="table-header">
                              <th class="column-name">Name</th>
                              <th class="column-email">Email</th>
                              <th class="column-status">role</th>
                              <th class="column-status">Status</th>
                              <th class="column-status">action</th>
                           </tr>
                        </thead>
                        <tbody>
                
                                <?php
          
                          
                                $ndb = new database;
                                $pdo = $ndb->getConnection();
                                $acc = new admin($pdo);  
                                $acc->affichage();  
                            
                                ?>


                        </tbody>
                    </table>

            </div>
        </div>
      </div>
    </section>

    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
    </script>
  </body>
</html>


</body>
</html>
