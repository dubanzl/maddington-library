<?php
namespace Core\CLI\Handlers;

use Core\CLI\ConsoleUI;
use Core\Controllers\BookController;

class BookMenuHandler
{
    public static function add(): void
    {
        ConsoleUI::title(title: "Add New Book");

        $name = ConsoleUI::ask(question: "Book name");
        $isbn = ConsoleUI::ask(question: "ISBN");
        $publisher = ConsoleUI::ask(question: "Publisher");
        $year = ConsoleUI::ask(question: "Publication Year");
        $author = ConsoleUI::ask(question: "Author Name");

        BookController::addBook(
            name: $name,
            isbn: $isbn,
            publisher: $publisher,
            year: $year,
            authorName: $author
        );

        ConsoleUI::success(message: "Book added successfully!");
        ConsoleUI::info(text: "Press Enter to continue...");
        fgets(stream: STDIN);
    }

    public static function list(): void
    {
        ConsoleUI::title(title: "All Books");
        $books = BookController::listBooks();

        if (empty($books)) {
            ConsoleUI::warning(text: "No books available.");
        } else {
            $rows = array_map(
                fn($b): array => [
                    $b['resourceId'],
                    $b['name'],
                    $b['author']['authorName'],
                    $b['year']
                ],
                $books
            );
            ConsoleUI::table(headers: ['ID', 'Book', 'Author', 'Year'], rows: $rows);
        }

        ConsoleUI::info(text: "Press Enter to go back...");
        fgets(stream: STDIN);
    }

    public static function edit(): void
    {
        ConsoleUI::title(title: "Edit Book");
        $books = BookController::listBooks();

        if (empty($books)) {
            ConsoleUI::warning(text: "No books available to edit.");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        self::displayBooksTable(books: $books);

        $id = ConsoleUI::ask(question: "Enter Book ID to edit");
        $book = BookController::getBook(id: $id);

        if (!$book) {
            ConsoleUI::warning(text: "Book not found!");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        $name = ConsoleUI::ask(question: "Book name", default: $book['name']);
        $isbn = ConsoleUI::ask(question: "ISBN", default: $book['isbn']);
        $publisher = ConsoleUI::ask(question: "Publisher", default: $book['publisher']);
        $year = ConsoleUI::ask(question: "Publication Year", default: $book['year']);
        $author = ConsoleUI::ask(question: "Author Name", default: $book['author']['authorName']);

        $success = BookController::editBook(
            id: $id,
            name: $name,
            isbn: $isbn,
            publisher: $publisher,
            year: $year,
            authorName: $author
        );

        if ($success) {
            ConsoleUI::success(message: "Book updated successfully!");
        } else {
            ConsoleUI::warning(text: "Failed to update book!");
        }

        ConsoleUI::info(text: "Press Enter to continue...");
        fgets(stream: STDIN);
    }

    public static function delete(): void
    {
        ConsoleUI::title(title: "Delete Book");
        $books = BookController::listBooks();

        if (empty($books)) {
            ConsoleUI::warning(text: "No books available to delete.");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        self::displayBooksTable(books: $books);

        $id = ConsoleUI::ask(question: "Enter Book ID to delete");
        $book = BookController::getBook(id: $id);

        if (!$book) {
            ConsoleUI::warning(text: "Book not found!");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        $confirm = ConsoleUI::ask(
            question: "Are you sure you want to delete '{$book['name']}'? (yes/no)",
            default: "no"
        );

        if (strtolower($confirm) === 'yes') {
            $success = BookController::deleteBook(id: $id);

            if ($success) {
                ConsoleUI::success(message: "Book deleted successfully!");
            } else {
                ConsoleUI::warning(text: "Failed to delete book!");
            }
        } else {
            ConsoleUI::info(text: "Delete cancelled.");
        }

        ConsoleUI::info(text: "Press Enter to continue...");
        fgets(stream: STDIN);
    }

    private static function displayBooksTable(array $books): void
    {
        $rows = array_map(
            fn($b): array => [
                $b['resourceId'],
                $b['name'],
                $b['author']['authorName'],
                $b['year']
            ],
            $books
        );
        ConsoleUI::table(headers: ['ID', 'Book', 'Author', 'Year'], rows: $rows);
    }
}

