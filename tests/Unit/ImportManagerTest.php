<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ImportService;
use App\Models\Client;
use App\Models\CreditCard;
use App\Factories\ClientFactory;
use App\Factories\CreditCardFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ImportManagerTest extends TestCase
{

    private ?ImportService $importService;

    function setUp(): void
    {
        $this->importService = new ImportService();
    }

    function tearDown(): void
    {
        $this->importService = NULL;
    }

    public function testIsBetween18and65Correct() 
    {
        $date = '2000-01-01';
        $this->assertEquals(true, $this->importService->isBetween18and65($date));
    }

    public function testIsBetween18and65LessThan18() 
    {
        $date = '2020-01-01';
        $this->assertEquals(false, $this->importService->isBetween18and65($date));
    }

    public function testIsBetween18and65MoreThan65() 
    {
        $date = '1950-01-01';
        $this->assertEquals(false, $this->importService->isBetween18and65($date));
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

        $clientFactory = new ClientFactory();

        $factoryClient = $clientFactory->create(
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

        $creditCardFactory = new CreditCardFactory();

        $factoryCreditCard = $creditCardFactory->create(
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

        $creditCardFactory = new CreditCardFactory();

        $factoryCreditCard = $creditCardFactory->create(
            NULL, 
            'Visa',
            '1234',
            '12/01'
        );

    }

    public function testClientFactoryWithErrors()
    {
        $this->expectError(TypeError::class);

        $clientFactory = new ClientFactory();

        $factoryClient = $clientFactory->create(
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
