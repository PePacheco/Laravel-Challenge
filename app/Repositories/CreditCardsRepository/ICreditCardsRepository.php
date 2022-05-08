<?php

namespace App\Repositories\CreditCardsRepository;

use App\Models\CreditCard;

interface ICreditCardsRepository {
    function create(string $name, string $type, string $number, string $expirationDate): CreditCard;
}

?>