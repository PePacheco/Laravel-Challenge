<?php

namespace App\Factories;

use App\Models\CreditCard;

final class CreditCardFactory {
    public function Create(string $name, string $type, string $number, string $expirationDate): CreditCard 
    {
        $creditCard = new CreditCard();
        $dates = explode("/", $expirationDate);
        $creditCard->name = $name;
        $creditCard->type = $type;
        $creditCard->number = $number;
        $creditCard->expirationDateDay = $dates[0];
        $creditCard->expirationDateMonth = $dates[1];
        return $creditCard;
    }
}

?>