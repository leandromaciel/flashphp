<?php
namespace FlashPHP\Singleton;

class Core_Singleton {

    private $Router;
    private $Language;
    private $Security;
    private $DB_Factory;
    private $Logger;
    private $Message;

    /**
     * Retorna uma instância única da classe.
     *
     * @staticvar Core_Singleton $instance A instância única dessa classe.
     *
     * @return Core_Singleton A Instância única.
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

    public function setRouter($Router) {
        $this->Router = $Router;
    }

    public function getRouter() {
        return $this->Router;
    }

    public function setLanguage($Language) {
        $this->Language = $Language;
    }

    public function getLanguage() {
        return $this->Language;
    }

    public function setSecurity($Security) {
        $this->Security = $Security;
    }

    public function getSecurity() {
        return $this->Security;
    }

    public function setDB_Factory($DB_Factory) {
        $this->DB_Factory = $DB_Factory;
    }

    public function getDB_Factory() {
        return $this->DB_Factory;
    }

    public function setLogger($Logger) {
        $this->Logger = $Logger;
    }

    public function getLogger() {
        return $this->Logger;
    }

    public function setMessage($Message) {
        $this->Message = $Message;
    }

    public function getMessage() {
        return $this->Message;
    }
}