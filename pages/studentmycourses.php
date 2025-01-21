<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/youdemy/vendor/autoload.php';
use Youcode\youdemy\student;
use Youcode\youdemy\database;


$ndb = new database;
$pdo = $ndb->getConnection();


if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "student") {

  header("location:../index.php");
  exit();
}

$student = new student($pdo);


$student_id = $_SESSION['user_id'];  
$courses = $student->getCoursesForStudent($student_id); 


?>



<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/cssadmine.css">
  
  <link rel="stylesheet" href="../public/activation.css">
  <link rel="stylesheet" href="../public/card.css">
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
  <div class="sidebar"style=" background:#007317">

<div class="logo-details">
  <i class="bx bxl-c-plus-plus"></i>
  <span class="logo_name">D-CLIC</span>
</div>
<ul class="nav-links">


  <li>
    <a href="student.php" >
      <i class="bx bx-list-ul"></i>
      <span class="links_name">home</span>
    </a>
  </li>

  <li>
    <a href="studentmycourses.php" class="active">
      <i class="bx bx-grid-alt"></i>
      <span class="links_name">my courses</span>
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
        <div class="search-box">
          <input type="text" placeholder="Recherche..." />
          <i class="bx bx-search"></i>
        </div>

      </nav>
      <div class="home-content">

<div class="sales-boxes" style="justify-content: center;">
    <div class="recent-sales box">

        <div class="form-container sign-up"></div>








      <?php

if (isset($_GET['course_id'])) {
    $course_id = (int) $_GET['course_id'];
    $student_id = $_SESSION['user_id'];
    $student->removeFromCourse($student_id, $course_id);
    header("location:studentmycourses.php");
}


if (!empty($courses)) {
    echo "<h1>My Enrolled Courses</h1>";
    echo "<div class='course-container'>";  

  
    foreach ($courses as $course) {
        echo "<div class='course-item'>";
        
        echo "<h2>Course Title: " . $course['title'] . "</h2>";
        echo "<p><strong>Content Type:</strong> " . $course['content_type'] . "</p>";
        echo "<p><strong>Description:</strong> " . $course['description'] . "</p>";
        echo "<p><strong>Category:</strong> " . $course['category'] . "</p>";
        echo "<p><strong>Tags:</strong> " . $course['tags'] . "</p>";
        echo "<p><strong>Created At:</strong> " . $course['created_at'] . "</p>";
        echo "<div class='course-actions'>";
        echo '<a href="../pages/desplay.php?id=' . $course['course_id'] . '" class="act">View</a>';
        echo '<a href="?course_id=' . $course['course_id'] . '" class="act" >Remove</a>';
        
        echo "</div>";  

        echo "</div>";  
    }

    echo "</div>";  
} else {
    echo "<p class='no-courses'>You are not enrolled in any courses.</p>";
}
?>



</div>

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
