<?php
namespace FlashPHP\Singleton\Backend;

use FlashPHP\Singleton\Core_Singleton;
use FlashPHP\Singleton\Smarty_Singleton;
use FlashPHP\Core\Data_Object;


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
        'securityHash' => 'security_hash',
        'loggedIn' => 'logged_in',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at' 
        );

    private $DB_Factory;

    public $list = array();
    public $listIds = array();

    private $Security;

    /**
     * Construtor do tipo protegido previne que uma nova instância da
     * Classe seja criada através do operador `new` de fora dessa classe.
     */
    protected function __construct() {
        $this->DB_Factory = Core_Singleton::getInstance()->getDB_Factory();
        $this->Security = Core_Singleton::getInstance()->getSecurity();
    }

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

    public function doFindByIds(array $listIds = null) {
        $ids = [];

        if (is_array($listIds)) {
            $ids = $listIds;
        } else {
            foreach($this->listIds as $field => $value) {
                $ids[] = $value['id'];
            }
        }

        if ( count($ids) >= 1 ) {
            $inArray  = implode(',', $ids);
            $sql = "SELECT * FROM {$this::$_table['name']} WHERE {$this::$_table['name']}.id IN ({$inArray})";
            $statement = $this->DB_Factory->DBConnection->prepare($sql);
            $statement->execute();
            
            $this->list = array();
            
            while ( $user = $statement->fetchObject(__CLASS__) ) {
                $this->list[] = $user->data;
            }

            return $this->list;
        }
        
        return false;
    }

    private function findIdAll() {
        $statement = $this->DB_Factory->DBConnection->query("SELECT {$this::$_table['name']}.id FROM {$this::$_table['name']}");

        $this->listIds = array();
        
        while ( $user = $statement->fetchObject(__CLASS__) ) {
            $this->listIds[] = $user->data;
        }

        return $this->listIds;
    }

    private function findIdByLogin(string $login) {
        $query = "SELECT {$this::$_table['name']}.id FROM {$this::$_table['name']} WHERE {$this::$_table['name']}.login = :login";

        $statement = $this->DB_Factory->DBConnection->prepare($query);
        $statement->bindParam(':login', $login);
        $statement->execute();

        $this->listIds = array();
        
        while ( $user = $statement->fetchObject(__CLASS__) ) {
            $this->listIds[] = $user->data;
        }

        return $this->listIds;
    }

    private function findIdByNameOrLastName(string $name, string $lastName = null) {
        if (!is_null($lastName)) {
            $query = "SELECT 
                        {$this::$_table['name']}.id 
                    FROM 
                        {$this::$_table['name']} 
                    WHERE 
                        {$this::$_table['name']}.name LIKE '%:name%' 
                        OR 
                        {$this::$_table['name']}.last_name LIKE '%:last_name%'";
            
            $statement = $this->DB_Factory->DBConnection->prepare($query);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':last_name', $lastName);
        } else {
            $query = "SELECT 
                        {$this::$_table['name']}.id 
                    FROM 
                        {$this::$_table['name']} 
                    WHERE 
                        {$this::$_table['name']}.name LIKE '%:name%'";

            $statement = $this->DB_Factory->DBConnection->prepare($query);
            $statement->bindParam(':name', $name);
        }

        $statement->execute();

        $this->listIds = array();
        
        while ( $user = $statement->fetchObject(__CLASS__) ) {
            $this->listIds[] = $user->data;
        }

        return $this->listIds;
    }

    public function findOneById(int $id) {
        $query = "SELECT * FROM {$this::$_table['name']} WHERE {$this::$_table['name']}.id = :id LIMIT 0,1";

        $statement = $this->DB_Factory->DBConnection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();

        $user = $statement->fetchObject(__CLASS__);

        return $user->data;
    }

    public function findAll() {
        $this->findIdAll();
        return $this->doFindByIds();
    }

    public function findByLogin(string $login) {
        $this->findIdByLogin($login);
        return $this->doFindByIds();
    }

    public function findByNameOrLastName(string $name, string $lastName = null) {
        $this->findIdByNameOrLastName($name, $lastName);
        return $this->doFindByIds();
    }

    public function doLogin(string $login, string $password) {
        $query = "SELECT * FROM {$this::$_table['name']} WHERE {$this::$_table['name']}.login = :login AND {$this::$_table['name']}.password  = :password LIMIT 0,1";

        $statement = $this->DB_Factory->DBConnection->prepare($query);
        $statement->bindParam(':login', $login);
        $statement->bindParam(':password', $password);
        $statement->execute();

        $user = $statement->fetchObject(__CLASS__);

        if ( !$user ) {
            return false;
        } else {
            return true;
        }
    }

    public function insert() {
        $this->DB_Factory->setFields($this->data);
        $queryData = $this->DB_Factory->prepareInsert();

        $finalQuery = "INSERT INTO {$this::$_table['name']}{$queryData['fields']} VALUES {$queryData['values']}";

        $statement = $this->DB_Factory->DBConnection->query($finalQuery);
        $lastId = $this->DB_Factory->DBConnection->lastInsertId();

        return $lastId;
    }

    public function update($id) {

        $this->DB_Factory->setFields($this->data);
        $updateFields = $this->DB_Factory->prepareUpdate();

        $newData = ['id' => $id];

        foreach ($this->data as $field => $value) {
            $newData[$field] = $value;
        }

        $sql = "UPDATE {$this::$_table['name']} SET {$updateFields} WHERE id=:id";
        
        $statement= $this->DB_Factory->DBConnection->prepare($sql);
        $statement->execute($newData);
        
        $affectedRows = $statement->rowCount();

        if ($affectedRows === 1) {
            return true;
        } else {
            return false;
        }
    }
}