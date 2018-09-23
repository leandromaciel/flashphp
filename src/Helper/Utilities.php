<?php

namespace FlashPHP\Helper;

class Utilities {

    public function doSanitize($method = 'post'):array {

        $sanitizedData = array();

        switch($method) {
            case 'get':
                $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
                $sanitizedData = $this->clearSpaces($_GET);
                break;
            case 'post':
                $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $sanitizedData = $this->clearSpaces($_POST);
                break;
        }   
        
        return $sanitizedData;
    }

    public function sanitizeData($data) {
        $sanitizedData = htmlspecialchars(strip_tags($data));
        return $sanitizedData;
    }

    public function clearSpaces(array $data):array {
        return array_map('trim', $data);
    }
}