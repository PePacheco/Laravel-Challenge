<?php

namespace App\Factories;

use App\Models\Client;

final class ClientFactory {
    public function create(string $name, ?string $address, string $checked, ?string $description, ?string $interest, ?string $email, string $account): Client 
    {
        $client = new Client();
        $client->name = $name;
        $client->address = $address;
        $client->checked = $checked;
        $client->description = $description;
        $client->interest = $interest;
        $client->email = $email;
        $client->account = $account;
        return $client;
    }
}

?>