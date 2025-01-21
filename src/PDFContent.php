<?php
namespace Youcode\youdemy;


class PDFContent extends Content {

    public function displayContent() {

        $safeUrl = htmlspecialchars($this->content);

        echo "<h2>Course PDF</h2>";
        echo '<iframe width="560" height="315" src="'.$safeUrl.'"></iframe>';
    }
}

