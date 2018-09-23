<?php
namespace FlashPHP\Singleton;

use Smarty;

class Smarty_Singleton extends Smarty {

    private $_baseUrl;

    /**
     * Retorna uma instância única da classe.
     *
     * @staticvar Smarty_Singleton $instance A instância única dessa classe.
     *
     * @return Smarty_Singleton A Instância única.
     */
    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
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

    public function setBaseUrl(string $baseUrl) {
        $this->_baseUrl = $baseUrl;
    }

    public function getBaseUrl():string {
        if (isset($this->_baseUrl)) {
            return $this->_baseUrl;
        }

        return $this->_baseUrl = '';
    }
}