<?php

use Youcode\youdemy\student;
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/youdemy/vendor/autoload.php';

use Youcode\youdemy\database;

$ndb = new database;


if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "student") {

    header("location:../index.php");
    exit();
}


$ndb = new database;
$pdo = $ndb->getConnection();

?>



<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/cssadmine.css">
  
  <link rel="stylesheet" href="../public/activation.css">
  <link rel="stylesheet" href="../public/card.css">

    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="sidebar" style=" background:#007317">

        <div class="logo-details">
            <i class="bx bxl-c-plus-plus"></i>
            <span class="logo_name">D-CLIC</span>
        </div>
        <ul class="nav-links">


            <li>
                <a href="student.php" class="active">
                    <i class="bx bx-list-ul"></i>
                    <span class="links_name">home</span>
                </a>
            </li>

            <li>
                <a href="studentmycourses.php">
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



            <form class="custom-search-form" method="GET">

                <input type="text" name="query" placeholder="Search courses..." />
                <button type="submit">
                    <i class="bx bx-search"></i>
                </button>
                < </form>



        </nav>


        <div class="home-content">

            <div class="sales-boxes" style="justify-content: center;">
                <div class="recent-sales box">

                    <div class="form-container sign-up"></div>





                    <?php


$student = new student($pdo);
                    if (isset($_GET['id'])) {
                        $course_id = (int) $_GET['id'];
                        $student_id = $_SESSION['user_id'];

                    $student->enrollInCourse($student_id, $course_id);
                    }
                           
                   



                    if (isset($_GET['query'])) {
                        $search = $_GET['query'];
                    } else {
                        $search = '';
                    }


                 
                    $page = isset($_GET['page']) ? (int) $_GET['page'] : 0;

                    $courses = $student->getAllCoursesWithPagination($page, $search);

                    if (!empty($courses)) {
                        echo "<h1>Courses</h1>";
                        echo "<div class='course-student'>";

                        foreach ($courses as $course) {
                            echo "<div class='course-item'>";
                            echo "<h2>Course Title: " . $course['title'] . "</h2>";
                            echo "<p><strong>Description:</strong> " . $course['description'] . "</p>";
                            echo "<p><strong>Category:</strong> " . $course['category'] . "</p>";
                            echo "<p><strong>Tags:</strong> " . $course['tags'] . "</p>";
                            echo "<p><strong>Created At:</strong> " . $course['created_at'] . "</p>";
                            echo '<td>
                           <a href="?id=' . $course['course_id'] . '" class="act">Add to my courses</a>
                          </td>';
                            echo "</div>";
                        }

                        echo "</div>";

                    } else {
                        echo "<p class='no-courses'>No courses found.</p>";
                    }


                    ?>


                </div>

            </div>
        </div>
        </div>

        <?php
        echo "<div class='pagination'>";

        if ($page > 0) {
            echo "<a href='?page=" . ($page - 1) . ($search ? '&' . $search : '') . "'>Previous</a>";
        }

        echo "<a href='?page=" . ($page + 1) . ($search ? '&' . $search : '') . "'>Next</a>";

        echo "</div>";



        ?>


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