<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Console\Commands\ImportManager;
use App\Models\Client;
use App\Models\CreditCard;

class ImportManagerTest extends TestCase
{

    private ?ImportManager $importManager;

    function setUp(): void
    {
        $this->importManager = new ImportManager();
    }

    function tearDown(): void
    {
        $this->importManager = NULL;
    }

    public function testIsBetween18and65Correct() 
    {
        $date = '2000-01-01';
        $this->assertEquals(true, $this->importManager->isBetween18and65($date));
    }

    public function testIsBetween18and65LessThen18() 
    {
        $date = '2020-01-01';
        $this->assertEquals(false, $this->importManager->isBetween18and65($date));
    }

    public function testIsBetween18and65MoreThen65() 
    {
        $date = '1950-01-01';
        $this->assertEquals(false, $this->importManager->isBetween18and65($date));
    }

    public function testClientFactory()
    {
        $client = new Client();
        $client->name = 'Pedro';
        $client->address = 'Random Street';
        $client->checked = true;
        $client->description = NULL;
        $client->interest = NULL;
        $client->email = 'example@email.com';
        $client->account = 'Pedro Pacheco';

        $factoryClient = $this->importManager->clientFactory(
            'Pedro', 
            'Random Street',
            true,
            NULL, 
            NULL,
            'example@email.com', 
            'Pedro Pacheco'
        );

        $this->assertEquals($client, $factoryClient);
    }

    public function testCreditCardFactory()
    {
        $creditCard = new CreditCard();
        $creditCard->name = 'Pedro';
        $creditCard->type = 'Visa';
        $creditCard->number = '1234';
        $creditCard->expirationDateDay = '12';
        $creditCard->expirationDateMonth = '01';


        $factoryCreditCard = $this->importManager->creditCardFactory(
            'Pedro', 
            'Visa',
            '1234',
            '12/01'
        );

        $this->assertEquals($creditCard, $factoryCreditCard);
    }

    public function testCreditCardFactoryWithErrors()
    {
        $this->expectError(TypeError::class);

        $factoryCreditCard = $this->importManager->creditCardFactory(
            NULL, 
            'Visa',
            '1234',
            '12/01'
        );

    }

    public function testClientFactoryWithErrors()
    {
        $this->expectError(TypeError::class);

        $factoryClient = $this->importManager->clientFactory(
            NULL, 
            'Random Street',
            true,
            NULL, 
            NULL,
            'example@email.com', 
            'Pedro Pacheco'
        );
    }
}
