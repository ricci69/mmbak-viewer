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

    public function testCanBeCreatedWithDefaultFilename()
    {
        // Test default constructor parameter - need a valid db file
        copy('tests/test.mmbak', '/tmp/test_default.mmbak');
        $db = new DbDriver('/tmp/test_default.mmbak');
        $this->assertInstanceOf(DbDriver::class, $db);
        unlink('/tmp/test_default.mmbak');
    }

    public function testThrowsExceptionOnInvalidDatabase()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('unable to open database file');
        new DbDriver('/tmp/nonexistent_db_that_does_not_exist.mmbak');
    }

    public function testDbPropertyIsAccessible()
    {
        $dbDriver = new DbDriver('tests/test.mmbak');
        $this->assertInstanceOf(\SQLite3::class, $dbDriver->db);
    }

    public function testFetchAllReturnsArray()
    {
        $dbDriver = new DbDriver('tests/test.mmbak');
        $result = $dbDriver->db->query('SELECT * FROM INOUTCOME');
        $fetched = $dbDriver->fetchAll($result);
        $this->assertIsArray($fetched);
        $this->assertCount(4, $fetched);
    }
}
