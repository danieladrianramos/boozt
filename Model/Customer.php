<?php
namespace Model;

class Customer implements Jsonable {
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    
    public function __contruct() {}

    public function getId() : Int {
        return $this->id;
    }

    public function setId(Int $id) {
        $this->id = $id;
    }

    public function getFirstName() : String {
        return $this->firstName;
    }

    public function setFirstName(String $firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() : String {
        return $this->lastName;
    }

    public function setLastName(String $lastName) {
        $this->lastName = $lastName;
    }

    public function getEmail() : String {
        return $this->email;
    }

    public function setEmail(String $email) {
        $this->email = $email;
    }

    public function toJson() : Array {
        $customer = [];

        $customer["id"] = $this->id;
        $customer["firstName"] = $this->firstName;
        $customer["lastName"] = $this->lastName;
        $customer["email"] = $this->email;

        return $customer;
    }
}
