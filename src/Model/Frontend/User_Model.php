<?php
namespace NotifyMe\Model\Frontend;

use NotifyMe\Singleton\Frontend\User_Singleton;

class User_Model extends User_Singleton {

    private $User;

    public function __construct() {
        $this->User = User_Singleton::getInstance();
    }

    public function doLogin() {
        $this->User->setLogin('novo_valor');
        $this->User->setPassword('nova-senha');
    }
}