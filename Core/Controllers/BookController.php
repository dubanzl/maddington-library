<?php
namespace Core\Controllers;

use Core\Models\Author;
use Core\Models\Book;
use Core\Repositories\BookRepository;

class BookController {
    public static function addBook($name, $isbn, $publisher, $year, $authorName): void {
        $books = BookRepository::findAll();
        $author = new Author(authorId: uniqid(), authorName: $authorName, nationality: "Unknown", biography: "");
        $book = new Book(
            id: count(value: $books) + 1,
            addedDate: date(format: 'Y-m-d'),
            name: $name,
            isbn: $isbn,
            publisher: $publisher,
            year: $year,
            author: $author
        );
        BookRepository::add(book: $book);
        echo "Book '{$book->name}' added successfully.\n";
    }

    public static function listBooks(): mixed {
        $books = BookRepository::findAll();
        if (empty($books)) {
            echo "No books found.\n";
            return [];
        }
        return $books;
    }

    public static function getBook($id): mixed {
        return BookRepository::findById(id: $id);
    }

    public static function editBook($id, $name, $isbn, $publisher, $year, $authorName): bool {
        $book = self::getBook(id: $id);
        if (!$book) {
            return false;
        }

        $author = new Author(
            authorId: $book['author']['authorId'],
            authorName: $authorName,
            nationality: $book['author']['nationality'] ?? "Unknown",
            biography: $book['author']['biography'] ?? ""
        );

        $updatedBook = new Book(
            id: $id,
            addedDate: $book['addedDate'],
            name: $name,
            isbn: $isbn,
            publisher: $publisher,
            year: $year,
            author: $author
        );

        return BookRepository::update(id: $id, updatedBook: $updatedBook);
    }

    public static function deleteBook($id): bool {
        return BookRepository::delete(id: $id);
    }
}
