<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\TestCase;
use Core\Repositories\DataStore;

class DataStoreTest extends TestCase
{
    private string $testFile;

    protected function setUp(): void
    {
        $this->testFile = sys_get_temp_dir() . '/test_data_' . uniqid() . '.json';
    }

    protected function tearDown(): void
    {
        if (file_exists(filename: $this->testFile)) {
            unlink(filename: $this->testFile);
        }
    }

    public function testReadReturnsEmptyArrayForNonExistentFile(): void
    {
        $result = DataStore::read(path: $this->testFile);
        $this->assertEquals(expected: [], actual: $result);
    }

    public function testWriteCreatesJsonFile(): void
    {
        $data = ['test' => 'value'];
        DataStore::write(path: $this->testFile, data: $data);

        $this->assertFileExists(filename: $this->testFile);
    }

    public function testWriteAndReadData(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Test Item 1'],
            ['id' => 2, 'name' => 'Test Item 2']
        ];

        DataStore::write(path: $this->testFile, data: $data);
        $result = DataStore::read(path: $this->testFile);

        $this->assertEquals(expected: $data, actual: $result);
    }

    public function testReadParsesJsonCorrectly(): void
    {
        $data = [
            'books' => [
                ['title' => 'Book 1'],
                ['title' => 'Book 2']
            ]
        ];

        file_put_contents(filename: $this->testFile, data: json_encode(value: $data));
        $result = DataStore::read(path: $this->testFile);

        $this->assertIsArray(actual: $result);
        $this->assertArrayHasKey(key: 'books', array: $result);
        $this->assertCount(expectedCount: 2, haystack: $result['books']);
    }

    public function testWriteFormatsJsonPretty(): void
    {
        $data = ['test' => 'value', 'number' => 123];
        DataStore::write(path: $this->testFile, data: $data);

        $content = file_get_contents(filename: $this->testFile);
        
        $this->assertStringContainsString(needle: "\n", haystack: $content);
    }
}

