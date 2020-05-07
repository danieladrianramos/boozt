<?php
namespace Helper;

class Chart {
    public static function convertToHighChartSerie(Array $data, Int $days) : Array {
        $response = [];
        $auxDays = $days;
        $lastName = null;
        
        foreach ($data as $item) {
            if ($lastName != $item["name"]) {
                $lastName = $item["name"];
                $response[$lastName] = array_fill(1, $days, 0);
            }

            $day = $item["day"];    
            $response[$lastName][$day] = $item["total"];
        }

        return $response;
    }
}
