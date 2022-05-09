<?php

namespace App\Repositories\ClientsRepository;

use App\Models\Client;

class ClientsRepositoryMock implements IClientsRepository {
    function create(string $name, ?string $address, string $checked, ?string $description, ?string $interest, ?string $email, string $account, int $creditCardId, ?string $dateOfBirth): Client {
        $client = new Client();
        $client->name = $name;
        $client->address = $address;
        $client->checked = $checked;
        $client->description = $description;
        $client->interest = $interest;
        $client->email = $email;
        $client->account = $account;
        $client->credit_card_id = $creditCardId;
        $client->dateOfBirth = $dateOfBirth;
        return $client;
    }
}

?>