<?php
namespace Model;

class Order implements Jsonable {
    private $id;
    private $customerId;
    private $purchaseDate;
    private $country;
    private $device;

    // Relations
    private $customer = null;
    private $items = [];
    
    public function __contruct() {}

    public function getId() : Int {
        return $this->id;
    }

    public function setId(Int $id) {
        $this->id = $id;
    }

    public function getCustomerId() : Int {
        return $this->customerId;
    }

    public function setCustomerId(Int $customerId) {
        $this->customerId = $customerId;
    }

    public function getPurchaseDate() : String {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(String $purchaseDate) {
        $this->purchaseDate = $purchaseDate;
    }

    public function getCountry() : String {
        return $this->country;
    }

    public function setCountry(String $country) {
        $this->country = $country;
    }

    public function getDevice() : String {
        return $this->device;
    }

    public function setDevice(String $device) {
        $this->device = $device;
    }

    // Relations
    public function getCustomer() : \Model\Customer {
        return $this->customer;
    }

    public function setCustomer(\Model\Customer $customer) {
        $this->customer = $customer;
    }

    public function getItems() : Array {
        return $this->items;
    }

    public function setItems(Array $items) {
        $this->items = $items;
    }

    public function toJson() : Array {
        $order = [];

        $order["id"] = $this->id;
        $order["customerId"] = $this->customerId;
        $order["purchaseDate"] = $this->purchaseDate;
        $order["country"] = $this->country;
        $order["device"] = $this->device;
    
        $order["customer"] = $this->customer->toJson();

        foreach ($this->items as $item) {
            $order["items"][] = $item->toJson();
        }

        return $order;
    }
}
