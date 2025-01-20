<?php
namespace Youcode\youdemy;

include $_SERVER['DOCUMENT_ROOT'].'/Youdemy/vendor/autoload.php';
use Youcode\youdemy\user;



class student extends user{

    public function getAllCoursesWithPagination($page)
    {
    
        $offset = $page * 6;
    
   
        $sql = "SELECT users.username, Courses.course_id, Courses.title, Courses.description, Courses.content, Courses.created_at, Courses.status,  
                    GROUP_CONCAT(Tags.name ORDER BY Tags.name) AS tags, 
                    Courses.content_type, 
                    Categories.name AS category 
                FROM Courses
                JOIN CourseTags ON Courses.course_id = CourseTags.course_id
                JOIN Tags ON CourseTags.tag_id = Tags.tag_id
                JOIN Categories ON Courses.category_id = Categories.category_id
                JOIN users ON Courses.teacher_id = users.user_id  
                GROUP BY Courses.course_id
                LIMIT 6 OFFSET $offset";



        $stmt = $this->pdo->prepare($sql);
        // $stmt->bindParam(':offset', $offset);
        $stmt->execute();
        $courses = $stmt->fetchAll();
    
        return $courses;
    }
    
    public function getTotalCoursesCount() {
        $sql = "SELECT COUNT(*) AS total FROM Courses";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    

}