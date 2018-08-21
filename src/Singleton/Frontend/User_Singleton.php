<?php
namespace NotifyMe\Singleton\Frontend;

use NotifyMe\Singleton\Smarty_Singleton;

class User_Singleton {

    private $_id = 0;
    private $_login = '';
    private $_password = '';

    /**
     * Retorna uma instância única da classe.
     *
     * @staticvar User_Singleton $instance A instância única dessa classe.
     *
     * @return User_Singleton A Instância única.
     */
    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Construtor do tipo protegido previne que uma nova instância da
     * Classe seja criada através do operador `new` de fora dessa classe.
     */
    protected function __construct() {
        $Smarty = Smarty_Singleton::getInstance();
        $Smarty->assign('User', $this);
    }

    /**
     * Método clone do tipo privado previne a clonagem dessa instância
     * da classe
     *
     * @return void
     */
    private function __clone() {
    }

    /**
     * Método unserialize do tipo privado para prevenir a desserialização
     * da instância dessa classe.
     *
     * @return void
     */
    private function __wakeup() {
    }

    public function setId(int $id) {
        $this->_id = $id;
    }

    public function getId():int {
        return $this->_id;
    }

    public function setLogin(string $login) {
        $this->_login = $login;
    }

    public function getLogin():string {
        return $this->_login;
    }

    public function setPassword(string $password) {
        $this->_password = $password;
    }

    public function getPassword():string {
        return $this->_password;
    }
}