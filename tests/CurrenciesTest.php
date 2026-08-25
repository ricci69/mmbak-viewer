<?php
use PHPUnit\Framework\TestCase;
use Ricci69\MmbakViewer\DbDriver;
use Ricci69\MmbakViewer\Currencies;

class CurrenciesTest extends TestCase
{
    private $dbDriver;

    protected function setUp(): void
    {
        $this->dbDriver = new DbDriver('tests/test.mmbak');
    }

    public function testGet()
    {
        $currencies = new Currencies($this->dbDriver);
        $this->assertEquals(
            ['1' => 'USD', '2' => 'EUR'],
            $currencies->get()
        );
    }

    public function testGetAll()
    {
        $currencies = new Currencies($this->dbDriver);
        $result = $currencies->getAll();
        $this->assertCount(2, $result);
        $this->assertEquals('1', $result[0]['uid']);
        $this->assertEquals('USD', $result[0]['symbol']);
        $this->assertEquals('2', $result[1]['uid']);
        $this->assertEquals('EUR', $result[1]['symbol']);
    }

    public function testGetById()
    {
        $currencies = new Currencies($this->dbDriver);
        
        $result = $currencies->getById('1');
        $this->assertNotNull($result);
        $this->assertEquals('1', $result['uid']);
        $this->assertEquals('USD', $result['symbol']);
        
        $result = $currencies->getById('999');
        $this->assertNull($result);
    }
}