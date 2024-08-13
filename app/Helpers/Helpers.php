<?php

namespace App\Helpers;

class Helpers
{
    public static function convertEstimateToDays($estimateString) {
        $totalDays = 0;

        preg_match_all('/(\d+)([hdw])/i', $estimateString, $matches);
        if($estimateString === "Not Specified"){
            return 1;
        }

        foreach ($matches[0] as $match) {
            list($quantity, $unit) = sscanf($match, '%d%s');

            switch ($unit) {
                case 'h':
                    $totalDays += $quantity / 8;
                    break;
                case 'd':
                    $totalDays += $quantity;
                    break;
                case 'w':
                    $totalDays += $quantity * 5;
                    break;
                default:
                    ;
            }
        }

        return $totalDays;
    }

    public static function countWeekends($startDate, $endDate)
    {
        $weekends = 0;
        $currentDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        while ($currentDate <= $endDate) {
            $dayOfWeek = date('N', $currentDate);
            if (($dayOfWeek == FRIDAY) || ($dayOfWeek == SATURDAY)) {
                $weekends++;
            }
            $currentDate = strtotime('+1 day', $currentDate);
        }
        return (int)$weekends;
    }
}
