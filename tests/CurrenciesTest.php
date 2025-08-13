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
}
