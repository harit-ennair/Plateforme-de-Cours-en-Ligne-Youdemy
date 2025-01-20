<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/youdemy/vendor/autoload.php';

use Youcode\youdemy\database;

$ndb = new database;


if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "teacher") {

  header("location:../index.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../public/cssadmine.css">


</head>

<body>

  <!DOCTYPE html>
  <html lang="fr" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>

  <body>





    <div class="sidebar"style=" background:#8d0a1f">

      <div class="logo-details">
        <i class="bx bxl-c-plus-plus"></i>
        <span class="logo_name">D-CLIC</span>
      </div>
      <ul class="nav-links">


        <li>
          <a href="teacher.php" class="active">
            <i class="bx bx-list-ul"></i>
            <span class="links_name">statistics</span>
          </a>
        </li>

        <li>
          <a href="teachercourses.php" >
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">les courses</span>
          </a>
        </li>
 

        <li>
          <a href="teacherprofile.php">
            <i class="bx bx-user"></i>
            <span class="links_name">profile</span>
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