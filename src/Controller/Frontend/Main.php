<?php
namespace FlashPHP\Controller\Frontend;

use FlashPHP\Singleton\Frontend\User_Singleton;
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