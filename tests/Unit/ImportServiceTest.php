<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ImportService;
use App\Repositories\ClientsRepository\ClientsRepositoryMock;
use App\Repositories\CreditCardsRepository\CreditCardsRepositoryMock;
use Exception;

class ImportServiceTest extends TestCase
{

    private ?ImportService $importService;

    function setUp(): void
    {
        $this->importService = new ImportService(new CreditCardsRepositoryMock(), new ClientsRepositoryMock());
    }

    function tearDown(): void
    {
        $this->importService = NULL;
    }

    public function testFileEmptyException()
    {
        try {
            $this->importService->execute([]);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), 'The file was empty');
        }
    }

    public function testExecutingAddingCorrectly()
    {
        $data = [
            [
                'name' => 'Pedro', 
                'address' => NULL, 
                'checked' => 1,
                'description' => NULL,
                'interest' => NULL,
                'email' => 'test@test.com',
                'account' => 'pedro',
                'date_of_birth' => '1989-03-21T01:11:13+00:00',
                'credit_card' => [
                    'name' => 'Pedro',
                    'type' => 'Visa',
                    'number' => '123456',
                    'expirationDate' => '12/19'
                ]
            ]
        ];
        $recordsAdded = $this->importService->execute($data);
        $this->assertTrue($recordsAdded === 1);
    }

    public function testExecutingNotAddingBecauseOfAge()
    {
        $data = [
            [
                'name' => 'Pedro', 
                'address' => NULL, 
                'checked' => 1,
                'description' => NULL,
                'interest' => NULL,
                'email' => 'test@test.com',
                'account' => 'pedro',
                'date_of_birth' => '2020-03-21T01:11:13+00:00',
                'credit_card' => [
                    'name' => 'Pedro',
                    'type' => 'Visa',
                    'number' => '123456',
                    'expirationDate' => '12/19'
                ]
            ]
        ];
        $recordsAdded = $this->importService->execute($data);
        $this->assertTrue($recordsAdded === 0);
    }

    public function testExecutingNotAddingBecauseOfMissingFields()
    {
        $data = [
            [
                'address' => NULL, 
                'checked' => 1,
                'description' => NULL,
                'interest' => NULL,
                'email' => 'test@test.com',
                'account' => 'pedro',
                'date_of_birth' => '1989-03-21T01:11:13+00:00',
                'credit_card' => [
                    'name' => 'Pedro',
                    'type' => 'Visa',
                    'number' => '123456',
                    'expirationDate' => '12/19'
                ]
            ]
        ];
        $recordsAdded = $this->importService->execute($data);
        $this->assertTrue($recordsAdded === 0);
    }

    public function testChallengeFileExists()
    {
        $this->assertFileExists('challenge.json');
    }
}
