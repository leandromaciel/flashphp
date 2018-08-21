<?php
namespace NotifyMe\Controller\Frontend;

use NotifyMe\Singleton\Frontend\User_Singleton;
use NotifyMe\Singleton\Smarty_Singleton;
use NotifyMe\Singleton\Core_Singleton;
use NotifyMe\Helper\Utilities;
use NotifyMe\Core\Router;

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
		$this->Smarty->display('Main/default.tpl');
	}

	public function error404() {
        $this->User->setLogin('esse login tá mais doido');
		$this->Smarty->display('Main/error_404.tpl');
	}

    public function error403() {
        $this->Smarty->display('Main/error_403.tpl');
    }
}