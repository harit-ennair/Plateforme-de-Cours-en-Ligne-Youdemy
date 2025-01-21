<?php

use Youcode\youdemy\student;
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/youdemy/vendor/autoload.php';

use Youcode\youdemy\database;

$ndb = new database;
$pdo = $ndb->getConnection();

?>



<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./public/cssadmine.css">

    <link rel="stylesheet" href="./public/activation.css">
    <link rel="stylesheet" href="./public/card.css">

    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="sidebar" style=" background:#007317">

        <div class="logo-details">
            <button onclick="window.location.href='./pages/login.php';">
                Create Aconte
                
            </button>
        </div>

    </div>
    <section class="home-section">



        <form class="custom-search-forjm" method="GET">

            <input type="text" name="query" placeholder="Search courses..." />
            <button type="submit">
                <i class="bx bx-search"></i>
            </button>
            < </form>





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