<?php
namespace Youcode\youdemy;


class VideoContent extends Content {

    public function displayContent() {

        $safeUrl = htmlspecialchars($this->content);
        
        echo "<h2>Course Video</h2>";
        echo '<iframe width="560" height="315" src="'.$safeUrl.'"></iframe>';
    }
}
