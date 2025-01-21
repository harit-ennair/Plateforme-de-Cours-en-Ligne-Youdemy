<?php
namespace Youcode\youdemy;

include $_SERVER['DOCUMENT_ROOT'].'/Youdemy/vendor/autoload.php';
use Youcode\youdemy\user;



class student extends user{

 

    public function getAllCoursesWithPagination($page, $search)
    {

        $searchTerm = '%' . $search . '%'; 
    
        $offset = $page  * 6;
    

        $sql = "SELECT users.username, Courses.course_id, Courses.title, Courses.description, Courses.content, Courses.created_at, Courses.status,  
                        GROUP_CONCAT(Tags.name ORDER BY Tags.name) AS tags, 
                        Courses.content_type, 
                        Categories.name AS category 
                    FROM Courses
                    JOIN CourseTags ON Courses.course_id = CourseTags.course_id
                    JOIN Tags ON CourseTags.tag_id = Tags.tag_id
                    JOIN Categories ON Courses.category_id = Categories.category_id
                    JOIN users ON Courses.teacher_id = users.user_id  
                    WHERE Courses.status = 'active'
                    AND (Courses.title LIKE :searchTerm OR Categories.name LIKE :searchTerm OR tags.name LIKE :searchTerm) 
                    GROUP BY Courses.course_id
                    LIMIT 6 OFFSET $offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':searchTerm', $searchTerm);     
        $stmt->execute();
        $courses = $stmt->fetchAll();
    
        return $courses;
    }




    public function enrollInCourse($student_id, $course_id) {
   
        $stmt = $this->pdo->prepare("SELECT * FROM Enrollments WHERE student_id = :student_id AND course_id = :course_id");
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
    
        
        if ($stmt->rowCount() > 0) {
            return false; 
        }
    
      
        $stmt = $this->pdo->prepare("INSERT INTO Enrollments (student_id, course_id) VALUES (:student_id, :course_id)");
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
    
        return true;  
    }


    public function getCoursesForStudent($student_id) 
{
    $sql = "SELECT users.username, Courses.course_id, Courses.title, Courses.description, Courses.content, Courses.created_at, Courses.status,  
            GROUP_CONCAT(Tags.name ORDER BY Tags.name) AS tags, 
            Courses.content_type, 
            Categories.name AS category 
            FROM Courses
            JOIN CourseTags ON Courses.course_id = CourseTags.course_id
            JOIN Tags ON CourseTags.tag_id = Tags.tag_id
            JOIN Categories ON Courses.category_id = Categories.category_id
            JOIN users ON Courses.teacher_id = users.user_id  
            JOIN Enrollments ON Enrollments.course_id = Courses.course_id  
            WHERE Enrollments.student_id = :student_id 
            GROUP BY Courses.course_id";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);  

    $stmt->execute();
    $courses = $stmt->fetchAll();

    return $courses;
}

public function removeFromCourse($student_id, $course_id) {
    
    $stmt = $this->pdo->prepare("DELETE FROM enrollments WHERE student_id = :student_id AND course_id = :course_id");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':course_id', $course_id);
    
    return $stmt->execute();
}

    

    

}