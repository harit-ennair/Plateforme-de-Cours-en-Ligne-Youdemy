<?php
namespace Youcode\youdemy;


class PDFContent extends Courses {

    public function displayContent() {

        $safeUrl = htmlspecialchars($this->content);

        echo "<h2>Course PDF</h2>";
        echo '<iframe width="800" height="450" src="'.$safeUrl.'"></iframe>';
    }
}

