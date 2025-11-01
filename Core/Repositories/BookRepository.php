<?php
namespace Core\Repositories;

use Core\Models\Book;

class BookRepository {
    private static $file = __DIR__ . '/../data/books.json';

    public static function findAll(): mixed {
        return DataStore::read(path: self::$file);
    }

    public static function add($book): void {
        $books = self::findAll();
        $books[] = $book;
        DataStore::write(path: self::$file, data: $books);
    }

    public static function findById($id): mixed {
        $books = self::findAll();
        foreach ($books as $book) {
            if ($book['resourceId'] == $id) {
                return $book;
            }
        }
        return null;
    }

    public static function update($id, $updatedBook): bool {
        $books = self::findAll();
        foreach ($books as $index => $book) {
            if ($book['resourceId'] == $id) {
                $books[$index] = $updatedBook;
                DataStore::write(path: self::$file, data: $books);
                return true;
            }
        }
        return false;
    }

    public static function delete($id): bool {
        $books = self::findAll();
        foreach ($books as $index => $book) {
            if ($book['resourceId'] == $id) {
                unset($books[$index]);
                DataStore::write(path: self::$file, data: array_values($books));
                return true;
            }
        }
        return false;
    }
}
