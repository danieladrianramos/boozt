<?php
namespace Controller;

class Dashboard extends MainController {
    public $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function index() {
        $customerProvider = new \Provider\Customer($this->db);
        $customerCount = $customerProvider->count();

        $orderProvider = new \Provider\Order($this->db);
        $orderCount = $orderProvider->count();
        $revenue = $orderProvider->getRevenue();

        $year = date('Y');
        $previousMonth = (int) \Helper\Date::getPreviousMonth();
        $previousMonthLetters = \Helper\Date::getPreviousMonth('F');
        $daysInAMonth = \Helper\Date::getDaysInAMonth($year, $previousMonth);

        // For Chart
        $chartLabelsX = range(1, $daysInAMonth, 1);
        $chartLabelsY = "U\$S";
        $chartValues = $orderProvider->getOrdersInAMonth($year, $previousMonth);
        $chartSeries = \Helper\Chart::convertToHighChartSerie($chartValues, $daysInAMonth);

        // For Statistics filter
        $from = \Helper\Date::getPreviousMonth('Y-m') . "-01";
        $to = date('Y-m') . "-01";

        $view = new \Lib\View("dashboard");
        $view->set("message", "Welcome to the dashboard for the test!");
        $view->set("orderCount", $orderCount);
        $view->set("customerCount", $customerCount);
        $view->set("revenue", $revenue);
        $view->set("chartTitle", $previousMonthLetters ." orders");
        $view->set("chartLabelX", implode("','", $chartLabelsX));
        $view->set("chartLabelY", $chartLabelsY);
        $view->set("chartSeries", $chartSeries);
        $view->set("from", $from);
        $view->set("to", $to);
        echo $view->render();
    }

    public function getStatisticsAjax($data) {
        $orderProvider = new \Provider\Order($this->db);
        $orders = $orderProvider->find($data->from, $data->to, true);

        header('Content-type: application/json');
        echo json_encode($orders);
        die;
    }
}
