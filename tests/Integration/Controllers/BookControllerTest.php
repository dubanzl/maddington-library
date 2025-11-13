<?php
namespace Tests\Integration\Controllers;

use PHPUnit\Framework\TestCase;
use Core\Controllers\BookController;
use Core\Repositories\BookRepository;

class BookControllerTest extends TestCase
{
    private string $testFile;
    private $originalFile;

    protected function setUp(): void
    {
        $reflection = new \ReflectionClass(BookRepository::class);
        $property = $reflection->getProperty('file');
        $property->setAccessible(true);
        $this->originalFile = $property->getValue();
        
        $this->testFile = sys_get_temp_dir() . '/test_books_' . uniqid() . '.json';
        $property->setValue(null, $this->testFile);
        
        file_put_contents($this->testFile, '[]');
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testFile)) {
            unlink($this->testFile);
        }
        
        $reflection = new \ReflectionClass(BookRepository::class);
        $property = $reflection->getProperty('file');
        $property->setAccessible(true);
        $property->setValue(null, $this->originalFile);
    }

    public function testAddBookCreatesNewBook(): void
    {
        ob_start();
        BookController::addBook(
            name: 'Test Book',
            isbn: '978-1234567890',
            publisher: 'Test Publisher',
            year: '2025',
            authorName: 'Test Author'
        );
        
        $books = BookController::listBooks();
        ob_end_clean();
        
        $this->assertCount(expectedCount: 1, haystack: $books);
        $this->assertEquals(expected: 'Test Book', actual: $books[0]['name']);
        $this->assertEquals(expected: '978-1234567890', actual: $books[0]['isbn']);
    }

    public function testListBooksReturnsAllBooks(): void
    {
        ob_start();
        BookController::addBook(
            name: 'Book 1',
            isbn: '111',
            publisher: 'Pub 1',
            year: '2024',
            authorName: 'Author 1'
        );
        BookController::addBook(
            name: 'Book 2',
            isbn: '222',
            publisher: 'Pub 2',
            year: '2025',
            authorName: 'Author 2'
        );

        $books = BookController::listBooks();
        ob_end_clean();

        $this->assertCount(expectedCount: 2, haystack: $books);
        $this->assertEquals(expected: 'Book 1', actual: $books[0]['name']);
        $this->assertEquals(expected: 'Book 2', actual: $books[1]['name']);
    }

    public function testGetBookReturnsCorrectBook(): void
    {
        ob_start();
        BookController::addBook(
            name: 'Findable Book',
            isbn: '999',
            publisher: 'Publisher',
            year: '2025',
            authorName: 'Author'
        );

        $book = BookController::getBook(id: 1);
        ob_end_clean();

        $this->assertNotNull(actual: $book);
        $this->assertEquals(expected: 'Findable Book', actual: $book['name']);
        $this->assertEquals(expected: '999', actual: $book['isbn']);
    }

    public function testDeleteBookRemovesBook(): void
    {
        ob_start();
        BookController::addBook(
            name: 'Delete Me',
            isbn: '777',
            publisher: 'Publisher',
            year: '2025',
            authorName: 'Author'
        );

        $result = BookController::deleteBook(id: 1);
        $this->assertTrue(condition: $result);

        $books = BookController::listBooks();
        ob_end_clean();
        
        $this->assertEmpty(actual: $books);
    }
}

