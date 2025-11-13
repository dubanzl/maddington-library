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

        $this->assertEquals(expected: 1, actual: $book->resourceId);
        $this->assertEquals(expected: 'Test Book', actual: $book->name);
        $this->assertEquals(expected: '978-1234567890', actual: $book->isbn);
        $this->assertEquals(expected: 'Test Publisher', actual: $book->publisher);
        $this->assertEquals(expected: '2025', actual: $book->year);
        $this->assertEquals(expected: 'John Doe', actual: $book->author->authorName);
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

        $this->assertTrue(condition: $book->availability);
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

        $this->assertTrue(condition: $book->availability);
        
        $book->availability = false;
        $this->assertFalse(condition: $book->availability);
        
        $book->availability = true;
        $this->assertTrue(condition: $book->availability);
    }
}

