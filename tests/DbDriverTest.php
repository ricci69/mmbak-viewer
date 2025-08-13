<?php
use PHPUnit\Framework\TestCase;
use Ricci69\MmbakViewer\DbDriver;

class DbDriverTest extends TestCase
{
    public function testCanBeCreatedFromValidDatabase()
    {
        $this->assertInstanceOf(
            DbDriver::class,
            new DbDriver('tests/test.mmbak')
        );
    }
}
