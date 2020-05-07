<?php
namespace Helper;

class Date {
    public static function getPreviousMonth(String $format = "m") {
        return date($format, strtotime(date('Y-m')." -1 month"));
    }

    public static function getDaysInAMonth(Int $year, Int $month) {
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }
}