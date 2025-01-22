<?php
namespace Youcode\youdemy;


class VideoContent extends Courses {

    public function displayContent() {

        $safeUrl = htmlspecialchars($this->content);
        
        echo "<h2>Course Video</h2>";
        echo '<iframe width="800" height="450" src="'.$safeUrl.'"></iframe>';
        
    }
}
