<?php
namespace Provider;

class Order implements Countable {
    protected $db;

    public function __construct($dbConn) {        
        $this->db = $dbConn;
    }

    public function count() : Int {
        try {
            $sql = "SELECT count(1) as count FROM orders";
            $rs = $this->db->query($sql);
            $result = $rs->fetchAll(\PDO::FETCH_ASSOC);

            return $result[0]["count"];
        } catch (\PDOException $e) {
            throw($e);
        }
    }

    public function getRevenue() : Float {
        try {
            $sql = "SELECT SUM(price * quantity) as revenue FROM order_items";
            $rs = $this->db->query($sql);
            $result = $rs->fetchAll(\PDO::FETCH_ASSOC);

            return $result[0]["revenue"];
        } catch (\PDOException $e) {
            throw($e);
        }
    }

    public function getOrdersInAMonth($year, $previousMonth) : Array {
        $previousMonth = ($previousMonth < 10) 
            ? '0'. $previousMonth
            : ''. $previousMonth;

        try {
            $sql = "
                SELECT 
                    c.last_name as name,
                    DATE_FORMAT(o.purchase_date, '%e') as day,
                    SUM(price * quantity) as total 
                FROM orders o 
                INNER JOIN customers c ON o.customer_id = c.id
                INNER JOIN order_items oi ON oi.order_id = o.id
                WHERE 
                    o.purchase_date >= '". $year ."-". $previousMonth ."-01 00:00:00'
                    AND o.purchase_date <= '". $year ."-". $previousMonth ."-31 23:59:59'
                GROUP BY 
                    name, day
                ORDER BY 
                    name, day
            ";
            $rs = $this->db->query($sql);
            $result = $rs->fetchAll(\PDO::FETCH_ASSOC);

            return $result;
        } catch (\PDOException $e) {
            throw($e);
        }
    }

    public function find(String $from, String $to, Bool $toJson = false) : Array {
        try {
            $sql = "
                SELECT * 
                FROM orders 
                WHERE 
                    purchase_date >= '". $from ." 00:00:00'
                    AND purchase_date <= '". $to ." 23:59:59'
            ";
            $rs = $this->db->query($sql);
            $result = $rs->fetchAll(\PDO::FETCH_ASSOC);

            return $this->toModel($result, $toJson);
        } catch (\PDOException $e) {
            throw($e);
        }
    }

    private function toModel(Array $data, Bool $toJson) : Array {
        $response = [];
        
        foreach ($data as $item) {
            $order = new \Model\Order();
            $order->setId($item["id"]);
            $order->setCustomerId($item["customer_id"]);
            $order->setPurchaseDate($item["purchase_date"]);
            $order->setCountry($item["country"]);
            $order->setDevice($item["device"]);

            $customerProvider = new \Provider\Customer($this->db);
            $customer = $customerProvider->findById($item["customer_id"]);
            $order->setCustomer($customer);

            $orderItemProvider = new \Provider\OrderItem($this->db);
            $items = $orderItemProvider->findByOrderId($item["id"]);
            $order->setItems($items);

            if ($toJson) {
                $response[] = $order->toJson();
            } else {
                $response[] = $order;
            }
        }
        
        return $response;
    }
}
