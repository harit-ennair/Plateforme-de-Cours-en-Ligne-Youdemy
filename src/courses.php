<?php
namespace Youcode\youdemy;

include $_SERVER['DOCUMENT_ROOT'] . '/Youdemy/vendor/autoload.php';




class Courses 
{

    private $course_id ;
    private $title ;
    private $description ;
    private $content_type ;

    private $teacher_id ;
    private $category_id ;
    private $tags ;


    protected $content;

    public function __construct($content) {
        $this->content = $content;
    }

   
    public function displayContent() {
      
    }

}

