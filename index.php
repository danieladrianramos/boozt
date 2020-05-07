<?php
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');

spl_autoload_register(function ($className) {
    include ROOT_DIR . str_replace('\\', '/', $className) .".php";
});

$db = (new Lib\DB())->getConnection();

$ctrl = new \Controller\Dashboard($db);

$json = file_get_contents('php://input');

if ($json) {
    $ctrl->getStatisticsAjax(json_decode($json));
} else {
    $ctrl->index();
}
