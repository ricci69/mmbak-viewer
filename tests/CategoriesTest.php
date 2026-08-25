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

    public function testGetAll()
    {
        $categories = new Categories($this->dbDriver);
        $result = $categories->getAll();
        $this->assertCount(3, $result); // Includes disabled category
        
        $names = array_column($result, 'NAME');
        $this->assertContains('Salary', $names);
        $this->assertContains('Groceries', $names);
        $this->assertContains('Disabled Category', $names);
    }

    public function testGetById()
    {
        $categories = new Categories($this->dbDriver);
        
        $result = $categories->getById('cat1');
        $this->assertNotNull($result);
        $this->assertEquals('Salary', $result['NAME']);
        $this->assertEquals('cat1', $result['uid']);
        
        $result = $categories->getById('nonexistent');
        $this->assertNull($result);
    }

    public function testGetByType()
    {
        $categories = new Categories($this->dbDriver);
        
        // Active only (default)
        $result = $categories->getByType(1, true);
        $this->assertCount(2, $result);
        
        // Include inactive
        $result = $categories->getByType(1, false);
        $this->assertCount(3, $result);
        
        // Non-existent type
        $result = $categories->getByType(999, false);
        $this->assertCount(0, $result);
    }
}