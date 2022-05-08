<?php

namespace App\Services;

use App\Repositories\ClientsRepository\IClientsRepository;
use Carbon\Carbon;
use App\Repositories\CreditCardsRepository\ICreditCardsRepository;
use Exception;
class ImportService {

    private ICreditCardsRepository $creditCardRepository;
    private IClientsRepository $clientsRepository;

    function __construct(ICreditCardsRepository $creditCardRepository, IClientsRepository $clientsRepository)
    {
        $this->creditCardRepository = $creditCardRepository;
        $this->clientsRepository = $clientsRepository;
    }

    public function execute(array $data) {
        
        if (empty($data)) {
            throw new Exception('The file was empty');
        }

        $counter = 0;
        foreach($data as $client) {
            $dateOfBirth = NULL;
            $dateSubstring = substr($client->date_of_birth, 0, 10);
            $isBetween18and65 = true;

            if (strpos($dateSubstring, "/")) {
                $parsedDate = Carbon::createFromFormat('d/m/Y', $dateSubstring)->format('Y-m-d');
                $dateOfBirth = $parsedDate;
                $isBetween18and65 = $this->isBetween18and65($parsedDate);
            } elseif(strpos($dateSubstring, "-")) {
                $parsedDate = date("Y-m-d", strtotime($dateSubstring));
                $dateOfBirth = $parsedDate;
                $isBetween18and65 = $this->isBetween18and65($parsedDate);
            }
            if ($isBetween18and65) {
                $newCreditCard = $this->creditCardRepository->create(
                    $client->credit_card->name, 
                    $client->credit_card->type,
                    $client->credit_card->number,
                    $client->credit_card->expirationDate
                );

                $this->clientsRepository->create(
                    $client->name, 
                    $client->address,
                    $client->checked,
                    $client->description, 
                    $client->interest,
                    $client->email, 
                    $client->account,
                    $newCreditCard->id,
                    $dateOfBirth
                );
            }
            $counter++;
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