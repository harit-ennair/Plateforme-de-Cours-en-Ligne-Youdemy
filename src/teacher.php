<?php
namespace Youcode\youdemy;

include $_SERVER['DOCUMENT_ROOT'].'/Youdemy/vendor/autoload.php';
use Youcode\youdemy\user;



class teacher extends user{
   


    public function addCourse($title, $description, $content_type, $content, $teacher_id, $category_id, $tags) {

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


    private function addTagToCourse($course_id, $tag_id) {
        $sql_tag = "INSERT INTO coursetags (course_id, tag_id) VALUES (?, ?)";
        $stmt_tag = $this->pdo->prepare($sql_tag);
        $stmt_tag->execute([$course_id, $tag_id]);
    }


 
    public function getAllCoursesWithTags() {
      
        $sql = "SELECT c.course_id, c.title, c.description, c.content, c.status,  
                GROUP_CONCAT(t.name ORDER BY t.name),status  AS tags, 
                c.content_type, 
                cat.name  AS category
                FROM Courses c
                LEFT JOIN CourseTags ct ON c.course_id = ct.course_id
                LEFT JOIN Tags t ON ct.tag_id = t.tag_id
                LEFT JOIN Categories cat ON c.category_id = cat.category_id
                GROUP BY c.course_id";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $courses = $stmt->fetchAll();
    
        return $courses;
    }
    
}
