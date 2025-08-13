<?php
use PHPUnit\Framework\TestCase;
use Ricci69\MmbakViewer\DbDriver;
use Ricci69\MmbakViewer\Categories;

class CategoriesTest extends TestCase
{
    private $dbDriver;

    protected function setUp(): void
    {
        $this->dbDriver = new DbDriver('tests/test.mmbak');
    }

    public function testGet()
    {
        $categories = new Categories($this->dbDriver);
        $result = $categories->get();
        $this->assertCount(2, $result);
        $this->assertEquals('Salary', $result[0]['NAME']);
        $this->assertEquals('Groceries', $result[1]['NAME']);
    }
}
