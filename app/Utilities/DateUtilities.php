<?php

namespace App\Utilities;

class DateUtilities {

    public static function isBetween18and65(string $date): bool
    {
        $now = date("Y-m-d");
        $date18years = date('Y-m-d', strtotime('-18 years', strtotime($now)));
        $date65years = date('Y-m-d', strtotime('-65 years', strtotime($now)));
        if (strtotime($date65years) < strtotime($date) && strtotime($date) < strtotime($date18years)) {
            return true;
        } else {
            return false;
        }
    }
}

?>