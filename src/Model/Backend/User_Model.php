<?php
namespace FlashPHP\Model\Backend;

use FlashPHP\Singleton\Backend\User_Singleton;
use FlashPHP\Singleton\Core_Singleton;
use FlashPHP\Helper\Utilities;

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

    public function registerLogin(string $login) {
        $userData = $this->User->findByLogin($login);
        
        $this->User->securityHash = $this->Security->getCsrfTokenValue();
        $this->User->loggedIn = 1;
        
        $registerLogin = $this->User->update($userData[0]['id']);
        
        return $registerLogin;
    }

    public function validateSecurityHash($userData) {
        $validationData = $this->User->findByLogin($userData->USER_LOGIN);

        if ( is_array($validationData) ) {
            if ( $validationData[0]['security_hash'] === $userData->CSRF_TOKEN_VALUE ) {
                return true;
            } 
        }

        return false;
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

            echo "Inserindo usuario {$i}<br />";
            flush();
        }
    }

    public function setUserById($userData) {
        $this->User->login = $userData->login;
        $this->User->password = md5($userData->password);
        $isUpdated = $this->User->update($userData->id, $userData->security_hash);

        if ($isUpdated) {
            return array('success_message' => true);
        } else {
            return array('error_message' => true);
        }
    }
}