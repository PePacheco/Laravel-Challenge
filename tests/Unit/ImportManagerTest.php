<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ImportService;
use App\Repositories\ClientsRepository\ClientsRepositoryMock;
use App\Repositories\CreditCardsRepository\CreditCardsRepositoryMock;
use Exception;

class ImportManagerTest extends TestCase
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

    public function testExecutingCorrectly()
    {
        $data = json_decode(file_get_contents('challenge.json'), false);
        $recordsAdded = $this->importService->execute($data);
        $this->assertTrue($recordsAdded > 0);
    }

    public function testChallengeFileExists()
    {
        $this->assertFileExists('challenge.json');
    }
}
