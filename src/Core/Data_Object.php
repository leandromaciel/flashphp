<?php 
namespace NotifyMe\Core;

class Data_Object {
    private $changedFields = array(); // list of updated fields
    private $data = array(); // original row from PDOStatement
    private $funcFields = array(); // fields that use MySQL functions
    // The properties above are private in this class, so even if in your subclass you define some properties named the same, or you associate a property of the same name with a field in your table, they will never influence these properties.
    
    function __get($property) {
        if (isset($this::$_propertyList[$property])) {
            return $this->data[$this::$_propertyList[$property]]; // access fields by PHP properties
        } else {
            return $this->$property; // throw the default PHP error
        }
    }
    
    function __set($property, $value) {
        if (isset($this::$_propertyList[$property])) {
            $field = $this::$_propertyList[$property];
            $this->data[$field] = $value; // update $data
            
            // take down changed fields
            if (!in_array($field, $this->changedFields)) {
                array_push($this->changedFields, $field);
            }
            $index = array_search($field, $this->funcFields);
            if ($index !== false) {
                unset($this->funcFields[$index]);
                $this->funcFields = array_values($this->funcFields);
            }
        } else {
            // For fetchObject
            $this->data[$property] = $value; // redirect to Array $data
        }
    }
    
    private function checkPrimaryKey() {}
    private function clear() {}
    public function delete() {}
    public function insert() {}
    public function update() {}
    public function useFunction($property, $function) {}
}