<?php

namespace App\Repositories\CreditCardsRepository;

use App\Models\CreditCard;

class CreditCardsRepositoryMock implements ICreditCardsRepository {
    function create(string $name, string $type, string $number, string $expirationDate): CreditCard {
        $creditCard = new CreditCard();
        $dates = explode("/", $expirationDate);
        $creditCard->name = $name;
        $creditCard->type = $type;
        $creditCard->number = $number;
        $creditCard->expirationDateDay = $dates[0];
        $creditCard->expirationDateMonth = $dates[1];
        $creditCard->id = 1;
        return $creditCard;
    }
}

?>