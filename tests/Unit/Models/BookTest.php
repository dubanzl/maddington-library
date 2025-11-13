<?php
namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use Core\Models\Book;
use Core\Models\Author;

class BookTest extends TestCase
{
    public function testBookCanBeCreated(): void
    {
        $author = new Author(
            authorId: '1',
            authorName: 'John Doe',
            nationality: 'US',
            biography: 'Test author'
        );

        $book = new Book(
            id: 1,
            addedDate: '2025-11-01',
            name: 'Test Book',
            isbn: '978-1234567890',
            publisher: 'Test Publisher',
            year: '2025',
            author: $author
        );

        $this->assertEquals(1, $book->resourceId);
        $this->assertEquals('Test Book', $book->name);
        $this->assertEquals('978-1234567890', $book->isbn);
        $this->assertEquals('Test Publisher', $book->publisher);
        $this->assertEquals('2025', $book->year);
        $this->assertEquals('John Doe', $book->author->authorName);
    }

    public function testBookHasAvailability(): void
    {
        $author = new Author(
            authorId: '1',
            authorName: 'Jane Smith',
            nationality: 'UK',
            biography: ''
        );

        $book = new Book(
            id: 1,
            addedDate: '2025-11-01',
            name: 'Available Book',
            isbn: '978-0987654321',
            publisher: 'Publisher',
            year: '2025',
            author: $author
        );

        $this->assertTrue($book->availability);
    }

    public function testBookAvailabilityCanBeChanged(): void
    {
        $author = new Author(
            authorId: '1',
            authorName: 'Test Author',
            nationality: 'AU',
            biography: ''
        );

        $book = new Book(
            id: 1,
            addedDate: '2025-11-01',
            name: 'Test Book',
            isbn: '978-1111111111',
            publisher: 'Publisher',
            year: '2025',
            author: $author
        );

        // Test availability is initially true
        $this->assertTrue($book->availability);
        
        // Manually change availability (as done in the system)
        $book->availability = false;
        $this->assertFalse($book->availability);
        
        // Change it back
        $book->availability = true;
        $this->assertTrue($book->availability);
    }
}

