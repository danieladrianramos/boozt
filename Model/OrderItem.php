<?php
namespace Model;

class OrderItem implements Jsonable {
    private $id;
    private $orderId;   
    private $ean;
    private $quantity;
    private $price;

    public function __contruct() {}

    public function getId() : Int {
        return $this->id;
    }

    public function setId(Int $id) {
        $this->id = $id;
    }

    public function getOrderId() : Int {
        return $this->orderId;
    }

    public function setOrderId(Int $orderId) {
        $this->orderId = $orderId;
    }

    public function getEan() : String {
        return $this->ean;
    }

    public function setEan(String $ean) {
        $this->ean = $ean;
    }

    public function getQuantity() : Int {
        return $this->quantity;
    }

    public function setQuantity(Int $quantity) {
        $this->quantity = $quantity;
    }

    public function getPrice() : Float {
        return $this->price;
    }

    public function setPrice(Float $price) {
        $this->price = $price;
    }

    public function toJson() : Array {
        $item = [];

        $item["id"] = $this->id;
        $item["orderId"] = $this->orderId;
        $item["ean"] = $this->ean;
        $item["quantity"] = $this->quantity;
        $item["price"] = $this->price;

        return $item;
    }
}
