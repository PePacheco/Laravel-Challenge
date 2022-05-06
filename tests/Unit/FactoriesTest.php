<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Client;
use App\Models\CreditCard;
use App\Factories\ClientFactory;
use App\Factories\CreditCardFactory;

class FactoriesTest extends TestCase
{
    private ?ClientFactory $clientFactory;
    private ?CreditCardFactory $creditCardFactory;

    function setUp(): void
    {
        $this->clientFactory = new ClientFactory();
        $this->creditCardFactory = new CreditCardFactory();
    }

    function tearDown(): void
    {
        $this->clientFactory = NULL;
        $this->creditCardFactory = NULL;
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

        $factoryClient = $this->clientFactory->create(
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

        $factoryCreditCard =  $this->creditCardFactory->create(
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

        $factoryCreditCard = $this->creditCardFactory->create(
            NULL, 
            'Visa',
            '1234',
            '12/01'
        );

    }

    public function testClientFactoryWithErrors()
    {
        $this->expectError(TypeError::class);

        $factoryClient = $this->clientFactory->create(
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
