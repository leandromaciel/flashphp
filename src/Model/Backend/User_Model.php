<?php
namespace NotifyMe\Model\Backend;

use NotifyMe\Singleton\Backend\User_Singleton;
use NotifyMe\Singleton\Core_Singleton;
use NotifyMe\Helper\Utilities;

class User_Model {

    private $User;
    private $DB_Factory;
    private $Utilities;
    private $Security;

    public function __construct() {
        $this->User = User_Singleton::getInstance();
        $this->DB_Factory = Core_Singleton::getInstance()->getDB_Factory();
        $this->Utilities = new Utilities();
        $this->Security = Core_Singleton::getInstance()->getSecurity();
    }

    public function doLogin($userData) {
        $cleanLogin = $this->Utilities->sanitizeData($userData->userLogin);
        $cleanPassword = md5($this->Utilities->sanitizedata($userData->userPassword));

        $authorization = $this->User->doLogin($cleanLogin, $cleanPassword);

        return $authorization;
    }

    public function getList() {
        $userList = $this->User->findAll();
        return $userList;
    }

    public function getListByIds($idsData) {
        $userList = $this->User->doFindByIds($idsData->listIds);
        return $userList;
    }

    public function getOneById(int $id) {
        $cleanId = $this->Utilities->sanitizeData($id);
        $userData = $this->User->findOneById($cleanId);
        return $userData;
    }

    public function populateDB() {
        for($i = 1; $i <= 10000; $i++) {
            $this->User->login = "usuario_{$i}@teste{$i}.com";
            $this->User->password = md5($i);
            $this->User->securityHash = md5("usuario{$i}");
            $this->User->createdAt = date('Y-m-d H:i:s');

            $this->User->insert();

            echo "Inserindo usuario {$i}";
        }
    }
}