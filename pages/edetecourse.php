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


$course_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $content_type = $_POST['content_type'];
  $content = $_POST['content'];

  $teacher_id = $_SESSION['user_id'];
  $category_id = $_POST['category_id'];

  $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

  $teacher = new teacher($pdo);
  $teacher->updateCourse($course_id, $title, $description, $content_type, $content, $teacher_id, $category_id, $tags);
  header("location: teachercourses.php");
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/activation.css">
    <link rel="stylesheet" href="../public/card.css">
</head>
<body>
    

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

</body>
</html>