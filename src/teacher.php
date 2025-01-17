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






}
