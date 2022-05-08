<?php

namespace App\Repositories\ClientsRepository;

use App\Models\Client;

interface IClientsRepository {
    function create(string $name, ?string $address, string $checked, ?string $description, ?string $interest, ?string $email, string $account, int $creditCardId, ?string $dateOfBirth): Client;
}

?>