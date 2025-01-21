<?php
namespace Youcode\youdemy;


class ContentFactory {

        public static function createContent($content_type, $content) {
            switch ($content_type) {
                
                case 'Video':
                    return new VideoContent($content);
                case 'PDF':
                    return new PDFContent($content);
                default:
                    return null; 
            }
        }
    
    
}

