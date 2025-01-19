<?php

use Youcode\youdemy\admin;
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/youdemy/vendor/autoload.php';

use Youcode\youdemy\database;
use Youcode\youdemy\teacher;


$ndb = new database;
$pdo = $ndb->getConnection();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "teacher") {

  header("location:../index.php");
  exit();
}





$teacher_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $content_type = $_POST['content_type'];
  $content = $_POST['content'];
  $teacher_id = $_SESSION['user_id'];
  $category_id = $_POST['category_id'];

  //   if (isset($_POST['tags'])) {
  //     $tags = $_POST['tags'];
  // } else {
  //     $tags = [];
  // }

  $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

  $teacher = new teacher($pdo);
  $teacher->addCourse($title, $description, $content_type, $content, $teacher_id, $category_id, $tags);
}

if (isset($_GET['id'])) {

  $acc = new teacher($pdo);
  $acc->deletecourse($_GET["id"]);
  header("location: teachercourses.php");
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
  <link rel="stylesheet" href="../public/card.css">

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





    <div class="sidebar" style=" background:#8d0a1f">

      <div class="logo-details">
        <i class="bx bxl-c-plus-plus"></i>
        <span class="logo_name">D-CLIC</span>
      </div>
      <ul class="nav-links">


        <li>
          <a href="teacher.php">
            <i class="bx bx-list-ul"></i>
            <span class="links_name">statistics</span>
          </a>
        </li>

        <li>
          <a href="teachercourses.php" class="active">
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

      <div class="home-content">

        <div class="sales-boxes" style="justify-content: center;">
          <div class="recent-sales box">

            <div class="form-container sign-up"></div>












            <form method="POST" enctype="multipart/form-data">
              <label for="title">Titr:</label>
              <input type="text" id="title" name="title" required><br><br>

              <label for="description">Description:</label>
              <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

              <label for="content_type">Content Type:</label>
              <select id="content_type" name="content_type" required>
                <option value="PDF">PDF</option>
                <option value="Video">Video</option>
              </select><br><br>
              <label for="content">Content (Video or PDF URL):</label>
              <input type="url" id="content" name="content" placeholder="Enter URL for Video or PDF" required><br><br>

              <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"><br><br>

              <label for="category_id">Category:</label>
              <select id="category_id" name="category_id" required>
                <?php
                $acc = new admin($pdo);
                $categories = $acc->affichagedescription();
                foreach ($categories as $category) {
                  echo "<option value='" . $category['category_id'] . "'>" . $category['name'] . "</option>";
                }
                ?>
              </select><br><br>

              <label for="tags">Tags:</label><br>
              <div class="checkbox-container">
                <?php
                $tags = $acc->affichagetags();
                foreach ($tags as $tag) {
                  echo "<input type='checkbox' id='tag_id" . $tag['tag_id'] . "' name='tags[]' value='" . $tag['tag_id'] . "'>";
                  echo "<label for='tag_id" . $tag['tag_id'] . "'>" . $tag['name'] . "</label><br>";
                }
                ?><br>
              </div>

              <button type="submit">Submit</button>
            </form>











          </div>

        </div>
      </div>
      </div>
<?php

$teacher = new teacher($pdo);

$courses = $teacher->getAllCoursesWithTags($teacher_id);

if (!empty($courses)) {
  echo "<h1>All Courses</h1>";
  echo "<div class='course-container'>";

  foreach ($courses as $course) {
      echo "<div class='course-item'>";
      echo "<h2>Course Title: " . $course['title'] . "</h2>";
      echo "<a href='" . $course['content'] . "'><strong></strong> link</a>";
      echo "<p><strong></strong> " . $course['content_type'] . "</p>";
      echo "<p><strong>Description:</strong> " . $course['description'] . "</p>";
      echo "<p><strong>Category:</strong> " . $course['category'] . "</p>";
      echo "<p><strong>Tags:</strong> " . $course['tags'] . "</p>";
      echo "<p><strong>Created At:</strong> " . $course['created_at'] . "</p>";
      echo "<p><strong>Status:</strong> " . $course['status'] . "</p>";
      echo '<td>
            <a href="../pages/teachercourses.php?id=' . $course['course_id'] . '"class="act" >delete</a>
            </td>';
      echo '<td>
            <a href="../pages/edetecourse.php?id=' . $course['course_id'] . '"class="act" >edete</a>
            </td>';
      echo "</div>";
  }

  echo "</div>";
} else {
  echo "<p class='no-courses'>No courses found.</p>";
}

?>



    </section>

    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active"); content
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
    </script>
  </body>

  </html>


</body>

</html>