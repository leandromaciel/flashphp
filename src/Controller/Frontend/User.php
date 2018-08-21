<?php
namespace NotifyMe\Controller\Frontend;

use NotifyMe\Singleton\Smarty_Singleton;
use NotifyMe\Singleton\Frontend\User_Singleton;
use NotifyMe\Model\Frontend\User_Model;
use NotifyMe\Helper\Utilities;


class User extends User_Singleton {

    private $User;
    private $Model;
    private $Utilities;
    private $Data;
    private $Smarty;

    public function __construct() {
        $this->User = User_Singleton::getInstance();
        $this->Model = new User_Model();
        $this->Utilities = new Utilities();

        $this->Smarty = Smarty_Singleton::getInstance();
        $this->Smarty->assign('User', $this->User);
    }

    public function index() {
        $this->Smarty->assign('texto qualquer', 'texto');
        $this->Smarty->display('User/index.tpl');
    }

    public function doLogin() {

        $_POST['login'] = 'teste';
        $_POST['password'] = 'senha';
        //if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // required headers
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            
            //$this->Data = $this->Utilities->doSanitize();

            $this->User->setLogin($_POST['login']);
            $this->User->setPassword($_POST['password']);
            
            $responseData = array(
                'LoginOK' => $this->User->getLogin(),
                'passwordOK' => $this->User->getPassword()
            );

            echo json_encode($responseData);
        //}

    }
}