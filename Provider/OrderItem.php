<?php
namespace Provider;

class OrderItem {
    protected $db;

    public function __construct($dbConn) {        
        $this->db = $dbConn;
    }

    public function findByOrderId(Int $orderId) : Array {
        try {
            $sql = "SELECT * FROM order_items WHERE order_id = ". $orderId;
            $rs = $this->db->query($sql);
            $result = $rs->fetchAll(\PDO::FETCH_ASSOC);

            return $this->toModel($result);
        } catch (\PDOException $e) {
            throw($e);
        }
    }

    private function toModel(Array $data) : Array {
        $response = [];
        
        foreach ($data as $item) {
            $orderItem = new \Model\OrderItem();
            $orderItem->setId($item["id"]);
            $orderItem->setOrderId($item["order_id"]);
            $orderItem->setEan($item["ean"]);
            $orderItem->setQuantity($item["quantity"]);
            $orderItem->setPrice($item["price"]);

            $response[] = $orderItem;
        }
        
        return $response;
    }
}
