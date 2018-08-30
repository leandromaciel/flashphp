<?php
namespace NotifyMe\Singleton\Frontend;

use NotifyMe\Singleton\Core_Singleton;
use NotifyMe\Singleton\Smarty_Singleton;
use NotifyMe\Core\Data_Object;


class User_Singleton extends Data_Object {

    // name: Table Name, key: Primary Key (can be an array), auto: AUTO_INCREMENT field
    protected static $_table = array(
        'name' => 'users', 
        'key' => 'id', 
        'auto' => 'id');
    
    // relationships between PHP properties and MySQL field names
    protected static $_propertyList = array(
        'id' => 'id', 
        'login' => 'login', 
        'password' => 'password',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at', 
        'securityHash' => 'security_hash');

    private $DB_Factory;

    public $list = array();

    /**
     * Construtor do tipo protegido previne que uma nova instância da
     * Classe seja criada através do operador `new` de fora dessa classe.
     */
    protected function __construct() {
        $this->DB_Factory = Core_Singleton::getInstance()->getDB_Factory();
    }

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

    public function findAll() {
        $statement = $this->DB_Factory->DBConnection->query('select * from '.$this::$_table['name']);

        $this->list = array();
        
        while ( $user = $statement->fetchObject(__CLASS__) ) {
            $this->list[] = $user->data;
        }

        return $this->list;
    }

    public function insert() {
        $this->DB_Factory->setFields($this->data);
        $queryData = $this->DB_Factory->prepareInsert();

        $finalQuery = 'INSERT INTO '.$this::$_table['name'].$queryData['fields']. ' VALUES'.$queryData['values'];

        $statement = $this->DB_Factory->DBConnection->query($finalQuery);
        $lastId = $this->DB_Factory->DBConnection->lastInsertId();

        return $lastId;
    }
}