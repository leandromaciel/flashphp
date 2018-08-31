<?php
namespace NotifyMe\Controller\Backend;

use NotifyMe\Singleton\Backend\User_Singleton;
use NotifyMe\Model\Backend\User_Model;
use NotifyMe\Helper\Utilities;
use NotifyMe\Singleton\Core_Singleton;


class User {

    private $User;
    private $Model;
    private $Utilities;
    private $Data;
    private $Language;

    public function __construct() {
        $this->User = User_Singleton::getInstance();
        $this->Model = new User_Model();
        $this->Utilities = new Utilities();
        $this->Security = Core_Singleton::getInstance()->getSecurity();
        $this->Language = Core_Singleton::getInstance()->getLanguage(); 
    }

    public function index() {
        if ($this->Security->validateRequestMethod('GET')) {
            $userData = $this->Model->getList();
            $this->Security->displayRestHeaders();
            echo json_encode($userData);
        }
    }

    public function show(int $id) {
        if ($this->Security->validateRequestMethod('GET')) {
            
            $userData = $this->Model->getOneById($id);
            $this->Security->displayRestHeaders();
        
            echo json_encode($userData);
        }
    }

    public function doLogin() {
        if ($this->Security->validateRequestMethod('POST')) {
            $userData = json_decode(file_get_contents("php://input"));
            
            if ($this->Model->doLogin($userData)) {
                $responseData = [
                    'AUTHORIZED' => true, 
                    'CSRF_TOKEN_NAME' => $this->Security->getCsrfTokenName(),
                    'CSRF_TOKEN_VALUE' => $this->Security->getCsrfTokenValue(),
                    'CREDENTIALS' => 'admin',
                    'USER_LOGIN' => $userData->userLogin
                ];        
            } else {
                $responseData = [
                    'AUTHORIZED' => false,
                    'error_message' => $this->Language->getMessage('login-failed')
                ];
            }
            
            $this->Security->displayRestHeaders();
            echo json_encode($responseData);
        }
    }

    public function exportCSV() {
        if ($this->Security->validateRequestMethod('POST')) {
            $listIds = json_decode(file_get_contents("php://input"));
            $userData = $this->Model->getListByIds($listIds);

            $this->Security->displayRestHeaders();
            echo json_encode($userData);
        }
    }

    public function edit() {
        if ($this->Security->validateRequestMethod('POST')) {
            $userData = json_decode(file_get_contents("php://input"));
            $serverResponse = $this->Model->setUserById($userData);

            $this->Security->displayRestHeaders();
            echo json_encode($serverResponse);
        }
    }
}