<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link rel="stylesheet" href="../public/desplay.css">
</head>
<body>
    
    <div class="container">
        <?php
            session_start();
        if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "student") {

            header("location:../index.php");
            exit();
          }
        include $_SERVER['DOCUMENT_ROOT'] . '/youdemy/vendor/autoload.php';  

        use Youcode\youdemy\database;
        use Youcode\youdemy\student;
        use Youcode\youdemy\ContentFactory;
        
        $ndb = new database;
        $pdo = $ndb->getConnection();

        $student_id = $_SESSION['user_id'];  
        $course_id = isset($_GET['id']) ? (int) $_GET['id'] : 0; 

        if ($course_id > 0) {
            $student = new student($pdo);
            $course = $student->getCourseDetails($course_id);

            if ($course) {
                echo "<div class='course-info'>";
                echo "<h2>Course Title: " . $course['title'] . "</h2>";
                echo "<p><strong>Description:</strong> " . $course['description'] . "</p>";
                echo "<p><strong>Content Type:</strong> " . $course['content_type'] . "</p>";

                $content_type = $course['content_type'];
                $content = $course['content'];
                
                try {
                    $contentObject = ContentFactory::createContent($content_type, $content);
                    $contentObject->displayContent();  
                } catch (Exception $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }

                echo "<p><strong>Category:</strong> " . $course['category'] . "</p>";
                echo "<p><strong>Tags:</strong> " . $course['tags'] . "</p>";
                echo "<p><strong>Created At:</strong> " . $course['created_at'] . "</p>";
                echo "</div>";
            } else {
                echo "<p>Course not found.</p>";
            }
        } else {
            echo "<p>Invalid course ID.</p>";
        }
        ?>
    </div>

</body>
</html>
