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
}
