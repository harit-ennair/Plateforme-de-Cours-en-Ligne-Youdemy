<?php
namespace Youcode\youdemy;

include $_SERVER['DOCUMENT_ROOT'] . '/Youdemy/vendor/autoload.php';
use Youcode\youdemy\user;



class teacher extends user
{



    public function addCourse($title, $description, $content_type, $content, $teacher_id, $category_id, $tags)
    {

        $sql = "INSERT INTO courses (title, description, content, teacher_id, category_id, content_type) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$title, $description, $content, $teacher_id, $category_id, $content_type]);


        $course_id = $this->pdo->lastInsertId();


        if (!empty($tags)) {
            foreach ($tags as $tag_id) {
                $this->addTagToCourse($course_id, $tag_id);
            }
        }
    }


    private function addTagToCourse($course_id, $tag_id)
    {
        $sql_tag = "INSERT INTO coursetags (course_id, tag_id) VALUES (?, ?)";
        $stmt_tag = $this->pdo->prepare($sql_tag);
        $stmt_tag->execute([$course_id, $tag_id]);
    }



    public function getAllCoursesWithTags($teacher_id)
    {

        $sql = "SELECT users.username, Courses.course_id, Courses.title, Courses.description, Courses.content, Courses.created_at, Courses.status,  
                GROUP_CONCAT(Tags.name ORDER BY Tags.name) AS tags, 
                Courses.content_type, 
                Categories.name AS category 
                FROM Courses
                LEFT JOIN CourseTags ON Courses.course_id = CourseTags.course_id
                LEFT JOIN Tags ON CourseTags.tag_id = Tags.tag_id
                LEFT JOIN Categories ON Courses.category_id = Categories.category_id
                LEFT JOIN users ON Courses.teacher_id = users.user_id  
                WHERE users.user_id = :teacher_id
                GROUP BY Courses.course_id
";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':teacher_id', $teacher_id);
        $stmt->execute();
        $courses = $stmt->fetchAll();

        return $courses;
    }

}


// SELECT Courses.course_id, 
//        Courses.title, 
//        Courses.description, 
//        Courses.content, 
//        Courses.status,  
//        GROUP_CONCAT(Tags.name ORDER BY Tags.name) AS tags, 
//        Courses.content_type, 
//        Categories.name AS category,
//        users.username
// FROM Courses
// LEFT JOIN CourseTags ON Courses.course_id = CourseTags.course_id
// LEFT JOIN Tags ON CourseTags.tag_id = Tags.tag_id
// LEFT JOIN Categories ON Courses.category_id = Categories.category_id
// LEFT JOIN users ON Courses.user_id = Users.user_id  
// GROUP BY Courses.course_id

