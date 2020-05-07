<?php
namespace Provider;

class Customer implements Countable {
    protected $db;

    public function __construct($dbConn) {        
        $this->db = $dbConn;
    }

    public function count() : Int {
        try {
            $sql = "SELECT count(*) as count FROM customers";
            $rs = $this->db->query($sql);
            $result = $rs->fetchAll(\PDO::FETCH_ASSOC);

            return $result[0]["count"];
        } catch (\PDOException $e) {
            throw($e);
        }
    }

    public function findById(Int $id) : \Model\Customer {
        try {
            $sql = "SELECT * FROM customers WHERE id = ". $id;
            $rs = $this->db->query($sql);
            $result = $rs->fetchAll(\PDO::FETCH_ASSOC);

            return $this->toSingleModel($result);
        } catch (\PDOException $e) {
            throw($e);
        }
    }

    private function toSingleModel(Array $data) : \Model\Customer {
        $customer = new \Model\Customer();

        $customer->setId($data[0]["id"]);
        $customer->setFirstName($data[0]["first_name"]);
        $customer->setLastName($data[0]["last_name"]);
        $customer->setEmail($data[0]["email"]);
        
        return $customer;
    }
}
