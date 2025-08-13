<?php
use PHPUnit\Framework\TestCase;
use Ricci69\MmbakViewer\DbDriver;
use Ricci69\MmbakViewer\Inoutcome;

class InoutcomeTest extends TestCase
{
    private $dbDriver;
    private $inoutcome;

    protected function setUp(): void
    {
        $this->dbDriver = new DbDriver('tests/test.mmbak');
        $this->inoutcome = new Inoutcome($this->dbDriver);
    }

    public function testGetIn()
    {
        $start = '2023-01-01';
        $end = '2023-01-31';
        $result = $this->inoutcome->getIn($start, $end);
        $this->assertCount(1, $result);
        $this->assertEquals(2000.00, $result[0]['AMOUNT_ACCOUNT']);
    }

    public function testGetOut()
    {
        $start = '2023-01-01';
        $end = '2023-01-31';
        $result = $this->inoutcome->getOut($start, $end);
        $this->assertCount(1, $result);
        $this->assertEquals(150.50, $result[0]['AMOUNT_ACCOUNT']);
    }

    public function testGetFull()
    {
        $start = '2023-01-01';
        $end = '2023-01-31';
        $result = $this->inoutcome->getFull($start, $end);
        $this->assertCount(2, $result);
    }

    public function testGetSumIn()
    {
        $start = '2023-01-01';
        $end = '2023-02-28';
        $result = $this->inoutcome->getSumIn($start, $end);
        $this->assertEquals(4000.00, $result['sum']);
        $this->assertEquals('1', $result['currency']);
    }

    public function testGetSumOut()
    {
        $start = '2023-01-01';
        $end = '2023-02-28';
        $result = $this->inoutcome->getSumOut($start, $end);
        $this->assertEquals(401.25, $result['sum']);
        $this->assertEquals('1', $result['currency']);
    }
}
