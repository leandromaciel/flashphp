<?php
namespace FlashPHP\Controller\Backend;

use FlashPHP\Singleton\Backend\User_Singleton;
use FlashPHP\Singleton\Smarty_Singleton;
use FlashPHP\Singleton\Core_Singleton;
use FlashPHP\Helper\Utilities;
use FlashPHP\Core\Router;

class Main {

    private $Smarty;
    private $Router;
    private $Security;
    private $User;

    public function __construct() {
        $this->Smarty = Smarty_Singleton::getInstance();
        
        $Core = Core_Singleton::getInstance();
        
        $this->Router = $Core->getRouter();
        $this->Language = $Core->getLanguage();
        $this->Security = $Core->getSecurity();

        $this->User = User_Singleton::getInstance();
    }

	public function index() {
	}

	public function error404() {
        header("HTTP/1.0 404 Page Not Found");
        echo($this->Language->getMessage('page-not-found'));
	}

    public function error403() {
        $this->Security->displayRestHeaders();
        echo($this->Language->getMessage('access-denied'));
    }
}