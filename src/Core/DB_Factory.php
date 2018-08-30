<?php
namespace NotifyMe\Core;
use PDO;

class DB_Factory {
    public $DBConnection;
    public $DBConnectionError;

    private $table;
    private $fields;
    private $where;
    private $limit;
    private $query;

    public function __construct(PDO $DBConnection, int $limit) {
        $this->DBConnection = $DBConnection;
        $this->setLimit($limit);
    }

    public function setTable(string $table) {
        $this->table = $table;
    }

    public function getTable() {
        return $this->table;
    }

    public function setFields(array $fields) {
        $this->fields = $fields;
    }

    public function getFields() {
        return $this->fields;
    }

    public function setWhere(string $where) {
        $this->where = $where;
    }

    public function getWhere() {
       return $this->where;
    }

    public function setLimit(int $limit) {
        $this->limit = $limit;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setQuery(string $query) {
        $this->query.= $query;
    }

    public function getQuery() {
        return $this->query;
    }

    public function flushQuery() {
        $this->query = null;
    }

    private function prepareFieldsForSelect() {

        $preparedFields = '';

        if (is_array($this->getFields())) {
            foreach ( $this->fields as $key => $field ) {
                $preparedFields.= "{$this->table}.{$field},";
            }
        } else {
            $preparedFields = '*';
        }
        
        return $preparedFields;
    }

    private function prepareFieldsForInsert() {
        $preparedFields = '(';

        if (is_array($this->getFields())) {
            foreach ( $this->fields as $field => $value ) {
                $preparedFields.= "{$field},";
            }
        }
        
        $size = strlen($preparedFields);
        $finalFields = substr($preparedFields, 0, $size-1).')';
        
        return $finalFields;
    }

    private function prepareValuesForInsert() {
        $preparedValues = '(';

        if (is_array($this->getFields())) {
            foreach ( $this->fields as $field => $value ) {
                $preparedValues.= "'{$value}',";
            }
        }
        
        $size = strlen($preparedValues);
        $finalValues = substr($preparedValues, 0, $size-1).')';
        
        return $finalValues;
    }

    private function prepareSelect() {
        $fields = $this->prepareFields();
        $table = $this->getTable();

        $this->flushQuery();
        $this->setQuery("select {$fields} from {$table} ");
        
        if (!is_null($this->getWhere())) {
            $where = $this->getWhere();
            $this->setQuery("where {$where}");
        }

        $limit = $this->getLimit();
        $this->setQuery(" limit {$limit} ");
    }

    public function prepareInsert() {
        $fields = $this->prepareFieldsForInsert();
        $values = $this->prepareValuesForInsert();

        $insertData = [
            'fields' => $fields,
            'values' => $values
        ];

        return $insertData;
    }

    private function executeQuery() {
        $DBFetch = $this->DBConnection->prepare($this->query);
        try {
            $stmt = $DBFetch->execute();
        } catch (PDO_Exception $Error) {
            die(var_dump($Error->getMessage()));
        }
        
        return $DBFetch;
    }

    public function findAll($where = null) {
        $this->prepareSelect($where);
        return $this->executeQuery();
    }

    public function findOne($where) {
        $query = $this->prepareSelect($where);
        $this->setLimit(1);
        $this->executeQuery();
    }
}