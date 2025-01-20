<?php
namespace Youcode\youdemy;

include $_SERVER['DOCUMENT_ROOT'] . '/Youdemy/vendor/autoload.php';
// use Youcode\youdemy\database;
use Youcode\youdemy\user;


class admin extends user
{




    public function affichage()
    {

        $sql = "SELECT * FROM users WHERE role != 'admin' ORDER BY status";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach ($users as $user) {
            echo '<tr class="row-user">';
            echo '<td class="column-name">' . $user['username'] . '</td>';
            echo '<td class="column-email">' . $user['email'] . '</td>';
            echo '<td class="column-email">' . $user['role'] . '</td>';
            echo '<td class="column-email">' . $user['status'] . '</td>';
            if ($user['status'] == 'active') {
                echo '<td class="column-status active">
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=suspended" class="act" >Disactive</a>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=panding" class="act">panding</a>
    
                </td>';
            } else if ($user['status'] == 'suspended') {
                echo '<td>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=active" class="act">Active</a>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=panding" class="act">panding</a>
                </td>';
            } else {
                echo '<td>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=suspended" class="act" >Disactive</a>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=active" class="act">Active</a>
                </td>';
            }
            echo '</tr>';
        }
    }
    public function updateactivety($user_id, $activety)
    {
        $userId = $user_id;
        $newactivety = $activety;

        $sql = "UPDATE users SET status = :status WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':status' => $newactivety,
            ':user_id' => $userId
        ]);



    }

    public function addcategories($name, $description)
    {


        $stmt = $this->pdo->prepare("INSERT INTO categories (name,description)VALUES(?,?)");
        $stmt->execute([$name, $description]);

    }
    public function affichagedescription()
    {
        $sql = "SELECT * FROM categories
        WHERE name != 'null';";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll();
        return $users;

    }


    public function deletedescription($category_id)
    {

        $sql = "UPDATE courses SET category_id = 11 WHERE category_id = :category_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();



        $sql = "DELETE FROM categories WHERE category_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $category_id);
        $stmt->execute();
    }

    public function addtags($name)
    {


        $stmt = $this->pdo->prepare("INSERT INTO tags (name)VALUES(?)");
        var_dump($stmt);
        $stmt->execute([$name]);

    }
    public function affichagetags()
    {
        $sql = "SELECT * FROM tags;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll();
        return $users;
   
    }

    public function deletetags($tag_id)
    {

        $sql = "DELETE FROM coursetags WHERE tag_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $tag_id);
        $stmt->execute();

        $sql = "DELETE FROM tags WHERE tag_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $tag_id);
        $stmt->execute();
    }



















    public function affichageCourses()
    {
        $sql = "SELECT users.username,users.email, Courses.course_id, Courses.title, Courses.description, Courses.content, Courses.created_at, Courses.status,  
                GROUP_CONCAT(Tags.name ORDER BY Tags.name) AS tags, 
                Courses.content_type, 
                Categories.name AS category
                FROM Courses
                JOIN CourseTags ON Courses.course_id = CourseTags.course_id
                JOIN Tags ON CourseTags.tag_id = Tags.tag_id
                JOIN Categories ON Courses.category_id = Categories.category_id
                JOIN users ON Courses.teacher_id = users.user_id  
                GROUP BY Courses.course_id
                ORDER BY users.email
                
";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $courses = $stmt->fetchAll();

        foreach ($courses as $course) {
            echo '<tr class="row-course">';
            echo '<td class="column-title">' . $course['username'] . '</td>';
            echo '<td class="column-title">' . $course['email'] . '</td>';
            echo '<td class="column-title">' . $course['title'] . '</td>';
            echo '<td class="column-description">' . $course['description'] . '</td>';
            echo '<td class="column-tags">' . $course['tags'] . '</td>';
            echo '<td class="column-category">' . $course['category'] . '</td>';
            echo '<td class="column-status">' . $course['status'] . '</td>';

            if ($course['status'] == 'active') {
                echo '<td class="column-status active">
                  
                    <a href="../pages/adminpage.php?course_id=' . $course['course_id'] . '&activitys=panding" class="act">Pending</a>
                </td>';
            } else {
                echo '<td>
               
                    <a href="../pages/adminpage.php?course_id=' . $course['course_id'] . '&activitys=active" class="act">Activate</a>
                </td>';
            }
            echo '</tr>';
        }
    }
    public function updateActivitycourse($course_id, $activity)
    {
        $courseId = $course_id;
        $newActivity = $activity;

        $sql = "UPDATE Courses SET status = :status WHERE course_id = :course_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':status' => $newActivity,
            ':course_id' => $courseId
        ]);
    }



}


