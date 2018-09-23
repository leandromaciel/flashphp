<?php
namespace FlashPHP\Model\Frontend;

use FlashPHP\Singleton\Frontend\User_Singleton;
use FlashPHP\Singleton\Core_Singleton;

class User_Model {

    private $User;
    private $DB_Factory;

    public function __construct() {
        $this->User = User_Singleton::getInstance();
        $this->DB_Factory = Core_Singleton::getInstance()->getDB_Factory();
    }

    public function doLogin() {

    }

    public function getList() {
        $userList = $this->User->findAll();
        return $userList;
    }
}