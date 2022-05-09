<?php

namespace App\Services;

use App\Repositories\ClientsRepository\IClientsRepository;
use Carbon\Carbon;
use App\Repositories\CreditCardsRepository\ICreditCardsRepository;
use App\Utilities\DateUtilities;
use Exception;
class ImportService {

    private ICreditCardsRepository $creditCardRepository;
    private IClientsRepository $clientsRepository;

    function __construct(ICreditCardsRepository $creditCardRepository, IClientsRepository $clientsRepository)
    {
        $this->creditCardRepository = $creditCardRepository;
        $this->clientsRepository = $clientsRepository;
    }

    public function execute(array $data): int {
        
        if (empty($data)) {
            throw new Exception('The file was empty');
        }

        $recordsAdded = 0;
        foreach($data as $client) {
            $dateOfBirth = NULL;
            $dateSubstring = substr($client->date_of_birth, 0, 10);
            $isBetween18and65 = true;

            if (strpos($dateSubstring, "/")) {
                $parsedDate = Carbon::createFromFormat('d/m/Y', $dateSubstring)->format('Y-m-d');
                $dateOfBirth = $parsedDate;
                $isBetween18and65 = DateUtilities::isBetween18and65($parsedDate);
            } elseif(strpos($dateSubstring, "-")) {
                $parsedDate = date("Y-m-d", strtotime($dateSubstring));
                $dateOfBirth = $parsedDate;
                $isBetween18and65 = DateUtilities::isBetween18and65($parsedDate);
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

                $recordsAdded++;
            }
            if ($recordsAdded % 500 === 0) {
                echo 'Added 500 records' . PHP_EOL;
            }
        }
        echo 'JSON processed smoothly and '. $recordsAdded .' records added to the database.';

        return $recordsAdded;
    }

}

?>