<?php

namespace App\Utilities;

use Carbon\Carbon;

class DateUtilities {

    /**
     * @param string date from format Y-m-d
     * @return bool if the date is between 18 and 65
     */
    public static function isBetween18and65(?string $date): bool
    {
        if (empty($date)) {
            return true;
        }
        $now = date("Y-m-d");
        $date18years = date('Y-m-d', strtotime('-18 years', strtotime($now)));
        $date65years = date('Y-m-d', strtotime('-65 years', strtotime($now)));
        if (strtotime($date65years) < strtotime($date) && strtotime($date) < strtotime($date18years)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string date from any format
     * @return string formatted to Y-m-d
     */
    public static function formattingDate(string $date): ?string
    {
        if (strpos($date, "/")) {
            $parsedDate = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            $dateFormatted = $parsedDate;
            return $dateFormatted;
        } elseif(strpos($date, "-")) {
            $parsedDate = date("Y-m-d", strtotime($date));
            $dateFormatted = $parsedDate;
            return $dateFormatted;
        }
        return NULL;
    }
}

?>