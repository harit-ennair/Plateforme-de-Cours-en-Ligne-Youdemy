<?php

use Youcode\youdemy\admin;
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/youdemy/vendor/autoload.php';

use Youcode\youdemy\database;


$ndb = new database;
$pdo = $ndb->getConnection();

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
  <link rel="stylesheet" href="../public/activation.css">


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

            <form action="submit_teacher_form.php" method="POST" enctype="multipart/form-data">
              <label for="title">Titr:</label>
              <input type="text" id="title" name="title" required><br><br>

              <label for="description">Description:</label>
              <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

              <label for="content">Content (Video or PDF):</label>
              <input type="file" id="content" name="content" accept="video/*, application/pdf" required><br><br>

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