<?php
use PHPUnit\Framework\TestCase;
use Ricci69\MmbakViewer\DbDriver;
use Ricci69\MmbakViewer\Wallet;

class WalletTest extends TestCase
{
    private $dbDriver;

    protected function setUp(): void
    {
        $this->dbDriver = new DbDriver('tests/test.mmbak');
    }

    public function testGetBalance()
    {
        $wallet = new Wallet($this->dbDriver);
        $result = $wallet->getBalance();
        $this->assertEquals(3598.75, $result['balance']);
        $this->assertEquals('1', $result['currency']);
    }

    public function testGetBalanceByPeriod()
    {
        $wallet = new Wallet($this->dbDriver);
        
        // Full year balance
        $result = $wallet->getBalanceByPeriod('2023-01-01', '2023-12-31');
        $this->assertEquals(3598.75, $result['balance']);
        $this->assertEquals('1', $result['currency']);
        
        // January only: 2000 - 150.50 = 1849.50
        $result = $wallet->getBalanceByPeriod('2023-01-01', '2023-01-31');
        $this->assertEquals(1849.50, $result['balance']);
        $this->assertEquals('1', $result['currency']);
        
        // February only: 2000 - 250.75 = 1749.25
        $result = $wallet->getBalanceByPeriod('2023-02-01', '2023-02-28');
        $this->assertEquals(1749.25, $result['balance']);
        $this->assertEquals('1', $result['currency']);
        
        // Empty period (no transactions)
        $result = $wallet->getBalanceByPeriod('2024-01-01', '2024-12-31');
        $this->assertEquals(0, $result['balance']);
        $this->assertNull($result['currency']);
    }

    public function testGetBalanceByCurrency()
    {
        $wallet = new Wallet($this->dbDriver);
        
        // All transactions are currency '1'
        $result = $wallet->getBalanceByCurrency('1');
        $this->assertEquals(3598.75, $result['balance']);
        $this->assertEquals('1', $result['currency']);
        
        // Non-existent currency
        $result = $wallet->getBalanceByCurrency('999');
        $this->assertEquals(0, $result['balance']);
        $this->assertEquals('999', $result['currency']);
    }
}