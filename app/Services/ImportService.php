<?php

namespace App\Services;

use Carbon\Carbon;
use App\Factories\ClientFactory;
use App\Factories\CreditCardFactory;
use App\Exceptions\FileEmptyException;
class ImportService {

    public function execute(array $data) {
        $counter = 0;
        foreach($data as $client) {
            $counter++;

            $creditCardFactory = new CreditCardFactory();
            $newCreditCard = $creditCardFactory->create(
                $client->credit_card->name, 
                $client->credit_card->type,
                $client->credit_card->number,
                $client->credit_card->expirationDate
            );

            $clientFactory = new ClientFactory();
            $newClient = $clientFactory->create(
                $client->name, 
                $client->address,
                $client->checked,
                $client->description, 
                $client->interest,
                $client->email, 
                $client->account
            );

            $dateSubstring = substr($client->date_of_birth, 0, 10);
            $isBetween18and65 = true;
            if (strpos($dateSubstring, "/")) {
                $parsedDate = Carbon::createFromFormat('d/m/Y', $dateSubstring)->format('Y-m-d');
                $newClient->dateOfBirth = $parsedDate;
                $isBetween18and65 = $this->isBetween18and65($parsedDate);
            } elseif(strpos($dateSubstring, "-")) {
                $parsedDate = date("Y-m-d", strtotime($dateSubstring));
                $newClient->dateOfBirth = $parsedDate;
                $isBetween18and65 = $this->isBetween18and65($parsedDate);
            }
            if ($isBetween18and65) {
                $newCreditCard->save();
                $newClient->credit_card_id = $newCreditCard->id;
                $newClient->save();
            }
            if ($counter === 500) {
                $counter = 0;
                echo 'Added 500 records' . PHP_EOL;
            }
        }
        echo 'JSON processed smoothly and data added to the database.';
    }

    public function isBetween18and65(string $date): bool
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