<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ImportService;
use App\Repositories\CreditCardsRepository\CreditCardsRepository;
use App\Repositories\ClientsRepository\ClientsRepository;
use Exception;

class ImportManagerTest extends TestCase
{

    private ?ImportService $importService;

    function setUp(): void
    {
        $this->importService = new ImportService(new CreditCardsRepository(), new ClientsRepository());
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
}
