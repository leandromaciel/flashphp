<?php
namespace NotifyMe\Controller\Frontend;

use NotifyMe\Singleton\Smarty_Singleton;
use NotifyMe\Singleton\Frontend\User_Singleton;
use NotifyMe\Model\Frontend\User_Model;
use NotifyMe\Helper\Utilities;


class User {

    private $User;
    private $Model;
    private $Utilities;
    private $Data;
    private $Smarty;

    public function __construct() {
        $this->User = User_Singleton::getInstance();
        $this->Model = new User_Model();
        $this->Smarty = Smarty_Singleton::getInstance();
        $this->Utilities = new Utilities();
    }

    public function index() {
        $this->Model->getList();

        $this->Utilities->displayRestHeaders();
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo json_encode($_SERVER);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
        }
    }

    public function doLogin() {

        $userList = $this->Model->doLogin();

        //foreach($user)

        //$_POST['login'] = 'teste';
        //$_POST['password'] = 'senha';
        
        //if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /* header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
 */
            
            /* $this->User->setLogin($_POST['login']);
            $this->User->setPassword($_POST['password']);
            
            $responseData = array(
                'LoginOK' => $this->User->getLogin(),
                'passwordOK' => $this->User->getPassword()
            );
             */
            //echo json_encode($_POST);
        /* } else {
            header("HTTP/1.0 404 Not Found"); */
        //}
    }
}