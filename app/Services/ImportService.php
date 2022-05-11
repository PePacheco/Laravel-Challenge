<?php

namespace App\Services;

use App\Repositories\ClientsRepository\IClientsRepository;
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
            if (
                !array_key_exists('credit_card', $client) ||
                !array_key_exists('name', $client) ||
                !array_key_exists('checked', $client) ||
                !array_key_exists('account', $client) ||
                !array_key_exists('name', $client['credit_card']) ||
                !array_key_exists('type', $client['credit_card']) ||
                !array_key_exists('number', $client['credit_card']) ||
                !array_key_exists('expirationDate', $client['credit_card'])
            ) {
                continue;
            }

            $dateSubstring = substr($client['date_of_birth'], 0, 10);

            $formattedDateOfBirth = DateUtilities::formattingDate($dateSubstring);
            $isBetween18and65 = DateUtilities::isBetween18and65($formattedDateOfBirth);
            
            if ($isBetween18and65) {
                $newCreditCard = $this->creditCardRepository->create(
                    $client['credit_card']['name'], 
                    $client['credit_card']['type'],
                    $client['credit_card']['number'],
                    $client['credit_card']['expirationDate']
                );

                $this->clientsRepository->create(
                    $client['name'], 
                    $client['address'],
                    $client['checked'],
                    $client['description'], 
                    $client['interest'],
                    $client['email'], 
                    $client['account'],
                    $newCreditCard->id,
                    $formattedDateOfBirth
                );

                $recordsAdded++;
            }
            if ($recordsAdded % 500 === 0) {
                echo 'Added 500 records' . PHP_EOL;
            }
        }

        return $recordsAdded;
    }

}

?>